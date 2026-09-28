<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('vehicles.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-red-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="py-1">
                <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                    {{ __('✏️ Edit Kendaraan') }}
                </h2>
                <p class="text-sm text-gray-500 font-bold mt-1">
                    Master Data / <span class="text-amber-600 uppercase tracking-wider">Perbarui Unit</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl shadow-gray-200/50 sm:rounded-[2rem] border border-gray-100">
                
                {{-- HEADER EDIT MODE (AMBER) --}}
                <div class="bg-amber-400 px-8 py-6 flex items-center gap-4 shadow-sm relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-32 h-full bg-amber-500/30 skew-x-12 transform -translate-x-4"></div>
                    <div class="bg-amber-600 p-3 rounded-2xl text-white shadow-inner relative z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-lg font-black text-amber-900 tracking-widest uppercase">Mode Edit Unit</h3>
                        <p class="text-amber-800 text-xs font-bold mt-0.5">Memperbarui Data Nopol: <span class="bg-amber-900 text-amber-100 px-2 py-0.5 rounded ml-1">{{ $vehicle->nopol }}</span></p>
                    </div>
                </div>

                <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        
                        {{-- KOLOM KIRI --}}
                        <div class="space-y-6">
                            
                            {{-- AUTOCOMPLETE CUSTOMER (MODE EDIT) --}}
                            <div class="space-y-2" x-data="{ 
                                search: '', 
                                open: false, 
                                selectedName: '{{ $vehicle->customer ? $vehicle->customer->name . ' (' . $vehicle->customer->phone . ')' : '' }}', 
                                selectedId: '{{ $vehicle->customer_id }}',
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
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Pemilik Kendaraan</label>
                                
                                <input type="hidden" name="customer_id" x-model="selectedId" required>

                                <div class="relative">
                                    <input type="text" 
                                           x-model="search" 
                                           @focus="open = true" 
                                           @click.away="open = false"
                                           :placeholder="selectedName ? selectedName : '🔍 Ketik Nama atau No Telpon Customer...'"
                                           class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm">
                                    
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </div>

                                    <div x-show="open && filteredCustomers.length > 0" 
                                         style="display: none;" 
                                         class="absolute z-30 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-2xl max-h-60 overflow-y-auto p-2 space-y-1">
                                        <template x-for="cust in filteredCustomers" :key="cust.id">
                                            <div @click="selectedId = cust.id; selectedName = cust.name; search = cust.name; open = false" 
                                                 class="px-4 py-3 hover:bg-amber-50 hover:text-amber-700 rounded-xl cursor-pointer text-xs font-bold text-gray-700 transition-colors flex items-center justify-between">
                                                <span x-text="cust.name"></span>
                                                <span class="text-[10px] text-gray-400 uppercase tracking-widest">Pilih</span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Nomor Polisi (Plat)</label>
                                <input type="text" name="nopol" value="{{ $vehicle->nopol }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-mono font-black shadow-sm uppercase tracking-widest" required>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Merek</label>
                                    <select name="merk" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm" required>
                                        @foreach(['Toyota', 'Honda', 'Daihatsu', 'Mitsubishi', 'Suzuki', 'Nissan', 'Mazda', 'Hyundai', 'Wuling', 'BMW', 'Lainnya'] as $merk)
                                            <option value="{{ $merk }}" {{ $vehicle->merk == $merk ? 'selected' : '' }}>{{ $merk }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Model / Tipe</label>
                                    <input type="text" name="model" value="{{ $vehicle->model }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm uppercase" required>
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM KANAN --}}
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Warna</label>
                                    <input type="text" name="warna" value="{{ $vehicle->warna }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm" required>
                                </div>
                                <div>
                                    <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Tahun</label>
                                    <input type="number" name="tahun" value="{{ $vehicle->tahun }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Nomor Rangka</label>
                                <input type="text" name="no_rangka" value="{{ $vehicle->no_rangka }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-mono shadow-sm uppercase">
                            </div>

                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Nomor Mesin</label>
                                <input type="text" name="no_mesin" value="{{ $vehicle->no_mesin }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-mono shadow-sm uppercase">
                            </div>
                        </div>
                    </div>

                    {{-- FOOTER ACTION --}}
                    <div class="flex items-center justify-end border-t border-gray-100 pt-6 gap-4">
                        <a href="{{ route('vehicles.index') }}" class="px-6 py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-all border border-transparent">
                            Batal
                        </a>
                        <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-amber-500/30 transform transition hover:-translate-y-1 flex items-center gap-2">
                            Simpan Perubahan
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>