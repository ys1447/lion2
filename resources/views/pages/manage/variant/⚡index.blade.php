<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div>
    {{-- Let all your things have their places; let each part of your business have its time. - Benjamin Franklin --}}
    <div class="flex gap-4 items-start">
        <div class="flex-1 p-6 bg-white rounded-sm shadow-sm">
            <livewire:pages::manage.variant.create />
            <livewire:pages::manage.variant.edit />
        </div>
        
    </div>
</div>
