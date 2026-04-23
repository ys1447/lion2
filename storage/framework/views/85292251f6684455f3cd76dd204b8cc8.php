<?php
use Livewire\Component;
use App\Models\Category;
?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200 hover:shadow-md transition-all">
            <!-- Header: Icon & Title -->
            <div class="flex items-center gap-4 mb-4">
                <div class="shrink-0 w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-slate-500 text-[10px] uppercase font-bold tracking-wider leading-none mb-1">Daily Mixing</p>
                    <h3 class="text-slate-800 font-bold leading-none truncate w-32" title="<?php echo e($category->name); ?>"><?php echo e($category->name); ?></h3>
                </div>
            </div>

            <!-- Main Number -->
            <div class="mb-4">
                <p class="text-3xl font-black text-slate-900 leading-none">
                    <?php echo e(number_format($category->total_today)); ?>

                </p>
                <p class="text-xs text-slate-400 mt-1 font-medium italic">Total batch hari ini</p>
            </div>

            <!-- Footer Stats (Trial & Terkendali) -->
            <div class="grid grid-cols-2 gap-2 pt-4 border-t border-slate-100">
                <div class="bg-amber-50 rounded-md p-2">
                    <p class="text-[9px] uppercase font-bold text-amber-600 opacity-80">Trial</p>
                    <p class="text-sm font-bold text-amber-700"><?php echo e(number_format($category->total_trial)); ?></p>
                </div>
                <div class="bg-emerald-50 rounded-md p-2">
                    <p class="text-[9px] uppercase font-bold text-emerald-600 opacity-80">Terkendali</p>
                    <p class="text-sm font-bold text-emerald-700"><?php echo e(number_format($category->total_terkendali)); ?></p>
                </div>
            </div>
        </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
</div><?php /**PATH C:\xampp\htdocs\lion2\storage\framework/views/livewire/views/c2d280a1.blade.php ENDPATH**/ ?>