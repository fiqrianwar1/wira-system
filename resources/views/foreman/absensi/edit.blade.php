<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('absensi.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-red-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gray-800 leading-tight">
                    {{ __('✏️ Perbarui Absensi & Job') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Manajemen SDM / <span class="text-amber-600 font-bold uppercase tracking-wider">Update Kehadiran</span></p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- ERROR MESSAGE --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-sm animate-pulse">
                    <p class="font-bold">Gagal Update Data!</p>
                    <ul class="list-disc list-inside text-sm mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-gray-100">
                
                {{-- HEADER EDIT MODE --}}
                <div class="bg-amber-400 px-8 py-8 flex items-center justify-between shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-full bg-yellow-300 skew-x-12 -mr-32 opacity-30"></div>
                    <div class="flex items-center gap-5 relative z-10">
                        <div class="bg-amber-600 p-3 rounded-2xl text-white shadow-inner border border-amber-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-amber-900 tracking-tight">MODE REVISI DATA</h3>
                            <p class="text-amber-800 text-xs font-bold mt-1 uppercase tracking-widest">
                                Personil: {{ $attendance->mechanic->name }}
                            </p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('absensi.update', $attendance->id) }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        
                        {{-- KOLOM KIRI --}}
                        <div class="space-y-6">
                            {{-- TANGGAL --}}
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Tanggal Operasional</label>
                                <input type="date" name="date" value="{{ $attendance->date }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm transition-all cursor-pointer">
                            </div>

                            {{-- MEKANIK --}}
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Personil / Teknisi</label>
                                <div class="relative">
                                    <select name="mechanic_id" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 font-bold shadow-sm transition-all appearance-none cursor-pointer">
                                        @foreach($mechanics as $mechanic)
                                            <option value="{{ $mechanic->id }}" {{ $attendance->mechanic_id == $mechanic->id ? 'selected' : '' }}>
                                                {{ $mechanic->name }} - {{ $mechanic->position }} (Spec: {{ $mechanic->specialist }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></div>
                                </div>
                            </div>

                            {{-- STATUS --}}
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Status Kehadiran</label>
                                <select name="status" id="statusSelect" onchange="toggleJobInput()" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-bold shadow-sm transition-all cursor-pointer">
                                    <option value="Hadir" {{ old('status', $attendance->status) == 'Hadir' ? 'selected' : '' }}>✅ Hadir</option>
                                    <option value="Sakit" {{ old('status', $attendance->status) == 'Sakit' ? 'selected' : '' }}>⚠️ Sakit</option>
                                    <option value="Ijin" {{ old('status', $attendance->status) == 'Ijin' ? 'selected' : '' }}>ℹ️ Ijin</option>
                                    <option value="Alpha" {{ old('status', $attendance->status) == 'Alpha' ? 'selected' : '' }}>❌ Alpha</option>
                                </select>
                            </div>

                            {{-- CATATAN --}}
                            <div>
                                <label class="block text-gray-500 text-[10px] font-black mb-1.5 uppercase tracking-widest">Catatan Opsional</label>
                                <textarea name="note" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block p-3.5 shadow-sm transition-all" rows="3" placeholder="Revisi catatan kehadiran...">{{ $attendance->note }}</textarea>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: JOB AREA --}}
                        <div id="jobArea" class="bg-amber-50/50 rounded-3xl p-6 border border-amber-200 shadow-inner h-fit" style="{{ $attendance->status != 'Hadir' ? 'opacity:0.4; pointer-events:none;' : '' }}">
                            <div class="flex items-center justify-between mb-6 pb-4 border-b border-amber-200">
                                <h4 class="text-amber-900 font-black text-sm uppercase tracking-tight flex items-center gap-2">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    Alokasi SPK Personil
                                </h4>
                            </div>
                            
                            <div id="jobContainer" class="space-y-4">
                                @forelse($attendance->details as $detail)
                                    <div class="flex gap-3 job-row items-center">
                                        <div class="flex-grow relative">
                                            <select name="spk_ids[]" class="appearance-none w-full bg-white border border-gray-300 text-gray-800 py-3.5 px-4 pr-10 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 font-bold text-sm shadow-sm cursor-pointer">
                                                <option value="">-- Pilih Kendaraan --</option>
                                                @foreach($activeSPKs as $spk)
                                                    <option value="{{ $spk->id }}" {{ $detail->work_order_id == $spk->id ? 'selected' : '' }}>
                                                        [{{ $spk->vehicle->nopol }}] {{ $spk->vehicle->merk }} ({{ $spk->repair_type }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></div>
                                        </div>
                                        <button type="button" onclick="removeRow(this)" class="p-3.5 bg-white border border-red-200 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-all shadow-sm group shrink-0">
                                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                @empty
                                    {{-- Block script di bawah yg auto bikin --}}
                                @endforelse
                            </div>

                            <button type="button" onclick="addJobRow()" class="mt-5 w-full py-3.5 border-2 border-dashed border-amber-300 text-amber-700 rounded-xl font-black hover:bg-white hover:border-amber-400 hover:shadow-sm transition-all flex items-center justify-center gap-2 group text-xs uppercase tracking-widest bg-amber-50/50">
                                <svg class="w-4 h-4 group-hover:scale-125 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg> Tambah Pekerjaan
                            </button>
                        </div>
                    </div>

                    {{-- FOOTER ACTION --}}
                    <div class="flex items-center justify-end border-t border-gray-100 pt-8 mt-4 gap-4">
                        <a href="{{ route('absensi.index') }}" class="px-6 py-3.5 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-all text-sm uppercase tracking-widest shadow-sm">
                            Batal
                        </a>
                        <button type="submit" class="px-8 py-3.5 bg-amber-500 hover:bg-amber-600 text-white font-black rounded-xl shadow-lg shadow-amber-500/30 transform transition hover:-translate-y-0.5 flex items-center gap-2 text-sm uppercase tracking-widest">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Perubahan
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

        // Kalau datanya kosong pas load edit
        if(document.getElementById('jobContainer').children.length === 0) addJobRow();

        function addJobRow() {
            const container = document.getElementById('jobContainer');
            const div = document.createElement('div');
            div.className = 'flex gap-3 job-row items-center';
            div.innerHTML = `
                <div class="flex-grow relative">
                    <select name="spk_ids[]" class="appearance-none w-full bg-white border border-gray-300 text-gray-800 py-3.5 px-4 pr-10 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 font-bold text-sm shadow-sm cursor-pointer">${spkOptions}</select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></div>
                </div>
                <button type="button" onclick="removeRow(this)" class="p-3.5 bg-white border border-red-200 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-all shadow-sm group shrink-0"><svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
            `;
            container.appendChild(div);
        }

        function removeRow(btn) {
            btn.parentElement.remove();
        }

        function toggleJobInput() {
            const status = document.getElementById('statusSelect').value;
            const jobArea = document.getElementById('jobArea');
            jobArea.style.opacity = (status === 'Hadir') ? '1' : '0.4';
            jobArea.style.pointerEvents = (status === 'Hadir') ? 'auto' : 'none';
        }
    </script>
</x-app-layout>