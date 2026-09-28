<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('vehicles.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-red-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="py-1">
                <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                    {{ __('🚗 Tambah Kendaraan') }}
                </h2>
                <p class="text-sm text-gray-500 font-bold mt-1">
                    Master Data / <span class="text-red-600 uppercase tracking-wider">Input Unit Baru</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100">
                
                {{-- HEADER CARD --}}
                <div class="bg-gray-900 px-8 py-6 flex items-center gap-4">
                    <div class="bg-blue-500/20 p-3 rounded-2xl text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-white uppercase tracking-widest">Registrasi Unit Kendaraan</h3>
                        <p class="text-gray-400 text-xs font-medium mt-1">Lengkapi spesifikasi mobil dan hubungkan dengan data pemilik.</p>
                    </div>
                </div>

                <form action="{{ route('vehicles.store') }}" method="POST" class="p-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        
                        {{-- KOLOM KIRI --}}
                        <div class="space-y-6">
                            
                            {{-- AUTOCOMPLETE CUSTOMER (GANTI COMBO BOX BIASA) --}}
                            <div class="space-y-2" x-data="{ 
                                search: '', 
                                open: false, 
                                selectedName: '', 
                                selectedId: '{{ old('customer_id') }}',
                                customers: [
                                    @foreach($customers as $customer)
                                        { id: '{{ $customer->id }}', name: '{{ $customer->name }} ({{ $customer->phone }})' },
                                    @endforeach
                                ],
                                get filteredCustomers() {
                                    if (this.search === '') {
                                        return this.customers;
                                    }
                                    return this.customers.filter(c => c.name.toLowerCase().includes(this.search.toLowerCase()));
                                }
                            }">
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Pemilik Kendaraan (Customer)</label>
                                
                                <input type="hidden" name="customer_id" x-model="selectedId" required>

                                <div class="relative">
                                    <input type="text" 
                                           x-model="search" 
                                           @focus="open = true" 
                                           @click.away="open = false"
                                           :placeholder="selectedName ? selectedName : '🔍 Ketik Nama atau No HP Customer...'"
                                           class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold shadow-sm">
                                    
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </div>

                                    <div x-show="open && filteredCustomers.length > 0" 
                                         style="display: none;" 
                                         class="absolute z-30 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-2xl max-h-60 overflow-y-auto p-2 space-y-1">
                                        <template x-for="cust in filteredCustomers" :key="cust.id">
                                            <div @click="selectedId = cust.id; selectedName = cust.name; search = cust.name; open = false" 
                                                 class="px-4 py-3 hover:bg-blue-50 hover:text-blue-700 rounded-xl cursor-pointer text-xs font-bold text-gray-700 transition-colors flex items-center justify-between">
                                                <span x-text="cust.name"></span>
                                                <span class="text-[10px] text-gray-400 uppercase tracking-widest">Pilih</span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Nomor Polisi (Plat)</label>
                                <input type="text" name="nopol" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-mono font-black shadow-sm uppercase tracking-widest" placeholder="DA 1234 XY" required>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Merek</label>
                                    <select name="merk" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold shadow-sm" required>
                                        <option value="Toyota">Toyota</option>
                                        <option value="Honda">Honda</option>
                                        <option value="Daihatsu">Daihatsu</option>
                                        <option value="Mitsubishi">Mitsubishi</option>
                                        <option value="Suzuki">Suzuki</option>
                                        <option value="Nissan">Nissan</option>
                                        <option value="Mazda">Mazda</option>
                                        <option value="Hyundai">Hyundai</option>
                                        <option value="Wuling">Wuling</option>
                                        <option value="BMW">BMW</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Model / Tipe</label>
                                    <input type="text" name="model" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold shadow-sm uppercase" placeholder="Contoh: Avanza G" required>
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM KANAN --}}
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Warna Kendaraan</label>
                                    <input type="text" name="warna" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold shadow-sm" placeholder="Hitam Metalik" required>
                                </div>
                                <div>
                                    <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Tahun Perakitan</label>
                                    <input type="number" name="tahun" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold shadow-sm" placeholder="2023" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Nomor Rangka (Chassis)</label>
                                <input type="text" name="no_rangka" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-mono shadow-sm uppercase" placeholder="MHFX...">
                            </div>

                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Nomor Mesin (Engine)</label>
                                <input type="text" name="no_mesin" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-mono shadow-sm uppercase" placeholder="1TR...">
                            </div>
                        </div>
                    </div>

                    {{-- FOOTER ACTION --}}
                    <div class="flex items-center justify-end border-t border-gray-100 pt-6 gap-4">
                        <a href="{{ route('vehicles.index') }}" class="px-6 py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-all border border-transparent">
                            Batal
                        </a>
                        <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-gray-900/30 transform transition hover:-translate-y-1 flex items-center gap-2">
                            Simpan Data
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>