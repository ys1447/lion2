<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Livewire\Attributes\On;


new class extends Component {
    use WithPagination;
    protected $listeners = ['user-added', 'user-updated' , 'user-deleted' => '$refresh'];

    public function edit($id)
    {
        $this->dispatch('edit-user', id: $id);
    }

     public function confirm_delete($id)
    {
        $this->dispatch(
            'confirm-delete',
            id: $id,
            type: 'user', // beda tiap component
        );
    }

    #[On('delete-user')]
    public function delete($id)
    {
        User::findOrFail($id)->delete();
        $this->dispatch('alert-success', message: 'Data berhasil dihapus');
    }

    public function render()
    {
        return $this->view([
            'users' => User::select('id', 'name', 'username', 'role')->latest()->simplePaginate(15),
        ]);
    }
};
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
            @foreach ($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->username }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->role }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center">
                        <span class="text-indigo-600 hover:text-indigo-900 mr-2 cursor-pointer"
                            wire:click="edit({{ $user->id }})">
                            <x-edit-svg />
                        </span>
                        <span class="text-red-600 hover:text-red-900 cursor-pointer" wire:click="confirm_delete({{ $user->id }})">
                            <x-delete-svg />
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>


    <div class="mt-4">
        {{ $users->links() }}
    </div>

    {{-- Loading --}}
    <x-loading wire:target='edit,nextPage, previousPage, gotoPage, delete' />
</div>
