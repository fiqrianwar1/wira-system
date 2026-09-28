<x-app-layout>
    <x-slot name="header">
        <div class="py-1">
            <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                {{ __('🎨 Material & Inventori Control') }}
            </h2>
            <p class="text-sm text-gray-500 font-bold mt-1">
                Pantau Stok Cat, Thinner, Dempul & Distribusi / <span class="text-purple-600 uppercase tracking-wider">Wira Toyota</span>
            </p>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-[95rem] mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- ALERT WARNING JIKA ADA STOK MAU HABIS (Sleek Style) --}}
            @if($stokMenipis->count() > 0)
                <div class="bg-red-50 border-l-4 border-red-500 p-5 rounded-2xl shadow-sm flex items-center gap-4 mx-4 sm:mx-0 animate-pulse">
                    <div class="bg-white p-2.5 rounded-full text-red-500 shadow-sm shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-red-800 font-black uppercase tracking-widest text-xs mb-0.5">Peringatan: Stok Material Menipis!</h4>
                        <p class="text-[11px] text-red-600 font-bold">Terdapat <span class="font-black text-red-900">{{ $stokMenipis->count() }} item</span> bahan yang stoknya kritis (di bawah 5). Segera lakukan pengorderan.</p>
                    </div>
                </div>
            @endif

            {{-- 1. KARTU STATISTIK (PREMIUM GRADIENT) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4 sm:px-0">
                
                {{-- KARTU 1: TOTAL MASTER BAHAN --}}
                <div class="bg-gradient-to-br from-purple-600 to-indigo-800 rounded-[2rem] p-8 text-white shadow-xl shadow-purple-500/20 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 opacity-10 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-36 h-36" fill="currentColor" viewBox="0 0 24 24"><path d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <div class="flex justify-between items-start mb-4 relative z-10">
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2-2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <span class="text-[10px] font-black bg-white/20 px-3 py-1.5 rounded-lg backdrop-blur-sm uppercase tracking-widest">Master Data</span>
                    </div>
                    <div class="relative z-10 group-hover:-translate-y-1 transition-transform">
                        <div class="text-4xl font-black">{{ $totalBahan ?? 0 }} <span class="text-sm font-bold text-purple-200 tracking-widest uppercase">Jenis</span></div>
                        <div class="text-[10px] font-bold uppercase tracking-widest text-purple-200 mt-1">Total Item Inventori</div>
                    </div>
                </div>

                {{-- KARTU 2: STOK KRITIS --}}
                <div class="bg-gradient-to-br from-rose-500 to-red-600 rounded-[2rem] p-8 text-white shadow-xl shadow-red-500/20 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 opacity-10 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-36 h-36" fill="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="flex justify-between items-start mb-4 relative z-10">
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <span class="text-[10px] font-black bg-white/20 px-3 py-1.5 rounded-lg backdrop-blur-sm uppercase tracking-widest">Warning</span>
                    </div>
                    <div class="relative z-10 group-hover:-translate-y-1 transition-transform">
                        <div class="text-4xl font-black">{{ $stokMenipis->count() ?? 0 }} <span class="text-sm font-bold text-rose-200 tracking-widest uppercase">Item</span></div>
                        <div class="text-[10px] font-bold uppercase tracking-widest text-rose-100 mt-1">Bahan Stok Kritis (≤ 5)</div>
                    </div>
                </div>

               {{-- KARTU 3: PEMAKAIAN BULAN INI (Ubah biar ga reset harian) --}}
                <div class="bg-gradient-to-br from-emerald-400 to-teal-600 rounded-[2rem] p-8 text-white shadow-xl shadow-teal-500/20 relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 opacity-10 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-36 h-36" fill="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <div class="flex justify-between items-start mb-4 relative z-10">
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-[10px] font-black bg-white/20 px-3 py-1.5 rounded-lg backdrop-blur-sm uppercase tracking-widest">Bulan Ini</span>
                    </div>
                    <div class="relative z-10 group-hover:-translate-y-1 transition-transform">
                        <div class="text-4xl font-black">{{ $distribusiBulanIni ?? 0 }} <span class="text-sm font-bold text-teal-100 tracking-widest uppercase">Kali</span></div>
                        <div class="text-[10px] font-bold uppercase tracking-widest text-teal-100 mt-1">Distribusi Material (30 Hari)</div>
                    </div>
                </div>
            </div>

            {{-- ========================================================== --}}
            {{-- FITUR BARU: ALERT NOTIFIKASI (SPK BELUM DIKASIH BAHAN) --}}
            {{-- ========================================================== --}}
            @if(isset($pendingSpks) && $pendingSpks->count() > 0)
                <div class="bg-purple-50 border-l-4 border-purple-500 p-5 rounded-[1.5rem] shadow-sm mx-4 sm:mx-0">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="relative flex h-4 w-4">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-4 w-4 bg-purple-500"></span>
                        </span>
                        <h3 class="text-sm font-black text-purple-800 uppercase tracking-widest">To-Do List: Distribusi Material SPK (Urgent!)</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($pendingSpks as $spk)
                            <div class="bg-white p-4 rounded-xl shadow-sm border border-purple-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                                <div class="mb-4">
                                    <h4 class="font-black text-gray-900">{{ $spk->vehicle->nopol ?? 'NOPOL' }}</h4>
                                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-0.5">{{ $spk->nomor_spk }}</p>
                                    <p class="text-xs text-gray-600 mt-3 bg-gray-50 p-2.5 rounded-lg border border-gray-100">Unit ini <span class="font-black text-purple-600">belum</span> menerima distribusi bahan material dari gudang.</p>
                                </div>
                                <a href="{{ route('bahan.spk.input', $spk->id) }}" class="text-center bg-purple-600 hover:bg-purple-700 text-white text-[10px] font-black px-4 py-2.5 rounded-lg uppercase tracking-widest transition-all">
                                    Proses Input Bahan →
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- 2. GRAFIK (PEMBELIAN & SPK) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4 sm:px-0">
                
                {{-- Line Chart: Tren Pengadaan --}}
                <div class="md:col-span-2 bg-white shadow-xl shadow-gray-200/50 rounded-[2.5rem] border border-gray-100 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-black text-gray-800 text-lg tracking-tight flex items-center gap-3">
                            <div class="bg-purple-50 text-purple-600 p-2 rounded-xl border border-purple-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                            Tren Pengadaan Material (30 Hari Terakhir)
                        </h3>
                    </div>
                    <div class="h-64 relative w-full"><canvas id="trendChart"></canvas></div>
                </div>

                {{-- Doughnut Chart: Progress --}}
                <div class="bg-white shadow-xl shadow-gray-200/50 rounded-[2.5rem] border border-gray-100 p-8 flex flex-col">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-black text-gray-800 text-lg tracking-tight flex items-center gap-3">
                            <div class="bg-emerald-50 text-emerald-600 p-2 rounded-xl border border-emerald-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg></div>
                            Status Distribusi SPK
                        </h3>
                    </div>
                    <div class="h-48 relative w-full flex-1 flex justify-center items-center"><canvas id="spkChart"></canvas></div>
                    <div class="mt-6 flex justify-between items-center bg-gray-50 rounded-2xl p-4 border border-gray-100">
                        <span class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Total SPK Aktif</span>
                        <span class="text-xl text-gray-900 font-black">{{ $totalActiveSpk ?? 0 }} Unit</span>
                    </div>
                </div>
            </div>
            
            {{-- 3. MENU PINTASAN --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-4 sm:px-0">
                <a href="{{ route('bahan.spk.index') }}" class="group block p-6 bg-white shadow-sm hover:shadow-xl hover:shadow-purple-200/50 rounded-[2rem] border border-gray-100 hover:border-purple-200 transition-all transform hover:-translate-y-1">
                    <div class="flex items-center gap-5">
                        <div class="bg-purple-50 p-4 rounded-2xl text-purple-600 shadow-sm border border-purple-100 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-black text-lg text-gray-900 tracking-tight group-hover:text-purple-700 transition-colors">Distribusi & Pemakaian</h4>
                            <p class="text-xs text-gray-500 font-bold mt-0.5">Input pemakaian bahan per SPK / Teknisi</p>
                        </div>
                        <div class="ml-auto text-gray-300 group-hover:text-purple-500 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('bahan.stok.index') }}" class="group block p-6 bg-white shadow-sm hover:shadow-xl hover:shadow-indigo-200/50 rounded-[2rem] border border-gray-100 hover:border-indigo-200 transition-all transform hover:-translate-y-1">
                    <div class="flex items-center gap-5">
                        <div class="bg-indigo-50 p-4 rounded-2xl text-indigo-600 shadow-sm border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-black text-lg text-gray-900 tracking-tight group-hover:text-indigo-700 transition-colors">Kelola Master Inventori</h4>
                            <p class="text-xs text-gray-500 font-bold mt-0.5">Tambah, edit, dan hapus data stok bahan</p>
                        </div>
                        <div class="ml-auto text-gray-300 group-hover:text-indigo-500 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    {{-- SCRIPT BUAT JALANIN GRAFIKNYA --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // FIX BLURRY TEXT: Warna ditebelin dan digelapin
        Chart.defaults.font.family = "'Nunito', 'Segoe UI', sans-serif";
        Chart.defaults.font.weight = '900'; // Ekstra Bold
        Chart.defaults.color = '#6B7280'; // Gray-500 (Lebih gelap & jelas)

        const ctxTrend = document.getElementById('trendChart');
        if (ctxTrend) {
            new Chart(ctxTrend.getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartDates ?? []) !!},
                    datasets: [{
                        label: 'Frekuensi Barang Masuk',
                        data: {!! json_encode($chartPembelian ?? []) !!},
                        borderColor: '#9333EA', // Purple-600
                        backgroundColor: 'rgba(147, 51, 234, 0.1)', 
                        borderWidth: 3, 
                        pointRadius: 4, 
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#9333EA',
                        fill: true, 
                        tension: 0.4
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    plugins: { legend: { display: false } }, 
                    scales: { 
                        y: { 
                            beginAtZero: true, 
                            border: { dash: [4, 4], display: false }, 
                            grid: { color: '#E5E7EB' }, // Garis bantu ditebelin dikit
                            ticks: { stepSize: 1, font: { size: 11 } } 
                        }, 
                        x: { 
                            grid: { display: false },
                            ticks: { 
                                font: { size: 10 },
                                maxRotation: 45, // Teks dimiringin 45 derajat biar 30 hari kaga numpuk
                                minRotation: 45
                            }
                        } 
                    } 
                }
            });
        }

        const ctxSpk = document.getElementById('spkChart');
        if (ctxSpk) {
            new Chart(ctxSpk, {
                type: 'doughnut',
                data: {
                    labels: ['Belum Distribusi', 'Sudah Distribusi'],
                    datasets: [{
                        data: [{{ $spkWithoutBahan ?? 0 }}, {{ $spkWithBahan ?? 0 }}],
                        backgroundColor: ['#F43F5E', '#10B981'], // Rose & Emerald
                        borderWidth: 0, 
                        hoverOffset: 8
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    cutout: '75%', 
                    plugins: { 
                        legend: { 
                            position: 'bottom', 
                            labels: { 
                                padding: 20, 
                                usePointStyle: true,
                                font: { size: 12, weight: 'bold' } // Legend pie chart ditebelin juga
                            } 
                        } 
                    } 
                }
            });
        }
    </script>
</x-app-layout>