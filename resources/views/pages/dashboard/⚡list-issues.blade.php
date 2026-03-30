<?php

use Livewire\Component;
use App\Models\InputData;

new class extends Component {
    public function render()
    {
        $now = now();
        $time = $now->format('H:i');

        // Logika Hari Produksi (Sama seperti sebelumnya)
        $prodDate = $time < '06:00' ? $now->copy()->subDay() : $now->copy();
        $startWindow = $prodDate->copy()->setTime(6, 0, 0);
        $endWindow = $startWindow->copy()->addDay()->subSecond();

        // Ambil data hold dalam window waktu tersebut
        $listHold = InputData::with('variant', 'activeHold') //
            ->where('status', 'hold')
            ->whereBetween('created_at', [$startWindow, $endWindow])
            ->latest()
            ->get();

        return $this->view([
            'listHold' => $listHold,
        ]);
    }
};
?>

<div class="mt-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold text-slate-800 tracking-tight">Daily Hold List</h2>
        <span class="px-2 py-1 bg-amber-100 text-amber-700 text-[10px] tracking-wide font-bold rounded uppercase">
            {{ $listHold->count() }} - Items Found
        </span>
    </div>

    <x-table-data-2 :headers="['Time', 'Shift', 'Product / Info', 'Reason', 'Status']">
        @forelse ($listHold as $item)
            <tr class="hover:bg-slate-50 transition-colors">
                <!-- Time -->
                <td class="px-4 py-3 whitespace-nowrap text-slate-600 font-medium">
                    {{ $item->created_at->format('H:i') }}
                </td>

                <!-- Shift -->
                <td class="px-4 py-3 whitespace-nowrap">

                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase">
                        {{ $item->shift }}
                    </span>
                </td>

                <!-- Product Info (Asumsi ada kolom name/product) -->
                <td class="px-4 py-3 text-slate-700 font-semibold">
                    {{ $item->variant->name ?? 'N/A' }}
                    <span class="block text-[10px] font-normal text-slate-400 italic">ID:
                        #{{ $item->variant->category->name }}</span>
                </td>

                <td class="px-4 py-3 text-slate-700 font-semibold">
                    <span class="block text-[10px] font-normal text-slate-400 italic">
                        {{ Str::words($item->activeHold->reason ?? '-', 5, '...') }}
                    </span>
                </td>

                <!-- Status Badge -->
                <td class="px-4 py-3 whitespace-nowrap">
                    <span
                        class="inline-flex animate-pulse items-center gap-1.5 px-2 py-1 rounded-md bg-amber-50 text-amber-700 font-bold border border-amber-100 uppercase text-[9px]">
                        {{ $item->status }}
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-4 py-10 ">
                    <div class="flex flex-col items-center justify-center opacity-50">
                        <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 8-8-8" />
                        </svg>
                        <p class="text-sm font-medium text-slate-500 italic">No hold items for this day.</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </x-table-data-2>
</div>
