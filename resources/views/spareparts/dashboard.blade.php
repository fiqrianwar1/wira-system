<x-app-layout>
    <x-slot name="header">
        <div class="py-1">
            <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                {{ __('📦 Logistik Control Center') }}
            </h2>
            <p class="text-sm text-gray-500 font-bold mt-1">
                Pantau Grafik, Statistik & Stok / <span class="text-indigo-600 uppercase tracking-wider">Gudang Sparepart</span>
            </p>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- ALERT --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center gap-3 transform transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            {{-- ========================================================== --}}
            {{-- 1. KARTU STATISTIK (PREMIUM GRADIENT STYLE) --}}
            {{-- ========================================================== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 px-4 sm:px-0 mb-2">
                
                {{-- KARTU 1: TOTAL PO DIBUAT (Indigo) --}}
                <div class="bg-gradient-to-br from-indigo-500 to-purple-700 rounded-[2rem] p-6 text-white shadow-xl shadow-indigo-500/20 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 opacity-20 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="flex justify-between items-center mb-4 relative z-10">
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <span class="text-[10px] font-black bg-white/20 px-3 py-1.5 rounded-lg backdrop-blur-sm uppercase tracking-widest">Total PO</span>
                    </div>
                    <div class="text-4xl font-black relative z-10 group-hover:-translate-y-1 transition-transform">
                        {{ $totalPO ?? 0 }} <span class="text-sm font-bold opacity-80 uppercase tracking-widest">Dokumen</span>
                    </div>
                </div>

                {{-- KARTU 2: OTW (Amber) --}}
                <div class="bg-gradient-to-br from-amber-400 to-orange-500 rounded-[2rem] p-6 text-white shadow-xl shadow-orange-500/20 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 opacity-20 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div class="flex justify-between items-center mb-4 relative z-10">
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                            <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <span class="text-[10px] font-black bg-white/20 px-3 py-1.5 rounded-lg backdrop-blur-sm uppercase tracking-widest">Dikirim (OTW)</span>
                    </div>
                    <div class="text-4xl font-black relative z-10 group-hover:-translate-y-1 transition-transform">
                        {{ $totalOtw ?? 0 }} <span class="text-sm font-bold opacity-80 uppercase tracking-widest">Item</span>
                    </div>
                </div>

                {{-- KARTU 3: READY (Emerald) --}}
                <div class="bg-gradient-to-br from-emerald-400 to-teal-600 rounded-[2rem] p-6 text-white shadow-xl shadow-teal-500/20 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 opacity-20 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div class="flex justify-between items-center mb-4 relative z-10">
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-[10px] font-black bg-white/20 px-3 py-1.5 rounded-lg backdrop-blur-sm uppercase tracking-widest">Stok Ready</span>
                    </div>
                    <div class="text-4xl font-black relative z-10 group-hover:-translate-y-1 transition-transform">
                        {{ $totalReady ?? 0 }} <span class="text-sm font-bold opacity-80 uppercase tracking-widest">Item</span>
                    </div>
                </div>

                {{-- KARTU 4: TOTAL BELANJA (Rose/Merah) --}}
                <div class="bg-gradient-to-br from-rose-500 to-red-600 rounded-[2rem] p-6 text-white shadow-xl shadow-red-500/20 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 opacity-20 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex justify-between items-center mb-4 relative z-10">
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-[10px] font-black bg-white/20 px-3 py-1.5 rounded-lg backdrop-blur-sm uppercase tracking-widest">Pengeluaran</span>
                    </div>
                    <div class="text-3xl font-black relative z-10 group-hover:-translate-y-1 transition-transform">
                        <span class="text-xl">Rp</span> {{ number_format(($totalBelanja ?? 0) / 1000000, 1, ',', '.') }} <span class="text-sm font-bold opacity-80 uppercase tracking-widest">Juta</span>
                    </div>
                </div>
            </div>

            {{-- ========================================================== --}}
            {{-- FITUR BARU: ALERT NOTIFIKASI KEDAP-KEDIP (REQUEST SPK SA) --}}
            {{-- ========================================================== --}}
            @if(isset($pendingSpks) && $pendingSpks->count() > 0)
                <div class="bg-red-50 border-l-4 border-red-500 p-5 rounded-[1.5rem] shadow-sm mx-4 sm:mx-0">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="relative flex h-4 w-4">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500"></span>
                        </span>
                        <h3 class="text-sm font-black text-red-800 uppercase tracking-widest">To-Do List: Order Part SPK (Urgent!)</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($pendingSpks as $spk)
                            <div class="bg-white p-4 rounded-xl shadow-sm border border-red-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                                <div class="mb-4">
                                    <h4 class="font-black text-gray-900">{{ $spk->vehicle->nopol ?? 'NOPOL' }}</h4>
                                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-0.5">{{ $spk->nomor_spk }}</p>
                                    <p class="text-xs text-gray-600 mt-2 bg-gray-50 p-2 rounded-lg border border-gray-100"><span class="font-black text-red-600">{{ $spk->details->count() }} Panel</span> butuh di-Order (GT/GC)</p>
                                </div>
                                <a href="{{ route('spareparts.purchases.create', ['spk_id' => $spk->id]) }}" class="text-center bg-red-500 hover:bg-red-600 text-white text-[10px] font-black px-4 py-2.5 rounded-lg uppercase tracking-widest transition-all">
                                    Proses Bikin PO →
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ========================================================== --}}
            {{-- 2. GRAFIK CHART (VISUALISASI DATA) --}}
            {{-- ========================================================== --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4 sm:px-0">
                
                {{-- Chart Pie Status --}}
                <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 col-span-1">
                    <h3 class="font-black text-gray-800 mb-6 flex items-center gap-2 text-lg">
                        <div class="p-2 bg-indigo-100 text-indigo-600 rounded-xl"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg></div>
                        Status Logistik
                    </h3>
                    <div class="h-56 relative"><canvas id="statusChart"></canvas></div>
                </div>

                {{-- Chart Line Belanja --}}
                <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 col-span-1 md:col-span-2">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-black text-gray-800 text-lg flex items-center gap-2">
                            <div class="p-2 bg-emerald-100 text-emerald-600 rounded-xl"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg></div>
                            Tren Belanja (6 Bulan) 
                        </h3>
                        <span class="bg-blue-50 border border-blue-100 text-blue-600 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-lg">Cash Flow</span>
                    </div>
                    <div class="h-56 relative"><canvas id="spendingChart"></canvas></div>
                </div>
            </div>

            {{-- ========================================================== --}}
            {{-- 3. QUICK LINKS (SHORTCUT MENU) --}}
            {{-- ========================================================== --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4 sm:px-0">
                <a href="{{ route('spareparts.purchases.index') }}" class="block p-6 bg-white border border-gray-100 rounded-[2rem] shadow-sm hover:shadow-xl hover:border-indigo-200 transition-all group hover:-translate-y-1">
                    <div class="flex items-center gap-5">
                        <div class="bg-indigo-50 p-4 rounded-2xl text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-black text-lg text-gray-900 leading-tight">Order PO</h4>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Manajemen Pengadaan</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('spareparts.stocks.index') }}" class="block p-6 bg-white border border-gray-100 rounded-[2rem] shadow-sm hover:shadow-xl hover:border-teal-200 transition-all group hover:-translate-y-1">
                    <div class="flex items-center gap-5">
                        <div class="bg-teal-50 p-4 rounded-2xl text-teal-600 group-hover:bg-teal-600 group-hover:text-white transition-colors shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-black text-lg text-gray-900 leading-tight">Stok Gudang</h4>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Distribusi ke Mekanik</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('spareparts.purchases.recap') }}" target="_blank" class="block p-6 bg-white border border-gray-100 rounded-[2rem] shadow-sm hover:shadow-xl hover:border-rose-200 transition-all group hover:-translate-y-1">
                    <div class="flex items-center gap-5">
                        <div class="bg-rose-50 p-4 rounded-2xl text-rose-600 group-hover:bg-rose-600 group-hover:text-white transition-colors shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-black text-lg text-gray-900 leading-tight">Cetak Laporan</h4>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Rekap Keuangan</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- ========================================================== --}}
            {{-- 4. PURCHASE ORDER TERBARU --}}
            {{-- ========================================================== --}}
            <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100 mx-4 sm:mx-0">
                <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h3 class="font-black text-gray-900 text-xl flex items-center gap-2">
                            🛒 Purchase Order Terbaru
                        </h3>
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Daftar pesanan logistik terakhir ke supplier.</p>
                    </div>
                    <a href="{{ route('spareparts.purchases.index') }}" class="text-xs font-black uppercase tracking-widest text-indigo-600 hover:text-indigo-800 transition-colors bg-indigo-50 border border-indigo-100 px-4 py-2.5 rounded-xl shadow-sm hover:shadow">
                        Lihat Semua &rarr;
                    </a>
                </div>

                <div class="p-8">
                    @if(isset($recentPOs) && $recentPOs->isEmpty())
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-dashed border-gray-200">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <h3 class="text-lg font-black text-gray-700 uppercase tracking-widest">Belum ada PO</h3>
                            <p class="text-xs text-gray-400 font-bold mt-1">Data order pembelian masih kosong.</p>
                        </div>
                    @elseif(isset($recentPOs))
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            @foreach($recentPOs as $po)
                                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-indigo-200 transition-all relative overflow-hidden group">
                                    {{-- Indikator Warna Status --}}
                                    @php 
                                        $isReceived = $po->status == 'Received';
                                        $barColor = $isReceived ? 'bg-emerald-500' : 'bg-amber-400';
                                    @endphp
                                    <div class="absolute left-0 top-0 bottom-0 w-2 {{ $barColor }}"></div>

                                    <div class="p-6 pl-8">
                                        <div class="flex justify-between items-start mb-5">
                                            <div>
                                                <div class="flex items-center gap-2 mb-2">
                                                    @if($isReceived)
                                                        <span class="bg-emerald-50 text-emerald-600 border border-emerald-200 text-[9px] font-black px-2.5 py-1 rounded-lg uppercase tracking-widest flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> RECEIVED</span>
                                                    @else
                                                        <span class="bg-amber-50 text-amber-600 border border-amber-200 text-[9px] font-black px-2.5 py-1 rounded-lg uppercase tracking-widest flex items-center gap-1 animate-pulse"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg> ORDERED</span>
                                                    @endif
                                                    <span class="text-[10px] font-bold text-gray-400">{{ $po->order_date->format('d M Y') }}</span>
                                                </div>
                                                <h3 class="text-xl font-black text-gray-900 tracking-tight">{{ $po->po_number }}</h3>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-0.5">Total Tagihan</span>
                                                <span class="text-base font-mono font-black text-indigo-700 bg-indigo-50 px-2 py-1 rounded border border-indigo-100">
                                                    Rp {{ number_format($po->total_amount, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-gray-50 p-4 rounded-2xl flex justify-between items-center border border-gray-100 group-hover:bg-indigo-50/30 transition-colors">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-400 font-bold shadow-sm group-hover:border-indigo-200 group-hover:text-indigo-500 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                </div>
                                                <div>
                                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Supplier / Toko</p>
                                                    <p class="text-sm font-black text-gray-800 uppercase">{{ Str::limit($po->supplier_name, 25) }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-[10px] font-bold text-gray-500 bg-white px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm"><span class="font-black text-indigo-600 text-sm">{{ $po->items->count() }}</span> Item</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- CHART SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = "'Nunito', 'Segoe UI', sans-serif";
        Chart.defaults.font.weight = 'bold';
        Chart.defaults.color = '#9CA3AF';

        // HITUNG DATA REAL: Total item dari SA yang nunggu dibikinin PO
        @php
            $butuhPO = isset($pendingSpks) ? $pendingSpks->sum(function($spk) {
                return $spk->details->count();
            }) : 0;
        @endphp

        const ctxStatus = document.getElementById('statusChart');
        if (ctxStatus) {
            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: ['Butuh Bikin PO', 'Sedang Dikirim', 'Barang Ready'],
                    datasets: [{
                        data: [
                            {{ $butuhPO }}, // <- DATA REAL: Ngambil dari alert merah di atas!
                            {{ $totalOtw ?? 0 }}, 
                            {{ $totalReady ?? 0 }}
                        ],
                        backgroundColor: ['#EF4444', '#F59E0B', '#10B981'],
                        borderWidth: 0, hoverOffset: 8
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    cutout: '75%',
                    plugins: { legend: { position: 'right', labels: { padding: 20, usePointStyle: true } } } 
                }
            });
        }

        const ctxSpending = document.getElementById('spendingChart');
        if (ctxSpending) {
            new Chart(ctxSpending.getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($months ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
                    datasets: [{
                        label: 'Total Belanja (Rp)',
                        data: {!! json_encode($monthlySpending ?? [0,0,0,0,0,0]) !!},
                        borderColor: '#4F46E5', // Indigo-600
                        backgroundColor: 'rgba(79, 70, 229, 0.1)', 
                        borderWidth: 3, 
                        pointRadius: 4, 
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#4F46E5',
                        fill: true, 
                        tension: 0.4
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    plugins: { legend: { display: false } }, 
                    scales: { 
                        y: { beginAtZero: true, border: { dash: [4, 4] }, grid: { color: '#F3F4F6' }, ticks: { callback: function(value) { return 'Rp ' + (value/1000000) + ' Jt'; } } }, 
                        x: { grid: { display: false } } 
                    } 
                }
            });
        }
    </script>
</x-app-layout>