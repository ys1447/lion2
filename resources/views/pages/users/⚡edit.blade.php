<?php

use Livewire\Component;
use App\Models\User;

new class extends Component {
    public $userId;
    public $name, $username, $role;
    public $show = false;

    protected $listeners = ['edit-user' => 'loadUser'];

    public function loadUser($id)
    {
        $this->show = true;
        $this->userId = $id;

        $user = User::findOrFail($id);

        $this->name = $user->name;
        $this->username = $user->username;
        $this->role = $user->role;
    }

    public function cancel()
    {
        $this->show = false;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $this->userId,
            'role' => 'required',
        ]);

        User::find($this->userId)->update([
            'name' => $this->name,
            'username' => $this->username,
            'role' => $this->role,
        ]);

        $this->dispatch('user-updated');
        $this->show = false;
    }
};
?>

<div>
    <x-modal :show="$show" title="Edit User">

        <form wire:submit.prevent="update">
            <x-form-input wire:model="name" label="Name" forId='name' />
            <x-form-input wire:model="username" label="Username" forId='username' />

            <x-select-form label="Role" model="role" :options="[
                'admin' => 'Admin',
                'user' => 'User',
            ]" />

            <div class="flex justify-end gap-2">
                <button type="button" wire:click="cancel"
                    class="px-4 py-2 text-sm bg-gray-200 rounded-sm hover:bg-gray-300 cursor-pointer">Cancel</button>

                <x-button type="submit">Update</x-button>
            </div>
        </form>
    </x-modal>

</div>
