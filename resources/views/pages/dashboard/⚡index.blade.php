<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {};
?>

<!-- Pastikan pembungkus paling luar memiliki h-screen dan overflow-hidden -->
<div class="flex h-screen overflow-hidden bg-slate-50">

    <!-- Sidebar kamu di sini (jika ada) -->

    <!-- CONTENT AREA -->
    <div class="flex flex-col flex-1 min-w-0">

        <!-- Header/Navbar kamu di sini (jika ada) -->

        <main class="flex-1 p-4 lg:p-6 overflow-y-auto" id="main-content">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
                <p class="text-slate-500 text-sm">
                    Welcome back, <span class="font-semibold text-indigo-600">{{ auth()->user()->name }}</span>! Here is
                    what's happening today.
                </p>
            </div>

            <!-- Grid Wrapper untuk Komponen Dashboard agar rapi -->
            <div class="space-y-6">
                <livewire:pages::dashboard.total-mixing-today />

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <livewire:pages::dashboard.total-hold />
                    <!-- Tambahkan komponen lain di sini jika perlu -->
                </div>

                <livewire:pages::dashboard.list-issues />
                <livewire:pages::dashboard.filling-issues />
            </div>
        </main>



    </div>





</div>
