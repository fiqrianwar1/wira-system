<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bahan;
use App\Models\BahanSpk;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BahanController extends Controller
{
    // ====================================================================
    // 0. DASHBOARD GUDANG BAHAN
    // ====================================================================
    public function dashboard()
    {
        // 1. Data Stat Card Atas
        $totalBahan = Bahan::count();
        $stokMenipis = Bahan::where('stok', '<=', 5)->get();
        $recentUsage = BahanSpk::with(['bahan', 'workOrder.vehicle'])
                        ->latest()
                        ->take(5)
                        ->get();

        // 2. DATA GRAFIK 1: Tren Pembelian / Restock Bahan (UBAH JADI 30 HARI TERAKHIR)
        $chartDates = [];
        $chartPembelian = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = \Carbon\Carbon::today()->subDays($i)->format('Y-m-d');
            // Format tanggalnya dibikin d M (contoh: 15 Mar) biar rapi di grafik
            $chartDates[] = \Carbon\Carbon::today()->subDays($i)->format('d M');
            
            // Hitung aktivitas tambah/update stok bahan di hari tersebut
            $chartPembelian[] = Bahan::whereDate('updated_at', $date)->count();
        }

        // 3. STATISTIK KARTU 3: Distribusi 1 Bulan Ini (Biar kaga reset tiap hari wkwk)
        $distribusiBulanIni = BahanSpk::whereMonth('tanggal_pakai', date('m'))
                                      ->whereYear('tanggal_pakai', date('Y'))
                                      ->count();

        // 4. DATA GRAFIK 2 & ALERT SPK: Status SPK Aktif
        // FIX: Tambahin status 'Selesai' di sini biar notif SPK yang belum diinput bahannya tetep muncul wkwk!
        $activeSpks = WorkOrder::whereIn('status', ['Pending', 'PENDING', 'Proses', 'PROSES', 'Selesai', 'SELESAI'])->pluck('id');
        $totalActiveSpk = $activeSpks->count();
        
        // Ambil ID SPK yang udah dapet bahan
        $spkWithBahanIds = BahanSpk::whereIn('work_order_id', $activeSpks)
                            ->pluck('work_order_id')
                            ->unique();
                            
        $spkWithBahan = $spkWithBahanIds->count();
        $spkWithoutBahan = $totalActiveSpk - $spkWithBahan;

        // Tarik data SPK yang BELUM didistribusi bahan buat dimunculin di Alert!
        $pendingSpks = WorkOrder::with('vehicle')
                        ->whereIn('id', $activeSpks)
                        ->whereNotIn('id', $spkWithBahanIds)
                        ->get();

        // JANGAN LUPA variabel $distribusiBulanIni dikirim ke view!
        return view('bahan.dashboard', compact(
            'totalBahan', 'stokMenipis', 'recentUsage',
            'chartDates', 'chartPembelian', 'distribusiBulanIni',
            'spkWithBahan', 'spkWithoutBahan', 'totalActiveSpk', 'pendingSpks'
        ));
    }

    // ====================================================================
    // 1. MANAJEMEN STOK BAHAN (Master Data)
    // ====================================================================
    public function stokIndex()
    {
        $bahans = Bahan::latest()->get();
        return view('bahan.stok.index', compact('bahans'));
    }

    public function stokPrint()
    {
        // Tarik data bahan terus di-group berdasarkan Kategori (Biar rapi di kertasnya)
        $bahans = Bahan::orderBy('kategori')->orderBy('nama_bahan')->get();
        $groupedBahans = $bahans->groupBy('kategori');

        return view('bahan.stok.print', compact('groupedBahans'));
    }

    // Nampilin Halaman Form Tambah
    public function stokCreate()
    {
        return view('bahan.stok.create');
    }

    public function stokStore(Request $request)
    {
        // Validasi, HAPUS aturan 'unique' di kode_bahan biar dia bisa nerima kode lama
        $request->validate([
            'supplier'         => 'nullable|string',
            'nomor_nota'       => 'nullable|string',
            'foto_nota'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // 👇 TAMBAHAN VALIDASI FOTO
            'kode_bahan.*'     => 'required|string', 
            'nama_bahan.*'     => 'required|string',
            'kategori.*'       => 'required|string',
            'satuan.*'         => 'required|string',
            'stok.*'           => 'required|numeric|min:0.1',
            'harga_satuan.*'   => 'required|numeric'
        ]);

        $supplier = $request->supplier;
        $nomor_nota = $request->nomor_nota; 

        // 👇👇 LOGIKA UPLOAD FOTO NOTA 👇👇
        $fotoNotaPath = null;
        if ($request->hasFile('foto_nota')) {
            // Simpan foto ke storage/app/public/nota_bahan
            $fotoNotaPath = $request->file('foto_nota')->store('nota_bahan', 'public');
        }

        // Pake DB Transaction biar aman
        DB::beginTransaction();
        try {
            // Looping semua data array
            foreach ($request->kode_bahan as $key => $kode) {
                
                // Cari apakah kode bahan ini udah ada di database
                $bahanExist = Bahan::where('kode_bahan', $kode)->first();

                if ($bahanExist) {
                    // KALAU BARANGNYA UDAH ADA
                    $bahanExist->stok += $request->stok[$key];
                    $bahanExist->harga_satuan = $request->harga_satuan[$key];
                    if ($supplier) $bahanExist->supplier = $supplier; 
                    if ($nomor_nota) $bahanExist->nomor_nota = $nomor_nota; 
                    
                    // Update foto nota kalau user upload foto baru
                    if ($fotoNotaPath) $bahanExist->foto_nota = $fotoNotaPath; 
                    
                    $bahanExist->save();
                    
                } else {
                    // KALAU BARANGNYA BENERAN BARU
                    Bahan::create([
                        'kode_bahan'   => $kode,
                        'nama_bahan'   => $request->nama_bahan[$key],
                        'kategori'     => $request->kategori[$key],
                        'satuan'       => $request->satuan[$key],
                        'stok'         => $request->stok[$key],
                        'harga_satuan' => $request->harga_satuan[$key],
                        'supplier'     => $supplier,
                        'nomor_nota'   => $nomor_nota, 
                        'foto_nota'    => $fotoNotaPath, // <-- SIMPAN PATH FOTO KE DB
                    ]);
                }
            }
            
            DB::commit();
            return redirect()->route('bahan.stok.index')->with('success', count($request->kode_bahan) . ' Item berhasil ditambahkan / diupdate di Gudang!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Sistem error bro: ' . $e->getMessage());
        }
    }
    
    public function stokEdit($id)
    {
        $bahan = Bahan::findOrFail($id);
        return view('bahan.stok.edit', compact('bahan'));
    }

    public function stokUpdate(Request $request, $id)
    {
        $request->validate([
            'kode_bahan' => 'required|string|unique:bahans,kode_bahan,'.$id,
            'nama_bahan' => 'required|string',
            'kategori'   => 'required|string',
            'supplier'   => 'nullable|string',
            'nomor_nota' => 'nullable|string', 
            'foto_nota'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // 👇 TAMBAHAN VALIDASI FOTO
            'stok'       => 'required|numeric',
            'satuan'     => 'required|string',
            'harga_satuan'=> 'required|numeric'
        ]);

        $bahan = Bahan::findOrFail($id);
        $dataToUpdate = $request->all();

        // 👇👇 LOGIKA UPDATE FOTO NOTA 👇👇
        if ($request->hasFile('foto_nota')) {
            // Hapus nota lama kalau ada, biar storage DBngin lu gak menumpuk sampah file
            if ($bahan->foto_nota && Storage::disk('public')->exists($bahan->foto_nota)) {
                Storage::disk('public')->delete($bahan->foto_nota);
            }
            // Simpan nota yang baru
            $dataToUpdate['foto_nota'] = $request->file('foto_nota')->store('nota_bahan', 'public');
        }

        $bahan->update($dataToUpdate);
        
        return redirect()->route('bahan.stok.index')->with('success', 'Data Bahan berhasil diupdate!');
    }

    public function stokDestroy($id)
    {
        Bahan::findOrFail($id)->delete();
        return back()->with('success', 'Bahan berhasil dihapus!');
    }

    // ====================================================================
    // 2. PENCATATAN OPLOSAN & PEMAKAIAN BAHAN PER SPK
    // ====================================================================
    
    // Nampilin daftar SPK mobil yang lagi dikerjain
    public function spkIndex()
    {
        // TAMBAHIN 'vehicle.customer' BIAR NAMA PELANGGAN KE-LOAD SEKALI TARIK
        // FIX: Tambahin status 'Selesai' di sini biar datanya tetep muncul di tabel buat diinput!
        $spkAktif = WorkOrder::with('vehicle.customer') 
                    ->withCount('bahanSpks') 
                    ->whereIn('status', ['Pending', 'PENDING', 'Proses', 'PROSES', 'Selesai', 'SELESAI'])
                    ->latest()
                    ->get();
                    
        return view('bahan.spk.index', compact('spkAktif'));
    }

    public function spkInput($id)
    {
        $wo = WorkOrder::with(['vehicle', 'details'])->findOrFail($id);
        $bahans = Bahan::where('stok', '>', 0)->orderBy('nama_bahan', 'ASC')->get();
        
        // Panggil relasi 'mechanic' sekalian biar gampang ditampilin di tabel
        $riwayatPakai = BahanSpk::with(['bahan', 'mechanic'])->where('work_order_id', $id)->latest()->get();

        // AMBIL DATA TEKNISI BENGKEL 
        $mekaniks = \App\Models\Mechanic::orderBy('name', 'ASC')->get(); 

        return view('bahan.spk.input', compact('wo', 'bahans', 'riwayatPakai', 'mekaniks'));
    }

    public function spkStore(Request $request, $id)
    {
        $request->validate([
            'bahan_id'     => 'required|exists:bahans,id',
            'mechanic_id'  => 'required', // Validasi Teknisi
            'stall'        => 'required|string', // Validasi Stall
            'jumlah_pakai' => 'required|numeric|min:0.1',
            'tanggal_pakai'=> 'required|date',
        ]);

        $bahan = Bahan::findOrFail($request->bahan_id);

        if ($request->jumlah_pakai > $bahan->stok) {
            return back()->with('error', 'Waduh stok gak cukup bro! Sisa ' . $bahan->nama_bahan . ' cuma ' . $bahan->stok . ' ' . $bahan->satuan);
        }

        DB::beginTransaction();
        try {
            BahanSpk::create([
                'work_order_id' => $id,
                'bahan_id'      => $request->bahan_id,
                'mechanic_id'   => $request->mechanic_id, // Simpan ID Mekanik
                'jumlah_pakai'  => $request->jumlah_pakai,
                'tanggal_pakai' => $request->tanggal_pakai,
                'catatan'       => $request->stall, // TRIK: Nama Stall kita simpan di kolom catatan!
            ]);

            $bahan->decrement('stok', $request->jumlah_pakai);

            DB::commit();
            return back()->with('success', 'Mantap! Bahan berhasil dicatat untuk teknisi tersebut.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Sistem error bro: ' . $e->getMessage());
        }
    }

    // Fungsi Batal / Hapus Salah Input (Balikin Stok ke Gudang)
    public function spkDestroy($id)
    {
        DB::beginTransaction();
        try {
            $pemakaian = BahanSpk::findOrFail($id);
            $bahan = Bahan::findOrFail($pemakaian->bahan_id);

            // 1. BALIKIN LAGI STOKNYA ke master bahan
            $bahan->increment('stok', $pemakaian->jumlah_pakai);

            // 2. Hapus riwayat pemakaiannya
            $pemakaian->delete();

            DB::commit();
            return back()->with('success', 'Riwayat dihapus dan stok bahan otomatis dikembalikan ke gudang!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Sistem error bro: ' . $e->getMessage());
        }
    }

    public function spkPrint($id)
    {
        // Tarik data WO + Relasi ke Customer & Vehicle
        $wo = WorkOrder::with(['vehicle.customer'])->findOrFail($id);
        
        // Tarik data pemakaian bahan + Relasi ke Bahan & Mechanic
        $pemakaian = BahanSpk::with(['bahan', 'mechanic'])->where('work_order_id', $id)->get();
        
        return view('bahan.spk.print', compact('wo', 'pemakaian'));
    }
}