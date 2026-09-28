<x-app-layout>
    <x-slot name="header">
        <div class="py-1">
            <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                {{ __('📋 Data SPK (Work Orders)') }}
            </h2>
            <p class="text-sm text-gray-500 font-bold mt-1">
                Manajemen Operasional / <span class="text-red-600 uppercase tracking-wider">Surat Perintah Kerja</span>
            </p>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- ALERT SUKSES --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center gap-3 transform transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                
                {{-- TOOLBAR (Header Card) --}}
                <div class="p-6 lg:p-8 border-b border-gray-100 bg-white flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    
                    {{-- TOTAL COUNT --}}
                    <div class="flex items-center gap-4 w-full lg:w-auto">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 shadow-inner flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-black text-xl text-gray-900 leading-none">{{ $workOrders->total() ?? count($workOrders) }} <span class="text-sm font-bold text-gray-500 uppercase tracking-widest">Unit</span></h3>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Total SPK Ditemukan</p>
                        </div>
                    </div>

                    {{-- SEARCH & ACTIONS --}}
                    <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto items-center">
                        {{-- GW TAMBAHIN onsubmit="return false;" & ID cariSPK --}}
                        <form method="GET" action="{{ route('work-orders.index') }}" class="relative w-full sm:w-72 group" onsubmit="return false;">
                            {{-- JURUS SKRIPSI: Biar kalau lagi milih tab "Selesai", terus dia nge-search, tab-nya gak balik ke "Semua" --}}
                            @if(request('filter'))
                                <input type="hidden" name="filter" value="{{ request('filter') }}">
                            @endif
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" id="cariSPK" name="search" value="{{ request('search') }}" class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 bg-gray-50 rounded-2xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white transition-all font-bold text-sm shadow-sm" placeholder="Cari SPK / Plat...">
                        </form>

                        <div class="flex gap-2 w-full sm:w-auto">
                            <a href="{{ route('work-orders.print') }}" target="_blank" class="flex-1 sm:flex-none px-5 py-3.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-2xl shadow-sm hover:bg-gray-50 hover:text-green-600 hover:border-green-300 transition-all flex items-center justify-center gap-2 text-sm whitespace-nowrap group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Laporan
                            </a>
                            <a href="{{ route('work-orders.create') }}" class="flex-1 sm:flex-none px-6 py-3.5 bg-gray-900 text-white font-bold rounded-2xl shadow-lg shadow-gray-900/30 hover:bg-red-600 transition-all flex items-center justify-center gap-2 text-sm transform hover:-translate-y-0.5 whitespace-nowrap">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                SPK Baru
                            </a>
                        </div>
                    </div>
                </div>

                {{-- TABS FILTER LOG HISTORIS (REVISI IBU FITRAH) --}}
                <div class="px-6 lg:px-8 py-4 bg-gray-50/50 border-b border-gray-100 flex gap-4 overflow-x-auto">
                    <a href="{{ route('work-orders.index') }}" 
                       class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest whitespace-nowrap transition-all flex items-center gap-2 
                       {{ !request('filter') ? 'bg-gray-900 text-white shadow-md' : 'text-gray-500 hover:bg-gray-200 bg-white border border-gray-200' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        Semua SPK
                    </a>
                    
                    <a href="{{ route('work-orders.index', ['filter' => 'aktif']) }}" 
                       class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest whitespace-nowrap transition-all flex items-center gap-2 
                       {{ request('filter') == 'aktif' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-500 hover:bg-gray-200 bg-white border border-gray-200' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        ⏳ SPK Aktif
                    </a>
                    
                    <a href="{{ route('work-orders.index', ['filter' => 'selesai']) }}" 
                       class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest whitespace-nowrap transition-all flex items-center gap-2 
                       {{ request('filter') == 'selesai' ? 'bg-emerald-500 text-white shadow-md' : 'text-gray-500 hover:bg-gray-200 bg-white border border-gray-200' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        ✅ Riwayat Selesai (Log)
                    </a>
                </div>

                {{-- TABEL (Font Di-Scale Up Biar Lebih Jelas) --}}
                <div class="overflow-x-auto w-full">
                    {{-- GW TAMBAHIN ID tabelSPK --}}
                    <table class="w-full text-left table-fixed" id="tabelSPK"> 
                        <thead class="bg-white border-b border-gray-100">
                            <tr>
                                <th class="w-1/5 px-4 py-4 text-gray-500 font-black text-xs uppercase tracking-widest">Info SPK</th>
                                <th class="w-1/4 px-4 py-4 text-gray-500 font-black text-xs uppercase tracking-widest">Kendaraan</th>
                                <th class="w-[12%] px-4 py-4 text-center text-gray-500 font-black text-xs uppercase tracking-widest">Tipe</th>
                                <th class="w-[12%] px-4 py-4 text-center text-gray-500 font-black text-xs uppercase tracking-widest">Status</th>
                                <th class="w-[15%] px-4 py-4 text-right text-gray-500 font-black text-xs uppercase tracking-widest">Biaya</th>
                                <th class="w-1/5 px-4 py-4 text-center text-gray-500 font-black text-xs uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($workOrders as $spk)
                            {{-- GW TAMBAHIN CLASS search-item-spk --}}
                            <tr class="group hover:bg-red-50/40 transition-colors search-item-spk" x-data="{ showDeleteModal: false }">
                                
                                {{-- INFO SPK --}}
                                <td class="px-4 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-base font-black text-gray-900 group-hover:text-red-600 transition-colors tracking-tight truncate spk-data-text">
                                            {{ $spk->nomor_spk }}
                                        </span>
                                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1 flex items-center gap-1">
                                            {{ date('d M Y', strtotime($spk->tanggal_masuk)) }}
                                        </span>
                                    </div>
                                </td>

                                {{-- KENDARAAN (Plat Nomor) --}}
                                <td class="px-4 py-4">
                                    <div class="flex flex-col gap-2 overflow-hidden">
                                        <div class="font-bold text-gray-800 text-sm truncate spk-data-text">
                                            {{ $spk->vehicle->merk ?? '' }} {{ $spk->vehicle->model ?? '' }}
                                        </div>
                                        <div>
                                            <span class="inline-block bg-gray-900 text-white font-mono text-xs font-black px-2.5 py-1 rounded-md shadow-sm border-b-2 border-gray-600 spk-data-text">
                                                {{ $spk->vehicle->nopol ?? 'DELETED' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                {{-- TIPE --}}
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-block px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider border {{ $spk->repair_type == 'Quick Repair' ? 'bg-red-50 text-red-600 border-red-200' : 'bg-gray-50 text-gray-700 border-gray-200' }} spk-data-text">
                                        {{ $spk->repair_type }}
                                    </span>
                                </td>

                                {{-- STATUS --}}
                                <td class="px-4 py-4 text-center">
                                    @php
                                        $statusClass = match(strtolower($spk->status)) {
                                            'selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                            'proses' => 'bg-blue-50 text-blue-600 border-blue-200',
                                            'pending' => 'bg-amber-50 text-amber-600 border-amber-200',
                                            default => 'bg-gray-50 text-gray-600 border-gray-200'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black border {{ $statusClass }} uppercase tracking-wider spk-data-text">
                                        {{ $spk->status }}
                                    </span>
                                </td>

                                {{-- BIAYA --}}
                                <td class="px-4 py-4 text-right">
                                    <div class="font-mono font-black text-sm text-gray-800">
                                        {{ number_format($spk->estimasi_biaya, 0, ',', '.') }}
                                    </div>
                                    @if($spk->diskon > 0)
                                        <div class="text-[10px] font-bold text-red-500 uppercase tracking-wider mt-0.5">-{{ $spk->diskon }}%</div>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="px-4 py-4 text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        {{-- Detail --}}
                                        <a href="{{ route('work-orders.detail', $spk->id) }}" class="p-2 bg-purple-50 text-purple-600 rounded-xl hover:bg-purple-600 hover:text-white transition-all shadow-sm" title="Profit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        {{-- Edit --}}
                                        <a href="{{ route('work-orders.edit', $spk->id) }}" class="p-2 bg-gray-50 text-gray-500 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        {{-- Cetak --}}
                                        <a href="{{ route('work-orders.show', $spk->id) }}" target="_blank" class="p-2 bg-gray-50 text-gray-500 rounded-xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm" title="Cetak">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        </a>
                                        {{-- Hapus --}}
                                        <button @click="showDeleteModal = true" class="p-2 bg-gray-50 text-gray-500 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>

                                    {{-- MODAL HAPUS --}}
                                    <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto whitespace-normal">
                                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity" @click="showDeleteModal = false"></div>
                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                                            <div class="inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full">
                                                <div class="bg-white px-8 pt-8 pb-6 text-center">
                                                    <h3 class="text-xl font-black text-gray-900 mb-2">Hapus SPK {{ $spk->nomor_spk }}?</h3>
                                                    <p class="text-sm text-gray-500 italic">Data akan hilang permanen. Yakin?</p>
                                                </div>
                                                <div class="bg-gray-50 px-8 py-5 flex flex-row-reverse gap-3 rounded-b-[2rem]">
                                                    <form action="{{ route('work-orders.destroy', $spk->id) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-md transition-colors">Hapus</button>
                                                    </form>
                                                    <button type="button" @click="showDeleteModal = false" class="px-6 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-colors">Batal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="emptyStateSPK">
                                <td colspan="6" class="px-6 py-16 text-center italic text-gray-400">Belum ada data SPK.</td>
                            </tr>
                            @endforelse

                            {{-- BARIS KALO HASIL PENCARIAN KOSONG --}}
                            <tr id="noResultsRowSPK" style="display: none;">
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
                
                {{-- PAGINATION --}}
                @if($workOrders->hasPages())
                <div class="bg-gray-50 px-8 py-5 border-t border-gray-100">
                    {{ $workOrders->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT BUAT BIKIN KOLOM PENCARIAN HIDUP --}}
    <script>
        document.getElementById('cariSPK')?.addEventListener('keyup', function() {
            const val = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tabelSPK tbody tr.search-item-spk');
            let visible = false;
            
            rows.forEach(row => {
                // Ambil teks dari class spk-data-text (mencakup SPK, Plat, Merk, Tipe, Status)
                let textData = '';
                row.querySelectorAll('.spk-data-text').forEach(el => {
                    textData += el.innerText.toLowerCase() + ' ';
                });

                if(textData.includes(val)) { 
                    row.style.display = ''; 
                    visible = true; 
                } else { 
                    row.style.display = 'none'; 
                }
            });

            // Logika munculin "Pencarian Tidak Ditemukan"
            const emptyState = document.getElementById('emptyStateSPK');
            const noResultsRow = document.getElementById('noResultsRowSPK');

            if (emptyState && emptyState.style.display !== 'none') {
                return; // Kalo emang dari awal kosong (database 0), gausah ngapa-ngapain
            }

            if (!visible) {
                if (noResultsRow) noResultsRow.style.display = '';
            } else {
                if (noResultsRow) noResultsRow.style.display = 'none';
            }
        });
    </script>
</x-app-layout>