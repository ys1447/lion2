<?php

use Livewire\Component;
use App\Models\Variant;
use App\Models\Category;
use App\Models\VariantStandard;
use Illuminate\Support\Str;
use App\Traits\HasNotification;

new class extends Component {
    use HasNotification;

    public $variantId;
    public $name;
    public $slug;
    public $show = false;
    public $category_id;
    public $capacity;

    public $standards = [];

    protected $listeners = ['edit-variant' => 'loadVariant'];

    protected $standardFields = [
        'ph_1' => 'pH 1',
        'ph_2' => 'pH 2',
        'ph_3' => 'pH 3',
        'viscosity_1' => 'Viscosity 1',
        'viscosity_2' => 'Viscosity 2',
        'viscosity_3' => 'Viscosity 3',
        'specific_gravity' => 'Specific Gravity',
        'active_ingredient' => 'Active Ingredient',
        'zpt' => 'ZPT',
        'soap_percentage' => 'Soap %',
    ];

    public function loadVariant($id)
    {
        $this->show = true;
        $this->variantId = $id;

        $variant = Variant::with('standards')->findOrFail($id);

        $this->name = $variant->name;
        $this->slug = $variant->slug;
        $this->capacity = $variant->capacity;
        $this->category_id = $variant->category_id;

        // Map data dari database ke array standards
        $this->standards = collect($this->standardFields)
            ->mapWithKeys(function ($label, $field) use ($variant) {
                $s = $variant->standards->firstWhere('field_name', $field);
                return [
                    $field => [
                        'label' => $label, // Simpan label untuk tampilan
                        'min' => $s?->min_value ?? null,
                        'max' => $s?->max_value ?? null,
                    ],
                ];
            })
            ->toArray();
    }

    public function cancel()
    {
        $this->show = false;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $variant = Variant::findOrFail($this->variantId);

        // Catat perubahan untuk notifikasi
        $changes = [];

        if ($variant->name !== $this->name) {
            $changes[] = "name from '{$variant->name}' to '{$this->name}'";
        }
        if ($variant->capacity != $this->capacity) {
            $changes[] = "capacity from {$variant->capacity}ml to {$this->capacity}ml";
        }
        if ($variant->category_id != $this->category_id) {
            $newCategory = Category::find($this->category_id)?->name ?? 'Unknown';
            $changes[] = "category to '{$newCategory}'";
        }

        $variant->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'capacity' => $this->capacity,
            'category_id' => $this->category_id,
        ]);

        $this->updateStandards();

        $detailMessage = count($changes) > 0 ? 'Updated ' . implode(', ', $changes) : 'Saved without changes';

        $this->sendNotification(action: 'EDIT', target: 'Variant: ' . $this->name, details: $detailMessage);

        $this->dispatch('variant-updated');
        $this->dispatch('alert-success', message: 'Data berhasil diedit');
        $this->show = false;
    }

    public function updateStandards()
    {
        foreach ($this->standards as $field => $data) {
            VariantStandard::updateOrCreate(
                [
                    'variant_id' => $this->variantId,
                    'field_name' => $field,
                ],
                [
                    'min_value' => $data['min'] === '' ? null : $data['min'],
                    'max_value' => $data['max'] === '' ? null : $data['max'],
                ],
            );
        }

        $this->dispatch('alert-success', message: 'Standar berhasil disimpan');
        $this->show = false;
    }

    public function render()
    {
        return $this->view([
            'categories' => Category::pluck('name', 'id'),
        ]);
    }
};
?>

<div>
    <x-modal :show="$show">

        {{-- FORM VARIANT --}}
        <form wire:submit.prevent="update" class="mb-4">
            <x-form-input wire:model="name" label="Name" forId='name' />
            <x-form-input wire:model="capacity" label="Capacity" forId='capacity' />
            <x-select-form label="Category" model="category_id" :options="$categories" />

            <div class="flex justify-end gap-2 mt-2">
                <button type="button" wire:click="cancel"
                    class="px-4 py-2 text-sm bg-gray-200 rounded-sm hover:bg-gray-300 cursor-pointer">
                    Cancel
                </button>

                <x-button type="submit">Update Variant</x-button>
            </div>
        </form>

        {{-- FORM STANDARDS --}}
        <div class="border-t pt-4 mt-4">
            <h3 class="font-semibold mb-4 text-gray-700">Quality Standards (Min/Max)</h3>
            <form wire:submit.prevent="updateStandards">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($standards as $field => $data)
                        <div class="flex flex-col p-2 border border-slate-200 rounded-sm bg-gray-50">
                            <label class="text-xs font-bold uppercase text-gray-600 mb-2">
                                {{ $data['label'] }}
                            </label>
                            <div class="flex items-center gap-2">
                                {{-- Min Input Group --}}
                                <div class="flex-1 space-y-1">
                                    <label
                                        class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-0.5">Min</label>
                                    <div class="relative">
                                        <input type="number" step="0.001"
                                            wire:model="standards.{{ $field }}.min"
                                            class="w-full bg-white border border-slate-200 px-2 py-1.5 text-sm rounded-md
                                                text-slate-700 placeholder:text-slate-300
                                                outline-none transition-all duration-200
                                                focus:border-blue-400 focus:ring-4 focus:ring-blue-50"
                                            placeholder="0.000">
                                    </div>
                                </div>

                                {{-- Max Input Group --}}
                                <div class="flex-1 space-y-1">
                                    <label
                                        class="text-[10px] font-bold text-slate-400 uppercase tracking-wider ml-0.5">Max</label>
                                    <div class="relative">
                                        <input type="number" step="0.001"
                                            wire:model="standards.{{ $field }}.max"
                                            class="w-full bg-white border border-slate-200 px-2 py-1.5 text-sm rounded-md
                                                text-slate-700 placeholder:text-slate-300
                                                outline-none transition-all duration-200
                                                focus:border-blue-400 focus:ring-4 focus:ring-blue-50"
                                            placeholder="0.000">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <x-button type="submit">
                        Save All Standards
                    </x-button>
                </div>
            </form>
        </div>

    </x-modal>
</div>
