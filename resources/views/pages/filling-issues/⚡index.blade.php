<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="flex-1 p-4 lg:p-6 bg-slate-50 h-screen overflow-y-auto">
    {{-- The whole future lies in uncertainty: live immediately. - Seneca --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Report Filling Issues</h1>
        <p class="text-slate-500 text-sm">
             Log and document any filling inconsistencies for this variant. High-precision data entry is required for quality assurance.
        </p>
    </div>

    <div class="space-y-8">
        <livewire:pages::filling-issues.create/>
        <livewire:pages::filling-issues.table/>
        <livewire:pages::filling-issues.edit/>
    </div>
</div>