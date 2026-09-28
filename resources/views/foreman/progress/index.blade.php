<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-black text-2xl text-gray-900 leading-tight">
                {{ __('🚀 Progres Produksi') }}
            </h2>
            <p class="text-sm text-gray-600 mt-1">Operasional / <span class="text-red-600 font-bold uppercase tracking-wider">Monitoring & Alokasi</span></p>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ALERT SUKSES --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 bg-green-500 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center gap-3 transform transition-all hover:scale-[1.01]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden relative">
                
                {{-- BACKGROUND ACCENT --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-red-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 -mr-20 -mt-20 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 -ml-20 -mb-20 pointer-events-none"></div>

                {{-- HEADER & STATS --}}
                <div class="p-8 border-b border-gray-100 relative z-10">
                    <div class="flex flex-col xl:flex-row justify-between items-center gap-8">
                        
                        {{-- STATISTIK MINI --}}
                        <div class="flex gap-4 w-full xl:w-auto overflow-x-auto pb-2 xl:pb-0">
                            <div class="flex items-center gap-3 bg-gray-50 px-5 py-3 rounded-2xl border border-gray-200">
                                <div class="p-2 bg-white rounded-xl shadow-sm text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Total Unit</p>
                                    <p class="text-lg font-black text-gray-800 leading-none">{{ count($workOrders) }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 bg-blue-50 px-5 py-3 rounded-2xl border border-blue-100">
                                <div class="p-2 bg-white rounded-xl shadow-sm text-blue-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-blue-400 uppercase tracking-wider">Proses</p>
                                    <p class="text-lg font-black text-blue-800 leading-none">{{ $workOrders->where('status', 'proses')->count() }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 bg-yellow-50 px-5 py-3 rounded-2xl border border-yellow-100">
                                <div class="p-2 bg-white rounded-xl shadow-sm text-yellow-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-yellow-400 uppercase tracking-wider">Antrian</p>
                                    <p class="text-lg font-black text-yellow-800 leading-none">{{ $workOrders->where('status', 'pending')->count() }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- SEARCH BAR (WARNA MERAH & TINGGI 50px) --}}
                        <div class="relative w-full xl:w-72 group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" id="searchInput" class="block w-full pl-12 pr-4 h-[50px] border border-gray-200 bg-gray-50 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white transition-all font-bold text-sm shadow-sm" placeholder="Cari Nopol / Merk...">
                        </div>
                    </div>
                </div>

                {{-- TABLE MONITORING --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left min-w-[900px]" id="tableUnit">
                        <thead class="bg-white border-b border-gray-100 text-gray-400 font-black text-[10px] uppercase tracking-wider">
                            <tr>
                                <th class="px-8 py-6">Identitas Unit</th>
                                <th class="px-8 py-6">Penanggung Jawab (PIC)</th>
                                <th class="px-8 py-6 w-1/4">Status & Progres</th>
                                <th class="px-8 py-6">Deadline</th>
                                <th class="px-8 py-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($workOrders as $wo)
                            <tr class="hover:bg-blue-50/70 transition-colors duration-200 group search-item">
                                
                                {{-- KOLOM 1: IDENTITAS UNIT --}}
                                <td class="px-8 py-5 align-top">
                                    <div class="flex flex-col items-start gap-2">
                                        <div class="w-fit px-3 py-1.5 bg-black rounded-lg border-2 border-white shadow-md ring-1 ring-gray-200 flex items-center justify-center group-hover:ring-blue-300 transition-all">
                                            <span class="font-mono font-black text-white text-sm tracking-[0.2em] uppercase whitespace-nowrap">
                                                {{ $wo->vehicle->nopol }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-black text-gray-800 text-sm mt-1 group-hover:text-blue-700 transition-colors">{{ $wo->vehicle->merk }}</div>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-[10px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded font-bold uppercase group-hover:bg-blue-100 group-hover:text-blue-600 transition-colors">{{ $wo->vehicle->model ?? '-' }}</span>
                                                <span class="text-[10px] bg-red-50 text-red-500 px-1.5 py-0.5 rounded font-bold uppercase tracking-widest">{{ $wo->repair_type }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- KOLOM 2: PIC MEKANIK --}}
                                <td class="px-8 py-5 align-middle">
                                    @if($wo->mechanic)
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-black text-sm shadow-md border-2 border-white group-hover:scale-105 transition-transform">
                                                {{ substr($wo->mechanic->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-gray-800 group-hover:text-blue-800 transition-colors">{{ $wo->mechanic->name }}</div>
                                                <div class="text-[10px] text-blue-600 font-bold uppercase bg-blue-50 px-1.5 rounded inline-block">
                                                    {{ $wo->mechanic->specialist }}
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2 text-gray-400 opacity-70">
                                            <div class="w-8 h-8 rounded-full bg-gray-200 border-2 border-dashed border-gray-300 flex items-center justify-center group-hover:border-blue-300 group-hover:bg-blue-100 transition-colors">
                                                <svg class="w-4 h-4 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            </div>
                                            <span class="text-xs font-bold italic group-hover:text-blue-500 transition-colors tracking-tight">Belum diplot</span>
                                        </div>
                                    @endif
                                </td>

                                {{-- KOLOM 3: STATUS & PROGRES --}}
                                <td class="px-8 py-5 align-middle">
                                    <div class="w-full">
                                        <div class="flex justify-between items-end mb-1">
                                            <span class="text-xs font-black text-gray-700 uppercase group-hover:text-blue-700 transition-colors tracking-wide">{{ $wo->repair_stage ?? 'Menunggu' }}</span>
                                            <span class="text-xs font-black {{ $wo->progress == 100 ? 'text-green-600' : 'text-blue-600' }}">
                                                {{ $wo->progress }}%
                                            </span>
                                        </div>
                                        
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden shadow-inner">
                                            <div class="h-full rounded-full transition-all duration-700 ease-out relative
                                                {{ $wo->progress == 100 ? 'bg-gradient-to-r from-green-400 to-green-600' : 'bg-gradient-to-r from-blue-400 to-indigo-600' }}" 
                                                style="width: {{ $wo->progress }}%">
                                                @if($wo->status == 'proses')
                                                    <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mt-2 flex justify-between items-center">
                                            <div>
                                                @if($wo->status == 'pending')
                                                    <span class="inline-flex items-center gap-1 text-[10px] font-black text-yellow-600 bg-yellow-50 px-2 py-0.5 rounded border border-yellow-100 uppercase">
                                                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span> Antrian
                                                    </span>
                                                @elseif($wo->status == 'proses')
                                                    <span class="inline-flex items-center gap-1 text-[10px] font-black text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-100 uppercase">
                                                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-ping"></span> Proses
                                                    </span>
                                                @elseif($wo->status == 'selesai')
                                                    <span class="inline-flex items-center gap-1 text-[10px] font-black text-green-600 bg-green-50 px-2 py-0.5 rounded border border-green-100 uppercase">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Done
                                                    </span>
                                                @endif
                                            </div>

                                            @php
                                                $stageClean = str_replace([' / Finishing', ' / Oven', ' Repair'], '', $wo->repair_stage);
                                                $currentAlloc = $wo->allocations->where('stage', $stageClean)->first();
                                                $isEfisien = true; 
                                                $durationText = '';

                                                if($currentAlloc && $currentAlloc->start_time && $currentAlloc->end_time) {
                                                    $start = \Carbon\Carbon::parse($currentAlloc->start_time);
                                                    $end = \Carbon\Carbon::parse($currentAlloc->end_time);
                                                    
                                                    // PERBAIKAN LOGIKA JAM (PAKAI TOTAL MENIT LALU DI-FLOOR BIAR BULAT)
                                                    $totalMins = $start->diffInMinutes($end);
                                                    $diffHrs = floor($totalMins / 60);
                                                    $diffMins = $totalMins % 60;
                                                    
                                                    $durationText = "{$diffHrs}j {$diffMins}m";
                                                    $diffDecimal = $totalMins / 60;

                                                    $std = 4; 
                                                    if(str_contains($stageClean, 'Body')) $std = 5;
                                                    elseif(str_contains($stageClean, 'Prep')) $std = 3;
                                                    elseif(str_contains($stageClean, 'Paint')) $std = 4;
                                                    elseif(str_contains($stageClean, 'Poles')) $std = 2;
                                                    elseif(str_contains($stageClean, 'Washing')) $std = 1;

                                                    if($diffDecimal > $std) $isEfisien = false;
                                                }
                                            @endphp

                                            @if($wo->status == 'proses' && $currentAlloc && $currentAlloc->start_time && $currentAlloc->end_time)
                                                <div class="flex items-center gap-1.5">
                                                    <span class="text-xs font-black text-gray-800">{{ $durationText }}</span>
                                                    @if($isEfisien)
                                                        <span class="text-[9px] font-black bg-emerald-100 text-emerald-700 px-1.5 py-0.5 rounded border border-emerald-200 uppercase tracking-tighter">🔥 EFISIEN</span>
                                                    @else
                                                        <span class="text-[9px] font-black bg-red-100 text-red-700 px-1.5 py-0.5 rounded border border-red-200 uppercase tracking-tighter">⚠️ OVERTIME</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- KOLOM 4: DEADLINE --}}
                                <td class="px-8 py-5 align-middle">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-gray-800">{{ date('d M Y', strtotime($wo->estimasi_selesai)) }}</span>
                                        <span class="text-[10px] font-bold {{ \Carbon\Carbon::parse($wo->estimasi_selesai)->isPast() && $wo->status != 'selesai' ? 'text-red-500 animate-pulse' : 'text-gray-400' }} uppercase">
                                            {{ \Carbon\Carbon::parse($wo->estimasi_selesai)->diffForHumans() }}
                                        </span>
                                    </div>
                                </td>

                                {{-- KOLOM 5: AKSI --}}
                                <td class="px-8 py-5 align-middle text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('foreman.progress.print', $wo->id) }}" target="_blank" class="p-2.5 bg-white border-2 border-gray-100 rounded-xl text-gray-400 hover:text-gray-900 hover:border-gray-300 hover:bg-gray-50 transition-all shadow-sm" title="Cetak SPK">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        </a>

                                        <a href="{{ route('foreman.progress.edit', $wo->id) }}" class="inline-flex items-center gap-2 bg-gray-900 hover:bg-blue-600 text-white pl-4 pr-5 py-2.5 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg transform hover:-translate-y-0.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                                            Plot
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="emptyStateUnit">
                                <td colspan="5" class="px-8 py-24">
                                    <div class="w-full mx-auto flex flex-col items-center justify-center text-center opacity-50">
                                        <div class="bg-gray-100 p-6 rounded-full mb-4 inline-flex">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                        </div>
                                        <p class="font-black text-gray-500 text-lg uppercase tracking-widest">Kosong Bro!</p>
                                        <p class="text-sm text-gray-400 font-bold">Belum ada unit dalam antrian pengerjaan.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse

                            {{-- BARIS KALO HASIL PENCARIAN KOSONG (ANTI GEPENG TETAP ADA) --}}
                            <tr id="noResultsRow" style="display: none;">
                                <td colspan="5" class="px-8 py-16">
                                    <div class="w-full mx-auto flex flex-col items-center justify-center text-center opacity-50">
                                        <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        </div>
                                        <p class="font-black text-gray-500 text-sm uppercase tracking-widest">Data tidak ditemukan.</p>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchInput')?.addEventListener('keyup', function() {
            const val = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tableUnit tbody tr.search-item');
            let visible = false;
            
            rows.forEach(row => {
                if(row.innerText.toLowerCase().includes(val)) { 
                    row.style.display = ''; 
                    visible = true; 
                } else { 
                    row.style.display = 'none'; 
                }
            });

            const emptyState = document.getElementById('emptyStateUnit');
            const noResultsRow = document.getElementById('noResultsRow');

            if (emptyState && emptyState.style.display !== 'none') {
                return; 
            }

            if (!visible) {
                if (noResultsRow) noResultsRow.style.display = 'table-row';
            } else {
                if (noResultsRow) noResultsRow.style.display = 'none';
            }
        });
    </script>
</x-app-layout>