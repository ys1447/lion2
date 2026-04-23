<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title', 'value', 'unit' => '', 'link' => '#']));

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

foreach (array_filter((['title', 'value', 'unit' => '', 'link' => '#']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<a href="<?php echo e($link); ?>" wire:navigate
    class="block transition-all duration-200 bg-white hover:shadow-md">
    <div class="rounded-md p-4 shadow-sm border border-slate-100 flex items-center gap-4 w-full min-w-50">

        <!-- Icon Box (Fixed size agar tidak gepeng) -->
        <div class="w-12 h-12 bg-amber-50 rounded-lg shrink-0 flex items-center justify-center text-amber-500">
            <div class="w-6 h-6">
                <?php echo e($slot); ?>

            </div>
        </div>

        <!-- Text Content (Flexible space) -->
        <div class="min-w-0 flex-1 flex flex-col justify-center">
            <p class="text-slate-500 text-[10px] uppercase font-bold truncate leading-tight tracking-tight">
                <?php echo e($title); ?>

            </p>
            <div class="flex items-baseline gap-1 mt-0.5">
                <p class="text-xl font-black text-slate-800 leading-none">
                    <?php echo e(number_format($value)); ?>

                </p>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unit): ?>
                    <span class="text-[10px] font-medium text-slate-400 whitespace-nowrap"><?php echo e($unit); ?></span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</a>
<?php /**PATH C:\xampp\htdocs\lion2\resources\views/components/stats-card.blade.php ENDPATH**/ ?>