<?php

use Livewire\Component;
use App\Models\Filling;
use App\Models\Category;
use Livewire\Attributes\On;
use App\Traits\HasNotification;

new class extends Component {
    use HasNotification;
    public $category_id,
        $title,
        $issues,
        $fillingId,
        $show = false;

    #[On('edit-filling')]
    public function loadFilling($id)
    {
        $this->show = true;
        $this->fillingId = $id;

        $filling = Filling::findOrFail($id);

        $this->title = $filling->title;
        $this->category_id = $filling->category_id;
        $this->issues = $filling->issues;
    }

    public function cancel()
    {
        $this->show = false;
        $this->reset(['title', 'category_id', 'issues', 'fillingId']);
    }

    public function update()
    {
        // 1. Validasi Input
        $this->validate([
            'title' => 'required|min:3',
            'category_id' => 'required|exists:categories,id',
            'issues' => 'required|min:5',
        ]);

        $filling = Filling::findOrFail($this->fillingId);
        $fillingTitle = $filling->title;
        $filling->update([
            'title' => $this->title,
            'category_id' => $this->category_id,
            'issues' => $this->issues,
        ]);

        $this->sendNotification(
            action: 'EDIT', 
            target: 'Filling data: ' . $fillingTitle,
            details: "Edited data filling '{$fillingTitle}'"
        );

        // 3. Reset & Tutup Modal
        $this->show = false;

        // 4. Beri tahu komponen lain (Table) untuk refresh
        $this->dispatch('filling-updated');

        // 5. Kirim Notifikasi Sukses
        $this->dispatch('alert-success', message: 'Data issue berhasil diperbarui!');
    }

    public function render()
    {
        return $this->view([
            'categories' => Category::pluck('name', 'id'),
        ]);
    }
};
?>

<div>
    <x-loading wire:target='cancel, update' />
    <x-modal :show="$show">
        <form wire:submit.prevent="update">
            {{-- <x-form-input wire:model="name" label="Name" forId='name' /> --}}
            <div class="p-6 overflow-y-auto max-h-[70vh] space-y-4">
                {{-- Input Title --}}
                <div>
                    <x-form-input wire:model="title" label="Title" forId="edit_title" />
                    @error('title')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Select Category --}}
                <x-select-form label="Category" model="category_id" :options="$categories" />
                @error('category_id')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror


                {{-- Textarea Issues --}}
                <div>
                    <x-form-textarea wire:model="issues" label="Problem Description" forId="edit_issues" />
                    @error('issues')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex gap-2">
                <button type="button" wire:click="cancel"
                    class="px-4 py-2 text-sm bg-gray-200 rounded-sm hover:bg-gray-300 cursor-pointer">Cancel
                </button>
                <x-button type="submit">Update</x-button>
                </div>
            </div>
        </form>
    </x-modal>
</div>
