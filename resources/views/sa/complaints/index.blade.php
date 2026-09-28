<x-app-layout>
    <x-slot name="header">
        <div class="py-1">
            <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                {{ __('🛡️ Manajemen Klaim Garansi') }}
            </h2>
            <p class="text-sm text-gray-500 font-bold mt-1">
                Operasional SA / <span class="text-red-600 uppercase tracking-wider">Wira Toyota</span>
            </p>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="w-full px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- ALERT SUKSES (Sudah diseragamkan dengan SPK Index) --}}
            @if(session('success'))
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-init="setTimeout(() => show = false, 4000)" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center gap-3 transform transition-all mb-6">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif
            
            {{-- HEADER INFO & SEARCH BAR --}}
            <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm flex flex-col lg:flex-row justify-between items-start lg:items-center gap-5 mb-6">
                <div class="w-full lg:w-auto">
                    <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight">Daftar Pengajuan Komplain</h3>
                    <p class="text-xs text-gray-400 font-medium mt-1">Lakukan verifikasi keluhan pelanggan dan setujui untuk proses <span class="font-bold text-red-500">Rework</span>.</p>
                </div>
                
                {{-- Kumpulan Search Bar & Badge --}}
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
                    
                    {{-- KOLOM PENCARIAN (LIVE SEARCH) --}}
                    <form method="GET" action="#" class="relative w-full sm:w-64 group" onsubmit="return false;">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" id="cariComplaint" name="search" class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 bg-gray-50 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white transition-all font-bold text-xs shadow-sm" placeholder="Cari SPK, Nopol, Pelanggan...">
                    </form>

                    {{-- BADGE LIVE SYNC --}}
                    <div class="px-5 py-2.5 bg-red-50 text-red-700 font-bold text-xs rounded-xl border border-red-100 flex items-center justify-center gap-2.5 shadow-sm w-full sm:w-auto whitespace-nowrap">
                        <span class="relative flex h-3 w-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-red-600"></span>
                        </span>
                        Live Sync Portal Customer
                    </div>
                </div>
            </div>

            {{-- TABEL TRACKING ANTI-NUMPUK --}}
            <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100">
                <div class="overflow-x-auto w-full pb-4">
                    {{-- DITAMBAHKAN ID tabelComplaint --}}
                    <table class="w-full text-left" id="tabelComplaint">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-5 py-4 text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Info Kendaraan (SPK)</th>
                                <th class="px-5 py-4 text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Detail Keluhan & Bukti</th>
                                <th class="px-5 py-4 text-center text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Status Garansi</th>
                                <th class="px-5 py-4 text-center text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Aksi SA</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white text-sm">
                            @forelse($complaints as $complaint)
                                {{-- DITAMBAHKAN CLASS search-item-complaint --}}
                                <tr class="hover:bg-red-50/40 transition-colors group search-item-complaint" x-data="{ showForm: false, cancelConfirm: false }">
                                    
                                    {{-- 1. INFO KENDARAAN & SPK --}}
                                    <td class="px-5 py-5 align-top">
                                        <div class="flex flex-col gap-2">
                                            <div class="font-bold text-gray-800 text-sm group-hover:text-red-600 transition-colors line-clamp-1 complaint-data-text">
                                                {{ $complaint->workOrder->vehicle->merk ?? '' }} {{ $complaint->workOrder->vehicle->model ?? 'Model Tidak Diketahui' }}
                                            </div>
                                            <div>
                                                <span class="inline-block bg-gray-900 text-white font-mono text-xs font-black px-2.5 py-1 rounded-md shadow-sm border-b-2 border-gray-600 complaint-data-text">
                                                    {{ $complaint->workOrder->vehicle->nopol ?? '-' }}
                                                </span>
                                            </div>
                                            <div class="mt-1">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-100 border border-gray-200 text-[10px] font-black text-gray-600 shadow-sm uppercase tracking-widest complaint-data-text">
                                                    <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                    SPK: {{ $complaint->workOrder->nomor_spk ?? '-' }}
                                                </span>
                                            </div>
                                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">
                                                Diajukan: {{ $complaint->created_at->format('d M Y') }}
                                            </div>
                                        </div>
                                    </td>

                                    {{-- 2. RINCIAN KELUHAN & FOTO --}}
                                    <td class="px-5 py-5 align-top">
                                        <div class="flex gap-4 items-start">
                                            <a href="{{ asset('storage/' . $complaint->foto_bukti) }}" target="_blank" class="shrink-0 group/img">
                                                <div class="w-16 h-16 rounded-xl overflow-hidden border border-gray-200 shadow-sm relative bg-gray-50">
                                                    <img src="{{ asset('storage/' . $complaint->foto_bukti) }}" alt="Bukti" class="w-full h-full object-cover group-hover/img:scale-110 transition-transform">
                                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover/img:opacity-100 transition-opacity">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="min-w-[150px] max-w-[220px]">
                                                <p class="text-[9px] uppercase font-black text-gray-400 tracking-widest mb-1">Pelanggan:</p>
                                                <p class="text-xs font-bold text-gray-800 tracking-tight mb-2 truncate complaint-data-text">{{ $complaint->workOrder->vehicle->customer->name ?? '-' }}</p>
                                                
                                                <p class="text-[9px] font-black text-gray-400 tracking-widest mb-1">Kendala:</p>
                                                <p class="text-xs font-bold text-gray-600 italic line-clamp-3 complaint-data-text" title="{{ $complaint->keluhan }}">"{{ $complaint->keluhan }}"</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- 3. STATUS GARANSI --}}
                                    <td class="px-5 py-5 text-center align-top whitespace-nowrap">
                                        @if($complaint->status == 'disetujui')
                                            <div class="inline-flex flex-col items-center justify-center p-3 bg-emerald-50 rounded-2xl border border-emerald-100 shadow-sm w-32 complaint-data-text">
                                                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-2">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                </div>
                                                <span class="text-[10px] font-black text-emerald-700 uppercase tracking-widest">Disetujui</span>
                                                <span class="text-[9px] font-bold text-emerald-500 mt-1 max-w-[110px] truncate" title="{{ $complaint->catatan_sa }}">{{ $complaint->catatan_sa }}</span>
                                            </div>
                                        @elseif($complaint->status == 'ditolak')
                                            <div class="inline-flex flex-col items-center justify-center p-3 bg-red-50 rounded-2xl border border-red-100 shadow-sm w-32 complaint-data-text">
                                                <div class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center mb-2">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </div>
                                                <span class="text-[10px] font-black text-red-700 uppercase tracking-widest">Ditolak</span>
                                                <span class="text-[9px] font-bold text-red-500 mt-1 max-w-[110px] truncate" title="{{ $complaint->catatan_sa }}">{{ $complaint->catatan_sa }}</span>
                                            </div>
                                        @else
                                            <div class="inline-flex flex-col items-center justify-center p-3 bg-amber-50 rounded-2xl border border-amber-100 shadow-sm w-32 complaint-data-text">
                                                <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mb-2">
                                                    <svg class="w-5 h-5 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                </div>
                                                <span class="text-[10px] font-black text-amber-700 uppercase tracking-widest">Menunggu</span>
                                                <span class="text-[9px] font-bold text-amber-500 mt-1">Review SA</span>
                                            </div>
                                        @endif
                                    </td>

                                    {{-- 4. AKSI SA --}}
                                    <td class="px-5 py-5 text-center align-top whitespace-nowrap relative">
                                        @if($complaint->status == 'menunggu')
                                            <button @click="showForm = !showForm" class="inline-flex flex-col items-center justify-center p-3 bg-white border border-gray-200 text-gray-500 hover:text-red-600 hover:border-red-300 hover:bg-red-50 rounded-xl transition-all shadow-sm group/btn w-full max-w-[100px] mx-auto">
                                                <svg class="w-5 h-5 mb-1 text-gray-400 group-hover/btn:text-red-500 transition-colors transform group-hover/btn:scale-110" :class="showForm ? 'rotate-180 text-red-500' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                                                <span class="text-[9px] font-black uppercase tracking-widest">Tanggapi</span>
                                            </button>

                                            {{-- Dropdown Form Review --}}
                                            <div x-show="showForm" style="display: none;" class="absolute right-6 top-20 z-10 w-72 bg-white border border-gray-200 rounded-2xl shadow-2xl p-5 text-left before:content-[''] before:absolute before:-top-2 before:right-8 before:w-4 before:h-4 before:bg-white before:border-l before:border-t before:border-gray-200 before:rotate-45">
                                                <form action="{{ route('sa.complaints.update', $complaint->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Keputusan Garansi</label>
                                                    <select name="status" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-xs rounded-xl focus:ring-red-500 focus:border-red-500 block p-2.5 font-bold shadow-sm mb-4 transition-colors hover:bg-white">
                                                        <option value="" disabled selected>-- Pilih Aksi --</option>
                                                        <option value="disetujui">✅ Setujui & Rework</option>
                                                        <option value="ditolak">❌ Tolak Komplain</option>
                                                    </select>

                                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Catatan SA</label>
                                                    <textarea name="catatan_sa" rows="2" required placeholder="Alasan disetujui / ditolak..." class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-xs rounded-xl focus:ring-red-500 focus:border-red-500 block p-2.5 font-medium shadow-sm mb-5 transition-colors hover:bg-white"></textarea>

                                                    <button type="submit" class="w-full py-2.5 bg-red-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition-colors shadow-lg shadow-red-200 flex items-center justify-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        Simpan Keputusan
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <div class="inline-flex flex-col items-center gap-2 w-full max-w-[100px] mx-auto">
                                                <div class="inline-flex flex-col items-center justify-center p-3 bg-gray-50 border border-gray-100 text-gray-400 rounded-xl w-full">
                                                    <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    <span class="text-[9px] font-black uppercase tracking-widest">Telah Direview</span>
                                                </div>

                                                {{-- TOMBOL BATALKAN KEPUTUSAN --}}
                                                <form id="cancel-decision-form-{{ $complaint->id }}" action="{{ route('sa.complaints.cancelDecision', $complaint->id) }}" method="POST" class="hidden">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
                                                <button type="button" @click="cancelConfirm = true" class="inline-flex items-center justify-center gap-1 w-full px-2 py-1.5 bg-white border border-gray-200 text-gray-500 hover:text-amber-600 hover:border-amber-300 hover:bg-amber-50 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                    Batalkan
                                                </button>
                                            </div>

                                            {{-- MODAL KONFIRMASI BATALKAN KEPUTUSAN (Diseragamkan dengan SPK) --}}
                                            <div x-show="cancelConfirm" style="display: none;" class="fixed inset-0 z-[60] overflow-y-auto whitespace-normal" x-cloak>
                                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                    
                                                    {{-- Backdrop --}}
                                                    <div x-show="cancelConfirm"
                                                         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                                         class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity" @click="cancelConfirm = false"></div>
                                                    
                                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                                                    
                                                    {{-- Modal Panel --}}
                                                    <div x-show="cancelConfirm"
                                                         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                         class="inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-gray-100">
                                                        
                                                        <div class="bg-white px-8 pt-8 pb-6 text-center">
                                                            <h3 class="text-xl font-black text-gray-900 mb-2">Batalkan keputusan ini?</h3>
                                                            <p class="text-sm text-gray-500 italic">Status klaim akan dikembalikan ke <span class="font-black text-amber-600 not-italic">Menunggu</span> dan bisa direview ulang.</p>
                                                        </div>
                                                        
                                                        {{-- Footer Tombol (Style 100% sama dengan modal Hapus SPK) --}}
                                                        <div class="bg-gray-50 px-8 py-5 flex flex-row-reverse gap-3 rounded-b-[2rem]">
                                                            <button type="button" @click="document.getElementById('cancel-decision-form-{{ $complaint->id }}').submit()" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-md transition-colors">
                                                                Ya, Batalkan
                                                            </button>
                                                            <button type="button" @click="cancelConfirm = false" class="px-6 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-colors">
                                                                Batal
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr id="emptyStateComplaint">
                                    <td colspan="4" class="px-5 py-24 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="bg-gray-50 p-6 rounded-full mb-4 border-4 border-white shadow-sm">
                                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                            </div>
                                            <p class="font-black text-gray-800 uppercase tracking-widest text-lg">Tidak ada komplain masuk</p>
                                            <p class="text-sm font-medium text-gray-500 mt-1">Belum ada pelanggan yang mengajukan klaim garansi sejauh ini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                            {{-- BARIS KALO HASIL PENCARIAN KOSONG --}}
                            <tr id="noResultsRowComplaint" style="display: none;">
                                <td colspan="4" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center opacity-50">
                                        <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        </div>
                                        <p class="font-black text-gray-500 text-sm uppercase tracking-widest">Data Komplain Tidak Ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT BUAT LIVE SEARCH KOMPLAIN --}}
    <script>
        document.getElementById('cariComplaint')?.addEventListener('keyup', function() {
            const val = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tabelComplaint tbody tr.search-item-complaint');
            let visible = false;
            
            rows.forEach(row => {
                let textData = '';
                row.querySelectorAll('.complaint-data-text').forEach(el => {
                    textData += el.innerText.toLowerCase() + ' ';
                });

                if(textData.includes(val)) { 
                    row.style.display = ''; 
                    visible = true; 
                } else { 
                    row.style.display = 'none'; 
                }
            });

            const emptyState = document.getElementById('emptyStateComplaint');
            const noResultsRow = document.getElementById('noResultsRowComplaint');

            if (emptyState && emptyState.style.display !== 'none') {
                return;
            }

            if (!visible) {
                if (noResultsRow) noResultsRow.style.display = '';
            } else {
                if (noResultsRow) noResultsRow.style.display = 'none';
            }
        });
    </script>
</x-app-layout>