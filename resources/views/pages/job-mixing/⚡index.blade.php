<?php

use Livewire\Component;


new class extends Component {
    
};
?>

<div class="flex-1 p-4 lg:p-6 bg-slate-50 h-screen overflow-y-auto">
    {{-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger --}}

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Job Mixing Overview</h1>
        <p class="text-slate-500 text-sm">
            Manage job mixing, add new job, or update job information here.
        </p>
    </div>

    <div class="space-y-8">
        <livewire:pages::job-mixing.create />
        <livewire:pages::job-mixing.table />
        <livewire:pages::job-mixing.edit />
    </div>
        
</div>
