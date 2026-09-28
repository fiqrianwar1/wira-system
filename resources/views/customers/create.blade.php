<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('customers.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-red-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gray-900 leading-tight">
                    {{ __('Tambah Pelanggan') }}
                </h2>
                <p class="text-xs text-gray-500 font-bold mt-0.5 uppercase tracking-widest">
                    Input Data Customer Baru / <span class="text-red-600">Wira Toyota</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100">
                
                {{-- HEADER CARD --}}
                <div class="bg-gray-900 px-8 py-6 flex items-center gap-4">
                    <div class="bg-blue-500/20 p-3 rounded-2xl text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-white uppercase tracking-widest">Form Pelanggan Baru</h3>
                        <p class="text-gray-400 text-xs font-medium mt-1">Masukkan data diri customer / pemilik kendaraan.</p>
                    </div>
                </div>

                <form action="{{ route('customers.store') }}" method="POST" class="p-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        
                        {{-- KOLOM KIRI --}}
                        <div class="space-y-6">
                            {{-- NAMA --}}
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Nama Lengkap</label>
                                <input type="text" name="name" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold shadow-sm transition-all" placeholder="Contoh: Ahmad Subagyo" required>
                            </div>

                            {{-- NO HP --}}
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">No. HP / WA</label>
                                <input type="text" name="phone" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold shadow-sm transition-all" placeholder="08xxxxxxxxxx" required>
                            </div>

                            {{-- EMAIL --}}
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Email (Opsional)</label>
                                <input type="email" name="email" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold shadow-sm transition-all" placeholder="email@contoh.com">
                            </div>
                        </div>

                        {{-- KOLOM KANAN --}}
                        <div class="space-y-6">
                            {{-- ALAMAT --}}
                            <div class="h-full flex flex-col">
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Alamat Lengkap</label>
                                <textarea name="address" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold shadow-sm transition-all flex-1 min-h-[150px]" placeholder="Masukkan alamat lengkap domisili..."></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- FOOTER ACTION --}}
                    <div class="flex items-center justify-end border-t border-gray-100 pt-6 gap-4">
                        <a href="{{ route('customers.index') }}" class="px-6 py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-all border border-transparent">
                            Batal
                        </a>
                        <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-gray-900/30 transform transition hover:-translate-y-1 flex items-center gap-2">
                            Simpan Data
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>