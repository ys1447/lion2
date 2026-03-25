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

    @if ($error)
        <p class="text-red-500 text-xs mt-1">{{ $error }}</p>
    @endif
</div>
