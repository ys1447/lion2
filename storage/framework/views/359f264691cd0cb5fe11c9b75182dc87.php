<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'color' => 'indigo', // default warna indigo jika tidak diisi
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
    'color' => 'indigo', // default warna indigo jika tidak diisi
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    // Mapping warna agar lebih dinamis
    $colors = [
        'indigo' => 'bg-indigo-600 hover:bg-indigo-700',
        'emerald' => 'bg-emerald-600 hover:bg-emerald-700',
        'red' => 'bg-red-600 hover:bg-red-700',
        'slate' => 'bg-slate-600 hover:bg-slate-700',
    ];

    $selectedColor = $colors[$color] ?? $colors['indigo'];
?>

<button <?php echo e($attributes->merge([
    'type' => 'button',
    'class' => "inline-flex items-center px-4 py-2 $selectedColor text-white text-sm font-semibold rounded-sm shadow-sm transition-all active:scale-95 group"
])); ?>>
    
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($slot->isNotEmpty()): ?>
        <div class="mr-2">
            <?php echo e($slot); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <span><?php echo e($attributes->get('label')); ?></span>
</button><?php /**PATH C:\xampp\htdocs\lion2\resources\views/components/plus-svg.blade.php ENDPATH**/ ?>