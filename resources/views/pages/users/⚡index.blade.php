<?php
    // 
use Livewire\Component;

new class extends Component {};
?>

<div class="flex-1 p-4 lg:p-6 bg-slate-50 h-screen overflow-y-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Users Overview</h1>
        <p class="text-slate-500 text-sm">
            Manage data, add new users, or update profile information here.
        </p>
    </div>

    <!-- Tab Content -->
    <div class="mt-6 flex flex-col md:flex-row items-start gap-6">

    <!-- Left Section: Add User -->
    <div class="w-full md:w-1/3 p-6 bg-white rounded-sm shadow-sm">
        <livewire:pages::users.create />
    </div>

    <!-- Right Section: User List -->
    <div class="w-full md:w-2/3 p-6 bg-white rounded-sm shadow-sm border border-gray-200">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">List Users</h2>
        <livewire:pages::users.table />
    </div>

    {{-- Modal Edit --}}
    <livewire:pages::users.edit />

</div>
</div>
