<?php

use Livewire\Component;
use App\Models\Filling;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $title = null;
    public $category_id = null;
    public $issues = null;

    public function mount()
    {
        $this->dispatch('focus-input');
    }

    public function save()
    {
        // 1. Validasi Input
        $validated = $this->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|min:5|max:255',
            'issues' => 'required|string|min:10',
        ]);

        // 2. Simpan ke Database
        Filling::create([
            'category_id' => $this->category_id,
            'user_id' => auth()->user()->getAttributes()['id'], // Mengambil ID user yang sedang login
            'title' => $this->title,
            'issues' => $this->issues,
            'status' => 'pending', // Default status sesuai migration
        ]);

        // 3. Reset Form (Opsional)
        $this->reset(['category_id', 'title', 'issues']);

        $this->dispatch('alert-success', message: 'Issue has been created!');
        $this->dispatch('filling-added');
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
    <x-loading wire:target="save" />
    <div class="w-full p-6 bg-white rounded-sm shadow-sm">
        <h2 class="text-xl font-semibold mb-2 text-indigo-800">Input Issue</h2>
        <form wire:submit.prevent='save'>
            <x-form-input wire:model='title' label="Issue Title" class="first-input" forId='title'
                placeholder="Blocking machine ..." :error="$errors->first('totle')" />
            <x-select-form label="Plant" model="category_id" :options="$categories" />
            <x-form-textarea wire:model="issues" label="Issue Details" forId="issues"
                placeholder="Describe the quality deviation in detail..." :error="$errors->first('issues')" rows="5" />
            <x-button type="submit"> Save Issue </x-button>
        </form>
    </div>
</div>
