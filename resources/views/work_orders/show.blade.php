<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK - {{ $workOrder->nomor_spk }}</title>
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

    <div class="flex items-center justify-between border-b-2 border-gray-800 pb-4 mb-8">
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
            <h2 class="text-xl font-bold text-gray-800 uppercase tracking-widest">Surat Perintah Kerja</h2>
            <p class="text-2xl font-mono font-black text-red-600 mt-1">{{ $workOrder->nomor_spk }}</p>
            <p class="text-xs text-gray-500 mt-1">Tanggal Masuk: <span class="font-bold text-gray-800">{{ date('d F Y', strtotime($workOrder->tanggal_masuk)) }}</span></p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-12 mb-8">
        <div>
            <h3 class="font-bold border-b border-gray-300 mb-2 uppercase text-xs tracking-wider text-gray-500">Data Pemilik (Customer)</h3>
            <table class="w-full text-sm">
                <tr><td class="py-1 w-24 text-gray-500">Nama</td><td class="font-bold uppercase">{{ $workOrder->vehicle->customer->name ?? '-' }}</td></tr>
                <tr><td class="py-1 text-gray-500">Telepon</td><td>{{ $workOrder->vehicle->customer->phone ?? '-' }}</td></tr>
                <tr><td class="py-1 text-gray-500">Alamat</td><td>{{ $workOrder->vehicle->customer->address ?? '-' }}</td></tr>
            </table>
        </div>

        <div>
            <h3 class="font-bold border-b border-gray-300 mb-2 uppercase text-xs tracking-wider text-gray-500">Data Kendaraan (Vehicle)</h3>
            <table class="w-full text-sm">
                <tr><td class="py-1 w-24 text-gray-500">No. Polisi</td><td class="font-black bg-gray-100 px-2 inline-block rounded border border-gray-200">{{ $workOrder->vehicle->nopol ?? '-' }}</td></tr>
                <tr><td class="py-1 text-gray-500">Unit</td><td class="font-bold uppercase">{{ $workOrder->vehicle->merk ?? '' }} {{ $workOrder->vehicle->model ?? '' }}</td></tr>
                <tr><td class="py-1 text-gray-500">Kategori</td><td class="font-bold uppercase italic {{ $workOrder->repair_type == 'Quick Repair' ? 'text-red-600' : 'text-gray-800' }}">{{ $workOrder->repair_type ?? '-' }}</td></tr>
            </table>
        </div>
    </div>

    @if($workOrder->keluhan_customer)
    <div class="mb-8 bg-gray-50 p-4 rounded border border-gray-200">
        <h3 class="font-bold text-xs uppercase tracking-wider mb-1 text-gray-500">Catatan / Keluhan Awal:</h3>
        <p class="italic text-gray-800">{{ $workOrder->keluhan_customer }}</p>
    </div>
    @endif

    {{-- TABEL 1: JASA PERBAIKAN --}}
    <h3 class="font-bold text-sm mb-2 uppercase text-gray-800">Rincian Jasa Perbaikan</h3>
    <table class="w-full border-collapse border border-gray-400 text-sm mb-8">
        <thead>
            <tr class="bg-gray-100 text-gray-800 uppercase tracking-wider font-bold text-xs">
                <th class="border border-gray-400 px-3 py-2 text-center w-12">No</th>
                <th class="border border-gray-400 px-3 py-2 text-left">Panel / Pengerjaan</th>
                <th class="border border-gray-400 px-3 py-2 text-center">Kode</th>
                <th class="border border-gray-400 px-3 py-2 text-right">Biaya (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($workOrder->details as $idx => $item)
            <tr>
                <td class="border border-gray-400 px-3 py-2 text-center">{{ $idx + 1 }}</td>
                <td class="border border-gray-400 px-3 py-2 font-bold">{{ $item->panel_name }}</td>
                <td class="border border-gray-400 px-3 py-2 text-center">{{ $item->kerusakan }}</td>
                <td class="border border-gray-400 px-3 py-2 text-right font-mono">{{ number_format($item->harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            
            {{-- INFO DISKON JIKA ADA --}}
            @if($workOrder->diskon > 0)
            <tr class="bg-gray-50 font-bold">
                <td colspan="3" class="border border-gray-400 px-3 py-2 text-right uppercase tracking-wider text-xs text-gray-500">Potongan Diskon</td>
                <td class="border border-gray-400 px-3 py-2 text-right text-gray-600 font-mono">{{ $workOrder->diskon }}%</td>
            </tr>
            @endif

            <tr class="bg-gray-100 font-black border-t-2 border-gray-800">
                <td colspan="3" class="border border-gray-400 px-3 py-2 text-right uppercase tracking-wider text-xs">Total Tagihan Jasa</td>
                <td class="border border-gray-400 px-3 py-2 text-right text-lg text-red-600 font-mono">Rp {{ number_format($workOrder->estimasi_biaya, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- TABEL 2: MATERIAL PREMIUM (TANPA HARGA) --}}
    @if($workOrder->bahanSpks && $workOrder->bahanSpks->count() > 0)
    <h3 class="font-bold text-sm mb-2 uppercase text-gray-800">Material Premium yang Digunakan</h3>
    <table class="w-full border-collapse border border-gray-400 text-sm mb-8">
        <thead>
            <tr class="bg-gray-50 text-gray-600 uppercase tracking-wider font-bold text-[10px]">
                <th class="border border-gray-400 px-3 py-2 text-center w-12">No</th>
                <th class="border border-gray-400 px-3 py-2 text-left w-48">Kategori</th>
                <th class="border border-gray-400 px-3 py-2 text-left">Nama Material / Merek</th>
            </tr>
        </thead>
        <tbody>
            @foreach($workOrder->bahanSpks as $idx => $bahanSpk)
            <tr>
                <td class="border border-gray-400 px-3 py-2 text-center">{{ $idx + 1 }}</td>
                <td class="border border-gray-400 px-3 py-2 font-bold text-gray-700 text-xs">{{ $bahanSpk->bahan->kategori ?? '-' }}</td>
                <td class="border border-gray-400 px-3 py-2 font-bold">{{ $bahanSpk->bahan->nama_bahan ?? 'Material Standar' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- TANDA TANGAN --}}
    <div class="mt-12 flex justify-between px-12">
        <div class="text-center w-48">
            <p class="text-xs mb-1">&nbsp;</p>
            <p class="text-xs mb-16">Menyetujui,</p>
            <p class="font-bold border-b border-gray-800 pb-1 uppercase">{{ $workOrder->vehicle->customer->name ?? '-' }}</p>
            <p class="text-xs text-gray-500 mt-1">Pemilik Kendaraan</p>
        </div>
        <div class="text-center w-48">
            <p class="text-xs mb-1">Banjarmasin, {{ date('d F Y') }}</p>
            <p class="text-xs mb-16">Dikeluarkan Oleh,</p>
            <p class="font-bold border-b border-gray-800 pb-1 uppercase">
                IMAM KHUDORI
            </p>
            <p class="text-xs text-gray-500 mt-1">Wira Toyota B&P</p>
        </div>
    </div>

    <div class="mt-12 text-center text-[10px] text-gray-400 italic border-t border-gray-200 pt-4">
        Dicetak otomatis oleh Wira System pada {{ date('d/m/Y H:i') }}
    </div>

</body>
</html>