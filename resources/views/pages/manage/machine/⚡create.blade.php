<?php

use Livewire\Component;
use App\Models\Machine;
use App\Models\Category;


new class extends Component {

    public $name;
    public $category_id;

    protected $listeners = ['category-added' => '$refresh'];

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'category_id' => 'required',
        ]);

        Machine::create([
            'name' => $this->name,
            'category_id' => $this->category_id,
        ]);

        $this->reset();
        $this->dispatch('machine-added');
        $this->dispatch('alert-success', message: 'Variant has been created!');
    }

    public function render(){
        return $this->view([
            'categories' => Category::pluck('name', 'id'),
        ]);
    }
};
?>

<div>
    <h2 class="text-xl font-semibold mb-2 text-indigo-800">Create Machine</h2>
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
        <x-form-input wire:model='name' label="Machine Name" class="first-input" forId='name' placeholder="401"
            :error="$errors->first('name')" />
        <x-select-form label="Category" model="category_id" :options="$categories" />
        <x-button type="submit"> Create New Machine </x-button>
    </form>
</div>
