<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label',
    'forId' => null,
    'placeholder' => '',
    'error' => null,
    'rows' => 3
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
    'label',
    'forId' => null,
    'placeholder' => '',
    'error' => null,
    'rows' => 3
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="my-4">
    <label for="<?php echo e($forId); ?>" class="block text-xs font-medium text-gray-600 mb-1">
        <?php echo e($label); ?>

    </label>

    <textarea
        id="<?php echo e($forId); ?>"
        rows="<?php echo e($rows); ?>"
        <?php echo e($attributes->merge([
            'class' => 'w-full px-3 py-2 text-sm border border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-indigo-500' . ($error ? ' border-red-500' : '')
        ])); ?>

        placeholder="<?php echo e($placeholder); ?>"
    ></textarea>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($error): ?>
        <p class="text-red-500 text-xs mt-1"><?php echo e($error); ?></p>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH C:\xampp\htdocs\lion2\resources\views/components/form-textarea.blade.php ENDPATH**/ ?>