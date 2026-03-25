<?php

use Livewire\Component;
use App\Models\Variant;

new class extends Component {
    public $search = '';
    public $showDropdown = false;

    public function getVariantsProperty()
    {
        if (strlen($this->search) < 2) {
            return collect();
        }

        return Variant::where('name', 'like', "%{$this->search}%")
            ->orderBy('name')
            ->limit(10)
            ->get();
    }

    public function selectVariant($slug)
    {
        $this->search = '';
        $this->showDropdown = false;

        return $this->redirect('/input-data/' . $slug, navigate: true);
    }
};
?>

<div class="hidden sm:flex items-center" x-data="{
    highlight: -1,
    show: @entangle('showDropdown'),

    get count() {
        return $el.querySelectorAll('.variant-item').length;
    },

    moveDown() {
        if (this.highlight < this.count - 1) {
            this.highlight++;
            this.scrollToActive();
        }
    },

    moveUp() {
        if (this.highlight > 0) {
            this.highlight--;
            this.scrollToActive();
        }
    },

    scrollToActive() {
        let activeEl = $el.querySelector(`.variant-item[data-index='${this.highlight}']`);
        if (activeEl) {
            activeEl.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
        }
    },

    select() {
        // Jika belum ada yang di-highlight (masih -1), 
        // opsional: bisa pilih item pertama (0) atau abaikan
        if (this.highlight === -1 && this.count > 0) {
            this.highlight = 0;
        }

        let selected = $el.querySelector(`.variant-item[data-index='${this.highlight}']`);
        if (selected) {
            let slug = selected.getAttribute('data-slug');
            $wire.selectVariant(slug);
        }
    }
}"
    @focus-search.window="setTimeout(() => $refs.searchInput.focus(), 100)"
    @keydown.window.ctrl.k.prevent="$refs.searchInput.focus()" @click.away="show = false" {{-- Reset highlight ke -1 setiap kali user mengetik ulang --}}
    x-init="$watch('$wire.search', () => highlight = -1)">

    <div class="relative w-64 lg:w-80">
        <input x-ref="searchInput" type="text" wire:model.live.debounce.400ms="search" @focus="show = true"
            {{-- Class 'search-input-focus' untuk bypass script global layout --}} {{-- Class 'no-arrow-nav' untuk dikecualikan dari array navigasi --}}
            class="search-input-focus no-arrow-nav w-full border border-slate-200 rounded-sm pl-3 pr-10 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50 transition-all"
            @keydown.arrow-down.stop.prevent="moveDown()" @keydown.arrow-up.stop.prevent="moveUp()"
            @keydown.enter.stop.prevent="select()" @keydown.escape.stop="show = false" placeholder="Search variant..."
            autocomplete="off">

        <div x-show="show && $wire.search.length >= 2" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-cloak
            class="absolute w-full bg-white border border-slate-200 shadow-xl z-99 max-h-60 overflow-y-auto mt-2 rounded">

            @forelse($this->variants as $index => $variant)
                <div data-index="{{ $index }}" data-slug="{{ $variant->slug }}"
                    @mouseover="highlight = {{ $index }}" @click="$wire.selectVariant('{{ $variant->slug }}')"
                    {{-- Gunakan style inline untuk memaksa warna background --}}
                    :style="highlight === {{ $index }} ?
                        'background-color: #4f46e5 !important; color: white !important;' :
                        'background-color: white !important; color: #0f172a !important;'"
                    class="variant-item px-4 py-2 cursor-pointer text-sm flex flex-col focus:outline-none border-b border-slate-50 last:border-0">

                    <span class="font-medium block" style="color: inherit;">
                        {{ $variant->name }}
                    </span>

                    <span class="text-[10px] block"
                        :style="highlight === {{ $index }} ? 'color: #e0e7ff !important;' : 'color: #64748b !important;'">
                        /{{ $variant->slug }}
                    </span>
                </div>
            @empty
                <div class="px-4 py-3 text-slate-500 text-sm text-center italic bg-white">
                    Data not found...
                </div>
            @endforelse

        </div>

        <div wire:loading wire:target="search" class="absolute right-3 top-2">
            <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </div>
    </div>
</div>
