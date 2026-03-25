<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="flex-1 p-4 lg:p-6 bg-slate-50 h-screen overflow-y-auto">
    {{-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger --}}

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">List Hold</h1>
        <p class="text-slate-500 text-sm">
            Record and manage any technical issues or quality findings discovered during the production process.
        </p>
    </div>

    <div class="space-y-8">
        <livewire:pages::list-hold.table/>
    </div>
        
</div>