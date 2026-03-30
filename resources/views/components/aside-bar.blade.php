<div>
    <!-- An unexamined life is not worth living. - Socrates -->
    <aside x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
        :class="sidebarOpen ? 'w-64' : 'w-18'"
        class="bg-white border-r border-slate-200 h-full transition-all duration-300 ease-in-out flex flex-col z-40 fixed lg:relative transform overflow-hidden">

        <!-- LOGO SECTION - HANYA GAMBAR -->
        <div class="h-16 flex items-center px-4 border-b border-slate-100 shrink-0">
            <div class="flex items-center space-x-3 p-2 rounded-xl transition-all duration-200">
                <!-- Logo Image -->
                <img src="{{ asset('img/LION.png') }}" alt="Lion Logo"
                    class="w-10 h-10 object-contain hover:scale-110 hover:rotate-3 transition-all duration-300">
            </div>
        </div>

        <!-- MENU -->
        <!-- PERBAIKAN: Tambahkan 'min-h-0' dan 'sidebar-scroll' -->
        <nav class="flex-1 p-3 space-y-1 overflow-y-auto overflow-x-hidden min-h-0 sidebar-scroll">

            <!-- Dashboard -->
            <x-aside-bar-items menu='Dashboard' link='/dashboard'>
                <svg class="w-5 h-5 shrink-0 transition-colors" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </x-aside-bar-items>

            @if (auth()->user()->role === 'admin')
                <x-aside-bar-items menu='Users' link='/users'>
                    <svg class="w-5 h-5 shrink-0 transition-colors" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </x-aside-bar-items>
            @endif

            <x-aside-bar-items menu='Manage' link='/manage'>
                <svg class="w-5 h-5 shrink-0 transition-colors" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </x-aside-bar-items>

            <x-aside-bar-items menu='Job Mixing' link='/job-mixing'>
                <svg class="w-5 h-5 shrink-0 transition-colors" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </x-aside-bar-items>

            <x-aside-bar-items menu='Input Data' link='#' @click="$dispatch('focus-search')">
                <svg class="w-5 h-5 shrink-0 transition-colors" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </x-aside-bar-items>

            <x-aside-bar-items menu='List Hold' link='/list-hold'>
                <svg class="w-5 h-5 shrink-0 transition-colors" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 3h.01" />
                </svg>
            </x-aside-bar-items>

            <x-aside-bar-items menu='List Remix' link='/list-remix'>
                <svg class="w-5 h-5 shrink-0 transition-colors" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </x-aside-bar-items>

            <x-aside-bar-items menu='Filling Issues' link='/filling-issues'>
                <svg class="w-5 h-5 shrink-0 transition-colors" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H15M9 5V9M15 5V9M9 9H15M6 9H18V19C18 20.1046 17.1046 21 16 21H8C6.89543 21 6 20.1046 6 19V9Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13H15" />
                </svg>
            </x-aside-bar-items>



            <x-aside-bar-items menu='Activity Log' link='/list-notification'>
                <svg class="w-5 h-5 shrink-0 transition-colors" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </x-aside-bar-items>

            <x-aside-bar-items menu='Reagent Stock' link='/stock-reagent'>
                <img src="{{ asset('svg/stock.svg') }}" class="w-5 h-5 shrink-0 transition-colors" alt="Stock Icon">
            </x-aside-bar-items>

            <x-aside-bar-items menu='MQM' link='/mqm'>
                <svg class="w-5 h-5 shrink-0 transition-colors" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </x-aside-bar-items>





        </nav>

        <!-- SIDEBAR TOGGLE BUTTON (Desktop) - FIXED -->
        <div class="p-3 border-t border-slate-100 hidden lg:block shrink-0 min-h-15">
            <!-- Button SELALU MUNCUL -->
            <button @click="sidebarOpen = !sidebarOpen"
                class="w-full flex items-center justify-center gap-2 px-3 py-2.5 transition-all duration-50 text-slate-500 hover:text-slate-700 ">
                <!-- Collapse Icon (saat open) -->
                <svg x-show="sidebarOpen" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                </svg>

                <!-- Expand Icon (saat closed) -->
                <svg x-show="!sidebarOpen" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 5l7 7-7 7M5 5l7 7-7 7">
                    </path>
                </svg>

                <!-- Text - HILANG saat collapsed -->
                <span x-show="sidebarOpen" x-transition
                    class="whitespace-nowrap text-sm font-medium transition-opacity duration-50">
                    Collapse
                </span>


            </button>
        </div>


    </aside>


</div>
