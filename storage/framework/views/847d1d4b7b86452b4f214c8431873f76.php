<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo e($title ?? config('app.name')); ?></title>
    <link rel="icon"
        href="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQEAAAAB3u9SAAAAAnRSTlMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAN798zQAAAAJcEhZcwAAFiUAABYlAUlSJPAAAAA0SURBVAjXY2SgCHACInYGCpAEYSADpIEMkAYyQBrIQInh/38wA6SBDJAGMkAayABpIAMDgwAAsmILmS6S998AAAAASUVORK5CYII=">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">


    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .custom-scrollbar {
            scrollbar-gutter: stable;
        }


        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .overflow-y-auto::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .overflow-y-auto {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        /* Tooltip Animation */
        button:hover>span.absolute {
            animation: tooltipSlide 0.2s ease-out forwards;
        }

        @keyframes tooltipSlide {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            100% {
                opacity: 100;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="h-full overflow-hidden flex flex-col">
    <div>
        <div x-data="{
            sidebarOpen: localStorage.getItem('sidebarOpen') === 'false' ? false : true,
            mobileSidebar: false,
            dropdownOpen: false
        }" x-init="$watch('sidebarOpen', value => localStorage.setItem('sidebarOpen', value))" class="flex h-screen overflow-hidden">

            <!-- MOBILE OVERLAY -->
            <div x-show="mobileSidebar" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 lg:hidden"
                @click="mobileSidebar = false">
            </div>

            <!-- SIDEBAR -->
            <?php if (isset($component)) { $__componentOriginal431d1f3877629df5c42dcc6256c4bd27 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal431d1f3877629df5c42dcc6256c4bd27 = $attributes; } ?>
<?php $component = App\View\Components\AsideBar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('aside-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AsideBar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal431d1f3877629df5c42dcc6256c4bd27)): ?>
<?php $attributes = $__attributesOriginal431d1f3877629df5c42dcc6256c4bd27; ?>
<?php unset($__attributesOriginal431d1f3877629df5c42dcc6256c4bd27); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal431d1f3877629df5c42dcc6256c4bd27)): ?>
<?php $component = $__componentOriginal431d1f3877629df5c42dcc6256c4bd27; ?>
<?php unset($__componentOriginal431d1f3877629df5c42dcc6256c4bd27); ?>
<?php endif; ?>

            <!-- MAIN AREA -->
            <div class="flex-1 flex flex-col overflow-hidden">

                <!-- NAVBAR -->
                <?php if (isset($component)) { $__componentOriginalb9eddf53444261b5c229e9d8b9f1298e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb9eddf53444261b5c229e9d8b9f1298e = $attributes; } ?>
<?php $component = App\View\Components\Navbar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Navbar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb9eddf53444261b5c229e9d8b9f1298e)): ?>
<?php $attributes = $__attributesOriginalb9eddf53444261b5c229e9d8b9f1298e; ?>
<?php unset($__attributesOriginalb9eddf53444261b5c229e9d8b9f1298e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb9eddf53444261b5c229e9d8b9f1298e)): ?>
<?php $component = $__componentOriginalb9eddf53444261b5c229e9d8b9f1298e; ?>
<?php unset($__componentOriginalb9eddf53444261b5c229e9d8b9f1298e); ?>
<?php endif; ?>

                

                <?php echo e($slot); ?>


            </div>
        </div>
    </div>


    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


    <script data-navigate-once>
        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }
    </script>


    <script>
        window.addEventListener('print-pdf', event => {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = event.detail.url;
            document.body.appendChild(iframe);
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        });
    </script>



    
    <script>
        document.addEventListener('focus-input', () => {
            const el = document.querySelector('.first-input')
            if (el) el.focus()
        })
    </script>

    
    <script>
        function initArrowNavigation() {
            // 1. Ambil semua elemen navigasi
            const elements = Array.from(
                document.querySelectorAll("input, button, select, textarea")
            ).filter(el => !el.disabled && !el.classList.contains('no-arrow-nav'));

            elements.forEach((el, index) => {
                // Hapus listener lama jika ada (mencegah double listener)
                el.removeEventListener("keydown", handleArrowKey);
                el.addEventListener("keydown", handleArrowKey);
            });
        }

        function handleArrowKey(e) {
            if (e.target.classList.contains('search-input-focus')) return;

            const keys = ["ArrowUp", "ArrowDown", "ArrowLeft", "ArrowRight"];
            if (!keys.includes(e.key)) return;

            const elements = Array.from(
                document.querySelectorAll("input, button, select, textarea")
            ).filter(el => !el.disabled && !el.classList.contains('no-arrow-nav'));

            const currentRect = e.target.getBoundingClientRect();
            let bestMatch = null;
            let minDistance = Infinity;

            elements.forEach(el => {
                if (el === e.target) return;

                const elRect = el.getBoundingClientRect();

                // Logika penentuan arah visual
                let isPossibleMatch = false;
                if (e.key === "ArrowRight") isPossibleMatch = elRect.left >= currentRect.right && Math.abs(elRect
                    .top - currentRect.top) < 50;
                if (e.key === "ArrowLeft") isPossibleMatch = elRect.right <= currentRect.left && Math.abs(elRect
                    .top - currentRect.top) < 50;
                if (e.key === "ArrowDown") isPossibleMatch = elRect.top >= currentRect.bottom;
                if (e.key === "ArrowUp") isPossibleMatch = elRect.bottom <= currentRect.top;

                if (isPossibleMatch) {
                    // Hitung jarak Euclidean antara dua titik (pythagoras)
                    // d = sqrt((x2-x1)^2 + (y2-y1)^2)
                    const dist = Math.sqrt(
                        Math.pow(elRect.left - currentRect.left, 2) +
                        Math.pow(elRect.top - currentRect.top, 2)
                    );

                    if (dist < minDistance) {
                        minDistance = dist;
                        bestMatch = el;
                    }
                }
            });

            // Jika tidak ketemu secara visual (misal di ujung baris), 
            // gunakan fallback index standar agar user tidak bingung
            if (bestMatch) {
                e.preventDefault();
                bestMatch.focus();
            } else {
                // Fallback ke index +1 / -1 jika ingin tetap pindah urutan DOM
                const currentIndex = elements.indexOf(e.target);
                let nextIndex;
                if (e.key === "ArrowRight" || e.key === "ArrowDown") nextIndex = currentIndex + 1;
                if (e.key === "ArrowLeft" || e.key === "ArrowUp") nextIndex = currentIndex - 1;

                if (elements[nextIndex]) {
                    e.preventDefault();
                    elements[nextIndex].focus();
                }
            }
        }


        // pertama kali load
        document.addEventListener("DOMContentLoaded", initArrowNavigation);

        // setiap Livewire update
        document.addEventListener("livewire:navigated", initArrowNavigation);
    </script>

    
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('alert-success', (data) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 500,
                    showConfirmButton: false
                });
            });
        });

        Livewire.on('alert-error', (data) => {
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                text: data.message,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Periksa Kembali'
            });
        });

        document.addEventListener('livewire:init', () => {

            Livewire.on('confirm-delete', (data) => {
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch(`delete-${data.type}`, {
                            id: data.id
                        })
                    }
                });
            });

        });

        <?php if(session()->has('welcome')): ?>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 10000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'success',
                title: '<?php echo e(session('welcome')); ?>',
                background: '#ffffff',
                color: '#1e293b',
                customClass: {
                    popup: 'rounded-sm border-l-4 border-indigo-500 shadow-lg',
                }
            });
        <?php endif; ?>
    </script>


</body>

</html>
<?php /**PATH C:\xampp\htdocs\lion2\resources\views/layouts/app.blade.php ENDPATH**/ ?>