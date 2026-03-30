@props([
    'label' => null,
    'model' => 'filterStatus',
])

<div {{ $attributes->merge(['class' => 'relative w-1/4']) }}>
    {{-- Ikon Filter/Dropdown --}}
    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
            </path>
        </svg>
    </span>

    {{-- Select Field --}}
    <select 
        wire:model.live="{{ $model }}" 
        class="w-full my-2 pl-10 pr-8 py-2 text-sm border border-slate-300 rounded-sm 
               appearance-none focus:border-blue-400 focus:ring-1 focus:ring-blue-100 outline-none 
               transition duration-150 text-slate-600 bg-white cursor-pointer"
    >
        {{ $slot }}
    </select>

    {{-- Ikon Panah Kecil (Custom Arrow) --}}
    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </div>
</div>