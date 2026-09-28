<x-guest-layout>
    {{-- WRAPPER RESPONSIVE --}}
    <div class="px-2 sm:px-0 w-full">
        
        {{-- KETERANGAN TEKS --}}
        <div class="mb-6 text-sm text-gray-500 text-center bg-gray-50/50 p-4 rounded-xl border border-gray-100">
            {{ __('Lupa password? Santai bro, masukin aja email lu yang terdaftar. Nanti Wira System bakal ngirim link buat reset password ke email tersebut.') }}
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            {{-- INPUT EMAIL --}}
            <div class="relative">
                <x-input-label for="email" :value="__('Email')" />
                <div class="relative mt-1.5">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <x-text-input id="email" class="block w-full pl-11 py-3 text-sm sm:text-base rounded-xl" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@wira.co.id" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- TOMBOL SUBMIT --}}
            <div class="mt-8">
                <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-black text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-150 uppercase tracking-widest transform hover:-translate-y-0.5">
                    Kirim Link Reset
                </button>
            </div>
            
            {{-- KEMBALI KE LOGIN --}}
            <div class="mt-5 text-center">
                <a href="{{ route('login') }}" class="text-gray-500 hover:text-red-600 text-sm font-bold underline transition-colors">
                    Kembali ke Login
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>