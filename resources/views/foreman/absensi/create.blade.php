<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('absensi.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-red-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gray-800 leading-tight">
                    {{ __('✨ Input Absensi & Job Baru') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Manajemen SDM / <span class="text-blue-600 font-bold uppercase tracking-wider">Catat Kehadiran</span></p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ERROR MESSAGE --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-sm animate-pulse">
                    <p class="font-bold">Gagal Menyimpan Data!</p>
                    <ul class="list-disc list-inside text-sm mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-gray-100">
                
                {{-- FORM HEADER --}}
                <div class="bg-gray-900 px-8 py-8 border-b border-gray-800 flex items-center gap-4 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-full bg-blue-600 skew-x-12 -mr-32 opacity-20"></div>
                    <div class="bg-blue-600 p-3 rounded-xl text-white shadow-lg relative z-10 border border-blue-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-xl font-black text-white tracking-tight">Catat Kehadiran & Pekerjaan</h3>
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Isi data mekanik dengan teliti.</p>
                    </div>
                </div>

                <form action="{{ route('absensi.store') }}" method="POST" class="p-8">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                        
                        {{-- KIRI: DATA PERSONIL & STATUS --}}
                        <div class="space-y-6 bg-gray-50/50 p-6 rounded-3xl border border-gray-100 h-fit">
                            <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4 border-b border-gray-200 pb-2">Informasi Personil</h4>
                            
                            {{-- TANGGAL --}}
                            <div>
                                <label class="block text-gray-600 text-[10px] font-black mb-1.5 uppercase tracking-widest">Tanggal Operasional</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <input type="date" name="date" value="{{ date('Y-m-d') }}" class="pl-12 w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold shadow-sm transition-all">
                                </div>
                            </div>

                            {{-- MEKANIK --}}
                            <div>
                                <label class="block text-gray-600 text-[10px] font-black mb-1.5 uppercase tracking-widest">Pilih Personil Lapangan</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <select name="mechanic_id" class="pl-12 w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold shadow-sm transition-all appearance-none cursor-pointer">
                                        <option value="">-- Cari / Pilih Personil --</option>
                                        @foreach($mechanics as $mechanic)
                                            <option value="{{ $mechanic->id }}">
                                                {{ $mechanic->name }} [{{ $mechanic->specialist }}]
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></div>
                                </div>
                            </div>

                            {{-- STATUS --}}
                            <div>
                                <label class="block text-gray-600 text-[10px] font-black mb-1.5 uppercase tracking-widest">Kehadiran Harian</label>
                                <select name="status" id="statusSelect" onchange="toggleJobInput()" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold shadow-sm transition-all cursor-pointer">
                                    <option value="Hadir">✅ Hadir</option>
                                    <option value="Sakit">⚠️ Sakit</option>
                                    <option value="Ijin">ℹ️ Ijin</option>
                                    <option value="Alpha">❌ Alpha</option>
                                </select>
                            </div>

                            {{-- CATATAN --}}
                            <div>
                                <label class="block text-gray-600 text-[10px] font-black mb-1.5 uppercase tracking-widest">Catatan Opsional</label>
                                <textarea name="note" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 shadow-sm transition-all" rows="2" placeholder="Ketikan alasan absen atau kendala kerja..."></textarea>
                            </div>
                        </div>

                        {{-- KANAN: ALOKASI PEKERJAAN --}}
                        <div id="jobArea" class="space-y-6">
                            <div class="bg-blue-50/50 p-6 rounded-3xl border border-blue-100 shadow-inner h-full">
                                <div class="flex items-center justify-between mb-6 pb-4 border-b border-blue-100">
                                    <h4 class="text-blue-900 font-black text-sm uppercase tracking-tight flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        Alokasi Pekerjaan SPK
                                    </h4>
                                    <span class="bg-blue-100 text-blue-800 text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded-md border border-blue-200 shadow-sm">Multi-Select</span>
                                </div>
                                
                                <div id="jobContainer" class="space-y-4">
                                    {{-- Baris Pertama Input SPK --}}
                                    <div class="flex gap-3 job-row items-center">
                                        <div class="flex-grow relative">
                                            <select name="spk_ids[]" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-3.5 px-4 pr-10 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 font-bold text-sm shadow-sm cursor-pointer">
                                                <option value="">-- Pilih Kendaraan (SPK) --</option>
                                                @foreach($activeSPKs as $spk)
                                                    <option value="{{ $spk->id }}">
                                                        [{{ $spk->vehicle->nopol }}] {{ $spk->vehicle->merk }} ({{ $spk->repair_type }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </div>
                                        </div>
                                        <button type="button" onclick="removeRow(this)" class="p-3.5 bg-white border border-red-200 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-all shadow-sm group shrink-0" title="Hapus Baris">
                                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </div>

                                <button type="button" onclick="addJobRow()" class="mt-5 w-full py-3.5 border-2 border-dashed border-blue-300 text-blue-600 rounded-xl font-black hover:bg-white hover:border-blue-400 hover:shadow-sm transition-all flex items-center justify-center gap-2 group text-xs uppercase tracking-widest bg-blue-50/50">
                                    <svg class="w-4 h-4 group-hover:scale-125 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                    Tambah Pekerjaan
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- FOOTER ACTION --}}
                    <div class="flex items-center justify-end border-t border-gray-100 pt-8 mt-4 gap-4">
                        <a href="{{ route('absensi.index') }}" class="px-6 py-3.5 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-all text-sm uppercase tracking-widest shadow-sm">
                            Batal
                        </a>
                        <button type="submit" class="px-8 py-3.5 bg-gray-900 hover:bg-blue-600 text-white font-black rounded-xl shadow-lg transform transition hover:-translate-y-0.5 flex items-center gap-2 text-sm uppercase tracking-widest">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Absensi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        const spkOptions = `
            <option value="">-- Pilih Kendaraan (SPK) --</option>
            @foreach($activeSPKs as $spk)
                <option value="{{ $spk->id }}">
                    [{{ $spk->vehicle->nopol }}] {{ $spk->vehicle->merk }} ({{ $spk->repair_type }})
                </option>
            @endforeach
        `;

        function addJobRow() {
            const container = document.getElementById('jobContainer');
            const div = document.createElement('div');
            div.className = 'flex gap-3 job-row items-center';
            div.innerHTML = `
                <div class="flex-grow relative">
                    <select name="spk_ids[]" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-3.5 px-4 pr-10 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 font-bold text-sm shadow-sm cursor-pointer">
                        ${spkOptions}
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                <button type="button" onclick="removeRow(this)" class="p-3.5 bg-white border border-red-200 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-all shadow-sm group shrink-0">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            `;
            container.appendChild(div);
        }

        function removeRow(btn) {
            const rows = document.querySelectorAll('.job-row');
            if (rows.length > 1) {
                btn.parentElement.remove();
            } else {
                btn.parentElement.querySelector('select').value = "";
            }
        }

        function toggleJobInput() {
            const status = document.getElementById('statusSelect').value;
            const jobArea = document.getElementById('jobArea');
            jobArea.style.opacity = (status === 'Hadir') ? '1' : '0.4';
            jobArea.style.pointerEvents = (status === 'Hadir') ? 'auto' : 'none';
        }
    </script>
</x-app-layout>