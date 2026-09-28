<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('mekanik.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-red-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gray-900 leading-tight">
                    {{ __('➕ Tambah Personil') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Manajemen SDM / <span class="text-blue-600 font-bold uppercase tracking-wider">Input Data Baru</span></p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-gray-100">
                
                {{-- HEADER CARD --}}
                <div class="bg-gray-900 px-8 py-8 relative overflow-hidden flex items-center gap-5">
                    <div class="absolute top-0 right-0 w-64 h-full bg-blue-600 skew-x-12 -mr-32 opacity-20"></div>
                    <div class="bg-blue-600 p-3 rounded-2xl text-white shadow-lg relative z-10 border border-blue-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-xl font-black text-white tracking-tight">Form Data Mekanik Baru</h3>
                        <p class="text-gray-400 text-xs mt-1 font-bold uppercase tracking-widest">Lengkapi form identitas di bawah ini.</p>
                    </div>
                </div>

                <form action="{{ route('mekanik.store') }}" method="POST" class="p-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                        
                        {{-- KOLOM KIRI --}}
                        <div class="space-y-6">
                            {{-- NAMA --}}
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Nama Lengkap</label>
                                <input type="text" name="name" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold shadow-sm transition-all" placeholder="Contoh: Budi Santoso" required>
                            </div>

                            {{-- NO HP --}}
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">No. HP / WA</label>
                                <input type="text" name="phone" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold shadow-sm transition-all" placeholder="08xxxxxxxxxx">
                            </div>

                            {{-- STATUS TOGGLE (FIXED LOGIC) --}}
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-200 flex items-center justify-between shadow-inner">
                                <div>
                                    <span class="text-sm font-black text-gray-800 block">Status Personil</span>
                                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Aktif / Non-Aktif</span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer shadow-sm rounded-full">
                                    {{-- Hidden input buat fallback kalo toggle dimatikan --}}
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                                    <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-500 shadow-inner"></div>
                                </label>
                            </div>
                        </div>

                        {{-- KOLOM KANAN --}}
                        <div class="space-y-6">
                            {{-- POSISI (RADIO) --}}
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Pilih Jabatan</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="cursor-pointer relative">
                                        <input type="radio" name="position" value="Leader" class="peer sr-only">
                                        <div class="text-center p-3.5 rounded-xl border-2 border-gray-200 text-gray-500 peer-checked:border-yellow-500 peer-checked:bg-yellow-50 peer-checked:text-yellow-700 font-black transition-all hover:bg-gray-50 shadow-sm text-sm">
                                            👑 Leader
                                        </div>
                                    </label>
                                    <label class="cursor-pointer relative">
                                        <input type="radio" name="position" value="Teknisi" class="peer sr-only" checked>
                                        <div class="text-center p-3.5 rounded-xl border-2 border-gray-200 text-gray-500 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 font-black transition-all hover:bg-gray-50 shadow-sm text-sm">
                                            🔧 Teknisi
                                        </div>
                                    </label>
                                </div>
                            </div>

                            {{-- SPESIALIS (SELECT) --}}
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Spesialis (Stel)</label>
                                <div class="relative">
                                    {{-- TAMBAHIN REQUIRED DI SINI --}}
                                    <select name="specialist" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold shadow-sm appearance-none cursor-pointer" required>
                                        {{-- TAMBAHIN DISABLED SELECTED BIAR GAK BISA DIPILIH --}}
                                        <option value="" disabled selected>- Pilih Spesialis -</option>
                                        <option value="Body">Body</option>
                                        <option value="Preparation">Preparation</option>
                                        <option value="Paint">Paint</option>
                                        <option value="Poles">Poles</option>
                                        <option value="Washing">Washing</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                {{-- PESAN ERROR MERAH KALO DITEMBUS --}}
                                @error('specialist')
                                    <p class="text-red-500 text-xs font-bold mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Spesialis wajib dipilih bro!
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- FOOTER ACTION --}}
                    <div class="flex items-center justify-end border-t border-gray-100 pt-8 gap-4">
                        <a href="{{ route('mekanik.index') }}" class="px-6 py-3.5 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-all border border-transparent hover:border-gray-200 text-sm uppercase tracking-widest">
                            Batal
                        </a>
                        <button type="submit" class="bg-gray-900 hover:bg-blue-600 text-white font-black py-3.5 px-8 rounded-xl shadow-lg transform transition hover:-translate-y-0.5 text-sm uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>