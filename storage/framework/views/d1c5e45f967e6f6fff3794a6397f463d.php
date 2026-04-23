<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'placeholder' => 'Search...',
    'model' => 'search', // default wire:model
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
    'placeholder' => 'Search...',
    'model' => 'search', // default wire:model
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div <?php echo e($attributes->merge(['class' => 'relative w-full'])); ?>>
    
    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
            </path>
        </svg>
    </span>

    
    <input 
        type="text" 
        wire:model.live.debounce.500ms="<?php echo e($model); ?>" 
        placeholder="<?php echo e($placeholder); ?>" 
        class="w-full my-2 pl-10 pr-4 py-2 text-sm border border-slate-300 rounded-sm 
               focus:border-blue-400 focus:ring-1 focus:ring-blue-100 outline-none 
               transition duration-150 placeholder:text-slate-400 bg-white"
    >
</div><?php /**PATH C:\xampp\htdocs\lion2\resources\views/components/search.blade.php ENDPATH**/ ?>