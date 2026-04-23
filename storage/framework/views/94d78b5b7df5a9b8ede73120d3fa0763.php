<?php
use App\Models\ReagentLog;
use App\Models\StockReagent;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Traits\HasNotification;
?>

<div class="mt-8 border-t border-slate-100 pt-6">
    <?php if (isset($component)) { $__componentOriginal50c4b79f45ebbaf745fc521f681493a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal50c4b79f45ebbaf745fc521f681493a1 = $attributes; } ?>
<?php $component = App\View\Components\Loading::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('loading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Loading::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:target' => 'edit']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal50c4b79f45ebbaf745fc521f681493a1)): ?>
<?php $attributes = $__attributesOriginal50c4b79f45ebbaf745fc521f681493a1; ?>
<?php unset($__attributesOriginal50c4b79f45ebbaf745fc521f681493a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal50c4b79f45ebbaf745fc521f681493a1)): ?>
<?php $component = $__componentOriginal50c4b79f45ebbaf745fc521f681493a1; ?>
<?php unset($__componentOriginal50c4b79f45ebbaf745fc521f681493a1); ?>
<?php endif; ?>
    <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Recent Activity Logs
    </h3>

    
    <?php if (isset($component)) { $__componentOriginal2464d28aa792583487272eca56eee89c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2464d28aa792583487272eca56eee89c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table-data-2','data' => ['headers' => ['Time', 'Reagent', 'Action', 'Amount', 'User', 'Action']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table-data-2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['headers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Time', 'Reagent', 'Action', 'Amount', 'User', 'Action'])]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-2 text-slate-400 italic"><?php echo e($log->created_at->diffForHumans()); ?></td>
                <td class="px-4 py-2 font-medium text-slate-700"><?php echo e($log->reagent->name); ?></td>
                <td class="px-4 py-2">
                    <span
                        class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase">
                        <?php echo e($log->type); ?>

                    </span>
                </td>
                <td class="px-4 py-2 font-bold text-emerald-600">
                    +<?php echo e(number_format($log->amount)); ?> ml
                </td>
                <td class="px-4 py-2 text-slate-500"><?php echo e($log->user_name); ?></td>
                <td class="px-4 py-2 text-slate-500 flex">
                    <span wire:click="edit(<?php echo e($log->id); ?>)"
                        class="text-indigo-600 hover:text-indigo-900 cursor-pointer">
                        <?php if (isset($component)) { $__componentOriginal7c9295f3d7fe210c6d2a85cdcaa6864d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7c9295f3d7fe210c6d2a85cdcaa6864d = $attributes; } ?>
<?php $component = App\View\Components\EditSvg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('edit-svg'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\EditSvg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7c9295f3d7fe210c6d2a85cdcaa6864d)): ?>
<?php $attributes = $__attributesOriginal7c9295f3d7fe210c6d2a85cdcaa6864d; ?>
<?php unset($__attributesOriginal7c9295f3d7fe210c6d2a85cdcaa6864d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7c9295f3d7fe210c6d2a85cdcaa6864d)): ?>
<?php $component = $__componentOriginal7c9295f3d7fe210c6d2a85cdcaa6864d; ?>
<?php unset($__componentOriginal7c9295f3d7fe210c6d2a85cdcaa6864d); ?>
<?php endif; ?>
                    </span>

                    <span wire:click="confirm_delete(<?php echo e($log->id); ?>)"
                        class="text-red-600 hover:text-red-900 cursor-pointer">
                        <?php if (isset($component)) { $__componentOriginal43fab4223cc9af4397454e7ec0099e53 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal43fab4223cc9af4397454e7ec0099e53 = $attributes; } ?>
<?php $component = App\View\Components\DeleteSvg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('delete-svg'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\DeleteSvg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal43fab4223cc9af4397454e7ec0099e53)): ?>
<?php $attributes = $__attributesOriginal43fab4223cc9af4397454e7ec0099e53; ?>
<?php unset($__attributesOriginal43fab4223cc9af4397454e7ec0099e53); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal43fab4223cc9af4397454e7ec0099e53)): ?>
<?php $component = $__componentOriginal43fab4223cc9af4397454e7ec0099e53; ?>
<?php unset($__componentOriginal43fab4223cc9af4397454e7ec0099e53); ?>
<?php endif; ?>
                    </span>
                </td>
            </tr>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
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
    <div class="mt-2">
        <?php echo e($logs->links()); ?>

    </div>

    <div class="mt-10 border-t border-slate-100 pt-6">
        <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.628.283a2 2 0 01-1.186.127l-2.96-.592a2 2 0 00-.546.101l-1.58.475a2 2 0 00-1.357 2.324l.84 3.358a2 2 0 002.325 1.355l10.126-2.025a2 2 0 001.355-2.325l-.84-3.358z" />
            </svg>
            Current Reagent Inventory
        </h3>

        <?php if (isset($component)) { $__componentOriginal2464d28aa792583487272eca56eee89c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2464d28aa792583487272eca56eee89c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table-data-2','data' => ['headers' => [
            'Reagent Name',
            'Tare (Bottle)',
            'Initial',
            'Incoming',
            'Usage',
            'Current Stock',
            'Min Stock',
            'Status',
            'Action',
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table-data-2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['headers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            'Reagent Name',
            'Tare (Bottle)',
            'Initial',
            'Incoming',
            'Usage',
            'Current Stock',
            'Min Stock',
            'Status',
            'Action',
        ])]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $reagents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <tr class="hover:bg-slate-50 transition-colors">
                    
                    <td class="px-4 py-3 font-semibold text-slate-700">
                        <?php echo e($item->name); ?>

                    </td>

                    
                    <td class="px-4 py-3 text-amber-600 font-mono text-xs">
                        <?php echo e(number_format($item->empty_bottle_weight)); ?> <span class="text-[10px]">g</span>
                    </td>

                    
                    <td class="px-4 py-3 text-slate-500 text-xs">
                        <?php echo e(number_format($item->initial_stock)); ?> <span class="text-[10px]">ML</span>
                    </td>

                    
                    <td class="px-4 py-3 text-emerald-600 text-xs font-medium">
                        + <?php echo e(number_format($item->total_incoming)); ?>

                    </td>

                    
                    <td class="px-4 py-3 text-red-500 text-xs font-medium">
                        - <?php echo e(number_format($item->total_usage)); ?>

                    </td>

                    
                    <td class="px-4 py-3 font-bold text-slate-900 bg-slate-50/50">
                        <?php echo e(number_format($item->current_stock)); ?> <span
                            class="text-[10px] font-normal text-slate-400">ML</span>
                    </td>

                    <td class="px-4 py-3 font-bold text-slate-900 bg-slate-50/50">
                        <?php echo e(number_format($item->min_stock)); ?> <span
                            class="text-[10px] font-normal text-slate-400">ML</span>
                    </td>

                    
                    <td class="px-4 py-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->current_stock <= $item->min_stock): ?>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-sm bg-red-100 text-red-700 text-[10px] font-bold uppercase tracking-wider animate-pulse">
                                Low Stock
                            </span>
                        <?php else: ?>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-sm bg-slate-100 text-slate-600 text-[10px] font-bold uppercase tracking-wider">
                                Safe
                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                    <td class="px-4 py-3 font-bold text-slate-900 bg-slate-50/50">
                        <span wire:click="confirm_delete_stock(<?php echo e($item->id); ?>)"
                            class="text-red-600 hover:text-red-900 cursor-pointer">
                            <?php if (isset($component)) { $__componentOriginal43fab4223cc9af4397454e7ec0099e53 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal43fab4223cc9af4397454e7ec0099e53 = $attributes; } ?>
<?php $component = App\View\Components\DeleteSvg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('delete-svg'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\DeleteSvg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal43fab4223cc9af4397454e7ec0099e53)): ?>
<?php $attributes = $__attributesOriginal43fab4223cc9af4397454e7ec0099e53; ?>
<?php unset($__attributesOriginal43fab4223cc9af4397454e7ec0099e53); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal43fab4223cc9af4397454e7ec0099e53)): ?>
<?php $component = $__componentOriginal43fab4223cc9af4397454e7ec0099e53; ?>
<?php unset($__componentOriginal43fab4223cc9af4397454e7ec0099e53); ?>
<?php endif; ?>
                        </span>
                    </td>
                </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
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
    </div>
</div><?php /**PATH C:\xampp\htdocs\lion2\storage\framework/views/livewire/views/0be563ad.blade.php ENDPATH**/ ?>