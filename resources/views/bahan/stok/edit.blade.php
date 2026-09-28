<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('bahan.stok.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-red-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="py-1">
                <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                    {{ __('✏️ Revisi Data Master') }}
                </h2>
                <p class="text-sm text-gray-500 font-bold mt-1">
                    Koreksi Stok & HPP / <span class="text-amber-600 uppercase tracking-wider">Update Material</span>
                </p>
            </div>
        </div>
    </x-slot>

    {{-- JARAK ATAS DIPANGKAS JADI pt-5 --}}
    <div class="pt-5 pb-10 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-5 rounded-2xl shadow-sm animate-pulse">
                    <p class="font-black uppercase tracking-widest text-xs mb-2">Gagal update! Cek isiannya bre:</p>
                    <ul class="list-disc list-inside text-sm font-bold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-2xl shadow-gray-200/50 sm:rounded-[2.5rem] border border-gray-100">
                
                {{-- HEADER EDIT MODE (AMBER) --}}
                <div class="bg-amber-400 px-8 py-8 flex items-center gap-5 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-full bg-yellow-300 skew-x-12 -mr-32 opacity-30"></div>
                    <div class="bg-amber-600 p-3 rounded-2xl text-white shadow-inner border border-amber-500 relative z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-xl font-black text-amber-900 tracking-tight">MODE KOREKSI DATA BAHAN</h3>
                        <p class="text-amber-800 text-xs font-bold uppercase tracking-widest mt-1">Kode Material: <span class="bg-amber-800 text-amber-100 px-2 py-0.5 rounded ml-1">{{ $bahan->kode_bahan }}</span></p>
                    </div>
                </div>

                <form action="{{ route('bahan.stok.update', $bahan->id) }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    @method('PUT')

                    {{-- TIPS BOX --}}
                    <div class="mb-8 bg-blue-50/50 border border-blue-100 p-5 rounded-2xl flex gap-4 items-start">
                        <div class="bg-blue-100 p-2 rounded-xl text-blue-500 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-blue-800 uppercase tracking-widest mb-1.5">Pusat Informasi</p>
                            <p class="text-xs text-blue-700 font-medium leading-relaxed">Form ini digunakan khusus untuk <b>koreksi kesalahan data</b> (salah ketik nama, penyesuaian selisih stok opname, atau update harga HPP). Untuk menambah stok dari faktur/barang masuk, gunakan menu <a href="{{ route('bahan.stok.create') }}" class="font-black underline hover:text-blue-900">Tambah Stok Baru</a>.</p>
                        </div>
                    </div>

                    {{-- INFORMASI DASAR BAHAN --}}
                    <div class="bg-gray-50/50 p-6 rounded-3xl border border-gray-100 mb-8">
                        <h4 class="font-black text-gray-400 text-[10px] uppercase tracking-widest mb-5 flex items-center gap-2 border-b border-gray-200 pb-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Identitas Material
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Kode </label>
                                <input type="text" name="kode_bahan" value="{{ $bahan->kode_bahan }}" required class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-mono font-bold shadow-sm transition-colors">
                            </div>
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Nama Bahan / Merek</label>
                                <input type="text" name="nama_bahan" value="{{ $bahan->nama_bahan }}" required class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm transition-colors">
                            </div>
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Kategori</label>
                                <select name="kategori" required class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm transition-colors cursor-pointer">
                                    <option value="Cat" {{ $bahan->kategori == 'Cat' ? 'selected' : '' }}>Cat Basecoat</option>
                                    <option value="Thinner" {{ $bahan->kategori == 'Thinner' ? 'selected' : '' }}>Thinner</option>
                                    <option value="Clear" {{ $bahan->kategori == 'Clear' ? 'selected' : '' }}>Clear Coat</option>
                                    <option value="Dempul" {{ $bahan->kategori == 'Dempul' ? 'selected' : '' }}>Dempul</option>
                                    <option value="Epoxy" {{ $bahan->kategori == 'Epoxy' ? 'selected' : '' }}>Epoxy</option>
                                    <option value="Amplas" {{ $bahan->kategori == 'Amplas' ? 'selected' : '' }}>Amplas</option>
                                    <option value="Lainnya" {{ $bahan->kategori == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Satuan (UOM)</label>
                                <select name="satuan" required class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm transition-colors cursor-pointer">
                                    <option value="Gram" {{ $bahan->satuan == 'Gram' ? 'selected' : '' }}>Gram (g)</option>
                                    <option value="Kg" {{ $bahan->satuan == 'Kg' ? 'selected' : '' }}>Kilogram (Kg)</option>
                                    <option value="cc" {{ $bahan->satuan == 'cc' ? 'selected' : '' }}>cc / mL</option>
                                    <option value="Set" {{ $bahan->satuan == 'Set' ? 'selected' : '' }}>Set</option>
                                    <option value="Pcs" {{ $bahan->satuan == 'Pcs' ? 'selected' : '' }}>Pcs / Lembar</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- INFORMASI STOK & SUPPLIER --}}
                    <div class="bg-amber-50/50 rounded-3xl border border-amber-200 overflow-hidden shadow-sm mb-6">
                        <div class="bg-amber-100/50 px-6 py-4 border-b border-amber-200">
                            <h3 class="font-black text-amber-900 text-sm uppercase tracking-widest flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                Penyesuaian Stok & HPP
                            </h3>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-amber-900 text-[10px] font-black mb-2 uppercase tracking-widest">Supplier / Asal Toko</label>
                                <input type="text" name="supplier" value="{{ $bahan->supplier }}" class="w-full bg-white border border-amber-300 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm transition-colors">
                            </div>
                            <div>
                                <label class="block text-amber-900 text-[10px] font-black mb-2 uppercase tracking-widest">Nomor Nota / Invoice</label>
                                <input type="text" name="nomor_nota" value="{{ $bahan->nomor_nota }}" class="w-full bg-white border border-amber-300 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm transition-colors">
                            </div>
                            <div>
                                <label class="block text-amber-900 text-[10px] font-black mb-2 uppercase tracking-widest">Update Foto Nota</label>
                                <div class="flex items-center gap-3">
                                    {{-- PREVIEW FOTO (Diperbesar & Dikasih Shadow Biar Rapi) --}}
                                    @if($bahan->foto_nota)
                                        <a href="{{ asset('storage/' . $bahan->foto_nota) }}" target="_blank" class="shrink-0 w-14 h-14 bg-white rounded-xl border border-amber-300 shadow-sm overflow-hidden hover:opacity-75 transition-all flex items-center justify-center p-0.5" title="Lihat Foto Saat Ini">
                                            <img src="{{ asset('storage/' . $bahan->foto_nota) }}" class="w-full h-full object-cover rounded-lg" alt="Nota">
                                        </a>
                                    @endif
                                    
                                    {{-- INPUT FILE (Dikasih flex-1 biar ngisi sisa ruang dengan rata) --}}
                                    <div class="flex-1">
                                        <input type="file" name="foto_nota" accept="image/*" class="w-full bg-white border border-amber-300 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-2 font-bold shadow-sm transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-amber-100 file:text-amber-800 hover:file:bg-amber-200 cursor-pointer">
                                    </div>
                                </div>
                                <p class="text-[10px] text-amber-700 font-medium mt-1.5">Upload baru untuk mengganti foto lama.</p>
                            </div>
                            <div>
                                <label class="block text-amber-900 text-[10px] font-black mb-2 uppercase tracking-widest">Koreksi Stok Fisik</label>
                                <input type="number" step="0.1" min="0" name="stok" value="{{ $bahan->stok }}" required class="w-full bg-white border border-amber-300 text-gray-900 text-xl rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3 font-black shadow-sm transition-colors text-center">
                                <p class="text-[10px] text-amber-700 font-medium mt-1.5">Ubah angka ini jika terdapat selisih saat opname.</p>
                            </div>
                            <div>
                                <label class="block text-amber-900 text-[10px] font-black mb-2 uppercase tracking-widest">Modal / Satuan (Rp)</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 font-black">Rp</span>
                                    <input type="number" name="harga_satuan" value="{{ $bahan->harga_satuan }}" required class="w-full pl-12 bg-white border border-amber-300 text-gray-900 text-xl rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3 font-black font-mono shadow-sm transition-colors text-right">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- FOOTER ACTION --}}
                    <div class="flex items-center justify-end border-t border-gray-100 pt-8 mt-4 gap-4">
                        <a href="{{ route('bahan.stok.index') }}" class="px-6 py-3.5 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-all border border-transparent hover:border-gray-200 text-sm uppercase tracking-widest">
                            Batal
                        </a>
                        <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-black py-3.5 px-8 rounded-xl shadow-lg shadow-amber-500/30 transform transition hover:-translate-y-0.5 flex items-center gap-2 text-sm uppercase tracking-widest">
                            Simpan Perubahan
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>