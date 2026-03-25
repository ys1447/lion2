<?php

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Variant;
use App\Models\Category;

new class extends Component {
    public $name;
    public $category_id;
    public $capacity;

    protected $listeners = ['category-added' => '$refresh'];

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'category_id' => 'required',
            'capacity' => 'required',
        ]);

        Variant::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'category_id' => $this->category_id,
            'capacity' => $this->capacity,
        ]);

        $this->reset();
        $this->dispatch('variant-added');
        $this->dispatch('alert-success', message: 'Variant has been created!');
    }

    public function render()
    {
        return $this->view([
            'categories' => Category::pluck('name', 'id'), // 🔥 ini penting
        ]);
    }
};
?>

<div>
    <h2 class="text-xl font-semibold mb-2 text-indigo-800">Create Variant</h2>
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
        <x-form-input wire:model='name' label="Variant Name" class="first-input" forId='name' placeholder="Jeruk Nipis 13T"
            :error="$errors->first('name')" />
        <x-form-input wire:model='capacity' label="Capacity" forId='capacity' placeholder="13000"
            :error="$errors->first('capacity')" />
        <x-select-form label="Category" model="category_id" :options="$categories" />

        <x-button type="submit"> Create New Variant </x-button>
    </form>
</div>
