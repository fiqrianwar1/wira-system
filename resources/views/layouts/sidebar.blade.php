<div class="flex flex-col w-64 h-full bg-gray-900 border-r border-gray-800 transition-all duration-300"
     x-cloak
     x-show="sidebarOpen"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="-translate-x-full"
     x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="translate-x-0"
     x-transition:leave-end="-translate-x-full">

    {{-- LOGO BRAND --}}
    <div class="flex-shrink-0 flex items-center justify-center h-16 bg-red-700 shadow-lg z-10 relative overflow-hidden">
        <div class="flex items-center gap-2 text-white font-black text-xl tracking-widest relative z-10">
            <x-application-logo class="w-8 h-8 fill-current text-white drop-shadow-md" />
            <span class="drop-shadow-md">WIRA SYSTEM</span>
        </div>
        <div class="absolute top-0 right-0 w-16 h-full bg-white/10 skew-x-12 -mr-8"></div>
    </div>

    <div class="flex-1 min-h-0 overflow-y-auto py-6 px-4 space-y-1 custom-scrollbar">

        {{-- ========================================================== --}}
        {{-- MENU DASHBOARD UMUM (SA, ADMIN, CUSTOMER, BAHAN)           --}}
        {{-- ========================================================== --}}
        @if(Auth::user()->role !== 'foreman' && Auth::user()->role !== 'sparepart')
            <a href="{{ Auth::user()->role == 'bahan' ? route('bahan.dashboard') : route('dashboard') }}" 
               class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('dashboard') || request()->routeIs('bahan.dashboard') ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('dashboard') || request()->routeIs('bahan.dashboard') ? 'text-white' : 'text-gray-500 group-hover:text-white transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Dashboard
            </a>
        @endif

        {{-- ========================================================== --}}
        {{-- 1. AREA KHUSUS CUSTOMER                                    --}}
        {{-- ========================================================== --}}
        @if(Auth::user()->role == 'customer') 
            <div class="pt-6 pb-2">
                <p class="px-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">
                    Track My Car
                </p>
            </div>

            <a href="{{ route('customer.spareparts') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('customer.spareparts') ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('customer.spareparts') ? 'text-white' : 'text-gray-500 group-hover:text-red-500 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                Status Sparepart
            </a>

            <a href="{{ route('customer.history') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('customer.history') ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('customer.history') ? 'text-white' : 'text-gray-500 group-hover:text-red-500 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Riwayat Perbaikan
            </a>

            {{-- MENU BARU: STATUS KOMPLAIN CUSTOMER --}}
            <a href="{{ route('customer.complaints') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('customer.complaints') ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('customer.complaints') ? 'text-white' : 'text-gray-500 group-hover:text-red-500 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                Status Komplain
            </a>

        {{-- ========================================================== --}}
        {{-- 2. AREA KHUSUS FOREMAN (KEPALA BENGKEL / PRODUKSI)         --}}
        {{-- ========================================================== --}}
        @elseif(Auth::user()->role == 'foreman')
            <div class="pt-6 pb-2">
                <p class="px-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">
                    Operasional Produksi
                </p>
            </div>

            <a href="{{ route('foreman.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('foreman.dashboard') ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('foreman.dashboard') ? 'text-white' : 'text-gray-500 group-hover:text-red-500 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Dashboard
            </a>

            <a href="{{ route('foreman.progress.index') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('foreman.progress.*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('foreman.progress.*') ? 'text-white' : 'text-gray-500 group-hover:text-red-500 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                Progres & Job Sheet
            </a>

            <div class="pt-6 pb-2">
                <p class="px-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">
                    Manajemen SDM
                </p>
            </div>

            <a href="{{ route('mekanik.index') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('mekanik.*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('mekanik.*') ? 'text-white' : 'text-gray-500 group-hover:text-red-500 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Data Mekanik
            </a>

            {{-- MENU BARU: REKAP KINERJA BULANAN --}}
            <div class="pt-6 pb-2">
                <p class="px-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">
                    Laporan Bulanan
                </p>
            </div>

            <a href="{{ route('foreman.rekap') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('foreman.rekap') ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('foreman.rekap') ? 'text-white' : 'text-gray-500 group-hover:text-red-500 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Rekap Kinerja
            </a>

            <a href="{{ route('absensi.index') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('absensi.*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('absensi.*') ? 'text-white' : 'text-gray-500 group-hover:text-red-500 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z" />
                </svg>
                Data Kehadiran
            </a>

        {{-- ========================================================== --}}
        {{-- 3. AREA KHUSUS GUDANG SPAREPART                            --}}
        {{-- ========================================================== --}}
        @elseif(Auth::user()->role == 'sparepart')
            
            <div class="pt-6 pb-2">
                <p class="px-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">
                    Main Menu
                </p>
            </div>

            <a href="{{ route('spareparts.index') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('spareparts.index') ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('spareparts.index') ? 'text-white' : 'text-gray-500 group-hover:text-red-500 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Dashboard
            </a>

            <div class="pt-6 pb-2">
                <p class="px-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">
                    Operasional Logistik
                </p>
            </div>

            <a href="{{ route('spareparts.stocks.index') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('spareparts.stocks.*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('spareparts.stocks.*') ? 'text-white' : 'text-gray-500 group-hover:text-red-500 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Stok Gudang
            </a>

            <a href="{{ route('spareparts.purchases.index') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('spareparts.purchases.*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('spareparts.purchases.*') ? 'text-white' : 'text-gray-500 group-hover:text-red-500 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Monitoring PO
            </a>

        {{-- ========================================================== --}}
        {{-- 4. AREA KHUSUS GUDANG BAHAN (TINTER / OPLOS CAT)           --}}
        {{-- ========================================================== --}}
        @elseif(Auth::user()->role == 'bahan')
            
            <div class="pt-6 pb-2">
                <p class="px-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">
                    Inventori Bahan
                </p>
            </div>

            <a href="{{ route('bahan.stok.index') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('bahan.stok.*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg class="h-5 w-5 mr-3 {{ request()->routeIs('bahan.stok.*') ? 'text-white' : 'text-gray-500 group-hover:text-red-500 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
                Data Stok Bahan
            </a>

            <div class="pt-6 pb-2">
                <p class="px-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">
                    Pendataan Bahan
                </p>
            </div>

            <a href="{{ route('bahan.spk.index') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('bahan.spk.*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg class="h-5 w-5 mr-3 {{ request()->routeIs('bahan.spk.*') ? 'text-white' : 'text-gray-500 group-hover:text-red-500 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                Pemakaian per SPK
            </a>
            
        {{-- ========================================================== --}}
        {{-- 5. AREA KHUSUS SA / ADMIN (DEFAULT)                        --}}
        {{-- ========================================================== --}}
        @else 
            
            <div class="pt-6 pb-2">
                <p class="px-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">
                    Master Data
                </p>
            </div>

            <a href="{{ route('customers.index') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('customers.*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('customers.*') ? 'text-white' : 'text-gray-500 group-hover:text-red-500 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Data Customer
            </a>

            <a href="{{ route('vehicles.index') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('vehicles.*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('vehicles.*') ? 'text-white' : 'text-gray-500 group-hover:text-red-500 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                </svg>
                Data Kendaraan
            </a>

            <div class="pt-6 pb-2">
                <p class="px-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">
                    Operasional SA
                </p>
            </div>

            <a href="{{ route('work-orders.index') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('work-orders.*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('work-orders.*') ? 'text-white' : 'text-gray-500 group-hover:text-red-500 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                SPK / Work Order
            </a>

            <a href="{{ route('spareparts.monitoring') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('spareparts.monitoring') ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('spareparts.monitoring') ? 'text-white' : 'text-gray-500 group-hover:text-red-500 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Tracking Sparepart
            </a>

            {{-- MENU BARU: KELOLA KOMPLAIN SA --}}
            <a href="{{ route('sa.complaints.index') }}" class="flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 group {{ request()->routeIs('sa.complaints.*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 {{ request()->routeIs('sa.complaints.*') ? 'text-white' : 'text-gray-500 group-hover:text-red-500 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                Klaim Garansi
            </a>

        @endif 
    </div>

    {{-- PROFILE USER DI BAWAH --}}
    <div class="flex-shrink-0 border-t border-gray-800 p-4 bg-gray-900">
        <div class="flex items-center group cursor-pointer hover:bg-gray-800 p-2 rounded-xl transition-all">
            <div class="flex-shrink-0">
                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-red-600 to-red-800 flex items-center justify-center text-white font-black shadow-md group-hover:shadow-red-900/50 transition-all">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
            <div class="ml-3 overflow-hidden">
                <p class="text-sm font-black text-gray-200 truncate group-hover:text-white transition-colors">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-red-500 font-bold uppercase tracking-widest">{{ Auth::user()->role }}</p>
            </div>
        </div>
    </div>
</div>