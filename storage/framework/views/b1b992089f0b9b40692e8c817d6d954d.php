<?php
use Livewire\Component;
?>

<div class="flex-1 p-4 lg:p-6 bg-slate-50 h-screen overflow-y-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Users Overview</h1>
        <p class="text-slate-500 text-sm">
            Manage data, add new users, or update profile information here.
        </p>
    </div>

    <!-- Tab Content -->
    <div class="mt-6 flex flex-col md:flex-row items-start gap-6">

    <!-- Left Section: Add User -->
    <div class="w-full md:w-1/3 p-6 bg-white rounded-sm shadow-sm">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pages::users.create', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2035642444-0', $__key);

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

    <!-- Right Section: User List -->
    <div class="w-full md:w-2/3 p-6 bg-white rounded-sm shadow-sm border border-gray-200">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">List Users</h2>
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pages::users.table', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2035642444-1', $__key);

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

    
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pages::users.edit', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2035642444-2', $__key);

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
</div><?php /**PATH C:\xampp\htdocs\lion2\storage\framework/views/livewire/views/a8968dca.blade.php ENDPATH**/ ?>