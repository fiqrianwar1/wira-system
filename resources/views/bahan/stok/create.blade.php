<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('bahan.stok.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-red-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="py-1">
                <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                    {{ __('📥 Order Stok Massal') }}
                </h2>
                <p class="text-sm text-gray-500 font-bold mt-1">
                    Input Data Material / <span class="text-purple-600 uppercase tracking-wider">Wira Toyota</span>
                </p>
            </div>  
        </div>
    </x-slot>

    {{-- JARAK ATAS DIPANGKAS JADI pt-5 --}}
    <div class="pt-5 pb-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- ERROR MESSAGE --}}
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-5 rounded-2xl shadow-sm animate-pulse">
                    <p class="font-black uppercase tracking-widest text-xs mb-2">Gagal Menyimpan Data!</p>
                    <ul class="list-disc list-inside text-sm font-bold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-[2.5rem] border border-gray-100">
                
                {{-- FORM HEADER --}}
                <div class="bg-white px-8 py-6 border-b border-gray-100 flex items-center gap-4">
                    <div class="bg-purple-50 p-2.5 rounded-xl text-purple-600 border border-purple-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-gray-900 uppercase tracking-tight">Form Input Stok Massal</h3>
                        <p class="text-gray-400 text-xs font-bold mt-0.5 tracking-widest uppercase">Catat banyak material dari satu faktur supplier sekaligus.</p>
                    </div>
                </div>

                <form action="{{ route('bahan.stok.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf

                    {{-- INFORMASI SUPPLIER & NOTA --}}
                    <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100 mb-8">
                        <h4 class="font-black text-gray-400 text-[10px] uppercase tracking-widest mb-4 flex items-center gap-2 border-b border-gray-200 pb-2">
                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            Info Faktur / Pengadaan
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6"> {{-- UBAH JADI grid-cols-3 --}}
                            <div>
                                <label class="block text-gray-500 text-xs font-black mb-2 uppercase tracking-widest">Supplier / Nama Toko</label>
                                <input type="text" name="supplier" placeholder="Contoh: Warna Tanjung Jaya" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-purple-500 focus:border-purple-500 block p-3.5 font-bold shadow-sm placeholder-gray-300 transition-all">
                            </div>
                            <div>
                                <label class="block text-gray-500 text-xs font-black mb-2 uppercase tracking-widest">Nomor Nota / Invoice</label>
                                <input type="text" name="nomor_nota" placeholder="Contoh: STJ/WTJ/001" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-purple-500 focus:border-purple-500 block p-3.5 font-bold shadow-sm placeholder-gray-300 transition-all">
                            </div>
                            {{-- TAMBAHAN INPUT FILE DI SINI --}}
                            <div class="flex-1">
                                <label class="block text-gray-500 text-xs font-black mb-2 uppercase tracking-widest">Upload Foto Nota</label>
                                <input type="file" name="foto_nota" accept="image/*" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-purple-500 focus:border-purple-500 block p-2.5 font-bold shadow-sm transition-all file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200 cursor-pointer">
                            </div>
                        </div>
                    </div>

                    {{-- AREA INPUT BANYAK BARANG --}}
                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm mb-6">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="font-black text-gray-800 text-sm uppercase tracking-widest flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                Daftar Material
                            </h3>
                            <button type="button" onclick="addItemRow()" class="bg-gray-900 hover:bg-purple-600 text-white text-[10px] font-black uppercase tracking-widest px-4 py-2.5 rounded-lg shadow-sm transition-all flex items-center gap-1 transform hover:-translate-y-0.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Baris
                            </button>
                        </div>

                        <div class="p-4 overflow-x-auto">
                            <table class="w-full text-left min-w-[1000px]">
                                <thead>
                                    <tr class="text-[10px] text-gray-400 font-black uppercase tracking-widest border-b border-gray-100">
                                        <th class="pb-3 pl-3 w-[15%]">Kode / Warna</th>
                                        <th class="pb-3 px-2 w-[22%]">Nama Bahan</th>
                                        <th class="pb-3 px-2 w-[15%]">Kategori</th>
                                        <th class="pb-3 px-2 w-[12%]">Satuan</th>
                                        <th class="pb-3 px-2 w-[10%] text-center">Qty</th>
                                        <th class="pb-3 px-2 w-[20%] text-right">Modal Satuan (Rp)</th>
                                        <th class="pb-3 px-2 w-12 text-center"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50" id="itemsContainer">
                                    {{-- Baris JS bakal muncul di sini --}}
                                </tbody>
                            </table>
                        </div>

                        {{-- TOTAL ASET ORDER --}}
                        <div class="bg-gray-50/50 p-6 border-t border-gray-100">
                            <div class="flex justify-end items-center gap-6">
                                <span class="font-black text-gray-400 text-xs uppercase tracking-widest">Total Nilai Order:</span>
                                <span class="font-black text-purple-600 font-mono text-2xl bg-white px-4 py-2 rounded-xl border border-gray-200 shadow-sm" id="grandTotalDisplay">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    {{-- FOOTER ACTION --}}
                    <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-8 mt-4">
                        <a href="{{ route('bahan.stok.index') }}" class="px-6 py-3.5 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-all border border-transparent hover:border-gray-200 text-sm uppercase tracking-widest">
                            Batal
                        </a>
                        {{-- TOMBOL DIUBAH JADI HITAM KE UNGU --}}
                        <button type="submit" class="bg-gray-900 hover:bg-purple-600 text-white font-black py-3.5 px-8 rounded-xl shadow-lg transform transition hover:-translate-y-0.5 flex items-center gap-2 text-sm uppercase tracking-widest">
                            Simpan Orderan
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT BUAT NAMBAH BARIS --}}
    <script>
        function addItemRow() {
            const container = document.getElementById('itemsContainer');
            const row = document.createElement('tr');
            row.className = "item-row hover:bg-gray-50/50 transition-colors group";
            
            // JURUS ALIGNMENT: h-[42px] biar tinggi semua inputan sama rata
            row.innerHTML = `
                <td class="p-2 pl-3 align-top">
                    <input type="text" name="kode_bahan[]" placeholder="Kode..." required class="w-full h-[42px] bg-white border border-gray-200 text-gray-800 text-xs rounded-xl focus:ring-purple-500 focus:border-purple-500 block px-3 font-mono font-bold shadow-sm placeholder-gray-300">
                </td>
                <td class="p-2 align-top">
                    <input type="text" name="nama_bahan[]" placeholder="Nama Barang..." required class="w-full h-[42px] bg-white border border-gray-200 text-gray-800 text-xs rounded-xl focus:ring-purple-500 focus:border-purple-500 block px-3 font-bold shadow-sm placeholder-gray-300">
                </td>
                <td class="p-2 align-top">
                    <select name="kategori[]" required class="w-full h-[42px] bg-white border border-gray-200 text-gray-800 text-xs rounded-xl focus:ring-purple-500 focus:border-purple-500 block px-3 font-bold shadow-sm cursor-pointer">
                        <option value="" disabled selected>Kategori...</option>
                        <option value="Cat">Cat Basecoat</option>
                        <option value="Thinner">Thinner</option>
                        <option value="Clear">Clear Coat</option>
                        <option value="Dempul">Dempul</option>
                        <option value="Epoxy">Epoxy</option>
                        <option value="Amplas">Amplas</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </td>
                <td class="p-2 align-top">
                    <select name="satuan[]" required class="w-full h-[42px] bg-white border border-gray-200 text-gray-800 text-xs rounded-xl focus:ring-purple-500 focus:border-purple-500 block px-3 font-bold shadow-sm cursor-pointer">
                        <option value="Gram">Gram (g)</option>
                        <option value="Kg">Kilogram (Kg)</option>
                        <option value="cc">cc / mL</option>
                        <option value="Set">Set</option>
                        <option value="Pcs">Pcs / Lembar</option>
                    </select>
                </td>
                <td class="p-2 align-top">
                    <input type="number" step="0.1" min="0" name="stok[]" value="1" required class="w-full h-[42px] bg-white border border-gray-200 text-gray-800 text-xs rounded-xl focus:ring-purple-500 focus:border-purple-500 block px-3 font-black shadow-sm text-center qty-input" oninput="calculateGrandTotal()">
                </td>
                <td class="p-2 align-top">
                    <div class="relative w-full h-[42px]">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-[10px] font-black pointer-events-none">Rp</span>
                        <input type="number" name="harga_satuan[]" placeholder="0" required class="w-full h-[42px] bg-white border border-gray-200 text-gray-800 text-xs rounded-xl focus:ring-purple-500 focus:border-purple-500 block pl-8 pr-3 font-mono font-bold shadow-sm text-right price-input" oninput="calculateGrandTotal()">
                    </div>
                </td>
                <td class="p-2 align-top text-center pt-2.5">
                    <button type="button" onclick="removeRow(this)" class="text-gray-300 hover:text-red-500 transition-colors p-1.5 rounded-lg hover:bg-red-50 group-hover:text-red-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </td>
            `;
            container.appendChild(row);
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
                row.querySelectorAll('input').forEach(input => input.value = '');
                row.querySelector('.qty-input').value = 1;
                row.querySelector('select[name="kategori[]"]').value = ""; 
                row.querySelector('select[name="satuan[]"]').value = "Gram";
                calculateGrandTotal();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            addItemRow();
        });
    </script>
</x-app-layout> 