<x-app-layout>
    <x-slot name="header">
        <div class="py-1">
            <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                {{ __('👥 Data Pelanggan') }}
            </h2>
            <p class="text-sm text-gray-500 font-bold mt-1">
                Master Data / <span class="text-red-600 uppercase tracking-wider">List Customer Bengkel</span>
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
                    
                    {{-- WIDGET TOTAL (Tanpa background card) --}}
                    <div class="flex items-center gap-4 w-full lg:w-auto">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-red-600 shadow-inner flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-black text-xl text-gray-900 leading-none">{{ $customers->total() ?? count($customers) }} <span class="text-sm font-bold text-gray-500 uppercase tracking-widest">Orang</span></h3>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Total Terdaftar</p>
                        </div>
                    </div>

                    {{-- SEARCH & ACTIONS --}}
                    <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto items-center">
                        
                        {{-- FORM SEARCH --}}
                        <form method="GET" action="{{ route('customers.index') }}" class="relative w-full sm:w-72 group" onsubmit="return false;">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            {{-- GW TAMBAHIN ID cariCustomer --}}
                            <input type="text" id="cariCustomer" name="search" value="{{ request('search') }}" class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 bg-gray-50 rounded-2xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white transition-all font-bold text-sm shadow-sm" placeholder="Cari Nama / Kontak...">
                        </form>

                        {{-- GROUP BUTTONS --}}
                        <div class="flex gap-2 w-full sm:w-auto">
                            <a href="{{ route('customers.print') }}" target="_blank" class="flex-1 sm:flex-none px-5 py-3.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-2xl shadow-sm hover:bg-gray-50 hover:text-green-600 hover:border-green-300 transition-all flex items-center justify-center gap-2 text-sm whitespace-nowrap group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Cetak
                            </a>
                            <a href="{{ route('customers.create') }}" class="flex-1 sm:flex-none px-6 py-3.5 bg-gray-900 text-white font-bold rounded-2xl shadow-lg shadow-gray-900/30 hover:bg-red-600 transition-all flex items-center justify-center gap-2 text-sm transform hover:-translate-y-0.5 whitespace-nowrap">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah
                            </a>
                        </div>
                    </div>
                </div>

                {{-- TABEL ANTI NUMPUK --}}
                <div class="overflow-x-auto w-full pb-4">
                    {{-- GW TAMBAHIN ID tabelCustomer --}}
                    <table class="w-full text-left min-w-[800px]" id="tabelCustomer">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-8 py-5 text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Profil Pelanggan</th>
                                <th class="px-8 py-5 text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Kontak (WA)</th>
                                <th class="px-8 py-5 text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Alamat Domisili</th>
                                <th class="px-8 py-5 text-center text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white text-sm">
                            @forelse ($customers as $customer)
                            {{-- GW TAMBAHIN CLASS search-item-customer --}}
                            <tr class="group hover:bg-red-50/40 transition-colors search-item-customer" x-data="{ showDeleteModal: false }">
                                
                                {{-- NAMA & ID (Hitam default, Merah pas hover) --}}
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <div class="h-12 w-12 rounded-2xl bg-gray-900 flex items-center justify-center text-white font-black text-lg shadow-md group-hover:bg-red-600 transition-colors">
                                            {{ substr($customer->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 text-sm group-hover:text-red-600 transition-colors customer-data-text">
                                                {{ $customer->name }}
                                            </div>
                                            <div class="text-[10px] text-gray-400 font-black uppercase tracking-widest mt-0.5">ID: #{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- KONTAK --}}
                                <td class="px-8 py-5 whitespace-nowrap customer-data-text">
                                    <div class="flex flex-col">
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $customer->phone)) }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm font-bold text-gray-800 hover:text-green-600 transition-colors">
                                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.463 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                            {{ $customer->phone }}
                                        </a>
                                        <div class="text-xs text-gray-500 font-medium mt-1">{{ $customer->email ?? 'Tidak ada email' }}</div>
                                    </div>
                                </td>

                                {{-- ALAMAT --}}
                                <td class="px-8 py-5 customer-data-text">
                                    <div class="text-sm text-gray-600 truncate max-w-[250px] font-medium" title="{{ $customer->address }}">
                                        {{ $customer->address ?? 'Alamat belum diisi' }}
                                    </div>
                                </td>

                                {{-- AKSI --}}
                                <td class="px-8 py-5 text-center whitespace-nowrap">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('customers.edit', $customer->id) }}" class="p-2.5 bg-blue-50 border border-blue-200 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Edit Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        
                                        <button @click="showDeleteModal = true" class="p-2.5 bg-red-50 border border-red-200 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Hapus Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>

                                    {{-- MODAL HAPUS PELANGGAN --}}
                                    <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto whitespace-normal">
                                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity" @click="showDeleteModal = false"></div>
                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                                            <div class="inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full">
                                                <div class="bg-white px-8 pt-8 pb-6 text-center">
                                                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                                                        <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                    </div>
                                                    <h3 class="text-xl font-black text-gray-900 mb-2">Hapus {{ $customer->name }}?</h3>
                                                    <p class="text-sm text-gray-500">Data kendaraan dan histori perbaikan milik pelanggan ini akan ikut terhapus permanen. Yakin?</p>
                                                </div>
                                                <div class="bg-gray-50 px-8 py-5 flex flex-row-reverse gap-3 rounded-b-[2rem]">
                                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="w-full sm:w-auto">
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
                            <tr id="emptyStateCustomer">
                                <td colspan="4" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="h-24 w-24 bg-gray-50 rounded-full flex items-center justify-center mb-4 border-4 border-white shadow-sm">
                                            <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <h3 class="text-lg font-black text-gray-800 uppercase tracking-widest">Belum ada data customer</h3>
                                        <p class="mt-1 text-sm text-gray-500 max-w-sm mx-auto">Mulai dengan menambahkan data pelanggan pertama Anda.</p>
                                        <div class="mt-6">
                                            <a href="{{ route('customers.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-md text-sm font-bold rounded-xl text-white bg-red-600 hover:bg-red-700 transition-all transform hover:-translate-y-0.5">
                                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                Tambah Data
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforelse

                            {{-- BARIS KALO HASIL PENCARIAN KOSONG --}}
                            <tr id="noResultsRowCustomer" style="display: none;">
                                <td colspan="4" class="px-8 py-16 text-center">
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
                @if($customers->hasPages())
                <div class="bg-gray-50 px-8 py-5 border-t border-gray-100">
                    {{ $customers->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT BUAT BIKIN KOLOM PENCARIAN HIDUP --}}
    <script>
        document.getElementById('cariCustomer')?.addEventListener('keyup', function() {
            const val = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tabelCustomer tbody tr.search-item-customer');
            let visible = false;
            
            rows.forEach(row => {
                // Ambil semua teks dari class 'customer-data-text' biar nyarinya akurat
                let textData = '';
                row.querySelectorAll('.customer-data-text').forEach(el => {
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
            const emptyState = document.getElementById('emptyStateCustomer');
            const noResultsRow = document.getElementById('noResultsRowCustomer');

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