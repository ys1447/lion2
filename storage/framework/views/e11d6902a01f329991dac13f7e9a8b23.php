<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo e($title ?? config('app.name')); ?></title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('img/favicon.png')); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>


    <style>
        @keyframes loading-bar {
            0% {
                width: 0%;
                transform: translateX(-20%);
            }

            50% {
                width: 70%;
            }

            100% {
                width: 100%;
            }
        }

        .animate-loading-bar {
            animation: loading-bar 1s ease-in-out infinite;
        }

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
            dropdownOpen: false,
            pageLoading: false
        }" x-init="
        $watch('sidebarOpen', value => localStorage.setItem('sidebarOpen', value)) 
        
        window.addEventListener('livewire:navigate', () => {
        pageLoading = true
        })

        window.addEventListener('livewire:navigated', () => {
        setTimeout(() => {
            pageLoading = false
        }, 150)
        })
        
        "

            class="flex h-screen overflow-hidden">


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


            <div
                class="flex-1 overflow-y-auto relative">

                <!-- Loading Overlay -->
                <div
                    x-show="pageLoading"
                    x-transition.opacity.duration.50ms
                    class="absolute inset-0 z-40 flex items-center justify-center bg-white/30 backdrop-blur-[1px]"
                    style="display:none;">
                    <div class="flex items-center gap-3 px-5 py-3 rounded-xl bg-white/90 shadow-xl border border-slate-200">
                        <div class="w-5 h-5 border-2 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>

                        <span class="text-sm font-medium text-slate-700">
                            Loading...
                        </span>
                    </div>
                </div>

                

                <div class="sticky top-0 z-30">
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
                </div>


                
                <div
                    :class="pageLoading ? 'opacity-60' : 'opacity-100'"
                    class="transition-opacity duration-300">

                    <?php echo e($slot); ?>


                </div>

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

            Livewire.on('alert-error', (data) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal!',
                    text: data.message,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Periksa Kembali'
                });
            });

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
    </script>


</body>

</html><?php /**PATH C:\laragon\www\lion2\resources\views/layouts/app.blade.php ENDPATH**/ ?>