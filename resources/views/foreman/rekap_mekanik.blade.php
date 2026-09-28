<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-black text-2xl text-gray-800 leading-tight">
                {{ __('📊 Rekap Kinerja Teknisi') }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">Laporan Bulanan / <span class="text-red-600 font-bold">Produktivitas Tim</span></p>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- MASTER CARD: GABUNGAN TOOLBAR & TABEL YANG RAPAT --}}
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
                
                {{-- EFEK AMBIENT BLUR BIRU (DARI ABSENSI) --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 -mr-20 -mt-20 pointer-events-none"></div>

                {{-- TOOLBAR (Header Card) --}}
                <div class="p-6 lg:p-8 border-b border-gray-100 bg-white/50 backdrop-blur-sm flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 relative z-10 no-print">
                    
                    {{-- KIRI: JUDUL / KETERANGAN --}}
                    <div class="flex items-center gap-4 w-full xl:w-auto">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center shadow-inner flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-black text-xl text-gray-900 leading-none">Filter Laporan</h3>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Periode Pekerjaan Selesai</p>
                        </div>
                    </div>

                    {{-- KANAN: INPUT, SEARCH, DAN TOMBOL --}}
                    <div class="flex flex-col sm:flex-row gap-3 w-full xl:w-auto items-center">
                        
                        {{-- Form Filter Dropdown --}}
                        <form method="GET" action="{{ route('foreman.rekap') }}" id="filterForm" class="flex gap-2 w-full sm:w-auto">
                            <div class="relative w-full sm:w-36">
                                <select name="bulan" onchange="document.getElementById('filterForm').submit()" class="w-full pl-4 pr-10 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-bold text-gray-800 focus:bg-white focus:ring-2 focus:ring-red-500 focus:outline-none appearance-none cursor-pointer shadow-sm transition-all relative z-20">
                                    @foreach(range(1, 12) as $m)
                                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 z-30">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            <div class="relative w-full sm:w-28">
                                <select name="tahun" onchange="document.getElementById('filterForm').submit()" class="w-full pl-4 pr-10 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-bold text-gray-800 focus:bg-white focus:ring-2 focus:ring-red-500 focus:outline-none appearance-none cursor-pointer shadow-sm transition-all relative z-20">
                                    @foreach(range(date('Y')-2, date('Y')) as $y)
                                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 z-30">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </form>

                        {{-- Search Box --}}
                        <div class="relative w-full sm:w-60 group">
                            <input type="text" id="cariMekanik" placeholder="Cari Mekanik..." class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 bg-gray-50 rounded-2xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white transition-all font-bold text-sm shadow-sm relative z-20">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-30">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </div>

                        {{-- Tombol Cetak --}}
                        <div class="flex gap-2 w-full sm:w-auto relative z-20">
                            <a href="{{ route('foreman.rekap.print', ['bulan' => $bulan, 'tahun' => $tahun]) }}" target="_blank" class="flex-1 sm:flex-none px-6 py-3.5 bg-gray-900 text-white font-bold rounded-2xl shadow-lg shadow-gray-900/30 hover:bg-red-600 transition-all flex items-center justify-center gap-2 text-sm transform hover:-translate-y-0.5 whitespace-nowrap">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Laporan
                            </a>
                        </div>
                    </div>
                </div>

                {{-- TABEL UTAMA (Langsung nempel, tanpa <div class="p-6"> lagi) --}}
                <div class="overflow-x-auto w-full pb-4 relative z-10">
                    <table class="w-full text-left table-auto min-w-[700px]" id="tabelRekapMekanik">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Teknisi / PIC</th>
                                <th class="px-4 py-4 text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Spesialisasi</th>
                                <th class="px-4 py-4 text-center text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Total Tahapan Selesai</th>
                                <th class="px-6 py-4 text-center text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($mechanics as $mekanik)
                                @php $totalSpk = $mekanik->allocations->count(); @endphp
                                
                                {{-- BARIS HOVER JADI BIRU ESTETIK --}}
                                <tr class="hover:bg-blue-50/20 transition-colors group search-item-rekap" x-data="{ openDetail: false }">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            
                                            {{-- AVATAR DIBIKIN BIRU BULET PERSIS KEK DATA MEKANIK --}}
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-black text-sm shadow-md border-2 border-white shrink-0 group-hover:scale-110 transition-transform">
                                                {{ substr($mekanik->name, 0, 1) }}
                                            </div>
                                            
                                            <div>
                                                {{-- NAMA TEKNISI DIBIKIN CAPITALIZE BIAR HURUF AWAL DOANG YANG BESAR --}}
                                                <div class="font-black text-gray-800 text-sm capitalize group-hover:text-blue-600 transition-colors tracking-tight">{{ $mekanik->name }}</div>
                                                <div class="text-[10px] text-gray-400 font-bold uppercase mt-0.5">{{ $mekanik->position }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest">{{ $mekanik->specialist }}</span>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <div class="inline-flex flex-col">
                                            <span class="text-2xl font-black {{ $totalSpk > 0 ? 'text-emerald-500' : 'text-gray-300' }}">{{ $totalSpk }}</span>
                                            <span class="text-[8px] font-bold text-gray-400 uppercase tracking-tighter">Tahapan</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        {{-- TOMBOL ACTION HOVER JADI BIRU JUGA --}}
                                        <button @click="openDetail = true" class="p-2.5 bg-white border border-gray-200 rounded-xl text-gray-500 hover:text-blue-600 hover:border-blue-300 hover:bg-blue-50 transition-all shadow-sm" title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>

                                        {{-- MODAL DETAIL --}}
                                        <div x-show="openDetail" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" x-cloak>
                                            <div class="bg-white rounded-[2.5rem] w-full max-w-2xl shadow-2xl overflow-hidden transform transition-all text-left" @click.away="openDetail = false">
                                                <div class="bg-gray-900 p-8 text-white flex justify-between items-center">
                                                    <div>
                                                        <p class="text-[10px] font-black text-red-500 uppercase tracking-widest">Detail Kinerja Real-Time</p>
                                                        {{-- NAMA DI MODAL JUGA CAPITALIZE --}}
                                                        <h3 class="text-xl font-black capitalize tracking-tight">{{ $mekanik->name }}</h3>
                                                    </div>
                                                    <button @click="openDetail = false" class="p-2 hover:bg-white/10 rounded-full transition-colors">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </div>
                                                <div class="p-8 max-h-[60vh] overflow-y-auto">
                                                    @if($totalSpk > 0)
                                                        <div class="space-y-4">
                                                            @foreach($mekanik->allocations as $alloc)
                                                                @php
                                                                    $durationText = '-';
                                                                    $isEfisien = true;
                                                                    $std = 4; // Default

                                                                    if(str_contains($alloc->stage, 'Body')) $std = 5;
                                                                    elseif(str_contains($alloc->stage, 'Prep')) $std = 3;
                                                                    elseif(str_contains($alloc->stage, 'Paint')) $std = 4;
                                                                    elseif(str_contains($alloc->stage, 'Poles')) $std = 2;
                                                                    elseif(str_contains($alloc->stage, 'Washing')) $std = 1;

                                                                    if($alloc->start_time && $alloc->end_time) {
                                                                        $start = \Carbon\Carbon::parse($alloc->start_time);
                                                                        $end = \Carbon\Carbon::parse($alloc->end_time);
                                                                        
                                                                        $diffTotalMins = $start->diffInMinutes($end);
                                                                        $diffHrs = floor($diffTotalMins / 60);
                                                                        $diffMins = $diffTotalMins % 60;
                                                                        $durationText = "{$diffHrs}j {$diffMins}m";
                                                                        
                                                                        $diffDecimal = $diffTotalMins / 60;
                                                                        if($diffDecimal > $std) $isEfisien = false;
                                                                    }
                                                                @endphp

                                                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                                                    <div class="flex flex-col text-left">
                                                                        <span class="font-mono font-black text-sm text-gray-800 tracking-wider">{{ $alloc->workOrder->vehicle->nopol ?? '-' }}</span>
                                                                        <span class="text-[10px] font-bold text-gray-400 uppercase">{{ $alloc->workOrder->vehicle->merk ?? '-' }} | Selesai: {{ \Carbon\Carbon::parse($alloc->end_time)->format('d M Y') }}</span>
                                                                    </div>
                                                                    
                                                                    <div class="flex items-center gap-3">
                                                                        <div class="text-right border-r border-gray-200 pr-3">
                                                                            <div class="font-black text-xs text-gray-800">{{ $durationText }}</div>
                                                                            <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Std: {{ $std }}j</div>
                                                                        </div>
                                                                        
                                                                        <div class="flex flex-col gap-1 items-end">
                                                                            @if($durationText == '-')
                                                                                <span class="bg-gray-100 text-gray-500 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest">Tdk Ada Data</span>
                                                                            @elseif($isEfisien)
                                                                                <span class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest">🔥 Efisien</span>
                                                                            @else
                                                                                <span class="bg-red-50 border border-red-200 text-red-600 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest">⚠️ Overtime</span>
                                                                            @endif

                                                                            <span class="bg-gray-800 text-white px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest text-center w-full">
                                                                                {{ $alloc->stage }}
                                                                           </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p class="text-gray-400 italic text-sm py-4">Belum ada tahapan kerja yang diselesaikan bulan ini.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="emptyRowRekap">
                                    <td colspan="4" class="px-8 py-20">
                                        <div class="w-full mx-auto flex flex-col items-center justify-center text-center opacity-50">
                                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <p class="font-black text-gray-500 text-sm uppercase tracking-widest">Data mekanik tidak ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                            {{-- MESSAGE KALO HASIL CARI KOSONG --}}
                            <tr id="noResultsRekap" style="display: none;">
                                <td colspan="4" class="px-8 py-16">
                                    <div class="w-full mx-auto flex flex-col items-center justify-center text-center opacity-50">
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
            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print, header, .sidebar-container { display: none !important; }
            .bg-gray-50 { background-color: white !important; }
            .shadow-xl, .shadow-sm { shadow: none !important; border: 1px solid #eee !important; }
            .rounded-[2.5rem] { border-radius: 0 !important; }
        }
    </style>

    <script>
        document.getElementById('cariMekanik')?.addEventListener('keyup', function() {
            const val = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tabelRekapMekanik tbody tr.search-item-rekap');
            let visible = false;
            
            rows.forEach(row => {
                // SCRIPT NYA JUGA UDAH GW SESUAIIN NYARI CLASS .capitalize BUKAN .uppercase LAGI
                const namaMekanik = row.querySelector('.font-black.text-gray-800.text-sm.capitalize')?.innerText.toLowerCase() || '';
                const spesialis = row.querySelector('.bg-gray-100.text-gray-600')?.innerText.toLowerCase() || '';

                if(namaMekanik.includes(val) || spesialis.includes(val)) { 
                    row.style.display = ''; 
                    visible = true; 
                } else { 
                    row.style.display = 'none'; 
                }
            });

            const noResultsDiv = document.getElementById('noResultsRekap');
            const emptyRow = document.getElementById('emptyRowRekap');

            if (noResultsDiv) {
                if (!visible && (!emptyRow || emptyRow.style.display === 'none')) {
                    noResultsDiv.style.display = 'table-row';
                } else {
                    noResultsDiv.style.display = 'none';
                }
            }
        });
    </script>
</x-app-layout>