<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekap PO - Wira Toyota</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
            /* Pake Landscape biar tabelnya lega memanjang kesamping */
            @page { size: A4 landscape; margin: 1cm; } 
        }
    </style>
</head>
<body class="bg-white p-10 text-gray-900 font-sans text-sm" onload="window.print()">

    {{-- KOP SURAT WIRA TOYOTA --}}
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
            <h2 class="text-xl font-bold text-gray-800 uppercase">Laporan Rekap Order Pembelian (PO)</h2>
            <p class="text-xs text-gray-500 mt-1">
                Periode: <span class="font-bold text-gray-700 uppercase">{{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}</span> | 
                Tanggal Cetak: <span class="font-mono font-bold text-gray-700">{{ date('d/m/Y') }}</span>
            </p>
        </div>
    </div>

    {{-- TABEL REKAPITULASI --}}
    <table class="w-full border-collapse border border-gray-400 text-xs mb-8">
        <thead>
            <tr class="bg-gray-100 text-gray-800 uppercase tracking-wider font-bold text-[10px]">
                <th class="border border-gray-400 px-2 py-3 text-center w-10">No</th>
                <th class="border border-gray-400 px-2 py-3 text-left">No. PO</th>
                <th class="border border-gray-400 px-2 py-3 text-center">Tgl Order</th>
                <th class="border border-gray-400 px-2 py-3 text-left">Vendor / Supplier</th>
                <th class="border border-gray-400 px-2 py-3 text-center">Total Item</th>
                <th class="border border-gray-400 px-2 py-3 text-center">Status</th>
                <th class="border border-gray-400 px-3 py-3 text-right">Total Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $index => $po)
            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                <td class="border border-gray-400 px-2 py-2 text-center">{{ $index + 1 }}</td>
                <td class="border border-gray-400 px-2 py-2 font-bold">{{ $po->po_number }}</td>
                <td class="border border-gray-400 px-2 py-2 text-center">{{ date('d/m/Y', strtotime($po->order_date)) }}</td>
                <td class="border border-gray-400 px-2 py-2 font-bold uppercase text-gray-700">{{ $po->supplier_name }}</td>
                <td class="border border-gray-400 px-2 py-2 text-center">{{ $po->items->count() }} Pcs</td>
                <td class="border border-gray-400 px-2 py-2 text-center uppercase text-[9px] {{ $po->status == 'Received' ? 'text-green-600 font-black' : 'text-amber-600 font-bold' }}">
                    {{ $po->status }}
                </td>
                <td class="border border-gray-400 px-3 py-2 text-right font-mono">
                    {{ number_format($po->total_amount, 0, ',', '.') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="border border-gray-400 px-4 py-6 text-center text-gray-500 italic font-bold">
                    Tidak ada data order pembelian pada bulan ini.
                </td>
            </tr>
            @endforelse
            
            {{-- BARIS GRAND TOTAL --}}
            <tr class="bg-gray-200 font-bold border-t-2 border-gray-800">
                <td colspan="6" class="border border-gray-400 px-4 py-3 text-right uppercase tracking-widest text-xs">Total Nilai Pengadaan Logistik</td>
                <td class="border border-gray-400 px-3 py-3 text-right text-blue-700 text-sm font-black font-mono">
                    Rp {{ number_format($orders->sum('total_amount'), 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    {{-- BLOK TANDA TANGAN --}}
    <div class="mt-12 flex justify-between px-12">
        <div class="text-center w-48">
            <p class="text-xs mb-16">Mengetahui,</p>
            <p class="font-bold border-b border-gray-800 pb-1 uppercase">Bpk. Sugiannor</p>
            <p class="text-xs text-gray-500 mt-1">Kepala Bengkel BP</p>
        </div>
        <div class="text-center w-48">
            <p class="text-xs mb-1">Banjarmasin, {{ date('d F Y') }}</p>
            <p class="text-xs mb-16">Dibuat Oleh,</p>
            <p class="font-bold border-b border-gray-800 pb-1 uppercase">{{ Auth::user()->name ?? 'Admin Sparepart' }}</p>
            <p class="text-xs text-gray-500 mt-1">Bagian Sparepart</p>
        </div>
    </div>

    {{-- FOOTER HALAMAN --}}
    <div class="fixed bottom-0 left-0 w-full text-center text-[10px] text-gray-400 italic py-4 border-t border-gray-200 mt-8">
        Dicetak otomatis oleh Wira System pada {{ date('d/m/Y H:i:s') }} | Dokumen Internal Rahasia
    </div>

</body>
</html>