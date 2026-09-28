<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('work-orders.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-purple-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-3">
                    Detail SPK <span class="bg-gray-900 text-white px-3 py-1 rounded-lg text-lg">#{{ str_pad($workOrder->id, 4, '0', STR_PAD_LEFT) }}</span>
                </h2>
                <p class="text-xs text-gray-500 font-bold mt-0.5 uppercase tracking-widest">
                    Monitor Pekerjaan & Costing Bahan / <span class="text-purple-600">Wira Toyota</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- SECTION 1: INFO CUSTOMER & KENDARAAN --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mx-4 sm:mx-0">
                <div class="bg-white shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100 p-6">
                    <h3 class="font-black text-gray-800 uppercase text-xs tracking-widest flex items-center gap-2 mb-4 pb-4 border-b border-gray-50">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Data Pelanggan
                    </h3>
                    <table class="w-full text-sm">
                        <tr><td class="py-2 text-gray-500 font-bold w-24">Nama</td><td class="font-black text-gray-900 uppercase">: {{ $workOrder->vehicle->customer->name ?? '-' }}</td></tr>
                        <tr><td class="py-2 text-gray-500 font-bold">Telepon</td><td class="font-bold text-gray-800">: {{ $workOrder->vehicle->customer->phone ?? '-' }}</td></tr>
                        <tr><td class="py-2 text-gray-500 font-bold">Alamat</td><td class="font-bold text-gray-800">: {{ $workOrder->vehicle->customer->address ?? '-' }}</td></tr>
                    </table>
                </div>

                <div class="bg-white shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100 p-6">
                    <h3 class="font-black text-gray-800 uppercase text-xs tracking-widest flex items-center gap-2 mb-4 pb-4 border-b border-gray-50">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Data Kendaraan
                    </h3>
                    <table class="w-full text-sm">
                        <tr><td class="py-2 text-gray-500 font-bold w-24">No. Polisi</td><td><span class="font-black bg-gray-100 text-gray-800 px-2 py-1 rounded border border-gray-200">: {{ $workOrder->vehicle->nopol ?? '-' }}</span></td></tr>
                        <tr><td class="py-2 text-gray-500 font-bold">Unit</td><td class="font-bold text-gray-900 uppercase">: {{ $workOrder->vehicle->merk ?? '' }} {{ $workOrder->vehicle->model ?? '' }}</td></tr>
                        <tr><td class="py-2 text-gray-500 font-bold">Status</td><td>: <span class="font-black text-blue-600 uppercase">{{ $workOrder->status }}</span></td></tr>
                    </table>
                </div>
            </div>

            {{-- SECTION 1.5: FOTO DOKUMENTASI UNIT --}}
            @if($workOrder->foto_sebelum || $workOrder->foto_sesudah)
            <div class="mx-4 sm:mx-0 bg-white shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100 p-6 mb-6">
                <h3 class="font-black text-gray-800 uppercase text-xs tracking-widest flex items-center gap-2 mb-4 pb-4 border-b border-gray-50">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Dokumentasi Kendaraan
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Tampilin Foto Sebelum --}}
                    @if($workOrder->foto_sebelum)
                    <div>
                        <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Kondisi Awal (SA Check-in)</span>
                        <div class="rounded-2xl overflow-hidden border-2 border-gray-100 shadow-sm bg-gray-50 relative group">
                            <img src="{{ asset('storage/' . $workOrder->foto_sebelum) }}" alt="Foto Sebelum" class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-105">
                        </div>
                    </div>
                    @endif

                    {{-- Tampilin Foto Sesudah (Disiapin buat Foreman Nanti) --}}
                    @if($workOrder->foto_sesudah)
                    <div>
                        <span class="block text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-2">Setelah Perbaikan (Foreman/QC)</span>
                        <div class="rounded-2xl overflow-hidden border-2 border-emerald-100 shadow-sm bg-emerald-50 relative group">
                            <img src="{{ asset('storage/' . $workOrder->foto_sesudah) }}" alt="Foto Sesudah" class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-105">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- SECTION 2: COSTING & PROFIT CALCULATOR --}}
            @php
                $totalPendapatan = $workOrder->estimasi_biaya;
                $totalModalBahan = 0;
                foreach($workOrder->bahanSpks as $pemakaian) {
                    if($pemakaian->bahan) {
                        $totalModalBahan += ($pemakaian->jumlah_pakai * $pemakaian->bahan->harga_satuan);
                    }
                }
                $profit = $totalPendapatan - $totalModalBahan;
                $margin = $totalPendapatan > 0 ? ($profit / $totalPendapatan) * 100 : 0;
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mx-4 sm:mx-0">
                
                {{-- KIRI: TAGIHAN JASA --}}
                <div class="bg-white shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100 overflow-hidden flex flex-col h-full">
                    <div class="bg-gray-900 px-6 py-4">
                        <h3 class="font-black text-white text-sm uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Rincian Tagihan (Pendapatan)
                        </h3>
                    </div>
                    <div class="p-0 flex-1 overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-400 text-[10px] uppercase tracking-[0.2em] border-b border-gray-100">
                                    <th class="px-6 py-3 font-black">Pengerjaan Panel</th>
                                    <th class="px-6 py-3 font-black text-right">Tarif (Rp)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm">
                                @forelse($workOrder->details as $item)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-800">{{ $item->panel_name }}</div>
                                        <div class="text-[10px] text-gray-500 font-bold uppercase">{{ $item->kerusakan }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono font-bold text-gray-700">
                                        {{ number_format($item->harga, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="2" class="px-6 py-8 text-center text-gray-400 italic">Belum ada rincian pengerjaan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-emerald-50 px-6 py-4 border-t border-emerald-100 flex justify-between items-center mt-auto">
                        <span class="font-black text-emerald-800 uppercase tracking-widest text-xs">Total Pendapatan</span>
                        <span class="font-black text-xl text-emerald-600 font-mono">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- KANAN: BIAYA BAHAN --}}
                <div class="bg-white shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100 overflow-hidden flex flex-col h-full">
                    <div class="bg-gray-900 px-6 py-4 flex justify-between items-center">
                        <h3 class="font-black text-white text-sm uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                            Pemakaian Material (Modal HPP)
                        </h3>
                    </div>
                    <div class="p-0 flex-1 overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-400 text-[10px] uppercase tracking-[0.2em] border-b border-gray-100">
                                    <th class="px-6 py-3 font-black">Material & Teknisi</th>
                                    <th class="px-6 py-3 font-black text-center">Jumlah</th>
                                    <th class="px-6 py-3 font-black text-right">HPP Total (Rp)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm">
                                @forelse($workOrder->bahanSpks as $rp)
                                    @php
                                        $hppTotal = 0;
                                        if($rp->bahan) {
                                            $hppTotal = $rp->jumlah_pakai * $rp->bahan->harga_satuan;
                                        }
                                    @endphp
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-800">{{ $rp->bahan->nama_bahan ?? 'Bahan Dihapus' }}</div>
                                        <div class="text-[10px] text-gray-500 font-bold uppercase mt-0.5">{{ $rp->mechanic->name ?? '-' }} | {{ $rp->catatan ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-gray-700">
                                        {{ $rp->jumlah_pakai }} <span class="text-[10px]">{{ $rp->bahan->satuan ?? '' }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono font-bold text-red-500">
                                        {{ number_format($hppTotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="px-6 py-8 text-center text-gray-400 italic">Belum ada material yang ditarik Tinter.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-red-50 px-6 py-4 border-t border-red-100 flex justify-between items-center mt-auto">
                        <span class="font-black text-red-800 uppercase tracking-widest text-xs">Total Modal Bahan</span>
                        <span class="font-black text-xl text-red-600 font-mono">Rp {{ number_format($totalModalBahan, 0, ',', '.') }}</span>
                    </div>
                </div>

            </div>

            {{-- SECTION 3: KESIMPULAN PROFIT --}}
            <div class="mx-4 sm:mx-0">
                <div class="bg-gradient-to-r {{ $profit >= 0 ? 'from-purple-600 to-indigo-700' : 'from-red-600 to-pink-700' }} sm:rounded-[2rem] p-8 shadow-xl text-white relative overflow-hidden flex flex-col sm:flex-row justify-between items-center gap-6">
                    <div class="absolute -right-10 -top-10 opacity-10">
                        <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="relative z-10 text-center sm:text-left">
                        <h3 class="text-sm font-bold uppercase tracking-widest text-white/80 mb-1">Estimasi Keuntungan Kotor (Gross Profit)</h3>
                        <p class="text-xs text-white/60">Pendapatan Jasa dikurangi Total Harga Pokok Penjualan (HPP) Material.</p>
                    </div>
                    <div class="relative z-10 text-center sm:text-right">
                        <div class="text-4xl sm:text-5xl font-black font-mono tracking-tight">
                            Rp {{ number_format($profit, 0, ',', '.') }}
                        </div>
                        <div class="mt-2 inline-block px-3 py-1 bg-white/20 rounded-lg text-sm font-bold backdrop-blur-sm">
                            Margin: {{ number_format($margin, 1) }}%
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 4: TOMBOL CETAK DIPINDAH KE SINI --}}
            <div class="mx-4 sm:mx-0 pb-8 flex justify-end">
                <a href="{{ route('work-orders.show', $workOrder->id) }}" target="_blank" class="inline-flex items-center gap-3 px-8 py-4 bg-gray-900 hover:bg-gray-800 text-white font-black rounded-2xl shadow-xl shadow-gray-900/30 transition-all transform hover:-translate-y-1">
                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    CETAK INVOICE RESMI
                </a>
            </div>

        </div>
    </div>
</x-app-layout>