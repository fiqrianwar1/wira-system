<x-app-layout>
    <x-slot name="header">
        <div class="py-1">
            <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                {{ __('🏭 Foreman Control Center') }}
            </h2>
            <p class="text-sm text-gray-500 font-bold mt-1">
                Ringkasan Produksi / <span class="text-red-600 uppercase tracking-wider">Komandan Lapangan</span>
            </p>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ========================================================== --}}
            {{-- 1. EMPAT KARTU STATISTIK (PREMIUM GRADIENT STYLE) --}}
            {{-- ========================================================== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 px-4 sm:px-0">
                
                {{-- KARTU 1: UNIT AKTIF --}}
                <div class="bg-gradient-to-br from-blue-500 to-indigo-700 rounded-[2rem] p-6 text-white shadow-xl shadow-blue-600/20 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 opacity-20 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div class="flex justify-between items-center mb-4 relative z-10">
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <span class="text-[10px] font-black tracking-widest uppercase bg-white/20 px-3 py-1.5 rounded-lg backdrop-blur-sm">Unit Diproses</span>
                    </div>
                    <div class="text-4xl font-black relative z-10 group-hover:-translate-y-1 transition-transform">
                        {{ $stats['total_proses'] }} <span class="text-sm font-bold opacity-80 uppercase tracking-widest">Mobil</span>
                    </div>
                </div>

                {{-- KARTU 2: ANTREAN SPK --}}
                <div class="bg-gradient-to-br from-amber-400 to-orange-500 rounded-[2rem] p-6 text-white shadow-xl shadow-orange-600/20 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 opacity-20 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex justify-between items-center mb-4 relative z-10">
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                            <svg class="w-6 h-6 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-[10px] font-black tracking-widest uppercase bg-white/20 px-3 py-1.5 rounded-lg backdrop-blur-sm">Antrean Masuk</span>
                    </div>
                    <div class="text-4xl font-black relative z-10 group-hover:-translate-y-1 transition-transform">
                        {{ $stats['unit_menunggu'] }} <span class="text-sm font-bold opacity-80 uppercase tracking-widest">Unit</span>
                    </div>
                </div>

                {{-- KARTU 3: OUTPUT BULAN INI --}}
                <div class="bg-gradient-to-br from-emerald-500 to-green-700 rounded-[2rem] p-6 text-white shadow-xl shadow-green-600/20 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 opacity-20 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex justify-between items-center mb-4 relative z-10">
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-[10px] font-black tracking-widest uppercase bg-white/20 px-3 py-1.5 rounded-lg backdrop-blur-sm">Bulan Ini</span>
                    </div>
                    <div class="text-4xl font-black relative z-10 group-hover:-translate-y-1 transition-transform">
                        {{ $stats['total_selesai_bulan_ini'] }} <span class="text-sm font-bold opacity-80 uppercase tracking-widest">Selesai</span>
                    </div>
                </div>

                {{-- KARTU 4: TOTAL MEKANIK --}}
                <div class="bg-gradient-to-br from-rose-500 to-red-700 rounded-[2rem] p-6 text-white shadow-xl shadow-red-600/20 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 opacity-20 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div class="flex justify-between items-center mb-4 relative z-10">
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <span class="text-[10px] font-black tracking-widest uppercase bg-white/20 px-3 py-1.5 rounded-lg backdrop-blur-sm">Mekanik</span>
                    </div>
                    <div class="text-4xl font-black relative z-10 group-hover:-translate-y-1 transition-transform">
                        {{ $stats['total_mekanik'] }} <span class="text-sm font-bold opacity-80 uppercase tracking-widest">Orang</span>
                    </div>
                </div>
            </div>

            {{-- ========================================================== --}}
            {{-- ALERT SPK BELUM DIPLOT --}}
            {{-- ========================================================== --}}
            @if($pendingSpks->count() > 0)
                <div class="mb-10 px-4 sm:px-0">
                    <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                        Antrean SPK Baru (Belum Diplot Mekanik)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                        @foreach($pendingSpks as $spk)
                            <div class="bg-white border-l-4 border-amber-500 p-5 rounded-2xl shadow-sm flex justify-between items-center group hover:shadow-md transition-all relative overflow-hidden">
                                <div class="absolute right-0 top-0 opacity-5">
                                    <svg class="w-24 h-24 -mt-4 -mr-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="relative z-10">
                                    <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-1">SPK-{{ str_pad($spk->id, 4, '0', STR_PAD_LEFT) }}</p>
                                    <h4 class="font-black text-gray-900 text-base leading-tight">{{ $spk->vehicle->nopol ?? 'NOPOL' }}</h4>
                                    <p class="text-xs text-gray-500 mt-0.5 font-bold uppercase">{{ $spk->vehicle->merk ?? 'Mobil' }}</p>
                                </div>
                                <a href="{{ route('foreman.progress.edit', $spk->id) }}" 
                                   class="relative z-10 bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-500 hover:text-white text-[10px] font-black px-4 py-2.5 rounded-xl uppercase tracking-widest transition-all whitespace-nowrap shadow-sm">
                                   Plot Mekanik
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ========================================================== --}}
            {{-- 2. GRAFIK / CHART --}}
            {{-- ========================================================== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10 px-4 sm:px-0">
                <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100 p-8">
                    <h3 class="font-black text-gray-800 text-lg mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                        Status Pengerjaan Total
                    </h3>
                    <div class="relative h-64">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100 p-8">
                    <h3 class="font-black text-gray-800 text-lg mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2m0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Tipe Perbaikan
                    </h3>
                    <div class="relative h-64">
                        <canvas id="repairChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- ========================================================== --}}
            {{-- 3. JOB ORDER CARDS (LIVE MONITORING) --}}
            {{-- ========================================================== --}}
            <div class="mb-10 px-4 sm:px-0">
                <div class="flex justify-between items-end mb-6">
                    <div>
                        <h3 class="font-black text-gray-900 text-xl flex items-center gap-2">
                            🔧 Job Order Aktif
                            <span class="bg-red-100 text-red-600 text-[10px] font-black px-2.5 py-1 rounded-lg animate-pulse uppercase tracking-widest border border-red-200">Prioritas</span>
                        </h3>
                        <p class="text-gray-500 text-sm mt-1 font-bold">Pantau unit yang sedang dikerjakan di lantai produksi.</p>
                    </div>
                    <button onclick="window.location.reload()" class="p-2.5 bg-white border border-gray-200 rounded-xl text-gray-500 hover:text-blue-600 hover:border-blue-300 transition-all shadow-sm" title="Refresh Data">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </button>
                </div>

                @if($workOrders->isEmpty())
                    <div class="bg-white rounded-[2rem] p-12 text-center border border-gray-100 shadow-sm flex flex-col items-center justify-center">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <h3 class="text-lg font-black text-gray-700 uppercase tracking-widest">Tidak ada unit aktif</h3>
                        <p class="text-gray-400 font-bold mt-1 text-sm">Lantai produksi saat ini sedang kosong.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($workOrders as $wo)
                            <div class="bg-white rounded-[2rem] border border-gray-100 p-6 shadow-sm hover:shadow-xl hover:shadow-gray-200/50 transition-all relative overflow-hidden group">
                                
                                @php 
                                    $deadline = \Carbon\Carbon::parse($wo->estimasi_selesai);
                                    $isUrgent = $deadline->isPast() || $deadline->diffInDays(now()) <= 1;
                                    $barColor = $isUrgent ? 'bg-red-500' : 'bg-blue-500';
                                @endphp
                                <div class="absolute left-0 top-0 bottom-0 w-2 {{ $barColor }}"></div>

                                {{-- HEADER CARD --}}
                                <div class="flex justify-between items-start mb-5 pl-2">
                                    <div class="flex flex-col gap-1.5">
                                        <div class="font-black text-gray-900 leading-tight truncate text-lg group-hover:text-blue-600 transition-colors">
                                            {{ $wo->vehicle->nopol }}
                                        </div>
                                        <div class="text-xs font-bold text-gray-500">
                                            {{ $wo->vehicle->merk }} {{ $wo->vehicle->model }}
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @if($wo->repair_type == 'Quick Repair')
                                            <span class="bg-yellow-50 text-yellow-700 text-[10px] font-black px-2.5 py-1 rounded-lg border border-yellow-200 uppercase tracking-widest inline-block mb-1">⚡ Quick</span>
                                        @else
                                            <span class="bg-gray-50 text-gray-600 text-[10px] font-black px-2.5 py-1 rounded-lg border border-gray-200 uppercase tracking-widest inline-block mb-1">🛠️ Reg</span>
                                        @endif
                                        <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">
                                            DL: <span class="{{ $isUrgent ? 'text-red-600' : 'text-gray-800' }}">{{ $deadline->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- POSISI UNIT --}}
                                <div class="mb-5 bg-gray-50 p-4 rounded-2xl border border-gray-100 ml-2">
                                    @php
                                        $stage = $wo->repair_stage ?? 'Menunggu';
                                        $badgeClass = 'bg-white text-gray-600 border-gray-200'; 
                                        $iconStage = '⏳';

                                        if(str_contains($stage, 'Body')) { $badgeClass = 'bg-white text-slate-700 border-slate-300'; $iconStage = '🔨'; }
                                        elseif(str_contains($stage, 'Prep')) { $badgeClass = 'bg-white text-orange-600 border-orange-300'; $iconStage = '🧽'; }
                                        elseif(str_contains($stage, 'Paint')) { $badgeClass = 'bg-white text-indigo-600 border-indigo-300'; $iconStage = '🔫'; }
                                        elseif(str_contains($stage, 'Poles')) { $badgeClass = 'bg-white text-teal-600 border-teal-300'; $iconStage = '✨'; }
                                        elseif(str_contains($stage, 'Washing')) { $badgeClass = 'bg-white text-blue-600 border-blue-300'; $iconStage = '🚿'; }
                                    @endphp
                                    <div class="flex justify-between items-end mb-3">
                                        <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase border shadow-sm {{ $badgeClass }} flex items-center gap-1.5">
                                            {{ $iconStage }} {{ $stage }}
                                        </span>
                                        <span class="text-sm font-black text-gray-900">{{ $wo->progress }}%</span>
                                    </div>
                                    
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden shadow-inner">
                                        <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 transition-all duration-1000 relative" style="width: {{ $wo->progress }}%">
                                            <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                                        </div>
                                    </div>
                                </div>

                                {{-- FOOTER: PIC & TOMBOL UPDATE --}}
                                <div class="flex justify-between items-center pl-2">
                                    <div class="flex items-center gap-2">
                                        @if($wo->mechanic)
                                            <div class="w-8 h-8 rounded-full bg-gray-900 flex items-center justify-center text-[10px] text-white font-black shadow-sm shrink-0">
                                                {{ substr($wo->mechanic->name, 0, 1) }}
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">PIC Utama</span>
                                                <span class="text-xs font-black text-gray-800">{{ Str::limit($wo->mechanic->name, 12) }}</span>
                                            </div>
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 shrink-0 border border-gray-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-[9px] font-bold text-red-500 uppercase tracking-widest">Belum Diplot</span>
                                                <span class="text-xs font-black text-gray-400 italic">Menunggu PIC</span>
                                            </div>
                                        @endif
                                    </div>
                                    <a href="{{ route('foreman.progress.edit', $wo->id) }}" class="px-4 py-2 bg-gray-900 hover:bg-blue-600 text-white rounded-xl text-xs font-bold transition-all shadow-md flex items-center gap-1">
                                        Update
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- ========================================================== --}}
            {{-- 4. TABEL RIWAYAT SELESAI (BAWAH) --}}
            {{-- ========================================================== --}}
            <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100 mx-4 sm:mx-0 mb-10">
                <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-black text-gray-800 text-lg flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        Unit Selesai (QC Passed)
                    </h3>
                </div>
                <div class="overflow-x-auto w-full pb-4">
                    <table class="w-full text-left min-w-[700px]">
                        <thead class="bg-white border-b border-gray-100">
                            <tr>
                                <th class="px-8 py-5 text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Waktu Selesai</th>
                                <th class="px-8 py-5 text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Kendaraan & Nopol</th>
                                <th class="px-8 py-5 text-center text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Status</th>
                                <th class="px-8 py-5 text-center text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white text-sm">
                            @forelse($finishedOrders as $wo)
                            <tr class="group hover:bg-emerald-50/30 transition-colors">
                                <td class="px-8 py-5 whitespace-nowrap">
                                    @php
                                        $washingAlloc = $wo->allocations->where('stage', 'Washing')->first();
                                        $jamSelesai = ($washingAlloc && $washingAlloc->end_time) 
                                                        ? date('H:i', strtotime($washingAlloc->end_time)) 
                                                        : $wo->updated_at->format('H:i');
                                    @endphp
                                    <div class="font-black text-gray-800">{{ $wo->updated_at->format('d M Y') }}</div>
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">{{ $jamSelesai }} WITA</div>
                                </td>
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <div class="font-bold text-gray-800 text-sm mb-1.5">{{ $wo->vehicle->merk }} {{ $wo->vehicle->model }}</div>
                                    <span class="inline-block bg-gray-900 text-white font-mono text-[11px] font-black px-2.5 py-0.5 rounded-md shadow-sm tracking-widest border-b-2 border-gray-600">
                                        {{ $wo->vehicle->nopol }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] font-black tracking-widest border bg-emerald-50 text-emerald-600 border-emerald-200 uppercase">
                                        Selesai
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center whitespace-nowrap">
                                    <form action="{{ route('foreman.reopen', $wo->id) }}" method="POST" onsubmit="return confirm('Yakin mau membatalkan status SELESAI?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-4 py-2 bg-white border border-amber-200 text-amber-600 hover:bg-amber-500 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm flex items-center gap-1 mx-auto">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                            Batalkan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-16 text-center">
                                    <p class="font-bold text-gray-400 italic">Belum ada unit yang diselesaikan.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- SCRIPT CHART JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = "'Nunito', 'Segoe UI', sans-serif";
        Chart.defaults.font.weight = 'bold';
        Chart.defaults.color = '#9CA3AF';

        const ctxStatus = document.getElementById('statusChart');
        if (ctxStatus) {
            new Chart(ctxStatus, {
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
        }

        const ctxRepair = document.getElementById('repairChart');
        if (ctxRepair) {
            new Chart(ctxRepair, {
                type: 'bar',
                data: {
                    labels: ['Regular', 'Quick Repair'],
                    datasets: [{
                        label: 'Jumlah Unit',
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
        }
    </script>
</x-app-layout>