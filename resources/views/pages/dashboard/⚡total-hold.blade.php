<?php

use Livewire\Component;
use App\Models\InputData;
use App\Models\ReworkLog;

new class extends Component {
    public function render()
    {
        return $this->view([
            'totalHold' => InputData::where('status', 'hold')->count(),
            'totalActiveRework' => ReworkLog::where('status', 'active')->count(),
        ]);
    }
};
?>

<div class="flex gap-2">

    <!-- Card Hold -->
    <x-stats-card title="Lifetime Hold Total" :value="$totalHold" unit="Lots" link="/list-hold">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </x-stats-card>

    <!-- Card Rework -->
    <x-stats-card title="Active Rework" :value="$totalActiveRework" unit="Units" link="/list-remix">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
    </x-stats-card>

</div>
