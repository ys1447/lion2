<?php

use Livewire\Component;
use App\Models\VariantConfig;

new class extends Component {
    public $variant;
    public $visibleColumns = [];
    public $openSetting = false;

    public function mount($variant)
    {
        $this->variant = $variant;
        $config = VariantConfig::where('variant_id', $this->variant->id)->first();
        $this->visibleColumns = $config ? $config->visible_columns : $this->allFields();
    }

    public function allFields()
    {
        return ['one_day', 'machine_id', 'batch', 'job_number', 'ph_1', 'ph_2', 'ph_3', 'viscosity_1', 'viscosity_2', 'viscosity_3', 'specific_gravity', 'active_ingredient', 'zpt', 'soap_percentage', 'rad', 'rgx', 'rxb', 'ryc', 'appearance', 'odor', 'capacity', 'shift', 'job_code', 'notes'];
    }

    public function saveSettings()
    {
        VariantConfig::updateOrCreate(
        ['variant_id' => $this->variant->id], 
        ['visible_columns' => $this->visibleColumns]
    );

    $this->openSetting = false;

    // Emit event ke komponen lain
    $this->dispatch('columns-updated', columns: $this->visibleColumns);
    
    $this->dispatch('alert-success', message: 'Column has been saved!');
    }
};
?>

<div>
    {{-- Well begun is half done. - Aristotle --}}
    {{-- Icon Gear Simpel --}}
    <x-loading wire:target='saveSettings,openSetting, visibleColumns' />

    <span wire:click="$set('openSetting', true)"
        class="group flex items-center gap-2 text-slate-400 hover:text-indigo-600 transition-colors mb-3 cursor-pointer"
        title="Setting Kolom">

        {{-- Icon Sliders --}}
        <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor"
            stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0m-9.75 0h9.75" />
        </svg>

        {{-- Teks --}}
        <span class="text-sm font-medium">Setting Columns</span>
    </span>

    {{-- MODAL SETTING --}}
    <x-modal :show="$openSetting" title="Pilih Kolom Aktif">
        <div class="grid grid-cols-2 gap-3 mb-6">
            @foreach ($this->allFields() as $field)
                <label
                    class="flex items-center gap-2 p-2 hover:bg-slate-50 rounded border border-transparent hover:border-slate-100 cursor-pointer">
                    <input type="checkbox" wire:model="visibleColumns" value="{{ $field }}"
                        class="rounded text-indigo-600 focus:ring-indigo-500">
                    <span class="text-xs text-slate-700">
                        {{ ucwords(str_replace('_', ' ', $field)) }}
                    </span>
                </label>
            @endforeach
        </div>

        <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
            <button type="button" wire:click="$set('openSetting', false)"
                class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-800 transition">
                Cancel
            </button>
            <x-button wire:click="saveSettings"> Save </x-button>
            
        </div>
    </x-modal>
</div>
