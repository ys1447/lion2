<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['menu', 'link']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['menu', 'link']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    // Cek apakah URL saat ini mengandung 'input-data' atau sesuai dengan link
    $active = request()->is(trim($link, '/') . '*') || ($menu === 'Input Data' && request()->is('input-data*'));
?>

<a <?php echo e($link !== '#' ? 'wire:navigate' : ''); ?> <?php echo e($attributes); ?> href="<?php echo e($link); ?> "
    class="flex items-center gap-3 px-3 py-2.5 rounded-lg
    <?php echo e($active
        ? 'bg-linear-to-r from-indigo-50 via-purple-50/50 to-indigo-100 shadow-sm border-l-4 border-indigo-500 transition-all duration-300'
        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'); ?>">

    <?php echo e($slot); ?>

    <span class="font-medium text-sm whitespace-nowrap" :class="sidebarOpen ? 'opacity-100' : 'opacity-0'">
        <?php echo e($menu); ?>

    </span>
</a>
<?php /**PATH C:\xampp\htdocs\lion2\resources\views/components/aside-bar-items.blade.php ENDPATH**/ ?>