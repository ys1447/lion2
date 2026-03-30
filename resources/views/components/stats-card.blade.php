@props(['title', 'value', 'unit' => '', 'link' => '#'])

<a href="{{ $link }}" wire:navigate
    class="block transition-all duration-200 bg-white hover:shadow-md">
    <div class="rounded-md p-4 shadow-sm border border-slate-100 flex items-center gap-4 w-full min-w-50">

        <!-- Icon Box (Fixed size agar tidak gepeng) -->
        <div class="w-12 h-12 bg-amber-50 rounded-lg shrink-0 flex items-center justify-center text-amber-500">
            <div class="w-6 h-6">
                {{ $slot }}
            </div>
        </div>

        <!-- Text Content (Flexible space) -->
        <div class="min-w-0 flex-1 flex flex-col justify-center">
            <p class="text-slate-500 text-[10px] uppercase font-bold truncate leading-tight tracking-tight">
                {{ $title }}
            </p>
            <div class="flex items-baseline gap-1 mt-0.5">
                <p class="text-xl font-black text-slate-800 leading-none">
                    {{ number_format($value) }}
                </p>
                @if ($unit)
                    <span class="text-[10px] font-medium text-slate-400 whitespace-nowrap">{{ $unit }}</span>
                @endif
            </div>
        </div>
    </div>
</a>
