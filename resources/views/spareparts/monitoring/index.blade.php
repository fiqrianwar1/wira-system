<x-app-layout>
    <x-slot name="header">
        <div class="py-1">
            <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                {{ __('📦 Tracking Sparepart') }}
            </h2>
            <p class="text-sm text-gray-500 font-bold mt-1">
                Pantau Kedatangan Logistik SPK / <span class="text-red-600 uppercase tracking-wider">Service Advisor</span>
            </p>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- HEADER INFO & SEARCH BAR --}}
            <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm flex flex-col lg:flex-row justify-between items-start lg:items-center gap-5">
                <div class="w-full lg:w-auto">
                    <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight">Status Pesanan Gudang</h3>
                    <p class="text-xs text-gray-400 font-medium mt-1">Halaman ini bersifat <span class="font-bold text-red-500">Read-Only</span>. Hubungi bagian Logistik untuk revisi data vendor.</p>
                </div>
                
                {{-- Kumpulan Search Bar & Badge (Sesuai Request Lingkaran Hijau) --}}
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
                    
                    {{-- KOLOM PENCARIAN (LIVE SEARCH) --}}
                    <form method="GET" action="#" class="relative w-full sm:w-64 group" onsubmit="return false;">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" id="cariTrack" name="search" class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 bg-gray-50 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white transition-all font-bold text-xs shadow-sm" placeholder="Cari SPK, Nopol, Part...">
                    </form>

                    {{-- BADGE LIVE SYNC --}}
                    <div class="px-5 py-2.5 bg-red-50 text-red-700 font-bold text-xs rounded-xl border border-red-100 flex items-center justify-center gap-2.5 shadow-sm w-full sm:w-auto whitespace-nowrap">
                        <span class="relative flex h-3 w-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-red-600"></span>
                        </span>
                        Live Sync dari PO Gudang
                    </div>
                </div>
            </div>

            {{-- TABEL TRACKING ANTI-NUMPUK --}}
            <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100">
                <div class="overflow-x-auto w-full pb-4">
                    {{-- DITAMBAHIN ID tabelTrack BUAT TARGET JAVASCRIPT --}}
                    <table class="w-full text-left min-w-[900px]" id="tabelTrack">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-8 py-5 text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Info Kendaraan (SPK)</th>
                                <th class="px-6 py-5 text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Rincian Part Dipesan</th>
                                <th class="px-6 py-5 text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Info Pemesanan</th>
                                <th class="px-6 py-5 text-center text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Status Barang</th>
                                <th class="px-8 py-5 text-center text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white text-sm">
                            @forelse($trackings as $po)
                                {{-- CLASS search-item-track DITAMBAHIN DI SINI --}}
                                <tr class="hover:bg-red-50/40 transition-colors group search-item-track">
                                    
                                    {{-- 1. INFO KENDARAAN & SPK --}}
                                    <td class="px-8 py-6 align-top whitespace-nowrap">
                                        @if($po->work_order_id && $po->workOrder)
                                            <div class="flex flex-col gap-2 overflow-hidden">
                                                <div class="font-bold text-gray-800 text-sm truncate group-hover:text-red-600 transition-colors track-data-text">
                                                    {{ $po->workOrder->vehicle->merk ?? '' }} {{ $po->workOrder->vehicle->model ?? 'Model Tidak Diketahui' }}
                                                </div>
                                                <div>
                                                    <span class="inline-block bg-gray-900 text-white font-mono text-xs font-black px-2.5 py-1 rounded-md shadow-sm border-b-2 border-gray-600 track-data-text">
                                                        {{ $po->workOrder->vehicle->nopol ?? 'NOPOL KOSONG' }}
                                                    </span>
                                                </div>
                                                <div class="mt-1">
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-100 border border-gray-200 text-[10px] font-black text-gray-600 shadow-sm uppercase tracking-widest track-data-text">
                                                        <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                        SPK: {{ $po->workOrder->nomor_spk ?? '-' }}
                                                    </span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex flex-col gap-2 overflow-hidden">
                                                <div class="font-black text-emerald-600 text-sm tracking-tight truncate track-data-text">
                                                    STOK GUDANG INTERNAL
                                                </div>
                                                <div class="text-xs font-bold text-gray-500 track-data-text">
                                                    Restock (Pemakaian Umum)
                                                </div>
                                                <div class="mt-1">
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-100 border border-gray-200 text-[10px] font-black text-gray-500 shadow-sm uppercase tracking-widest track-data-text">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                                        NON-SPK
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                    </td>

                                    {{-- 2. RINCIAN PART --}}
                                    <td class="px-6 py-6 align-top">
                                        <ul class="space-y-3">
                                            @foreach($po->items as $item)
                                                <li class="flex items-start gap-3">
                                                    <span class="w-6 h-6 rounded-md bg-gray-100 text-gray-700 border border-gray-200 flex items-center justify-center text-xs font-black shrink-0 shadow-sm">
                                                        {{ $item->qty }}
                                                    </span>
                                                    <span class="text-xs font-bold text-gray-700 uppercase tracking-tight leading-relaxed pt-0.5 track-data-text">
                                                        {{ $item->item_name }}
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>

                                    {{-- 3. INFO PEMESANAN (Vendor) --}}
                                    <td class="px-6 py-6 align-top whitespace-nowrap">
                                        <div class="mb-3.5">
                                            <p class="text-[9px] uppercase font-black text-gray-400 tracking-widest mb-1">Nomor PO</p>
                                            <p class="text-xs font-black text-gray-800 tracking-tight track-data-text">{{ $po->po_number }}</p>
                                        </div>
                                        <div class="mb-3.5">
                                            <p class="text-[9px] uppercase font-black text-gray-400 tracking-widest mb-1">Tanggal Order</p>
                                            <p class="text-xs font-bold text-gray-700">{{ $po->order_date->format('d M Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[9px] uppercase font-black text-gray-400 tracking-widest mb-1">Vendor / Toko</p>
                                            <p class="text-xs font-bold text-gray-800 uppercase track-data-text">{{ $po->supplier_name }}</p>
                                        </div>
                                    </td>

                                    {{-- 4. STATUS BARANG --}}
                                    <td class="px-6 py-6 text-center align-top whitespace-nowrap">
                                        @if($po->status == 'Received')
                                            <div class="inline-flex flex-col items-center justify-center p-3.5 bg-emerald-50 rounded-2xl border border-emerald-100 shadow-sm track-data-text">
                                                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-2">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                </div>
                                                <span class="text-[10px] font-black text-emerald-700 uppercase tracking-widest">Barang Tiba</span>
                                                <span class="text-[9px] font-bold text-emerald-500 mt-1">Siap di Gudang</span>
                                            </div>
                                        @else
                                            <div class="inline-flex flex-col items-center justify-center p-3.5 bg-amber-50 rounded-2xl border border-amber-100 shadow-sm track-data-text">
                                                <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mb-2">
                                                    <svg class="w-5 h-5 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                </div>
                                                <span class="text-[10px] font-black text-amber-700 uppercase tracking-widest">Menunggu</span>
                                                <span class="text-[9px] font-bold text-amber-500 mt-1">Proses Supplier</span>
                                            </div>
                                        @endif
                                    </td>

                                    {{-- 5. AKSI --}}
                                    <td class="px-8 py-6 text-center align-top whitespace-nowrap">
                                        <a href="{{ route('spareparts.purchases.print', $po->id) }}" target="_blank" class="inline-flex flex-col items-center justify-center p-3 bg-white border border-gray-200 text-gray-500 hover:text-red-600 hover:border-red-300 hover:bg-red-50 rounded-xl transition-all shadow-sm group/btn">
                                            <svg class="w-5 h-5 mb-1 text-gray-400 group-hover/btn:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                            <span class="text-[9px] font-black uppercase tracking-widest">Cetak PO</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr id="emptyStateTrack">
                                    <td colspan="5" class="px-6 py-24 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="bg-gray-50 p-6 rounded-full mb-4 border-4 border-white shadow-sm">
                                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                            </div>
                                            <p class="font-black text-gray-800 uppercase tracking-widest text-lg">Tidak ada pesanan logistik</p>
                                            <p class="text-sm font-medium text-gray-500 mt-1">Belum ada data Sparepart PO yang ditarik dari sistem Gudang.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            
                            {{-- BARIS KALO HASIL PENCARIAN KOSONG --}}
                            <tr id="noResultsRowTrack" style="display: none;">
                                <td colspan="5" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center opacity-50">
                                        <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        </div>
                                        <p class="font-black text-gray-500 text-sm uppercase tracking-widest">Data Tidak Ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($trackings->hasPages())
                    <div class="px-8 py-5 bg-gray-50/80 border-t border-gray-100">
                        {{ $trackings->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
    
    {{-- SCRIPT JAVASCRIPT BUAT LIVE SEARCH --}}
    <script>
        document.getElementById('cariTrack')?.addEventListener('keyup', function() {
            const val = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tabelTrack tbody tr.search-item-track');
            let visible = false;
            
            rows.forEach(row => {
                let textData = '';
                row.querySelectorAll('.track-data-text').forEach(el => {
                    textData += el.innerText.toLowerCase() + ' ';
                });

                if(textData.includes(val)) { 
                    row.style.display = ''; 
                    visible = true; 
                } else { 
                    row.style.display = 'none'; 
                }
            });

            const emptyState = document.getElementById('emptyStateTrack');
            const noResultsRow = document.getElementById('noResultsRowTrack');

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