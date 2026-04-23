<?php
use Livewire\Component;
use App\Models\HoldLog;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Gate;
use App\Traits\HasNotification;
use Livewire\WithPagination;
?>

<div>
    <?php if (isset($component)) { $__componentOriginal50c4b79f45ebbaf745fc521f681493a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal50c4b79f45ebbaf745fc521f681493a1 = $attributes; } ?>
<?php $component = App\View\Components\Loading::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('loading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Loading::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:target' => 'cancel, openReason, releaseHold, search, inputStatusFilter']); ?>
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
<?php $component->withAttributes(['model' => 'inputStatusFilter']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <option value="">All Status</option>
            <option value="hold">On Hold ⚠️</option>
            <option value="releaseHold">Released ✅</option>
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
    <?php if (isset($component)) { $__componentOriginalb539fdd4bceece4a667dd360eb69c7ae = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb539fdd4bceece4a667dd360eb69c7ae = $attributes; } ?>
<?php $component = App\View\Components\DataTable::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('data-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\DataTable::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Job Mixing List']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

         <?php $__env->slot('head', null, []); ?> 

            <th class="px-5 py-3 font-semibold">Variant</th>
            <th class="px-5 py-3 font-semibold">Batch</th>
            <th class="px-5 py-3 font-semibold">Date</th>
            <th class="px-5 py-3 font-semibold">Notes</th>
            <th class="px-5 py-3 font-semibold">User id</th>
            <th class="px-5 py-3 font-semibold">Release(?)</th>
            <th class="px-5 py-3 font-semibold">Status</th>
            <th class="px-5 py-3 font-semibold">Release Date</th>
            <th class="px-5 py-3 font-semibold">Delete</th>
         <?php $__env->endSlot(); ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <tr class="hover:bg-slate-50 transition-colors align-middle">


                <td class="px-5 py-3">
                    <span class="text-xs px-2 py-1 rounded-sm bg-amber-100 text-amber-800 font-medium">
                        <?php echo e($log->inputData->variant->name); ?>

                    </span>
                </td>

                <td class="px-5 py-3 text-slate-600 font-mono text-sm">
                    <?php echo e($log->inputData->batch); ?>

                </td>

                <td class="px-5 py-3 text-slate-600 font-mono text-sm">
                    <?php echo e($log->hold_at->format('d/m/y H:i')); ?>

                </td>

                <td class="px-5 py-3">
                    <button wire:click="openReason('<?php echo e(addslashes($log->reason)); ?>')"
                        class="inline-flex items-center gap-1.5 px-2 py-1 rounded bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-colors group">

                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>

                        <span class="text-[10px] font-bold uppercase tracking-tight">Show Reason</span>
                    </button>
                </td>

                <td class="px-5 py-3">
                    <span class="text-slate-700 font-medium text-sm"><?php echo e($log->user->name ?? 'System'); ?></span>
                </td>

                <td class="px-5 py-3 text-center">
                    <button wire:click="releaseHold(<?php echo e($log->id); ?>)"
                        wire:confirm="Konfirmasi: Batch ini akan dikembalikan ke status normal?"
                        class="group inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded border border-slate-200 bg-white text-slate-500 hover:border-green-500 hover:text-green-600 hover:bg-green-50/50 transition-all duration-200 shadow-sm"
                        title="Release Batch">

                        
                        <svg class="w-3.5 h-3.5 transform group-hover:scale-110 transition-transform duration-200"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>

                        
                        <span class="text-[10px] font-bold uppercase tracking-wider">Release</span>
                    </button>
                </td>

                <td class="px-5 py-3">
                    <span class="text-slate-700 font-medium text-sm">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($log->released_at): ?>
                            <span
                                class="inline-flex items-center px-2 py-1 rounded text-[10px] font-bold bg-green-100 text-green-700">
                                RELEASED
                            </span>
                        <?php else: ?>
                            <span
                                class="inline-flex items-center px-2 py-1 rounded text-[10px] font-bold bg-red-100 text-red-700 animate-pulse">
                                ON HOLD
                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </span>
                </td>

                <td class="px-5 py-3">
                    <span class="text-slate-700 font-medium text-sm">
                        <?php echo e($log->released_at ? $log->released_at->format('d/m/y H:i') : '-- : --'); ?>

                    </span>
                </td>
                <td class="px-5 py-3 text-center" wire:click="confirm_delete(<?php echo e($log->id); ?>)">
                    <div class="flex items-center justify-center"> 
                        <span class="text-red-600 hover:text-red-900 cursor-pointer transition-colors duration-200">
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
                    </div>
                </td>
            </tr>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb539fdd4bceece4a667dd360eb69c7ae)): ?>
<?php $attributes = $__attributesOriginalb539fdd4bceece4a667dd360eb69c7ae; ?>
<?php unset($__attributesOriginalb539fdd4bceece4a667dd360eb69c7ae); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb539fdd4bceece4a667dd360eb69c7ae)): ?>
<?php $component = $__componentOriginalb539fdd4bceece4a667dd360eb69c7ae; ?>
<?php unset($__componentOriginalb539fdd4bceece4a667dd360eb69c7ae); ?>
<?php endif; ?>
    <div class="mt-4">
        <?php echo e($logs->links()); ?>

    </div>

    
    <?php if (isset($component)) { $__componentOriginale6a555649da86b3de44465cdfe004aa4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale6a555649da86b3de44465cdfe004aa4 = $attributes; } ?>
<?php $component = App\View\Components\Modal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Modal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($showReasonModal),'title' => 'Full Hold Reason']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <div class="space-y-4">
            
            <div class="flex items-center gap-2 mb-2">
                <span
                    class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold uppercase tracking-wider">
                    Reason Detail
                </span>
            </div>

            
            <div class="bg-slate-50 border border-slate-100 rounded-lg p-4">
                <p class="text-sm text-slate-700 leading-relaxed text-justify italic shadow-inner">
                    "<?php echo e($selectedReason); ?>"
                </p>
            </div>

            <div class="flex justify-end pt-2">
                <button wire:click="cancel"
                    class="px-5 py-2 text-sm font-semibold text-slate-500 hover:bg-slate-100 rounded-md transition-colors border border-slate-200 shadow-sm">
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
</div><?php /**PATH C:\xampp\htdocs\lion2\storage\framework/views/livewire/views/4ae43168.blade.php ENDPATH**/ ?>