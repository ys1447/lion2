<?php

use Livewire\Component;
use App\Models\Category;

new class extends Component {
    public function mount()
    {
        $this->dispatch('focus-input');
    }

    public $name;
    public function save()
    {
        $this->validate([
            'name' => 'required',
        ]);

        Category::create([
            'name' => $this->name,
        ]);

        $this->reset();
        $this->dispatch('category-added');
        $this->dispatch('alert-success', message: 'Category has been created!');
        $this->dispatch('focus-input');
    }
};
?>

<div>
    <h2 class="text-xl font-semibold mb-2 text-indigo-800">Create Category</h2>
    <form wire:submit.prevent='save'>
        @if ($errors->any())
            <div class="mb-4 p-3 text-sm text-red-700 bg-red-100 border border-red-300 rounded-sm">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <x-form-input wire:model='name' label="Category Name" class="first-input" forId='name' placeholder="Dishwashing"
            :error="$errors->first('name')" />
        <x-button type="submit"> Create New Category </x-button>
    </form>
</div>
