<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Mekanik - Wira Toyota</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
            @page { size: A4 portrait; margin: 1cm; }
        }
    </style>
</head>
<body class="bg-white p-10 text-gray-900 font-sans text-sm" onload="window.print()">

    {{-- KOP SURAT --}}
    <div class="flex items-center justify-between border-b-2 border-gray-800 pb-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-24 flex-shrink-0">
                 <img src="{{ asset('images/logo-wira.png') }}" alt="Logo Wira Toyota" class="w-full object-contain">
            </div>
            <div>
                <h1 class="text-2xl font-black uppercase tracking-widest text-red-600 leading-none mb-1">WIRA TOYOTA</h1>
                <p class="text-sm font-bold text-gray-800">Body & Paint Specialist</p>
                <p class="text-xs text-gray-600 mt-0.5">Jl. A. Yani Km. 10, Banjarmasin | Telp: (0511) 1234567</p>
            </div>
        </div>
        <div class="text-right">
            <h2 class="text-xl font-bold text-gray-800 uppercase">Data Personil Bengkel</h2>
            <p class="text-xs text-gray-500 mt-1">Tanggal Cetak: <span class="font-mono font-bold text-gray-700">{{ date('d/m/Y') }}</span></p>
        </div>
    </div>

    {{-- TABEL --}}
    <table class="w-full border-collapse border border-gray-400 text-xs">
        <thead>
            <tr class="bg-gray-100 text-gray-800 uppercase tracking-wider font-bold">
                <th class="border border-gray-400 px-2 py-2 text-center w-10">No</th>
                <th class="border border-gray-400 px-3 py-2 text-left">Nama Lengkap</th>
                <th class="border border-gray-400 px-3 py-2 text-center">Jabatan</th>
                <th class="border border-gray-400 px-3 py-2 text-center">Posisi / Spesialis</th>
                <th class="border border-gray-400 px-3 py-2 text-center">No. HP / Kontak</th>
                <th class="border border-gray-400 px-3 py-2 text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mechanics as $index => $mekanik)
            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                <td class="border border-gray-400 px-2 py-2 text-center">{{ $index + 1 }}</td>
                <td class="border border-gray-400 px-3 py-2 font-bold uppercase">{{ $mekanik->name }}</td>
                
                <td class="border border-gray-400 px-3 py-2 text-center">
                    @if($mekanik->position == 'Leader')
                        <span class="font-black text-yellow-600">LEADER</span>
                    @else
                        <span class="text-gray-600">Teknisi</span>
                    @endif
                </td>

                <td class="border border-gray-400 px-3 py-2 text-center">
                    <span class="px-2 py-0.5 rounded border border-gray-300 bg-white font-bold text-gray-700">
                        {{ $mekanik->specialist }}
                    </span>
                </td>
                
                <td class="border border-gray-400 px-3 py-2 text-center font-mono">
                    {{ $mekanik->phone ?? '-' }}
                </td>

                <td class="border border-gray-400 px-3 py-2 text-center">
                    @if($mekanik->is_active)
                        <span class="text-green-700 font-bold">AKTIF</span>
                    @else
                        <span class="text-red-600 font-bold italic">NON-AKTIF</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="mt-12 flex justify-between px-12 break-inside-avoid">
        <div class="text-center w-48">
            <p class="text-xs mb-16">Mengetahui,</p>
            {{-- INI UDAH GW GANTI JADI SUGIANNOR --}}
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