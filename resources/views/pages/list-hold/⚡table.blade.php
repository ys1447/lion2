<?php

use Livewire\Component;
use App\Models\HoldLog;
use Livewire\Attributes\On; // Tambahkan ini
use Illuminate\Support\Facades\Gate;
use App\Traits\HasNotification;
use Livewire\WithPagination;

new class extends Component {
    use HasNotification, WithPagination;
    public $selectedReason = '';
    public $showReasonModal = false;
    public $search = '';

    public $inputStatusFilter = '';

    public function openReason($reason)
    {
        $this->selectedReason = $reason;
        $this->showReasonModal = true;
    }

    public function releaseHold($logId)
    {
        $log = HoldLog::findOrFail($logId);
        $inputData = $log->inputData;

        \DB::transaction(function () use ($log, $inputData) {
            // 1. Update status di tabel utama kembali ke normal
            $inputData->update([
                'status' => 'releaseHold',
            ]);

            // 2. Tutup log: Tandai kapan batch ini dibebaskan
            $log->update([
                'released_at' => now(),
            ]);
        });

        $this->dispatch('alert-success', message: 'Batch berhasil dirilis dan dikembalikan ke daftar utama.');
    }

    public function cancel()
    {
        $this->showReasonModal = false;
    }

    public function updatedInputStatusFilter()
    {
        // Setiap kali ganti filter, balikkan ke halaman 1
        $this->resetPage();
    }

    public function render()
    {
        return $this->view([
            'logs' => HoldLog::query()
                ->with(['inputData', 'user'])
                ->search($this->search)
                ->withInputStatus($this->inputStatusFilter)
                ->latest()
                ->paginate(10),
        ]);
    }

    public function confirm_delete($id)
    {
        $this->dispatch(
            'confirm-delete',
            id: $id,
            type: 'list-hold', // beda tiap component
        );
    }

    #[On('delete-list-hold')]
    public function deleteHold($id)
    {
        if (Gate::denies('admin-only')) {
            $this->dispatch('alert-error', message: 'Anda tidak memiliki akses untuk menghapus!');
            return;
        }

        $log = HoldLog::findOrFail($id);

        $dataIdentity = $log->inputData->batch ?? 'Data ID: ' . $log->input_data_id;
        $reworkType = $log->status ?? 'Hold';

        // 1. Kembalikan status di tabel InputData agar tidak dianggap Rework lagi
        // Asumsi: relasi di model ReworkLog bernama 'inputData'
        if ($log->inputData) {
            $log->inputData->update([
                'status' => 'releaseHold', // atau status default Anda
            ]);
        }

        // 2. Hapus data log (dan detailnya jika menggunakan cascade delete di DB)
        $log->delete();

        $this->sendNotification(action: 'DELETE', target: 'Hold Log: ' . $dataIdentity, details: "Cancelled {$reworkType} for '{$dataIdentity}' and restored status to release");

        $this->dispatch('alert-success', message: 'Hold dibatalkan dan dikembalikan ke list utama.');
    }
};
?>

<div>
    <x-loading wire:target='cancel, openReason, releaseHold, search, inputStatusFilter' />
    <div class="gap-2 flex">
        <x-search model='search' />
        <x-filter model="inputStatusFilter">
            <option value="">All Status</option>
            <option value="hold">On Hold ⚠️</option>
            <option value="releaseHold">Released ✅</option>
        </x-filter>
    </div>
    <x-data-table title="Job Mixing List">
        <x-slot:head>

            <th class="px-5 py-3 font-semibold">Variant</th>
            <th class="px-5 py-3 font-semibold">Batch</th>
            <th class="px-5 py-3 font-semibold">Date</th>
            <th class="px-5 py-3 font-semibold">Notes</th>
            <th class="px-5 py-3 font-semibold">User id</th>
            <th class="px-5 py-3 font-semibold">Release(?)</th>
            <th class="px-5 py-3 font-semibold">Status</th>
            <th class="px-5 py-3 font-semibold">Release Date</th>
            <th class="px-5 py-3 font-semibold">Delete</th>
        </x-slot:head>
        @foreach ($logs as $log)
            <tr class="hover:bg-slate-50 transition-colors align-middle">


                <td class="px-5 py-3">
                    <span class="text-xs px-2 py-1 rounded-sm bg-amber-100 text-amber-800 font-medium">
                        {{ $log->inputData->variant->name }}
                    </span>
                </td>

                <td class="px-5 py-3 text-slate-600 font-mono text-sm">
                    {{ $log->inputData->batch }}
                </td>

                <td class="px-5 py-3 text-slate-600 font-mono text-sm">
                    {{ $log->hold_at->format('d/m/y H:i') }}
                </td>

                <td class="px-5 py-3">
                    <button wire:click="openReason('{{ addslashes($log->reason) }}')"
                        class="inline-flex items-center gap-1.5 px-2 py-1 rounded bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-colors group">

                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>

                        <span class="text-[10px] font-bold uppercase tracking-tight">Show Reason</span>
                    </button>
                </td>

                <td class="px-5 py-3">
                    <span class="text-slate-700 font-medium text-sm">{{ $log->user->name ?? 'System' }}</span>
                </td>

                <td class="px-5 py-3 text-center">
                    <button wire:click="releaseHold({{ $log->id }})"
                        wire:confirm="Konfirmasi: Batch ini akan dikembalikan ke status normal?"
                        class="group inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded border border-slate-200 bg-white text-slate-500 hover:border-green-500 hover:text-green-600 hover:bg-green-50/50 transition-all duration-200 shadow-sm"
                        title="Release Batch">

                        {{-- Ikon SVG --}}
                        <svg class="w-3.5 h-3.5 transform group-hover:scale-110 transition-transform duration-200"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>

                        {{-- Teks Pendek --}}
                        <span class="text-[10px] font-bold uppercase tracking-wider">Release</span>
                    </button>
                </td>

                <td class="px-5 py-3">
                    <span class="text-slate-700 font-medium text-sm">
                        @if ($log->released_at)
                            <span
                                class="inline-flex items-center px-2 py-1 rounded text-[10px] font-bold bg-green-100 text-green-700">
                                RELEASED
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-2 py-1 rounded text-[10px] font-bold bg-red-100 text-red-700 animate-pulse">
                                ON HOLD
                            </span>
                        @endif
                    </span>
                </td>

                <td class="px-5 py-3">
                    <span class="text-slate-700 font-medium text-sm">
                        {{ $log->released_at ? $log->released_at->format('d/m/y H:i') : '-- : --' }}
                    </span>
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

    </x-data-table>
    <div class="mt-4">
        {{ $logs->links() }}
    </div>

    {{-- Modal untuk melihat alasan lengkap --}}
    <x-modal :show="$showReasonModal" title="Full Hold Reason">
        <div class="space-y-4">
            {{-- Info Badge --}}
            <div class="flex items-center gap-2 mb-2">
                <span
                    class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold uppercase tracking-wider">
                    Reason Detail
                </span>
            </div>

            {{-- Isi Alasan --}}
            <div class="bg-slate-50 border border-slate-100 rounded-lg p-4">
                <p class="text-sm text-slate-700 leading-relaxed text-justify italic shadow-inner">
                    "{{ $selectedReason }}"
                </p>
            </div>

            <div class="flex justify-end pt-2">
                <button wire:click="cancel"
                    class="px-5 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100 rounded-md transition-colors border border-slate-200 shadow-sm">
                    Close
                </button>
            </div>
        </div>
    </x-modal>
</div>
