<div>
    <!-- Simplicity is the essence of happiness. - Cedric Bledsoe -->
    @props([
        'show' => false,
        'title' => null,
    ])

    @if ($show)
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">

        <div class="bg-white p-6 rounded-sm shadow-lg w-full max-w-md max-h-[90vh] overflow-y-auto scroll-smooth">

            @if ($title)
                <h2 class="text-xl font-semibold mb-4">
                    {{ $title }}
                </h2>
            @endif

            {{ $slot }}

        </div>

    </div>
@endif


</div>
