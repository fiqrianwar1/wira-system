<nav class="flex items-center justify-between px-6 py-3 bg-white border-b border-gray-100 shadow-sm z-40 sticky top-0 transition-all duration-300">
    
    {{-- KIRI: TOMBOL TOGGLE SIDEBAR & JUDUL HALAMAN --}}
    <div class="flex items-center">
        {{-- Mobile Toggle --}}
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-red-600 focus:outline-none lg:hidden transition-colors mr-3 p-2 rounded-lg hover:bg-gray-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        {{-- Desktop Toggle (Sidebar Collapse) --}}
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-red-600 focus:outline-none hidden lg:block transition-colors transform active:scale-95 mr-4 p-1 rounded-md hover:bg-gray-50">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
        </button>
        
        {{-- JUDUL DINAMIS BERDASARKAN ROLE (FALLBACK PINTAR) --}}
        <h2 class="text-xl font-black text-gray-800 leading-tight hidden sm:block tracking-tight">
            @if(isset($header))
                {{ $header }}
            @else
                @if(Auth::user()->role == 'foreman')
                    Panel Kendali Produksi
                @elseif(Auth::user()->role == 'customer')
                    Status Perbaikan Unit
                @elseif(Auth::user()->role == 'sparepart')
                    Logistik & Sparepart
                @elseif(Auth::user()->role == 'bahan')
                    Inventori & Oplos Bahan
                @else
                    Wira Toyota Body & Paint
                @endif
            @endif
        </h2>
    </div>

    {{-- KANAN: NOTIFIKASI & PROFILE --}}
    <div class="flex items-center space-x-4">
        
        {{-- ROLE BADGE (Udah Keren, Gw Rapihin Dikit Warnanya) --}}
        <span class="hidden md:inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider shadow-sm border border-opacity-20
            @if(Auth::user()->role == 'sa') bg-red-100 text-red-700 border-red-200
            @elseif(Auth::user()->role == 'foreman') bg-blue-100 text-blue-700 border-blue-200
            @elseif(Auth::user()->role == 'sparepart') bg-yellow-100 text-yellow-700 border-yellow-200
            @elseif(Auth::user()->role == 'bahan') bg-purple-100 text-purple-700 border-purple-200
            @else bg-gray-100 text-gray-700 border-gray-200 @endif">
            {{ Auth::user()->role }}
        </span>

        {{-- Bell Notifikasi (Ada Efek Hover) --}}
        <button class="relative p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-full transition-all">
            <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-red-500 animate-pulse ring-2 ring-white"></span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
        </button>

        {{-- Dropdown Profile --}}
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="inline-flex items-center px-4 py-2 border-2 border-gray-50 text-sm leading-4 font-bold rounded-xl text-gray-600 bg-gray-50 hover:bg-white hover:text-red-600 hover:border-red-100 hover:shadow-md focus:outline-none transition ease-in-out duration-200">
                    <div>{{ Auth::user()->name }}</div>
                    <div class="ms-2">
                        <svg class="fill-current h-4 w-4 opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')" class="font-bold text-gray-600 hover:bg-gray-50 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    {{ __('Pengaturan Profile') }}
                </x-dropdown-link>

                <div class="border-t border-gray-100"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf  
                    <x-dropdown-link :href="route('logout')" 
                        onclick="event.preventDefault(); this.closest('form').submit();" 
                        class="text-red-600 font-bold hover:bg-red-50 flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        {{ __('Keluar Aplikasi') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>