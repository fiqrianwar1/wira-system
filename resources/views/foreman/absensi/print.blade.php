<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Harian - {{ date('d-m-Y', strtotime($date)) }}</title>
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
                 <img src="{{ asset('images/logo-wira.png') }}" alt="WIRA" class="w-full object-contain" onerror="this.style.display='none'">
            </div>
            <div>
                <h1 class="text-2xl font-black uppercase tracking-widest text-red-600 leading-none mb-1">WIRA TOYOTA</h1>
                <p class="text-sm font-bold text-gray-800">Body & Paint Specialist</p>
                <p class="text-xs text-gray-600 mt-0.5">Jl. A. Yani Km. 10, Banjarmasin | Telp: (0511) 1234567</p>
            </div>
        </div>
        <div class="text-right">
            <h2 class="text-xl font-bold text-gray-800 uppercase">LAPORAN HARIAN</h2>
            <p class="text-xs font-bold text-gray-500 tracking-widest">ABSENSI & PRODUKTIFITAS</p>
            <p class="text-xl font-mono font-black text-red-600 mt-1">{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</p>
        </div>
    </div>

    {{-- RINGKASAN DATA --}}
    <div class="grid grid-cols-2 gap-12 mb-8">
        <div>
            <h3 class="font-bold border-b border-gray-300 mb-2 uppercase text-xs tracking-wider text-gray-500">Informasi Hari</h3>
            <table class="w-full text-sm">
                <tr>
                    <td class="py-1 w-32 text-gray-500">Hari / Tanggal</td>
                    <td class="font-bold uppercase">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-500">Dicetak Oleh</td>
                    <td class="font-bold">{{ Auth::user()->name }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-500">Waktu Cetak</td>
                    <td>{{ date('H:i:s') }} WITA</td>
                </tr>
            </table>
        </div>

        <div>
            <h3 class="font-bold border-b border-gray-300 mb-2 uppercase text-xs tracking-wider text-gray-500">Ringkasan Kehadiran</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-100 p-2 rounded text-center border border-gray-200">
                    <span class="text-xs text-gray-500 block uppercase font-bold">Total Personil</span>
                    <span class="text-lg font-black">{{ $attendances->count() }}</span>
                </div>
                <div class="bg-green-50 p-2 rounded text-center border border-green-200">
                    <span class="text-xs text-green-600 block uppercase font-bold">Hadir</span>
                    <span class="text-lg font-black text-green-700">
                        {{ $attendances->where('status', 'Hadir')->count() }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL DATA --}}
    <h3 class="font-bold text-sm mb-2 uppercase flex items-center gap-2">
        <span>📋 Detail Absensi & Pekerjaan (Job)</span>
    </h3>
    <table class="w-full border-collapse border border-gray-400 text-sm mb-8">
        <thead>
            <tr class="bg-gray-800 text-white uppercase tracking-wider font-bold text-xs">
                <th class="border border-gray-800 px-3 py-2 text-center w-12">No</th>
                <th class="border border-gray-800 px-3 py-2 text-left">Nama Personil</th>
                <th class="border border-gray-800 px-3 py-2 text-center w-24">Spesialis</th>
                <th class="border border-gray-800 px-3 py-2 text-center w-24">Status</th>
                <th class="border border-gray-800 px-3 py-2 text-left">Unit / Pekerjaan (SPK)</th>
                <th class="border border-gray-800 px-3 py-2 text-left w-32">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $idx => $absen)
            <tr>
                <td class="border border-gray-400 px-3 py-2 text-center">{{ $idx + 1 }}</td>
                <td class="border border-gray-400 px-3 py-2">
                    <div class="font-bold">{{ $absen->mechanic->name }}</div>
                </td>
                <td class="border border-gray-400 px-3 py-2 text-center text-xs uppercase">
                    {{ $absen->mechanic->specialist }}
                </td>
                <td class="border border-gray-400 px-3 py-2 text-center font-bold">
                    @if($absen->status == 'Hadir')
                        Hadir
                    @elseif($absen->status == 'Sakit')
                        <span class="text-yellow-600">Sakit</span>
                    @elseif($absen->status == 'Ijin')
                        <span class="text-blue-600">Ijin</span>
                    @else
                        <span class="text-red-600">Alpha</span>
                    @endif
                </td>
                
                {{-- LIST PEKERJAAN (MULTI SPK) --}}
                <td class="border border-gray-400 px-3 py-2">
                    @forelse($absen->details as $detail)
                        <div class="mb-2 pb-1 border-b border-gray-200 last:border-0 last:mb-0 last:pb-0">
                            
                            {{-- NO SPK --}}
                            <div class="text-[10px] text-gray-500 font-bold">
                                SPK #{{ $detail->workOrder->id }}
                            </div>

                            {{-- PLAT & MERK --}}
                            <div class="flex items-center gap-1">
                                <span class="font-black text-xs border border-gray-800 px-1 rounded bg-gray-100">
                                    {{ $detail->workOrder->vehicle->nopol ?? '-' }}
                                </span>
                                <span class="text-xs uppercase">
                                    - {{ $detail->workOrder->vehicle->merk ?? '' }}
                                </span>
                            </div>
                            
                            {{-- JENIS PERBAIKAN --}}
                            <div class="text-[10px] italic text-gray-500 mt-0.5">
                                Job: {{ $detail->workOrder->repair_type }}
                            </div>
                        </div>
                    @empty
                        <span class="text-gray-400 italic text-xs">-</span>
                    @endforelse
                </td>

                <td class="border border-gray-400 px-3 py-2 text-xs italic">
                    {{ $absen->note }}
                </td>
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