<x-app-layout>
    <x-slot name="header">
        <div class="py-1">
            <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                {{ __('🚗 Antrean Distribusi Material') }}
            </h2>
            <p class="text-sm text-gray-500 font-bold mt-1">
                Pilih kendaraan untuk mencatat pemakaian bahan / <span class="text-purple-600 uppercase tracking-wider">Wira Toyota</span>
            </p>
        </div>
    </x-slot>

    <div class="pt-5 pb-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- ALERT SUKSES SERAGAM --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-lg font-bold flex items-center gap-3 animate-bounce mx-4 sm:mx-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- WIDGET STATISTIK SPK --}}
            @php
                $totalSpk = $spkAktif->count();
                $sudahInput = $spkAktif->where('bahan_spks_count', '>', 0)->count();
                $belumInput = $totalSpk - $sudahInput;
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mx-4 sm:mx-0">
                <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 shadow-inner flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total SPK Berjalan</p>
                        <p class="text-2xl font-black text-gray-800">{{ $totalSpk }} <span class="text-sm font-bold text-gray-500">Unit</span></p>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 shadow-inner flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Sudah Distribusi</p>
                        <p class="text-2xl font-black text-purple-700">{{ $sudahInput }} <span class="text-sm font-bold text-gray-500">Unit</span></p>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-4 relative overflow-hidden hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 {{ $belumInput > 0 ? 'bg-amber-100 text-amber-600' : 'bg-gray-100 text-gray-400' }} rounded-xl flex items-center justify-center shadow-inner flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Belum Diinput Bahan</p>
                        <p class="text-2xl font-black {{ $belumInput > 0 ? 'text-amber-600' : 'text-gray-800' }}">{{ $belumInput }} <span class="text-sm font-bold text-gray-500">Unit</span></p>
                    </div>
                </div>
            </div>

            {{-- DAFTAR KENDARAAN AKTIF --}}
            <div class="bg-white shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100 mx-4 sm:mx-0 overflow-hidden">
                
                {{-- HEADER TABLE DENGAN SEARCH (SERAGAM MEKANIK) --}}
                <div class="p-6 lg:p-8 border-b border-gray-100 bg-white flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    
                    {{-- INFO KIRI --}}
                    <div class="hidden lg:block w-full lg:w-auto">
                        <h3 class="font-black text-xl text-gray-900 leading-none">Antrean Kendaraan</h3>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Daftar SPK Proses Repair</p>
                    </div>

                    {{-- SEARCH FORM (FOKUS MERAH) --}}
                    <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto items-center">
                        <form method="GET" action="{{ route('bahan.spk.index') }}" class="relative w-full sm:w-72 group" onsubmit="return false;">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" id="cariKendaraan" name="search" value="{{ request('search') }}" class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 bg-gray-50 rounded-2xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white transition-all font-bold text-sm shadow-sm" placeholder="Cari Nopol atau SPK...">
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[900px]" id="tabelKendaraan">
                        <thead>
                            {{-- HEADER UDAH DISAMAIN KAYA STOK BAHAN (bg-gray-50/50) --}}
                            <tr class="bg-gray-50/50 text-gray-400 text-[10px] uppercase tracking-[0.2em] border-b border-gray-100">
                                <th class="px-6 py-5 font-black">No. SPK / Nopol</th>
                                <th class="px-6 py-5 font-black">Detail Kendaraan</th>
                                <th class="px-6 py-5 font-black text-center">Status Pengerjaan</th>
                                <th class="px-6 py-5 font-black text-center">Bahan Terinput</th>
                                <th class="px-6 py-5 font-black text-center">Aksi (Admin)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @forelse($spkAktif as $wo)
                                <tr class="hover:bg-purple-50/40 transition-colors group search-item-kendaraan">
                                    <td class="px-6 py-5 kendaraan-data-text">
                                        {{-- NOPOL HOVER JADI UNGU (Kaya Nama Bahan) --}}
                                        <div class="font-black text-gray-900 text-sm mb-1 group-hover:text-purple-700 transition-colors tracking-tight">{{ $wo->vehicle->nopol ?? 'TANPA NOPOL' }}</div>
                                        
                                        {{-- BADGE SPK 100% PERSIS KODE BAHAN (Hover ganti background) --}}
                                        <span class="inline-block bg-purple-50 text-purple-700 font-mono font-black text-[10px] px-3 py-1.5 rounded-lg border border-purple-200 group-hover:bg-purple-600 group-hover:text-white transition-colors tracking-widest shadow-sm">
                                            SPK-{{ str_pad($wo->id, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 kendaraan-data-text">
                                        <div class="font-bold text-gray-800 text-sm mb-1">{{ $wo->vehicle->model ?? 'Mobil Tidak Diketahui' }}</div>
                                        <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">
                                            Pelanggan: <span class="text-purple-600">{{ $wo->vehicle->customer->name ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        {{-- LABEL STATUS DI-TWEAK BIAR ROUNDED-XL KAYA LABEL STOK --}}
                                        @if(strtolower($wo->status) == 'pending')
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] tracking-widest uppercase font-black bg-amber-50 text-amber-700 border border-amber-200 shadow-sm">
                                                MENUNGGU
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] tracking-widest uppercase font-black bg-blue-50 text-blue-700 border border-blue-200 animate-pulse shadow-sm">
                                                PROSES REPAIR
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if($wo->bahan_spks_count > 0)
                                            <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-purple-100 text-purple-700 font-black border border-purple-200 shadow-sm">
                                                {{ $wo->bahan_spks_count }}
                                            </div>
                                            <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1">Material</div>
                                        @else
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">Belum ada</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            
                                            {{-- TOMBOL CETAK RINCIAN BAHAN (HOVER IJO) --}}
                                            @if($wo->bahan_spks_count > 0)
                                                <a href="{{ route('bahan.spk.print', $wo->id) }}" target="_blank" class="p-2.5 bg-white border border-gray-200 text-gray-500 hover:text-green-600 hover:bg-green-50 hover:border-green-300 rounded-xl shadow-sm transition-all" title="Cetak Rincian Bahan">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                                </a>
                                            @endif

                                            {{-- TOMBOL INPUT BAHAN (AWAL HITAM, HOVER MERAH, HURUF NORMAL) --}}
                                            <a href="{{ route('bahan.spk.input', $wo->id) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-900 hover:bg-red-600 text-white text-sm font-bold rounded-xl shadow-sm transition-all whitespace-nowrap transform hover:-translate-y-0.5">
                                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                                Input Bahan
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="emptyStateKendaraan">
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="w-full mx-auto flex flex-col items-center justify-center text-center">
                                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-sm">
                                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                            </div>
                                            <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight">Belum Ada SPK Aktif</h3>
                                            <p class="text-sm text-gray-500 mt-1 max-w-sm mx-auto">Tidak ada kendaraan yang sedang dalam proses perbaikan saat ini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                            {{-- BARIS KALO HASIL PENCARIAN KOSONG --}}
                            <tr id="noResultsRowKendaraan" style="display: none;">
                                <td colspan="5" class="px-8 py-16">
                                    <div class="w-full mx-auto flex flex-col items-center justify-center text-center opacity-50">
                                        <div class="w-12 h-12 bg-purple-50 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
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

    <script>
        document.getElementById('cariKendaraan')?.addEventListener('keyup', function() {
            const val = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tabelKendaraan tbody tr.search-item-kendaraan');
            let visible = false;
            
            rows.forEach(row => {
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

            const emptyState = document.getElementById('emptyStateKendaraan');
            const noResultsRow = document.getElementById('noResultsRowKendaraan');

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