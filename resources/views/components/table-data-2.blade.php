@props([
    'headers' => [], // Array untuk judul kolom
])

<div {{ $attributes->merge(['class' => 'overflow-hidden border border-slate-200 rounded-sm']) }}>
    <table class="min-w-full divide-y divide-slate-200 text-xs">
        <thead class="bg-slate-50">
            <tr>
                @foreach ($headers as $header)
                    <th class="px-4 py-2 text-left font-semibold text-slate-600 uppercase tracking-wider">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-slate-100">
            {{ $slot }}
        </tbody>
    </table>
</div>