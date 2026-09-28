<x-app-layout>
    <x-slot name="header">
        <div class="py-1">
            <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-2">
                {{ __('🛡️ Klaim Garansi') }}
            </h2>
            <p class="text-sm text-gray-500 font-bold mt-1">
                Layanan Purna Jual / <span class="text-rose-600 uppercase tracking-wider">Wira Toyota</span>
            </p>
        </div>
    </x-slot>

    {{-- WRAPPER ALPINE.JS BUAT MODAL --}}
    <div x-data="{ showModal: false, confirmDeleteId: null }" class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER INFO & TOMBOL AJUKAN --}}
            <div class="bg-gray-900 p-6 sm:p-8 rounded-3xl sm:rounded-[2.5rem] shadow-xl shadow-gray-900/20 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 relative overflow-hidden border border-gray-800">
                <div class="absolute right-0 top-0 w-48 h-full bg-red-600/10 skew-x-12 transform -translate-x-10 pointer-events-none"></div>
                <div class="relative z-10 text-white w-full sm:w-auto">
                    <h3 class="text-lg sm:text-xl font-black uppercase tracking-tight">Status Klaim & Komplain</h3>
                    <p class="text-gray-400 text-[10px] sm:text-xs mt-1 font-medium max-w-sm">Garansi pengerjaan Body & Paint berlaku untuk perbaikan cacat pengecatan sesuai ketentuan Wira Toyota.</p>
                </div>
                
                {{-- TOMBOL BUKA MODAL --}}
                <button @click="showModal = true" class="relative z-10 bg-red-600 text-white hover:bg-red-700 px-5 py-3 rounded-xl text-xs sm:text-sm font-black shadow-lg shadow-red-900/50 flex items-center gap-2 w-full sm:w-auto justify-center transition-all hover:scale-105 active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Ajukan Komplain
                </button>
            </div>

            {{-- ALERT SUCCESS (Sudah diseragamkan dengan animasi otomatis) --}}
            @if(session('success'))
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-init="setTimeout(() => show = false, 4000)" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center gap-3 transform transition-all mb-6">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            {{-- ALERT ERROR (Sudah diseragamkan dengan animasi otomatis) --}}
            @if(session('error'))
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-init="setTimeout(() => show = false, 4000)" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="bg-red-500 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center gap-3 transform transition-all mb-6">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-bold">{{ session('error') }}</span>
                </div>
            @endif

            {{-- LIST RIWAYAT KOMPLAIN --}}
            <div class="space-y-6 mt-8">
                @forelse($complaints as $complaint)
                    <div class="bg-white rounded-3xl sm:rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-rose-100/50 transition-all duration-300 overflow-hidden relative group">
                        
                        {{-- Garis Warna Status --}}
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 sm:w-2 
                            {{ $complaint->status == 'menunggu' ? 'bg-amber-400' : ($complaint->status == 'disetujui' ? 'bg-emerald-500' : 'bg-red-500') }}">
                        </div>

                        {{-- Header Card --}}
                        <div class="p-5 pl-6 sm:p-6 sm:pl-8 border-b border-gray-50 flex justify-between items-start md:items-center flex-col md:flex-row gap-4">
                            <div>
                                <div class="flex items-center gap-2 sm:gap-3 mb-2">
                                    <span class="inline-block bg-black text-white font-mono text-[10px] sm:text-[11px] font-black px-2.5 py-1 rounded-md shadow-md tracking-widest border-2 border-gray-300">
                                        {{ $complaint->workOrder->vehicle->nopol ?? '-' }}
                                    </span>
                                    <span class="text-[9px] sm:text-[10px] font-bold text-gray-500 uppercase bg-gray-50 border border-gray-200 px-2 py-1 rounded-md shadow-sm">
                                        SPK: {{ $complaint->workOrder->nomor_spk ?? '-' }}
                                    </span>
                                </div>
                                <h4 class="font-black text-gray-800 text-xs sm:text-sm uppercase tracking-tight">Klaim Diajukan: {{ $complaint->created_at->format('d M Y') }}</h4>
                            </div>
                            
                            {{-- Badge Status & Tombol Batal --}}
                            <div class="text-left md:text-right w-full md:w-auto">
                                @if($complaint->status == 'menunggu')
                                    <div class="flex flex-wrap items-center gap-2 w-fit md:ml-auto">
                                        {{-- TOMBOL BATAL (buka modal konfirmasi custom) --}}
                                        <form id="delete-form-{{ $complaint->id }}" action="{{ route('customer.complaints.destroy', $complaint->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type="button" @click="confirmDeleteId = {{ $complaint->id }}" class="bg-white text-gray-500 hover:text-red-600 hover:bg-red-50 px-3 py-1.5 rounded-full text-[9px] sm:text-[10px] font-black uppercase tracking-widest border border-gray-200 hover:border-red-200 shadow-sm flex items-center gap-1.5 transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Batalkan
                                        </button>
                                        
                                        {{-- BADGE MENUNGGU --}}
                                        <span class="bg-amber-50 text-amber-600 px-3 py-1.5 rounded-full text-[9px] sm:text-[10px] font-black uppercase tracking-widest border border-amber-100 shadow-sm flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            Menunggu SA
                                        </span>
                                    </div>
                                @elseif($complaint->status == 'disetujui')
                                    <span class="bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-full text-[9px] sm:text-[10px] font-black uppercase tracking-widest border border-emerald-100 shadow-sm flex items-center gap-1.5 w-fit md:ml-auto">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        Garansi Disetujui
                                    </span>
                                @else
                                    <div class="flex flex-wrap items-center gap-2 w-fit md:ml-auto">
                                        <form id="delete-form-{{ $complaint->id }}" action="{{ route('customer.complaints.destroy', $complaint->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type="button" @click="confirmDeleteId = {{ $complaint->id }}" class="bg-white text-gray-500 hover:text-red-600 hover:bg-red-50 px-3 py-1.5 rounded-full text-[9px] sm:text-[10px] font-black uppercase tracking-widest border border-gray-200 hover:border-red-200 shadow-sm flex items-center gap-1.5 transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Batalkan
                                        </button>

                                        <span class="bg-red-50 text-red-600 px-3 py-1.5 rounded-full text-[9px] sm:text-[10px] font-black uppercase tracking-widest border border-red-100 shadow-sm flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Klaim Ditolak
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Body Card --}}
                        <div class="p-5 pl-6 sm:p-6 sm:pl-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                            
                            {{-- Foto & Keluhan --}}
                            <div class="md:col-span-2 space-y-4">
                                <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 relative overflow-hidden">
                                    <div class="absolute left-0 top-0 w-1 h-full bg-rose-400"></div>
                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1.5 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                        Deskripsi Kendala
                                    </p>
                                    <p class="text-xs sm:text-sm text-gray-700 font-bold italic">"{{ $complaint->keluhan }}"</p>
                                </div>
                                
                                @if($complaint->catatan_sa)
                                <div class="{{ $complaint->status == 'disetujui' ? 'bg-emerald-50 border-emerald-200' : 'bg-red-50 border-red-200' }} p-4 rounded-2xl border relative overflow-hidden">
                                    <p class="text-[9px] font-black {{ $complaint->status == 'disetujui' ? 'text-emerald-500' : 'text-red-500' }} uppercase tracking-[0.2em] mb-1.5 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Respon Service Advisor
                                    </p>
                                    <p class="text-xs sm:text-sm text-gray-800 font-bold">"{{ $complaint->catatan_sa }}"</p>
                                </div>
                                @endif
                            </div>

                            {{-- Foto Bukti --}}
                            <div>
                                <div class="relative group rounded-xl sm:rounded-2xl overflow-hidden border-2 border-gray-100 shadow-sm bg-gray-50 h-32 sm:h-full min-h-[150px]">
                                    <img src="{{ asset('storage/' . $complaint->foto_bukti) }}" alt="Foto Bukti" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    <div class="absolute top-2 left-2 bg-black/60 backdrop-blur-md px-2 py-1 rounded-md">
                                        <span class="text-[8px] font-black text-white uppercase tracking-widest">Foto Bukti</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="text-center py-16 sm:py-24 bg-white rounded-[2rem] border border-gray-100 shadow-sm">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-sm">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-black text-gray-800 uppercase tracking-tight">Belum Ada Komplain</h3>
                        <p class="text-xs sm:text-sm text-gray-500 mt-2 max-w-sm mx-auto">Riwayat garansi atau komplain kendaraan Anda masih kosong.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- MODAL FORM PENGAJUAN KOMPLAIN (ALPINE JS)                 --}}
        {{-- ========================================================= --}}
        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-[50] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <div x-show="showModal" 
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="showModal = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showModal"
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full border border-gray-100">
                    
                    <div class="bg-gradient-to-r from-gray-900 to-gray-800 px-6 py-5 flex justify-between items-center">
                        <h3 class="text-lg font-black text-white uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Form Pengajuan Garansi
                        </h3>
                        <button @click="showModal = false" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form action="{{ route('customer.complaints.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
                        @csrf
                        
                        <div class="space-y-5">
                            {{-- Pilih SPK --}}
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Pilih Kendaraan / No. SPK</label>
                                <select name="work_order_id" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-red-500 focus:border-red-500 block p-3 font-bold shadow-sm">
                                    <option value="" disabled selected>-- Pilih Riwayat Servis --</option>
                                    @foreach($eligibleSpks as $spk)
                                        <option value="{{ $spk->id }}">{{ $spk->vehicle->nopol }} - SPK: {{ $spk->nomor_spk }} (Selesai: {{ $spk->updated_at->format('d M Y') }})</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Keluhan --}}
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Deskripsi Keluhan</label>
                                <textarea name="keluhan" rows="3" required placeholder="Contoh: Cat di area bemper depan belang / ada bintik debu..." class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-red-500 focus:border-red-500 block p-3 font-medium shadow-sm"></textarea>
                            </div>

                            {{-- Upload Foto --}}
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Upload Foto Bukti</label>
                                <input type="file" name="foto_bukti" required accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest file:bg-red-50 file:text-red-600 hover:file:bg-red-100 transition-all border border-gray-200 rounded-xl bg-gray-50 shadow-sm cursor-pointer">
                                <p class="text-[10px] text-gray-400 mt-2">*Format: JPG/PNG. Maksimal 2MB.</p>
                            </div>
                        </div>

                        <div class="mt-8 pt-5 border-t border-gray-100 flex justify-end gap-3">
                            <button type="button" @click="showModal = false" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-gray-50 transition-colors shadow-sm">
                                Batal
                            </button>
                            <button type="submit" class="px-5 py-2.5 bg-red-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-red-700 transition-colors shadow-lg shadow-red-200 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Kirim Komplain
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- MODAL KONFIRMASI BATALKAN KLAIM (UI IDENTIK SPK)           --}}
        {{-- ========================================================= --}}
        <div x-show="confirmDeleteId !== null" style="display: none;" x-cloak class="fixed inset-0 z-[60] overflow-y-auto whitespace-normal" aria-labelledby="confirm-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                {{-- Background overlay blur gelap ala SPK --}}
                <div x-show="confirmDeleteId !== null"
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="confirmDeleteId = null"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                {{-- Modal Panel --}}
                <div x-show="confirmDeleteId !== null"
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-gray-100">

                    {{-- Konten Atas --}}
                    <div class="bg-white px-8 pt-8 pb-6 text-center">
                        <h3 id="confirm-title" class="text-xl font-black text-gray-900 mb-2">
                            Batalkan pengajuan klaim ini?
                        </h3>
                        <p class="text-sm text-gray-500 italic">
                            Data akan hilang permanen. Yakin?
                        </p>
                    </div>

                    {{-- Tombol Aksi Bawah (Background gray-50) --}}
                    <div class="bg-gray-50 px-8 py-5 flex flex-row-reverse justify-center gap-3 rounded-b-[2rem]">
                        <button type="button"
                                @click="document.getElementById('delete-form-' + confirmDeleteId).submit(); confirmDeleteId = null"
                                class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-md transition-colors w-24">
                            Hapus
                        </button>
                        <button type="button" @click="confirmDeleteId = null" 
                                class="px-6 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-colors w-24">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>