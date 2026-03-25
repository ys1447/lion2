<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="bg-gray-50 antialiased">
    
     <!-- Main Content -->
    <!-- Main Content - Lebih Kompak -->
    <main class="">
        {{ $slot }}
    </main>
    

    @livewireScripts

    {{-- Autofocus form --}}
    <script>
        document.querySelector(".first-input").focus();
    </script>

    {{-- Geser kolom --}}
    <script>
        function initArrowNavigation() {

            const elements = Array.from(
                document.querySelectorAll("input, button, select, textarea")
            ).filter(el => !el.disabled);

            elements.forEach((el, index) => {

                el.addEventListener("keydown", function(e) {

                    let next;

                    if (e.key === "ArrowRight") next = index + 1;
                    if (e.key === "ArrowLeft") next = index - 1;
                    if (e.key === "ArrowDown") next = index + 1;
                    if (e.key === "ArrowUp") next = index - 1;

                    if (next !== undefined && elements[next]) {
                        e.preventDefault();
                        elements[next].focus();
                    }

                });

            });

        }

        // pertama kali load
        document.addEventListener("DOMContentLoaded", initArrowNavigation);

        // setiap Livewire update
        document.addEventListener("livewire:navigated", initArrowNavigation);
    </script>


</body>

</html>
