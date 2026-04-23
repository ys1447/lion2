<?php
use Livewire\Component;
use App\Models\JobMixing;
use Livewire\Attributes\On;
use App\Traits\HasNotification;
use Livewire\WithPagination;
?>

<div>
    
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
<?php $component->withAttributes(['model' => 'isActiveFilter']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <option value="">All Status</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
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
            <th class="px-5 py-3 font-semibold w-16 text-center">No</th>
            <th class="px-5 py-3 font-semibold">Name</th>
            <th class="px-5 py-3 font-semibold">Variant</th>
            <th class="px-5 py-3 font-semibold">Code</th>
            <th class="px-5 py-3 font-semibold">Capacity</th>
            <th class="px-5 py-3 font-semibold">Type</th>
            <th class="px-5 py-3 font-semibold">No Document</th>
            <th class="px-5 py-3 font-semibold">No FTD</th>
            <th class="px-5 py-3 font-semibold">Revisi</th>
            <th class="px-5 py-3 font-semibold">Status</th>
            <th class="px-5 py-3 font-semibold">Created</th>
            <th class="px-5 py-3 font-semibold text-right">Action</th>
            <th class="px-5 py-3 font-semibold text-center">Document</th>
         <?php $__env->endSlot(); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $jobMixings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'job-'.e($job->id).''; ?>wire:key="job-<?php echo e($job->id); ?>" class="hover:bg-slate-50 transition-colors align-middle">

                <td class="px-5 py-3 text-center text-slate-500 font-medium">
                    <?php echo e($i + 1); ?>

                </td>

                <td class="px-5 py-3">
                    <span class="font-medium text-slate-700"><?php echo e($job->name); ?></span>
                </td>

                <td class="px-5 py-3">
                    <span
                        class="text-xs px-2 py-1 rounded-sm bg-amber-100 text-amber-800"><?php echo e($job->variant->name); ?></span>
                </td>

                <td class="px-5 py-3 text-slate-600">
                    <?php echo e($job->code_job_mixing); ?>

                </td>

                <td class="px-5 py-3 text-slate-600">
                    <?php echo e($job->capacity); ?>

                </td>

                <td class="px-5 py-3">
                    <span
                        class="text-xs px-2 py-1 rounded-sm 
                    <?php echo e($job->type ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700'); ?>">
                        <?php echo e($job->type ? 'Trial' : 'Terkendali'); ?>

                    </span>
                </td>

                <td class="px-5 py-3 text-slate-600">
                    <?php echo e($job->no_document); ?>

                </td>

                <td class="px-5 py-3 text-slate-600">
                    <?php echo e($job->no_ftd); ?>

                </td>

                <td class="px-5 py-3 text-slate-600">
                    <?php echo e($job->no_revisi); ?>

                </td>

                <td class="px-5 py-3">
                    <span
                        class="text-xs px-2 py-1 rounded-sm 
                    <?php echo e($job->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?>">
                        <?php echo e($job->is_active ? 'Active' : 'Inactive'); ?>

                    </span>
                </td>

                <td class="px-5 py-3 text-slate-500">
                    <?php echo e($job->created_at->diffForHumans()); ?>

                </td>

                <td class="px-5 py-3 text-right flex items-center justify-end gap-2">
                    <span wire:click="edit(<?php echo e($job->id); ?>)"
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

                    <span wire:click="confirm_delete(<?php echo e($job->id); ?>)"
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

                <td class="px-5 py-3 text-center">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($job->file_path): ?>
                        <a href="<?php echo e(Storage::url($job->file_path)); ?>" target="_blank" title="Print/View Document"
                            class="inline-flex items-center justify-center p-2 rounded-full bg-slate-100 text-slate-600 hover:bg-indigo-100 hover:text-indigo-600 transition-all group">

                            
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 9V4a1 1 0 011-1h10a1 1 0 011 1v5M6 18H5a2 2 0 01-2-2v-5a2 2 0 012-2h14a2 2 0 012 2v5a2 2 0 01-2 2h-1M6 14h12v7H6v-7z" />
                            </svg>

                        </a>
                    <?php else: ?>
                        <span class="text-[10px] text-slate-400 italic">No File</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
        <?php echo e($jobMixings->links()); ?>

    </div>

    <?php if (isset($component)) { $__componentOriginal50c4b79f45ebbaf745fc521f681493a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal50c4b79f45ebbaf745fc521f681493a1 = $attributes; } ?>
<?php $component = App\View\Components\Loading::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('loading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Loading::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:target' => 'edit, delete, search, isActiveFilter']); ?>
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

</div><?php /**PATH C:\xampp\htdocs\lion2\storage\framework/views/livewire/views/f5c62236.blade.php ENDPATH**/ ?>