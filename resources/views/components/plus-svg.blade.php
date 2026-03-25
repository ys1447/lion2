@props([
    'color' => 'indigo', // default warna indigo jika tidak diisi
])

@php
    // Mapping warna agar lebih dinamis
    $colors = [
        'indigo' => 'bg-indigo-600 hover:bg-indigo-700',
        'emerald' => 'bg-emerald-600 hover:bg-emerald-700',
        'red' => 'bg-red-600 hover:bg-red-700',
        'slate' => 'bg-slate-600 hover:bg-slate-700',
    ];

    $selectedColor = $colors[$color] ?? $colors['indigo'];
@endphp

<button {{ $attributes->merge([
    'type' => 'button',
    'class' => "inline-flex items-center px-4 py-2 $selectedColor text-white text-sm font-semibold rounded-sm shadow-sm transition-all active:scale-95 group"
]) }}>
    
    {{-- Slot untuk Icon (Opsional) --}}
    @if ($slot->isNotEmpty())
        <div class="mr-2">
            {{ $slot }}
        </div>
    @endif

    {{-- Label Tombol --}}
    <span>{{ $attributes->get('label') }}</span>
</button>