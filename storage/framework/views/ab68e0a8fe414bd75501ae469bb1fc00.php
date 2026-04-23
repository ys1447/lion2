<?php
use Livewire\Component;
use App\Models\Filling;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Traits\HasNotification;
?>

<div>
    <?php
        $headers = ['Title', 'Category', 'User', 'Issue', 'Status', 'Date', 'Update Status', 'Action'];
    ?>
    <?php if (isset($component)) { $__componentOriginal50c4b79f45ebbaf745fc521f681493a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal50c4b79f45ebbaf745fc521f681493a1 = $attributes; } ?>
<?php $component = App\View\Components\Loading::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('loading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Loading::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:target' => 'updateStatus, showIssue, editStatus, cancelIssue, cancelStatus, edit, search, statusFilter']); ?>
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
    <div class="gap-2 flex">

        <?php if (isset($component)) { $__componentOriginal465912bafb53d2799b51398725f2e117 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal465912bafb53d2799b51398725f2e117 = $attributes; } ?>
<?php $component = App\View\Components\Search::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Search::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['model' => 'search']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal465912bafb53d2799b51398725f2e117)): ?>
<?php $attributes = $__attributesOriginal465912bafb53d2799b51398725f2e117; ?>
<?php unset($__attributesOriginal465912bafb53d2799b51398725f2e117); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal465912bafb53d2799b51398725f2e117)): ?>
<?php $component = $__componentOriginal465912bafb53d2799b51398725f2e117; ?>
<?php unset($__componentOriginal465912bafb53d2799b51398725f2e117); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginalb68d555c13273f9d26aedfa8ff6c880d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb68d555c13273f9d26aedfa8ff6c880d = $attributes; } ?>
<?php $component = App\View\Components\Filter::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filter'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Filter::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['model' => 'statusFilter']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="in_progress">In Progress</option>
            <option value="closed">Closed</option>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb68d555c13273f9d26aedfa8ff6c880d)): ?>
<?php $attributes = $__attributesOriginalb68d555c13273f9d26aedfa8ff6c880d; ?>
<?php unset($__attributesOriginalb68d555c13273f9d26aedfa8ff6c880d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb68d555c13273f9d26aedfa8ff6c880d)): ?>
<?php $component = $__componentOriginalb68d555c13273f9d26aedfa8ff6c880d; ?>
<?php unset($__componentOriginalb68d555c13273f9d26aedfa8ff6c880d); ?>
<?php endif; ?>
    </div>
    <?php if (isset($component)) { $__componentOriginal2464d28aa792583487272eca56eee89c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2464d28aa792583487272eca56eee89c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table-data-2','data' => ['headers' => $headers]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table-data-2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['headers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($headers)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $fillings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <tr class="hover:bg-slate-50 border-b border-slate-100">
                <td class="px-4 py-3 font-medium text-slate-700"><?php echo e($item->title); ?></td>
                <td class="px-4 py-3 text-slate-600"><?php echo e($item->category->name); ?></td>
                <td class="px-4 py-3 text-slate-500 italic"><?php echo e($item->user->name ?? 'System'); ?></td>

                <td class="px-4 py-3">
                    
                    <button wire:click="showIssue(<?php echo e($item->id); ?>)"
                        class="inline-flex items-center gap-1.5 px-2 py-1 rounded bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-colors group">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span class="text-[10px] font-bold uppercase tracking-tight">Show Issue</span>
                    </button>
                </td>

                <td class="px-4 py-3">
                    <?php
                        $statusClasses = [
                            'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                            'in_progress' => 'bg-blue-100 text-blue-700 border-blue-200',
                            'closed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                        ];
                    ?>
                    <span
                        class="px-2 py-0.5 rounded-sm border text-[10px] font-bold uppercase <?php echo e($statusClasses[$item->status] ?? 'bg-gray-100'); ?>">
                        <?php echo e(str_replace('_', ' ', $item->status)); ?>

                    </span>
                </td>

                <td class="px-4 py-3 text-slate-500"><?php echo e($item->created_at->format('d/m/Y')); ?></td>
                <td class="px-4 py-3 text-slate-500">
                    <button wire:click="editStatus(<?php echo e($item->id); ?>)"
                        class="text-indigo-600 hover:text-indigo-900 text-xs font-semibold underline cursor-pointer">
                        Update Status
                    </button>
                </td>
                <td class="px-4 py-3 flex items-center">
                    <span wire:click="edit(<?php echo e($item->id); ?>)"
                        class="text-indigo-600 hover:text-indigo-900 mr-2 cursor-pointer">
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
                    <span wire:click="confirm_delete(<?php echo e($item->id); ?>)"
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
    <div class="m-2"><?php echo e($fillings->links()); ?></div>

    
    <?php if (isset($component)) { $__componentOriginale6a555649da86b3de44465cdfe004aa4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale6a555649da86b3de44465cdfe004aa4 = $attributes; } ?>
<?php $component = App\View\Components\Modal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Modal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($showModal),'title' => 'Update Issue Status']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <div class="space-y-4">
            <p class="text-sm text-slate-600">
                Updating status for: <span class="font-bold text-slate-800"><?php echo e($titleForModal); ?></span>
            </p>
            <div class="my-4">
                <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                <select wire:model="newStatus"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-indigo-500">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
            <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                <button type="button" wire:click="cancelStatus"
                    class="px-4 py-2 text-xs font-medium text-slate-600">Cancel</button>
                <button type="button" wire:click="updateStatus"
                    class="px-4 py-2 text-xs font-medium text-white bg-indigo-600 rounded-sm shadow-sm">Apply
                    Changes</button>
            </div>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale6a555649da86b3de44465cdfe004aa4)): ?>
<?php $attributes = $__attributesOriginale6a555649da86b3de44465cdfe004aa4; ?>
<?php unset($__attributesOriginale6a555649da86b3de44465cdfe004aa4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale6a555649da86b3de44465cdfe004aa4)): ?>
<?php $component = $__componentOriginale6a555649da86b3de44465cdfe004aa4; ?>
<?php unset($__componentOriginale6a555649da86b3de44465cdfe004aa4); ?>
<?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginale6a555649da86b3de44465cdfe004aa4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale6a555649da86b3de44465cdfe004aa4 = $attributes; } ?>
<?php $component = App\View\Components\Modal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Modal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($showIssueModal),'title' => 'Issue Detail']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <div class="space-y-2 overflow-y-auto max-h-[70vh]">
            <div>
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Title</h4>
                <p class="text-sm font-semibold text-slate-800"><?php echo e($titleForModal); ?></p>
            </div>

            <div class="p-2 bg-slate-50 border border-slate-200 rounded-sm">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Problem Description</h4>
                <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                    <?php echo e($selectedIssueContent); ?>

                </p>
            </div>

            <div class="flex justify-end pt-4">
                <button type="button" wire:click="cancelIssue"
                    class="px-6 py-2 text-xs font-bold text-white bg-slate-800 hover:bg-slate-700 rounded-sm transition-colors">
                    Close
                </button>
            </div>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale6a555649da86b3de44465cdfe004aa4)): ?>
<?php $attributes = $__attributesOriginale6a555649da86b3de44465cdfe004aa4; ?>
<?php unset($__attributesOriginale6a555649da86b3de44465cdfe004aa4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale6a555649da86b3de44465cdfe004aa4)): ?>
<?php $component = $__componentOriginale6a555649da86b3de44465cdfe004aa4; ?>
<?php unset($__componentOriginale6a555649da86b3de44465cdfe004aa4); ?>
<?php endif; ?>
</div><?php /**PATH C:\xampp\htdocs\lion2\storage\framework/views/livewire/views/a11ab06b.blade.php ENDPATH**/ ?>