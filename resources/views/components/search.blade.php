@props([
    'placeholder' => 'Search...',
    'model' => 'search', // default wire:model
])

<div {{ $attributes->merge(['class' => 'relative w-full']) }}>
    {{-- Ikon Kaca Pembesar --}}
    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
            </path>
        </svg>
    </span>

    {{-- Input Field --}}
    <input 
        type="text" 
        wire:model.live.debounce.500ms="{{ $model }}" 
        placeholder="{{ $placeholder }}" 
        class="w-full my-2 pl-10 pr-4 py-2 text-sm border border-slate-300 rounded-sm 
               focus:border-blue-400 focus:ring-1 focus:ring-blue-100 outline-none 
               transition duration-150 placeholder:text-slate-400 bg-white"
    >
</div>