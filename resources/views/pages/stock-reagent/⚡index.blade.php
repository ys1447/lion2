<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="flex-1 p-4 lg:p-6 bg-slate-50 h-screen overflow-y-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Reagent Inventory</h1>
        <p class="text-slate-500 text-sm">
             Manage incoming stock and track real-time usage for mixing operations.
        </p>
    </div>

    <div class="space-y-8">
        <livewire:pages::stock-reagent.create />
        <livewire:pages::stock-reagent.table-log />
        <livewire:pages::stock-reagent.edit-log />
    </div>

</div>
