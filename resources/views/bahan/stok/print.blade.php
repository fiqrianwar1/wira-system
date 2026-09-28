<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stok Gudang Bahan - Wira Toyota</title>
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
    <div class="flex items-center justify-between border-b-2 border-gray-800 pb-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-24 flex-shrink-0">
                 <img src="{{ asset('images/logo-wira.png') }}" alt="Logo Wira Toyota" class="w-full object-contain">
            </div>
            <div>
                <h1 class="text-2xl font-black uppercase tracking-widest text-red-600 leading-none mb-1">WIRA TOYOTA</h1>
                <p class="text-sm font-bold text-gray-800">Body & Paint Department</p>
                <p class="text-xs text-gray-600 mt-0.5">Jl. A. Yani Km. 10, Banjarmasin | Telp: (0511) 1234567</p>
            </div>
        </div>
        <div class="text-right">
            <h2 class="text-xl font-bold text-gray-800 uppercase">Laporan Stok Material</h2>
            <p class="text-xs text-gray-500 mt-2">Periode Cetak: <span class="font-bold text-gray-900">{{ date('d F Y') }}</span></p>
            <p class="text-xs text-gray-500">Pukul: <span class="font-bold text-gray-900">{{ date('H:i') }} WITA</span></p>
        </div>
    </div>

    {{-- TABEL STOK BAHAN --}}
    <table class="w-full border-collapse border border-gray-400 text-sm mb-8">
        <thead>
            <tr class="bg-gray-100 text-gray-800 uppercase tracking-wider font-bold text-xs">
                <th class="border border-gray-400 px-3 py-2 text-center w-10">No</th>
                <th class="border border-gray-400 px-3 py-2 text-center w-28">Kode Bahan</th>
                <th class="border border-gray-400 px-3 py-2 text-left">Nama Bahan / Merek</th>
                <th class="border border-gray-400 px-3 py-2 text-left w-48">Supplier</th>
                <th class="border border-gray-400 px-3 py-2 text-center w-28">Sisa Stok</th>
                <th class="border border-gray-400 px-3 py-2 text-right w-36">Nilai Aset (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $grandTotalItem = 0; 
                $grandTotalValue = 0; 
            @endphp
            
            {{-- Looping per Kategori --}}
            @forelse($groupedBahans as $kategori => $items)
                {{-- Baris Header Kategori (DIBIKIN ITALIC AJA SESUAI REQUEST) --}}
                <tr class="bg-gray-50">
                    <td colspan="6" class="border border-gray-400 px-3 py-2 text-xs italic text-gray-600">
                        Kategori: {{ $kategori }}
                    </td>
                </tr>

                @php $no = 1; @endphp
                @foreach($items as $item)
                    @php 
                        // Hitung Nilai Aset per item (Stok * Harga Satuan)
                        $nilaiAset = $item->stok * $item->harga_satuan;
                        
                        $grandTotalItem += 1;
                        $grandTotalValue += $nilaiAset;
                    @endphp

                    <tr>
                        <td class="border border-gray-400 px-3 py-2 text-center">{{ $no++ }}</td>
                        <td class="border border-gray-400 px-3 py-2 text-center font-mono text-gray-600 text-xs">{{ $item->kode_bahan }}</td>
                        <td class="border border-gray-400 px-3 py-2 font-bold text-gray-900">
                            {{ $item->nama_bahan }}
                        </td>
                        <td class="border border-gray-400 px-3 py-2 text-gray-700 text-xs">{{ $item->supplier ?? '-' }}</td>
                        <td class="border border-gray-400 px-3 py-2 text-center font-black bg-gray-50 {{ $item->stok <= 5 ? 'text-red-600' : 'text-gray-800' }}">
                            {{ $item->stok }} <span class="text-[10px] font-normal">{{ $item->satuan }}</span>
                        </td>
                        <td class="border border-gray-400 px-3 py-2 text-right font-mono font-bold text-gray-800">
                            {{ number_format($nilaiAset, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="6" class="border border-gray-400 px-3 py-8 text-center text-gray-500 italic">Data stok material belum tersedia.</td>
                </tr>
            @endforelse

            {{-- BARIS TOTAL --}}
            @if($grandTotalItem > 0)
            <tr class="bg-gray-100 font-bold border-t-2 border-gray-800">
                <td colspan="4" class="border border-gray-400 px-3 py-2 text-right uppercase tracking-wider text-xs">Total Kalkulasi Aset Gudang</td>
                <td class="border border-gray-400 px-3 py-2 text-center text-gray-900 font-black">{{ $grandTotalItem }} Item</td>
                <td class="border border-gray-400 px-3 py-2 text-right text-red-600 font-black">Rp {{ number_format($grandTotalValue, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="mt-12 flex justify-between px-12 break-inside-avoid">
        <div class="text-center w-48">
            <p class="text-xs mb-16 text-gray-600">Mengetahui / Disetujui Oleh,</p>
            <p class="font-bold border-b border-gray-800 pb-1 uppercase">Bpk. Sugiannor</p>
            <p class="text-[10px] text-gray-500 mt-1 font-bold">Kepala Bengkel BP</p>
        </div>
        
        <div class="text-center w-48">
            <p class="text-xs mb-1 text-gray-600">Banjarmasin, {{ date('d F Y') }}</p>
            <p class="text-xs mb-16 text-gray-600">Dibuat Oleh,</p>
            <p class="font-bold border-b border-gray-800 pb-1 text-gray-900 uppercase">{{ Auth::user()->name }}</p>
            <p class="text-[10px] text-gray-500 mt-1 font-bold">Bagian Gudang Bahan</p>
        </div>
    </div>

    {{-- FOOTER HALAMAN --}}
    <div class="mt-12 text-center text-[10px] text-gray-400 italic border-t border-gray-200 pt-4">
        Dicetak otomatis oleh Wira System pada {{ date('d/m/Y H:i') }} | Dokumen Internal Logistik
    </div>

</body>
</html>