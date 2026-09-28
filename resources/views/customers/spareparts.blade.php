<x-app-layout>
    <x-slot name="header">
        <div class="py-1">
            <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                {{ __('📦 Tracking Suku Cadang') }}
            </h2>
            <p class="text-sm text-gray-500 font-bold mt-1">
                Pantau Pesanan Logistik / <span class="text-indigo-600 uppercase tracking-wider">Garasi Saya</span>
            </p>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        {{-- TAMBAHAN px-4 BUAT MOBILE --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            {{-- HEADER INFO --}}
            <div class="bg-gray-900 p-6 sm:p-8 rounded-3xl sm:rounded-[2.5rem] border border-gray-800 shadow-xl shadow-indigo-900/20 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sm:gap-6 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-64 h-64 bg-indigo-600 rounded-full blur-[80px] opacity-20 pointer-events-none -mt-10 -mr-10"></div>
                <div class="relative z-10 text-white w-full sm:w-auto">
                    <h3 class="text-lg sm:text-xl font-black uppercase tracking-tight">Status Pesanan Berjalan</h3>
                    <p class="text-[10px] sm:text-xs text-gray-400 mt-1 font-medium max-w-sm">Data diperbarui secara real-time dari sistem logistik Wira Toyota.</p>
                </div>
                <div class="relative z-10 bg-indigo-500/20 text-indigo-200 px-4 py-2 sm:px-4 sm:py-2.5 rounded-xl text-[9px] sm:text-[10px] font-black uppercase tracking-widest shadow-inner border border-indigo-400/30 flex items-center gap-2 sm:gap-3 backdrop-blur-md w-full sm:w-auto justify-center">
                    <span class="relative flex h-2 w-2 sm:h-2.5 sm:w-2.5">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 sm:h-2.5 sm:w-2.5 bg-indigo-500"></span>
                    </span>
                    Live Tracking
                </div>
            </div>

            {{-- LIST TRACKING --}}
            <div class="space-y-6 sm:space-y-8 mt-6 sm:mt-8">
                @forelse($trackings as $po)
                    <div class="bg-white rounded-3xl sm:rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-100/50 transition-all duration-300 overflow-hidden relative group">
                        
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 sm:w-2 {{ $po->status == 'Received' ? 'bg-emerald-500' : 'bg-amber-400' }}"></div>

                        <div class="p-5 pl-6 sm:p-6 sm:pl-8 border-b border-gray-50 flex justify-between items-start md:items-center flex-col md:flex-row gap-4 bg-white">
                            <div>
                                <div class="flex items-center gap-2 sm:gap-3 mb-2 sm:mb-3">
                                    <span class="inline-block bg-black text-white font-mono text-[10px] sm:text-[11px] font-black px-2.5 py-1 sm:px-3 sm:py-1 rounded-md shadow-md tracking-widest border-2 border-gray-300">
                                        {{ $po->workOrder->vehicle->nopol ?? '-' }}
                                    </span>
                                    <span class="text-[9px] sm:text-[10px] font-bold text-gray-500 uppercase bg-gray-50 border border-gray-200 px-2 py-1 rounded-md shadow-sm">
                                        {{ $po->workOrder->vehicle->model ?? '-' }}
                                    </span>
                                </div>
                                <h4 class="font-black text-gray-800 text-xs sm:text-sm uppercase tracking-tight group-hover:text-indigo-600 transition-colors">NO. PO: {{ $po->po_number }}</h4>
                            </div>
                            
                            <div class="flex items-center justify-between w-full md:w-auto gap-4 sm:gap-5 border-t border-gray-50 pt-3 sm:pt-0 sm:border-none">
                                <div class="text-left md:text-right">
                                    <p class="text-[8px] sm:text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Tanggal Pesan:</p>
                                    <p class="text-[10px] sm:text-xs font-black text-gray-800 bg-gray-50 px-2 py-1 rounded-md">{{ $po->order_date->format('d M Y') }}</p>
                                </div>
                                
                                <a href="{{ route('spareparts.purchases.print', $po->id) }}" target="_blank" class="flex flex-col items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 bg-white border border-gray-200 text-gray-600 hover:text-indigo-600 hover:border-indigo-300 hover:bg-indigo-50 rounded-xl transition-all shadow-sm group/btn">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mb-0.5 text-gray-400 group-hover/btn:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    <span class="text-[8px] sm:text-[9px] font-black uppercase tracking-widest">Rincian</span>
                                </a>
                            </div>
                        </div>

                        <div class="px-5 py-5 sm:px-8 sm:py-6 bg-gray-50/30">
                            @if($po->status == 'Received')
                                <div class="flex items-center gap-4 sm:gap-5 bg-gradient-to-r from-emerald-500 to-emerald-600 p-4 sm:p-5 rounded-2xl shadow-lg shadow-emerald-200">
                                    <div class="w-10 h-10 sm:w-14 sm:h-14 bg-white/20 text-white rounded-full flex items-center justify-center shadow-inner shrink-0 backdrop-blur-sm border border-white/30">
                                        <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-white uppercase tracking-tight text-sm sm:text-lg">Telah Tiba di Bengkel</h4>
                                        <p class="text-[10px] sm:text-xs text-emerald-100 font-medium mt-0.5 sm:mt-1">Suku cadang siap dipasang oleh mekanik kami.</p>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center gap-4 sm:gap-5 bg-gradient-to-r from-amber-400 to-orange-400 p-4 sm:p-5 rounded-2xl shadow-lg shadow-amber-200">
                                    <div class="w-10 h-10 sm:w-14 sm:h-14 bg-white/20 text-white rounded-full flex items-center justify-center shadow-inner shrink-0 backdrop-blur-sm border border-white/30">
                                        <svg class="w-5 h-5 sm:w-7 sm:h-7 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-white uppercase tracking-tight text-sm sm:text-lg">Dalam Pengiriman</h4>
                                        <p class="text-[10px] sm:text-xs text-amber-50 font-medium mt-0.5 sm:mt-1">Suku cadang sedang dalam perjalanan menuju bengkel.</p>
                                    </div>
                                </div>
                            @endif

                            <div class="mt-6 sm:mt-8">
                                <p class="text-[9px] sm:text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 sm:mb-4 flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2-2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    Daftar Suku Cadang Dipesan:
                                </p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                    @foreach($po->items as $item)
                                        <div class="flex items-center gap-3 sm:gap-4 bg-white border border-gray-100 p-3 sm:p-4 rounded-xl hover:border-indigo-200 hover:shadow-md transition-all">
                                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-indigo-50 text-indigo-600 shadow-inner flex items-center justify-center text-xs sm:text-sm font-black shrink-0 border border-indigo-100">
                                                {{ $item->qty }}<span class="text-[9px] sm:text-[10px] ml-0.5 text-indigo-400">x</span>
                                            </div>
                                            <p class="text-xs sm:text-sm font-black text-gray-800 uppercase tracking-tight truncate">
                                                {{ $item->item_name }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="text-center py-16 sm:py-24 bg-white rounded-[2rem] sm:rounded-[2.5rem] border border-gray-100 shadow-sm">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-5 sm:mb-6 border-4 border-white shadow-sm">
                            <svg class="w-10 h-10 sm:w-12 sm:h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-black text-gray-800 uppercase tracking-tight">Belum Ada Pemesanan</h3>
                        <p class="text-xs sm:text-sm text-gray-500 mt-2 max-w-md mx-auto leading-relaxed px-4">Saat ini kendaraan Anda tidak memiliki suku cadang yang sedang dalam status inden.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>