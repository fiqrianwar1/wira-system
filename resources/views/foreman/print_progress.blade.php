<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Sheet - {{ $wo->vehicle->nopol }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
            @page { size: A4; margin: 1cm; }
        }
        body { font-family: sans-serif; }
    </style>
</head>
<body class="bg-white p-10 text-gray-900 text-sm" onload="window.print()">

    {{-- KOP SURAT --}}
    <div class="flex items-center justify-between border-b-2 border-gray-800 pb-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-24 flex-shrink-0">
                 {{-- Logo Opsional --}}
                 <img src="{{ asset('images/logo-wira.png') }}" alt="WIRA" class="w-full object-contain" onerror="this.style.display='none'">
            </div>
            <div>
                <h1 class="text-2xl font-black uppercase tracking-widest text-red-600 leading-none mb-1">WIRA TOYOTA</h1>
                <p class="text-sm font-bold text-gray-800">Body & Paint Specialist</p>
                <p class="text-xs text-gray-600 mt-0.5">Jl. A. Yani Km. 10, Banjarmasin | Telp: (0511) 1234567</p>
            </div>
        </div>
        <div class="text-right">
            <h2 class="text-xl font-bold text-gray-800 uppercase">LEMBAR PERINTAH KERJA</h2>
            <p class="text-xs font-bold text-gray-500 tracking-widest">JOB SHEET MEKANIK</p>
            <p class="text-2xl font-mono font-black text-red-600 mt-1">{{ $wo->nomor_spk }}</p>
        </div>
    </div>

    {{-- DATA KENDARAAN & CUSTOMER --}}
    <div class="grid grid-cols-2 gap-12 mb-8">
        <div>
            <h3 class="font-bold border-b border-gray-300 mb-2 uppercase text-xs tracking-wider text-gray-500">Data Unit (Vehicle)</h3>
            <table class="w-full text-sm">
                <tr>
                    <td class="py-1 w-24 text-gray-500">Nopol</td>
                    <td class="font-black bg-gray-100 px-2 inline-block rounded">{{ $wo->vehicle->nopol }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-500">Model</td>
                    <td class="font-bold">{{ $wo->vehicle->merk }} {{ $wo->vehicle->model }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-500">Warna</td>
                    <td>{{ $wo->vehicle->warna }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-500">Tgl Masuk</td>
                    <td>{{ date('d/m/Y', strtotime($wo->tanggal_masuk)) }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-500">Deadline</td>
                    <td class="text-red-600 font-bold">{{ date('d/m/Y', strtotime($wo->estimasi_selesai)) }}</td>
                </tr>
            </table>
        </div>

        <div>
            <h3 class="font-bold border-b border-gray-300 mb-2 uppercase text-xs tracking-wider text-gray-500">Catatan Pengerjaan</h3>
            <div class="bg-gray-50 p-3 rounded border border-gray-200 h-full">
                <span class="text-xs text-gray-400 uppercase font-bold">Keluhan / Instruksi:</span>
                <p class="italic text-gray-800 font-medium mt-1">"{{ $wo->keluhan_customer ?? '-' }}"</p>
            </div>
        </div>
    </div>

    {{-- TABEL 1: DETAIL PANEL --}}
    <h3 class="font-bold text-sm mb-2 uppercase flex items-center gap-2">
        <span>📍 Area Kerusakan (Panel)</span>
    </h3>
    <table class="w-full border-collapse border border-gray-400 text-sm mb-8">
        <thead>
            <tr class="bg-gray-100 text-gray-800 uppercase tracking-wider font-bold text-xs">
                <th class="border border-gray-400 px-3 py-2 text-center w-12">No</th>
                <th class="border border-gray-400 px-3 py-2 text-left">Nama Panel</th>
                <th class="border border-gray-400 px-3 py-2 text-center">Jenis Kerusakan</th>
                <th class="border border-gray-400 px-3 py-2 text-center">Status Part</th>
            </tr>
        </thead>
        <tbody>
            @foreach($wo->details as $idx => $item)
            <tr>
                <td class="border border-gray-400 px-3 py-2 text-center">{{ $idx + 1 }}</td>
                <td class="border border-gray-400 px-3 py-2 font-bold">{{ $item->panel_name }}</td>
                <td class="border border-gray-400 px-3 py-2 text-center">{{ $item->kerusakan }}</td>
                <td class="border border-gray-400 px-3 py-2 text-center text-xs uppercase">{{ $item->part_status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TABEL 2: ALOKASI MEKANIK (DITAMBAHIN KOLOM EVALUASI EFISIENSI) --}}
    <h3 class="font-bold text-sm mb-2 uppercase flex items-center gap-2">
        <span>👷‍♂️ Alokasi Mekanik & Penanggung Jawab</span>
    </h3>
    <table class="w-full border-collapse border border-gray-400 text-sm mb-8">
        <thead>
            <tr class="bg-gray-800 text-white uppercase tracking-wider font-bold text-xs">
                <th class="border border-gray-800 px-3 py-2 text-left">Tahapan Kerja</th>
                <th class="border border-gray-800 px-3 py-2 text-left">Nama Mekanik (PIC)</th>
                <th class="border border-gray-800 px-3 py-2 text-center">Jam Kerja</th>
                <th class="border border-gray-800 px-3 py-2 text-center">Durasi & Status</th>
                <th class="border border-gray-800 px-3 py-2 text-center w-24">Paraf</th>
            </tr>
        </thead>
        <tbody>
            @php $stages = ['Body', 'Preparation', 'Paint', 'Poles', 'Washing']; @endphp
            @foreach($stages as $stage)
                @php 
                    // FIX BUG 3: Pakai last() biar ngambil data alokasi yang paling baru/update!
                    $alloc = $wo->allocations->where('stage', $stage)->last(); 
                    
                    $durationText = '-';
                    $isEfisien = true;
                    
                    // Konversi standar waktu ke MENIT biar perhitungannya gak ada desimal
                    $stdMenit = 240; // Default 4 jam
                    if(str_contains($stage, 'Body')) $stdMenit = 300; // 5 Jam
                    elseif(str_contains($stage, 'Prep')) $stdMenit = 180; // 3 Jam
                    elseif(str_contains($stage, 'Paint')) $stdMenit = 240; // 4 Jam
                    elseif(str_contains($stage, 'Poles')) $stdMenit = 120; // 2 Jam
                    elseif(str_contains($stage, 'Washing')) $stdMenit = 60; // 1 Jam

                    if($alloc && $alloc->start_time && $alloc->end_time) {
                        $start = \Carbon\Carbon::parse($alloc->start_time);
                        $end = \Carbon\Carbon::parse($alloc->end_time);
                        
                        // FIX BUG 1: Hitung total murni dalam menit dulu, baru dipecah pakai floor()
                        $totalMins = $start->diffInMinutes($end);
                        $jamBulat = floor($totalMins / 60);
                        $sisaMenit = $totalMins % 60;
                        
                        $durationText = "{$jamBulat}j {$sisaMenit}m";
                        
                        // FIX BUG 2: Bandingkan murni total menit kerja dengan standar menit
                        if($totalMins > $stdMenit) {
                            $isEfisien = false;
                        }
                    }
                @endphp
                <tr>
                    <td class="border border-gray-400 px-3 py-3 font-bold uppercase bg-gray-50">{{ $stage }}</td>
                    <td class="border border-gray-400 px-3 py-3 text-sm font-medium">
                        {{-- Safety check biar gak error --}}
                        {{ $alloc && $alloc->mechanic ? $alloc->mechanic->name : '-' }}
                    </td>
                    <td class="border border-gray-400 px-3 py-3 text-center font-mono font-bold text-xs">
                        @if($alloc && $alloc->start_time)
                            {{ date('H:i', strtotime($alloc->start_time)) }} - {{ $alloc->end_time ? date('H:i', strtotime($alloc->end_time)) : '...' }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="border border-gray-400 px-3 py-3 text-center">
                        @if($durationText == '-')
                            <span class="text-gray-400 text-[10px] italic">Tdk Ada</span>
                        @else
                            <div class="font-black text-gray-800 text-xs">{{ $durationText }}</div>
                            @if($isEfisien)
                                <span class="text-[10px] font-black text-green-600 uppercase tracking-widest">Efisien</span>
                            @else
                                <span class="text-[10px] font-black text-red-600 uppercase tracking-widest underline">Overtime</span>
                            @endif
                        @endif
                    </td>
                    <td class="border border-gray-400 px-3 py-3"></td> 
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="mt-12 flex justify-between px-12 break-inside-avoid">
        <div class="text-center w-48">
            <p class="text-xs mb-16">Mengetahui,</p>
            <p class="font-bold border-b border-gray-800 pb-1 uppercase">Bpk. Sugiannor</p>
            <p class="text-xs text-gray-500 mt-1">Kepala Bengkel BP</p>
        </div>
        <div class="text-center w-48">
            <p class="text-xs mb-1">Banjarmasin, {{ date('d F Y') }}</p>
            <p class="text-xs mb-16">Dibuat Oleh,</p>
            <p class="font-bold border-b border-gray-800 pb-1 uppercase">{{ Auth::user()->name }}</p>
            <p class="text-xs text-gray-500 mt-1">Foreman</p>
        </div>
    </div>

    <div class="mt-12 text-center text-[10px] text-gray-400 italic border-t border-gray-200 pt-4">
        Dicetak otomatis oleh Wira System pada {{ date('d/m/Y H:i') }} | Dokumen Internal Bengkel
    </div>

</body>
</html>