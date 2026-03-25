<div {{ $attributes->merge([
    'class' => 'fixed inset-0 z-100 flex items-center justify-center bg-black/40',
]) }}
    wire:loading.flex {{ $attributes->get('wire:target') ? 'wire:target=' . $attributes->get('wire:target') : '' }}>
    <div class="w-8 h-8 border-8 border-white border-t-transparent rounded-full animate-spin"></div>
</div>
