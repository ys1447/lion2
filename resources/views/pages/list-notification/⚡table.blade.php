<?php

use App\Models\ActivityNotification;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;

new class extends Component {
    use WithPagination;
    public $search = '';

    public function render()
    {
        return $this->view([
            'notifications' => ActivityNotification::query()->with('user')->search($this->search)->latest()->paginate(15),
        ]);
    }

    public function clearAll()
    {
        if (Gate::denies('admin-only')) {
            return;
        }

        ActivityNotification::truncate(); // Hapus semua isi tabel
        $this->dispatch('alert-success', message: 'Semua notifikasi dibersihkan.');
    }
};
?>

<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-slate-800">System Activity Logs</h2>

        @if ($notifications->count() > 0)
            <button wire:click="clearAll" wire:confirm="Hapus semua riwayat notifikasi?"
                class="text-xs px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-sm font-semibold transition-colors">
                Clear All Logs
            </button>
        @endif
    </div>

    {{-- Gunakan Template Tabel Kamu --}}
    <x-loading wire:target='search'/>
    <x-search model='search' />
    <x-table-data-2 :headers="['Time', 'User', 'Action', 'Target', 'Details']">
        @forelse ($notifications as $notif)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3 text-slate-400 italic">
                    {{ $notif->created_at }}
                </td>
                <td class="px-4 py-3 font-semibold text-slate-700">
                    {{ $notif->user_name }}
                </td>
                <td class="px-4 py-3">
                    <span @class([
                        'px-2 py-0.5 rounded-sm text-[10px] font-bold uppercase',
                        'bg-blue-100 text-blue-700' => $notif->action === 'EDIT',
                        'bg-red-100 text-red-700' => $notif->action === 'DELETE',
                        'bg-emerald-100 text-emerald-700' => !in_array($notif->action, [
                            'EDIT',
                            'DELETE',
                        ]),
                    ])>
                        {{ $notif->action }}
                    </span>
                </td>
                <td class="px-4 py-3 text-slate-600 font-medium">
                    {{ $notif->target }}
                </td>
                <td class="px-4 py-3 text-slate-500 max-w-xs truncate">
                    {{ $notif->details }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-4 py-10 text-center text-slate-400 italic">
                    No activity recorded yet.
                </td>
            </tr>
        @endforelse
    </x-table-data-2>

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
</div>
