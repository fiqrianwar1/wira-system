<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('work-orders.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-amber-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gray-900 leading-tight">
                    {{ __('Edit Data SPK') }}
                </h2>
                <p class="text-xs text-gray-500 font-bold mt-0.5 uppercase tracking-widest">
                    Pembaruan Surat Perintah Kerja / <span class="text-amber-600">Wira Toyota</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100">
                
                {{-- HEADER EDIT MODE (AMBER) --}}
                <div class="bg-amber-400 px-8 py-6 flex items-center gap-4 shadow-sm relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-32 h-full bg-amber-500/30 skew-x-12 transform -translate-x-4"></div>
                    <div class="bg-amber-600 p-3 rounded-2xl text-white shadow-inner relative z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-lg font-black text-amber-900 tracking-widest uppercase">Mode Edit SPK</h3>
                        <p class="text-amber-800 text-xs font-bold mt-0.5">Memperbarui Data: <span class="bg-amber-900 text-amber-100 px-2 py-0.5 rounded ml-1">{{ $workOrder->nomor_spk }}</span></p>
                    </div>
                </div>

                <form action="{{ route('work-orders.update', $workOrder->id) }}" method="POST" class="p-8" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                        
                        {{-- KOLOM KIRI --}}
                        <div class="lg:col-span-1 space-y-6">
                            <div class="bg-gray-50/50 p-6 rounded-3xl border border-gray-100">
                                <h3 class="font-black text-gray-800 text-xs uppercase tracking-widest mb-5 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Informasi Kendaraan
                                </h3>
                                
                                <div class="mt-5" x-data="{ photoDeleted: false, hasPhoto: {{ $workOrder->foto_sebelum ? 'true' : 'false' }} }">
                                    <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Foto Kondisi Awal (Sebelum Perbaikan)
                                    </label>

                                    {{-- Input Hidden buat trigger Controller hapus foto fisik --}}
                                    <input type="hidden" name="hapus_foto_sebelum" :value="photoDeleted ? '1' : '0'">

                                    {{-- Tampilin preview foto lama --}}
                                    @if($workOrder->foto_sebelum)
                                        <div class="mb-3" x-show="!photoDeleted">
                                            <div class="relative inline-block rounded-xl overflow-hidden border-2 border-gray-200 shadow-sm group">
                                                <img src="{{ asset('storage/' . $workOrder->foto_sebelum) }}" alt="Foto Lama" class="h-32 w-auto object-cover">
                                                <div class="absolute bottom-0 left-0 right-0 bg-black/60 text-white text-[9px] font-black text-center py-1 tracking-widest">
                                                    FOTO SAAT INI
                                                </div>
                                                {{-- Tombol Hapus Silang Merah Melayang --}}
                                                <button type="button" @click="photoDeleted = true" class="absolute top-1 right-1 bg-red-600 text-white p-1 rounded-full shadow-lg hover:bg-red-700 transition-all opacity-0 group-hover:opacity-100">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                            <p class="text-[10px] text-red-500 font-bold mt-1.5 italic">*Klik silang merah di ujung foto untuk menghapusnya</p>
                                        </div>
                                    @endif

                                    {{-- Input buat upload foto baru --}}
                                    <input type="file" name="foto_sebelum" accept="image/*" @change="photoDeleted = false" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-2.5 font-medium shadow-sm transition-shadow file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                </div>

                                <div class="mb-5">
                                    <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Kendaraan</label>
                                    <div class="relative">
                                        <select name="vehicle_id" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm appearance-none" required>
                                            @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" {{ $workOrder->vehicle_id == $vehicle->id ? 'selected' : '' }}>{{ $vehicle->nopol }} - {{ $vehicle->merk }}</option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Nomor SPK</label>
                                    <input type="text" value="{{ $workOrder->nomor_spk }}" readonly class="w-full bg-gray-200 border-transparent text-gray-500 text-sm rounded-xl font-mono font-black block p-3.5 shadow-inner cursor-not-allowed">
                                </div>

                                <div class="mb-5">
                                    <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Kategori Perbaikan</label>
                                    <div class="flex gap-3">
                                        <label class="cursor-pointer flex-1 relative group">
                                            <input type="radio" name="repair_type" value="Regular" class="peer sr-only" {{ $workOrder->repair_type == 'Regular' ? 'checked' : '' }}>
                                            <div class="text-center py-3 rounded-xl border-2 border-gray-200 text-gray-500 text-xs font-bold peer-checked:bg-amber-500 peer-checked:text-white peer-checked:border-amber-500 transition-all hover:bg-amber-50">Regular</div>
                                        </label>
                                        <label class="cursor-pointer flex-1 relative group">
                                            <input type="radio" name="repair_type" value="Quick Repair" class="peer sr-only" {{ $workOrder->repair_type == 'Quick Repair' ? 'checked' : '' }}>
                                            <div class="text-center py-3 rounded-xl border-2 border-gray-200 text-gray-500 text-xs font-bold peer-checked:bg-red-600 peer-checked:text-white peer-checked:border-red-600 transition-all hover:bg-red-50">Quick Repair</div>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Keluhan Customer</label>
                                    <textarea name="keluhan_customer" rows="3" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-medium shadow-sm">{{ $workOrder->keluhan_customer }}</textarea>
                                </div>
                            </div>

                            <div class="bg-gray-50/50 p-6 rounded-3xl border border-gray-100">
                                <h3 class="font-black text-gray-800 text-xs uppercase tracking-widest mb-5 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Jadwal & Status
                                </h3>
                                <div class="grid grid-cols-2 gap-4 mb-5">
                                    <div>
                                        <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Tgl Masuk</label>
                                        <input type="date" name="tanggal_masuk" value="{{ $workOrder->tanggal_masuk }}" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3 font-bold shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Est. Selesai</label>
                                        <input type="date" name="estimasi_selesai" value="{{ $workOrder->estimasi_selesai }}" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3 font-bold shadow-sm">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Status Pengerjaan</label>
                                    <select name="status" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm">
                                        <option value="pending" {{ $workOrder->status == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                                        <option value="proses" {{ $workOrder->status == 'proses' ? 'selected' : '' }}>Proses Pengerjaan</option>
                                        <option value="selesai" {{ $workOrder->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM KANAN --}}
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-sm h-full flex flex-col">
                                <div class="bg-gray-50 px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                                    <h3 class="font-black text-gray-800 text-sm uppercase tracking-widest flex items-center gap-2">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        Estimasi Panel & Biaya
                                    </h3>
                                    <button type="button" onclick="addRow()" class="bg-amber-100 hover:bg-amber-500 text-amber-700 hover:text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Tambah Panel
                                    </button>
                                </div>
                                
                                <div class="p-2 flex-grow overflow-x-auto">
                                    <table class="w-full text-left" id="items-table">
                                        <thead>
                                            <tr class="text-[10px] text-gray-400 font-black uppercase tracking-widest border-b border-gray-50">
                                                <th class="pb-3 pt-2 pl-4 w-1/3">Detail Panel</th>
                                                <th class="pb-3 pt-2 pl-2 w-1/4">Tindakan / Kode</th>
                                                <th class="pb-3 pt-2 pr-4 w-1/3 text-right">Tarif Jasa + Part (Rp)</th>
                                                <th class="pb-3 pt-2 text-center w-12">Hapus</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-50" id="table-body">
                                            @foreach($workOrder->details as $detail)
                                            <tr>
                                                <td class="p-3 align-top pl-4">
                                                    <select name="panel_name[]" class="bg-gray-50 border border-gray-200 text-gray-900 text-xs rounded-xl focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 font-bold" onchange="updatePrice(this)" required>
                                                        <option value="{{ $detail->panel_name }}" selected hidden>{{ $detail->panel_name }}</option>
                                                        <optgroup label="--- BAGIAN DEPAN ---">
                                                            <option value="Bumper Depan">Bumper Depan</option>
                                                            <option value="Bodykit Bumper Depan">Bodykit Bumper Depan</option>
                                                            <option value="Grill">Grill</option>
                                                            <option value="Kap Mesin (Hood)">Kap Mesin (Hood)</option>
                                                            <option value="Kaca Depan">Kaca Depan</option>
                                                            <option value="Headlamp Kanan">Headlamp Kanan</option>
                                                            <option value="Headlamp Kiri">Headlamp Kiri</option>
                                                        </optgroup>
                                                        <optgroup label="--- SAMPING KANAN ---">
                                                            <option value="Fender Kanan Depan">Fender Kanan Depan</option>
                                                            <option value="Pintu Depan Kanan">Pintu Depan Kanan</option>
                                                            <option value="Pintu Tengah Kanan">Pintu Tengah Kanan</option>
                                                            <option value="Pillar Kanan">Pillar Kanan</option>
                                                            <option value="Quarter Panel Kanan">Quarter Panel Kanan</option>
                                                            <option value="Triplank Kanan">Triplank Kanan</option>
                                                            <option value="Molding Depan Kanan">Molding Depan Kanan</option>
                                                            <option value="Molding Belakang Kanan">Molding Belakang Kanan</option>
                                                            <option value="Spion Kanan">Spion Kanan</option>
                                                            <option value="Kaca Pintu Kanan">Kaca Pintu Kanan</option>
                                                        </optgroup>
                                                        <optgroup label="--- SAMPING KIRI ---">
                                                            <option value="Fender Kiri Depan">Fender Kiri Depan</option>
                                                            <option value="Pintu Depan Kiri">Pintu Depan Kiri</option>
                                                            <option value="Pintu Tengah Kiri">Pintu Tengah Kiri</option>
                                                            <option value="Pillar Kiri">Pillar Kiri</option>
                                                            <option value="Quarter Panel Kiri">Quarter Panel Kiri</option>
                                                            <option value="Triplank Kiri">Triplank Kiri</option>
                                                            <option value="Molding Depan Kiri">Molding Depan Kiri</option>
                                                            <option value="Molding Belakang Kiri">Molding Belakang Kiri</option>
                                                            <option value="Spion Kiri">Spion Kiri</option>
                                                            <option value="Kaca Pintu Kiri">Kaca Pintu Kiri</option>
                                                        </optgroup>
                                                        <optgroup label="--- BAGIAN BELAKANG ---">
                                                            <option value="Bagasi (Trunk)">Bagasi (Trunk)</option>
                                                            <option value="Bumper Belakang">Bumper Belakang</option>
                                                            <option value="Bodykit Bumper Belakang">Bodykit Bumper Belakang</option>
                                                            <option value="Kaca Belakang">Kaca Belakang</option>
                                                            <option value="Stoplamp Kanan">Stoplamp Kanan</option>
                                                            <option value="Stoplamp Kiri">Stoplamp Kiri</option>
                                                            <option value="Spoiler">Spoiler</option>
                                                        </optgroup>
                                                        <optgroup label="--- ATAP & LAINNYA ---">
                                                            <option value="Atap (Roof)">Atap (Roof)</option>
                                                            <option value="Velg / Roda">Velg / Roda</option>
                                                            <option value="Full Body Siram Luar">Full Body Siram Luar</option>
                                                            <option value="Full Body Luar Dalam">Full Body Luar Dalam</option>
                                                        </optgroup>
                                                    </select>
                                                </td>
                                                <td class="p-3 align-top">
                                                    <select name="kerusakan[]" class="bg-gray-50 border border-gray-200 text-gray-900 text-xs rounded-xl focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 font-bold" onchange="updatePrice(this)" required>
                                                        <option value="KC" {{ $detail->kerusakan == 'KC' ? 'selected' : '' }}>KC - Ketok</option>
                                                        <option value="GC" {{ $detail->kerusakan == 'GC' ? 'selected' : '' }}>GC - Ganti Cat</option>
                                                        <option value="SC" {{ $detail->kerusakan == 'SC' ? 'selected' : '' }}>SC - Siram Cat</option>
                                                        <option value="GT" {{ $detail->kerusakan == 'GT' ? 'selected' : '' }} class="text-blue-600 font-black">GT - Ganti Part</option>
                                                    </select>
                                                    <input type="hidden" name="part_status[]" class="part-status-hidden" value="{{ $detail->part_status }}">
                                                    <input type="hidden" name="part_location[]" value="{{ $detail->part_location }}">
                                                    <input type="hidden" name="part_eta[]" value="{{ $detail->part_eta }}">
                                                </td>
                                                <td class="p-3 align-top pr-4">
                                                    <div class="relative">
                                                        <span class="absolute left-3 top-2.5 text-xs font-black text-gray-400">Rp</span>
                                                        {{-- JURUS SAKTI (int) BIAR DESIMAL .00 MUSNAH! --}}
                                                        <input type="number" name="harga[]" value="{{ (int) $detail->harga }}" class="bg-gray-50 border border-gray-200 text-gray-900 text-xs rounded-xl focus:ring-amber-500 focus:border-amber-500 block w-full pl-10 p-2.5 text-right font-mono font-bold cost-input" oninput="calculateTotal()" required>
                                                    </div>
                                                </td>
                                                <td class="p-3 text-center align-middle">
                                                    <button type="button" onclick="removeRow(this)" class="text-red-400 hover:text-white hover:bg-red-500 transition-all p-2 rounded-xl" title="Hapus Baris">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- TOTAL CALCULATION (HITAM ELEGAN) --}}
                                <div class="bg-gray-900 text-white p-6 border-t border-gray-800 mt-auto rounded-b-3xl">
                                    <div class="flex flex-col gap-3 items-end">
                                        <div class="flex items-center gap-4 text-sm opacity-80">
                                            <span class="font-bold tracking-wider uppercase text-[10px]">Subtotal Jasa:</span>
                                            <span class="font-mono font-bold" id="subtotalDisplay">Rp 0</span>
                                        </div>
                                        <div class="flex items-center gap-4 text-sm">
                                            <span class="font-bold tracking-wider uppercase text-[10px] text-amber-400">Potongan Diskon (%):</span>
                                            {{-- JURUS SAKTI (int) DISKON --}}
                                            <input type="number" name="diskon" id="diskonInput" class="w-20 bg-gray-800 border border-gray-700 rounded-lg text-right text-xs font-bold p-2 focus:ring-amber-500 text-white" value="{{ (int) ($workOrder->diskon ?? 0) }}" oninput="calculateTotal()">
                                        </div>
                                        <div class="w-full h-px bg-gray-800 my-2"></div>
                                        <div class="flex items-center gap-4 text-2xl">
                                            <span class="font-black uppercase tracking-widest text-xs">Total Tagihan:</span>
                                            <span class="font-black text-emerald-400 font-mono tracking-tight" id="total-display">Rp 0</span>
                                            {{-- JURUS SAKTI (int) ESTIMASI BIAYA HIDDEN --}}
                                            <input type="hidden" name="estimasi_biaya" id="estimasiBiayaHidden" value="{{ (int) $workOrder->estimasi_biaya }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6 bg-white flex justify-end gap-4">
                                    <a href="{{ route('work-orders.index') }}" class="px-6 py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-all border border-transparent">
                                        Batal
                                    </a>
                                    <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-amber-500/30 transform transition hover:-translate-y-1 flex items-center gap-2">
                                        Simpan Perubahan
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // 1. KATEGORI PANEL SA WIRA TOYOTA
        const heavyPanels = ['Atap', 'Kap Mesin', 'Quarter', 'Bagasi'];
        const expensiveParts = ['Headlamp', 'Stoplamp', 'Kaca', 'Velg']; 
        const lightPanels = ['Spion', 'Grill', 'Handle', 'Lis', 'Wiper', 'Mika', 'Emblem', 'Cover', 'Side Skirt', 'Triplank', 'Molding', 'Pillar'];
        
        const replaceOnlyPanels = ['Kaca', 'Lampu', 'Headlamp', 'Stoplamp', 'Mika', 'Wiper', 'Grill', 'Emblem', 'Velg'];

        // 2. LOGIKA PENENTUAN HARGA SAKTI (MARKUP SA)
        function getRealPrice(panelName, damageCode) {
            let isHeavy = heavyPanels.some(p => panelName.includes(p)); 
            let isExpensive = expensiveParts.some(p => panelName.includes(p));
            let isLight = lightPanels.some(p => panelName.includes(p));
            
            let isFullBodyLuar = panelName === 'Full Body Siram Luar';
            let isFullBodyDalam = panelName === 'Full Body Luar Dalam';

            // Bypass Full Body
            if (isFullBodyLuar) return 8000000;
            if (isFullBodyDalam) return 12000000;

            // A. Tentukan Harga Dasar Perbaikan / Ketok (KC)
            let baseKcPrice = 900000; // Harga Jasa Standar
            if (isHeavy) baseKcPrice = 1500000; 
            if (isLight) baseKcPrice = 500000;  
            if (isExpensive) baseKcPrice = 0;   

            // B. Hitung berdasarkan Kode Tindakan
            if (damageCode === 'KC') { 
                return baseKcPrice; 
            } 
            else if (damageCode === 'SC') { 
                return baseKcPrice > 0 ? baseKcPrice + 300000 : 0; 
            }
            else if (damageCode === 'GT') { // GANTI PART (Jual Barang)
                if (isExpensive) return 3800000; 
                if (isHeavy) return 2800000;     
                if (panelName.includes('Bumper') && !panelName.includes('Bodykit')) return 1800000; 
                if (panelName.includes('Bodykit')) return 1200000; 
                if (isLight) return 750000;      
                return 1600000;                  
            }
            else if (damageCode === 'GC') { // GANTI PART + CAT BARU
                let pricePart = 1600000; 
                if (isExpensive) pricePart = 3800000;
                if (isHeavy) pricePart = 2800000;
                if (panelName.includes('Bumper') && !panelName.includes('Bodykit')) pricePart = 1800000;
                if (panelName.includes('Bodykit')) pricePart = 1200000;
                if (isLight) pricePart = 750000;

                return pricePart + (baseKcPrice > 0 ? baseKcPrice : 500000); 
            }
            
            return 0;
        }

        // 3. FUNGSI UPDATE HARGA OTOMATIS
        function updatePrice(element) {
            const row = element.closest('tr');
            let panelVal = '';
            
            const panelInput = row.querySelector('input[name="panel_name[]"]');
            const panelSelect = row.querySelector('select[name="panel_name[]"]');
            if(panelSelect) panelVal = panelSelect.value;
            else if (panelInput) panelVal = panelInput.value;

            const damageSelect = row.querySelector('select[name="kerusakan[]"]');
            const costInput = row.querySelector('.cost-input');
            const statusInput = row.querySelector('.part-status-hidden');

            let isReplaceOnly = replaceOnlyPanels.some(p => panelVal.includes(p));
            if (isReplaceOnly) damageSelect.value = 'GT';

            const code = damageSelect.value;
            const finalPrice = getRealPrice(panelVal, code);
            if(finalPrice > 0) costInput.value = finalPrice;

            if (statusInput) {
                if (code === 'GC' || code === 'GT') {
                    statusInput.value = 'Order';
                } else {
                    statusInput.value = 'Ready';
                }
            }
            
            calculateTotal();
        }

        // 4. FUNGSI KALKULASI TOTAL + DISKON
        function calculateTotal() {
            let subtotal = 0;
            document.querySelectorAll('.cost-input').forEach(input => {
                subtotal += parseFloat(input.value || 0);
            });

            const diskonInput = document.getElementById('diskonInput');
            const diskonPersen = diskonInput ? parseFloat(diskonInput.value || 0) : 0;
            const diskonRupiah = subtotal * (diskonPersen / 100);
            const total = subtotal - diskonRupiah;

            const subtotalDisplay = document.getElementById('subtotalDisplay');
            if (subtotalDisplay) subtotalDisplay.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
            
            const totalDisplay = document.getElementById('total-display');
            if (totalDisplay) totalDisplay.innerText = 'Rp ' + total.toLocaleString('id-ID');
            
            const estimasiBiayaHidden = document.getElementById('estimasiBiayaHidden');
            if (estimasiBiayaHidden) estimasiBiayaHidden.value = total;
        }

        // 5. FUNGSI TAMBAH BARIS BARU
        function addRow() {
            const table = document.getElementById('table-body');
            if (!table) return;
            const newRow = table.insertRow();
            
            const isEditMode = window.location.href.includes('edit');
            const focusColor = isEditMode ? 'focus:ring-amber-500 focus:border-amber-500' : 'focus:ring-blue-500 focus:border-blue-500';
            const inputClass = `bg-gray-50 border border-gray-200 text-gray-900 text-xs rounded-xl ${focusColor} block w-full p-2.5 shadow-sm font-bold transition-all`;

            const panelOptions = `
                <option value="" disabled selected>Pilih Panel...</option>
                <optgroup label="--- BAGIAN DEPAN ---">
                    <option value="Bumper Depan">Bumper Depan</option>
                    <option value="Bodykit Bumper Depan">Bodykit Bumper Depan</option>
                    <option value="Grill">Grill</option>
                    <option value="Kap Mesin (Hood)">Kap Mesin (Hood)</option>
                    <option value="Kaca Depan">Kaca Depan</option>
                    <option value="Headlamp Kanan">Headlamp Kanan</option>
                    <option value="Headlamp Kiri">Headlamp Kiri</option>
                </optgroup>
                <optgroup label="--- SAMPING KANAN ---">
                    <option value="Fender Kanan Depan">Fender Kanan Depan</option>
                    <option value="Pintu Depan Kanan">Pintu Depan Kanan</option>
                    <option value="Pintu Tengah Kanan">Pintu Tengah Kanan</option>
                    <option value="Pillar Kanan">Pillar Kanan</option>
                    <option value="Quarter Panel Kanan">Quarter Panel Kanan</option>
                    <option value="Triplank Kanan">Triplank Kanan</option>
                    <option value="Molding Depan Kanan">Molding Depan Kanan</option>
                    <option value="Molding Belakang Kanan">Molding Belakang Kanan</option>
                    <option value="Spion Kanan">Spion Kanan</option>
                    <option value="Kaca Pintu Kanan">Kaca Pintu Kanan</option>
                </optgroup>
                <optgroup label="--- SAMPING KIRI ---">
                    <option value="Fender Kiri Depan">Fender Kiri Depan</option>
                    <option value="Pintu Depan Kiri">Pintu Depan Kiri</option>
                    <option value="Pintu Tengah Kiri">Pintu Tengah Kiri</option>
                    <option value="Pillar Kiri">Pillar Kiri</option>
                    <option value="Quarter Panel Kiri">Quarter Panel Kiri</option>
                    <option value="Triplank Kiri">Triplank Kiri</option>
                    <option value="Molding Depan Kiri">Molding Depan Kiri</option>
                    <option value="Molding Belakang Kiri">Molding Belakang Kiri</option>
                    <option value="Spion Kiri">Spion Kiri</option>
                    <option value="Kaca Pintu Kiri">Kaca Pintu Kiri</option>
                </optgroup>
                <optgroup label="--- BAGIAN BELAKANG ---">
                    <option value="Bagasi (Trunk)">Bagasi (Trunk)</option>
                    <option value="Bumper Belakang">Bumper Belakang</option>
                    <option value="Bodykit Bumper Belakang">Bodykit Bumper Belakang</option>
                    <option value="Kaca Belakang">Kaca Belakang</option>
                    <option value="Stoplamp Kanan">Stoplamp Kanan</option>
                    <option value="Stoplamp Kiri">Stoplamp Kiri</option>
                    <option value="Spoiler">Spoiler</option>
                </optgroup>
                <optgroup label="--- ATAP & LAINNYA ---">
                    <option value="Atap (Roof)">Atap (Roof)</option>
                    <option value="Velg / Roda">Velg / Roda</option>
                    <option value="Full Body Siram Luar">Full Body Siram Luar</option>
                    <option value="Full Body Luar Dalam">Full Body Luar Dalam</option>
                </optgroup>
            `;

            newRow.innerHTML = `
                <td class="p-3 align-top pl-4">
                    <select name="panel_name[]" class="${inputClass}" onchange="updatePrice(this)" required>
                        ${panelOptions}
                    </select>
                </td>
                <td class="p-3 align-top">
                    <select name="kerusakan[]" class="${inputClass}" onchange="updatePrice(this)" required>
                        <option value="" disabled selected>Kode...</option>
                        <option value="KC">KC (Ketok)</option>
                        <option value="GC">GC (Ganti Cat)</option>
                        <option value="SC">SC (Siram)</option>
                        <option value="GT" class="text-blue-600 font-black">GT (Ganti Part)</option>
                    </select>
                    <input type="hidden" name="part_status[]" class="part-status-hidden" value="Ready">
                    <input type="hidden" name="part_location[]" value="">
                    <input type="hidden" name="part_eta[]" value="">
                </td>
                <td class="p-3 align-top pr-4">
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-xs font-black text-gray-400">Rp</span>
                        <input type="number" name="harga[]" placeholder="0" class="${inputClass} pl-10 text-right font-mono cost-input" oninput="calculateTotal()" required>
                    </div>
                </td>
                <td class="p-3 text-center align-middle">
                    <button type="button" onclick="removeRow(this)" class="text-red-400 hover:text-white hover:bg-red-500 transition-all p-2 rounded-xl" title="Hapus Baris">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </td>
            `;
        }

        function removeRow(btn) {
            const row = btn.closest('tr');
            row.remove();
            calculateTotal();
        }

        // 6. INIT LOAD
        document.addEventListener('DOMContentLoaded', function() {
            const tableBody = document.getElementById('table-body');
            if (tableBody && tableBody.children.length === 0) {
                addRow();
            }
            calculateTotal();
        });
    </script>
</x-app-layout>