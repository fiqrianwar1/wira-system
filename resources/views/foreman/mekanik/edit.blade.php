<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('mekanik.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-red-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gray-900 leading-tight">
                    {{ __('✏️ Edit Data Personil') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Manajemen SDM / <span class="text-amber-600 font-bold uppercase tracking-wider">Perbarui Data</span></p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-gray-100">
                
                {{-- HEADER EDIT MODE --}}
                <div class="bg-amber-400 px-8 py-8 relative overflow-hidden flex items-center gap-5">
                    <div class="absolute top-0 right-0 w-64 h-full bg-yellow-300 skew-x-12 -mr-32 opacity-30"></div>
                    <div class="bg-amber-600 p-3 rounded-2xl text-white shadow-inner border border-amber-500 relative z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-xl font-black text-amber-900 tracking-tight">Mode Ubah Data</h3>
                        <p class="text-amber-800 text-xs font-bold mt-1 uppercase tracking-widest">Update data milik: {{ $mechanic->name }}</p>
                    </div>
                </div>

                <form action="{{ route('mekanik.update', $mechanic->id) }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                        
                        {{-- KOLOM KIRI --}}
                        <div class="space-y-6">
                            {{-- NAMA --}}
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ $mechanic->name }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm transition-all" required>
                            </div>

                            {{-- NO HP --}}
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">No. HP / WA</label>
                                <input type="text" name="phone" value="{{ $mechanic->phone }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm transition-all">
                            </div>

                            {{-- STATUS TOGGLE --}}
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-200 flex items-center justify-between shadow-inner">
                                <div>
                                    <span class="text-sm font-black text-gray-800 block">Status Personil</span>
                                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Aktif / Non-Aktif</span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer shadow-sm rounded-full">
                                    {{-- Hidden input fallback --}}
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ $mechanic->is_active ? 'checked' : '' }}>
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
                                        <input type="radio" name="position" value="Leader" class="peer sr-only" {{ $mechanic->position == 'Leader' ? 'checked' : '' }}>
                                        <div class="text-center p-3.5 rounded-xl border-2 border-gray-200 text-gray-500 peer-checked:border-yellow-500 peer-checked:bg-yellow-50 peer-checked:text-yellow-700 font-black transition-all hover:bg-gray-50 shadow-sm text-sm">
                                            👑 Leader
                                        </div>
                                    </label>
                                    <label class="cursor-pointer relative">
                                        <input type="radio" name="position" value="Teknisi" class="peer sr-only" {{ $mechanic->position != 'Leader' ? 'checked' : '' }}>
                                        <div class="text-center p-3.5 rounded-xl border-2 border-gray-200 text-gray-500 peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-800 font-black transition-all hover:bg-gray-50 shadow-sm text-sm">
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
                                    <select name="specialist" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm appearance-none cursor-pointer" required>
                                        <option value="" disabled {{ empty($mechanic->specialist) ? 'selected' : '' }}>- Pilih Spesialis -</option>
                                        <option value="Body" {{ $mechanic->specialist == 'Body' ? 'selected' : '' }}>Body</option>
                                        <option value="Preparation" {{ $mechanic->specialist == 'Preparation' ? 'selected' : '' }}>Preparation</option>
                                        <option value="Paint" {{ $mechanic->specialist == 'Paint' ? 'selected' : '' }}>Paint</option>
                                        <option value="Poles" {{ $mechanic->specialist == 'Poles' ? 'selected' : '' }}>Poles</option>
                                        <option value="Washing" {{ $mechanic->specialist == 'Washing' ? 'selected' : '' }}>Washing</option>
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
                        <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-black py-3.5 px-8 rounded-xl shadow-lg shadow-amber-500/30 transform transition hover:-translate-y-0.5 text-sm uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>