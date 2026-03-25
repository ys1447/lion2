<?php

use Livewire\Component;
use App\Models\User;

new class extends Component {
    public $name, $username, $password, $role;

    public function mount()
    {
        $this->dispatch('focus-input');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        User::create([
            'name' => $this->name,
            'username' => $this->username,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);

        $this->reset();
        $this->dispatch('user-added');
        $this->dispatch('alert-success', message: 'User has been created!');
        $this->dispatch('focus-input');
    }
};
?>

<div>

    {{-- Loading --}}
    <x-loading wire:target='save' />

    {{-- Title --}}
    <h2 class="text-xl font-semibold mb-2 text-indigo-800">Create User</h2>

    {{-- Form --}}
    <form wire:submit.prevent='save'>
        @if ($errors->any())
            <div class="mb-4 p-3 text-sm text-red-700 bg-red-100 border border-red-300 rounded-sm">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <x-form-input wire:model='name' label="Name" class="first-input" forId='name' placeholder="Name"
            :error="$errors->first('name')" />
        <x-form-input wire:model='username' label="Username" forId='username' placeholder="Username"
            :error="$errors->first('username')" />
        <x-form-input wire:model='password' type='password' label="Password" forId='password' placeholder="Password"
            :error="$errors->first('password')" />

        <x-select-form label="Role" model="role" :options="[
            'admin' => 'Admin',
            'user' => 'User',
        ]" />

        <x-button type="submit"> Create New User </x-button>
    </form>

</div>
