<?php
use Livewire\Component;
use App\Models\InputData;
?>

<div class="mt-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold text-slate-800 tracking-tight">Daily Hold List</h2>
        <span class="px-2 py-1 bg-amber-100 text-amber-700 text-[10px] tracking-wide font-bold rounded uppercase">
            <?php echo e($listHold->count()); ?> - Items Found
        </span>
    </div>

    <?php if (isset($component)) { $__componentOriginal2464d28aa792583487272eca56eee89c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2464d28aa792583487272eca56eee89c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table-data-2','data' => ['headers' => ['Time', 'Shift', 'Product / Info', 'Reason', 'Status']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table-data-2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['headers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Time', 'Shift', 'Product / Info', 'Reason', 'Status'])]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $listHold; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <tr class="hover:bg-slate-50 transition-colors">
                <!-- Time -->
                <td class="px-4 py-3 whitespace-nowrap text-slate-600 font-medium">
                    <?php echo e($item->created_at->format('H:i')); ?>

                </td>

                <!-- Shift -->
                <td class="px-4 py-3 whitespace-nowrap">

                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase">
                        <?php echo e($item->shift); ?>

                    </span>
                </td>

                <!-- Product Info (Asumsi ada kolom name/product) -->
                <td class="px-4 py-3 text-slate-700 font-semibold">
                    <?php echo e($item->variant->name ?? 'N/A'); ?>

                    <span class="block text-[10px] font-normal text-slate-400 italic">ID:
                        #<?php echo e($item->variant->category->name); ?></span>
                </td>

                <td class="px-4 py-3 text-slate-700 font-semibold">
                    <span class="block text-[10px] font-normal text-slate-400 italic">
                        <?php echo e(Str::words($item->activeHold->reason ?? '-', 5, '...')); ?>

                    </span>
                </td>

                <!-- Status Badge -->
                <td class="px-4 py-3 whitespace-nowrap">
                    <span
                        class="inline-flex animate-pulse items-center gap-1.5 px-2 py-1 rounded-md bg-amber-50 text-amber-700 font-bold border border-amber-100 uppercase text-[9px]">
                        <?php echo e($item->status); ?>

                    </span>
                </td>
            </tr>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <tr>
                <td colspan="5" class="px-4 py-10 ">
                    <div class="flex flex-col items-center justify-center opacity-50">
                        <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 8-8-8" />
                        </svg>
                        <p class="text-sm font-medium text-slate-500 italic">No hold items for this day.</p>
                    </div>
                </td>
            </tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2464d28aa792583487272eca56eee89c)): ?>
<?php $attributes = $__attributesOriginal2464d28aa792583487272eca56eee89c; ?>
<?php unset($__attributesOriginal2464d28aa792583487272eca56eee89c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2464d28aa792583487272eca56eee89c)): ?>
<?php $component = $__componentOriginal2464d28aa792583487272eca56eee89c; ?>
<?php unset($__componentOriginal2464d28aa792583487272eca56eee89c); ?>
<?php endif; ?>
</div><?php /**PATH C:\xampp\htdocs\lion2\storage\framework/views/livewire/views/cf9a71f3.blade.php ENDPATH**/ ?>