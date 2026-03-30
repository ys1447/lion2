<?php

use Livewire\Component;
use App\Models\Filling;

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
        $fillings = Filling::with('user', 'category') //
            ->latest()
            ->whereBetween('created_at', [$startWindow, $endWindow])
            ->get();

        return $this->view([
            'fillings' => $fillings,
        ]);
    }
};
?>

<div class="mt-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold text-slate-800 tracking-tight">Daily Filling Issues</h2>
        <span class="px-2 py-1 bg-amber-100 text-amber-700 text-[10px] tracking-wide font-bold rounded uppercase">
            {{ $fillings->count() }} - Items Found
        </span>
    </div>

    <x-table-data-2 :headers="['Time', 'Title', 'Category', 'Status']">
        @forelse ($fillings as $item)
            <tr class="hover:bg-slate-50 transition-colors">
                <!-- Time -->
                <td class="px-4 py-3 whitespace-nowrap text-slate-600 font-medium">
                    {{ $item->created_at->format('H:i') }}
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-slate-600 font-medium">
                    {{ $item->title }}
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-slate-600 font-medium">
                    {{ $item->category->name }}
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                    @php
                        $statusMap = [
                            'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                            'in_progress' => 'bg-blue-100 text-blue-700 border-blue-200',
                            'closed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                        ];

                        $statusLabel = [
                            'pending' => 'Pending',
                            'in_progress' => 'In Progress',
                            'closed' => 'Closed',
                        ];

                        $currentClass = $statusMap[$item->status] ?? 'bg-slate-100 text-slate-600 border-slate-200';
                    @endphp

                    {{-- Gunakan variabel $currentClass di sini --}}
                    <span class="px-2 py-1 rounded-sm border text-[10px] font-bold uppercase {{ $currentClass }}">
                        {{ $statusLabel[$item->status] ?? $item->status }}
                    </span>
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="4" class="px-4 py-10 ">
                    <div class="flex flex-col items-center justify-center opacity-50">
                        <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 8-8-8" />
                        </svg>
                        <p class="text-sm font-medium text-slate-500 italic">No issues for this day.</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </x-table-data-2>
</div>
