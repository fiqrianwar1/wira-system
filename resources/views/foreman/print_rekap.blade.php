<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kinerja Teknisi - {{ date('F Y', mktime(0, 0, 0, $bulan, 10)) }}</title>
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
            <h2 class="text-xl font-bold text-gray-800 uppercase">LAPORAN BULANAN</h2>
            <p class="text-xs font-bold text-gray-500 tracking-widest">PRODUKTIVITAS TEKNISI</p>
            <p class="text-xl font-mono font-black text-red-600 mt-1">{{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}</p>
        </div>
    </div>

    @php
        $totalAktif = $mechanics->count();
        $totalSpkSemua = 0;
        foreach($mechanics as $m) {
            $totalSpkSemua += $m->allocations->count();
        }
    @endphp

    {{-- RINGKASAN DATA --}}
    <div class="grid grid-cols-2 gap-12 mb-8">
        <div>
            <h3 class="font-bold border-b border-gray-300 mb-2 uppercase text-xs tracking-wider text-gray-500">Informasi Dokumen</h3>
            <table class="w-full text-sm">
                <tr>
                    <td class="py-1 w-32 text-gray-500">Periode Data</td>
                    <td class="font-bold uppercase">{{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-500">Dicetak Oleh</td>
                    <td class="font-bold">{{ Auth::user()->name }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-500">Waktu Cetak</td>
                    <td>{{ date('d/m/Y H:i') }} WITA</td>
                </tr>
            </table>
        </div>

        <div>
            <h3 class="font-bold border-b border-gray-300 mb-2 uppercase text-xs tracking-wider text-gray-500">Ringkasan Pengerjaan</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-100 p-2 rounded text-center border border-gray-200">
                    <span class="text-xs text-gray-500 block uppercase font-bold">Teknisi Aktif</span>
                    <span class="text-lg font-black">{{ $totalAktif }} <span class="text-xs font-normal text-gray-500">Orang</span></span>
                </div>
                <div class="bg-red-50 p-2 rounded text-center border border-red-200">
                    <span class="text-xs text-red-600 block uppercase font-bold">Total Tahapan Selesai</span>
                    <span class="text-lg font-black text-red-700">
                        {{ $totalSpkSemua }} <span class="text-xs font-normal text-red-500">Tahapan</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL DATA KINERJA --}}
    <h3 class="font-bold text-sm mb-2 uppercase flex items-center gap-2">
        <span>📋 Rincian Pekerjaan Per Teknisi</span>
    </h3>
    <table class="w-full border-collapse border border-gray-400 text-sm mb-8">
        <thead>
            <tr class="bg-gray-800 text-white uppercase tracking-wider font-bold text-[10px]">
                <th class="border border-gray-800 px-3 py-2 text-center w-10">No</th>
                <th class="border border-gray-800 px-3 py-2 text-left w-48">Nama Teknisi</th>
                <th class="border border-gray-800 px-3 py-2 text-center w-24">Spesialis</th>
                <th class="border border-gray-800 px-3 py-2 text-center w-20">Total Tahapan</th>
                <th class="border border-gray-800 px-3 py-2 text-left">Daftar Pekerjaan Selesai (Nopol | Tahap | Tanggal)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mechanics as $idx => $mekanik)
            @php $jml = $mekanik->allocations->count(); @endphp
            <tr>
                <td class="border border-gray-400 px-3 py-2 text-center align-top">{{ $idx + 1 }}</td>
                <td class="border border-gray-400 px-3 py-2 align-top">
                    <div class="font-bold uppercase">{{ $mekanik->name }}</div>
                    <div class="text-[10px] text-gray-500">{{ $mekanik->position }}</div>
                </td>
                <td class="border border-gray-400 px-3 py-2 text-center text-xs uppercase align-top">
                    {{ $mekanik->specialist }}
                </td>
                <td class="border border-gray-400 px-3 py-2 text-center font-black align-top">
                    {{ $jml }}
                </td>
                
                {{-- LIST PEKERJAAN (MULTI SPK) --}}
                <td class="border border-gray-400 px-3 py-2 align-top">
                    @if($jml > 0)
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($mekanik->allocations as $alloc)
                                <div class="text-[10px]">
                                    <span class="font-black border border-gray-800 px-1 rounded bg-gray-100 uppercase tracking-widest">
                                        {{ $alloc->workOrder->vehicle->nopol ?? '-' }}
                                    </span>
                                    <span class="text-gray-600">
                                        - Tahap: <span class="font-bold">{{ $alloc->stage }}</span> ({{ \Carbon\Carbon::parse($alloc->end_time)->format('d/m') }})
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <span class="text-gray-400 italic text-[10px]">Tidak ada pekerjaan selesai di periode ini.</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="border border-gray-400 px-3 py-4 text-center text-gray-500 italic">Belum ada data teknisi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- FOOTER TANDA TANGAN --}}
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
        Dicetak otomatis oleh Wira System pada {{ date('d/m/Y H:i') }} | Dokumen Internal Bengkel Wira Toyota
    </div>

</body>
</html>