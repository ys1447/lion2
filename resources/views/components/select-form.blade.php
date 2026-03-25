<div>
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
    @props([
        'label' => '',
        'model' => '',
        'options' => [],
    ])

    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">
            {{ $label }}
        </label>

        <select wire:model="{{ $model }}"
            
            {{ $attributes->merge([
                'class' =>
                    'mb-4 w-full px-3 py-2 text-sm border border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-indigo-500',
            ]) }}>
            <option value="">-- Select Option --</option>

            @foreach ($options as $value => $text)
                <option value="{{ $value }}">{{ $text }}</option>
            @endforeach
        </select>
    </div>

</div>
