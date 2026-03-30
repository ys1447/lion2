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
            ])->get(),
        ]);
    }
};
?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach ($categories as $category)
        {{-- Very little is needed to make a happy life. - Marcus Aurelius --}}
        <div
            class="bg-white rounded-md p-4 shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div>
                <p class="text-slate-500 text-xs uppercase font-semibold">Daily Mixing {{ $category->name }}</p>
                <p class="text-xl font-bold text-slate-800">{{ number_format($category->total_today) }}</p>
            </div>
        </div>
    @endforeach
</div>
