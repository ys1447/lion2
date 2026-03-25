@props(['menu', 'link'])

@php
    // Cek apakah URL saat ini mengandung 'input-data' atau sesuai dengan link
    $active = request()->is(trim($link, '/') . '*') || ($menu === 'Input Data' && request()->is('input-data*'));
@endphp

<a {{ $link !== '#' ? 'wire:navigate' : '' }} {{ $attributes }} href="{{ $link }}"
    class="flex items-center gap-3 px-3 py-2.5 rounded-lg
    {{ $active
        ? 'bg-linear-to-r from-indigo-50 via-purple-50/50 to-indigo-100 shadow-sm border-l-4 border-indigo-500 transition-all duration-300'
        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

    {{ $slot }}
    <span class="font-medium text-sm whitespace-nowrap" :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">
        {{ $menu }}
    </span>
</a>
