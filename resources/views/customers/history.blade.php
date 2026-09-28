<x-app-layout>
    <x-slot name="header">
        <div class="py-1">
            <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                {{ __('✅ Riwayat Perbaikan') }}
            </h2>
            <p class="text-sm text-gray-500 font-bold mt-1">
                Buku Servis Digital / <span class="text-emerald-600 uppercase tracking-wider">Garasi Saya</span>
            </p>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        {{-- TAMBAHAN px-4 BUAT MOBILE PADDING --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER INFO --}}
            <div class="bg-gradient-to-r from-emerald-600 to-teal-500 p-5 sm:p-6 rounded-3xl sm:rounded-[2.5rem] shadow-lg shadow-emerald-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-32 h-full bg-white/10 skew-x-12 transform -translate-x-10 pointer-events-none"></div>
                <div class="relative z-10 text-white w-full sm:w-auto">
                    <h3 class="text-base sm:text-lg font-black uppercase tracking-tight">Catatan Historis Kendaraan</h3>
                    <p class="text-emerald-100 text-[10px] sm:text-xs mt-1 font-medium max-w-sm">Daftar kendaraan Anda yang telah selesai diperbaiki dengan standar kualitas Wira Toyota.</p>
                </div>
                <div class="relative z-10 bg-white/20 backdrop-blur-md text-white px-4 py-2 sm:px-5 sm:py-2.5 rounded-xl text-xs sm:text-sm font-black shadow-inner border border-white/30 flex items-center gap-2 w-full sm:w-auto justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ $histories->count() }} Unit Selesai
                </div>
            </div>

            {{-- LIST RIWAYAT --}}
            <div class="space-y-6 mt-8">
                @forelse($histories as $wo)
                    <div class="bg-white rounded-3xl sm:rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-emerald-100/50 transition-all duration-300 overflow-hidden relative group">
                        
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 sm:w-2 bg-emerald-500"></div>

                        {{-- Header Card --}}
                        <div class="p-5 pl-6 sm:p-6 sm:pl-8 border-b border-gray-50 flex justify-between items-start md:items-center flex-col md:flex-row gap-4">
                            <div>
                                <div class="flex items-center gap-2 sm:gap-3 mb-2 sm:mb-3">
                                    <span class="inline-block bg-black text-white font-mono text-[10px] sm:text-[11px] font-black px-2.5 py-1 sm:px-3 sm:py-1 rounded-md shadow-md tracking-widest border-2 border-gray-300">
                                        {{ $wo->vehicle->nopol ?? '-' }}
                                    </span>
                                    <span class="text-[9px] sm:text-[10px] font-bold text-gray-500 uppercase bg-gray-50 border border-gray-200 px-2 py-1 rounded-md shadow-sm">
                                        {{ $wo->vehicle->model ?? '-' }}
                                    </span>
                                </div>
                                <h4 class="font-black text-gray-800 text-xs sm:text-sm uppercase tracking-tight group-hover:text-emerald-600 transition-colors">NO. SPK: {{ $wo->nomor_spk ?? '-' }}</h4>
                            </div>
                            
                            <div class="text-left md:text-right flex flex-col md:items-end gap-3 w-full md:w-auto">
                                <span class="bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-full text-[9px] sm:text-[10px] font-black uppercase tracking-widest border border-emerald-100 shadow-sm flex items-center gap-1.5 w-fit">
                                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    Selesai Diperbaiki
                                </span>
                                
                                <div class="flex items-center gap-3 sm:gap-5 justify-between w-full md:w-auto mt-1">
                                    <div class="text-left md:text-right">
                                        <p class="text-[8px] sm:text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Tanggal Keluar:</p>
                                        <p class="text-[10px] sm:text-xs font-black text-gray-800 bg-gray-50 px-2 py-1 rounded-md">{{ $wo->updated_at->format('d F Y') }}</p>
                                    </div>
                                    
                                    <a href="{{ route('work-orders.show', $wo->id) }}" target="_blank" class="flex flex-col items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 bg-gray-900 border border-gray-800 text-white hover:bg-emerald-600 hover:border-emerald-500 rounded-xl transition-all shadow-md group/btn">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mb-0.5 text-gray-300 group-hover/btn:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        <span class="text-[8px] sm:text-[9px] font-black uppercase tracking-widest">Invoice</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Body Card --}}
                        <div class="p-5 pl-6 sm:p-6 sm:pl-8">
                            <div class="mb-5 bg-gray-50 p-3 sm:p-4 rounded-2xl border border-gray-100 relative overflow-hidden">
                                <div class="absolute left-0 top-0 w-1 h-full bg-emerald-400"></div>
                                <p class="text-[8px] sm:text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1.5 flex items-center gap-1.5">
                                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                    Keluhan Awal
                                </p>
                                <p class="text-xs sm:text-sm text-gray-700 font-bold italic truncate overflow-hidden">"{{ $wo->keluhan_customer ?? 'Perbaikan Umum' }}"</p>
                            </div>

                            @if($wo->foto_sebelum || $wo->foto_sesudah)
                            <div class="mb-5 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @if($wo->foto_sebelum)
                                <div class="relative group rounded-xl sm:rounded-2xl overflow-hidden border-2 border-gray-100 shadow-sm bg-gray-50">
                                    <img src="{{ asset('storage/' . $wo->foto_sebelum) }}" alt="Sebelum" class="w-full h-28 sm:h-32 object-cover transition-transform duration-500 group-hover:scale-110">
                                    <div class="absolute top-2 left-2 bg-black/60 backdrop-blur-md px-2 py-1 sm:px-2.5 rounded-md">
                                        <span class="text-[7px] sm:text-[8px] font-black text-white uppercase tracking-widest">Sebelum</span>
                                    </div>
                                </div>
                                @endif

                                @if($wo->foto_sesudah)
                                <div class="relative group rounded-xl sm:rounded-2xl overflow-hidden border-2 border-emerald-100 shadow-sm bg-emerald-50">
                                    <img src="{{ asset('storage/' . $wo->foto_sesudah) }}" alt="Sesudah" class="w-full h-28 sm:h-32 object-cover transition-transform duration-500 group-hover:scale-110">
                                    <div class="absolute top-2 left-2 bg-emerald-600/80 backdrop-blur-md px-2 py-1 sm:px-2.5 rounded-md flex items-center gap-1">
                                        <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        <span class="text-[7px] sm:text-[8px] font-black text-white uppercase tracking-widest">Sesudah</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif

                            <div x-data="{ open: false }">
                                <button @click="open = !open" class="flex justify-between items-center w-full text-left bg-white border border-gray-200 hover:border-gray-300 hover:bg-gray-50 p-3 rounded-xl transition-all shadow-sm">
                                    <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-gray-700 flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        Rincian Panel Diperbaiki
                                    </span>
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 transform transition-transform" :class="open ? 'rotate-180 text-gray-800' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                
                                <div x-show="open" class="mt-2 sm:mt-3 grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3" x-transition>
                                    @forelse($wo->details as $detail)
                                        <div class="flex items-center gap-2.5 sm:gap-3 bg-gray-50 p-2.5 sm:p-3 rounded-xl border border-gray-100">
                                            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-white shadow-sm border border-gray-100 flex items-center justify-center text-gray-400 shrink-0">
                                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <div class="truncate">
                                                <p class="text-[10px] sm:text-xs font-black text-gray-800 uppercase tracking-tight truncate">{{ $detail->panel_name }}</p>
                                                <p class="text-[8px] sm:text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Tindakan: <span class="text-emerald-600">{{ $detail->kerusakan }}</span></p>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-[10px] sm:text-xs text-gray-400 italic col-span-1 sm:col-span-2 text-center py-2">Detail rincian panel tidak tersedia.</p>
                                    @endforelse
                                </div>
                            </div>

                            @if($wo->bahanSpks && $wo->bahanSpks->count() > 0)
                            <div x-data="{ openMaterial: false }" class="mt-2 sm:mt-3">
                                <button @click="openMaterial = !openMaterial" class="flex justify-between items-center w-full text-left group bg-gradient-to-r from-gray-900 to-gray-800 p-3 sm:p-3.5 rounded-xl transition-all shadow-md border border-gray-700 hover:border-gray-500">
                                    <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-yellow-400 flex items-center gap-2">
                                        <span class="text-xs sm:text-sm">💎</span> Material Premium Terpakai
                                    </span>
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-yellow-500/50 transform transition-transform" :class="openMaterial ? 'rotate-180 text-yellow-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                
                                <div x-show="openMaterial" class="mt-2 sm:mt-3 space-y-2" x-transition>
                                    @foreach($wo->bahanSpks as $bahan)
                                        <div class="flex justify-between items-center p-3 bg-white border border-gray-200 shadow-sm rounded-xl">
                                            <div class="flex flex-col truncate pr-2">
                                                <span class="font-black text-gray-800 text-[10px] sm:text-xs uppercase truncate">{{ $bahan->bahan->nama_bahan ?? 'Material Standar' }}</span>
                                                <span class="text-[8px] sm:text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">{{ $bahan->bahan->kategori ?? 'Umum' }}</span>
                                            </div>
                                            <div class="bg-gray-900 text-yellow-400 px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-lg text-[9px] sm:text-[10px] font-mono font-black shadow-inner flex items-center gap-1.5 shrink-0">
                                                {{ $bahan->jumlah_pakai }} <span class="opacity-70 text-[8px] sm:text-[9px]">{{ $bahan->bahan->satuan ?? 'Unit' }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 sm:py-24 bg-white rounded-[2rem] border border-gray-100 shadow-sm">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-5 border-4 border-white shadow-sm">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-black text-gray-800 uppercase tracking-tight">Belum Ada Riwayat</h3>
                        <p class="text-xs sm:text-sm text-gray-500 mt-2 max-w-sm mx-auto">Anda belum memiliki riwayat perbaikan yang berstatus selesai.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>