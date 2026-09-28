<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('customers.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-amber-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gray-900 leading-tight">
                    {{ __('Edit Data Pelanggan') }}
                </h2>
                <p class="text-xs text-gray-500 font-bold mt-0.5 uppercase tracking-widest">
                    Pembaruan Profil Customer / <span class="text-amber-600">Wira Toyota</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100">
                
                {{-- HEADER EDIT MODE (AMBER) --}}
                <div class="bg-amber-400 px-8 py-6 flex items-center gap-4 shadow-sm relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-32 h-full bg-amber-500/30 skew-x-12 transform -translate-x-4"></div>
                    <div class="bg-amber-600 p-3 rounded-2xl text-white shadow-inner relative z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-lg font-black text-amber-900 tracking-widest uppercase">Mode Edit Profil</h3>
                        <p class="text-amber-800 text-xs font-bold mt-0.5">Mengubah data: <span class="bg-amber-900 text-amber-100 px-2 py-0.5 rounded ml-1">{{ $customer->name }}</span></p>
                    </div>
                </div>

                <form action="{{ route('customers.update', $customer->id) }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        
                        {{-- KOLOM KIRI --}}
                        <div class="space-y-6">
                            {{-- NAMA --}}
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ $customer->name }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm transition-all" required>
                            </div>

                            {{-- NO HP --}}
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">No. HP / WA</label>
                                <input type="text" name="phone" value="{{ $customer->phone }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm transition-all" required>
                            </div>

                            {{-- EMAIL --}}
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Email (Opsional)</label>
                                <input type="email" name="email" value="{{ $customer->email }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm transition-all">
                            </div>
                        </div>

                        {{-- KOLOM KANAN --}}
                        <div class="space-y-6">
                            {{-- ALAMAT --}}
                            <div class="h-full flex flex-col">
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Alamat Lengkap</label>
                                <textarea name="address" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm transition-all flex-1 min-h-[150px]">{{ $customer->address }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- FOOTER ACTION --}}
                    <div class="flex items-center justify-end border-t border-gray-100 pt-6 gap-4">
                        <a href="{{ route('customers.index') }}" class="px-6 py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-all border border-transparent">
                            Batal
                        </a>
                        <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-amber-500/30 transform transition hover:-translate-y-1 flex items-center gap-2">
                            Simpan Perubahan
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>