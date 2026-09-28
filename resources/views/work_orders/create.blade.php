<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('work-orders.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-red-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gray-900 leading-tight">
                    {{ __('Input SPK Baru') }}
                </h2>
                <p class="text-xs text-gray-500 font-bold mt-0.5 uppercase tracking-widest">
                    Buat Surat Perintah Kerja / <span class="text-red-600">Wira Toyota</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100">
                
                {{-- HEADER CARD --}}
                <div class="bg-gray-900 px-8 py-6 flex items-center gap-4">
                    <div class="bg-blue-500/20 p-3 rounded-2xl text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-white uppercase tracking-widest">Formulir Pendaftaran Servis</h3>
                        <p class="text-gray-400 text-xs font-medium mt-1">Lengkapi data kendaraan dan estimasi biaya perbaikan panel.</p>
                    </div>
                </div>

                {{-- WAJIB ADA enctype="multipart/form-data" BIAR FOTO BISA KE-UPLOAD --}}
                <form action="{{ route('work-orders.store') }}" method="POST" class="p-8" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                        
                        {{-- KOLOM KIRI: INFO UTAMA --}}
                        <div class="lg:col-span-1 space-y-6">
                            
                            {{-- INFO KENDARAAN --}}
                            <div class="bg-gray-50/50 p-6 rounded-3xl border border-gray-100">
                                <h3 class="font-black text-gray-800 text-xs uppercase tracking-widest mb-5 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Informasi Kendaraan
                                </h3>
                                
                                <div class="mt-5">
                                    <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Foto Kondisi Awal (Sebelum Perbaikan)
                                    </label>
                                    <input type="file" name="foto_sebelum" accept="image/*" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-2.5 font-medium shadow-sm transition-shadow file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                </div>

                                <div class="mb-5">
                                    <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Pilih Kendaraan</label>
                                    <div class="relative">
                                        <select name="vehicle_id" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold shadow-sm appearance-none cursor-pointer" required>
                                            <option value="" disabled selected>Cari Nopol / Customer...</option>
                                            @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}">{{ $vehicle->nopol }} - {{ $vehicle->merk }} ({{ $vehicle->customer->name ?? 'No Owner' }})</option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Nomor SPK (Otomatis)</label>
                                    <input type="text" name="nomor_spk" value="{{ $nomorSpk ?? 'SPK-'.date('Ymd').'-'.rand(100,999) }}" readonly class="w-full bg-gray-200 border-transparent text-gray-600 text-sm rounded-xl font-mono font-black block p-3.5 shadow-inner cursor-not-allowed">
                                </div>

                                <div class="mb-5">
                                    <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Kategori Perbaikan</label>
                                    <div class="flex gap-3">
                                        <label class="cursor-pointer flex-1 relative group">
                                            <input type="radio" name="repair_type" value="Regular" class="peer sr-only" checked>
                                            <div class="text-center py-3 rounded-xl border-2 border-gray-200 text-gray-500 text-xs font-bold peer-checked:bg-gray-900 peer-checked:text-white peer-checked:border-gray-900 transition-all hover:bg-gray-100 group-hover:border-gray-300">Regular</div>
                                        </label>
                                        <label class="cursor-pointer flex-1 relative group">
                                            <input type="radio" name="repair_type" value="Quick Repair" class="peer sr-only">
                                            <div class="text-center py-3 rounded-xl border-2 border-gray-200 text-gray-500 text-xs font-bold peer-checked:bg-red-600 peer-checked:text-white peer-checked:border-red-600 transition-all hover:bg-red-50 group-hover:border-red-200">Quick Repair</div>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Keluhan Customer</label>
                                    <textarea name="keluhan_customer" rows="3" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-medium shadow-sm transition-shadow" placeholder="Contoh: Bumper depan penyok menabrak tiang..."></textarea>
                                </div>
                            </div>

                            {{-- INFO JADWAL --}}
                            <div class="bg-gray-50/50 p-6 rounded-3xl border border-gray-100">
                                <h3 class="font-black text-gray-800 text-xs uppercase tracking-widest mb-5 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Penjadwalan
                                </h3>
                                <div class="grid grid-cols-2 gap-4 mb-5">
                                    <div>
                                        <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Tgl Masuk</label>
                                        <input type="date" name="tanggal_masuk" value="{{ date('Y-m-d') }}" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3 font-bold shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Est. Selesai</label>
                                        <input type="date" name="estimasi_selesai" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3 font-bold shadow-sm">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Status Awal</label>
                                    <select name="status" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold shadow-sm appearance-none">
                                        <option value="pending">Pending (Menunggu)</option>
                                        <option value="proses">Proses Pengerjaan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: PANEL & BIAYA --}}
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-sm h-full flex flex-col">
                                
                                <div class="bg-gray-50 px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                                    <h3 class="font-black text-gray-800 text-sm uppercase tracking-widest flex items-center gap-2">
                                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        Estimasi Panel & Biaya
                                    </h3>
                                    <button type="button" onclick="addRow()" class="bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all flex items-center gap-1">
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
                                            {{-- JS Injects Here --}}
                                        </tbody>
                                    </table>
                                </div>

                                {{-- TOTAL CALCULATION --}}
                                <div class="bg-gray-900 text-white p-6 border-t border-gray-800 mt-auto rounded-b-3xl">
                                    <div class="flex flex-col gap-3 items-end">
                                        <div class="flex items-center gap-4 text-sm opacity-80">
                                            <span class="font-bold tracking-wider uppercase text-[10px]">Subtotal Jasa:</span>
                                            <span class="font-mono font-bold" id="subtotalDisplay">Rp 0</span>
                                        </div>
                                        <div class="flex items-center gap-4 text-sm">
                                            <span class="font-bold tracking-wider uppercase text-[10px] text-red-400">Potongan Diskon (%):</span>
                                            <input type="number" name="diskon" id="diskonInput" class="w-20 bg-gray-800 border border-gray-700 rounded-lg text-right text-xs font-bold p-2 focus:ring-red-500 text-white" value="0" oninput="calculateTotal()">
                                        </div>
                                        <div class="w-full h-px bg-gray-800 my-2"></div>
                                        <div class="flex items-center gap-4 text-2xl">
                                            <span class="font-black uppercase tracking-widest text-xs">Total Tagihan:</span>
                                            <span class="font-black text-emerald-400 font-mono tracking-tight" id="total-display">Rp 0</span>
                                            <input type="hidden" name="estimasi_biaya" id="estimasiBiayaHidden">
                                        </div>
                                    </div>
                                </div>

                                {{-- FORM ACTIONS --}}
                                <div class="p-6 bg-white flex justify-end gap-4">
                                    <a href="{{ route('work-orders.index') }}" class="px-6 py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-all border border-transparent">
                                        Batal
                                    </a>
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-blue-500/30 transform transition hover:-translate-y-1 flex items-center gap-2">
                                        Simpan SPK
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
        // 1. KATEGORI PANEL (SINKRON DENGAN GUDANG)
        const heavyPanels = ['Atap', 'Kap Mesin', 'Quarter', 'Bagasi'];
        const expensiveParts = ['Headlamp', 'Stoplamp', 'Kaca', 'Velg']; 
        const lightPanels = ['Spion', 'Grill', 'Handle', 'Lis', 'Wiper', 'Mika', 'Emblem', 'Cover', 'Side Skirt', 'Triplank', 'Molding', 'Pillar'];
        
        // Part yang WAJIB diganti (GT)
        const replaceOnlyPanels = ['Kaca', 'Lampu', 'Headlamp', 'Stoplamp', 'Mika', 'Wiper', 'Grill', 'Emblem', 'Velg'];

        // 2. LOGIKA PENENTUAN HARGA SAKTI (MARKUP SA / JASA BENGKEL)
        function getRealPrice(panelName, damageCode) {
            let isHeavy = heavyPanels.some(p => panelName.includes(p)); 
            let isExpensive = expensiveParts.some(p => panelName.includes(p));
            let isLight = lightPanels.some(p => panelName.includes(p));
            
            let isFullBodyLuar = panelName === 'Full Body Siram Luar';
            let isFullBodyDalam = panelName === 'Full Body Luar Dalam';

            // Kalo pilih Full Body, bypass semua logic, langsung kasih harga Sultan
            if (isFullBodyLuar) return 8000000;
            if (isFullBodyDalam) return 12000000;

            // A. Harga Dasar Jasa Ketok/Perbaikan (KC)
            let baseKcPrice = 900000; // Standar (Bumper, Pintu, Fender)
            if (isHeavy) baseKcPrice = 1500000; // Atap, Kap Mesin
            if (isLight) baseKcPrice = 500000;  // Spion, Handle, Molding
            if (isExpensive) baseKcPrice = 0;   // Kaca dkk gak bisa diketok

            // B. Hitung berdasarkan Kode Tindakan (KC, SC, GT, GC)
            if (damageCode === 'KC') { 
                return baseKcPrice; 
            } 
            else if (damageCode === 'SC') { 
                return baseKcPrice > 0 ? baseKcPrice + 300000 : 0; // Siram = Ketok + 300k
            }
            else if (damageCode === 'GT') { // GANTI PART AJA (Harga Jual ke Customer)
                if (isExpensive) return 3800000; // Modal 3.2m
                if (isHeavy) return 2800000;     // Modal 2m
                if (panelName.includes('Bumper') && !panelName.includes('Bodykit')) return 1800000; // Modal 1.5m
                if (panelName.includes('Bodykit')) return 1200000; // Modal 850k
                if (isLight) return 750000;      // Modal 450k
                return 1600000;                  // Standar (Modal 1.25m)
            }
            else if (damageCode === 'GC') { // GANTI PART + PENGECATAN BARU
                let pricePart = 1600000; 
                if (isExpensive) pricePart = 3800000;
                if (isHeavy) pricePart = 2800000;
                if (panelName.includes('Bumper') && !panelName.includes('Bodykit')) pricePart = 1800000;
                if (panelName.includes('Bodykit')) pricePart = 1200000;
                if (isLight) pricePart = 750000;

                // Total = Harga Part Markup + Jasa Cat
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

            // Cek part yang cuma bisa diganti
            let isReplaceOnly = replaceOnlyPanels.some(p => panelVal.includes(p));
            if (isReplaceOnly) damageSelect.value = 'GT';

            // Tembak Harga Sesuai Kategori SA
            const code = damageSelect.value;
            const finalPrice = getRealPrice(panelVal, code);
            if(finalPrice > 0) costInput.value = finalPrice;

            // Set Status buat ditembak ke Gudang Sparepart
            if (statusInput) {
                if (code === 'GC' || code === 'GT') {
                    statusInput.value = 'Order'; // Minta ke Gudang
                } else {
                    statusInput.value = 'Ready'; // Gak butuh part
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

            document.getElementById('subtotalDisplay').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('total-display').innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('estimasiBiayaHidden').value = total;
        }

        // 5. FUNGSI TAMBAH BARIS PANEL
        function addRow() {
            const table = document.getElementById('table-body');
            if (!table) return;
            const newRow = table.insertRow();
            
            const inputClass = `bg-gray-50 border border-gray-200 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 shadow-sm font-bold transition-all`;

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