<?php
use Livewire\Component;
use App\Models\Filling;
?>

<div class="mt-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold text-slate-800 tracking-tight">Daily Filling Issues</h2>
        <span class="px-2 py-1 bg-amber-100 text-amber-700 text-[10px] tracking-wide font-bold rounded uppercase">
            <?php echo e($fillings->count()); ?> - Items Found
        </span>
    </div>

    <?php if (isset($component)) { $__componentOriginal2464d28aa792583487272eca56eee89c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2464d28aa792583487272eca56eee89c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table-data-2','data' => ['headers' => ['Time', 'Title', 'Category', 'Status']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table-data-2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['headers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Time', 'Title', 'Category', 'Status'])]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $fillings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <tr class="hover:bg-slate-50 transition-colors">
                <!-- Time -->
                <td class="px-4 py-3 whitespace-nowrap text-slate-600 font-medium">
                    <?php echo e($item->created_at->format('H:i')); ?>

                </td>
                <td class="px-4 py-3 whitespace-nowrap text-slate-600 font-medium">
                    <?php echo e($item->title); ?>

                </td>
                <td class="px-4 py-3 whitespace-nowrap text-slate-600 font-medium">
                    <?php echo e($item->category->name); ?>

                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                    <?php
                        $statusMap = [
                            'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                            'in_progress' => 'bg-blue-100 text-blue-700 border-blue-200',
                            'closed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                        ];

                        $statusLabel = [
                            'pending' => 'Pending',
                            'in_progress' => 'In Progress',
                            'closed' => 'Closed',
                        ];

                        $currentClass = $statusMap[$item->status] ?? 'bg-slate-100 text-slate-600 border-slate-200';
                    ?>

                    
                    <span class="px-2 py-1 rounded-sm border text-[10px] font-bold uppercase <?php echo e($currentClass); ?>">
                        <?php echo e($statusLabel[$item->status] ?? $item->status); ?>

                    </span>
                </td>

            </tr>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <tr>
                <td colspan="4" class="px-4 py-10 ">
                    <div class="flex flex-col items-center justify-center opacity-50">
                        <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 8-8-8" />
                        </svg>
                        <p class="text-sm font-medium text-slate-500 italic">No issues for this day.</p>
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
</div><?php /**PATH C:\xampp\htdocs\lion2\storage\framework/views/livewire/views/7507e455.blade.php ENDPATH**/ ?>