<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stok Gudang - Wira Toyota</title>
    {{-- Pake Tailwind CDN biar styling cepet & rapi --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none; }
            @page { size: A4; margin: 1cm; }
        }
        .table-border { border: 1px solid #000; }
        .table-border th, .table-border td { border: 1px solid #000; padding: 6px 8px; }
    </style>
</head>
<body class="bg-white p-8 text-gray-900 font-sans text-sm" onload="window.print()">

    {{-- KOP SURAT --}}
    <div class="flex items-center justify-between border-b-4 border-double border-gray-800 pb-4 mb-6">
        <div class="flex items-center gap-5">
            {{-- LOGO (Ganti src sesuai path logo lu) --}}
            <div class="w-20">
                <img src="{{ asset('images/logo-wira.png') }}" alt="Logo Wira Toyota" class="w-full object-contain">
            </div>
            <div>
                <h1 class="text-2xl font-black uppercase tracking-widest text-red-600 leading-none mb-1">WIRA TOYOTA</h1>
                <p class="text-sm font-bold text-gray-900 uppercase">Body & Paint Department</p>
                <p class="text-xs text-gray-600 mt-0.5">Jl. A. Yani Km. 10, Banjarmasin, Kalimantan Selatan</p>
            </div>
        </div>
        <div class="text-right">
            <h2 class="text-xl font-bold text-gray-800 uppercase tracking-wide">Laporan Stok Opname</h2>
            <p class="text-xs text-gray-500 mt-1">Periode Cetak: <span class="font-mono font-bold text-gray-900">{{ date('d F Y') }}</span></p>
            <p class="text-xs text-gray-500">Pukul: <span class="font-mono font-bold text-gray-900">{{ date('H:i') }} WITA</span></p>
        </div>
    </div>

    {{-- TABEL STOK --}}
    <table class="w-full border-collapse table-border text-xs">
        <thead>
            <tr class="bg-gray-200 text-gray-900 uppercase tracking-wider font-bold">
                <th class="w-10 text-center">No</th>
                <th class="text-left">Nama Panel / Sparepart</th>
                <th class="w-32 text-center">Lokasi Rak</th>
                <th class="w-24 text-center">Stok Ready</th>
                <th class="w-40 text-right">Estimasi Nilai (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotalQty = 0; $grandTotalValue = 0; $no = 1; @endphp
            
            {{-- Looping per Kategori biar rapi --}}
            @foreach($panelCategories as $categoryName => $data)
                {{-- Baris Header Kategori --}}
                <tr class="bg-gray-100 font-bold">
                    <td colspan="5" class="uppercase text-gray-700 px-3 py-1.5 italic">{{ $categoryName }}</td>
                </tr>

                @foreach($data['items'] as $panelName)
                    @php 
                        // Hitung Stok
                        $items = \App\Models\WorkOrderDetail::where('panel_name', $panelName)
                                    ->where('part_status', 'Ready')
                                    ->get();
                        
                        $count = $items->count();
                        $value = $items->sum('harga');
                        
                        // Lokasi (Ambil salah satu aja buat contoh)
                        $location = $items->first()->part_location ?? '-';

                        $grandTotalQty += $count;
                        $grandTotalValue += $value;
                    @endphp

                    @if($count > 0) {{-- Cuma tampilin yg ada stoknya --}}
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td class="font-bold text-gray-800">{{ $panelName }}</td>
                            <td class="text-center text-gray-600 font-mono">{{ $location }}</td>
                            <td class="text-center font-bold bg-green-50 text-green-900">{{ $count }} Unit</td>
                            <td class="text-right font-mono">{{ number_format($value, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                @endforeach
            @endforeach

            {{-- FOOTER TOTAL --}}
            <tr class="bg-gray-800 text-white font-black text-sm uppercase">
                <td colspan="3" class="text-right py-3 px-4">Total Aset Gudang</td>
                <td class="text-center py-3">{{ $grandTotalQty }} Unit</td>
                <td class="text-right py-3 px-4">Rp {{ number_format($grandTotalValue, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="mt-12 flex justify-between px-16 break-inside-avoid">
        <div class="text-center w-48">
            <p class="text-xs mb-16">Disetujui Oleh,</p>
            {{-- INI UDAH GW GANTI JADI SUGIANNOR --}}
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