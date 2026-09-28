<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                {{ __('👥 Data Personil Lapangan') }}
            </h2>
            <p class="text-sm text-gray-600 mt-1">Manajemen SDM / <span class="text-red-600 font-bold uppercase tracking-wider">List Mekanik & Teknisi</span></p>
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

            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
                
                {{-- BACKGROUND ACCENT --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 -mr-20 -mt-20 pointer-events-none"></div>

                {{-- TOOLBAR (Header Card) --}}
                <div class="p-6 lg:p-8 border-b border-gray-100 bg-white flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    
                    {{-- WIDGET TOTAL --}}
                    <div class="flex items-center gap-4 w-full lg:w-auto">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-red-600 shadow-inner flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-black text-xl text-gray-900 leading-none">{{ count($mechanics) }} <span class="text-sm font-bold text-gray-500 uppercase tracking-widest">Orang</span></h3>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Total Personil</p>
                        </div>
                    </div>

                    {{-- SEARCH & ACTIONS --}}
                    <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto items-center">
                        
                        {{-- FORM SEARCH --}}
                        <form method="GET" action="{{ route('mekanik.index') }}" class="relative w-full sm:w-72 group" onsubmit="return false;">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" id="cariMekanik" name="search" value="{{ request('search') }}" class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 bg-gray-50 rounded-2xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white transition-all font-bold text-sm shadow-sm" placeholder="Cari Nama / Spesialis...">
                        </form>

                        {{-- GROUP BUTTONS --}}
                        <div class="flex gap-2 w-full sm:w-auto">
                            <a href="{{ route('mekanik.print', ['date' => request('date', date('Y-m-d'))]) }}" target="_blank" class="flex-1 sm:flex-none px-5 py-3.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-2xl shadow-sm hover:bg-gray-50 hover:text-green-600 hover:border-green-300 transition-all flex items-center justify-center gap-2 text-sm whitespace-nowrap group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Laporan
                            </a>
                            <a href="{{ route('mekanik.create') }}" class="flex-1 sm:flex-none px-6 py-3.5 bg-gray-900 text-white font-bold rounded-2xl shadow-lg shadow-gray-900/30 hover:bg-red-600 transition-all flex items-center justify-center gap-2 text-sm transform hover:-translate-y-0.5 whitespace-nowrap">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Baru
                            </a>
                        </div>
                    </div>
                </div>

                {{-- TABEL --}}
                <div class="overflow-x-auto w-full pb-4">
                    <table class="w-full text-left min-w-[900px]" id="tableMekanik">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-8 py-5 text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Profil Personil</th>
                                <th class="px-6 py-5 text-center text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Posisi & Jabatan</th>
                                <th class="px-6 py-5 text-center text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Kontak</th>
                                <th class="px-6 py-5 text-center text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Status Kerja</th>
                                <th class="px-8 py-5 text-center text-gray-400 font-black text-[10px] uppercase tracking-widest whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white text-sm">
                            @forelse ($mechanics as $mekanik)
                            <tr class="group hover:bg-blue-50/20 transition-colors search-item" x-data="{ showDeleteModal: false }">
                                
                                {{-- NAMA & AVATAR (BIRU ESTETIK) --}}
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-black text-sm shadow-md border-2 border-white shrink-0 group-hover:scale-110 transition-transform">
                                            {{ substr($mekanik->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-black text-gray-900 text-sm group-hover:text-blue-600 transition-colors tracking-tight">
                                                {{ $mekanik->name }}
                                            </div>
                                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">ID: MEK-{{ sprintf('%03d', $mekanik->id) }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- JABATAN & SPESIALIS (CENTER) --}}
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex flex-col gap-1.5 items-center">
                                        @if($mekanik->position == 'Leader')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-black bg-yellow-100 text-yellow-800 border border-yellow-200 uppercase tracking-widest shadow-sm">
                                                👑 Leader Regu
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-black bg-gray-100 text-gray-600 border border-gray-200 uppercase tracking-widest">
                                                🔧 Teknisi Lapangan
                                            </span>
                                        @endif

                                        @php
                                            $colors = [
                                                'Body' => 'bg-red-50 text-red-600 border-red-200',
                                                'Paint' => 'bg-indigo-50 text-indigo-600 border-indigo-200',
                                                'Preparation' => 'bg-orange-50 text-orange-600 border-orange-200',
                                                'Poles' => 'bg-teal-50 text-teal-600 border-teal-200',
                                                'Washing' => 'bg-blue-50 text-blue-600 border-blue-200',
                                                'Assembly' => 'bg-purple-50 text-purple-600 border-purple-200',
                                            ];
                                            $badgeColor = $colors[$mekanik->specialist] ?? 'bg-gray-50 text-gray-600 border-gray-200';
                                        @endphp
                                        <span class="inline-block px-2.5 py-0.5 rounded text-[9px] font-black border {{ $badgeColor }} uppercase tracking-widest">
                                            SPESIALIS: {{ $mekanik->specialist }}
                                        </span>
                                    </div>
                                </td>

                                {{-- KONTAK (CENTER) --}}
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <div class="p-1.5 bg-gray-50 rounded-md text-gray-400 border border-gray-100 group-hover:text-blue-500 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        </div>
                                        <span class="text-sm font-black text-gray-700 font-mono tracking-tight">
                                            {{ $mekanik->phone ?? '-' }}
                                        </span>
                                    </div>
                                </td>

                                {{-- STATUS (CENTER) --}}
                                <td class="px-6 py-5 text-center whitespace-nowrap">
                                    @if($mekanik->is_active)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-600 border border-emerald-200 tracking-widest">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                            AKTIF
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black bg-red-50 text-red-600 border border-red-200 tracking-widest">
                                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                            NON-AKTIF
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="px-8 py-5 text-center whitespace-nowrap">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('mekanik.edit', $mekanik->id) }}" class="p-2.5 bg-white border border-gray-200 text-gray-500 hover:text-blue-600 hover:border-blue-300 hover:bg-blue-50 rounded-xl transition-all shadow-sm" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        
                                        {{-- TOMBOL TRIGGER MODAL HAPUS --}}
                                        <button type="button" @click="showDeleteModal = true" class="p-2.5 bg-white border border-gray-200 text-gray-500 hover:text-red-600 hover:border-red-300 hover:bg-red-50 rounded-xl transition-all shadow-sm" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>

                                    {{-- MODAL HAPUS MEKANIK / PERSONIL --}}
                                    <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto whitespace-normal">
                                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity" @click="showDeleteModal = false"></div>
                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                                            <div class="inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full">
                                                <div class="bg-white px-8 pt-8 pb-6 text-center">
                                                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                                                        <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                    </div>
                                                    <h3 class="text-xl font-black text-gray-900 mb-2">Hapus {{ $mekanik->name }}?</h3>
                                                    <p class="text-sm text-gray-500">Data personil lapangan ini akan terhapus permanen. Yakin?</p>
                                                </div>
                                                <div class="bg-gray-50 px-8 py-5 flex flex-row-reverse gap-3 rounded-b-[2rem]">
                                                    <form action="{{ route('mekanik.destroy', $mekanik->id) }}" method="POST" class="w-full sm:w-auto">
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
                            <tr id="emptyStateMekanik">
                                <td colspan="5" class="px-8 py-20">
                                    <div class="w-full mx-auto flex flex-col items-center justify-center text-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 border-4 border-white shadow-sm">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        </div>
                                        <p class="font-black text-gray-600 uppercase tracking-widest text-sm">Belum Ada Data Personil</p>
                                        <p class="text-xs text-gray-400 mt-1">Silakan klik tombol "Tambah Baru" untuk memasukkan data.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse

                            {{-- BARIS KALO HASIL PENCARIAN KOSONG --}}
                            <tr id="noResults" style="display: none;">
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

    {{-- JS SEARCH --}}
    <script>
        document.getElementById('searchInput')?.addEventListener('keyup', function() {
            const val = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tableMekanik tbody tr.search-item');
            let visible = false;
            
            rows.forEach(row => {
                if(row.innerText.toLowerCase().includes(val)) { 
                    row.style.display = ''; 
                    visible = true; 
                } else { 
                    row.style.display = 'none'; 
                }
            });

            const emptyState = document.getElementById('emptyStateMekanik');
            const noResultsRow = document.getElementById('noResults');

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