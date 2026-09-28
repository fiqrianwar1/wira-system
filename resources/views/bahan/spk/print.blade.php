<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Pemakaian - SPK {{ str_pad($wo->id, 4, '0', STR_PAD_LEFT) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none; }
            @page { size: A4; margin: 1cm; } /* Portrait buat form rincian */
        }
    </style>
</head>
<body class="bg-white p-10 text-gray-900 font-sans text-sm" onload="window.print()">

    {{-- KOP SURAT --}}
    <div class="flex items-center justify-between border-b-2 border-gray-800 pb-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-24 flex-shrink-0">
                 {{-- Pastikan path logo wira lu bener ya bro --}}
                 <img src="{{ asset('images/logo-wira.png') }}" alt="Logo Wira Toyota" class="w-full object-contain">
            </div>
            <div>
                <h1 class="text-2xl font-black uppercase tracking-widest text-red-600 leading-none mb-1">WIRA TOYOTA</h1>
                <p class="text-sm font-bold text-gray-800">Body & Paint Department</p>
                <p class="text-xs text-gray-600 mt-0.5">Jl. A. Yani Km. 10, Banjarmasin | Telp: (0511) 1234567</p>
            </div>
        </div>
        <div class="text-right">
            <h2 class="text-xl font-bold text-gray-800 uppercase">Lembar Pemakaian Material</h2>
            <p class="text-2xl font-mono font-black text-red-600 mt-1">SPK-{{ str_pad($wo->id, 4, '0', STR_PAD_LEFT) }}</p>
            <p class="text-xs text-gray-500 mt-1">Tgl Cetak: <span class="font-bold text-gray-800">{{ date('d F Y') }}</span></p>
        </div>
    </div>

    {{-- INFO KENDARAAN & CUSTOMER --}}
    <div class="grid grid-cols-2 gap-12 mb-8">
        <div>
            <h3 class="font-bold border-b border-gray-300 mb-2 uppercase text-xs tracking-wider text-gray-500">Data Pemilik (Customer)</h3>
            <table class="w-full text-sm">
                <tr>
                    <td class="py-1 w-24 text-gray-500">Nama</td>
                    <td class="font-bold uppercase">{{ $wo->vehicle->customer->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-500">Telepon</td>
                    <td>{{ $wo->vehicle->customer->phone ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-500">Alamat</td>
                    <td>{{ $wo->vehicle->customer->address ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div>
            <h3 class="font-bold border-b border-gray-300 mb-2 uppercase text-xs tracking-wider text-gray-500">Data Kendaraan (Vehicle)</h3>
            <table class="w-full text-sm">
                <tr>
                    <td class="py-1 w-24 text-gray-500">No. Polisi</td>
                    <td class="font-black bg-gray-100 px-2 inline-block rounded">{{ $wo->vehicle->nopol ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-500">Unit</td>
                    {{-- FIX TIPE MOBIL UNKNOWN --}}
                    <td class="font-bold uppercase">{{ $wo->vehicle->merk ?? '' }} {{ $wo->vehicle->model ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1 text-gray-500">Status Pengerjaan</td>
                    <td class="font-bold uppercase text-blue-600">{{ $wo->status ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- TABEL PENGGUNAAN BAHAN (Pemakaian) --}}
    <h3 class="font-bold text-sm mb-2 uppercase text-gray-800">Rincian Pengambilan Material & Cat</h3>
    <table class="w-full border-collapse border border-gray-400 text-sm mb-8">
        <thead>
            <tr class="bg-gray-100 text-gray-800 uppercase tracking-wider font-bold text-xs">
                <th class="border border-gray-400 px-3 py-2 text-center w-10">No</th>
                <th class="border border-gray-400 px-3 py-2 text-center w-24">Tanggal</th>
                <th class="border border-gray-400 px-3 py-2 text-left">Nama Material / Kode</th>
                <th class="border border-gray-400 px-3 py-2 text-left">Area Pekerjaan</th>
                <th class="border border-gray-400 px-3 py-2 text-center">Teknisi (User)</th>
                <th class="border border-gray-400 px-3 py-2 text-center w-24">Jumlah Pakai</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $no = 1; 
                $totalItem = $pemakaian->count();
            @endphp
            
            @forelse($pemakaian as $rp)
            <tr>
                <td class="border border-gray-400 px-3 py-2 text-center">{{ $no++ }}</td>
                <td class="border border-gray-400 px-3 py-2 text-center font-mono text-xs">{{ \Carbon\Carbon::parse($rp->tanggal_pakai)->format('d/m/Y') }}</td>
                <td class="border border-gray-400 px-3 py-2">
                    <div class="font-bold text-gray-900">{{ $rp->bahan->nama_bahan ?? 'Bahan Dihapus' }}</div>
                    <div class="text-[10px] text-gray-500 font-mono mt-0.5">{{ $rp->bahan->kode_bahan ?? '-' }}</div>
                </td>
                <td class="border border-gray-400 px-3 py-2 text-xs text-gray-700">{{ $rp->catatan ?? '-' }}</td>
                <td class="border border-gray-400 px-3 py-2 text-center font-bold text-gray-800 text-xs">{{ $rp->mechanic->name ?? '-' }}</td>
                <td class="border border-gray-400 px-3 py-2 text-center font-black bg-gray-50">
                    {{ $rp->jumlah_pakai }} <span class="text-[10px] font-normal">{{ $rp->bahan->satuan ?? '' }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="border border-gray-400 px-3 py-8 text-center text-gray-500 italic">Belum ada material yang ditarik untuk SPK ini.</td>
            </tr>
            @endforelse
            
            {{-- BARIS TOTAL --}}
            @if($totalItem > 0)
            <tr class="bg-gray-100 font-bold border-t-2 border-gray-800">
                <td colspan="5" class="border border-gray-400 px-3 py-2 text-right uppercase tracking-wider text-xs">Total Transaksi Penarikan Bahan</td>
                <td class="border border-gray-400 px-3 py-2 text-center text-purple-700 font-black">{{ $totalItem }} Kali</td>
            </tr>
            @endif
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="mt-12 flex justify-between px-12 break-inside-avoid">
        <div class="text-center w-48">
            <p class="text-xs mb-16 text-gray-600">Mengetahui / Menyetujui,</p>
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

    {{-- FIX FOOTER HALAMAN BIAR GA NABRAK --}}
    <div class="mt-12 text-center text-[10px] text-gray-400 italic border-t border-gray-200 pt-4">
        Dicetak otomatis oleh Wira System pada {{ date('d/m/Y H:i') }} | Dokumen Internal Logistik
    </div>

</body>
</html>