<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('foreman.progress.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 hover:bg-gray-50 hover:text-red-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-black text-2xl text-gray-800 leading-tight">
                    {{ ('⚙️ Plotting Mekanik & Timer') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Operasional / <span class="text-red-600 font-bold">Job Allocation & Efficiency</span></p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 🔴 NOTIFIKASI ERROR --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm animate-pulse flex items-start gap-3">
                    <div class="mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="font-bold">Gagal Update!</p>
                        <ul class="list-disc list-inside text-sm mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- FORM CARD --}}
            <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
                <form action="{{ route('foreman.progress.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="work_order_id" value="{{ $selectedSPK->id }}">

                    <div class="flex flex-col">
                        
                        {{-- HEADER: INFO MOBIL & STATUS UTAMA --}}
                        <div class="p-8 bg-gray-50 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start gap-6">
                            <div>
                                <h1 class="text-4xl font-black text-gray-800 tracking-tight">{{ $selectedSPK->vehicle->nopol }}</h1>
                                <p class="text-xl text-gray-500 font-bold">{{ $selectedSPK->vehicle->merk }} | {{ $selectedSPK->vehicle->warna }}</p>
                            </div>
                            
                            <div class="w-full md:w-64">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Tahapan Sekarang</label>
                                <select name="repair_stage" class="w-full mt-1 bg-white border-2 border-gray-200 rounded-xl font-bold text-gray-700 py-3 px-4 focus:ring-blue-500 focus:border-blue-500 transition-all cursor-pointer hover:border-blue-300">
                                    @foreach(['Menunggu', 'Body Repair', 'Preparation', 'Paint / Oven', 'Poles / Finishing', 'Washing'] as $stg)
                                        <option value="{{ $stg }}" {{ $selectedSPK->repair_stage == $stg ? 'selected' : '' }}>{{ $stg }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- BODY: FORM PLOTTING MEKANIK & TIMER --}}
                        <div class="p-8">
                            <h3 class="font-black text-2xl text-gray-800 mb-2 flex items-center gap-2">
                                <span>Alokasi Waktu & Tim</span>
                                <span class="text-[10px] bg-red-100 text-red-600 px-2 py-1 rounded-lg uppercase tracking-widest border border-red-200">Auto-Calculate</span>
                            </h3>
                            <p class="text-sm text-gray-500 font-bold mb-6">Pantau efisiensi waktu kerja mekanik berdasarkan standar durasi Wira Toyota.</p>
                            
                            <div class="grid grid-cols-1 gap-4">
                                @php
                                    $stages = ['Body', 'Preparation', 'Paint', 'Poles', 'Washing'];
                                    $icons = ['🔨', '🧽', '🔫', '✨', '🚿'];
                                    
                                    $configs = [
                                        ['color' => 'slate', 'spec' => 'Body', 'std' => 5],
                                        ['color' => 'orange', 'spec' => 'Preparation', 'std' => 3],
                                        ['color' => 'indigo', 'spec' => 'Paint', 'std' => 4],
                                        ['color' => 'teal', 'spec' => 'Poles', 'std' => 2],
                                        ['color' => 'cyan', 'spec' => 'Washing', 'std' => 1]
                                    ];
                                @endphp

                                @foreach($stages as $index => $stage)
                                    @php
                                        $key = strtolower($stage);
                                        $alloc = $allocations[$stage] ?? []; 
                                        $savedMekanik = $alloc['mechanic_id'] ?? '';
                                        $conf = $configs[$index];
                                        $requiredSpec = $conf['spec']; 
                                        $color = $conf['color'];
                                        $stdJam = $conf['std'];
                                    @endphp

                                    <div class="bg-white p-2 md:p-3 rounded-2xl border border-gray-200 hover:border-{{$color}}-400 hover:shadow-xl transition-all group flex flex-col md:flex-row items-center gap-0 relative overflow-hidden">
                                        
                                        <div class="flex items-center gap-4 w-full md:w-56 shrink-0 pl-2 py-2 md:py-0">
                                            <div class="w-12 h-12 rounded-full bg-{{$color}}-50 text-{{$color}}-600 flex items-center justify-center text-xl border border-{{$color}}-100 shadow-inner">
                                                {{ $icons[$index] }}
                                            </div>
                                            <div>
                                                <h4 class="font-black text-gray-800 text-base uppercase">{{ $stage }}</h4>
                                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Std: {{ $stdJam }} Jam</span>
                                            </div>
                                        </div>

                                        <div class="flex-1 w-full md:border-l md:border-gray-100 px-4 md:px-6 py-2 md:py-0">
                                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 block">Teknisi Bertugas</label>
                                            <select name="mechanic_{{ $key }}" onchange="if(this.value == '') { document.getElementById('start_{{ $key }}').value = ''; document.getElementById('end_{{ $key }}').value = ''; hitungDurasi('{{ $key }}', {{ $stdJam }}); }" class="w-full bg-gray-50 border-gray-200 rounded-xl text-sm font-bold focus:bg-white focus:ring-{{$color}}-500 focus:border-{{$color}}-500 py-2.5 px-3 cursor-pointer transition-colors shadow-sm">
                                                <option value="">- Pilih Teknisi -</option>
                                                @foreach($mechanics as $mekanik)
                                                    @if($mekanik->specialist == $requiredSpec || $mekanik->id == $savedMekanik)
                                                        <option value="{{ $mekanik->id }}" {{ $savedMekanik == $mekanik->id ? 'selected' : '' }}>
                                                            {{ $mekanik->name }} - {{ $mekanik->position }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="flex flex-col items-center justify-center w-full md:w-72 shrink-0 md:border-l md:border-gray-100 px-4 md:px-6 py-2 md:py-0">
                                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 block w-full text-center">Durasi Kerja</label>
                                            <div class="flex items-center justify-center gap-2 w-full">
                                                <input type="time" id="start_{{ $key }}" name="start_{{ $key }}" value="{{ $alloc['start_time'] ?? '' }}" oninput="hitungDurasi('{{ $key }}', {{ $stdJam }})" class="w-24 bg-white border-gray-200 rounded-lg text-sm font-black text-center focus:ring-{{$color}}-500 shadow-sm">
                                                <span class="font-black text-gray-300">-</span>
                                                <input type="time" id="end_{{ $key }}" name="end_{{ $key }}" value="{{ $alloc['end_time'] ?? '' }}" oninput="hitungDurasi('{{ $key }}', {{ $stdJam }})" class="w-24 bg-white border-gray-200 rounded-lg text-sm font-black text-center focus:ring-{{$color}}-500 shadow-sm">
                                            </div>
                                            
                                            <div class="mt-2 w-full max-w-[210px] text-center bg-gray-50 rounded-md py-1 border border-gray-100" id="durasi_{{ $key }}">
                                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Isi Jam Kerja</span>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>

                            {{-- ========================================================================= --}}
                            {{-- FOTO SESUDAH DENGAN FITUR HAPUS ALPINE.JS --}}
                            {{-- ========================================================================= --}}
                            <div class="mt-8 mb-6 bg-emerald-50/50 p-6 rounded-3xl border border-emerald-100" x-data="{ photoDeleted: false, hasPhoto: {{ $workOrder->foto_sesudah ? 'true' : 'false' }} }">
                                <h3 class="font-black text-emerald-800 text-xs uppercase tracking-widest mb-5 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                    Dokumentasi Final (QC)
                                </h3>

                                {{-- Input Hidden buat trigger Controller hapus foto fisik --}}
                                <input type="hidden" name="hapus_foto_sesudah" :value="photoDeleted ? '1' : '0'">

                                @if($workOrder->foto_sesudah)
                                    <div class="mb-5" x-show="!photoDeleted">
                                        <div class="relative inline-block rounded-xl overflow-hidden border-2 border-emerald-200 shadow-sm group">
                                            <img src="{{ asset('storage/' . $workOrder->foto_sesudah) }}" alt="Foto Sesudah" class="h-32 w-auto object-cover">
                                            
                                            {{-- Tombol Hapus Silang Merah Melayang --}}
                                            <button type="button" @click="photoDeleted = true" class="absolute top-1 right-1 bg-red-600 text-white p-1 rounded-full shadow-lg hover:bg-red-700 transition-all opacity-0 group-hover:opacity-100" title="Hapus Foto">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                        <p class="text-[10px] text-red-500 font-bold mt-2 italic">*Arahkan kursor ke foto, lalu klik tanda silang untuk menghapus</p>
                                    </div>
                                @endif

                                <div>
                                    <label class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-2 block" x-text="photoDeleted || !hasPhoto ? 'Upload Foto Dokumentasi' : 'Ganti Foto'"></label>
                                    <input type="file" name="foto_sesudah" accept="image/*" @change="photoDeleted = false" class="w-full bg-white border border-emerald-200 text-gray-800 text-sm rounded-xl block p-2.5 font-medium shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 cursor-pointer hover:file:bg-emerald-100 transition-colors">
                                </div>
                            </div>

                            {{-- FOOTER TOMBOL SIMPAN --}}
                            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                                <a href="{{ route('foreman.progress.index') }}" class="px-6 py-4 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-all">Batal</a>
                                <button type="submit" class="bg-gray-900 hover:bg-blue-600 text-white font-black py-4 px-10 rounded-xl shadow-lg transition-all transform hover:scale-105 active:scale-95 flex items-center gap-2 tracking-widest uppercase text-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPT SAKTI PENGHITUNG DURASI OTOMATIS --}}
    <script>
        function hitungDurasi(key, stdJam) {
            let start = document.getElementById('start_' + key).value;
            let end = document.getElementById('end_' + key).value;
            let display = document.getElementById('durasi_' + key);

            if(start && end) {
                let startTime = new Date("01/01/2000 " + start);
                let endTime = new Date("01/01/2000 " + end);

                if(endTime < startTime) {
                    endTime.setDate(endTime.getDate() + 1);
                }

                let diffMs = endTime - startTime;
                let diffHrs = Math.floor(diffMs / 3600000);
                let diffMins = Math.round((diffMs % 3600000) / 60000);
                
                let totalJamDecimal = diffHrs + (diffMins / 60);

                let statusHtml = '';
                if(totalJamDecimal <= stdJam) {
                    statusHtml = `<span class="inline-block bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded text-[9px] font-black uppercase border border-emerald-200 shadow-sm ml-1">🔥 EFISIEN</span>`;
                } else {
                    statusHtml = `<span class="inline-block bg-red-100 text-red-700 px-2 py-0.5 rounded text-[9px] font-black uppercase border border-red-200 shadow-sm ml-1">⚠️ OVERTIME</span>`;
                }

                display.innerHTML = `<span class="text-xs font-black text-gray-800">${diffHrs}j ${diffMins}m</span> ${statusHtml}`;
            } else {
                display.innerHTML = `<span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Isi Jam Kerja</span>`;
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            @foreach($stages as $index => $stage)
                hitungDurasi('{{ strtolower($stage) }}', {{ $configs[$index]['std'] }});
            @endforeach
        });
    </script>
</x-app-layout>