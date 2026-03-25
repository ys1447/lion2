@props([
    'type' => 'button'
])

<button
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => 'cursor-pointer w-full bg-indigo-600 text-white text-sm font-medium py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:ring-offset-1 transition-colors'
    ]) }}
>
    {{ $slot }}
</button>
