<?php
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Livewire\Attributes\On;
?>

<div>

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Username</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Action</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <?php echo e($user->name); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($user->username); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($user->role); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center">
                        <span class="text-indigo-600 hover:text-indigo-900 mr-2 cursor-pointer"
                            wire:click="edit(<?php echo e($user->id); ?>)">
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
                        <span class="text-red-600 hover:text-red-900 cursor-pointer" wire:click="confirm_delete(<?php echo e($user->id); ?>)">
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
        </tbody>

    </table>


    <div class="mt-4">
        <?php echo e($users->links()); ?>

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
<?php $component->withAttributes(['wire:target' => 'edit,nextPage, previousPage, gotoPage, delete']); ?>
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
</div><?php /**PATH C:\xampp\htdocs\lion2\storage\framework/views/livewire/views/9b5bc6b9.blade.php ENDPATH**/ ?>