<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="flex-1 p-4 lg:p-6 bg-slate-50 h-screen overflow-y-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Monthly Report</h1>
        <p class="text-slate-500 text-sm">
             Record quality control parameters for all variant. Ensure all data is verified for accuracy
        </p>
    </div>

    <div class="space-y-8">
        <livewire:pages::mqm.table />
    </div>
</div>