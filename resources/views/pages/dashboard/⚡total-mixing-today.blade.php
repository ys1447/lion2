<?php

use Livewire\Component;
use App\Models\Category;

new class extends Component {
    public function render()
    {
        $now = now();
        $time = $now->format('H:i');

        // LOGIKA HARI PRODUKSI:
        // Jika jam 00:00 - 05:59, maka dianggap Produksi Hari Kemarin
        $prodDate = $time < '06:00' ? $now->copy()->subDay() : $now->copy();

        // Tentukan Range Waktu Produksi (06:00:00 s/d 05:59:59 besoknya)
        $startWindow = $prodDate->copy()->setTime(6, 0, 0);
        $endWindow = $startWindow->copy()->addDay()->subSecond();

        return $this->view([
            'categories' => Category::withCount([
                'inputDatas as total_today' => function ($query) use ($startWindow, $endWindow) {
                    $query->whereBetween('input_data.created_at', [$startWindow, $endWindow]);
                },
                // TOTAL TRIAL
                'inputDatas as total_trial' => function ($query) use ($startWindow, $endWindow) {
                    $query->whereBetween('input_data.created_at', [$startWindow, $endWindow])->whereHas('jobMixing', function ($q) {
                        $q->where('type', true);
                    });
                },

                // TOTAL TERKENDALI
                'inputDatas as total_terkendali' => function ($query) use ($startWindow, $endWindow) {
                    $query->whereBetween('input_data.created_at', [$startWindow, $endWindow])->whereHas('jobMixing', function ($q) {
                        $q->where('type', false);
                    });
                },
            ])->get(),
        ]);
    }
};
?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach ($categories as $category)
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200 hover:shadow-md transition-all">
            <!-- Header: Icon & Title -->
            <div class="flex items-center gap-4 mb-4">
                <div class="shrink-0 w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-slate-500 text-[10px] uppercase font-bold tracking-wider leading-none mb-1">Daily Mixing</p>
                    <h3 class="text-slate-800 font-bold leading-none truncate w-32" title="{{ $category->name }}">{{ $category->name }}</h3>
                </div>
            </div>

            <!-- Main Number -->
            <div class="mb-4">
                <p class="text-3xl font-black text-slate-900 leading-none">
                    {{ number_format($category->total_today) }}
                </p>
                <p class="text-xs text-slate-400 mt-1 font-medium italic">Total batch hari ini</p>
            </div>

            <!-- Footer Stats (Trial & Terkendali) -->
            <div class="grid grid-cols-2 gap-2 pt-4 border-t border-slate-100">
                <div class="bg-amber-50 rounded-md p-2">
                    <p class="text-[9px] uppercase font-bold text-amber-600 opacity-80">Trial</p>
                    <p class="text-sm font-bold text-amber-700">{{ number_format($category->total_trial) }}</p>
                </div>
                <div class="bg-emerald-50 rounded-md p-2">
                    <p class="text-[9px] uppercase font-bold text-emerald-600 opacity-80">Terkendali</p>
                    <p class="text-sm font-bold text-emerald-700">{{ number_format($category->total_terkendali) }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
