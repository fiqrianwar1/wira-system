<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('spareparts.purchases.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-red-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="py-1">
                <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                    {{ __('✏️ Edit Purchase Order') }}
                </h2>
                <p class="text-sm text-gray-500 font-bold mt-1 uppercase tracking-widest">
                    NOMOR PO / <span class="text-amber-600 font-black">{{ $po->po_number }}</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-[85rem] mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('spareparts.purchases.update', $po->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 px-5 py-4 rounded-xl mb-6 shadow-sm">
                        <p class="font-black text-xs uppercase tracking-widest mb-1.5 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77-1.333.192 3 1.732 3z"></path></svg>
                            Data Gagal Disimpan!
                        </p>
                        <ul class="list-disc pl-5 text-sm font-bold opacity-90">
                            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white p-6 rounded-[2rem] shadow-xl shadow-gray-100/50 border border-gray-100 sticky top-6">
                            <h3 class="font-black text-gray-800 text-xs uppercase tracking-[0.1em] mb-5 border-b border-gray-100 pb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Informasi PO
                            </h3>
                            
                            <div class="space-y-5">
                                <input type="hidden" name="work_order_id" value="{{ $po->work_order_id }}">

                                @if($po->work_order_id && $po->workOrder)
                                    <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100 shadow-sm">
                                        <label class="block text-indigo-800 text-[10px] font-black mb-1.5 uppercase tracking-wider">Kendaraan Customer</label>
                                        <div class="flex flex-col mt-1">
                                            <span class="bg-indigo-600 text-white px-3 py-1.5 rounded-lg text-xs font-black w-fit shadow-sm tracking-widest mb-2">{{ $po->workOrder->vehicle->nopol ?? '-' }}</span>
                                            <span class="text-[10px] text-indigo-700 font-bold uppercase tracking-widest">SPK: {{ $po->workOrder->nomor_spk ?? '-' }}</span>
                                        </div>
                                    </div>
                                @endif

                                <div class="bg-amber-50 p-4 rounded-xl border border-amber-100">
                                    <label class="block text-amber-800 text-[10px] font-black mb-2 uppercase tracking-wider">Status Barang</label>
                                    <select name="status" id="statusSelect" class="w-full bg-white border border-amber-200 rounded-lg font-bold text-sm focus:ring-amber-500 focus:border-amber-500 p-2.5 transition-colors text-amber-900 cursor-pointer shadow-sm">
                                        <option value="Ordered" {{ $po->status == 'Ordered' ? 'selected' : '' }}>🟡 ORDERED (Menunggu)</option>
                                        <option value="Received" {{ $po->status == 'Received' ? 'selected' : '' }}>🟢 RECEIVED (Tiba di Gudang)</option>
                                    </select>
                                    <p class="text-[9px] text-amber-600 mt-2 font-medium">Ubah jadi <span class="font-bold">Received</span> jika barang sudah sampai.</p>
                                </div>

                                {{-- VENDOR / SUPPLIER (DIUBAH JADI COMBOBOX) --}}
                                <div>
                                    <label class="block text-gray-400 text-[10px] font-bold mb-1.5 uppercase tracking-wider">Vendor / Sumber Barang</label>
                                    <select name="supplier_name" id="supplierSelect" onchange="autoStatus()" required class="w-full bg-white border border-gray-200 rounded-xl font-bold text-sm focus:ring-amber-500 focus:border-amber-500 p-3 transition-all hover:border-amber-300 text-gray-800 cursor-pointer shadow-sm">
                                        <option value="Gudang Internal (Potong Stok Rak)" {{ str_contains($po->supplier_name, 'Gudang') ? 'selected' : '' }}>Gudang Internal (Potong Stok Rak)</option>
                                        <option value="TAM Toyota (Official)" {{ $po->supplier_name == 'TAM Toyota (Official)' ? 'selected' : '' }}>TAM Toyota (Official)</option>
                                        <option value="Pembelian Luar (Toko)" {{ $po->supplier_name == 'Pembelian Luar (Toko)' ? 'selected' : '' }}>Pembelian Luar (Toko)</option>
                                        <option value="Sisa Proyek Lama" {{ $po->supplier_name == 'Sisa Proyek Lama' ? 'selected' : '' }}>Sisa Proyek Lama</option>
                                        <option value="Retur Customer" {{ $po->supplier_name == 'Retur Customer' ? 'selected' : '' }}>Retur Customer</option>
                                    </select>
                                    <p class="text-[9px] text-gray-400 mt-1.5 italic font-bold">*Ubah sumber barang jika part tidak cocok.</p>
                                </div>

                                <div>
                                    <label class="block text-gray-400 text-[10px] font-bold mb-1.5 uppercase tracking-wider">Tanggal Order</label>
                                    <input type="date" name="order_date" value="{{ $po->order_date->format('Y-m-d') }}" class="w-full bg-white border border-gray-200 rounded-xl font-bold text-sm focus:ring-amber-500 focus:border-amber-500 p-3 transition-all hover:border-amber-300 text-gray-700 cursor-pointer" required>
                                </div>
                            </div>

                            <div class="mt-8 bg-gray-900 rounded-2xl p-5 text-white shadow-xl shadow-gray-200/50 relative overflow-hidden">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em] relative z-10">Total Estimasi</p>
                                <div class="text-2xl font-black font-mono mt-1 tracking-tighter relative z-10" id="grandTotalDisplay">
                                    Rp {{ number_format($po->total_amount, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-3 space-y-6">
                        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-100/50 border border-gray-100 overflow-hidden">
                            <div class="bg-white px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                                <div>
                                    <h3 class="font-black text-gray-900 uppercase italic tracking-tighter flex items-center gap-2 text-lg">
                                        Revisi Item Sparepart
                                    </h3>
                                </div>
                                <button type="button" onclick="addRow()" class="bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white text-xs font-black uppercase tracking-widest px-5 py-2.5 rounded-xl transition-all shadow-sm border border-blue-100 hover:border-blue-600 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    Tambah Baris
                                </button>
                            </div>

                            <div class="p-8">
                                <div class="grid grid-cols-12 gap-4 mb-3 text-[10px] font-black text-gray-400 uppercase tracking-[0.1em] px-2 border-b border-gray-100 pb-3">
                                    <div class="col-span-5">Nama Panel / Sparepart</div>
                                    <div class="col-span-2 text-center">Volume (Qty)</div>
                                    <div class="col-span-4 text-right">Harga Satuan & Subtotal</div>
                                    <div class="col-span-1 text-center">Aksi</div>
                                </div>

                                <div id="items-container" class="space-y-4"></div>
                                <div id="empty-state" class="hidden text-center py-16 border-2 border-dashed border-gray-200 rounded-3xl mt-4 bg-gray-50/50">
                                    <p class="text-gray-400 text-xs font-black uppercase tracking-widest">Keranjang Kosong</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end items-center gap-4 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                            <a href="{{ route('spareparts.purchases.index') }}" class="px-6 py-3 bg-white hover:bg-gray-50 text-gray-600 font-black text-xs uppercase tracking-widest rounded-xl transition-colors border border-gray-200 shadow-sm text-center">
                                Batal
                            </a>
                            <button type="submit" class="px-8 py-3 bg-amber-500 hover:bg-amber-600 text-white font-black text-xs uppercase tracking-widest rounded-xl shadow-xl shadow-amber-200 transition-all transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Update PO
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // OTOMATIS GANTI STATUS KE RECEIVED KALAU PILIH GUDANG
        function autoStatus() {
            const supplierVal = document.getElementById('supplierSelect').value;
            const statusSelect = document.getElementById('statusSelect');
            
            if (supplierVal.includes('Gudang')) {
                statusSelect.value = 'Received';
            }
        }

        const heavyPanels = ['Atap', 'Kap Mesin', 'Quarter', 'Bagasi']; 
        const expensiveParts = ['Headlamp', 'Stoplamp', 'Kaca', 'Velg']; 
        const lightPanels = ['Spion', 'Grill', 'Handle', 'Lis', 'Wiper', 'Mika', 'Emblem', 'Cover', 'Side Skirt', 'Triplank', 'Molding', 'Pillar'];

        const optionsHtml = `
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

        let rowCount = 0;

        function addRow(existingItem = null) {
            document.getElementById('empty-state').style.display = 'none';
            const container = document.getElementById('items-container');
            const div = document.createElement('div');
            
            div.className = "grid grid-cols-12 gap-4 items-start bg-white p-5 rounded-2xl border border-gray-200 shadow-sm item-row hover:border-amber-300 transition-colors";
            
            div.innerHTML = `
                <div class="col-span-5 relative flex items-center">
                    <div class="absolute left-3 text-gray-400 pointer-events-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2-2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <select name="items[${rowCount}][name]" class="w-full bg-gray-50 border border-gray-300 rounded-xl text-sm font-bold focus:ring-amber-500 focus:border-amber-500 h-[46px] pl-10 pr-3 item-select cursor-pointer shadow-sm text-gray-700" onchange="autoPrice(this)" required>
                        ${optionsHtml}
                    </select>
                </div>
                <div class="col-span-2">
                    <input type="number" name="items[${rowCount}][qty]" value="${existingItem ? existingItem.qty : 1}" min="1" class="w-full bg-gray-50 border border-gray-300 rounded-xl text-center text-sm font-bold h-[46px] px-3 qty-input shadow-sm focus:ring-amber-500 focus:border-amber-500 text-gray-700" oninput="calculateRow(this)" required>
                </div>
                <div class="col-span-4 flex flex-col">
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-gray-400 text-xs font-black uppercase pointer-events-none">Rp</span>
                        <input type="number" name="items[${rowCount}][price]" value="${existingItem ? (existingItem.unit_price || existingItem.price || '') : ''}" class="w-full bg-gray-50 border border-gray-300 rounded-xl text-right text-sm font-mono font-bold pl-10 pr-4 h-[46px] price-input shadow-sm focus:ring-amber-500 focus:border-amber-500 text-gray-700" placeholder="0" oninput="calculateRow(this)" required>
                    </div>
                    <div class="text-right mt-2.5 flex justify-end items-center gap-2 pr-1">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Subtotal:</span>
                        <span class="font-mono font-black text-amber-600 text-sm bg-amber-50 px-2.5 py-0.5 rounded-lg border border-amber-200 subtotal-display">Rp0</span>
                    </div>
                    <input type="hidden" class="subtotal-raw" value="0">
                </div>
                <div class="col-span-1 flex justify-center items-start">
                    <button type="button" onclick="removeRow(this)" class="text-gray-400 hover:text-red-500 p-2.5 bg-white hover:bg-red-50 border border-gray-200 hover:border-red-200 rounded-xl transition-all shadow-sm mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            `;
            
            container.appendChild(div);

            if(existingItem) {
                const selectEl = div.querySelector('.item-select');
                if(!selectEl.querySelector(`option[value="${existingItem.item_name}"]`)){
                    selectEl.innerHTML += `<option value="${existingItem.item_name}">${existingItem.item_name}</option>`;
                }
                selectEl.value = existingItem.item_name;
                calculateRow(div.querySelector('.qty-input'));
            }

            rowCount++;
        }

        function autoPrice(selectElement) {
            const row = selectElement.closest('.item-row');
            const itemName = selectElement.value;
            const priceInput = row.querySelector('.price-input');
            
            priceInput.value = getPartPrice(itemName);
            calculateRow(selectElement);
        }

        function calculateRow(element) {
            const row = element.closest('.item-row');
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const subtotal = qty * price;
            
            row.querySelector('.subtotal-display').innerText = 'Rp' + subtotal.toLocaleString('id-ID');
            row.querySelector('.subtotal-raw').value = subtotal;
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
            const row = btn.closest('.item-row');
            row.remove();
            if(document.getElementById('items-container').children.length === 0) {
                document.getElementById('empty-state').style.display = 'block';
            }
            calculateGrandTotal();
        }

        document.addEventListener('DOMContentLoaded', () => {
            const existingItems = @json($po->items);
            if(existingItems && existingItems.length > 0) {
                existingItems.forEach(item => addRow(item));
            } else {
                addRow();
            }
            calculateGrandTotal();
        });
    </script>
</x-app-layout> 