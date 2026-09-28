<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('spareparts.stocks.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-red-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="py-1">
                <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                    {{ __('📥 Order Stok Gudang') }}
                </h2>
                <p class="text-sm text-gray-500 font-bold mt-1">
                    Logistik / <span class="text-indigo-600 uppercase tracking-wider">Input Manual</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 p-5 rounded-2xl shadow-sm animate-pulse">
                    <p class="font-black uppercase tracking-widest text-xs mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Data Belum Lengkap!
                    </p>
                    <ul class="list-disc list-inside text-sm font-bold ml-1">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/40 rounded-[2rem] border border-gray-100">
                <div class="bg-white px-8 py-6 border-b border-gray-100 flex items-center gap-4">
                    <div class="bg-indigo-50 p-2.5 rounded-xl text-indigo-600 border border-indigo-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-gray-900 uppercase tracking-tight">Form Pengadaan Stok</h3>
                        <p class="text-gray-400 text-xs font-bold mt-0.5 tracking-widest uppercase">Catat barang dari TAM atau pembelian luar.</p>
                    </div>
                </div>

                <form action="{{ route('spareparts.stocks.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100 mb-8">
                        <h4 class="font-black text-gray-400 text-[10px] uppercase tracking-widest mb-4 flex items-center gap-2 border-b border-gray-200 pb-2">
                            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Informasi Logistik
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Supplier / Sumber</label>
                                <select name="source" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3.5 font-bold shadow-sm cursor-pointer">
                                    <option value="TAM Toyota" selected>🏭 TAM Toyota (Official)</option>
                                    <option value="Beli Putus">🛒 Pembelian Luar (Toko)</option>
                                    <option value="Sisa Proyek">🏗️ Sisa Proyek Lama</option>
                                    <option value="Retur">↩️ Retur Customer</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Estimasi Tiba (ETA)</label>
                                <input type="date" name="part_eta" value="{{ date('Y-m-d') }}" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3.5 font-bold shadow-sm cursor-pointer">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Rencana Lokasi Rak</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                    </div>
                                    <input type="text" name="part_location" placeholder="Contoh: Rak A-1, Gudang Kaca..." class="pl-11 w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3.5 font-bold shadow-sm" required>
                                </div>
                            </div>
                            <div class="md:col-span-2 mt-2">
                                <label class="block text-gray-500 text-[10px] font-black mb-2 uppercase tracking-widest">Upload Bukti Surat Jalan / Faktur TAM (Opsional)</label>
                                <div class="flex items-center gap-3">
                                    <div id="fotoPreviewWrapper" class="hidden shrink-0 w-14 h-14 bg-white rounded-xl border border-indigo-200 shadow-sm overflow-hidden flex items-center justify-center p-0.5">
                                        <img id="fotoPreview" class="w-full h-full object-cover rounded-lg" alt="Preview Nota">
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" name="foto_nota" id="foto_nota_input" accept="image/*"
                                            onchange="previewFoto(this)"
                                            class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-[9px] font-bold shadow-sm transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-[10px] file:uppercase file:tracking-widest file:font-black file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                                    </div>
                                </div>
                                <p class="text-[10px] text-gray-400 font-medium mt-1.5">📎 Upload foto surat jalan, faktur, atau nota pembelian sebagai bukti pengadaan.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm mb-6">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="font-black text-gray-800 text-sm uppercase tracking-widest flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                Rincian Part Number
                            </h3>
                            <button type="button" onclick="addItemRow()" class="bg-gray-900 hover:bg-indigo-600 text-white text-[10px] uppercase tracking-widest font-black px-4 py-2.5 rounded-lg shadow-sm transition-all flex items-center gap-1 transform hover:-translate-y-0.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Baris
                            </button>
                        </div>

                        <div class="p-4 overflow-x-auto">
                            <table class="w-full text-left min-w-[700px]">
                                <thead>
                                    <tr class="text-[10px] text-gray-400 font-black uppercase tracking-widest border-b border-gray-100">
                                        <th class="pb-3 pl-2 w-4/12">Nama Panel / Part</th>
                                        <th class="pb-3 w-2/12 text-center">Qty</th>
                                        <th class="pb-3 w-3/12 text-right">Harga Satuan (Rp)</th>
                                        <th class="pb-3 w-3/12 text-right pr-4">Subtotal (Rp)</th>
                                        <th class="pb-3 w-10 text-center"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50" id="itemsContainer"></tbody>
                            </table>
                        </div>

                        <div class="bg-gray-50/50 p-6 border-t border-gray-100">
                            <div class="flex justify-end items-center gap-6">
                                <span class="font-black text-gray-400 text-xs uppercase tracking-widest">Total Belanja:</span>
                                <span class="font-black text-indigo-600 text-2xl font-mono bg-white px-4 py-2 rounded-xl border border-gray-200 shadow-sm" id="grandTotalDisplay">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-100">
                        <a href="{{ route('spareparts.stocks.index') }}" class="px-6 py-3.5 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-all border border-transparent hover:border-gray-200 text-sm uppercase tracking-widest">Batal</a>
                        <button type="submit" class="bg-gray-900 hover:bg-indigo-600 text-white font-black py-3.5 px-8 rounded-xl shadow-lg transform transition hover:-translate-y-0.5 flex items-center gap-2 text-sm uppercase tracking-widest">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Simpan Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const heavyPanels = ['Atap', 'Kap Mesin', 'Quarter', 'Bagasi']; 
        const expensiveParts = ['Headlamp', 'Stoplamp', 'Kaca', 'Velg']; 
        const lightPanels = ['Spion', 'Grill', 'Handle', 'Lis', 'Wiper', 'Mika', 'Emblem', 'Cover', 'Side Skirt', 'Triplank', 'Molding', 'Pillar'];

        const panelOptions = `
            <option value="" disabled selected>-- Pilih Panel / Sparepart --</option>
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
                <option value="Pintu Tengah/Belakang Kanan">Pintu Tengah/Belakang Kanan</option>
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
                <option value="Pintu Tengah/Belakang Kiri">Pintu Tengah/Belakang Kiri</option>
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
            </optgroup>
        `;

        function getPartPrice(panelName) {
            if (!panelName) return 0;
            let isHeavy = heavyPanels.some(p => panelName.includes(p)); 
            let isExpensive = expensiveParts.some(p => panelName.includes(p));
            let isLight = lightPanels.some(p => panelName.includes(p));

            if (isExpensive) return 3200000; 
            if (isHeavy) return 2000000;
            
            if (panelName.includes('Bumper') && !panelName.includes('Bodykit')) return 1500000;
            if (panelName.includes('Bodykit')) return 850000; 

            if (isLight) return 450000;      
            return 1250000; 
        }

        function addItemRow() {
            const container = document.getElementById('itemsContainer');
            const row = document.createElement('tr');
            row.className = "item-row group hover:bg-gray-50/50 transition-colors";
            
            row.innerHTML = `
                <td class="p-2 align-top">
                    <select name="panel_names[]" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 font-bold shadow-sm" onchange="setPrice(this)" required>
                        ${panelOptions}
                    </select>
                </td>
                <td class="p-2 align-top">
                    <input type="number" name="quantities[]" min="1" value="1" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 font-bold shadow-sm text-center qty-input" oninput="calculateRow(this)" required>
                </td>
                <td class="p-2 align-top">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-xs font-bold">Rp</span>
                        <input type="number" name="prices[]" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 pl-8 font-mono font-bold shadow-sm text-right price-input" oninput="calculateRow(this)" placeholder="0" required>
                    </div>
                </td>
                <td class="p-2 align-middle text-right pr-4">
                    <span class="text-sm font-black text-gray-800 font-mono block subtotal-display">Rp 0</span>
                </td>
                <td class="p-2 align-middle text-center">
                    <button type="button" onclick="removeRow(this)" class="text-gray-300 hover:text-red-500 transition-colors p-2 rounded-lg hover:bg-red-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </td>
            `;
            container.appendChild(row);
        }

        function setPrice(selectElement) {
            const row = selectElement.closest('tr');
            const panelName = selectElement.value;
            const priceInput = row.querySelector('.price-input');
            priceInput.value = getPartPrice(panelName);
            priceInput.classList.add('bg-emerald-50', 'border-emerald-300', 'text-emerald-700');
            setTimeout(() => priceInput.classList.remove('bg-emerald-50', 'border-emerald-300', 'text-emerald-700'), 500);
            calculateRow(selectElement);
        }

        function calculateRow(element) {
            const row = element.closest('tr');
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const subtotal = qty * price;
            row.querySelector('.subtotal-display').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let total = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                total += (qty * price);
            });
            document.getElementById('grandTotalDisplay').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        function removeRow(btn) {
            const row = btn.closest('tr');
            const allRows = document.querySelectorAll('.item-row');
            if(allRows.length > 1) {
                row.remove();
                calculateGrandTotal();
            } else {
                row.querySelector('select').value = "";
                row.querySelector('.qty-input').value = 1;
                row.querySelector('.price-input').value = "";
                row.querySelector('.subtotal-display').innerText = "Rp 0";
                calculateGrandTotal();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            addItemRow();
            const urlParams = new URLSearchParams(window.location.search);
            const selectedPanel = urlParams.get('panel');
            if(selectedPanel) {
                const firstSelect = document.querySelector('select[name="panel_names[]"]');
                if(firstSelect) {
                    firstSelect.value = selectedPanel;
                    setPrice(firstSelect);
                }
            }
        });

        function previewFoto(input) {
            const wrapper = document.getElementById('fotoPreviewWrapper');
            const preview = document.getElementById('fotoPreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    wrapper.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                wrapper.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>