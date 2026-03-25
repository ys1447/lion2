<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ReworkLog;
use Illuminate\Support\Facades\Gate;
use App\Traits\HasNotification;

new class extends Component {
    use HasNotification;
    public $showRemixModal = false;
    public $selectedReworkId;
    public $reworkData; // Untuk menampung info batch yang dipilih

    // Form Fields
    public $quantityUsed, $targetBatch, $shift, $notes;

    #[On('rework-added')]
    public function render()
    {
        return $this->view([
            // Di fungsi render
            'reworkLogs' => ReworkLog::with([
                'inputData.variant',
                'details' => function ($query) {
                    $query->latest()->limit(1); // Hanya ambil 1 detail terbaru untuk kolom "Last Remix"
                },
            ])
                ->latest()
                ->paginate(10),
        ]);
    }

    public function selectForRemix($id)
    {
        $this->selectedReworkId = $id;
        $this->reworkData = ReworkLog::with('inputData.variant')->find($id);

        // Reset Form
        $this->quantityUsed = '';
        $this->targetBatch = '';
        $this->shift = ''; // Bisa di-set default ke shift saat ini
        $this->notes = '';

        $this->showRemixModal = true;
    }

    public function cancel()
    {
        $this->showRemixModal = false;
    }

    public function processRemix()
    {
        $this->validate(
            [
                'quantityUsed' => 'required|numeric|min:1|max:' . $this->reworkData->current_quantity,
                'targetBatch' => 'required|string',
                'shift' => 'required',
            ],
            [
                'quantityUsed.max' => 'Input melebihi sisa stok (' . $this->reworkData->current_quantity . ' KG)',
            ],
        );

        // TAMBAHKAN BARIS INI: Definisikan siapa itu $log
        $log = ReworkLog::find($this->selectedReworkId);

        // 1. Catat ke tabel DETAIL (History) agar tidak tertimpa
        $log->details()->create([
            'quantity_used' => $this->quantityUsed,
            'target_batch_number' => $this->targetBatch,
            'shift' => $this->shift,
            'notes' => $this->notes,
        ]);

        // 2. Kurangi Sisa Stok di tabel INDUK
        $log->current_quantity -= $this->quantityUsed;
        if ($log->current_quantity <= 0) {
            $log->current_quantity = 0;
            $log->status = 'done';
        }
        $log->save();

        $this->showRemixModal = false;
        $this->dispatch('alert-success', message: 'Remix Berhasil Dicatat!');
    }

    public function confirm_delete($id)
    {
        $this->dispatch(
            'confirm-delete',
            id: $id,
            type: 'list-rework', // beda tiap component
        );
    }

    #[On('delete-list-rework')]
    public function deleteRework($id)
    {
        if (Gate::denies('admin-only')) {
            $this->dispatch('alert-error', message: 'Anda tidak memiliki akses untuk menghapus!');
            return;
        }

        $log = ReworkLog::findOrFail($id);
        $dataIdentity = $log->inputData->batch ?? 'Data ID: ' . $log->input_data_id;
        $reworkType = $log->status ?? 'Remix/Rework';

        // 1. Kembalikan status di tabel InputData agar tidak dianggap Rework lagi
        // Asumsi: relasi di model ReworkLog bernama 'inputData'
        if ($log->inputData) {
            $log->inputData->update([
                'status' => 'releaseHold', // atau status default Anda
            ]);
        }

        // 2. Hapus data log (dan detailnya jika menggunakan cascade delete di DB)
        $log->delete();

        $this->sendNotification(action: 'DELETE', target: 'Rework Log: ' . $dataIdentity, details: "Cancelled {$reworkType} for '{$dataIdentity}' and restored status to release");

        $this->dispatch('alert-success', message: 'Rework dibatalkan dan dikembalikan ke list utama.');
    }
};
?>

<div>
    <x-loading wire:target='selectForRemix, processRemix, cancel' />

    <x-data-table title="Active Rework & Remix List">
        <x-slot:head>

            <th class="px-5 py-3 font-semibold">Variant</th>
            <th class="px-5 py-3 font-semibold">Origin Batch</th>
            <th class="px-5 py-3 font-semibold">Initial Qty</th>
            <th class="px-5 py-3 font-semibold text-amber-600">Current Stock</th>
            <th class="px-5 py-3 font-semibold">Action</th>
            <th class="px-5 py-3 font-semibold">Status</th>
            <th class="px-5 py-3 font-semibold">Last Remix</th>
            <th class="px-5 py-3 font-semibold">Delete</th>
        </x-slot:head>

        @foreach ($reworkLogs as $log)
            <tr class="hover:bg-slate-50 transition-colors align-middle border-b border-slate-100">


                <td class="px-5 py-3">
                    <span
                        class="text-[11px] px-2 py-1 rounded-sm bg-amber-100 text-amber-800 font-bold uppercase tracking-tight">
                        {{ $log->inputData->variant->name }}
                    </span>
                </td>

                <td class="px-5 py-3 text-slate-600 font-mono text-sm">
                    {{ $log->inputData->batch }}
                </td>

                <td class="px-5 py-3 text-right text-slate-500 font-medium text-sm">
                    {{ number_format($log->initial_quantity) }} KG
                </td>

                <td class="px-5 py-3">
                    <span class="text-sm font-black text-amber-600">
                        {{ number_format($log->current_quantity) }} <span class="text-[10px]">KG</span>
                    </span>
                </td>

                <td class="px-5 py-3 text-center">
                    <button wire:click="selectForRemix({{ $log->id }})"
                        class="group inline-flex items-center gap-1.5 px-3 py-1.5 rounded border border-amber-200 bg-white text-amber-600 hover:bg-amber-600 hover:text-white transition-all duration-200 shadow-sm">

                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>

                        <span class="text-[10px] font-bold uppercase tracking-wider">Process Remix</span>
                    </button>
                </td>

                <td class="px-5 py-3">
                    @if ($log->current_quantity > 0)
                        <span
                            class="inline-flex items-center px-2 py-1 rounded text-[10px] font-bold bg-blue-100 text-blue-700 animate-pulse">
                            REWORKING
                        </span>
                    @else
                        <span
                            class="inline-flex items-center px-2 py-1 rounded text-[10px] font-bold bg-green-100 text-green-500">
                            COMPLETED
                        </span>
                    @endif
                </td>

                <td class="px-5 py-3">
                    <div class="flex flex-col">
                        <span class="text-slate-700 font-medium text-xs">
                            {{ $log->details->first()->target_batch_number ?? '--' }}
                        </span>
                        <span class="text-[10px] text-slate-400 italic">
                            {{ $log->details->first() ? $log->details->first()->created_at->format('d/m H:i') : 'No history' }}
                        </span>
                    </div>
                </td>

                <td class="px-5 py-3 text-center" wire:click="confirm_delete({{ $log->id }})">
                    <div class="flex items-center justify-center"> {{-- Container Flex untuk centering --}}
                        <span class="text-red-600 hover:text-red-900 cursor-pointer transition-colors duration-200">
                            <x-delete-svg />
                        </span>
                    </div>
                </td>
            </tr>
        @endforeach

        @if ($reworkLogs->isEmpty())
            <tr>
                <td colspan="8" class="px-5 py-10 text-center text-slate-400 italic text-sm">
                    No active rework batches found.
                </td>
            </tr>
        @endif
    </x-data-table>

    <div class="mt-4 px-5">
        {{ $reworkLogs->links() }}
    </div>

    {{-- Modal Remix --}}
    <x-modal :show="$showRemixModal" wire:model="showRemixModal" title="Add Remix Transaction">
        @if ($reworkData)
            <div class="p-1">
                {{-- 1. Bagian Riwayat (Usage History) --}}
                <div class="mb-5">
                    <div class="flex items-center gap-2 mb-3">
                        <span
                            class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold uppercase tracking-wider">
                            Usage History
                        </span>
                    </div>
                    <div class="max-h-40 overflow-y-auto border border-slate-100 rounded-lg bg-slate-50 shadow-inner">
                        <table class="w-full text-[11px] text-left">
                            <thead class="sticky top-0 bg-slate-200 text-slate-700 font-bold border-b">
                                <tr>
                                    <th class="p-2">Date</th>
                                    <th class="p-2 text-right">Used</th>
                                    <th class="p-2 pl-4">Target Batch</th>
                                    <th class="p-2 text-center">Shift</th>
                                    <th class="p-2 text-center">Notes</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @forelse($reworkData->details as $history)
                                    <tr class="hover:bg-white transition-colors">
                                        <td class="p-2 text-slate-500">{{ $history->created_at->format('d/m H:i') }}
                                        </td>
                                        <td class="p-2 text-right font-bold text-red-500">
                                            -{{ number_format($history->quantity_used) }} KG</td>
                                        <td class="p-2 pl-4 font-semibold text-slate-700">
                                            {{ $history->target_batch_number }}</td>
                                        <td class="p-2 text-center text-slate-600">{{ $history->shift }}</td>
                                        <td class="p-2 text-center text-slate-600">{{ $history->notes }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-4 text-center text-slate-400 italic">No transactions
                                            yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr class="border-slate-200 mb-5 border-dashed">

                {{-- 2. Bagian Form Input --}}
                <div class="space-y-0"> {{-- space-0 karena komponen Anda sudah punya my-4 --}}

                    {{-- Summary Panel (Tetap manual agar style khas Amber-nya terjaga) --}}
                    <div
                        class="grid grid-cols-2 gap-3 p-3 bg-amber-50 border border-amber-100 rounded-sm shadow-sm mb-2">
                        <div>
                            <p class="text-[10px] uppercase text-amber-600 font-bold tracking-wider leading-tight">
                                Original Batch</p>
                            <p class="text-sm font-black text-slate-800">{{ $reworkData->inputData->batch }}</p>
                        </div>
                        <div class="text-right border-l border-amber-200 pl-3">
                            <p class="text-[10px] uppercase text-amber-600 font-bold tracking-wider leading-tight">
                                Available Stock</p>
                            <p class="text-lg font-black text-amber-700 leading-none">
                                {{ number_format($reworkData->current_quantity) }} <span
                                    class="text-xs font-normal">KG</span>
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-x-4">
                        {{-- Quantity Input menggunakan Komponen Anda --}}
                        <x-form-input label="Quantity to Use (KG)" forId="quantityUsed" type="number"
                            wire:model="quantityUsed" placeholder="0" :error="$errors->first('quantityUsed')" />

                        {{-- Target Batch Input menggunakan Komponen Anda --}}
                        <x-form-input label="Target Batch (Remix To)" forId="targetBatch" wire:model="targetBatch"
                            placeholder="Ex: 260326x" :error="$errors->first('targetBatch')" />
                    </div>

                    <div class="grid grid-cols-3 gap-x-4">
                        {{-- Shift Selection (Manual karena komponen Anda khusus <input>) --}}
                        <div class="my-4">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Shift</label>
                            <select wire:model="shift"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                <option value="">Select</option>
                                <option value="1">Shift 1</option>
                                <option value="2">Shift 2</option>
                                <option value="3">Shift 3</option>
                            </select>
                            @error('shift')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Notes Input menggunakan Komponen Anda --}}
                        <div class="col-span-2">
                            <x-form-input label="Transaction Notes" forId="notes" wire:model="notes"
                                placeholder="Optional notes..." :error="$errors->first('notes')" />
                        </div>
                    </div>

                    {{-- Footer Actions --}}
                    <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
                        <button type="button" wire:click="cancel"
                            class="px-5 py-2 text-sm font-semibold text-gray-500 hover:bg-gray-100 rounded-sm transition-colors border border-gray-200">
                            Cancel
                        </button>
                        <button type="button" wire:click="processRemix"
                            class="inline-flex items-center justify-center gap-2 px-6 py-2 bg-amber-600 text-white rounded-sm text-sm font-bold shadow-sm hover:bg-amber-700 transition-all active:scale-95 disabled:opacity-50">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </x-modal>
</div>
