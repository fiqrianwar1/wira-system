<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="flex flex-col space-y-4">
        @csrf

        {{-- BARIS 1: NAMA LENGKAP & ROLE (Kiri - Kanan) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- NAMA LENGKAP --}}
            <div class="relative">
                <x-input-label for="name" :value="__('Nama Lengkap')" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <x-text-input id="name" class="block w-full pl-10" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Fiqri Anwar" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs" />
            </div>

            {{-- DAFTAR SEBAGAI (ROLE) --}}
            <div class="relative">
                <x-input-label for="role" :value="__('Daftar Sebagai')" />
                <div class="relative mt-1">
                     <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .884-.95 2-2.122 2H12h-1c-1.172 0-2.122-1.116-2.122-2" />
                        </svg>
                    </div>
                    <select id="role" name="role" class="block w-full pl-10 border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm cursor-pointer" required>
                        <option value="" disabled selected>Pilih Jabatan...</option>
                        <optgroup label="Internal Wira Toyota">
                            <option value="sa">Service Advisor (SA)</option>
                            <option value="foreman">Controller / Foreman</option>
                            <option value="bahan">Admin Gudang Bahan</option>
                            <option value="sparepart">Admin Gudang Sparepart</option>
                            <option value="monitor">Monitor TV Display</option>
                        </optgroup>
                        <optgroup label="Pengguna">
                            <option value="customer">Customer / Pelanggan</option>
                        </optgroup>
                    </select>
                </div>
                <x-input-error :messages="$errors->get('role')" class="mt-1 text-xs" />
            </div>
        </div>

        {{-- BARIS 2: EMAIL (Full Panjang) --}}
        <div class="relative">
            <x-input-label for="email" :value="__('Email')" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <x-text-input id="email" class="block w-full pl-10" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
        </div>

        {{-- BARIS 3: PASSWORD & KONFIRMASI PASSWORD (Kiri - Kanan) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- PASSWORD --}}
            <div x-data="{ show: false }">
                <x-input-label for="password" :value="__('Password')" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <x-text-input id="password" class="block w-full pl-10 pr-10" ::type="show ? 'text' : 'password'" name="password" required autocomplete="new-password"
                    placeholder="••••••••" />
                    
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-red-600 focus:outline-none transition-colors">
                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
            </div>

            {{-- CONFIRM PASSWORD --}}
            <div x-data="{ show: false }">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <div class="relative mt-1">
                     <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <x-text-input id="password_confirmation" class="block w-full pl-10 pr-10" ::type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" 
                    placeholder="••••••••"/>
                    
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-red-600 focus:outline-none transition-colors">
                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs" />
            </div>
        </div>

        {{-- AREA TOMBOL DAFTAR --}}
        <div class="mt-4 pt-2">
             <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-black text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-150 uppercase tracking-widest transform hover:-translate-y-0.5">
                DAFTAR SEKARANG
            </button>
        </div>

        <div class="text-center pb-2">
            <span class="text-gray-500 text-sm font-medium">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="text-red-600 hover:text-red-800 text-sm font-black underline ml-1 transition-colors">
                Login Disini
            </a>
        </div>
    </form>
</x-guest-layout>