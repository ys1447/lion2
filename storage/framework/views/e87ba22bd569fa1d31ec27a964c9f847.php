<?php
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
?>

<!-- Pastikan pembungkus paling luar memiliki h-screen dan overflow-hidden -->
<div class="flex h-screen overflow-hidden bg-slate-50">

    <!-- Sidebar kamu di sini (jika ada) -->

    <!-- CONTENT AREA -->
    <div class="flex flex-col flex-1 min-w-0">

        <!-- Header/Navbar kamu di sini (jika ada) -->

        <main class="flex-1 p-4 lg:p-6 overflow-y-auto" id="main-content">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
                <p class="text-slate-500 text-sm">
                    Welcome back, <span class="font-semibold text-indigo-600"><?php echo e(auth()->user()->name); ?></span>! Here is
                    what's happening today.
                </p>
            </div>

            <!-- Grid Wrapper untuk Komponen Dashboard agar rapi -->
            <div class="space-y-6">
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pages::dashboard.total-mixing-today', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-675649376-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pages::dashboard.total-hold', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-675649376-1', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
                    <!-- Tambahkan komponen lain di sini jika perlu -->
                </div>

                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pages::dashboard.list-issues', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-675649376-2', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pages::dashboard.filling-issues', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-675649376-3', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
            </div>
        </main>



    </div>





</div><?php /**PATH C:\xampp\htdocs\lion2\storage\framework/views/livewire/views/e3f7af1f.blade.php ENDPATH**/ ?>