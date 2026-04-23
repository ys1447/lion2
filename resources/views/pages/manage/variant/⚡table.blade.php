<?php

use Livewire\Component;
use App\Models\Variant;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Traits\HasNotification;

new class extends Component {
    use HasNotification, WithPagination;
    protected $listeners = ['variant-added', 'variant-updated', 'variant-deleted' => '$refresh'];

    public function edit($id)
    {
        $this->dispatch('edit-variant', id: $id);
    }

    public function render()
    {
        return $this->view([
            'variants' => Variant::with('category')->paginate(10),
        ]);
    }

    public function confirm_delete($id)
    {
        $this->dispatch(
            'confirm-delete',
            id: $id,
            type: 'variant', // beda tiap component
        );
    }

    #[On('delete-variant')]
    public function delete($id)
    {
        if (Gate::denies('admin-only')) {
            $this->dispatch('alert-error', message: 'Anda tidak memiliki akses untuk menghapus!');
            return;
        }
        
        $variant = Variant::findOrFail($id);
        $variantName = $variant->name;
        $variant->delete();


        $this->sendNotification(
            action: 'DELETE', 
            target: 'Variant: ' . $variantName,
            details: "Delete variant {$variantName} from system"
        );

        $this->dispatch('alert-success', message: 'Data berhasil dihapus');
    }
};
?>

<div>
    {{-- Smile, breathe, and go slowly. - Thich Nhat Hanh --}}
    <x-data-table title="Variant List">
        <x-slot:head>
            <th class="px-5 py-3 font-semibold w-16 text-center">No</th>
            <th class="px-5 py-3 font-semibold">Variant Name</th>
            <th class="px-5 py-3 font-semibold">Capacity</th>
            <th class="px-5 py-3 font-semibold">Uniqe Link</th>
            <th class="px-5 py-3 font-semibold">Category</th>
            <th class="px-5 py-3 font-semibold">Created At</th>
            <th class="px-5 py-3 font-semibold">Action</th>
        </x-slot:head>

        @foreach ($variants as $i => $variant)
            <tr wire:key="variant-{{ $variant->id }}" class="hover:bg-slate-50 transition-colors align-middle">
                <td class="px-5 py-3 text-center text-slate-500 font-medium">{{ $i + 1 }}</td>
                <td class="px-5 py-3">
                    <span class="font-medium text-slate-700">{{ $variant->name }}</span>
                </td>
                <td class="px-5 py-3">
                    <span class="font-medium text-slate-700">{{ $variant->capacity }}</span>
                </td>
                <td class="px-5 py-3">
                    <span class="font-medium text-slate-700">{{ $variant->slug }}</span>
                </td>
                <td class="px-5 py-3">
                    <span class="font-medium text-slate-700">{{ $variant->category->name }}</span>
                </td>
                <td class="px-5 py-3 text-slate-500">{{ $variant->created_at->diffForHumans() }}</td>
                <td class="px-5 py-3 text-right flex items-center">
                    <span wire:click="edit({{ $variant->id }})"
                        class="text-indigo-600 hover:text-indigo-900 mr-2 cursor-pointer">
                        <x-edit-svg />
                    </span>
                    <span wire:click="confirm_delete({{ $variant->id }})"
                        class="text-red-600 hover:text-red-900 cursor-pointer">
                        <x-delete-svg />
                    </span>
                </td>
            </tr>
        @endforeach
    </x-data-table>
    <div class="mt-4 px-5">
        {{ $variants->links() }}
    </div>
    <x-loading wire:target="edit, delete" />
</div>
