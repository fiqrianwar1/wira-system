<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Terima kasih sudah mendaftar! Sebelum memulai, tolong verifikasi email kamu dengan mengklik link yang baru saja kami kirim. Jika tidak masuk, kami bisa kirim ulang.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 border border-green-200 bg-green-50 p-3 rounded-md">
            {{ __('Link verifikasi baru sudah dikirim ke email kamu.') }}
        </div>
    @endif

    <div class="mt-6 flex flex-col items-center space-y-4">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 uppercase tracking-widest">
                Kirim Ulang Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="text-sm text-gray-500 hover:text-red-600 underline focus:outline-none">
                {{ __('Logout / Keluar') }}
            </button>
        </form>
    </div>
</x-guest-layout>