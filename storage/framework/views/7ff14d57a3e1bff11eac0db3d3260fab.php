<?php
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ReworkLog;
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
<?php $component->withAttributes(['wire:target' => 'search, filterStatus, updateRemixUsage, editRemixUsage, updateInitialQty, editQty, confirm_delete, deleteRework']); ?>
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

    <div class="gap-2 flex mb-4">
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
<?php $component->withAttributes(['model' => 'filterStatus']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <option value="">All Status</option>
            <option value="active">Active Stock ⚠️</option>
            <option value="done">Depleted (Done) ✅</option>
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
<?php $component->withAttributes(['title' => 'Monitoring Remix Stock']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

         <?php $__env->slot('head', null, []); ?> 
            <th class="px-5 py-3 font-semibold text-left">Origin Info</th>
            <th class="px-5 py-3 font-semibold text-right">Current Stock</th>
            <th class="px-5 py-3 font-semibold text-left pl-10">Used In (Target Batches)</th>
            <th class="px-5 py-3 font-semibold text-center">Status</th>
            <th class="px-5 py-3 font-semibold text-center">Delete</th>
         <?php $__env->endSlot(); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $reworkLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'rework-row-'.e($log->id).''; ?>wire:key="rework-row-<?php echo e($log->id); ?>"
                class="hover:bg-slate-50 transition-colors align-middle border-b border-slate-100">
                
                <td class="px-5 py-3">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-amber-600 uppercase tracking-wider">
                            <?php echo e($log->inputData->variant->name ?? 'Unknown'); ?>

                        </span>
                        <span class="text-sm font-mono font-bold text-slate-700">
                            <?php echo e($log->inputData->batch ?? '-'); ?>

                        </span>
                        <span class="text-[10px] text-slate-400">
                            Initial: <?php echo e(number_format($log->initial_quantity)); ?> KG
                        </span>
                    </div>
                </td>

                
                <td class="px-5 py-3 text-right">
                    <div class="flex flex-col group cursor-pointer"
                        wire:click="editQty(<?php echo e($log->id); ?>, <?php echo e($log->initial_quantity); ?>)">
                        <span
                            class="text-[10px] uppercase text-slate-400 font-semibold flex items-center justify-end gap-1">
                            Sisa
                            <svg class="w-2 h-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                </path>
                            </svg>
                        </span>
                        <span
                            class="text-sm font-black <?php echo e($log->current_quantity > 0 ? 'text-blue-600' : 'text-slate-300'); ?>">
                            <?php echo e(number_format($log->current_quantity)); ?> <span class="text-[10px]">KG</span>
                        </span>
                        <span class="text-[9px] text-slate-400 italic">Total:
                            <?php echo e(number_format($log->initial_quantity)); ?></span>
                    </div>
                </td>
                
                <td class="px-5 py-3 pl-10">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($log->details && $log->details->count() > 0): ?>
                        <div class="flex flex-wrap gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $log->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                
                                <button type="button" wire:click="editRemixUsage(<?php echo e($detail->id); ?>)"
                                    <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'detail-'.e($detail->id).''; ?>wire:key="detail-<?php echo e($detail->id); ?>"
                                    class="group relative flex items-center bg-white border border-slate-200 rounded-sm px-2 py-1 shadow-sm hover:border-indigo-400 hover:shadow-md transition-all">

                                    <div class="flex flex-col">
                                        <span
                                            class="text-[10px] font-black text-indigo-600 leading-tight group-hover:text-amber-600 transition-colors">
                                            <?php echo e($detail->target_batch_number); ?>

                                            <svg class="w-2 h-2 inline ml-1 opacity-0 group-hover:opacity-100 transition-opacity"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </span>
                                        <span class="text-[9px] text-slate-500 font-medium">
                                            <?php echo e(number_format($detail->quantity_used)); ?> KG <span
                                                class="text-slate-300 mx-0.5">•</span>
                                            <?php echo e($detail->created_at->format('d/m')); ?>

                                        </span>
                                    </div>

                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detail->notes): ?>
                                        ...
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </button>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    <?php else: ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>

                
                <td class="px-5 py-3 text-center">
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-sm text-[10px] font-bold border <?php echo e($log->current_quantity > 0 ? 'bg-green-50 text-green-700 border-green-200' : 'bg-slate-50 text-slate-500 border-slate-200'); ?>">
                        <?php echo e($log->current_quantity > 0 ? 'READY' : 'EXHAUSTED'); ?>

                    </span>
                </td>

                
                <td class="px-5 py-3 text-center">
                    <button wire:click="confirm_delete(<?php echo e($log->id); ?>)"
                        class="text-slate-300 hover:text-red-600 transition-colors duration-200">
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
                    </button>
                </td>
            </tr>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reworkLogs->isEmpty()): ?>
            <tr>
                <td colspan="5" class="px-5 py-12 text-center text-slate-400 italic text-sm">
                    No remix stock records found.
                </td>
            </tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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

    <div class="mt-4 px-5">
        <?php echo e($reworkLogs->links()); ?>

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
<?php $component->withAttributes(['show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editingId),'title' => 'Edit Total Input']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($editingId): ?>
            <div class="space-y-4">
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1 tracking-tight">
                        Jumlah Awal Baru (KG)
                    </label>

                    <input type="number" wire:model="newInitialQty"
                        class="w-full px-3 py-3 text-lg font-bold border border-slate-300 rounded-sm focus:ring-2 focus:ring-amber-500 outline-none transition-all shadow-sm"
                        placeholder="0">

                    
                    <div class="mt-3 p-3 bg-amber-50 border border-amber-100 rounded-sm">
                        <p class="text-[10px] text-amber-700 leading-relaxed italic">
                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Sistem akan otomatis menghitung <strong>Sisa Stok</strong> dengan mengurangi angka baru ini
                            dengan jumlah yang sudah terpakai di batch lain.
                        </p>
                    </div>
                </div>

                
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 mt-6">
                    <button type="button" wire:click="$set('editingId', null)"
                        class="px-5 py-2 text-sm font-bold text-slate-500 hover:bg-slate-100 rounded-sm transition-colors border border-slate-200 uppercase tracking-tighter">
                        Batal
                    </button>
                    <button type="button" wire:click="updateInitialQty"
                        class="px-6 py-2 bg-amber-600 text-white rounded-sm text-sm font-bold shadow-md hover:bg-amber-700 transition-all uppercase tracking-tighter">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
<?php $component->withAttributes(['wire:model' => 'editingDetailId','show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($editingDetailId),'title' => 'Koreksi Pemakaian']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($editingDetailId): ?>
            <?php
                $currentLog = \App\Models\ReworkLog::find($this->reworkLogIdOfDetail);
                $currentDetail = \App\Models\ReworkDetail::find($this->editingDetailId);
                $maxInput = ($currentLog->current_quantity ?? 0) + ($currentDetail->quantity_used ?? 0);
            ?>

            <div class="space-y-4">
                <div class="p-3 bg-slate-50 rounded-sm border border-slate-200">
                    <div class="flex justify-between text-[11px] mb-1">
                        <span class="text-slate-500 uppercase font-bold">Stok Induk Saat Ini:</span>
                        <span class="text-slate-700 font-black"><?php echo e(number_format($currentLog->current_quantity ?? 0)); ?>

                            KG</span>
                    </div>
                    <div class="flex justify-between text-[11px]">
                        <span class="text-slate-500 uppercase font-bold">Pemakaian Lama:</span>
                        <span class="text-slate-700 font-black"><?php echo e(number_format($currentDetail->quantity_used ?? 0)); ?>

                            KG</span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1 uppercase tracking-tight">Jumlah Baru
                        (KG)</label>
                    <input type="number" wire:model="editUsedQty"
                        class="w-full px-3 py-3 text-lg font-bold border border-slate-300 rounded-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all"
                        step="0.01">

                    <div class="mt-2 flex items-start gap-2">
                        <svg class="w-3 h-3 text-amber-500 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-[10px] text-slate-500 leading-tight italic">
                            Batas maksimal input adalah <strong><?php echo e(number_format($maxInput)); ?> KG</strong> (Sisa stok +
                            pemakaian lama).
                        </p>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['editUsedQty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 mt-6">
                    <button type="button" wire:click="$set('editingDetailId', null)"
                        class="px-5 py-2 text-sm font-bold text-gray-500 hover:bg-gray-100 rounded-sm transition-colors border border-gray-200 uppercase tracking-tighter">
                        Batal
                    </button>
                    <button type="button" wire:click="updateRemixUsage"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-sm text-sm font-bold shadow-md hover:bg-indigo-700 transition-all uppercase tracking-tighter">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
</div><?php /**PATH C:\xampp\htdocs\lion2\storage\framework/views/livewire/views/db003bb4.blade.php ENDPATH**/ ?>