<?php

use App\Models\ReagentLog;
use App\Models\StockReagent;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Traits\HasNotification;

new class extends Component {
    use WithPagination, HasNotification;
    protected $listeners = ['data-added', 'edit-updated', 'reagent-added' => '$refresh'];

    public function render()
    {
        return $this->view([
            'logs' => ReagentLog::with('reagent')->latest()->paginate(10),
            'reagents' => StockReagent::orderBy('name', 'asc')->get(),
        ]);
    }

    public function edit($id)
    {
        $this->dispatch('edit', id: $id);
    }

    public function confirm_delete($id)
    {
        $this->dispatch(
            'confirm-delete',
            id: $id,
            type: 'reagent-log', // beda tiap component
        );
    }

    #[On('delete-reagent-log')]
    public function delete($id)
    {
        if (Gate::denies('admin-only')) {
            $this->dispatch('alert-error', message: 'Akses Ditolak: Hanya Admin yang dapat menghapus reagent!');
            return;
        }

        $log = ReagentLog::findOrFail($id);
        $reagent = $log->reagent;

        $reagentName = $reagent->name;
        $logAmount = number_format($log->amount);
        $logType = $log->type; // 'incoming' atau 'usage'

        if ($log->type === 'incoming') {
            // Jika log stok masuk dihapus, kurangi total_incoming
            $reagent->decrement('total_incoming', $log->amount);
        } else {
            // Jika log pemakaian dihapus, kurangi total_usage (stok balik lagi)
            $reagent->decrement('total_usage', $log->amount);
        }

        // Update current_stock
        $reagent->refresh();
        $reagent->current_stock = $reagent->initial_stock + $reagent->total_incoming - $reagent->total_usage;
        $reagent->save();

        $log->delete();

        $this->sendNotification(action: 'DELETE', target: 'Log Regent: ' . $reagentName, details: "Deleted {$logType} log of {$logAmount}ml for reagent '{$reagentName}'");

        $this->dispatch('alert-success', message: 'Log deleted and stock adjusted.');
    }

    public function confirm_delete_stock($id)
    {
        $this->dispatch(
            'confirm-delete',
            id: $id,
            type: 'master-reagent', // Type unik untuk membedakan dengan log
        );
    }

    // Listener khusus untuk menghapus Master Reagent
    #[On('delete-master-reagent')]
    public function delete_reagent($id)
    {
        // 1. Proteksi Admin
        if (Gate::denies('admin-only')) {
            $this->dispatch('alert-error', message: 'Akses Ditolak: Hanya Admin yang dapat menghapus reagent!');
            return;
        }

        $reagent = StockReagent::findOrFail($id);

        // Simpan nama sebelum dihapus untuk notifikasi
        $reagentName = $reagent->name;
        $initialStock = number_format($reagent->initial_stock);

        // Opsional: Cek apakah reagent masih punya log activity
        // Jika masih ada log, biasanya sebaiknya log dihapus dulu atau dicegah hapus reagent-nya
        if ($reagent->logs()->exists()) {
            $this->dispatch('alert-error', message: 'Gagal: Reagent masih memiliki data history log. Hapus log terlebih dahulu.');
            return;
        }

        $reagent->delete();

        // 3. Kirim Notifikasi
        $this->sendNotification(action: 'DELETE', target: 'Master Reagent: ' . $reagentName, details: "Permanently deleted master reagent '{$reagentName}' (Initial Stock: {$initialStock}ml)");

        $this->dispatch('alert-success', message: 'Master Reagent berhasil dihapus.');
        $this->dispatch('reagent-added'); // Refresh tabel
    }
};
?>

<div class="mt-8 border-t border-slate-100 pt-6">
    <x-loading wire:target='edit' />
    <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Recent Activity Logs
    </h3>

    {{-- Memanggil Komponen Tabel --}}
    <x-table-data-2 :headers="['Time', 'Reagent', 'Action', 'Amount', 'User', 'Action']">
        @foreach ($logs as $log)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-2 text-slate-400 italic">{{ $log->created_at->diffForHumans() }}</td>
                <td class="px-4 py-2 font-medium text-slate-700">{{ $log->reagent->name }}</td>
                <td class="px-4 py-2">
                    <span
                        class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase">
                        {{ $log->type }}
                    </span>
                </td>
                <td class="px-4 py-2 font-bold text-emerald-600">
                    +{{ number_format($log->amount) }} ml
                </td>
                <td class="px-4 py-2 text-slate-500">{{ $log->user_name }}</td>
                <td class="px-4 py-2 text-slate-500 flex">
                    <span wire:click="edit({{ $log->id }})"
                        class="text-indigo-600 hover:text-indigo-900 cursor-pointer">
                        <x-edit-svg />
                    </span>

                    <span wire:click="confirm_delete({{ $log->id }})"
                        class="text-red-600 hover:text-red-900 cursor-pointer">
                        <x-delete-svg />
                    </span>
                </td>
            </tr>
        @endforeach
    </x-table-data-2>
    <div class="mt-2">
        {{ $logs->links() }}
    </div>

    <div class="mt-10 border-t border-slate-100 pt-6">
        <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.628.283a2 2 0 01-1.186.127l-2.96-.592a2 2 0 00-.546.101l-1.58.475a2 2 0 00-1.357 2.324l.84 3.358a2 2 0 002.325 1.355l10.126-2.025a2 2 0 001.355-2.325l-.84-3.358z" />
            </svg>
            Current Reagent Inventory
        </h3>

        <x-table-data-2 :headers="['Reagent Name', 'Initial', 'Incoming', 'Usage', 'Current Stock', 'Min Stock', 'Status', 'Action']">
            @foreach ($reagents as $item)
                <tr class="hover:bg-slate-50 transition-colors">
                    {{-- Nama Reagent --}}
                    <td class="px-4 py-3 font-semibold text-slate-700">
                        {{ $item->name }}
                    </td>

                    {{-- Stok Awal --}}
                    <td class="px-4 py-3 text-slate-500 text-xs">
                        {{ number_format($item->initial_stock) }} <span class="text-[10px]">ML</span>
                    </td>

                    {{-- Stok Masuk --}}
                    <td class="px-4 py-3 text-emerald-600 text-xs font-medium">
                        + {{ number_format($item->total_incoming) }}
                    </td>

                    {{-- Pemakaian --}}
                    <td class="px-4 py-3 text-red-500 text-xs font-medium">
                        - {{ number_format($item->total_usage) }}
                    </td>

                    {{-- Sisa Stok Sekarang --}}
                    <td class="px-4 py-3 font-bold text-slate-900 bg-slate-50/50">
                        {{ number_format($item->current_stock) }} <span
                            class="text-[10px] font-normal text-slate-400">ML</span>
                    </td>

                    <td class="px-4 py-3 font-bold text-slate-900 bg-slate-50/50">
                        {{ number_format($item->min_stock) }} <span
                            class="text-[10px] font-normal text-slate-400">ML</span>
                    </td>

                    {{-- Status Alert --}}
                    <td class="px-4 py-3">
                        @if ($item->current_stock <= $item->min_stock)
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-sm bg-red-100 text-red-700 text-[10px] font-bold uppercase tracking-wider animate-pulse">
                                Low Stock
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-sm bg-slate-100 text-slate-600 text-[10px] font-bold uppercase tracking-wider">
                                Safe
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 font-bold text-slate-900 bg-slate-50/50">
                        <span wire:click="confirm_delete_stock({{ $item->id }})"
                            class="text-red-600 hover:text-red-900 cursor-pointer">
                            <x-delete-svg />
                        </span>
                    </td>
                </tr>
            @endforeach
        </x-table-data-2>
    </div>
</div>
