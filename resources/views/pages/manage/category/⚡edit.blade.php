<?php

use Livewire\Component;
use App\Models\Category;
use App\Traits\HasNotification;

new class extends Component {
    use HasNotification;
    public $categoryId,
        $name,
        $show = false;

    protected $listeners = ['edit-category' => 'loadCategory'];

    public function loadCategory($id)
    {
        $this->show = true;
        $this->categoryId = $id;

        $category = Category::findOrFail($id);

        $this->name = $category->name;
    }

    public function cancel()
    {
        $this->show = false;
    }

    public function update(){
        $this->validate([
            'name' => 'required',
        ]);

        $category = Category::find($this->categoryId);
        $oldName = $category->name;
        $categoryName = $this->name;
        $category->update([
            'name' => $this->name,
        ]);

        $this->sendNotification(
            action: 'EDIT', 
            target: 'Category: ' . $categoryName,
            details: "Changed category from '{$oldName}' to '{$categoryName}'"
        );

        $this->dispatch('category-updated');
        $this->dispatch('alert-success', message: 'Data berhasil diedit');
        $this->show = false;
    }
};
?>

<div>
    {{-- Waste no more time arguing what a good man should be, be one. - Marcus Aurelius --}}
    <x-modal :show="$show">

        <form wire:submit.prevent="update">
            <x-form-input wire:model="name" label="Name" forId='name' />
            <div class="flex justify-end gap-2">
                <button type="button" wire:click="cancel"
                    class="px-4 py-2 text-sm bg-gray-200 rounded-sm hover:bg-gray-300 cursor-pointer">Cancel</button>

                <x-button type="submit">Update</x-button>
            </div>
        </form>
    </x-modal>
</div>
