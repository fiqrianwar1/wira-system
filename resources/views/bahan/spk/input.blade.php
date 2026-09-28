<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('bahan.spk.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-red-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="flex flex-col gap-1 py-1">
                <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-3">
                    🛒 Form Tarik Material
                    <span class="bg-purple-100 text-purple-700 border border-purple-200 px-3 py-0.5 rounded-lg text-sm shadow-sm tracking-widest font-mono">
                        SPK-{{ str_pad($wo->id, 4, '0', STR_PAD_LEFT) }}
                    </span>
                </h2>
                <p class="text-sm text-gray-500 font-bold tracking-widest uppercase mt-1">
                    KENDARAAN: <span class="text-purple-600">{{ $wo->vehicle->nopol ?? 'TANPA NOPOL' }}</span> - {{ $wo->vehicle->model ?? 'Mobil Unknown' }}
                </p>
            </div>
        </div>
    </x-slot>

    {{-- JARAK ATAS DIPANGKAS --}}
    <div class="pt-5 pb-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ALERT MESSAGES --}}
            @if(session('success'))
                <div class="mb-6 bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center gap-3 animate-fade-in-down font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-2xl shadow-sm flex items-center gap-3 animate-pulse font-bold">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
                
                {{-- KIRI: FORM INPUT PENGAMBILAN BAHAN (Makan 4 Kolom) --}}
                <div class="xl:col-span-5">
                    <div class="bg-white shadow-xl shadow-gray-200/50 rounded-[2rem] border border-gray-100 overflow-hidden">
                        <div class="bg-gray-900 px-6 py-5">
                            <h3 class="font-black text-white text-sm uppercase tracking-widest flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                Distribusi dari Gudang
                            </h3>
                        </div>

                        <form action="{{ route('bahan.spk.store', $wo->id) }}" method="POST" class="p-6 space-y-5">
                            @csrf
                            
                            {{-- COMBOBOX TEKNISI PENGAMBIL --}}
                            <div class="bg-purple-50/50 p-4 rounded-xl border border-purple-100">
                                <label class="block text-purple-800 text-[10px] font-black mb-2 uppercase tracking-widest">Siapa yang narik barang?</label>
                                {{-- FIX: disamain tinggi h-[46px] biar ga bantet --}}
                                <select name="mechanic_id" required class="w-full h-[46px] bg-white border border-purple-200 text-gray-800 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block px-3 font-bold shadow-sm cursor-pointer transition-colors">
                                    <option value="" disabled selected>-- Pilih Teknisi Lapangan --</option>
                                    @foreach($mekaniks as $mekanik)
                                        <option value="{{ $mekanik->id }}">{{ $mekanik->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- PILIH BAHAN & QTY --}}
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Material yang mau ditarik</label>
                                <select name="bahan_id" required class="w-full h-[46px] bg-white border border-gray-200 text-gray-800 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block px-3 font-bold shadow-sm cursor-pointer transition-colors">
                                    <option value="" disabled selected>-- Pilih Cat / Thinner / dll --</option>
                                    @foreach($bahans as $b)
                                        <option value="{{ $b->id }}">
                                            {{ $b->kode_bahan }} - {{ $b->nama_bahan }} (Sisa: {{ $b->stok }} {{ $b->satuan }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Jumlah Keluar</label>
                                    <input type="number" step="0.1" min="0.1" name="jumlah_pakai" required class="w-full h-[46px] bg-white border border-gray-200 text-gray-800 text-xl rounded-lg focus:ring-purple-500 focus:border-purple-500 block px-3 font-black shadow-sm placeholder-gray-300 transition-colors text-center" placeholder="0.0">
                                </div>
                                <div>
                                    <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Tgl Pakai</label>
                                    <input type="date" name="tanggal_pakai" value="{{ date('Y-m-d') }}" required class="w-full h-[46px] bg-white border border-gray-200 text-gray-800 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block px-3 font-bold shadow-sm cursor-pointer transition-colors">
                                </div>
                            </div>

                            {{-- COMBOBOX AREA STALL --}}
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Digunakan di Area Pekerjaan</label>
                                <select name="stall" required class="w-full h-[46px] bg-white border border-gray-200 text-gray-800 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block px-3 font-bold shadow-sm cursor-pointer transition-colors">
                                    <option value="" disabled selected>-- Pilih Stall --</option>
                                    <option value="Body">Stall Body (Ketok)</option>
                                    <option value="Preparation">Stall Preparation (Dempul/Epoxy)</option>
                                    <option value="Paint">Stall Paint (Spray Booth/Masking)</option>
                                    <option value="Poles">Stall Poles (Polishing)</option>
                                </select>
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="w-full bg-gray-900 hover:bg-purple-600 text-white font-black py-3.5 px-4 rounded-xl shadow-lg transform transition hover:-translate-y-0.5 flex justify-center items-center gap-2 uppercase tracking-widest text-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    Tarik & Potong Stok
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- KANAN: TABEL RIWAYAT PEMAKAIAN SPK INI (Makan 7 Kolom) --}}
                <div class="xl:col-span-7">
                    <div class="bg-white shadow-xl shadow-gray-200/50 rounded-[2rem] border border-gray-100 overflow-hidden h-full flex flex-col">
                        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                            <div>
                                <h3 class="font-black text-gray-800 text-sm uppercase tracking-widest flex items-center gap-2">
                                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                    Log Distribusi Material SPK
                                </h3>
                            </div>
                            @if($riwayatPakai->count() > 0)
                                <a href="{{ route('bahan.spk.print', $wo->id) }}" target="_blank" class="bg-white border border-gray-200 hover:text-purple-600 hover:bg-purple-50 text-gray-700 text-[10px] uppercase tracking-widest font-black px-4 py-2.5 rounded-lg shadow-sm transition-all flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    Cetak
                                </a>
                            @endif
                        </div>

                        <div class="flex-1 overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-white text-gray-400 text-[10px] uppercase tracking-[0.2em] border-b border-gray-100">
                                        <th class="px-6 py-4 font-black">Material & Area</th>
                                        <th class="px-6 py-4 font-black">Teknisi</th>
                                        <th class="px-6 py-4 font-black text-center">Jumlah</th>
                                        <th class="px-6 py-4 font-black text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 text-sm">
                                    @forelse($riwayatPakai as $rp)
                                        <tr class="hover:bg-purple-50/30 transition-colors group">
                                            <td class="px-6 py-4">
                                                <div class="font-black text-gray-800">{{ $rp->bahan->nama_bahan ?? 'Bahan Terhapus' }}</div>
                                                <div class="inline-flex items-center gap-1 mt-1 bg-purple-50 text-purple-600 px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-widest border border-purple-100">
                                                    {{ $rp->catatan ?? 'Area Kosong' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gray-700 to-gray-900 flex items-center justify-center text-[10px] font-black text-white shadow-sm">
                                                        {{ substr($rp->mechanic->name ?? '?', 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="text-xs font-black text-gray-800 uppercase">{{ $rp->mechanic->name ?? 'Dihapus' }}</div>
                                                        <div class="text-[9px] text-gray-400 font-bold tracking-widest uppercase mt-0.5">{{ \Carbon\Carbon::parse($rp->tanggal_pakai)->format('d M Y') }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="inline-flex items-center justify-center bg-gray-100 text-gray-800 font-black px-3 py-1 rounded-lg border border-gray-200">
                                                    {{ $rp->jumlah_pakai }} <span class="text-[9px] ml-1 text-gray-500 font-bold uppercase">{{ $rp->bahan->satuan ?? '' }}</span>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <form action="{{ route('bahan.spk.destroy', $rp->id) }}" method="POST" onsubmit="return confirm('Yakin batalin penarikan bahan ini? Stoknya bakal dikembalikan ke gudang!');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 bg-white border border-gray-200 text-gray-400 hover:text-red-600 hover:bg-red-50 hover:border-red-200 rounded-lg transition-all shadow-sm" title="Batal Tarik (Hapus)">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-16 text-center">
                                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 border-2 border-white shadow-sm">
                                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                                </div>
                                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Belum ada bahan ditarik untuk unit ini</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>