<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-black text-2xl text-gray-900 leading-tight">
                {{ __('📅 Kehadiran & Produktivitas') }}
            </h2>
            <p class="text-sm text-gray-600 mt-1">Manajemen SDM / <span class="text-red-600 font-bold uppercase tracking-wider">Absensi Harian</span></p>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center gap-3 transform transition-all hover:scale-[1.01]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
                
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 -mr-20 -mt-20 pointer-events-none"></div>

                <div class="p-6 lg:p-8 border-b border-gray-100 bg-white/50 backdrop-blur-sm flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 relative z-10">
                    
                    <form method="GET" action="{{ route('absensi.index') }}" class="flex flex-col sm:flex-row gap-3 w-full xl:w-auto">
                        <div class="relative w-full sm:w-44">
                            {{-- GW SESUAIIN: Tambah py-3.5 px-4 dan rounded-2xl biar tingginya rata sama tombol --}}
                            <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" onchange="this.form.submit()" class="block w-full px-4 py-3.5 bg-gray-50 rounded-2xl border border-gray-200 text-sm font-bold focus:ring-2 focus:ring-red-500 focus:outline-none shadow-sm cursor-pointer hover:bg-white transition-all" title="Pilih Tanggal">
                        </div>
                        
                        <div class="relative w-full sm:w-60 group">
                            {{-- GW SESUAIIN: Tambah py-3.5 dan rounded-2xl --}}
                            <input type="text" id="cariAbsensi" name="search" value="{{ request('search') }}" placeholder="Cari Mekanik..." class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 rounded-2xl border border-gray-200 text-sm font-bold focus:ring-2 focus:ring-red-500 focus:outline-none shadow-sm transition-all focus:bg-white placeholder-gray-400">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </div>

                        <button type="submit" class="hidden">Submit</button>
                    </form>

                    <div class="flex gap-2 w-full sm:w-auto">
                        {{-- GW GANTI: Hover hijau, huruf normal (text-sm), ukuran py-3.5 rounded-2xl --}}
                        <a href="{{ route('absensi.print', ['date' => request('date', date('Y-m-d'))]) }}" target="_blank" class="flex-1 sm:flex-none px-5 py-3.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-2xl shadow-sm hover:bg-gray-50 hover:text-green-600 hover:border-green-300 transition-all flex items-center justify-center gap-2 text-sm whitespace-nowrap group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Laporan
                        </a>
                        
                        {{-- GW GANTI: Hover merah, huruf normal (text-sm), ukuran py-3.5 rounded-2xl --}}
                        <a href="{{ route('absensi.create') }}" class="flex-1 sm:flex-none px-6 py-3.5 bg-gray-900 text-white font-bold rounded-2xl shadow-lg shadow-gray-900/30 hover:bg-red-600 transition-all flex items-center justify-center gap-2 text-sm transform hover:-translate-y-0.5 whitespace-nowrap">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Input Absen
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto w-full pb-4">
                    <table class="w-full text-left table-auto min-w-[700px]" id="tabelAbsensi">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap w-32">Tanggal</th>
                                <th class="px-4 py-4 text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Personil Mekanik</th>
                                <th class="px-4 py-4 text-center text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Status</th>
                                <th class="px-4 py-4 text-center text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Alokasi Job (SPK)</th>
                                <th class="px-6 py-4 text-right text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 bg-white text-sm">
                            @forelse($attendances as $absen)
                            {{-- BARIS HOVER JADI BIRU ESTETIK --}}
                            <tr class="hover:bg-blue-50/20 transition-colors group search-item-absensi" x-data="{ showDeleteModal: false }">
                                
                                <td class="px-6 py-5 align-top">
                                    <div class="font-black text-gray-800 text-xs">{{ \Carbon\Carbon::parse($absen->date)->format('d M Y') }}</div>
                                    <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">{{ \Carbon\Carbon::parse($absen->date)->translatedFormat('l') }}</div>
                                </td>

                                <td class="px-4 py-5 align-top">
                                    <div class="flex items-center gap-4">
                                        {{-- AVATAR DIBIKIN BIRU BULET PERSIS KEK DATA MEKANIK --}}
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-black text-sm shadow-md border-2 border-white shrink-0 group-hover:scale-110 transition-transform">
                                            {{ substr($absen->mechanic->name, 0, 1) }}
                                        </div>
                                        <div>
                                            {{-- NAMA TEKNISI HOVER JADI BIRU + CAPITALIZE --}}
                                            <div class="font-black text-gray-900 text-sm capitalize group-hover:text-blue-600 transition-colors mekanik-name">{{ $absen->mechanic->name }}</div>
                                            <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest {{ $absen->mechanic->position == 'Leader' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : 'bg-gray-100 text-gray-600 border border-gray-200' }}">
                                                {{ $absen->mechanic->position }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-5 text-center align-middle">
                                    @php
                                        $statusConfig = [
                                            'Hadir' => ['color' => 'emerald', 'icon' => '✅'],
                                            'Sakit' => ['color' => 'yellow', 'icon' => '⚠️'],
                                            'Ijin'  => ['color' => 'blue', 'icon' => 'ℹ️'],
                                            'Alpha' => ['color' => 'red', 'icon' => '❌'],
                                        ];
                                        $cfg = $statusConfig[$absen->status] ?? $statusConfig['Alpha'];
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest bg-{{ $cfg['color'] }}-50 text-{{ $cfg['color'] }}-600 border border-{{ $cfg['color'] }}-200 shadow-sm whitespace-nowrap">
                                        {{ $cfg['icon'] }} {{ $absen->status }}
                                    </span>
                                </td>
                                
                                <td class="px-4 py-5 align-middle">
                                    @if($absen->status == 'Hadir')
                                        <div class="flex flex-col gap-1.5 items-center">
                                            @forelse($absen->details as $detail)
                                                @if($detail->workOrder && $detail->workOrder->vehicle)
                                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                                        <span class="inline-block bg-gray-900 text-white font-mono text-[9px] font-black px-1.5 py-0.5 rounded shadow-sm tracking-widest border-b-2 border-gray-600">
                                                            {{ $detail->workOrder->vehicle->nopol }}
                                                        </span>
                                                        <span class="text-xs font-bold text-gray-700 uppercase">
                                                            {{ $detail->workOrder->vehicle->merk }} <span class="text-[9px] text-gray-400">({{ $detail->workOrder->repair_type }})</span>
                                                        </span>
                                                    </div>
                                                @endif
                                            @empty
                                                <span class="text-[10px] font-bold text-gray-400 italic flex items-center gap-1">
                                                    Belum ada SPK.
                                                </span>
                                            @endforelse
                                        </div>
                                    @endif

                                    @if($absen->note) 
                                        <div class="mt-2 bg-yellow-50/80 p-2 rounded border border-yellow-100 text-center">
                                            <p class="text-[9px] text-yellow-800 italic font-medium leading-tight">"{{ $absen->note }}"</p>
                                        </div> 
                                    @endif
                                </td>

                                <td class="px-6 py-5 text-right align-top whitespace-nowrap">
                                    <div class="flex justify-end items-center gap-1.5">
                                        {{-- TOMBOL ACTION HOVER JADI BIRU ESTETIK JUGA --}}
                                        <a href="{{ route('absensi.edit', $absen->id) }}" class="p-2.5 bg-white border border-gray-200 rounded-xl text-gray-400 hover:text-blue-600 hover:border-blue-300 hover:bg-blue-50 transition-all shadow-sm" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        
                                        <button type="button" @click="showDeleteModal = true" class="p-2.5 bg-white border border-gray-200 rounded-xl text-gray-400 hover:text-red-600 hover:border-red-300 hover:bg-red-50 transition-all shadow-sm" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>

                                    <template x-teleport="body">
                                        <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-[120] overflow-y-auto whitespace-normal" x-transition.opacity>
                                            <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                                                <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm" @click="showDeleteModal = false"></div>
                                                <div class="relative bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-md w-full">
                                                    
                                                    <div class="bg-white px-8 pt-8 pb-6 text-center">
                                                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-red-50">
                                                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                        </div>
                                                        <h3 class="text-xl font-black text-gray-900 mb-2">Hapus Absensi?</h3>
                                                        <p class="text-sm text-gray-500 font-medium whitespace-normal text-center">Data absensi <b><span class="capitalize">{{ $absen->mechanic->name }}</span></b> pada tanggal <b>{{ \Carbon\Carbon::parse($absen->date)->format('d M Y') }}</b> akan dihapus permanen. Lanjutkan?</p>
                                                    </div>
                                                    
                                                    <div class="bg-gray-50 px-8 py-5 flex flex-col sm:flex-row-reverse gap-3 rounded-b-[2rem]">
                                                        <form action="{{ route('absensi.destroy', $absen->id) }}" method="POST" class="w-full sm:w-auto">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="w-full px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-md transition-colors">Ya, Hapus!</button>
                                                        </form>
                                                        <button type="button" @click="showDeleteModal = false" class="w-full sm:w-auto px-6 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-colors">Batal</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </td>
                            </tr>
                            @empty
                            <tr id="emptyStateAbsen">
                                <td colspan="5" class="px-6 py-16">
                                    <div class="w-full mx-auto flex flex-col items-center justify-center text-center opacity-50">
                                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path></svg>
                                        </div>
                                        <p class="font-black text-gray-500 text-sm uppercase tracking-widest">Belum Ada Data</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                            
                            {{-- BARIS KHUSUS KALO HASIL CARI KOSONG (ANTI-GEPENG) --}}
                            <tr id="noResultsRow" style="display: none;">
                                <td colspan="5" class="px-6 py-16">
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
                
                @if($attendances->hasPages())
                <div class="p-4 bg-gray-50 border-t border-gray-100">
                    {{ $attendances->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.getElementById('cariAbsensi')?.addEventListener('keyup', function() {
            const val = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tabelAbsensi tbody tr.search-item-absensi');
            let visible = false;
            
            rows.forEach(row => {
                const namaMekanik = row.querySelector('.mekanik-name')?.innerText.toLowerCase() || '';

                if(namaMekanik.includes(val)) { 
                    row.style.display = ''; 
                    visible = true; 
                } else { 
                    row.style.display = 'none'; 
                }
            });

            const emptyState = document.getElementById('emptyStateAbsen');
            const noResultsRow = document.getElementById('noResultsRow');

            if (emptyState && emptyState.style.display !== 'none') {
                return;
            }

            if (!visible) {
                if (noResultsRow) noResultsRow.style.display = 'table-row'; // Anti-gepeng aktif!
            } else {
                if (noResultsRow) noResultsRow.style.display = 'none';
            }
        });
    </script>
</x-app-layout>