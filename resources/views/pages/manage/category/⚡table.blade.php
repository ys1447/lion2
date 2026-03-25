<?php

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use App\Traits\HasNotification;

new class extends Component {
    use HasNotification;

    protected $listeners = ['category-added', 'category-updated', 'category-deleted' => '$refresh'];

    public function render()
    {
        return $this->view([
            'categories' => Category::all(),
        ]);
    }

    public function edit($id)
    {
        $this->dispatch('edit-category', id: $id);
    }

    public function confirm_delete($id)
    {
        $this->dispatch(
            'confirm-delete',
            id: $id,
            type: 'category', // beda tiap component
        );
    }

    #[On('delete-category')]
    public function delete($id)
    {
        if (Gate::denies('admin-only')) {
            $this->dispatch('alert-error', message: 'Anda tidak memiliki akses untuk menghapus!');
            return;
        }
        
        $category = Category::findOrFail($id);
        $categoryName = $category->name;
        $category->delete();

        $this->sendNotification(
            action: 'DELETE', 
            target: 'Category: ' . $categoryName,
            details: "Delete category {$categoryName} from system"
        );
        
        $this->dispatch('alert-success', message: 'Data berhasil dihapus');
    }
};
?>

<div>
    <x-data-table title="Category List">
        <x-slot:head>
            <th class="px-5 py-3 font-semibold w-16 text-center">No</th>
            <th class="px-5 py-3 font-semibold">Category Name</th>
            <th class="px-5 py-3 font-semibold">Created At</th>
            <th class="px-5 py-3 font-semibold">Action</th>
        </x-slot:head>

        @foreach ($categories as $i => $category)
            <tr class="hover:bg-slate-50 transition-colors align-middle">
                <td class="px-5 py-3 text-center text-slate-500 font-medium">{{ $i + 1 }}</td>
                <td class="px-5 py-3">
                    <span class="font-medium text-slate-700">{{ $category->name }}</span>
                </td>
                <td class="px-5 py-3 text-slate-500">{{ $category->created_at->diffForHumans() }}</td>
                <td class="px-5 py-3 text-right flex items-center">
                    <span wire:click="edit({{ $category->id }})"
                        class="text-indigo-600 hover:text-indigo-900 mr-2 cursor-pointer">
                        <x-edit-svg />
                    </span>
                    <span wire:click="confirm_delete({{ $category->id }})"
                        class="text-red-600 hover:text-red-900 cursor-pointer">
                        <x-delete-svg />
                    </span>
                </td>
            </tr>
        @endforeach
    </x-data-table>
    <x-loading wire:target='edit, delete' />
</div>
