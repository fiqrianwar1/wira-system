<x-guest-layout>
    <div class="text-center">
        
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-2 tracking-tight">
            Selamat Datang
        </h1>
        <p class="text-gray-600 mb-8 font-medium text-sm sm:text-base">
            Sistem Informasi Body & Paint <br class="hidden sm:block"> Wira Toyota Banjarmasin
        </p>

        @if (Route::has('login'))
            <div class="space-y-4">
                @auth
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                        <p class="text-green-800 font-semibold text-sm">Halo, {{ Auth::user()->name }}!</p>
                        <p class="text-green-600 text-xs">Kamu sedang aktif.</p>
                    </div>
                    
                    <a href="{{ url('/dashboard') }}" class="block w-full px-4 py-3 bg-red-600 border border-transparent rounded-xl font-bold text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none transition ease-in-out duration-150 shadow-md">
                        Masuk ke Dashboard
                    </a>

                @else
                    <div class="grid grid-cols-1 gap-4">
                        
                        <a href="{{ route('login') }}" class="group relative flex items-center justify-center w-full px-4 py-3 bg-red-600 border border-transparent rounded-xl font-bold text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg transform hover:-translate-y-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-white/80 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Login Petugas
                        </a>

                        <a href="{{ route('login') }}" class="group relative flex items-center justify-center w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl font-bold text-gray-100 uppercase tracking-widest hover:bg-black hover:text-white active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg transform hover:-translate-y-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-gray-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Login Customer
                        </a>

                    </div>

                    <div class="mt-6 text-center">
                        <span class="text-gray-500 text-sm">Belum punya akun?</span>
                        <a href="{{ route('register') }}" class="text-red-600 hover:text-red-800 text-sm font-bold underline ml-1 transition">
                            Daftar Disini
                        </a>
                    </div>
                @endauth
            </div>
        @endif
    </div>
</x-guest-layout>