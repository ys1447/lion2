<div>
    <?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
        'title' => null,
        'head' => null
    ]));

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

foreach (array_filter(([
        'title' => null,
        'head' => null
    ]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

    <div class="bg-white rounded-sm border border-slate-200 overflow-hidden">
        <!-- Header Card -->
        <div
            class="px-5 py-3 border-b border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 bg-linear-to-r from-slate-700 to-slate-600">
            <h3 class="font-semibold text-white"><?php echo e($title); ?></h3>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-separate border-spacing-0">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs border-b border-slate-200">
                    <tr>
                        <?php echo e($head); ?>

                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php echo e($slot); ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\lion2\resources\views/components/data-table.blade.php ENDPATH**/ ?>