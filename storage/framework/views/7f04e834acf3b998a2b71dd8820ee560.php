<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo e($title ?? config('app.name')); ?></title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>

<body class="bg-gray-50 antialiased">
    
     <!-- Main Content -->
    <!-- Main Content - Lebih Kompak -->
    <main class="">
        <?php echo e($slot); ?>

    </main>
    

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


    
    <script>
        document.querySelector(".first-input").focus();
    </script>

    
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
<?php /**PATH C:\xampp\htdocs\lion2\resources\views/layouts/auth.blade.php ENDPATH**/ ?>