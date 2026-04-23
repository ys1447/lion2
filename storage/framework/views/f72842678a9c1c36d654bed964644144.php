<?php
use Livewire\Component;
use App\Models\Filling;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
?>

<div class="w-full p-6 bg-white rounded-sm shadow-sm">
    <h2 class="text-xl font-semibold mb-2 text-indigo-800">Input Issue</h2>
    <form wire:submit.prevent='save'>

        <!-- Bungkus dengan relative agar list saran muncul di bawah input -->
        <div class="relative">
            <?php if (isset($component)) { $__componentOriginal967bdc6f044358de111e8173f0c9c426 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal967bdc6f044358de111e8173f0c9c426 = $attributes; } ?>
<?php $component = App\View\Components\FormInput::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\FormInput::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live.debounce.300ms' => 'title','label' => 'Issue Title','class' => 'first-input','forId' => 'title','placeholder' => 'Blocking machine ...','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('title'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal967bdc6f044358de111e8173f0c9c426)): ?>
<?php $attributes = $__attributesOriginal967bdc6f044358de111e8173f0c9c426; ?>
<?php unset($__attributesOriginal967bdc6f044358de111e8173f0c9c426); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal967bdc6f044358de111e8173f0c9c426)): ?>
<?php $component = $__componentOriginal967bdc6f044358de111e8173f0c9c426; ?>
<?php unset($__componentOriginal967bdc6f044358de111e8173f0c9c426); ?>
<?php endif; ?>

            <!-- List Rekomendasi -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($suggestions)): ?>
                <div class="absolute z-50 w-full bg-white border border-slate-200 rounded-sm shadow-lg -mt-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $suggestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suggest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <div wire:click="selectSuggestion('<?php echo e($suggest); ?>')"
                            class="px-4 py-2 text-sm text-slate-700 hover:bg-indigo-50 cursor-pointer border-b border-slate-50 last:border-none">
                            <span class="font-medium"><?php echo e($suggest); ?></span>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <?php if (isset($component)) { $__componentOriginal8c0309122c50c5a2d0c61dff38ca1e85 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c0309122c50c5a2d0c61dff38ca1e85 = $attributes; } ?>
<?php $component = App\View\Components\SelectForm::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SelectForm::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Plant','model' => 'category_id','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($categories)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c0309122c50c5a2d0c61dff38ca1e85)): ?>
<?php $attributes = $__attributesOriginal8c0309122c50c5a2d0c61dff38ca1e85; ?>
<?php unset($__attributesOriginal8c0309122c50c5a2d0c61dff38ca1e85); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c0309122c50c5a2d0c61dff38ca1e85)): ?>
<?php $component = $__componentOriginal8c0309122c50c5a2d0c61dff38ca1e85; ?>
<?php unset($__componentOriginal8c0309122c50c5a2d0c61dff38ca1e85); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginalcc0154580828f80bdab5d7fe416ed74a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcc0154580828f80bdab5d7fe416ed74a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-textarea','data' => ['wire:model' => 'issues','label' => 'Issue Details','forId' => 'issues','placeholder' => 'Describe the quality deviation in detail...','error' => $errors->first('issues'),'rows' => '5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'issues','label' => 'Issue Details','forId' => 'issues','placeholder' => 'Describe the quality deviation in detail...','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('issues')),'rows' => '5']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcc0154580828f80bdab5d7fe416ed74a)): ?>
<?php $attributes = $__attributesOriginalcc0154580828f80bdab5d7fe416ed74a; ?>
<?php unset($__attributesOriginalcc0154580828f80bdab5d7fe416ed74a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcc0154580828f80bdab5d7fe416ed74a)): ?>
<?php $component = $__componentOriginalcc0154580828f80bdab5d7fe416ed74a; ?>
<?php unset($__componentOriginalcc0154580828f80bdab5d7fe416ed74a); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginale67687e3e4e61f963b25a6bcf3983629 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale67687e3e4e61f963b25a6bcf3983629 = $attributes; } ?>
<?php $component = App\View\Components\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
 Save Issue  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale67687e3e4e61f963b25a6bcf3983629)): ?>
<?php $attributes = $__attributesOriginale67687e3e4e61f963b25a6bcf3983629; ?>
<?php unset($__attributesOriginale67687e3e4e61f963b25a6bcf3983629); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale67687e3e4e61f963b25a6bcf3983629)): ?>
<?php $component = $__componentOriginale67687e3e4e61f963b25a6bcf3983629; ?>
<?php unset($__componentOriginale67687e3e4e61f963b25a6bcf3983629); ?>
<?php endif; ?>
    </form>
</div><?php /**PATH C:\xampp\htdocs\lion2\storage\framework/views/livewire/views/d6bff7e9.blade.php ENDPATH**/ ?>