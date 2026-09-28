<x-app-layout>
    <x-slot name="header">
        <div class="py-1">
            <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                {{ __('🛒 Monitoring Order Pembelian (PO)') }}
            </h2>
            <p class="text-sm text-gray-500 font-bold mt-1">
                Manajemen Pengadaan Sparepart / <span class="text-blue-600 uppercase tracking-wider">Wira Toyota</span>
            </p>
        </div>
    </x-slot>

    <div class="pt-5 pb-10 bg-gray-50 min-h-screen" x-data="{ openDetail: null }">
        <div class="max-w-[95rem] mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-xl font-bold flex items-center gap-3 mb-4 animate-bounce">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- FITUR BARU: ANTRIAN REQUEST SPK DARI SA --}}
            @if($pendingSpks->count() > 0)
                <div class="mb-2">
                    <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 animate-pulse"></span>
                        Antrian Request Barang (Dari SA)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                        @foreach($pendingSpks as $spk)
                            <div class="bg-white border-l-4 border-amber-500 p-4 rounded-2xl shadow-sm flex justify-between items-center group hover:shadow-md transition-all">
                                <div>
                                    <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest">Butuh PO Baru!</p>
                                    <h4 class="font-black text-gray-900 text-sm mt-0.5">{{ $spk->vehicle->nopol ?? 'NOPOL' }} <span class="text-gray-400 font-bold">| {{ $spk->nomor_spk }}</span></h4>
                                    <p class="text-xs text-gray-500 mt-1 font-bold">{{ $spk->details->count() }} Item (Ganti Part)</p>
                                </div>
                                <a href="{{ route('spareparts.purchases.create', ['spk_id' => $spk->id]) }}" 
                                   class="bg-amber-50 text-amber-600 border border-amber-200 hover:bg-amber-500 hover:text-white text-[10px] font-black px-4 py-2.5 rounded-xl uppercase tracking-widest transition-all whitespace-nowrap">
                                   Proses PO
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Action Toolbar --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-6 rounded-[2.5rem] border border-gray-100 shadow-xl shadow-gray-200/50 mb-6">
                
                {{-- Judul --}}
                <div class="w-full md:w-auto">
                    <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Daftar Belanja Logistik</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Monitoring barang OTW dari Supplier/TAM.</p>
                </div>
                
                {{-- Kumpulan Filter & Pencarian --}}
                <div class="flex flex-col gap-3 w-full md:w-auto">
                    
                    {{-- BARIS 1: Filter Bulan, Tahun, Cetak, Buat PO --}}
                    <div class="flex flex-col sm:flex-row gap-2 w-full justify-end items-center">
                        <form method="GET" action="{{ route('spareparts.purchases.index') }}" id="filterPoForm" class="flex gap-2 w-full sm:w-auto">
                            
                            {{-- Pilih Bulan --}}
                            <div class="relative w-full sm:w-36">
                                <select name="bulan" onchange="document.getElementById('filterPoForm').submit()" class="w-full pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none appearance-none cursor-pointer shadow-sm">
                                    @foreach(range(1, 12) as $m)
                                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 z-10">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            {{-- Pilih Tahun --}}
                            <div class="relative w-full sm:w-28">
                                <select name="tahun" onchange="document.getElementById('filterPoForm').submit()" class="w-full pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none appearance-none cursor-pointer shadow-sm">
                                    @foreach(range(date('Y')-2, date('Y')) as $y)
                                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 z-10">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </form>
                        
                        {{-- Cetak Laporan (Dikembalikan persis di samping tahun kayak foto) --}}
                        <a href="{{ route('spareparts.purchases.recap', ['bulan' => $bulan, 'tahun' => $tahun]) }}" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-3 bg-white border border-gray-200 text-gray-700 hover:text-green-600 hover:bg-green-50 hover:border-green-300 text-xs font-bold rounded-xl transition-all shadow-sm group whitespace-nowrap">
                            <svg class="w-4 h-4 mr-1.5 text-gray-400 group-hover:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak Laporan
                        </a>

                        {{-- Tombol Buat PO Baru --}}
                        <a href="{{ route('spareparts.purchases.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 bg-gray-900 hover:bg-red-600 text-white text-xs font-bold rounded-xl transition-all shadow-lg shadow-gray-900/30 whitespace-nowrap">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Buat PO Baru
                        </a>
                    </div>

                    {{-- BARIS 2: Live Search (Di bawah filter) --}}
                    <div class="w-full">
                        <form method="GET" action="{{ route('spareparts.purchases.index') }}" class="relative w-full group" onsubmit="return false;">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" id="cariPO" name="search" class="block w-full pl-10 pr-4 py-3 border border-gray-200 bg-gray-50 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all font-bold text-xs shadow-sm" placeholder="Cari No. PO, SPK, Nopol, Supplier di bulan ini...">
                        </form>
                    </div>

                </div>
            </div>

            {{-- Card Tabel --}}
            <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-2xl overflow-hidden relative">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="tabelPO">
                        <thead>
                            <tr class="bg-gray-50/50 text-gray-400 text-[10px] font-black uppercase tracking-[0.1em] border-b border-gray-100">
                                <th class="px-8 py-5">Identitas PO & Kendaraan</th>
                                <th class="px-6 py-5">Supplier / Vendor</th>
                                <th class="px-6 py-5 text-center">Volume</th>
                                <th class="px-6 py-5 text-center">Status Order</th>
                                <th class="px-6 py-5 text-right">Total Est. Harga</th>
                                <th class="px-8 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($purchaseOrders as $po)
                                <tr class="hover:bg-blue-50/20 transition-colors group text-sm search-item-po" x-data="{ showDeleteModal: false }">
                                    <td class="px-8 py-6">
                                        <div class="font-black text-gray-900 group-hover:text-blue-600 transition-colors uppercase tracking-tight po-data-text">{{ $po->po_number }}</div>
                                        <div class="flex flex-col gap-1.5 mt-2">
                                            <div class="text-[10px] text-gray-400 font-bold flex items-center gap-1 uppercase po-data-text">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                {{ $po->order_date->format('d M Y') }}
                                            </div>
                                            @if($po->work_order_id)
                                                <div class="text-[9px] font-black text-indigo-600 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded w-fit flex items-center gap-1 uppercase tracking-widest mt-0.5 po-data-text">
                                                    🚗 {{ $po->workOrder->vehicle->nopol ?? 'NOPOL' }} | SPK: {{ $po->workOrder->nomor_spk ?? '-' }}
                                                </div>
                                            @else
                                                <div class="text-[9px] font-black text-emerald-600 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded w-fit flex items-center gap-1 uppercase tracking-widest mt-0.5 po-data-text">
                                                    📦 STOK GUDANG UMUM
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 font-bold text-gray-700 uppercase po-data-text">{{ $po->supplier_name }}</td>
                                    <td class="px-6 py-6 text-center">
                                        <span class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 rounded-lg text-[10px] font-black italic">
                                            {{ $po->items->count() }} Pcs
                                        </span>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-tighter shadow-sm {{ $po->status == 'Received' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-amber-100 text-amber-700 border border-amber-200' }} po-data-text">
                                            ● {{ $po->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-6 text-right font-mono font-black text-blue-700 po-data-text">
                                        Rp {{ number_format($po->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button @click="openDetail = {{ $po->id }}" class="p-2.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all" title="Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </button>
                                            <a href="{{ route('spareparts.purchases.print', $po->id) }}" target="_blank" class="p-2.5 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-xl transition-all" title="Cetak"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg></a>
                                            <a href="{{ route('spareparts.purchases.edit', $po->id) }}" class="p-2.5 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-xl transition-all" title="Edit"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>
                                            <button type="button" @click="showDeleteModal = true" class="p-2.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>

                                        {{-- MODAL HAPUS PO --}}
                                        <template x-teleport="body">
                                            <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-[120] overflow-y-auto whitespace-normal" x-transition.opacity>
                                                <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                                                    <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm" @click="showDeleteModal = false"></div>
                                                    <div class="relative bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-md w-full">
                                                        <div class="bg-white px-8 pt-8 pb-6 text-center">
                                                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-red-50">
                                                                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                            </div>
                                                            <h3 class="text-xl font-black text-gray-900 mb-2">Hapus PO {{ $po->po_number }}?</h3>
                                                            <p class="text-sm text-gray-500 font-medium">Data Purchase Order ini akan dihapus permanen. Lanjutkan?</p>
                                                        </div>
                                                        <div class="bg-gray-50 px-8 py-5 flex flex-row-reverse gap-3 rounded-b-[2rem]">
                                                            <form action="{{ route('spareparts.purchases.destroy', $po->id) }}" method="POST">
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

                                {{-- MODAL DETAIL --}}
                                <template x-teleport="body">
                                    <div x-show="openDetail === {{ $po->id }}" class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-gray-900/40 backdrop-blur-md" x-cloak x-transition.opacity>
                                        <div @click.away="openDetail = null" class="bg-white rounded-[2.5rem] shadow-2xl max-w-lg w-full overflow-hidden border border-gray-100">
                                            <div class="px-8 py-5 border-b flex justify-between items-start bg-gray-50/50">
                                                <div>
                                                    <h4 class="font-black text-gray-900 uppercase italic tracking-tighter text-sm mb-1.5">Detail Purchase Order</h4>
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        <p class="text-[10px] text-blue-700 bg-blue-100 border border-blue-200 px-2 py-0.5 rounded font-bold uppercase tracking-widest">{{ $po->po_number }}</p>
                                                        @if($po->work_order_id)
                                                            <p class="text-[10px] text-indigo-700 bg-indigo-50 border border-indigo-200 px-2 py-0.5 rounded font-black uppercase tracking-widest">🚗 {{ $po->workOrder->vehicle->nopol ?? '-' }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <button @click="openDetail = null" class="p-2 hover:bg-red-50 text-gray-400 hover:text-red-500 rounded-xl transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                            </div>
                                            <div class="p-8">
                                                <div class="space-y-3 overflow-y-auto max-h-[105px] pr-2 [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-300 [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-gray-400 transition-colors">
                                                    @foreach($po->items as $item)
                                                        <div class="flex justify-between items-center p-4 rounded-2xl bg-gray-50/50 border border-gray-100">
                                                            <div class="flex items-center gap-3">
                                                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-[10px] font-black text-blue-600">{{ $item->qty }}</div>
                                                                <div>
                                                                    <p class="font-black text-gray-800 text-xs uppercase tracking-tight">{{ $item->item_name }}</p>
                                                                    <p class="text-[9px] text-gray-400 font-bold uppercase italic">Unit Price: Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="text-right italic">
                                                                <p class="font-mono font-black text-gray-900 text-xs text-blue-600">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="mt-8 pt-5 border-t border-dashed border-gray-200 flex justify-between items-end">
                                                    <div>
                                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest italic text-sm">Total Harga</p>
                                                        <p class="text-[9px] text-gray-400 font-medium">Est. biaya pengadaan logistik</p>
                                                    </div>
                                                    <div class="text-right">
                                                        <p class="text-2xl font-mono font-black text-blue-700 tracking-tighter">Rp{{ number_format($po->total_amount, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-6 bg-gray-50 border-t flex gap-3">
                                                <button @click="openDetail = null" class="flex-1 py-3 bg-white text-gray-700 font-black rounded-2xl border border-gray-200 hover:bg-gray-50 transition-colors uppercase text-[10px] tracking-widest shadow-sm hover:text-red-600 hover:border-red-300">Kembali</button>
                                                
                                                <a href="{{ route('spareparts.purchases.print', $po->id) }}" target="_blank" class="flex-1 py-3 bg-gray-900 text-white text-center font-bold text-sm rounded-2xl hover:bg-green-600 transition-colors shadow-lg shadow-gray-900/30">Cetak PO</a>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            @empty
                                <tr id="emptyStatePO">
                                    <td colspan="6" class="text-center py-24">
                                        <div class="flex flex-col items-center opacity-20">
                                            <svg class="w-24 h-24 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                            <p class="font-black text-xl tracking-tighter uppercase">Belum ada data transaksi</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            
                            {{-- BARIS KALO HASIL PENCARIAN KOSONG --}}
                            <tr id="noResultsRowPO" style="display: none;">
                                <td colspan="6" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center opacity-50">
                                        <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        </div>
                                        <p class="font-black text-gray-500 text-sm uppercase tracking-widest">Pencarian Tidak Ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
                    {{ $purchaseOrders->links() }}
                </div>
            </div>
        </div>
    </div>
    
    {{-- SCRIPT JAVASCRIPT BUAT BIKIN KOLOM PENCARIAN HIDUP --}}
    <script>
        document.getElementById('cariPO')?.addEventListener('keyup', function() {
            const val = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tabelPO tbody tr.search-item-po');
            let visible = false;
            
            rows.forEach(row => {
                let textData = '';
                row.querySelectorAll('.po-data-text').forEach(el => {
                    textData += el.innerText.toLowerCase() + ' ';
                });

                if(textData.includes(val)) { 
                    row.style.display = ''; 
                    visible = true; 
                } else { 
                    row.style.display = 'none'; 
                }
            });

            const emptyState = document.getElementById('emptyStatePO');
            const noResultsRow = document.getElementById('noResultsRowPO');

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
    
    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</x-app-layout>