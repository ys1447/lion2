<?php

use Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('List Notification')] class extends Component
{
    //
};
?>

<div class="flex-1 bg-slate-50 overflow-y-auto">
    <livewire:pages::list-notification.table/>
</div>