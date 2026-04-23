@props([
    'label',
    'forId' => null,
    'type' => 'text',
    'placeholder' => '',
    'error' => null
])

<div class="my-4">
    <label for="{{ $forId }}" class="block text-xs font-medium text-gray-600 mb-1">
        {{ $label }}
    </label>

    <input
        type="{{ $type }}"
        id="{{ $forId }}"
        {{ $attributes->merge([
            'class' => 'w-full px-3 py-2 text-sm border border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-indigo-500'
        ]) }}
        placeholder="{{ $placeholder }}"
    />

    @error($attributes->get('wire:model'))
        <span class="text-[10px] text-red-600 font-medium">{{ $message }}</span>
    @enderror
</div>
