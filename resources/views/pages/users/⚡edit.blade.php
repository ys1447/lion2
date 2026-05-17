<?php

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


new class extends Component {
    public $userId;
    public $name, $username, $role;
    public $show = false;
    public $password, $password_confirmation;

    protected $listeners = ['edit-user' => 'loadUser'];

    public function loadUser($id)
    {
        $this->show = true;
        $this->userId = $id;

        $user = User::findOrFail($id);

        $this->name = $user->name;
        $this->username = $user->username;
        $this->role = $user->role;
        // reset password field
        $this->password = '';
        $this->password_confirmation = '';
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

            // password optional
            'password' => 'nullable|min:4|confirmed',
        ]);

        $data = [
            'name' => $this->name,
            'username' => $this->username,
            'role' => $this->role,
        ];

        // hanya update password kalau diisi
        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        User::find($this->userId)->update($data);

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
            <x-form-input
                wire:model="password"
                label="Password Baru"
                forId="password"
                type="password" />

            <x-form-input
                wire:model="password_confirmation"
                label="Konfirmasi Password"
                forId="password_confirmation"
                type="password" />

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