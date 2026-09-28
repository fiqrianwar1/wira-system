<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col items-start gap-2">
            <h2 class="font-black text-2xl text-gray-800 leading-tight flex items-center gap-2">
                {{ __('🚗 Garasi Saya') }}
            </h2>
            
            {{-- Badge Member --}}
            <div>
                <span class="px-4 py-1.5 bg-gradient-to-r from-gray-900 to-gray-800 text-white rounded-full text-[10px] font-black tracking-widest shadow-lg border border-gray-700 flex items-center gap-2">
                    <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    MEMBER PRIORITY
                </span>
            </div>
        </div>
    </x-slot>

    @php
        $activeUnits = collect();
        $historyUnits = collect();
        
        if(isset($histories) && $histories->count() > 0) {
            $activeUnits = $histories->filter(function($item) {
                return strtolower($item->status) != 'selesai';
            });
            $historyUnits = $histories->filter(function($item) {
                return strtolower($item->status) == 'selesai';
            });
        }

        // Tarik status klaim garansi customer ini buat section terpisah
        $myComplaints = collect();
        $customerRecord = \App\Models\Customer::where('email', Auth::user()->email)->first();
        if ($customerRecord) {
            $myComplaints = \App\Models\Complaint::with(['workOrder.vehicle'])
                ->whereHas('workOrder.vehicle', function($q) use ($customerRecord) {
                    $q->where('customer_id', $customerRecord->id);
                })
                ->latest()
                ->take(5)
                ->get();
        }
    @endphp

    <div class="relative py-10 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            {{-- WELCOME BANNER --}}
            <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-black rounded-[2rem] sm:rounded-3xl p-6 sm:p-10 shadow-2xl relative overflow-hidden border border-gray-700">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-red-600 rounded-full blur-[80px] opacity-40 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-blue-600 rounded-full blur-[80px] opacity-20 pointer-events-none"></div>
                
                <div class="relative z-10">
                    <h1 class="text-2xl sm:text-4xl font-light text-gray-300 tracking-tight">Halo, <span class="font-black text-white">{{ Auth::user()->name }}</span>!</h1>
                    <p class="text-gray-400 mt-2 font-medium text-xs sm:text-base max-w-lg">Pantau progress perbaikan kendaraan kesayangan Anda secara real-time di fasilitas Wira Toyota Body & Paint.</p>
                </div>
            </div>

            {{-- 1. BAGIAN UNIT SEDANG DIPROSES --}}
            @if($activeUnits->count() > 0)
                <div class="flex items-center gap-3 mb-6 pl-2">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-600"></span>
                    </span>
                    <h3 class="font-black text-gray-800 text-base sm:text-lg uppercase tracking-widest">Sedang Dikerjakan</h3>
                </div>

                <div class="space-y-8">
                    @foreach($activeUnits as $wo)
                        <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-gray-200/60 border border-gray-100 overflow-hidden relative transition-all hover:shadow-2xl">
                            
                            {{-- Header Card --}}
                            <div class="bg-white p-5 sm:p-8 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sm:gap-6">
                                <div class="flex items-start gap-4 sm:gap-5">
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-inner">
                                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 14v2c0 .6.4 1 1 1h2m14 0a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm-10 0a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="inline-block bg-black text-white text-base sm:text-xl font-mono font-bold px-3 py-1 sm:px-4 sm:py-1 rounded-md mb-2 shadow-md border-2 border-gray-300 tracking-widest">
                                            {{ $wo->vehicle->nopol }}
                                        </div>
                                        <h2 class="text-lg sm:text-xl font-black text-gray-900 tracking-tight">{{ $wo->vehicle->merk }} {{ $wo->vehicle->model }}</h2>
                                        <p class="text-gray-400 text-[10px] sm:text-xs font-bold uppercase tracking-widest mt-1 flex items-center gap-2">
                                            <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                            SPK: {{ $wo->nomor_spk }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="w-full sm:w-auto bg-gray-50 sm:bg-transparent p-4 sm:p-0 rounded-2xl border border-gray-100 sm:border-none flex sm:flex-col justify-between sm:justify-start items-center sm:items-end">
                                    <p class="text-[10px] uppercase font-black text-gray-400 tracking-widest mb-0 sm:mb-1">Target Selesai</p>
                                    <p class="text-base sm:text-xl font-black text-emerald-500 tracking-tight flex items-center gap-1.5 sm:gap-2">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ date('d M Y', strtotime($wo->estimasi_selesai)) }}
                                    </p>
                                </div>
                            </div>

                            {{-- BODY CONTENT --}}
                            <div class="p-5 sm:p-8 bg-gray-50/30">
                                
                                {{-- STEPPER VISUAL --}}
                                <div class="mb-10 sm:mb-12">
                                    <h4 class="text-[9px] sm:text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6 sm:mb-8 text-center">Live Progress Perbaikan</h4>
                                    
                                    @php
                                        $stage = $wo->repair_stage ?? 'Menunggu';
                                        $step = 0;
                                        if(str_contains($stage, 'Body') || str_contains($stage, 'Bongkar')) $step = 1;
                                        elseif(str_contains($stage, 'Prep')) $step = 2;
                                        elseif(str_contains($stage, 'Paint') || str_contains($stage, 'Cat')) $step = 3;
                                        elseif(str_contains($stage, 'Poles') || str_contains($stage, 'Finishing')) $step = 4;
                                        elseif(str_contains($stage, 'Washing') || str_contains($stage, 'Cuci') || str_contains($stage, 'QC')) $step = 5;
                                    @endphp

                                    <div class="relative flex justify-between items-center w-full max-w-2xl mx-auto px-1 sm:px-0">
                                        <div class="absolute top-1/2 left-0 w-full h-1 sm:h-1.5 bg-gray-200 -z-10 rounded-full -translate-y-1/2"></div>
                                        <div class="absolute top-1/2 left-0 h-1 sm:h-1.5 bg-gradient-to-r from-red-500 to-red-600 -z-10 rounded-full transition-all duration-1000 -translate-y-1/2 shadow-[0_0_10px_rgba(220,38,38,0.5)]" style="width: {{ $step * 25 }}%"></div>

                                        @foreach(['Body', 'Prep', 'Paint', 'Poles', 'Ready'] as $index => $label)
                                            <div class="flex flex-col items-center gap-1 sm:gap-2.5">
                                                <div class="w-6 h-6 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-[10px] sm:text-sm font-black border-2 sm:border-4 transition-all duration-500
                                                    {{ $step >= ($index + 1) ? 'bg-red-600 border-white text-white scale-110 shadow-lg shadow-red-200' : 'bg-white border-gray-200 text-gray-300' }}">
                                                    @if($step > ($index + 1))
                                                        <svg class="w-3 h-3 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                    @else
                                                        {{ $index + 1 }}
                                                    @endif
                                                </div>
                                                <span class="text-[8px] sm:text-[10px] font-black uppercase tracking-widest {{ $step >= ($index + 1) ? 'text-gray-900' : 'text-gray-400' }} bg-gray-50/80 backdrop-blur-sm px-1">{{ $label }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="text-center mt-6 sm:mt-8">
                                        <span class="inline-flex items-center gap-1.5 sm:gap-2 bg-red-50 text-red-600 px-4 py-2 sm:px-5 sm:py-2.5 rounded-full font-black text-[10px] sm:text-xs border border-red-100 shadow-sm uppercase tracking-widest ring-4 ring-red-50/50">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            Status: {{ $wo->repair_stage }} ({{ $wo->progress }}%)
                                        </span>
                                    </div>
                                </div>

                                {{-- INFO BIAYA & TOMBOL CETAK --}}
                                <div class="bg-gray-900 rounded-2xl p-5 sm:p-6 mb-5 flex flex-col sm:flex-row justify-between items-center gap-4 shadow-lg relative overflow-hidden">
                                    <div class="absolute right-0 bottom-0 opacity-10 pointer-events-none text-white">
                                        <svg class="w-32 h-32 transform translate-x-8 translate-y-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 22h20L12 2zm0 3.8l7.2 14.2H4.8L12 5.8z"/></svg>
                                    </div>
                                    <div class="text-center sm:text-left relative z-10 w-full sm:w-auto border-b border-gray-700 sm:border-none pb-4 sm:pb-0">
                                        <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">Total Biaya Perbaikan</p>
                                        <p class="text-2xl sm:text-3xl font-black text-white tracking-tighter font-mono">Rp {{ number_format($wo->estimasi_biaya, 0, ',', '.') }}</p>
                                    </div>
                                    <a href="{{ route('work-orders.show', $wo->id) }}" target="_blank" class="relative z-10 w-full sm:w-auto px-5 py-3 sm:py-3.5 bg-white hover:bg-red-600 hover:text-white text-gray-900 rounded-xl font-black text-xs uppercase tracking-widest shadow-md transition-all flex items-center justify-center gap-2 group">
                                        <svg class="w-4 h-4 text-red-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        Download Invoice
                                    </a>
                                </div>

                                {{-- DOKUMENTASI FOTO --}}
                                @if($wo->foto_sebelum || $wo->foto_sesudah)
                                <div class="mb-5 bg-white p-4 sm:p-5 rounded-2xl border border-gray-100 shadow-sm">
                                    <h4 class="text-[9px] sm:text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Dokumentasi Kendaraan
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                        @if($wo->foto_sebelum)
                                        <div class="relative group rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                                            <img src="{{ asset('storage/' . $wo->foto_sebelum) }}" alt="Sebelum" class="w-full h-32 sm:h-40 object-cover transition-transform duration-300 group-hover:scale-105">
                                            <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-gray-900/90 to-transparent p-3 pt-8">
                                                <span class="text-[9px] sm:text-[10px] font-black text-white uppercase tracking-widest flex items-center gap-1.5">
                                                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span> Kondisi Awal
                                                </span>
                                            </div>
                                        </div>
                                        @endif
                                        @if($wo->foto_sesudah)
                                        <div class="relative group rounded-xl overflow-hidden border border-emerald-200 shadow-sm">
                                            <img src="{{ asset('storage/' . $wo->foto_sesudah) }}" alt="Sesudah" class="w-full h-32 sm:h-40 object-cover transition-transform duration-300 group-hover:scale-105">
                                            <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-emerald-900/90 to-transparent p-3 pt-8">
                                                <span class="text-[9px] sm:text-[10px] font-black text-emerald-300 uppercase tracking-widest flex items-center gap-1.5">
                                                    <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Hasil Akhir
                                                </span>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    {{-- ACCORDION PANEL --}}
                                    <div x-data="{ open: false }">
                                        <button @click="open = !open" class="flex justify-between items-center w-full text-left group bg-white border border-gray-200 hover:border-gray-300 shadow-sm p-4 rounded-xl transition-all">
                                            <span class="text-[10px] sm:text-xs font-black uppercase tracking-widest text-gray-700 flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                Rincian Panel
                                            </span>
                                            <svg class="w-4 h-4 text-gray-400 transform transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </button>
                                        <div x-show="open" class="mt-2 grid grid-cols-1 gap-2" x-transition>
                                            @forelse($wo->details as $item)
                                                <div class="flex flex-col p-3 bg-gray-50 border border-gray-100 rounded-lg">
                                                    <div class="font-black text-gray-800 text-[10px] sm:text-[11px] uppercase tracking-tight">{{ $item->panel_name }}</div>
                                                    <div class="text-[8px] sm:text-[9px] font-bold text-gray-500 uppercase mt-1 flex items-center gap-1">
                                                        <span class="w-1.5 h-1.5 bg-gray-300 rounded-full"></span>
                                                        Tindakan: <span class="text-red-600">{{ $item->kerusakan }}</span>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-center py-4 text-[10px] text-gray-400 italic bg-gray-50 rounded-lg border border-gray-100">Detail belum diinput.</div>
                                            @endforelse
                                        </div>
                                    </div>

                                    {{-- ACCORDION MATERIAL --}}
                                    <div x-data="{ openMaterial: false }">
                                        <button @click="openMaterial = !openMaterial" class="flex justify-between items-center w-full text-left group bg-gradient-to-r from-gray-900 to-gray-800 border border-gray-700 shadow-md p-4 rounded-xl transition-all">
                                            <span class="text-[10px] sm:text-xs font-black uppercase tracking-widest text-yellow-400 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                                Material Premium
                                            </span>
                                            <svg class="w-4 h-4 text-yellow-500/50 transform transition-transform" :class="openMaterial ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </button>
                                        <div x-show="openMaterial" class="mt-2 space-y-2" x-transition>
                                            @forelse($wo->bahanSpks as $bahan)
                                                <div class="flex justify-between items-center p-3 bg-white border border-gray-200 shadow-sm rounded-lg">
                                                    <div class="flex flex-col">
                                                        <span class="font-black text-gray-800 text-[10px] sm:text-[11px]">{{ $bahan->bahan->nama_bahan ?? 'Material Kosong' }}</span>
                                                        <span class="text-[8px] sm:text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">{{ $bahan->bahan->kategori ?? 'Umum' }}</span>
                                                    </div>
                                                    <div class="bg-yellow-50 text-yellow-700 px-2 py-1 rounded-md border border-yellow-200 text-[9px] sm:text-[10px] font-mono font-black shadow-sm">
                                                        {{ $bahan->jumlah_pakai }} <span class="opacity-70">{{ $bahan->bahan->satuan ?? 'Unit' }}</span>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-center py-4 bg-white rounded-lg border border-gray-200 shadow-sm">
                                                    <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400">Material sedang disiapkan.</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-3xl shadow-sm p-10 sm:p-12 text-center border border-gray-100">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-white shadow-sm">
                        <span class="text-3xl sm:text-4xl">🧘‍♂️</span>
                    </div>
                    <h3 class="font-black text-gray-800 text-lg sm:text-xl uppercase tracking-tight">Garasi Sedang Kosong</h3>
                    <p class="text-gray-500 text-xs sm:text-sm mt-2 max-w-sm mx-auto">Tidak ada kendaraan Anda yang sedang dalam proses perbaikan saat ini.</p>
                </div>
            @endif

            {{-- 2. RIWAYAT SELESAI --}}
            <div class="pt-8 border-t border-gray-200 mt-10">
                @if($historyUnits->count() > 0)
                    <div class="flex items-center gap-2 mb-6 pl-2">
                        <h3 class="font-black text-gray-800 text-base sm:text-lg uppercase tracking-tight">✅ Riwayat Perbaikan</h3>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach($historyUnits as $hist)
                        <div class="bg-white border border-gray-100 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:shadow-lg transition-shadow">
                            
                            <div class="flex items-center gap-4 w-full sm:w-auto">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 flex-shrink-0">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <div class="font-black text-gray-900 text-sm sm:text-base uppercase tracking-tight">{{ $hist->vehicle->nopol }}</div>
                                    <div class="text-[9px] sm:text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">{{ $hist->vehicle->merk }} {{ $hist->vehicle->model }}</div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between w-full sm:w-auto gap-4 border-t border-gray-50 pt-4 sm:pt-0 sm:border-none">
                                <div>
                                    <p class="text-[8px] sm:text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tgl Selesai</p>
                                    <p class="text-[10px] sm:text-xs font-black text-gray-700 bg-gray-50 px-2 py-1 rounded-md">{{ $hist->updated_at->format('d M Y') }}</p>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    {{-- TOMBOL INVOICE LAMA --}}
                                    <a href="{{ route('work-orders.show', $hist->id) }}" target="_blank" class="inline-flex items-center gap-1.5 sm:gap-2 px-3 py-2 sm:px-4 sm:py-2 bg-white border border-gray-200 text-gray-600 hover:text-red-600 hover:border-red-200 rounded-xl text-[10px] sm:text-xs font-black uppercase tracking-widest transition-all shadow-sm">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        Invoice
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- 3. STATUS KLAIM GARANSI (TERPISAH DARI RIWAYAT PERBAIKAN) --}}
            <div class="pt-8 border-t border-gray-200 mt-10">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6 pl-2">
                    <div class="flex items-center gap-2">
                        <span class="text-lg sm:text-xl">🛡️</span>
                        <h3 class="font-black text-gray-800 text-base sm:text-lg uppercase tracking-tight">Status Klaim Garansi</h3>
                    </div>
                    <a href="{{ route('customer.complaints') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-600 text-white hover:bg-red-700 rounded-xl text-[10px] sm:text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-red-200 w-fit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Ajukan / Lihat Semua Klaim
                    </a>
                </div>

                @if($myComplaints->count() > 0)
                    <div class="space-y-4">
                        @foreach($myComplaints as $klaim)
                            <div class="bg-white border border-gray-100 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:shadow-lg transition-shadow relative overflow-hidden">
                                
                                {{-- Warna Border Kiri --}}
                                <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $klaim->status == 'menunggu' ? 'bg-amber-400' : ($klaim->status == 'disetujui' ? 'bg-emerald-500' : 'bg-red-500') }}"></div>

                                <div class="flex items-center gap-4 w-full sm:w-auto pl-2">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400 flex-shrink-0 border border-gray-100">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="font-black text-gray-900 text-sm sm:text-base uppercase tracking-tight">{{ $klaim->workOrder->vehicle->nopol ?? '-' }}</div>
                                        <div class="text-[9px] sm:text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-0.5 line-clamp-1 max-w-[220px]" title="{{ $klaim->keluhan }}">{{ $klaim->keluhan }}</div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between w-full sm:w-auto gap-4 border-t border-gray-50 pt-4 sm:pt-0 sm:border-none pl-2 sm:pl-0">
                                    <div>
                                        <p class="text-[8px] sm:text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Diajukan</p>
                                        <p class="text-[10px] sm:text-xs font-black text-gray-700 bg-gray-50 px-2 py-1 rounded-md">{{ $klaim->created_at->format('d M Y') }}</p>
                                    </div>

                                    @if($klaim->status == 'menunggu')
                                        <span class="bg-amber-50 text-amber-600 px-3 py-1.5 rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest border border-amber-100 shadow-sm flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            Menunggu SA
                                        </span>
                                    @elseif($klaim->status == 'disetujui')
                                        <span class="bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest border border-emerald-100 shadow-sm flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            Disetujui
                                        </span>
                                    @else
                                        <span class="bg-red-50 text-red-600 px-3 py-1.5 rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest border border-red-100 shadow-sm flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Ditolak
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 sm:p-10 text-center">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-sm">
                            <svg class="w-8 h-8 sm:w-9 sm:h-9 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h3 class="font-black text-gray-800 text-sm sm:text-base uppercase tracking-tight">Belum Ada Klaim Garansi</h3>
                        <p class="text-gray-500 text-xs sm:text-sm mt-1 max-w-sm mx-auto">Kalau ada kendala pada hasil servis, ajukan klaim garansi lewat tombol di atas.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- WA FLOATING BUTTON --}}
    <a href="https://wa.me/6281943314448?text={{ urlencode('Halo SA Wira Toyota, saya ingin menanyakan progres status perbaikan mobil saya saat ini. Terima kasih!') }}" target="_blank" class="absolute bottom-4 right-4 sm:bottom-6 sm:right-6 bg-green-500 hover:bg-green-600 text-white p-3 sm:p-4 rounded-full shadow-2xl shadow-green-200/50 flex items-center justify-center transition-all hover:scale-110 hover:-translate-y-1 z-50 group">
        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133-.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.885-9.885 9.885m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        <span class="absolute right-full mr-4 bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none hidden sm:block">Hubungi SA Anda</span>
    </a>
</x-app-layout>