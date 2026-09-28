<x-guest-layout>
    {{-- TAMBAHAN WRAPPER BIAR DI HP GAK MENTOK PINGGIR --}}
    <div class="px-2 sm:px-0 w-full">
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- EMAIL --}}
            <div class="relative">
                <x-input-label for="email" :value="__('Email')" />
                <div class="relative mt-1.5">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    {{-- DIBIKIN PY-3 BIAR INPUTNYA GENDUT ENAK DIKLIK DI HP --}}
                    <x-text-input id="email" class="block w-full pl-11 py-3 text-sm sm:text-base rounded-xl" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@wira.co.id" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- PASSWORD --}}
            <div x-data="{ show: false }">
                <x-input-label for="password" :value="__('Password')" />
                <div class="relative mt-1.5">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>

                    <x-text-input id="password" class="block w-full pl-11 pr-12 py-3 text-sm sm:text-base rounded-xl" 
                                    ::type="show ? 'text' : 'password'"
                                    name="password" required autocomplete="current-password" placeholder="••••••••" />

                    <button type="button" @click="show = !show" 
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- REMEMBER ME & LUPA PASSWORD (SUDAH DITAMBAHKAN DI SINI) --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mt-4">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500 w-4 h-4" name="remember">
                    <span class="ms-2 text-sm text-gray-600 font-medium">{{ __('Ingat Saya') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="underline text-sm font-bold text-gray-500 hover:text-red-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors" href="{{ route('password.request') }}">
                        {{ __('Lupa Password?') }}
                    </a>
                @endif
            </div>

            {{-- TOMBOL LOGIN --}}
            <div class="mt-8">
                <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-black text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-150 uppercase tracking-widest transform hover:-translate-y-0.5">
                    MASUK SEKARANG
                </button>
            </div>

            {{-- DAFTAR BARU --}}
            <div class="mt-5 text-center bg-gray-50/50 py-3 rounded-xl border border-gray-100">
                <span class="text-gray-500 text-sm font-medium">Belum punya akun?</span>
                <a href="{{ route('register') }}" class="text-red-600 hover:text-red-800 text-sm font-black underline ml-1 transition-colors">
                    Daftar Akun Baru
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>