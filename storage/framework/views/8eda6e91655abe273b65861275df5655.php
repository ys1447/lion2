<?php
use Livewire\Component;
?>

<div class="flex-1 p-4 lg:p-6 bg-slate-50 h-screen overflow-y-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Monthly Report</h1>
        <p class="text-slate-500 text-sm">
             Record quality control parameters for all variant. Ensure all data is verified for accuracy
        </p>
    </div>

    <div class="space-y-8">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pages::mqm.table', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3459141656-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
    </div>
</div><?php /**PATH C:\xampp\htdocs\lion2\storage\framework/views/livewire/views/1c181f3e.blade.php ENDPATH**/ ?>