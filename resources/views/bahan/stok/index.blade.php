<x-app-layout>
    <x-slot name="header">
        <div class="py-1">
            <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                {{ __('📦 Master Stok Bahan') }}
            </h2>
            <p class="text-sm text-gray-500 font-bold mt-1">
                Manajemen inventori Cat, Thinner, Dempul, dll / <span class="text-purple-600 uppercase tracking-wider">Wira Toyota</span>
            </p>
        </div>
    </x-slot>

    <div class="pt-5 pb-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- ALERT SUKSES SERAGAM --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-xl font-bold flex items-center gap-3 animate-bounce mx-4 sm:mx-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- MINI STATS WIDGET --}}
            @php
                $totalItem = $bahans->count();
                $kritis = $bahans->where('stok', '<=', 5)->count();
                $nilaiAset = $bahans->sum(function($item) { return $item->stok * $item->harga_satuan; });
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mx-4 sm:mx-0">
                <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg></div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Jenis Bahan</p>
                        <p class="text-2xl font-black text-gray-800">{{ $totalItem }} <span class="text-sm font-bold text-gray-500">Item</span></p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Nilai Aset Gudang</p>
                        <p class="text-2xl font-black text-gray-800">Rp {{ number_format($nilaiAset, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4 relative overflow-hidden hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-2xl {{ $kritis > 0 ? 'bg-red-50 text-red-600 border-red-100' : 'bg-blue-50 text-blue-600 border-blue-100' }} flex items-center justify-center"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Status Stok Kritis</p>
                        <p class="text-2xl font-black {{ $kritis > 0 ? 'text-red-600' : 'text-gray-800' }}">{{ $kritis }} <span class="text-sm font-bold text-gray-500">Item</span></p>
                    </div>
                </div>
            </div>

            {{-- AREA TABEL --}}
            <div class="bg-white shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100 mx-4 sm:mx-0 overflow-hidden relative" x-data="{ showNotaModal: false, activeNota: '', activeNama: '', activeNotaNo: '', activeSupplier: '' }">
                
                {{-- HEADER TABLE DENGAN SEARCH & TOOLBAR --}}
                <div class="p-6 lg:p-8 border-b border-gray-100 bg-white flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    
                    {{-- INFO KIRI --}}
                    <div class="hidden lg:block w-full lg:w-auto">
                        <h3 class="font-black text-xl text-gray-900 leading-none">Daftar Material Gudang</h3>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Cari atau Tambah Stok Bahan</p>
                    </div>

                    {{-- SEARCH & ACTIONS --}}
                    <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto items-center">
                        
                        {{-- FORM SEARCH --}}
                        <form method="GET" action="{{ route('bahan.stok.index') }}" class="relative w-full sm:w-72 group" onsubmit="return false;">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" id="cariBahan" name="search" value="{{ request('search') }}" class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 bg-gray-50 rounded-2xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white transition-all font-bold text-sm shadow-sm" placeholder="Cari Kode, Nama Bahan...">
                        </form>

                        {{-- GROUP BUTTONS --}}
                        <div class="flex gap-2 w-full sm:w-auto">
                            <a href="{{ route('bahan.stok.print') }}" target="_blank" class="flex-1 sm:flex-none px-5 py-3.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-2xl shadow-sm hover:bg-gray-50 hover:text-green-600 hover:border-green-300 transition-all flex items-center justify-center gap-2 text-sm whitespace-nowrap group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Laporan
                            </a>
                            <a href="{{ route('bahan.stok.create') }}" class="flex-1 sm:flex-none px-6 py-3.5 bg-gray-900 text-white font-bold rounded-2xl shadow-lg shadow-gray-900/30 hover:bg-red-600 transition-all flex items-center justify-center gap-2 text-sm transform hover:-translate-y-0.5 whitespace-nowrap">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Baru
                            </a>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[900px]" id="tabelBahan">
                        <thead>
                            <tr class="bg-gray-50/50 text-gray-400 text-[10px] uppercase tracking-[0.2em] border-b border-gray-100">
                                <th class="px-6 py-5 font-black">Kode</th>
                                <th class="px-6 py-5 font-black">Detail Bahan & Supplier</th>
                                <th class="px-6 py-5 font-black text-center">Stok Fisik</th>
                                <th class="px-6 py-5 font-black text-right">Nilai Aset & HPP</th>
                                <th class="px-6 py-5 font-black text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @forelse($bahans as $item)
                                @php
                                    $katLabel = $item->kategori;
                                    if($katLabel == 'Cat') $katLabel = 'Cat Basecoat';
                                    elseif($katLabel == 'Clear') $katLabel = 'Clear Coat';
                                    
                                    $satLabel = $item->satuan;
                                    if($satLabel == 'Gram') $satLabel = 'Gram (g)';
                                    elseif($satLabel == 'Kg') $satLabel = 'Kilogram (Kg)';
                                    elseif($satLabel == 'cc') $satLabel = 'cc / mL';
                                    elseif($satLabel == 'Pcs') $satLabel = 'Pcs / Lembar';
                                @endphp

                                <tr class="hover:bg-purple-50/40 transition-colors group search-item-bahan" x-data="{ showDeleteModal: false }">
                                    <td class="px-6 py-5 bahan-data-text">
                                        <span class="bg-purple-50 text-purple-700 font-mono font-black text-[10px] px-3 py-1.5 rounded-lg border border-purple-200 group-hover:bg-purple-600 group-hover:text-white transition-colors tracking-widest">{{ $item->kode_bahan }}</span>
                                    </td>
                                    <td class="px-6 py-5 bahan-data-text">
                                        <div class="font-black text-gray-900 text-sm mb-1 group-hover:text-purple-700 transition-colors tracking-tight">{{ $item->nama_bahan }}</div>
                                        <div class="flex items-center gap-2">
                                            <span class="inline-block text-[9px] font-bold uppercase tracking-widest px-2.5 py-0.5 rounded-full border 
                                                @if(str_contains($item->kategori, 'Cat')) bg-blue-50 text-blue-600 border-blue-200
                                                @elseif(str_contains($item->kategori, 'Thinner')) bg-teal-50 text-teal-600 border-teal-200
                                                @elseif(str_contains($item->kategori, 'Clear')) bg-amber-50 text-amber-600 border-amber-200
                                                @elseif(str_contains($item->kategori, 'Dempul')) bg-orange-50 text-orange-600 border-orange-200
                                                @elseif(str_contains($item->kategori, 'Epoxy')) bg-indigo-50 text-indigo-600 border-indigo-200
                                                @elseif(str_contains($item->kategori, 'Amplas')) bg-pink-50 text-pink-600 border-pink-200
                                                @else bg-gray-50 text-gray-600 border-gray-200 @endif shadow-sm">
                                                {{ $katLabel }}
                                            </span>
                                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">| {{ $item->supplier ?? 'Internal Bengkel' }} - Nota: <span class="text-purple-600">{{ $item->nomor_nota ?? '-' }}</span></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if($item->stok <= 5)
                                            <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-700 font-black px-3 py-1.5 rounded-xl border border-red-200 shadow-sm animate-pulse">
                                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                {{ $item->stok }} <span class="text-[9px] text-red-500 font-bold uppercase tracking-widest">{{ $satLabel }}</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 font-black px-3 py-1.5 rounded-xl border border-emerald-200 shadow-sm">
                                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                {{ $item->stok }} <span class="text-[9px] text-emerald-500 font-bold uppercase tracking-widest">{{ $satLabel }}</span>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <div class="font-mono font-black text-purple-700 text-sm">Rp {{ number_format($item->stok * $item->harga_satuan, 0, ',', '.') }}</div>
                                        <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">@ Rp {{ number_format($item->harga_satuan, 0, ',', '.') }} / {{ $satLabel }}</div>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            
                                            {{-- TOMBOL LIHAT NOTA --}}
                                            @if($item->foto_nota)
                                                <button @click="showNotaModal = true; activeNota = '{{ asset('storage/' . $item->foto_nota) }}'; activeNama = '{{ $item->nama_bahan }}'; activeNotaNo = '{{ $item->nomor_nota ?? '-' }}'; activeSupplier = '{{ $item->supplier ?? '-' }}';" type="button" class="p-2.5 bg-white border border-gray-200 text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 hover:border-emerald-200 rounded-xl shadow-sm transition-all" title="Cek Nota Fisik">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </button>
                                            @endif

                                            {{-- TOMBOL EDIT --}}
                                            <a href="{{ route('bahan.stok.edit', $item->id) }}" class="p-2.5 bg-white border border-gray-200 text-gray-500 hover:text-blue-600 hover:bg-blue-50 hover:border-blue-200 rounded-xl shadow-sm transition-all" title="Edit Data">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            
                                            {{-- TOMBOL HAPUS --}}
                                            <button @click="showDeleteModal = true" class="p-2.5 bg-white border border-gray-200 text-gray-500 hover:text-red-600 hover:bg-red-50 hover:border-red-200 rounded-xl shadow-sm transition-all" title="Hapus Data">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>

                                        {{-- MODAL HAPUS --}}
                                        <template x-teleport="body">
                                            <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-[120] overflow-y-auto whitespace-normal" x-transition.opacity>
                                                <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                                                    <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm" @click="showDeleteModal = false"></div>
                                                    <div class="relative bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-md w-full">
                                                        <div class="bg-white px-8 pt-8 pb-6 text-center">
                                                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-red-50">
                                                                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                            </div>
                                                            <h3 class="text-xl font-black text-gray-900 mb-2">Hapus {{ $item->nama_bahan }}?</h3>
                                                            <p class="text-sm text-gray-500 font-medium">Data stok bahan material ini akan dihapus permanen. Lanjutkan?</p>
                                                        </div>
                                                        <div class="bg-gray-50 px-8 py-5 flex flex-row-reverse gap-3 rounded-b-[2rem]">
                                                            <form action="{{ route('bahan.stok.destroy', $item->id) }}" method="POST">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-md transition-colors w-full sm:w-auto">Ya, Hapus!</button>
                                                            </form>
                                                            <button type="button" @click="showDeleteModal = false" class="px-6 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-colors w-full sm:w-auto">Batal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </td>
                                </tr>
                            @empty
                                <tr id="emptyStateBahan">
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="w-full mx-auto flex flex-col items-center justify-center text-center">
                                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-sm">
                                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                            </div>
                                            <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight">Inventori Kosong</h3>
                                            <p class="text-sm text-gray-500 font-medium mt-1 mb-6 max-w-sm mx-auto">Data material belum tersedia. Silakan klik tombol "Tambah Stok" di atas.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                            <tr id="noResultsRowBahan" style="display: none;">
                                <td colspan="5" class="px-8 py-16">
                                    <div class="w-full mx-auto flex flex-col items-center justify-center text-center opacity-50">
                                        <div class="w-12 h-12 bg-purple-50 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        </div>
                                        <p class="font-black text-gray-500 text-sm uppercase tracking-widest">Pencarian Tidak Ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- MODAL PREVIEW FOTO NOTA (DESAIN SERAGAM DENGAN SPAREPART) --}}
                <template x-teleport="body">
                    <div x-show="showNotaModal" style="display: none;" class="fixed inset-0 z-[99999] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" x-transition.opacity x-cloak>
                        
                        <div class="bg-white rounded-[2.5rem] w-full max-w-2xl shadow-2xl overflow-hidden transform transition-all text-left flex flex-col max-h-[85vh]" @click.away="showNotaModal = false">
                            
                            {{-- HEADER MODAL --}}
                            <div class="bg-gray-900 p-5 sm:p-6 text-white flex justify-between items-center shrink-0">
                                <div>
                                    <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-1">Rincian Dokumen Fisik</p>
                                    <h3 class="text-lg font-black capitalize tracking-tight text-white" x-text="activeNama"></h3>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Supplier: <span class="text-indigo-400 font-black capitalize" x-text="activeSupplier"></span> | Nota: <span class="text-indigo-400 font-black" x-text="activeNotaNo"></span></p>
                                </div>
                                <button @click="showNotaModal = false" class="p-2 hover:bg-white/10 text-white rounded-full transition-colors shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>

                            {{-- 🚀 VIEW THUMBNAIL FOTO NOTA (RAPI & PAS DI TENGAH) 🚀 --}}
                            <div class="flex flex-col flex-1 overflow-hidden">
                                
                                {{-- Area konten foto --}}
                                <div class="p-4 sm:p-5 overflow-y-auto bg-gray-50 flex-1 flex flex-col items-center justify-center">
                                    
                                    {{-- Status Validasi Dokumen --}}
                                    <div class="w-full flex justify-end mb-4 pr-4">
                                        <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 border border-emerald-200 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest shadow-sm">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            Dokumen Valid
                                        </span>
                                    </div>

                                    {{-- THUMBNAIL KOTAK KECIL DITENGAH --}}
                                    <a :href="activeNota" target="_blank" class="relative group block w-48 h-48 sm:w-64 sm:h-64 rounded-2xl border-2 border-gray-200 shadow-sm overflow-hidden transition-all hover:border-indigo-400 hover:shadow-xl">
                                        <img :src="activeNota" alt="Foto Nota Fisik" class="w-full h-full object-cover">
                                        
                                        {{-- HOVER EFFECT (MUNCUL ICON ZOOM & TEKS) --}}
                                        <div class="absolute inset-0 bg-gray-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center pointer-events-none backdrop-blur-sm">
                                            <svg class="w-8 h-8 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                            <span class="text-white font-black text-[10px] uppercase tracking-widest bg-gray-900/80 px-3 py-1.5 rounded-lg shadow-sm">Klik Full Resolusi</span>
                                        </div>
                                    </a>
                                </div>

                                {{-- FOOTER BUTTONS --}}
                                <div class="bg-white px-6 py-4 border-t border-gray-100 flex justify-start items-center shrink-0">
                                    <button @click="showNotaModal = false" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-sm flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                        Kembali
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('cariBahan')?.addEventListener('keyup', function() {
            const val = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tabelBahan tbody tr.search-item-bahan');
            let visible = false;
            
            rows.forEach(row => {
                let textData = '';
                row.querySelectorAll('.bahan-data-text').forEach(el => {
                    textData += el.innerText.toLowerCase() + ' ';
                });

                if(textData.includes(val)) { 
                    row.style.display = ''; 
                    visible = true; 
                } else { 
                    row.style.display = 'none'; 
                }
            });

            const emptyState = document.getElementById('emptyStateBahan');
            const noResultsRow = document.getElementById('noResultsRowBahan');

            if (emptyState && emptyState.style.display !== 'none') {
                return; 
            }

            if (!visible) {
                if (noResultsRow) noResultsRow.style.display = 'table-row'; 
            } else {
                if (noResultsRow) noResultsRow.style.display = 'none';
            }
        });
    </script>
</x-app-layout>