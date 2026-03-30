<?php

use Livewire\Component;
use App\Models\Filling;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Traits\HasNotification;

new class extends Component {
    use HasNotification, WithPagination;

    public $showModal = false;
    public $selectedFillingId = null; // Simpan ID saja lebih aman
    public $showIssueModal = false;
    public $newStatus = '';
    public $titleForModal = ''; // Untuk menampilkan judul di modal
    public $selectedIssueContent = ''; // Menyimpan teks issue
    public $search = '';
    public $statusFilter = '';

    protected $listeners = ['filling-added', 'filling-updated' => '$refresh'];

    public function updatedSearch(){
        $this->resetPage();
    }

    public function updatedStatusFilter(){
        $this->resetPage();
    }

    public function editStatus($id)
    {
        $filling = Filling::findOrFail($id);
        $this->selectedFillingId = $filling->id;
        $this->titleForModal = $filling->title;
        $this->newStatus = $filling->status;
        $this->showModal = true;
    }

    public function updateStatus()
    {
        if ($this->selectedFillingId) {
            $filling = Filling::find($this->selectedFillingId);
            $fillingTitle = $filling->title;

            $filling->update([
                'status' => $this->newStatus,
            ]);

            $this->sendNotification(action: 'EDIT', target: 'Filling: ' . $fillingTitle, details: "Changed status '{$fillingTitle}'");

            $this->showModal = false;
            $this->dispatch('alert-success', message: 'Status has been updated!');
        }
    }

    // Fungsi baru untuk menampilkan detail issue
    public function showIssue($id)
    {
        $filling = Filling::findOrFail($id);
        $this->titleForModal = $filling->title;
        $this->selectedIssueContent = $filling->issues;
        $this->showIssueModal = true;
    }

    public function cancelIssue()
    {
        $this->showIssueModal = false;
    }

    public function cancelStatus()
    {
        $this->showModal = false;
    }

    public function confirm_delete($id)
    {
        $this->dispatch(
            'confirm-delete',
            id: $id,
            type: 'filling', // beda tiap component
        );
    }

    #[On('delete-filling')]
    public function delete($id)
    {
        if (Gate::denies('admin-only')) {
            $this->dispatch('alert-error', message: 'Anda tidak memiliki akses untuk menghapus!');
            return;
        }

        $filling = Filling::findOrFail($id);
        $fillingTitle = $filling->title;
        $filling->delete();

        $this->sendNotification(action: 'DELETE', target: 'Filling: ' . $fillingTitle, details: "Delete filling data '{$fillingTitle}' from system");

        $this->dispatch('alert-success', message: 'Data berhasil dihapus');
    }

    public function edit($id)
    {
        $this->dispatch('edit-filling', id: $id);
    }

    public function render()
    {
        return $this->view([
            // Jangan lupa tambahkan eager loading 'category' dan 'user' agar tidak N+1 query
            'fillings' => Filling::query()
                ->with(['category', 'user'])
                ->search($this->search)
                ->withStatus($this->statusFilter)
                ->latest()
                ->paginate(10),
        ]);
    }
};
?>

<div>
    @php
        $headers = ['Title', 'Category', 'User', 'Issue', 'Status', 'Date', 'Update Status', 'Action'];
    @endphp
    <x-loading wire:target="updateStatus, showIssue, editStatus, cancelIssue, cancelStatus, edit, search, statusFilter" />
    <div class="gap-2 flex">

        <x-search model='search' />
        <x-filter model="statusFilter">
            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="in_progress">In Progress</option>
            <option value="closed">Closed</option>
        </x-filter>
    </div>
    <x-table-data-2 :headers="$headers">
        @foreach ($fillings as $item)
            <tr class="hover:bg-slate-50 border-b border-slate-100">
                <td class="px-4 py-3 font-medium text-slate-700">{{ $item->title }}</td>
                <td class="px-4 py-3 text-slate-600">{{ $item->category->name }}</td>
                <td class="px-4 py-3 text-slate-500 italic">{{ $item->user->name ?? 'System' }}</td>

                <td class="px-4 py-3">
                    {{-- Tombol untuk buka modal Issue --}}
                    <button wire:click="showIssue({{ $item->id }})"
                        class="inline-flex items-center gap-1.5 px-2 py-1 rounded bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-colors group">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span class="text-[10px] font-bold uppercase tracking-tight">Show Issue</span>
                    </button>
                </td>

                <td class="px-4 py-3">
                    @php
                        $statusClasses = [
                            'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                            'in_progress' => 'bg-blue-100 text-blue-700 border-blue-200',
                            'closed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                        ];
                    @endphp
                    <span
                        class="px-2 py-0.5 rounded-sm border text-[10px] font-bold uppercase {{ $statusClasses[$item->status] ?? 'bg-gray-100' }}">
                        {{ str_replace('_', ' ', $item->status) }}
                    </span>
                </td>

                <td class="px-4 py-3 text-slate-500">{{ $item->created_at->format('d/m/Y') }}</td>
                <td class="px-4 py-3 text-slate-500">
                    <button wire:click="editStatus({{ $item->id }})"
                        class="text-indigo-600 hover:text-indigo-900 text-xs font-semibold underline cursor-pointer">
                        Update Status
                    </button>
                </td>
                <td class="px-4 py-3 flex items-center">
                    <span wire:click="edit({{ $item->id }})"
                        class="text-indigo-600 hover:text-indigo-900 mr-2 cursor-pointer">
                        <x-edit-svg />
                    </span>
                    <span wire:click="confirm_delete({{ $item->id }})"
                        class="text-red-600 hover:text-red-900 cursor-pointer">
                        <x-delete-svg />
                    </span>
                </td>
            </tr>
        @endforeach
    </x-table-data-2>
    <div class="m-2">{{ $fillings->links() }}</div>

    {{-- MODAL 1: Update Status --}}
    <x-modal :show="$showModal" title="Update Issue Status">
        <div class="space-y-4">
            <p class="text-sm text-slate-600">
                Updating status for: <span class="font-bold text-slate-800">{{ $titleForModal }}</span>
            </p>
            <div class="my-4">
                <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                <select wire:model="newStatus"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-indigo-500">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
            <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                <button type="button" wire:click="cancelStatus"
                    class="px-4 py-2 text-xs font-medium text-slate-600">Cancel</button>
                <button type="button" wire:click="updateStatus"
                    class="px-4 py-2 text-xs font-medium text-white bg-indigo-600 rounded-sm shadow-sm">Apply
                    Changes</button>
            </div>
        </div>
    </x-modal>

    {{-- MODAL 2: Detail Issue (Read Only) --}}
    <x-modal :show="$showIssueModal" title="Issue Detail">
        <div class="space-y-2 overflow-y-auto max-h-[70vh]">
            <div>
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Title</h4>
                <p class="text-sm font-semibold text-slate-800">{{ $titleForModal }}</p>
            </div>

            <div class="p-2 bg-slate-50 border border-slate-200 rounded-sm">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Problem Description</h4>
                <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                    {{ $selectedIssueContent }}
                </p>
            </div>

            <div class="flex justify-end pt-4">
                <button type="button" wire:click="cancelIssue"
                    class="px-6 py-2 text-xs font-bold text-white bg-slate-800 hover:bg-slate-700 rounded-sm transition-colors">
                    Close
                </button>
            </div>
        </div>
    </x-modal>
</div>
