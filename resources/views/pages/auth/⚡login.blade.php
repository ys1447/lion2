<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component {
    public $username;
    public $password;

    public function login()
    {
    
        // Tinggal validasi ya ...
        
        if (
            !Auth::attempt([
                'username' => $this->username,
                'password' => $this->password,
            ])
        ) {
            $this->addError('username', 'Username atau password salah');
            return;
        }

        session()->regenerate();

        return redirect('/dashboard')
    ->with('welcome', auth()->user()->name . "! Have a nice day! 🚀");
    }

    public function render()
    {
        return $this->view()->layout('layouts::auth');
    }
};
?>

<!-- Split Screen Kompak -->
<div
    class="min-h-screen bg-linear-to-br from-indigo-50 via-white to-purple-50 flex items-center justify-center py-4 px-4 sm:px-6">
    <div class="max-w-3xl w-full">

        {{-- Loading --}}
        <x-loading wire:target='login'/>

        <!-- Form Login (Kiri) - DIPERKECIL -->
        <div class="lg:py-6">
            <div class="max-w-sm mx-auto">

                <!-- Header - DIPERKECIL -->
                <div class="text-center mb-6">
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('img/LION.png') }}" alt="Logo"
                            class="w-14 h-14 object-contain drop-shadow-md">
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang</h2>
                    <p class="text-sm text-gray-500">Masuk untuk melanjutkan</p>
                </div>

                <!-- Form - DIPERKECIL -->
                <form class="space-y-4" wire:submit.prevent="login">
                    <!-- Username -->
                    <x-form-input wire:model="username"  class="first-input" label="Username" forId='username'
                        placeholder="Username Anda" :error="$errors->first('username')" />

                    <!-- Password -->
                    <x-form-input type="password" wire:model="password"  label="Password" placeholder="Password Anda" forId='password'
                        :error="$errors->first('password')" />

                    <!-- Tombol -->
                    <x-button type="submit"> Masuk </x-button>
                </form>

                
            </div>
        </div>


    </div>
</div>
