<?php
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
?>

<div>
    <button wire:click="exportExcel"
        class="flex cursor-pointer items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-emerald-600 rounded-sm hover:bg-emerald-700 transition-all mb-4">
        
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zM6 20V4h7v5h5v11H6z" />
        </svg>
        Export Excel
    </button>

    <?php if (isset($component)) { $__componentOriginal2464d28aa792583487272eca56eee89c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2464d28aa792583487272eca56eee89c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table-data-2','data' => ['headers' => array_merge(['Category', 'Variant'], $months, ['Release Rate Year'])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table-data-2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['headers' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(array_merge(['Category', 'Variant'], $months, ['Release Rate Year']))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <?php
                $variants = $category->variants;
                $variantCount = $variants->count();

                $catTotalBatch = array_fill(1, 12, 0);
                $catTotalHold = array_fill(1, 12, 0);
                $catTotalRework = array_fill(1, 12, 0);

                // Tentukan rowspan: Jika ada varian, rowspan = jumlah varian + 1 (untuk baris total)
                // Jika tidak ada varian, rowspan = 1 (hanya baris total saja)
                $rowSpanValue = $variantCount > 0 ? $variantCount + 1 : 1;
            ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <tr class="hover:bg-slate-50 transition-colors">
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($index === 0): ?>
                        <td class="px-4 py-2 font-bold text-slate-700 align-middle text-center border border-slate-300 bg-white"
                            rowspan="<?php echo e($rowSpanValue); ?>">
                            <?php echo e($category->name); ?>

                        </td>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <td class="px-4 py-2 text-slate-600 border-r italic text-[11px] border-b border-slate-100">
                        <?php echo e($variant->name); ?>

                    </td>

                    <?php
                        $varYearBatch = 0;
                        $varYearIssue = 0;
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <?php
                            $total = $variant->{"month_{$m}_count"} ?? 0;
                            $hold = $variant->{"month_{$m}_hold"} ?? 0;
                            $rework = $variant->{"month_{$m}_rework"} ?? 0;

                            $varYearBatch += $total;
                            $varYearIssue += $hold + $rework;

                            $catTotalBatch[$m] += $total;
                            $catTotalHold[$m] += $hold;
                            $catTotalRework[$m] += $rework;
                        ?>
                        <td class="px-2 py-1 text-center border-r border-b border-slate-100">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($total > 0): ?>
                                <div class="text-[11px] font-bold text-slate-800"><?php echo e($total); ?></div>
                                <div class="flex justify-center gap-1 mt-1">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hold > 0): ?>
                                        <span
                                            class="px-1 text-[9px] bg-amber-100 text-amber-700 rounded">H:<?php echo e($hold); ?></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rework > 0): ?>
                                        <span
                                            class="px-1 text-[9px] bg-rose-100 text-rose-700 rounded">R:<?php echo e($rework); ?></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php else: ?>
                                <span class="text-slate-300">-</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                    <td class="px-4 py-2 text-center bg-slate-50 border-b border-slate-100">
                        <?php
                            $released = $varYearBatch - $varYearIssue;
                            $percentage = $varYearBatch > 0 ? ($released / $varYearBatch) * 100 : 0;
                            $color =
                                $percentage >= 90
                                    ? 'text-green-600'
                                    : ($percentage >= 75
                                        ? 'text-amber-600'
                                        : 'text-red-600');
                        ?>
                        <div class="text-xs font-bold <?php echo e($color); ?>"><?php echo e(number_format($percentage, 1)); ?>%</div>
                        <div class="text-[10px] text-slate-400">(<?php echo e($released); ?>/<?php echo e($varYearBatch); ?>)</div>
                    </td>
                </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <tr class="bg-slate-800 text-white font-semibold">
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($variantCount === 0): ?>
                    <td
                        class="px-4 py-2 font-bold text-slate-700 bg-white align-middle text-center border border-slate-300">
                        <?php echo e($category->name); ?>

                    </td>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <td class="px-4 py-2 text-[10px] uppercase tracking-wider border-r border-slate-700">
                    TOTAL <?php echo e($category->name); ?>

                </td>

                <?php
                    $catYearTotal = 0;
                    $catYearIssue = 0;
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <td class="px-2 py-1 text-center border-r border-slate-700">
                        <div class="text-[11px]"><?php echo e($catTotalBatch[$m]); ?></div>
                        <div class="flex justify-center gap-1 text-[8px]">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($catTotalHold[$m] > 0): ?>
                                <span class="text-amber-400">H:<?php echo e($catTotalHold[$m]); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($catTotalRework[$m] > 0): ?>
                                <span class="text-rose-400">R:<?php echo e($catTotalRework[$m]); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </td>
                    <?php
                        $catYearTotal += $catTotalBatch[$m];
                        $catYearIssue += $catTotalHold[$m] + $catTotalRework[$m];
                    ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                <td class="px-4 py-2 text-center bg-slate-900">
                    <?php
                        $catRel = $catYearTotal - $catYearIssue;
                        $catPerc = $catYearTotal > 0 ? ($catRel / $catYearTotal) * 100 : 0;
                    ?>
                    <div class="text-xs"><?php echo e(number_format($catPerc, 1)); ?>%</div>
                    <div class="text-[9px] text-slate-400">Avg. Release</div>
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
</div><?php /**PATH C:\xampp\htdocs\lion2\storage\framework/views/livewire/views/b6361499.blade.php ENDPATH**/ ?>