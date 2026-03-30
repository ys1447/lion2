<?php

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

new class extends Component {
    public function render()
    {
        $currentYear = now()->year;
        $driver = DB::connection()->getDriverName();

        // 1. Definisikan Logic Time Shift sesuai Driver Database
        $timeShift = $driver === 'sqlite' ? "datetime(created_at, '-6 hours')" : 'DATE_SUB(created_at, INTERVAL 6 HOUR)';

        $categories = Category::with([
            'variants' => function ($query) use ($currentYear, $timeShift) {
                // Kita kumpulkan semua count dalam satu pemanggilan withCount agar lebih performant
                $counts = [];

                for ($m = 1; $m <= 12; $m++) {
                    $monthStr = str_pad($m, 2, '0', STR_PAD_LEFT);

                    // Definisi Count untuk Total, Hold, dan Rework per Bulan
                    $counts["inputDatas as month_{$m}_count"] = function ($q) use ($currentYear, $monthStr, $timeShift) {
                        $q->whereRaw("strftime('%Y', $timeShift) = ?", [(string) $currentYear])->whereRaw("strftime('%m', $timeShift) = ?", [$monthStr]);
                    };

                    $counts["inputDatas as month_{$m}_hold"] = function ($q) use ($currentYear, $monthStr, $timeShift) {
                        $q->whereRaw("strftime('%Y', $timeShift) = ?", [(string) $currentYear])
                            ->whereRaw("strftime('%m', $timeShift) = ?", [$monthStr])
                            ->where('status', 'hold');
                    };

                    $counts["inputDatas as month_{$m}_rework"] = function ($q) use ($currentYear, $monthStr, $timeShift) {
                        $q->whereRaw("strftime('%Y', $timeShift) = ?", [(string) $currentYear])
                            ->whereRaw("strftime('%m', $timeShift) = ?", [$monthStr])
                            ->where('status', 'rework');
                    };
                }

                // Eksekusi semua count sekaligus
                $query->withCount($counts);
            },
        ])->get();

        return $this->view([
            'categories' => $categories,
            'months' => [
                1 => 'Jan',
                2 => 'Feb',
                3 => 'Mar',
                4 => 'Apr',
                5 => 'May',
                6 => 'Jun',
                7 => 'Jul',
                8 => 'Aug',
                9 => 'Sep',
                10 => 'Oct',
                11 => 'Nov',
                12 => 'Dec',
            ],
        ]);
    }
};
?>

<div>
    <x-table-data-2 :headers="array_merge(['Category', 'Variant'], $months, ['Release Rate Year'])">
        @foreach ($categories as $category)
            @php
                $variants = $category->variants;
                $variantCount = $variants->count();

                $catTotalBatch = array_fill(1, 12, 0);
                $catTotalHold = array_fill(1, 12, 0);
                $catTotalRework = array_fill(1, 12, 0);

                // Tentukan rowspan: Jika ada varian, rowspan = jumlah varian + 1 (untuk baris total)
                // Jika tidak ada varian, rowspan = 1 (hanya baris total saja)
                $rowSpanValue = $variantCount > 0 ? $variantCount + 1 : 1;
            @endphp

            {{-- 1. Loop Varian (Hanya jalan jika ada varian) --}}
            @forelse ($variants as $index => $variant)
                <tr class="hover:bg-slate-50 transition-colors">
                    {{-- Nama Kategori muncul di index 0 --}}
                    @if ($index === 0)
                        <td class="px-4 py-2 font-bold text-slate-700 align-middle text-center border border-slate-300 bg-white"
                            rowspan="{{ $rowSpanValue }}">
                            {{ $category->name }}
                        </td>
                    @endif

                    <td class="px-4 py-2 text-slate-600 border-r italic text-[11px] border-b border-slate-100">
                        {{ $variant->name }}
                    </td>

                    @php
                        $varYearBatch = 0;
                        $varYearIssue = 0;
                    @endphp

                    @foreach (range(1, 12) as $m)
                        @php
                            $total = $variant->{"month_{$m}_count"} ?? 0;
                            $hold = $variant->{"month_{$m}_hold"} ?? 0;
                            $rework = $variant->{"month_{$m}_rework"} ?? 0;

                            $varYearBatch += $total;
                            $varYearIssue += $hold + $rework;

                            $catTotalBatch[$m] += $total;
                            $catTotalHold[$m] += $hold;
                            $catTotalRework[$m] += $rework;
                        @endphp
                        <td class="px-2 py-1 text-center border-r border-b border-slate-100">
                            @if ($total > 0)
                                <div class="text-[11px] font-bold text-slate-800">{{ $total }}</div>
                                <div class="flex justify-center gap-1 mt-1">
                                    @if ($hold > 0)
                                        <span
                                            class="px-1 text-[9px] bg-amber-100 text-amber-700 rounded">H:{{ $hold }}</span>
                                    @endif
                                    @if ($rework > 0)
                                        <span
                                            class="px-1 text-[9px] bg-rose-100 text-rose-700 rounded">R:{{ $rework }}</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-slate-300">-</span>
                            @endif
                        </td>
                    @endforeach

                    <td class="px-4 py-2 text-center bg-slate-50 border-b border-slate-100">
                        @php
                            $released = $varYearBatch - $varYearIssue;
                            $percentage = $varYearBatch > 0 ? ($released / $varYearBatch) * 100 : 0;
                            $color =
                                $percentage >= 90
                                    ? 'text-green-600'
                                    : ($percentage >= 75
                                        ? 'text-amber-600'
                                        : 'text-red-600');
                        @endphp
                        <div class="text-xs font-bold {{ $color }}">{{ number_format($percentage, 1) }}%</div>
                        <div class="text-[10px] text-slate-400">({{ $released }}/{{ $varYearBatch }})</div>
                    </td>
                </tr>
            @empty
                {{-- Bagian ini kosong karena Category Name akan dirender di baris TOTAL di bawah jika varian 0 --}}
            @endforelse

            {{-- 2. Baris TOTAL per Kategori --}}
            <tr class="bg-slate-800 text-white font-semibold">
                {{-- JIKA tidak ada varian, render Category Name di sini --}}
                @if ($variantCount === 0)
                    <td class="px-4 py-2 font-bold text-slate-700 bg-white align-middle text-center border border-slate-300">
                        {{ $category->name }}
                    </td>
                @endif

                <td class="px-4 py-2 text-[10px] uppercase tracking-wider border-r border-slate-700">
                    TOTAL {{ $category->name }}
                </td>

                @php
                    $catYearTotal = 0;
                    $catYearIssue = 0;
                @endphp
                @foreach (range(1, 12) as $m)
                    <td class="px-2 py-1 text-center border-r border-slate-700">
                        <div class="text-[11px]">{{ $catTotalBatch[$m] }}</div>
                        <div class="flex justify-center gap-1 text-[8px]">
                            @if ($catTotalHold[$m] > 0)
                                <span class="text-amber-400">H:{{ $catTotalHold[$m] }}</span>
                            @endif
                            @if ($catTotalRework[$m] > 0)
                                <span class="text-rose-400">R:{{ $catTotalRework[$m] }}</span>
                            @endif
                        </div>
                    </td>
                    @php
                        $catYearTotal += $catTotalBatch[$m];
                        $catYearIssue += $catTotalHold[$m] + $catTotalRework[$m];
                    @endphp
                @endforeach

                <td class="px-4 py-2 text-center bg-slate-900">
                    @php
                        $catRel = $catYearTotal - $catYearIssue;
                        $catPerc = $catYearTotal > 0 ? ($catRel / $catYearTotal) * 100 : 0;
                    @endphp
                    <div class="text-xs">{{ number_format($catPerc, 1) }}%</div>
                    <div class="text-[9px] text-slate-400">Avg. Release</div>
                </td>
            </tr>
        @endforeach
    </x-table-data-2>
</div>
