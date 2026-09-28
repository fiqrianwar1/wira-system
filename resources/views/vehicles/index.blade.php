<x-app-layout>
    <x-slot name="header">
        <div class="py-1">
            <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                {{ __('🚗 Data Kendaraan') }}
            </h2>
            <p class="text-sm text-gray-500 font-bold mt-1">
                Master Data / <span class="text-red-600 uppercase tracking-wider">List Unit Customer</span>
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
                
                {{-- TOOLBAR --}}
                <div class="p-6 lg:p-8 border-b border-gray-100 bg-white flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    
                    {{-- WIDGET TOTAL --}}
                    <div class="flex items-center gap-4 w-full lg:w-auto">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-red-600 shadow-inner flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-black text-xl text-gray-900 leading-none">{{ $vehicles->total() ?? count($vehicles) }} <span class="text-sm font-bold text-gray-500 uppercase tracking-widest">Unit</span></h3>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Terdaftar di Sistem</p>
                        </div>
                    </div>

                    {{-- SEARCH & ACTIONS --}}
                    <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto items-center">
                        {{-- Form Search Merah --}}
                        <form method="GET" action="{{ route('vehicles.index') }}" class="relative w-full sm:w-72 group" onsubmit="return false;">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            {{-- GW GANTI: h-[50px] jadi py-3.5 biar sama persis ukurannya --}}
                            <input type="text" id="cariKendaraan" name="search" value="{{ request('search') }}" class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 bg-gray-50 rounded-2xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white transition-all font-bold text-sm shadow-sm" placeholder="Cari Nopol / Model / Pemilik...">
                        </form>

                        <div class="flex gap-2 w-full sm:w-auto">
                            {{-- GW GANTI: h-[50px] jadi py-3.5 --}}
                            <a href="{{ route('vehicles.print') }}" target="_blank" class="flex-1 sm:flex-none px-5 py-3.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-2xl shadow-sm hover:bg-gray-50 hover:text-green-600 hover:border-green-300 transition-all flex items-center justify-center gap-2 text-sm whitespace-nowrap group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Cetak
                            </a>
                            {{-- GW GANTI: h-[50px] jadi py-3.5 --}}
                            <a href="{{ route('vehicles.create') }}" class="flex-1 sm:flex-none px-6 py-3.5 bg-gray-900 text-white font-bold rounded-2xl shadow-lg shadow-gray-900/30 hover:bg-red-600 transition-all flex items-center justify-center gap-2 text-sm transform hover:-translate-y-0.5 whitespace-nowrap">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Input Unit
                            </a>
                        </div>
                    </div>
                </div>
                {{-- TABEL ANTI NUMPUK --}}
                <div class="overflow-x-auto w-full pb-4">
                    <table class="w-full text-left min-w-[900px]" id="tabelKendaraan">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-8 py-5 text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Identitas Unit</th>
                                <th class="px-8 py-5 text-gray-400 font-black text-[10px] uppercase tracking-widest text-center whitespace-nowrap">Spesifikasi</th>
                                <th class="px-8 py-5 text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Pemilik Kendaraan</th>
                                <th class="px-8 py-5 text-center text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white text-sm">
                            @forelse ($vehicles as $vehicle)
                            <tr class="group hover:bg-red-50/40 transition-colors search-item-kendaraan" x-data="{ showDeleteModal: false }">
                                
                                {{-- IDENTITAS UNIT (PLAT NOMOR) --}}
                                <td class="px-8 py-5 whitespace-nowrap kendaraan-data-text">
                                    <div class="flex items-center gap-4">
                                        {{-- AVATAR DIUBAH JADI HITAM (bg-gray-900) & HOVER MERAH --}}
                                        <div class="h-12 w-12 rounded-2xl bg-gray-900 flex items-center justify-center text-white font-black text-lg shadow-md group-hover:bg-red-600 transition-colors shrink-0">
                                            {{ substr($vehicle->merk, 0, 1) }}
                                        </div>
                                        <div class="flex flex-col gap-1.5">
                                            <div class="font-bold text-gray-900 text-sm group-hover:text-red-600 transition-colors tracking-tight">
                                                {{ $vehicle->merk }} {{ $vehicle->model }}
                                            </div>
                                            <div>
                                                <span class="inline-block bg-gray-900 text-white font-mono text-[11px] font-black px-2.5 py-0.5 rounded shadow-sm tracking-widest border-b-2 border-gray-600">
                                                    {{ $vehicle->nopol }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- SPESIFIKASI --}}
                                <td class="px-8 py-5 text-center whitespace-nowrap">
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="px-2.5 py-1 bg-gray-100 text-gray-700 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                            TH. {{ $vehicle->tahun }}
                                        </span>
                                        <span class="text-xs font-bold text-gray-500 uppercase">{{ $vehicle->warna }}</span>
                                    </div>
                                </td>

                                {{-- PEMILIK --}}
                                <td class="px-8 py-5 whitespace-nowrap kendaraan-data-text">
                                    <div class="flex flex-col">
                                        <div class="text-sm font-bold text-gray-800">{{ $vehicle->customer->name ?? 'Tanpa Pemilik' }}</div>
                                        <div class="text-[10px] text-gray-500 font-bold mt-1 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                            {{ $vehicle->customer->phone ?? '-' }}
                                        </div>
                                    </div>
                                </td>

                                {{-- AKSI --}}
                                <td class="px-8 py-5 text-center whitespace-nowrap">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="p-2.5 bg-blue-50 border border-blue-200 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Edit Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        
                                        <button @click="showDeleteModal = true" class="p-2.5 bg-red-50 border border-red-200 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Hapus Unit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>

                                    {{-- MODAL HAPUS KENDARAAN --}}
                                    <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto whitespace-normal">
                                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity" @click="showDeleteModal = false"></div>
                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                                            <div class="inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full">
                                                <div class="bg-white px-8 pt-8 pb-6 text-center">
                                                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                                                        <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                    </div>
                                                    <h3 class="text-xl font-black text-gray-900 mb-2">Hapus Unit {{ $vehicle->nopol }}?</h3>
                                                    <p class="text-sm text-gray-500">Data unit ini beserta histori perbaikannya (SPK) akan terhapus. Yakin?</p>
                                                </div>
                                                <div class="bg-gray-50 px-8 py-5 flex flex-row-reverse gap-3 rounded-b-[2rem]">
                                                    <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" class="w-full sm:w-auto">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-md transition-colors">Ya, Hapus</button>
                                                    </form>
                                                    <button type="button" @click="showDeleteModal = false" class="w-full sm:w-auto px-6 py-3 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-colors">Batal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="emptyStateKendaraan">
                                <td colspan="4" class="px-8 py-16">
                                    <div class="w-full mx-auto flex flex-col items-center justify-center text-center">
                                        <div class="h-24 w-24 bg-gray-50 rounded-full flex items-center justify-center mb-4 border-4 border-white shadow-sm">
                                            <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        </div>
                                        <h3 class="text-lg font-black text-gray-800 uppercase tracking-widest">Belum ada Unit</h3>
                                        <p class="mt-1 text-sm text-gray-500 max-w-sm mx-auto">Silakan tambahkan data kendaraan pelanggan untuk memulai SPK.</p>
                                        <div class="mt-6">
                                            <a href="{{ route('vehicles.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-md text-sm font-bold rounded-xl text-white bg-red-600 hover:bg-red-700 transition-all transform hover:-translate-y-0.5">
                                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                Input Kendaraan
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforelse

                            {{-- BARIS KALO HASIL PENCARIAN KOSONG --}}
                            <tr id="noResultsRowKendaraan" style="display: none;">
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

                {{-- PAGINATION --}}
                @if($vehicles->hasPages())
                <div class="bg-gray-50 px-8 py-5 border-t border-gray-100">
                    {{ $vehicles->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT BUAT BIKIN KOLOM PENCARIAN HIDUP --}}
    <script>
        document.getElementById('cariKendaraan')?.addEventListener('keyup', function() {
            const val = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tabelKendaraan tbody tr.search-item-kendaraan');
            let visible = false;
            
            rows.forEach(row => {
                // Ambil teks dari class kendaraan-data-text (mencakup Nopol, Merk, Model, Nama Pemilik)
                let textData = '';
                row.querySelectorAll('.kendaraan-data-text').forEach(el => {
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
            const emptyState = document.getElementById('emptyStateKendaraan');
            const noResultsRow = document.getElementById('noResultsRowKendaraan');

            if (emptyState && emptyState.style.display !== 'none') {
                return; // Kalo emang dari awal kosong (database 0), gausah ngapa-ngapain
            }

            if (!visible) {
                if (noResultsRow) noResultsRow.style.display = 'table-row'; // Anti-gepeng aktif
            } else {
                if (noResultsRow) noResultsRow.style.display = 'none';
            }
        });
    </script>
</x-app-layout>