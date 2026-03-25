<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div class="overflow-y-auto">
    <div class="p-4 lg:p-6">
        <h1 class="text-2xl font-bold text-slate-800">Manage Data</h1>
        <p class="text-slate-500 text-sm">
            Manage categories, variants, and machines used in the system.
        </p>
    </div>

    <div class="p-4 lg:p-6 flex gap-4 items-start">
        <div class="flex-1">
            <livewire:pages::manage.category.index />
        </div>

        <div class="flex-1">
            <livewire:pages::manage.variant.index />
        </div>

        <div class="flex-1">
            <livewire:pages::manage.machine.index />
        </div>
    </div>

    <div class="p-6">
        <livewire:pages::manage.category.table />
    </div>

    <div class="p-6">
        <livewire:pages::manage.variant.table />
    </div>

    <div class="p-6">
        <livewire:pages::manage.machine.table />
    </div>

</div>
