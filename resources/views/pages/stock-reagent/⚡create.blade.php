<?php

use Livewire\Component;
use App\Models\StockReagent;

new class extends Component {
    // Properti Stock Reagent
    public $name, $initial_stock, $min_stock, $empty_bottle_weight;

    public $isCreateOpen = false;

    // Properti Add Incoming Stock
    public $isAddStockOpen = false;
    public $selectedReagentId, $incomingAmount;

    // Properti Usage (PEMAKAIAN)
    public $isUseStockOpen = false;
    public $usageAmount;

    public function openModal()
    {
        $this->reset(['name', 'initial_stock']); // Reset input setiap buka modal baru
        $this->isCreateOpen = true;
    }

    public function cancel()
    {
        $this->isCreateOpen = false;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'initial_stock' => 'required|numeric|min:0',
            'min_stock' => 'required|numeric|min:0',
            'empty_bottle_weight' => 'required|numeric|min:0',
        ]);

        StockReagent::create([
            'name' => $this->name,
            'initial_stock' => $this->initial_stock,
            'min_stock' => $this->min_stock,
            'empty_bottle_weight' => $this->empty_bottle_weight,
            // total_incoming & usage otomatis 0 dari migrasi
            // current_stock otomatis dihitung oleh Model Booted
        ]);
        $this->dispatch('alert-success', message: 'New Reagent added successfully!');
        $this->dispatch('reagent-added');
        $this->isCreateOpen = false;
        $this->reset(['name', 'initial_stock', 'min_stock', 'empty_bottle_weight']);
    }

    // --- Logic Add Incoming Stock ---
    public function openAddStock()
    {
        $this->reset(['selectedReagentId', 'incomingAmount']);
        $this->isAddStockOpen = true;
    }

    public function updateStock()
    {
        $this->validate([
            'selectedReagentId' => 'required|exists:stock_reagents,id',
            'incomingAmount' => 'required|numeric|min:1',
        ]);

        $reagent = StockReagent::find($this->selectedReagentId);

        // 1. Update Angka Stok Utama
        $reagent->increment('total_incoming', $this->incomingAmount);
        $reagent->refresh();
        $reagent->current_stock = $reagent->initial_stock + $reagent->total_incoming - $reagent->total_usage;
        $reagent->save();

        // 2. Simpan Riwayat ke Tabel Log (Relasi)
        $reagent->logs()->create([
            'type' => 'incoming',
            'amount' => $this->incomingAmount,
            'user_name' => auth()->user()->getAttributes()['name'] ?? 'QC', // Mengambil nama user yang login
        ]);

        $this->isAddStockOpen = false;
        $this->dispatch('alert-success', message: "Stok {$reagent->name} berhasil ditambahkan!");
        $this->dispatch('data-added');
    }

    public function cancelIncoming()
    {
        $this->isAddStockOpen = false;
    }

    // --- Logic Use Reagent ---
    public function openUseStock()
    {
        $this->reset(['selectedReagentId', 'usageAmount']);
        $this->isUseStockOpen = true;
    }

    public function cancelUseStock()
    {
        $this->isUseStockOpen = false;
    }

    public function useStock()
    {
        $reagent = StockReagent::find($this->selectedReagentId);

        $this->validate([
            'selectedReagentId' => 'required|exists:stock_reagents,id',
            'usageAmount' => [
                'required',
                'numeric',
                'min:1',
                // Validasi agar tidak memakai lebih dari stok yang ada
                function ($attribute, $value, $fail) use ($reagent) {
                    if ($reagent && $value > $reagent->current_stock) {
                        $fail('Usage amount exceeds current available stock.');
                    }
                },
            ],
        ]);

        // 1. Update Angka Pemakaian
        $reagent->increment('total_usage', $this->usageAmount);
        $reagent->refresh();
        $reagent->current_stock = $reagent->initial_stock + $reagent->total_incoming - $reagent->total_usage;
        $reagent->save();

        // 2. Simpan Riwayat Log (Type: usage)
        $reagent->logs()->create([
            'type' => 'usage',
            'amount' => $this->usageAmount,
            'user_name' => auth()->user()->getAttributes()['name'] ?? 'QC',
        ]);

        $this->isUseStockOpen = false;
        $this->dispatch('alert-success', message: "Used {$this->usageAmount}ml of {$reagent->name}");
        $this->dispatch('data-added'); // Agar tabel log refresh
    }

    public function render()
    {
        return $this->view([
            'reagents' => StockReagent::orderBy('name', 'asc')->get(),
        ]);
    }
};
?>

<div>

    <x-loading
        wire:target="save, openModal, cancel, cancelIncoming, openAddStock, updateStock,openUseStock, cancelUseStock, useStock  " />

    <x-modal :show="$isCreateOpen" title="Add New Reagent Stock">
        <form wire:submit.prevent="save" class="space-y-4">

            {{-- Nama Reagent --}}
            <x-form-input label="Reagent Name" forId="reagent_name" wire:model="name"
                placeholder="e.g. Sodium Hydroxide (NaOH)" :error="$errors->first('name')" />

            <div class="grid grid-cols-2 gap-4">
                {{-- Initial Stock --}}
                <x-form-input label="Initial Stock (ML)" forId="initial_stock" type="number" wire:model="initial_stock"
                    placeholder="0" :error="$errors->first('initial_stock')" />

                {{-- Alert Threshold --}}
                <x-form-input label="Min. Alert (ML)" forId="min_stock" type="number" wire:model="min_stock"
                    placeholder="100" :error="$errors->first('min_stock')" />
            </div>

            {{-- Input Berat Botol Kosong --}}
            <div class="grid grid-cols-1">
                <x-form-input label="Empty Bottle Weight (Gram)" forId="empty_weight" type="number"
                    wire:model="empty_bottle_weight" placeholder="e.g. 50" :error="$errors->first('empty_bottle_weight')"
                    helpText="Digunakan untuk memudahkan perhitungan stok via timbangan." />
            </div>

            {{-- Action Buttons --}}
            <div class="mt-8 flex justify-end items-center gap-3 pt-4 border-t border-slate-100">
                <button type="button" wire:click="cancel"
                    class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
                    Cancel
                </button>

                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2 px-5 rounded-sm shadow-sm transition-all flex items-center">
                    Save
                </button>
            </div>
        </form>
    </x-modal>

    {{-- MODAL ADD INCOMING STOCK --}}
    <x-modal :show="$isAddStockOpen" title="Record Incoming Stock">
        <form wire:submit.prevent="updateStock" class="space-y-4">
            <div class="my-4">
                <label class="block text-xs font-medium text-slate-600 mb-1">Select Reagent</label>
                <select wire:model="selectedReagentId"
                    class="w-full px-3 py-2 text-sm border border-slate-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 bg-white shadow-sm">
                    <option value="">-- Choose Reagent --</option>
                    @foreach ($reagents as $item)
                        <option value="{{ $item->id }}">{{ $item->name }} (Current: {{ $item->current_stock }}ml)
                        </option>
                    @endforeach
                </select>
                @error('selectedReagentId')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <x-form-input label="Incoming Amount (ML)" forId="inc_amount" type="number" wire:model="incomingAmount"
                placeholder="How many ML arrived?" :error="$errors->first('incomingAmount')" />

            <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" wire:click="cancelIncoming"
                    class="text-sm font-medium text-slate-500 hover:text-slate-800">Cancel</button>
                <button type="submit"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold py-2 px-5 rounded-sm shadow-sm transition-all">
                    Confirm Arrival
                </button>
            </div>
        </form>
    </x-modal>

    {{-- MODAL USE REAGENT (PEMAKAIAN) --}}
    <x-modal :show="$isUseStockOpen" title="Record Reagent Usage">
        <form wire:submit.prevent="useStock" class="space-y-4">
            <div class="my-4">
                <label class="block text-xs font-medium text-slate-600 mb-1">Select Reagent to Use</label>
                <select wire:model="selectedReagentId"
                    class="w-full px-3 py-2 text-sm border border-slate-300 rounded-sm focus:outline-none focus:ring-1 focus:ring-rose-500 bg-white shadow-sm">
                    <option value="">-- Choose Reagent --</option>
                    @foreach ($reagents as $item)
                        <option value="{{ $item->id }}" {{ $item->current_stock <= 0 ? 'disabled' : '' }}>
                            {{ $item->name }} (Available: {{ $item->current_stock }}ml)
                        </option>
                    @endforeach
                </select>
                @error('selectedReagentId')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <x-form-input label="Usage Amount (ML)" forId="use_amount" type="number" wire:model="usageAmount"
                placeholder="How many ML used?" :error="$errors->first('usageAmount')" />

            <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" wire:click="cancelUseStock"
                    class="text-sm font-medium text-slate-500 hover:text-slate-800">Cancel</button>
                <button type="submit"
                    class="bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold py-2 px-5 rounded-sm shadow-sm transition-all">
                    Confirm Usage
                </button>
            </div>
        </form>
    </x-modal>



    <div class="flex flex-col w-1/4 space-y-2">
        <x-plus-svg wire:click="openModal" color="indigo" label="Create New Reagent">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </x-plus-svg>
        <x-plus-svg wire:click="openAddStock" color="emerald" label="Incoming Stock">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </x-plus-svg>
        <x-plus-svg wire:click="openUseStock" color="rose" label="Use Reagent">
            <svg class="w-4 h-4 rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </x-plus-svg>

    </div>


</div>
