<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div>
    <!-- CONTENT -->
    <main class="flex-1 p-4 lg:p-6 overflow-y-auto bg-slate-50">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
            <p class="text-slate-500 text-sm">Welcome back, Alex! Here is what's happening today.</p>
        </div>

        <!-- STATS CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Card 1 -->
            <div
                class="bg-white rounded-xl p-4 shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-slate-500 text-xs uppercase font-semibold">Total Revenue</p>
                    <p class="text-xl font-bold text-slate-800">$45,231</p>
                </div>
            </div>

            <!-- Card 2 -->
            <div
                class="bg-white rounded-xl p-4 shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div>
                    <p class="text-slate-500 text-xs uppercase font-semibold">Sales</p>
                    <p class="text-xl font-bold text-slate-800">1,250</p>
                </div>
            </div>

            <!-- Card 3 -->
            <div
                class="bg-white rounded-xl p-4 shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-slate-500 text-xs uppercase font-semibold">New Users</p>
                    <p class="text-xl font-bold text-slate-800">320</p>
                </div>
            </div>

            <!-- Card 4 -->
            <div
                class="bg-white rounded-xl p-4 shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center text-orange-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-slate-500 text-xs uppercase font-semibold">Pending Orders</p>
                    <p class="text-xl font-bold text-slate-800">12</p>
                </div>
            </div>
        </div>

        <!-- RECENT ACTIVITY / TABLE -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-4 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-semibold text-slate-800">Recent Transactions</h3>
                <button class="text-indigo-600 text-sm font-medium hover:underline">View All</button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Transaction ID</th>
                            <th class="px-6 py-3">Customer</th>
                            <th class="px-6 py-3">Amount</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-700">#TNX98234</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://i.pravatar.cc/32?img=1" class="w-7 h-7 rounded-full">
                                    <span>Sarah Connor</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800">$250.00</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Completed</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-700">#TNX98235</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://i.pravatar.cc/32?img=2" class="w-7 h-7 rounded-full">
                                    <span>John Doe</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800">$125.00</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Pending</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-700">#TNX98236</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://i.pravatar.cc/32?img=3" class="w-7 h-7 rounded-full">
                                    <span>Jane Smith</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800">$420.00</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Failed</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</div>
