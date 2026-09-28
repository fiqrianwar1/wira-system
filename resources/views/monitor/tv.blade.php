<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    {{-- Meta refresh dicopot, kita ganti pakai Smart Refresh di Javascript bawah --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WIRA SYSTEM - COMMAND CENTER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); 
        }
        .font-digital { font-family: 'Orbitron', sans-serif; }
        
        /* Desain Plat Nomor Realistis 3D */
        .plate-number {
            background: linear-gradient(to bottom, #111827 0%, #030712 100%);
            border: 2px solid #9ca3af;
            color: #f9fafb;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), inset 0 2px 4px rgba(255,255,255,0.1);
            position: relative;
        }
        .plate-number::before {
            content: '';
            position: absolute;
            top: 2px; left: 2px; right: 2px; bottom: 2px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }
        
        .glass-row {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: rgba(226, 232, 240, 0.5); border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #ef4444; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #dc2626; }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-row {
            animation: slideInLeft 0.5s ease-out forwards;
            opacity: 0;
        }
    </style>
</head>
<body class="text-slate-800 h-screen overflow-hidden flex flex-col p-6 relative">
    
    {{-- HEADER KEKINIAN --}}
    <div class="flex justify-between items-center mb-4 bg-white/95 p-6 rounded-[2rem] border border-white shadow-xl shadow-slate-200/50 flex-shrink-0 backdrop-blur-md">
        <div class="flex items-center gap-5">
            <div class="bg-gradient-to-br from-red-500 to-red-800 p-4 rounded-2xl shadow-lg shadow-red-500/40 relative overflow-hidden group">
                <div class="absolute inset-0 bg-white/20 w-full h-full animate-[shimmer_3s_infinite]"></div>
                <svg class="w-10 h-10 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <h1 class="text-4xl font-black tracking-tight uppercase text-slate-900 drop-shadow-sm">Body & Paint <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-red-500">Live Center</span></h1>
                <p class="text-slate-500 font-bold tracking-[0.15em] text-[13px] uppercase mt-1">PT. Wira Megah Profitamas Banjarmasin</p>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" onclick="return confirm('Yakin mau nutup TV Monitor ini bro?')" class="p-4 rounded-2xl bg-slate-50 text-slate-400 hover:bg-red-50 hover:text-red-600 hover:shadow-inner border border-slate-200 hover:border-red-200 transition-all duration-300" title="Keluar / Logout">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>

            <div class="text-right bg-slate-900 p-4 rounded-2xl border-2 border-slate-800 shadow-[inset_0_2px_4px_rgba(0,0,0,0.6)] relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-12 h-12 bg-white/5 rounded-full blur-xl"></div>
                <div class="text-5xl font-digital text-emerald-400 tracking-widest drop-shadow-[0_0_12px_rgba(52,211,153,0.4)] relative z-10" id="clock">00:00:00</div>
                <p class="text-slate-400 font-black uppercase tracking-[0.2em] text-[10px] mt-2 relative z-10">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>
    </div>

    {{-- FITUR BARU: SMART LIVE SEARCH --}}
    <div class="mb-4 z-10 relative flex-shrink-0">
        <div class="relative w-full md:w-1/3">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari Plat Nomor, Merk, atau Status..." class="w-full pl-12 pr-4 py-3.5 border-2 border-white rounded-2xl text-sm focus:ring-red-500 focus:border-red-500 bg-white/80 backdrop-blur-md shadow-lg shadow-slate-200/50 font-bold transition-all text-slate-800 outline-none placeholder-slate-400">
        </div>
    </div>

    {{-- KONTEN TABEL --}}
    <div class="flex-1 overflow-y-auto pr-2 pb-20 custom-scrollbar relative z-0">
        <table class="w-full text-left border-separate border-spacing-y-4">
            <thead>
                <tr class="text-slate-500 text-[11px] uppercase font-black tracking-widest bg-white/90 sticky top-0 z-20 backdrop-blur-md shadow-sm border-b border-slate-100">
                    <th class="px-5 py-4 rounded-l-2xl w-[15%]">No. Kendaraan</th>
                    <th class="px-5 py-4 w-[12%]">Tgl Masuk</th>
                    <th class="px-5 py-4 w-[18%]">Unit Detail</th>
                    <th class="px-5 py-4 w-[18%]">Tahapan / Status</th>
                    <th class="px-5 py-4 w-[15%]">Teknisi (PIC)</th>
                    <th class="px-5 py-4 w-[15%]">Progress Timeline</th>
                    <th class="px-5 py-4 rounded-r-2xl text-center w-[7%]">Estimasi</th>
                </tr>
            </thead>
            {{-- Tambahin ID monitorTableBody di sini --}}
            <tbody id="monitorTableBody">
                @foreach($workOrders as $index => $wo)
                @php
                    // LOGIKA 1: Kalau status SPK udah di-CLOSE/SELESAI sama SA (Mobil udah diambil)
                    if(strtolower($wo->status) == 'selesai') {
                        $pct = 100;
                        $stageText = 'SELESAI (DIAMBIL)';
                        // Pake warna Biru Gelap/Indigo buat ngebedain sama Unit Ready
                        $tc = 'text-indigo-600'; $bg = 'bg-indigo-500'; 
                        $grad = 'from-indigo-600 to-indigo-500';
                    } else {
                        // LOGIKA 2: Mobil masih di bengkel (Proses Repair / Washing)
                        $pct = $wo->progress;
                        $stageText = strtoupper($wo->repair_stage ?? 'Menunggu');
                        
                        // Kalau tahapannya Washing (atau progress mentok 100 tapi belum di-close SA)
                        if($stageText == 'WASHING' || $pct == 100) { 
                            $stageText = 'UNIT READY';
                            $tc = 'text-emerald-600'; $bg = 'bg-emerald-500'; $grad = 'from-emerald-500 to-emerald-400'; 
                        }
                        elseif($pct >= 75) { $tc = 'text-blue-600'; $bg = 'bg-blue-500'; $grad = 'from-blue-500 to-blue-400'; }
                        elseif($pct >= 50) { $tc = 'text-amber-600'; $bg = 'bg-amber-400'; $grad = 'from-amber-400 to-yellow-400'; }
                        elseif($pct >= 25) { $tc = 'text-orange-600'; $bg = 'bg-orange-500'; $grad = 'from-orange-500 to-orange-400'; }
                        else { $tc = 'text-red-600'; $bg = 'bg-red-500'; $grad = 'from-red-600 to-red-500'; }
                    }
                @endphp
                
                <tr class="glass-row transition-all duration-300 shadow-sm hover:shadow-xl hover:-translate-y-1 relative overflow-hidden group rounded-2xl animate-row" style="animation-delay: {{ $index * 0.05 }}s">
                    
                    {{-- PLAT NOMOR --}}
                    <td class="px-5 py-4 pl-6 relative rounded-l-2xl">
                        <div class="absolute left-0 top-0 bottom-0 w-2 {{ $bg }} shadow-[0_0_10px_rgba(0,0,0,0.1)]"></div>
                        <div class="inline-block plate-number px-3 py-1.5 rounded-lg font-bold text-xl tracking-[0.1em] font-mono text-center min-w-[130px] search-target">
                            {{ $wo->vehicle->nopol }}
                        </div>
                    </td>

                    {{-- TGL MASUK --}}
                    <td class="px-5 py-4">
                        <div class="text-sm font-black text-slate-700 uppercase tracking-widest">{{ \Carbon\Carbon::parse($wo->tanggal_masuk)->translatedFormat('d M Y') }}</div>
                    </td>

                    {{-- MERK & MODEL --}}
                    <td class="px-5 py-4">
                        <div class="text-xl font-black uppercase text-slate-900 leading-tight search-target">{{ $wo->vehicle->merk }}</div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest search-target">{{ $wo->vehicle->model }}</div>
                    </td>

                    {{-- STATUS KERJA --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <span class="relative flex h-3 w-3">
                                @if(strtolower($wo->status) != 'selesai' && $stageText != 'UNIT READY')
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $bg }} opacity-75"></span>
                                @endif
                                <span class="relative inline-flex rounded-full h-3 w-3 {{ $bg }} shadow-md"></span>
                            </span>
                            <span class="{{ $tc }} font-black text-lg uppercase tracking-wider drop-shadow-sm search-target">
                                {{ $stageText }}
                            </span>
                        </div>
                    </td>

                    {{-- NAMA MEKANIK --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center font-black text-slate-500 shadow-inner text-sm">
                                {{ substr($wo->mechanic->name ?? '?', 0, 1) }}
                            </div>
                            <div class="font-bold text-slate-700 uppercase text-sm tracking-wide search-target">
                                {{ $wo->mechanic->name ?? 'Belum Diplot' }}
                            </div>
                        </div>
                    </td>

                    {{-- PROGRESS BAR --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-4">
                            <div class="flex-1 h-3.5 bg-slate-200/80 rounded-full overflow-hidden shadow-inner">
                                <div class="h-full bg-gradient-to-r {{ $grad }} shadow-md transition-all duration-1000 ease-out relative" style="width: {{ $pct }}%">
                                    @if(strtolower($wo->status) != 'selesai' && $stageText != 'UNIT READY')
                                        <div class="absolute inset-0 bg-white/40 w-full h-full animate-[shimmer_2s_infinite]"></div>
                                    @endif
                                </div>
                            </div>
                            <span class="font-digital text-2xl font-black {{ $tc }} w-14 text-right drop-shadow-sm">
                                {{ $pct }}%
                            </span>
                        </div>
                    </td>

                    {{-- TARGET SELESAI --}}
                    <td class="px-5 py-4 text-center rounded-r-2xl">
                        <div class="inline-flex flex-col items-center justify-center bg-slate-50 px-3 py-2 rounded-xl border border-slate-200 shadow-sm w-20 group-hover:bg-slate-100 transition-colors">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Target</span>
                            <span class="font-black text-slate-800 text-lg uppercase tracking-tight leading-none">
                                {{ \Carbon\Carbon::parse($wo->estimasi_selesai)->translatedFormat('d M') }}
                            </span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- RUNNING TEXT FIXED DI BAWAH --}}
    <div class="absolute bottom-6 left-6 right-6 bg-white/95 border border-white rounded-xl overflow-hidden flex items-center shadow-2xl shadow-slate-300/60 z-50 backdrop-blur-md">
        <div class="bg-gradient-to-r from-red-600 to-red-700 text-white font-black px-6 py-3 text-sm z-10 whitespace-nowrap uppercase tracking-[0.2em] shadow-md relative">
            INFO INTERNAL SA
            <div class="absolute right-0 top-0 bottom-0 w-4 bg-gradient-to-l from-transparent to-red-700/50"></div>
        </div>
        <marquee class="text-slate-600 text-[13px] font-bold tracking-widest uppercase ml-4" scrollamount="5">
            Peringatan: Utamakan Kualitas dan QC Sebelum Serah Terima Unit ke Pelanggan! &nbsp; | &nbsp; Selalu Cek Ketersediaan Part di Gudang Sebelum Menjanjikan Estimasi Waktu. &nbsp; | &nbsp; PT. Wira Megah Profitamas - Tumbuh Bersama.
        </marquee>
    </div>

    {{-- SCRIPTS --}}
    <script>
        // 1. UPDATE JAM DIGITAL
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('clock').innerText = `${hours}:${minutes}:${seconds}`;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // 2. LIVE SEARCH FILTER
        function filterTable() {
            const input = document.getElementById("searchInput");
            const filter = input.value.toUpperCase();
            const tableBody = document.getElementById("monitorTableBody");
            const rows = tableBody.getElementsByTagName("tr");

            for (let i = 0; i < rows.length; i++) {
                // Ambil semua teks di dalam row yang punya class 'search-target'
                // Ini meliputi Plat Nomor, Merk, Model, Status, dan Nama Mekanik
                let match = false;
                let targets = rows[i].getElementsByClassName("search-target");
                
                for(let j = 0; j < targets.length; j++) {
                    if(targets[j].innerText.toUpperCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }

                if (match) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }

        // 3. SMART AUTO REFRESH (Skripsi Level Feature!)
        // Refresh tiap 60 detik HANYA JIKA user TIDAK sedang ngetik/nyari data
        setInterval(() => {
            const searchInput = document.getElementById("searchInput");
            const isTyping = searchInput.value !== '' || document.activeElement === searchInput;
            
            if(!isTyping) {
                window.location.reload();
            } else {
                console.log("Auto-refresh dipending karena user sedang melakukan pencarian.");
            }
        }, 60000);
    </script>
</body>
</html>