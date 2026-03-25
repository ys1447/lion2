<?php

use Livewire\Component;
use App\Models\Variant;
use App\Models\Category;
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

    protected $listeners = ['edit-variant' => 'loadVariant'];

    public function loadVariant($id)
    {
        $this->show = true;
        $this->variantId = $id;

        $variant = Variant::findOrFail($id);

        $this->name = $variant->name;
        $this->slug = $variant->slug;
        $this->capacity = $variant->capacity;
        $this->category_id = $variant->category_id;
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

        $variant = Variant::find($this->variantId);

        // 1. Ambil data LAMA sebelum di-update
        $oldName = $variant->name;
        $oldCapacity = $variant->capacity;
        $oldCategoryId = $variant->category_id;

        $variant->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'capacity' => $this->capacity,
            'category_id' => $this->category_id,
        ]);

        // 3. Susun Pesan Notifikasi Berdasarkan Perubahan
        $changes = [];

        // Cek jika Nama berubah
        if ($oldName !== $this->name) {
            $changes[] = "name from '{$oldName}' to '{$this->name}'";
        }

        // Cek jika Kapasitas berubah
        if ($oldCapacity != $this->capacity) {
            $changes[] = "capacity from {$oldCapacity}ml to {$this->capacity}ml";
        }

        // Cek jika Kategori berubah
        if ($oldCategoryId != $this->category_id) {
            $newCategoryName = Category::find($this->category_id)?->name ?? 'Unknown';
            $changes[] = "category to '{$newCategoryName}'";
        }

        // 4. Gabungkan semua perubahan menjadi satu kalimat
        if (count($changes) > 0) {
            $detailMessage = 'Updated ' . implode(', ', $changes);
        } else {
            $detailMessage = 'Saved without changes';
        }

        $this->sendNotification(action: 'EDIT', target: 'Variant: ' . $this->name, details: $detailMessage);

        $this->dispatch('variant-updated');
        $this->dispatch('alert-success', message: 'Data berhasil diedit');
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
    {{-- You must be the change you wish to see in the world. - Mahatma Gandhi --}}
    <x-modal :show="$show">

        <form wire:submit.prevent="update">
            <x-form-input wire:model="name" label="Name" forId='name' />
            <x-form-input wire:model="capacity" label="Capacity" forId='capacity' />
            <x-select-form label="Category" model="category_id" :options="$categories" />
            <div class="flex justify-end gap-2">
                <button type="button" wire:click="cancel"
                    class="px-4 py-2 text-sm bg-gray-200 rounded-sm hover:bg-gray-300 cursor-pointer">Cancel</button>

                <x-button type="submit">Update</x-button>
            </div>
        </form>
    </x-modal>
</div>
