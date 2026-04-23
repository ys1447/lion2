<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'fromModel' => 'fromDate',
    'toModel' => 'toDate',
    'label' => null
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
    'fromModel' => 'fromDate',
    'toModel' => 'toDate',
    'label' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div <?php echo e($attributes->merge(['class' => 'flex items-center gap-2'])); ?>>
    
    <div class="relative w-full">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </span>
        <input 
            type="date" 
            wire:model.live="<?php echo e($fromModel); ?>"
            class="w-full pl-10 pr-3 py-2 text-xs border border-slate-300 rounded-sm focus:border-blue-400 focus:ring-1 focus:ring-blue-100 outline-none transition duration-150 bg-white text-slate-600"
        >
    </div>

    <span class="text-slate-400 text-xs font-bold px-1">s/d</span>

    
    <div class="relative w-full">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </span>
        <input 
            type="date" 
            wire:model.live="<?php echo e($toModel); ?>"
            class="w-full pl-10 pr-3 py-2 text-xs border border-slate-300 rounded-sm focus:border-blue-400 focus:ring-1 focus:ring-blue-100 outline-none transition duration-150 bg-white text-slate-600"
        >
    </div>
</div><?php /**PATH C:\xampp\htdocs\lion2\resources\views/components/range.blade.php ENDPATH**/ ?>