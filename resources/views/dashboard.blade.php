<x-app-layout>
    <x-slot name="header">
        <div class="py-1">
            <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                {{ __('📊 Dashboard Operasional') }}
            </h2>
            <p class="text-sm text-gray-500 font-bold mt-1">
                Ringkasan Sistem / <span class="text-red-600 uppercase tracking-wider">Service Advisor</span>
            </p>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ========================================================== --}}
            {{-- 1. EMPAT KARTU STATISTIK (GAYA GRADIENT) --}}
            {{-- ========================================================== --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 px-4 sm:px-0">
                {{-- KARTU 1: OMZET --}}
                <div class="bg-gradient-to-br from-emerald-500 to-green-700 rounded-[2rem] p-6 text-white shadow-xl shadow-green-600/20 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 opacity-20 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex justify-between items-center mb-4 relative z-10">
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <span class="text-xs font-black tracking-widest uppercase bg-white/20 px-3 py-1.5 rounded-lg backdrop-blur-sm">Omzet Total</span>
                    </div>
                    <div class="text-3xl font-black font-mono relative z-10 group-hover:scale-105 transition-transform origin-left">
                        Rp {{ number_format($totalPendapatan / 1000000, 1, ',', '.') }} <span class="text-lg">Jt</span>
                    </div>
                </div>

                {{-- KARTU 2: TOTAL UNIT --}}
                <div class="bg-gradient-to-br from-blue-500 to-indigo-700 rounded-[2rem] p-6 text-white shadow-xl shadow-blue-600/20 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 opacity-20 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="flex justify-between items-center mb-4 relative z-10">
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg></div>
                        <span class="text-xs font-black tracking-widest uppercase bg-white/20 px-3 py-1.5 rounded-lg backdrop-blur-sm">Total Unit</span>
                    </div>
                    <div class="text-3xl font-black relative z-10 group-hover:scale-105 transition-transform origin-left">
                        {{ $totalSpk }} <span class="text-lg font-bold opacity-80">Mobil</span>
                    </div>
                </div>

                {{-- KARTU 3: PROSES --}}
                <div class="bg-gradient-to-br from-amber-400 to-orange-500 rounded-[2rem] p-6 text-white shadow-xl shadow-orange-600/20 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 opacity-20 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </div>
                    <div class="flex justify-between items-center mb-4 relative z-10">
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm"><svg class="w-6 h-6 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg></div>
                        <span class="text-xs font-black tracking-widest uppercase bg-white/20 px-3 py-1.5 rounded-lg backdrop-blur-sm">Dikerjakan</span>
                    </div>
                    <div class="text-3xl font-black relative z-10 group-hover:scale-105 transition-transform origin-left">
                        {{ $totalUnitProses }} <span class="text-lg font-bold opacity-80">Unit</span>
                    </div>
                </div>

                {{-- KARTU 4: SELESAI --}}
                <div class="bg-gradient-to-br from-rose-500 to-pink-700 rounded-[2rem] p-6 text-white shadow-xl shadow-pink-600/20 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 opacity-20 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div class="flex justify-between items-center mb-4 relative z-10">
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
                        <span class="text-xs font-black tracking-widest uppercase bg-white/20 px-3 py-1.5 rounded-lg backdrop-blur-sm">Selesai</span>
                    </div>
                    <div class="text-3xl font-black relative z-10 group-hover:scale-105 transition-transform origin-left">
                        {{ $totalUnitSelesai }} <span class="text-lg font-bold opacity-80">Unit</span>
                    </div>
                </div>
            </div>

            {{-- ========================================================== --}}
            {{-- ALERT KOMPLAIN MASUK (DITARUH DI BAWAH KARTU BIAR KONSISTEN) --}}
            {{-- ========================================================== --}}
            @php
                $pendingComplaints = \App\Models\Complaint::where('status', 'menunggu')->count();
            @endphp

            @if($pendingComplaints > 0)
                <div class="mb-10 px-4 sm:px-0">
                    <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 animate-pulse"></span>
                        Perhatian: Ada Klaim Garansi Masuk
                    </h3>
                    <div class="bg-white border-l-4 border-red-500 p-5 rounded-2xl shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:shadow-md transition-all relative overflow-hidden group">
                        <div class="absolute right-0 top-0 opacity-5">
                            <svg class="w-24 h-24 -mt-4 -mr-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div class="relative z-10">
                            <p class="text-[10px] font-black text-red-600 uppercase tracking-widest mb-1">Menunggu Verifikasi SA</p>
                            <h4 class="font-black text-gray-900 text-base leading-tight">Terdapat {{ $pendingComplaints }} Komplain Customer</h4>
                            <p class="text-xs text-gray-500 mt-0.5 font-bold uppercase">Segera review keluhan dan foto bukti.</p>
                        </div>
                        <a href="{{ route('sa.complaints.index') }}" 
                           class="relative z-10 bg-red-50 text-red-700 border border-red-200 hover:bg-red-600 hover:text-white text-[10px] sm:text-xs font-black px-5 py-2.5 rounded-xl uppercase tracking-widest transition-all whitespace-nowrap shadow-sm flex items-center gap-2">
                           Review Sekarang
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            @endif

            {{-- ========================================================== --}}
            {{-- 2. GRAFIK OMZET & PRODUKSI --}}
            {{-- ========================================================== --}}
            <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100 p-8 mb-8 mx-4 sm:mx-0">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-black text-gray-800 text-lg flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        Trend Pendapatan ({{ date('Y') }})
                    </h3>
                    <span class="px-4 py-1.5 bg-emerald-50 text-emerald-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-100">Grafik Bulanan</span>
                </div>
                <div class="relative h-72">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 px-4 sm:px-0">
                <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100 p-8">
                    <h3 class="font-black text-gray-800 text-lg mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                        Status Pengerjaan
                    </h3>
                    <div class="relative h-64"><canvas id="statusChart"></canvas></div>
                </div>
                <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100 p-8">
                    <h3 class="font-black text-gray-800 text-lg mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Tipe Perbaikan
                    </h3>
                    <div class="relative h-64"><canvas id="repairChart"></canvas></div>
                </div>
            </div>

            {{-- ========================================================== --}}
            {{-- 3. LIVE MONITORING (POSISI UNIT) --}}
            {{-- ========================================================== --}}
            <div class="mb-8 px-4 sm:px-0">
                <div class="flex justify-between items-end mb-6">
                    <div>
                        <h3 class="font-black text-gray-900 text-xl flex items-center gap-2">
                            📡 Live Monitoring Produksi
                            <span class="bg-red-100 text-red-600 text-[10px] font-black px-2.5 py-1 rounded-lg animate-pulse uppercase tracking-widest border border-red-200">Real-time</span>
                        </h3>
                        <p class="text-gray-500 text-sm mt-1 font-bold">Pantauan langsung posisi unit di lantai bengkel.</p>
                    </div>
                </div>

                @if($monitoringUnits->isEmpty())
                    <div class="bg-white rounded-[2rem] p-12 text-center border border-gray-100 shadow-sm flex flex-col items-center justify-center">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        </div>
                        <p class="text-gray-500 font-bold uppercase tracking-widest text-sm">Lantai produksi sedang kosong</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($monitoringUnits as $wo)
                            <div class="bg-white rounded-[2rem] border border-gray-100 p-6 shadow-sm hover:shadow-xl hover:shadow-gray-200/50 transition-all relative overflow-hidden group">
                                
                                {{-- HEADER CARD --}}
                                <div class="flex justify-between items-start mb-5">
                                    <div class="flex flex-col gap-1.5">
                                        <div class="font-black text-gray-900 leading-tight truncate text-lg group-hover:text-red-600 transition-colors">{{ $wo->vehicle->merk }} {{ $wo->vehicle->model }}</div>
                                        <div>
                                            {{-- Plat Nomor Desain Pro --}}
                                            <span class="inline-block bg-gray-900 text-white font-mono text-[11px] font-black px-2.5 py-0.5 rounded-md shadow-sm tracking-widest border-b-2 border-gray-600">
                                                {{ $wo->vehicle->nopol }}
                                            </span>
                                        </div>
                                    </div>
                                    @if($wo->repair_type == 'Quick Repair')
                                        <span class="bg-yellow-50 text-yellow-700 text-[10px] font-black px-2.5 py-1 rounded-lg border border-yellow-200 uppercase tracking-widest">⚡ Quick</span>
                                    @else
                                        <span class="bg-gray-50 text-gray-600 text-[10px] font-black px-2.5 py-1 rounded-lg border border-gray-200 uppercase tracking-widest">🛠️ Reg</span>
                                    @endif
                                </div>

                                {{-- POSISI UNIT (BADGE WARNA-WARNI) --}}
                                <div class="mb-5 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                    <div class="flex justify-between items-end mb-3">
                                        @php
                                            $stage = $wo->repair_stage ?? 'Menunggu';
                                            $badgeClass = 'bg-white text-gray-600 border-gray-200'; 
                                            $icon = '⏳';

                                            if(str_contains($stage, 'Body')) { $badgeClass = 'bg-white text-slate-700 border-slate-300'; $icon='🔨'; }
                                            elseif(str_contains($stage, 'Prep')) { $badgeClass = 'bg-white text-orange-600 border-orange-300'; $icon='🧽'; }
                                            elseif(str_contains($stage, 'Paint')) { $badgeClass = 'bg-white text-indigo-600 border-indigo-300'; $icon='🔫'; }
                                            elseif(str_contains($stage, 'Poles')) { $badgeClass = 'bg-white text-teal-600 border-teal-300'; $icon='✨'; }
                                            elseif(str_contains($stage, 'Washing')) { $badgeClass = 'bg-white text-blue-600 border-blue-300'; $icon='🚿'; }
                                        @endphp
                                        <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase border shadow-sm {{ $badgeClass }} flex items-center gap-1.5">
                                            {{ $icon }} {{ $stage }}
                                        </span>
                                        <span class="text-sm font-black text-gray-900">{{ $wo->progress }}%</span>
                                    </div>
                                    
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden shadow-inner">
                                        <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 transition-all duration-1000 relative" style="width: {{ $wo->progress }}%"></div>
                                    </div>
                                </div>

                                {{-- FOOTER: PIC & ESTIMASI --}}
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-gray-900 flex items-center justify-center text-[10px] text-white font-black shadow-sm">
                                            {{ substr($wo->mechanic->name ?? '?', 0, 1) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">PIC Teknisi</span>
                                            <span class="text-xs font-black text-gray-800">{{ Str::limit($wo->mechanic->name ?? 'Belum plot', 12) }}</span>
                                        </div>
                                    </div>
                                    <div class="text-right flex flex-col">
                                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Selesai</span>
                                        <span class="text-xs font-black text-red-600">{{ date('d M', strtotime($wo->estimasi_selesai)) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- ========================================================== --}}
            {{-- 4. TABEL SPK TERBARU (DI BAWAH) --}}
            {{-- ========================================================== --}}
            <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100 mx-4 sm:mx-0 mb-10">
                <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-black text-gray-800 text-lg flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        SPK Terbaru Masuk
                    </h3>
                    <a href="{{ route('work-orders.index') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl hover:text-red-600 hover:border-red-300 transition-all text-xs font-bold shadow-sm flex items-center gap-1">
                        Lihat Semua 
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                <div class="overflow-x-auto w-full pb-4">
                    <table class="w-full text-left min-w-[900px]">
                        <thead class="bg-white border-b border-gray-100">
                            <tr>
                                <th class="px-8 py-5 text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Informasi SPK</th>
                                <th class="px-8 py-5 text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Kendaraan & Nopol</th>
                                <th class="px-8 py-5 text-center text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Jenis Pengerjaan</th>
                                <th class="px-8 py-5 text-center text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Status</th>
                                <th class="px-8 py-5 text-right text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Estimasi Biaya</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white text-sm">
                            @forelse($recentSpk as $spk)
                            <tr class="group hover:bg-red-50/40 transition-colors">
                                
                                {{-- INFO SPK (Hover Merah) --}}
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-base font-black text-gray-900 group-hover:text-red-600 transition-colors tracking-tight">
                                            {{ $spk->nomor_spk }}
                                        </span>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ date('d M Y', strtotime($spk->tanggal_masuk)) }}
                                        </span>
                                    </div>
                                </td>

                                {{-- KENDARAAN (Plat Hitam) --}}
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <div class="flex flex-col gap-2">
                                        <div class="font-bold text-gray-800 text-sm">
                                            {{ $spk->vehicle->merk ?? '' }} {{ $spk->vehicle->model ?? '' }}
                                        </div>
                                        <div>
                                            <span class="inline-block bg-gray-900 text-white font-mono text-xs font-black px-2.5 py-1 rounded-md shadow-sm border-b-2 border-gray-600">
                                                {{ $spk->vehicle->nopol ?? 'DELETED' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                {{-- TIPE --}}
                                <td class="px-8 py-5 text-center whitespace-nowrap">
                                    <span class="inline-block px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border
                                        {{ $spk->repair_type == 'Quick Repair' ? 'bg-red-50 text-red-600 border-red-200' : 'bg-gray-50 text-gray-700 border-gray-200' }}">
                                        {{ $spk->repair_type }}
                                    </span>
                                </td>

                                {{-- STATUS --}}
                                <td class="px-8 py-5 text-center whitespace-nowrap">
                                    @php
                                        $statusClass = match(strtolower($spk->status)) {
                                            'selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                            'proses' => 'bg-blue-50 text-blue-600 border-blue-200',
                                            'pending' => 'bg-amber-50 text-amber-600 border-amber-200',
                                            default => 'bg-gray-50 text-gray-600 border-gray-200'
                                        };
                                        $pulseClass = strtolower($spk->status) == 'proses' ? 'animate-pulse' : '';
                                    @endphp
                                    <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black tracking-widest border {{ $statusClass }} {{ $pulseClass }} uppercase">
                                        {{ $spk->status }}
                                    </span>
                                </td>

                                {{-- BIAYA --}}
                                <td class="px-8 py-5 text-right whitespace-nowrap">
                                    <div class="font-mono font-black text-sm text-gray-800">
                                        Rp {{ number_format($spk->estimasi_biaya, 0, ',', '.') }}
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-16 text-center italic text-gray-400 font-bold">Belum ada SPK baru.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- CHART SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Set Font Global untuk Chart
        Chart.defaults.font.family = "'Nunito', 'Segoe UI', sans-serif";
        Chart.defaults.font.weight = 'bold';
        Chart.defaults.color = '#9CA3AF';

        // 1. CHART BULANAN
        const ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
        new Chart(ctxMonthly, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($monthlyIncome),
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 4,
                    pointBackgroundColor: '#047857',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { 
                        beginAtZero: true,
                        border: { dash: [4, 4] },
                        grid: { color: '#F3F4F6' },
                        ticks: { callback: function(value) { return 'Rp ' + (value/1000000) + ' Jt'; } }
                    }
                }
            }
        });

        // 2. CHART DONUT
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Proses', 'Selesai'],
                datasets: [{
                    data: [{{ $statusPending }}, {{ $statusProses }}, {{ $statusSelesai }}], 
                    backgroundColor: ['#FBBF24', '#3B82F6', '#10B981'],
                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false, 
                cutout: '75%',
                plugins: { legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } } } 
            }
        });

        // 3. CHART BAR
        new Chart(document.getElementById('repairChart'), {
            type: 'bar',
            data: {
                labels: ['Regular', 'Quick Repair'],
                datasets: [{
                    label: 'Total Unit',
                    data: [{{ $repairRegular }}, {{ $repairQuick }}],
                    backgroundColor: ['#4B5563', '#EF4444'],
                    borderRadius: 8,
                    barPercentage: 0.6
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false, 
                plugins: { legend: { display: false } }, 
                scales: { 
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, border: { dash: [4, 4] }, grid: { color: '#F3F4F6' }, ticks: { stepSize: 1 } } 
                } 
            }
        });
    </script>
</x-app-layout>