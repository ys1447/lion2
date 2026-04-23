<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ReworkLog;
use Illuminate\Support\Facades\Gate;
use App\Traits\HasNotification;
use Livewire\WithPagination;

new class extends Component {
    use HasNotification, WithPagination;

    public $search = '',
        $filterStatus = '';

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    #[On('rework-added')]
    public function render()
    {
        return $this->view([
            'reworkLogs' => ReworkLog::query()
                // 1. Eager Loading dengan memilih kolom spesifik (Mengurangi penggunaan Memori)
                ->with([
                    'inputData' => function ($q) {
                        $q->select('id', 'batch', 'variant_id'); // Pilih kolom penting saja
                    },
                    'inputData.variant:id,name', // Hanya ambil ID dan Nama varian
                    'details' => function ($query) {
                        // 2. Jika history sangat banyak, pertimbangkan limit atau ambil kolom esensial
                        $query->select('id', 'rework_log_id', 'target_batch_number', 'quantity_used', 'notes', 'created_at')->latest();
                    },
                ])
                ->search($this->search)
                ->withStatus($this->filterStatus)
                ->latest()
                // 3. Gunakan simplePaginate jika tidak butuh nomor halaman spesifik (lebih cepat)
                // atau tetap paginate tapi pastikan query di atas sudah efisien.
                ->paginate(10),
        ]);
    }

    // Fungsi delete tetap sama...
    public function confirm_delete($id)
    {
        $this->dispatch('confirm-delete', id: $id, type: 'list-rework');
    }

    #[On('delete-list-rework')]
    public function deleteRework($id)
    {
        if (Gate::denies('admin-only')) {
            $this->dispatch('alert-error', message: 'Anda tidak memiliki akses untuk menghapus!');
            return;
        }

        // Gunakan eager load saat find untuk mempercepat log notification
        $log = ReworkLog::with('inputData')->findOrFail($id);
        $dataIdentity = $log->inputData->batch ?? 'Data ID: ' . $log->input_data_id;

        if ($log->inputData) {
            $log->inputData->update(['status' => 'releaseHold']);
        }

        $log->delete();
        $this->sendNotification(action: 'DELETE', target: 'Rework Log: ' . $dataIdentity, details: "Cancelled remix for '{$dataIdentity}'");
        $this->dispatch('alert-success', message: 'Rework dibatalkan.');
    }

    // Tambahkan properti di dalam class
    public $editingId = null;
    public $newInitialQty = 0;

    // Fungsi untuk membuka modal/form edit
    public function editQty($id, $currentQty)
    {
        $this->editingId = $id;
        $this->newInitialQty = $currentQty;
        // Dispatch ke browser jika kamu pakai modal JS (Alpine/Bootstrap/Tailwind)
        $this->dispatch('open-edit-modal');
    }

    public function updateInitialQty()
    {
        // 1. Cari data dengan eager loading 'inputData' untuk mengambil nomor batch
        $log = ReworkLog::with('inputData')->findOrFail($this->editingId);

        // 2. Definisikan identitas data (Batch Number)
        $dataIdentity = $log->inputData->batch ?? 'ID: ' . $log->id;

        // Hitung berapa qty yang sudah terpakai
        $usedQty = $log->initial_quantity - $log->current_quantity;

        // Validasi
        if ($this->newInitialQty < $usedQty) {
            $this->dispatch('alert-error', message: "Qty baru tidak boleh lebih kecil dari yang sudah digunakan ({$usedQty} KG)!");
            return;
        }

        // Simpan nilai lama untuk detail notifikasi (opsional tapi bagus untuk audit log)
        $oldQty = $log->initial_quantity;

        // 3. Update Initial dan Current Qty
        $log->update([
            'initial_quantity' => $this->newInitialQty,
            'current_quantity' => $this->newInitialQty - $usedQty,
        ]);

        // 4. Kirim Notifikasi
        $this->sendNotification(action: 'EDIT', target: 'Rework Stock: ' . $dataIdentity, details: "Mengubah total stok awal dari {$oldQty} KG menjadi {$this->newInitialQty} KG untuk batch {$dataIdentity}");

        $this->editingId = null;
        $this->dispatch('alert-success', message: 'Jumlah stok berhasil diperbarui.');
    }

    // Tambahkan properti baru di dalam class
    public $editingDetailId = null;
    public $editUsedQty = 0;
    public $editTargetBatch = '';
    public $reworkLogIdOfDetail = null; // Penting untuk update stok induk

    // Fungsi untuk membuka form edit detail
    public function editRemixUsage($detailId)
    {
        // Cari detail dengan eager load reworkLog-nya (Optimasi N+1)
        $detail = \App\Models\ReworkDetail::with('reworkLog')->findOrFail($detailId);

        $this->editingDetailId = $detailId;
        $this->reworkLogIdOfDetail = $detail->rework_log_id;
        $this->editUsedQty = $detail->quantity_used;
        $this->editTargetBatch = $detail->target_batch_number;

        $this->dispatch('open-edit-usage-modal');
    }

    public function updateRemixUsage()
    {
        $this->validate([
            'editUsedQty' => 'required|numeric|min:0.01',
        ]);

        // 1. Ambil data awal untuk identitas notifikasi (Eager Load agar cepat)
        $detail = \App\Models\ReworkDetail::with('reworkLog.inputData')->findOrFail($this->editingDetailId);
        $log = $detail->reworkLog;

        // Identitas untuk notifikasi
        $originBatch = $log->inputData->batch ?? 'Unknown';
        $targetBatch = $detail->target_batch_number ?? 'Unknown';
        $oldQtyUsed = $detail->quantity_used;

        // KALKULASI: Selisih penambahan (Baru - Lama)
        $qtyDifference = $this->editUsedQty - $detail->quantity_used;

        // VALIDASI: Jika user menambah jumlah pemakaian, cek apakah sisa stok induk mencukupi
        if ($qtyDifference > $log->current_quantity) {
            $this->dispatch('alert-error', message: "Gagal! Stok tidak cukup. Sisa stok tersedia: {$log->current_quantity} KG.");
            return;
        }

        try {
            \DB::transaction(function () use ($qtyDifference) {
                $detail = \App\Models\ReworkDetail::lockForUpdate()->findOrFail($this->editingDetailId);
                $log = \App\Models\ReworkLog::lockForUpdate()->findOrFail($this->reworkLogIdOfDetail);

                // Update Detail
                $detail->update([
                    'quantity_used' => $this->editUsedQty,
                ]);

                // Update Stok Induk (Log)
                $newCurrentQty = $log->current_quantity - $qtyDifference;

                $log->update([
                    'current_quantity' => $newCurrentQty,
                    'status' => $newCurrentQty <= 0 ? 'done' : 'active',
                ]);
            });

            // 2. Kirim Notifikasi Setelah Transaksi Berhasil
            $this->sendNotification(action: 'EDIT', target: "Usage: {$targetBatch}", details: "Koreksi pemakaian remix dari Batch {$originBatch} ke Batch {$targetBatch}. Jumlah diubah dari {$oldQtyUsed} KG menjadi {$this->editUsedQty} KG.");

            $this->editingDetailId = null;
            $this->dispatch('alert-success', message: 'History penggunaan berhasil diperbarui.');
        } catch (\Exception $e) {
            $this->dispatch('alert-error', message: 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
};
?>

<div>
    <x-loading
        wire:target='search, filterStatus, updateRemixUsage, editRemixUsage, updateInitialQty, editQty, confirm_delete, deleteRework' />

    <div class="gap-2 flex mb-4">
        <x-search model='search' />
        <x-filter model="filterStatus">
            <option value="">All Status</option>
            <option value="active">Active Stock ⚠️</option>
            <option value="done">Depleted (Done) ✅</option>
        </x-filter>
    </div>

    <x-data-table title="Monitoring Remix Stock">
        <x-slot:head>
            <th class="px-5 py-3 font-semibold text-left">Origin Info</th>
            <th class="px-5 py-3 font-semibold text-right">Current Stock</th>
            <th class="px-5 py-3 font-semibold text-left pl-10">Used In (Target Batches)</th>
            <th class="px-5 py-3 font-semibold text-center">Status</th>
            <th class="px-5 py-3 font-semibold text-center">Delete</th>
        </x-slot:head>

        @foreach ($reworkLogs as $log)
            <tr wire:key="rework-row-{{ $log->id }}"
                class="hover:bg-slate-50 transition-colors align-middle border-b border-slate-100">
                {{-- Variant & Batch Asal --}}
                <td class="px-5 py-3">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-amber-600 uppercase tracking-wider">
                            {{ $log->inputData->variant->name ?? 'Unknown' }}
                        </span>
                        <span class="text-sm font-mono font-bold text-slate-700">
                            {{ $log->inputData->batch ?? '-' }}
                        </span>
                        <span class="text-[10px] text-slate-400">
                            Initial: {{ number_format($log->initial_quantity) }} KG
                        </span>
                    </div>
                </td>

                {{-- Stok Saat Ini --}}
                <td class="px-5 py-3 text-right">
                    <div class="flex flex-col group cursor-pointer"
                        wire:click="editQty({{ $log->id }}, {{ $log->initial_quantity }})">
                        <span
                            class="text-[10px] uppercase text-slate-400 font-semibold flex items-center justify-end gap-1">
                            Sisa
                            <svg class="w-2 h-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                </path>
                            </svg>
                        </span>
                        <span
                            class="text-sm font-black {{ $log->current_quantity > 0 ? 'text-blue-600' : 'text-slate-300' }}">
                            {{ number_format($log->current_quantity) }} <span class="text-[10px]">KG</span>
                        </span>
                        <span class="text-[9px] text-slate-400 italic">Total:
                            {{ number_format($log->initial_quantity) }}</span>
                    </div>
                </td>
                {{-- DAFTAR BATCH YANG MENGGUNAKAN (TARGET BATCH) --}}
                <td class="px-5 py-3 pl-10">
                    @if ($log->details && $log->details->count() > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach ($log->details as $detail)
                                {{-- Kita bungkus detail dengan button untuk memicu edit --}}
                                <button type="button" wire:click="editRemixUsage({{ $detail->id }})"
                                    wire:key="detail-{{ $detail->id }}"
                                    class="group relative flex items-center bg-white border border-slate-200 rounded-sm px-2 py-1 shadow-sm hover:border-indigo-400 hover:shadow-md transition-all">

                                    <div class="flex flex-col">
                                        <span
                                            class="text-[10px] font-black text-indigo-600 leading-tight group-hover:text-amber-600 transition-colors">
                                            {{ $detail->target_batch_number }}
                                            <svg class="w-2 h-2 inline ml-1 opacity-0 group-hover:opacity-100 transition-opacity"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </span>
                                        <span class="text-[9px] text-slate-500 font-medium">
                                            {{ number_format($detail->quantity_used) }} KG <span
                                                class="text-slate-300 mx-0.5">•</span>
                                            {{ $detail->created_at->format('d/m') }}
                                        </span>
                                    </div>

                                    {{-- Tooltip tetap ada --}}
                                    @if ($detail->notes)
                                        ...
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    @else
                    @endif
                </td>

                {{-- Status --}}
                <td class="px-5 py-3 text-center">
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-sm text-[10px] font-bold border {{ $log->current_quantity > 0 ? 'bg-green-50 text-green-700 border-green-200' : 'bg-slate-50 text-slate-500 border-slate-200' }}">
                        {{ $log->current_quantity > 0 ? 'READY' : 'EXHAUSTED' }}
                    </span>
                </td>

                {{-- Action Delete --}}
                <td class="px-5 py-3 text-center">
                    <button wire:click="confirm_delete({{ $log->id }})"
                        class="text-slate-300 hover:text-red-600 transition-colors duration-200">
                        <x-delete-svg />
                    </button>
                </td>
            </tr>
        @endforeach

        @if ($reworkLogs->isEmpty())
            <tr>
                <td colspan="5" class="px-5 py-12 text-center text-slate-400 italic text-sm">
                    No remix stock records found.
                </td>
            </tr>
        @endif
    </x-data-table>

    <div class="mt-4 px-5">
        {{ $reworkLogs->links() }}
    </div>

    {{-- Modal Edit Total Input (Stok Awal) --}}
    <x-modal :show="$editingId" title="Edit Total Input">
        @if ($editingId)
            <div class="space-y-4">
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1 tracking-tight">
                        Jumlah Awal Baru (KG)
                    </label>

                    <input type="number" wire:model="newInitialQty"
                        class="w-full px-3 py-3 text-lg font-bold border border-slate-300 rounded-sm focus:ring-2 focus:ring-amber-500 outline-none transition-all shadow-sm"
                        placeholder="0">

                    {{-- Info Box: Membantu User Memahami Kalkulasi --}}
                    <div class="mt-3 p-3 bg-amber-50 border border-amber-100 rounded-sm">
                        <p class="text-[10px] text-amber-700 leading-relaxed italic">
                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Sistem akan otomatis menghitung <strong>Sisa Stok</strong> dengan mengurangi angka baru ini
                            dengan jumlah yang sudah terpakai di batch lain.
                        </p>
                    </div>
                </div>

                {{-- Footer Action --}}
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 mt-6">
                    <button type="button" wire:click="$set('editingId', null)"
                        class="px-5 py-2 text-sm font-bold text-slate-500 hover:bg-slate-100 rounded-sm transition-colors border border-slate-200 uppercase tracking-tighter">
                        Batal
                    </button>
                    <button type="button" wire:click="updateInitialQty"
                        class="px-6 py-2 bg-amber-600 text-white rounded-sm text-sm font-bold shadow-md hover:bg-amber-700 transition-all uppercase tracking-tighter">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        @endif
    </x-modal>

    {{-- Tambahkan ini di bagian paling bawah file blade (setelah penutup </div> utama) --}}
    {{-- Modal Edit Penggunaan --}}
    <x-modal wire:model="editingDetailId" :show="$editingDetailId" title="Koreksi Pemakaian">
        @if ($editingDetailId)
            @php
                $currentLog = \App\Models\ReworkLog::find($this->reworkLogIdOfDetail);
                $currentDetail = \App\Models\ReworkDetail::find($this->editingDetailId);
                $maxInput = ($currentLog->current_quantity ?? 0) + ($currentDetail->quantity_used ?? 0);
            @endphp

            <div class="space-y-4">
                <div class="p-3 bg-slate-50 rounded-sm border border-slate-200">
                    <div class="flex justify-between text-[11px] mb-1">
                        <span class="text-slate-500 uppercase font-bold">Stok Induk Saat Ini:</span>
                        <span class="text-slate-700 font-black">{{ number_format($currentLog->current_quantity ?? 0) }}
                            KG</span>
                    </div>
                    <div class="flex justify-between text-[11px]">
                        <span class="text-slate-500 uppercase font-bold">Pemakaian Lama:</span>
                        <span class="text-slate-700 font-black">{{ number_format($currentDetail->quantity_used ?? 0) }}
                            KG</span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1 uppercase tracking-tight">Jumlah Baru
                        (KG)</label>
                    <input type="number" wire:model="editUsedQty"
                        class="w-full px-3 py-3 text-lg font-bold border border-slate-300 rounded-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                        step="0.01">

                    <div class="mt-2 flex items-start gap-2">
                        <svg class="w-3 h-3 text-amber-500 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-[10px] text-slate-500 leading-tight italic">
                            Batas maksimal input adalah <strong>{{ number_format($maxInput) }} KG</strong> (Sisa stok +
                            pemakaian lama).
                        </p>
                    </div>
                    @error('editUsedQty')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 mt-6">
                    <button type="button" wire:click="$set('editingDetailId', null)"
                        class="px-5 py-2 text-sm font-bold text-gray-500 hover:bg-gray-100 rounded-sm transition-colors border border-gray-200 uppercase tracking-tighter">
                        Batal
                    </button>
                    <button type="button" wire:click="updateRemixUsage"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-sm text-sm font-bold shadow-md hover:bg-indigo-700 transition-all uppercase tracking-tighter">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        @endif
    </x-modal>
</div>
