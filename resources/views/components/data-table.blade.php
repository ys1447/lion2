<div>
    @props([
        'title' => null,
        'head' => null
    ])

    <div class="bg-white rounded-sm border border-slate-200 overflow-hidden">
        <!-- Header Card -->
        <div
            class="px-5 py-3 border-b border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 bg-linear-to-r from-slate-700 to-slate-600">
            <h3 class="font-semibold text-white">{{ $title }}</h3>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-separate border-spacing-0">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs border-b border-slate-200">
                    <tr>
                        {{ $head }}
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    {{ $slot }}
                </tbody>
            </table>
        </div>
    </div>
</div>
