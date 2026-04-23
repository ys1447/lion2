<?php

use Livewire\Component;
use App\Models\Filling;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $title = null;
    public $category_id = null;
    public $issues = null;
    public $suggestions = [];

    // Fungsi ini otomatis jalan tiap kali $title berubah
    public function updatedTitle($value)
    {
        if (strlen($value) < 2) {
            $this->suggestions = [];
            return;
        }

        // Cari title unik yang mirip dari data Filling yang sudah ada
        $this->suggestions = Filling::where('title', 'like', '%' . $value . '%')
            ->select('title')
            ->distinct()
            ->limit(5)
            ->pluck('title')
            ->toArray();
    }

    // Fungsi untuk memilih salah satu rekomendasi
    public function selectSuggestion($value)
    {
        $this->title = $value;
        $this->suggestions = []; // Kosongkan list setelah dipilih
    }

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

<div class="w-full p-6 bg-white rounded-sm shadow-sm">
    <h2 class="text-xl font-semibold mb-2 text-indigo-800">Input Issue</h2>
    <form wire:submit.prevent='save'>

        <!-- Bungkus dengan relative agar list saran muncul di bawah input -->
        <div class="relative">
            <x-form-input wire:model.live.debounce.300ms='title' label="Issue Title" class="first-input" forId='title'
                placeholder="Blocking machine ..." :error="$errors->first('title')" />

            <!-- List Rekomendasi -->
            @if (!empty($suggestions))
                <div class="absolute z-50 w-full bg-white border border-slate-200 rounded-sm shadow-lg -mt-3">
                    @foreach ($suggestions as $suggest)
                        <div wire:click="selectSuggestion('{{ $suggest }}')"
                            class="px-4 py-2 text-sm text-slate-700 hover:bg-indigo-50 cursor-pointer border-b border-slate-50 last:border-none">
                            <span class="font-medium">{{ $suggest }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <x-select-form label="Plant" model="category_id" :options="$categories" />

        <x-form-textarea wire:model="issues" label="Issue Details" forId="issues"
            placeholder="Describe the quality deviation in detail..." :error="$errors->first('issues')" rows="5" />

        <x-button type="submit"> Save Issue </x-button>
    </form>
</div>
