<x-app-layout>
    <x-slot name="header">
        <div class="py-1">
            <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                {{ __('📦 Visual Stock Monitor') }}
            </h2>
            <p class="text-sm text-gray-500 font-bold mt-1">
                Logistik / <span class="text-indigo-600 uppercase tracking-wider">Inventory Control</span>
            </p>
        </div>
    </x-slot>

    <div class="pt-5 pb-10 bg-gray-50 min-h-screen relative" x-data="{ openModal: false, selectedBatch: null, viewMode: 'list' }">
        <div class="max-w-[95rem] mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- ALERT NOTIFIKASI --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-xl shadow-emerald-200/50 font-bold flex items-center gap-3 animate-fade-in-down mb-6">
                    <div class="p-1 bg-white/20 rounded-full"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
                    {{ session('success') }}
                </div>
            @endif

            {{-- TOOLBAR --}}
            <div class="flex flex-col md:flex-row justify-between items-end md:items-center gap-4 mb-2">
                <div>
                    <h3 class="text-lg font-black text-gray-800">Overview Ketersediaan Panel</h3>
                    <p class="text-xs text-gray-500 font-medium">Monitoring real-time sparepart body & paint.</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('spareparts.stocks.print') }}" target="_blank" class="inline-flex items-center justify-center px-5 py-3.5 bg-white border border-gray-200 text-gray-700 hover:text-green-600 hover:bg-green-50 hover:border-green-300 text-sm font-bold rounded-2xl transition-all shadow-sm group whitespace-nowrap">
                        <svg class="w-5 h-5 mr-2 text-gray-400 group-hover:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak Laporan
                    </a>
                    <a href="{{ route('spareparts.stocks.create') }}" class="inline-flex items-center justify-center px-6 py-3.5 bg-gray-900 hover:bg-red-600 text-white text-sm font-bold rounded-2xl transition-all shadow-lg shadow-gray-900/30 transform hover:-translate-y-0.5 group whitespace-nowrap">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Input Stok Manual
                    </a>
                </div>
            </div>

            {{-- GRID KARTU KATEGORI --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 px-4 md:px-0 pb-6">
                @foreach($panelCategories as $categoryName => $data)
                    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-lg transition-shadow duration-300 flex flex-col h-full overflow-hidden">
                        
                        <div class="p-6 border-b border-gray-50 flex items-center gap-4 bg-white relative">
                            <div class="w-12 h-12 rounded-xl bg-{{ $data['color'] }}-50 text-{{ $data['color'] }}-600 flex items-center justify-center border border-{{ $data['color'] }}-100 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $data['icon'] !!}</svg>
                            </div>
                            <div>
                                <h4 class="font-black text-gray-800 text-sm uppercase tracking-wider leading-tight">{{ $categoryName }}</h4>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">{{ count($data['items']) }} Item Tersedia</p>
                            </div>
                        </div>

                        <div class="p-5 flex-grow bg-gray-50/30">
                            <ul class="space-y-3">
                                @foreach($data['items'] as $panelName)
                                    @php 
                                        $count = $stockCounts[$panelName] ?? 0; 
                                        $hasStock = $count > 0;
                                    @endphp
                                    <li class="relative bg-white border {{ $hasStock ? 'border-indigo-100 shadow-sm' : 'border-gray-100' }} rounded-xl p-3.5 transition-all duration-200 group flex justify-between items-center">
                                        
                                        <div class="flex items-center gap-3">
                                            <div class="w-2 h-2 rounded-full {{ $hasStock ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)]' : 'bg-gray-300' }}"></div>
                                            <div>
                                                <h5 class="text-xs font-bold {{ $hasStock ? 'text-gray-800' : 'text-gray-400' }}">{{ $panelName }}</h5>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            @if($hasStock)
                                                <span class="inline-flex items-center font-mono font-black text-sm text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">
                                                    {{ $count }}
                                                </span>
                                                <a href="{{ route('spareparts.stocks.edit', ['panel' => bin2hex($panelName)]) }}" class="w-7 h-7 rounded-lg bg-gray-50 border border-gray-200 flex items-center justify-center text-gray-400 hover:text-amber-600 hover:bg-amber-50 hover:border-amber-200 transition-all" title="Edit Detail">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </a>
                                            @else
                                                <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest">Kosong</span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="bg-white px-6 py-4 border-t border-gray-50 flex justify-between items-center">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Fisik Unit</span>
                            <div class="flex items-center gap-2">
                                <span class="text-gray-900 font-black text-sm">{{ collect($data['items'])->sum(fn($p) => $stockCounts[$p] ?? 0) }}</span>
                                <span class="text-xs text-gray-400">Unit</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- TABEL RIWAYAT BARANG MASUK --}}
            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden mb-8" 
                 x-data="{ page: 1, perPage: 4, totalBatches: {{ count($groupedHistory) }} }">
                 
                <div class="px-8 py-6 border-b border-gray-100 flex items-center gap-3 bg-white">
                    <div class="bg-indigo-50 p-2 rounded-lg text-indigo-600 border border-indigo-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-gray-900 uppercase tracking-tight">Log Stok Masuk (Batch)</h3>
                        <p class="text-gray-400 text-xs font-bold mt-0.5 tracking-widest uppercase">Riwayat input barang per transaksi</p>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 text-gray-400 text-[10px] font-black uppercase tracking-widest border-b border-gray-100">
                                <th class="px-8 py-5">Tgl Input</th>
                                <th class="px-6 py-5">Estimasi Tiba (ETA)</th>
                                <th class="px-6 py-5">Sumber / Supplier</th>
                                <th class="px-6 py-5">Lokasi Rak</th>
                                <th class="px-6 py-5 text-center">Total Qty</th>
                                <th class="px-6 py-5 text-right">Total Belanja</th>
                                <th class="px-8 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm min-h-[300px]">
                            @forelse($groupedHistory as $batch)
                                <tr class="hover:bg-indigo-50/30 transition-colors group"
                                    x-show="page === Math.ceil({{ $loop->iteration }} / perPage)"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform translate-x-4"
                                    x-transition:enter-end="opacity-100 transform translate-x-0"
                                    style="display: none;">
                                    
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="font-black text-gray-800">{{ $batch['date']->format('d M Y') }}</div>
                                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">{{ $batch['date']->format('H:i') }} WITA</div>
                                    </td>
                                    
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        @if($batch['eta'])
                                            <span class="text-indigo-600 font-bold bg-indigo-50 px-2 py-1 rounded text-xs border border-indigo-100">
                                                {{ date('d M Y', strtotime($batch['eta'])) }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5 whitespace-nowrap">
                                        @php
                                            $source = $batch['source'];
                                            
                                            $badgeColor = match(true) {
                                                in_array($source, ['TAM Toyota (Official)', 'TAM Toyota']) => 'bg-red-50 text-red-600 border-red-200',
                                                in_array($source, ['Pembelian Luar (Toko)', 'Beli Putus', 'Pembelian Luar']) => 'bg-amber-50 text-amber-600 border-amber-200',
                                                in_array($source, ['Sisa Proyek Lama', 'Sisa Proyek']) => 'bg-gray-50 text-gray-600 border-gray-200',
                                                $source === 'Retur Customer' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                                default => 'bg-blue-50 text-blue-600 border-blue-200'
                                            };

                                            $displayText = str_replace([' (Official)', ' (Toko)', ' Lama'], '', $source);
                                        @endphp
                                        
                                        <span class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border {{ $badgeColor }}">
                                            {{ $displayText }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="flex items-center gap-2 text-xs font-bold text-gray-600">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            {{ $batch['location'] ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-5 text-center whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 font-black text-xs text-gray-800 border border-gray-200 shadow-sm">
                                            {{ $batch['total_qty'] }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5 text-right font-mono font-black text-gray-800 whitespace-nowrap">
                                        Rp {{ number_format($batch['total_cost'], 0, ',', '.') }}
                                    </td>

                                    <td class="px-8 py-5 text-center whitespace-nowrap">
                                        <button @click="selectedBatch = {{ json_encode($batch) }}; viewMode = 'list'; openModal = true" class="px-4 py-2 bg-white border border-indigo-200 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm">
                                            Detail Item
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-8 py-16 text-center">
                                        <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        </div>
                                        <p class="font-black text-gray-400 text-sm uppercase tracking-widest">Belum Ada Riwayat Input</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(count($groupedHistory) > 0)
                <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 flex items-center justify-between">
                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                        Halaman <span class="text-indigo-600" x-text="page"></span> dari <span x-text="Math.ceil(totalBatches / perPage)"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button @click="if(page > 1) page--" 
                                :class="{ 'opacity-50 cursor-not-allowed': page === 1 }"
                                class="px-4 py-2 bg-white border border-gray-200 text-gray-600 hover:bg-gray-100 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            Prev
                        </button>
                        <button @click="if(page < Math.ceil(totalBatches / perPage)) page++" 
                                :class="{ 'opacity-50 cursor-not-allowed': page === Math.ceil(totalBatches / perPage) }"
                                class="px-4 py-2 bg-white border border-gray-200 text-gray-600 hover:bg-gray-100 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm flex items-center gap-1">
                            Next
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- MODAL DETAIL BATCH SPAREPART (FINAL: REFERENSI SOURCE 10, FIXED SCROLL) --}}
        <div x-show="openModal" style="display: none;" class="fixed inset-0 z-[99999] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" x-transition.opacity x-cloak>
            
            <div class="bg-white rounded-[2.5rem] w-full max-w-2xl shadow-2xl overflow-hidden transform transition-all text-left flex flex-col max-h-[85vh]" @click.away="openModal = false">
                
                {{-- HEADER MODAL --}}
                <div class="bg-gray-900 p-5 sm:p-6 text-white flex justify-between items-center shrink-0">
                    <div>
                        <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-1">Rincian Item Masuk</p>
                        <h3 class="text-lg font-black capitalize tracking-tight text-white">Detail Batch Stok Logistik</h3>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Sumber: <span class="text-indigo-400 font-black" x-text="selectedBatch?.source"></span></p>
                    </div>
                    <button @click="openModal = false" class="p-2 hover:bg-white/10 text-white rounded-full transition-colors shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                {{-- 🔥 KONDISI 1: VIEW DAFTAR ITEM (Scrollable List 1 Item) 🔥 --}}
                <div x-show="viewMode === 'list'" class="flex flex-col overflow-hidden" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    
                    {{-- Gak pake flex-1 lagi di bungkus ini, biar tinggi max-h dihargai! --}}
                    <div class="p-5 sm:p-6 bg-gray-50/50">
                        
                        {{-- LIST ITEM: max-h-[90px] Pas 1 Item, flex-1 dibuang murni ngikut Source 10 --}}
                        <div class="space-y-3 overflow-y-auto max-h-[90px] pr-2 [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-gray-300 [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-gray-400 transition-colors">
                            <template x-for="item in selectedBatch?.items" :key="item.id">
                                <div class="bg-white border border-gray-200 rounded-xl p-4 flex items-center gap-4 shadow-sm hover:border-indigo-200 transition-colors">
                                    <div class="w-12 h-12 shrink-0 bg-gray-100 text-gray-800 font-black text-xl rounded-lg flex items-center justify-center border border-gray-200" x-text="item.qty"></div>
                                    <div class="flex-1">
                                        <h4 class="font-black text-gray-900 text-sm" x-text="item.panel_name"></h4>
                                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-0.5">
                                            Unit Price: Rp <span x-text="new Intl.NumberFormat('id-ID').format(item.unit_price)"></span>
                                        </p>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <p class="font-mono font-black text-indigo-700 text-sm">
                                            Rp <span x-text="new Intl.NumberFormat('id-ID').format(item.subtotal)"></span>
                                        </p>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        {{-- INFO TOTAL (Murni nempel di bawah scroll) --}}
                        <div class="mt-5 pt-5 border-t border-gray-200 flex justify-between items-center">
                            <div>
                                <p class="text-[11px] font-black text-gray-500 uppercase tracking-widest">Total Harga</p>
                                <p class="text-[10px] text-gray-400 font-medium mt-0.5">Est. biaya pengadaan logistik</p>
                            </div>
                            <div class="text-xl font-mono font-black text-gray-900">
                                Rp <span x-text="new Intl.NumberFormat('id-ID').format(selectedBatch?.total_cost)"></span>
                            </div>
                        </div>
                    </div>

                    {{-- FOOTER BUTTONS VIEW 1 --}}
                    <div class="bg-white px-6 py-4 border-t border-gray-100 flex justify-between items-center">
                        <button @click="openModal = false" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-sm">
                            Kembali
                        </button>
                        
                        <template x-if="selectedBatch?.foto_nota">
                            <button @click="viewMode = 'photo'" class="px-5 py-2.5 bg-gray-900 hover:bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-gray-900/20 flex items-center gap-2 transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Buka Foto Bukti
                            </button>
                        </template>
                    </div>
                </div>

                {{-- 🚀 KONDISI 2: THUMBNAIL FOTO NOTA (RAPI & PAS DI TENGAH) 🚀 --}}
                <div x-show="viewMode === 'photo'" style="display: none;" class="flex flex-col flex-1 overflow-hidden" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                    
                    {{-- Padding atas-bawah dikecilin jadi py-4 biar tombol gak kepotong ke bawah --}}
                    <div class="p-4 sm:p-5 overflow-y-auto bg-gray-50 flex-1 flex flex-col items-center justify-center">
                        
                        {{-- THUMBNAIL KOTAK KECIL DITENGAH --}}
                        <a :href="'/storage/' + selectedBatch?.foto_nota" target="_blank" class="relative group block w-48 h-48 sm:w-60 sm:h-60 rounded-2xl border-2 border-gray-200 shadow-sm overflow-hidden transition-all hover:border-indigo-400 hover:shadow-xl">
                            <img :src="'/storage/' + selectedBatch?.foto_nota" alt="Bukti Nota Fisik" class="w-full h-full object-cover">
                            
                            {{-- HOVER EFFECT (MUNCUL ICON ZOOM & TEKS) --}}
                            <div class="absolute inset-0 bg-gray-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center pointer-events-none backdrop-blur-sm">
                                <svg class="w-8 h-8 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                <span class="text-white font-black text-[10px] uppercase tracking-widest bg-gray-900/80 px-3 py-1.5 rounded-lg shadow-sm">Klik Full Resolusi</span>
                            </div>
                        </a>
                    </div>

                    {{-- FOOTER BUTTONS VIEW 2 --}}
                    <div class="bg-white px-6 py-4 border-t border-gray-100 flex justify-start items-center shrink-0">
                        <button @click="viewMode = 'list'" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke List
                        </button>
                    </div>
                </div>
                
            </div>
        </div>

    </div>
</x-app-layout>