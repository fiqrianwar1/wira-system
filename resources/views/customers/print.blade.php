<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Customer - Wira Toyota</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none; }
            @page { size: A4; margin: 1cm; }
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
            <h2 class="text-xl font-bold text-gray-800 uppercase tracking-widest">Laporan Customer</h2>
            <p class="text-xs text-gray-500 mt-1">Periode Cetak: <span class="font-mono font-bold text-gray-800">{{ date('d M Y') }}</span></p>
        </div>
    </div>

    {{-- TABEL DATA --}}
    <table class="w-full border-collapse border border-gray-400 text-xs mb-8">
        <thead>
            <tr class="bg-gray-100 text-gray-800 uppercase tracking-wider font-bold">
                <th class="border border-gray-400 px-3 py-3 text-center w-10">No</th>
                <th class="border border-gray-400 px-3 py-3 text-left">Nama Customer</th>
                <th class="border border-gray-400 px-3 py-3 text-left">No. Telepon / WA</th>
                <th class="border border-gray-400 px-3 py-3 text-left">Email</th>
                <th class="border border-gray-400 px-3 py-3 text-left">Alamat</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-300">
            @foreach($customers as $index => $customer)
            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                <td class="border border-gray-400 px-3 py-2 text-center">{{ $index + 1 }}</td>
                <td class="border border-gray-400 px-3 py-2 font-bold text-gray-900">{{ $customer->name }}</td>
                <td class="border border-gray-400 px-3 py-2 font-mono">{{ $customer->phone }}</td>
                <td class="border border-gray-400 px-3 py-2 text-gray-600">{{ $customer->email ?? '-' }}</td>
                <td class="border border-gray-400 px-3 py-2 text-gray-600">{{ $customer->address }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TANDA TANGAN (Disamain pake format bengkel yg udah bener kemaren) --}}
    <div class="mt-12 flex justify-between px-12 break-inside-avoid">
        <div class="text-center w-48">
            <p class="text-xs mb-16 text-gray-600">Mengetahui / Disetujui Oleh,</p>
            <p class="font-bold border-b border-gray-800 pb-1 text-gray-900 uppercase">Bpk. Sugiannor</p>
            <p class="text-[10px] text-gray-500 mt-1 font-bold">Kepala Bengkel Wira</p>
        </div>
        <div class="text-center w-48">
            <p class="text-xs mb-1 text-gray-600">Banjarmasin, {{ date('d F Y') }}</p>
            <p class="text-xs mb-16 text-gray-600">Dibuat Oleh,</p>
            <p class="font-bold border-b border-gray-800 pb-1 text-gray-900 uppercase">{{ Auth::user()->name }}</p>
            <p class="text-[10px] text-gray-500 mt-1 font-bold">Service Advisor</p>
        </div>
    </div>

    <div class="mt-12 text-center text-[10px] text-gray-400 italic border-t border-gray-200 pt-4">
        Dicetak otomatis oleh Wira System pada {{ date('d/m/Y H:i') }} | Dokumen Internal Bengkel
    </div>

</body>
</html>