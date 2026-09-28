<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt Part - {{ $po->po_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
            /* Portrait buat Surat Bukti Pesanan */
            @page { size: A4; margin: 1cm; } 
        }
    </style>
</head>
<body class="bg-white p-10 text-gray-900 font-sans text-sm" onload="window.print()">

    {{-- KOP SURAT WIRA TOYOTA --}}
    <div class="flex items-center justify-between border-b-2 border-gray-800 pb-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-24 flex-shrink-0">
                 {{-- Pastikan gambar logo wira lo ada di folder public/images --}}
                 <img src="{{ asset('images/logo-wira.png') }}" alt="Logo Wira Toyota" class="w-full object-contain">
            </div>
            <div>
                <h1 class="text-2xl font-black uppercase tracking-widest text-red-600 leading-none mb-1">WIRA TOYOTA</h1>
                <p class="text-sm font-bold text-gray-800">Body & Paint Specialist</p>
                <p class="text-xs text-gray-600 mt-0.5">Jl. A. Yani Km. 10, Banjarmasin | Telp: (0511) 1234567</p>
            </div>
        </div>
        <div class="text-right">
            <h2 class="text-xl font-bold text-gray-800 uppercase tracking-tighter">Purchase Order</h2>
            <p class="text-lg font-mono font-black text-blue-600 mt-1">{{ $po->po_number }}</p>
        </div>
    </div>

    {{-- INFO CUSTOMER & DETAIL PESANAN --}}
    <div class="grid grid-cols-2 gap-12 mb-8">
        <div>
            <h3 class="font-bold border-b border-gray-300 mb-2 uppercase text-xs tracking-wider text-gray-500">Kepada Yth. (Pelanggan)</h3>
            <table class="w-full text-sm">
                <tr>
                    <td class="py-1 w-24 text-gray-500">Nama</td>
                    <td class="font-black uppercase text-base text-gray-900">{{ $po->workOrder->vehicle->customer->name ?? 'Pelanggan Umum' }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-500">Kendaraan</td>
                    <td class="font-bold uppercase text-gray-800">
                        <span class="bg-gray-100 px-2 py-0.5 rounded border border-gray-300 mr-1">{{ $po->workOrder->vehicle->nopol ?? '-' }}</span> 
                        {{ $po->workOrder->vehicle ? '('.$po->workOrder->vehicle->merk.')' : '' }}
                    </td>
                </tr>
            </table>
        </div>

        <div>
            <h3 class="font-bold border-b border-gray-300 mb-2 uppercase text-xs tracking-wider text-gray-500">Referensi Pemesanan</h3>
            <table class="w-full text-sm">
                <tr>
                    <td class="py-1 w-32 text-gray-500">Tanggal Pesan</td>
                    <td class="font-bold text-gray-900">{{ date('d F Y', strtotime($po->order_date)) }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-500">No. SPK</td>
                    <td class="font-bold text-gray-900">{{ $po->workOrder->nomor_spk ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-500">Status Barang</td>
                    <td class="font-bold uppercase italic {{ $po->status == 'Received' ? 'text-green-600' : 'text-amber-600' }}">
                        {{ $po->status == 'Ordered' ? 'Sedang Dipesan (Inden)' : 'Barang Telah Tiba' }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- TABEL BARANG --}}
    <h3 class="font-bold text-sm mb-2 uppercase">Rincian Komponen / Sparepart</h3>
    <table class="w-full border-collapse border border-gray-400 text-sm mb-8">
        <thead>
            <tr class="bg-gray-100 text-gray-800 uppercase tracking-wider font-bold text-xs">
                <th class="border border-gray-400 px-3 py-2 text-center w-12">No</th>
                <th class="border border-gray-400 px-3 py-2 text-left">Nama Panel / Sparepart</th>
                <th class="border border-gray-400 px-3 py-2 text-center w-20">Volume</th>
                <th class="border border-gray-400 px-3 py-2 text-right w-32">Harga Dasar</th>
                <th class="border border-gray-400 px-3 py-2 text-right w-32">Subtotal Part</th>
            </tr>
        </thead>
        <tbody>
            @foreach($po->items as $idx => $item)
            <tr>
                <td class="border border-gray-400 px-3 py-2 text-center">{{ $idx + 1 }}</td>
                <td class="border border-gray-400 px-3 py-2 font-bold uppercase">{{ $item->item_name }}</td>
                <td class="border border-gray-400 px-3 py-2 text-center font-bold">{{ $item->qty }}</td>
                <td class="border border-gray-400 px-3 py-2 text-right font-mono">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="border border-gray-400 px-3 py-2 text-right font-mono font-black">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            
            <tr class="bg-gray-100 font-bold border-t-2 border-gray-800">
                <td colspan="4" class="border border-gray-400 px-4 py-3 text-right uppercase tracking-wider">Total Harga Dasar Part</td>
                <td class="border border-gray-400 px-3 py-3 text-right text-lg text-blue-700 font-black">Rp {{ number_format($po->total_amount, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- KETENTUAN TAMBAHAN (ALASAN SAKTI BUAT NUTUPIN MARKUP WKWK) --}}
    <div class="mb-10 text-xs text-gray-800 bg-gray-50 border border-gray-300 p-4 rounded-lg">
        <h4 class="font-black uppercase mb-2 text-red-600">⚠ PEMBERITAHUAN PENTING:</h4>
        <ul class="list-disc pl-4 space-y-1.5 text-gray-600 font-medium">
            <li>Harga yang tertera pada dokumen ini adalah <b>Harga Dasar (Modal) Komponen/Sparepart</b> murni.</li>
            <li><b>Belum Termasuk:</b> Biaya Jasa Pemasangan, Penyetelan (Ketok/Las), dan Pengecatan (Bahan + Oven).</li>
            <li>Selisih nominal pada Total Tagihan Akhir merupakan biaya jasa perbaikan/pengecatan yang akan diakumulasikan ke dalam <b>Invoice Utama SPK</b>.</li>
        </ul>
    </div>

    {{-- TANDA TANGAN --}}
    <div class="mt-12 flex justify-between px-12">
        <div class="text-center w-48">
            <p class="text-xs mb-1">&nbsp;</p>
            <p class="text-xs mb-16">Menyetujui,</p>
            <p class="font-bold border-b border-gray-800 pb-1 uppercase">{{ $po->workOrder->vehicle->customer->name ?? 'Pelanggan' }}</p>
            <p class="text-xs text-gray-500 mt-1">Pemilik Kendaraan</p>
        </div>
        <div class="text-center w-48">
            <p class="text-xs mb-1">Banjarmasin, {{ date('d F Y', strtotime($po->order_date)) }}</p>
            <p class="text-xs mb-16">Dikeluarkan Oleh,</p>
            
            {{-- NAMA DINAMIS SESUAI YANG LOGIN, JABATAN TETAP MILIK GUDANG --}}
            <p class="font-bold border-b border-gray-800 pb-1 uppercase">
                DYLAN CASINDY
            </p>
            <p class="text-xs text-gray-500 mt-1 font-bold uppercase">Bagian Sparepart</p>
        </div>
    </div>

    {{-- WATERMARK SISTEM --}}
    <div class="mt-12 text-center text-[10px] text-gray-400 italic border-t border-gray-200 pt-4">
        Dicetak otomatis oleh Wira System pada {{ date('d/m/Y H:i') }}
    </div>

</body>
</html>