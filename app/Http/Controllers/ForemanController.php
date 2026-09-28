<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;       
use App\Models\WorkOrderDetail; 
use App\Models\Mechanic;            
use App\Models\WorkOrderAllocation; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ForemanController extends Controller
{
    /**
     * =================================================================
     * 1. DASHBOARD UTAMA FOREMAN (MONITORING)
     * =================================================================
     */
    public function index()
    {
        // A. KARTU STATISTIK
        $stats = [
            'total_proses' => WorkOrder::query()->where('status', 'proses')->count(),
            'total_selesai_bulan_ini' => WorkOrder::query()->where('status', 'selesai')
                                    ->whereMonth('updated_at', Carbon::now()->month)
                                    ->count(),
            'unit_menunggu' => WorkOrder::query()->where('status', 'pending')->count(), 
            'total_mekanik' => Mechanic::query()->where('is_active', true)->count() 
        ];

        // B. DATA GRAFIK
        $statusPending = WorkOrder::query()->where('status', 'pending')->count();
        $statusProses = WorkOrder::query()->where('status', 'proses')->count();
        $statusSelesai = WorkOrder::query()->where('status', 'selesai')->count();
        $repairRegular = WorkOrder::query()->where('repair_type', 'Regular')->count();
        $repairQuick = WorkOrder::query()->where('repair_type', 'Quick Repair')->count();

        // FITUR BARU: SPK YANG BARU MASUK TAPI BELUM DIKERJAIN / DIPLOT
        $pendingSpks = WorkOrder::query()->with(['vehicle'])
                        ->where('status', 'pending')
                        ->orderBy('created_at', 'desc')
                        ->get();

        // C. LIST JOB ORDER AKTIF (PAGINATION)
        $workOrders = WorkOrder::query()->with(['vehicle', 'details', 'allocations'])
                        ->where('status', 'proses')
                        ->orderBy('estimasi_selesai', 'asc')
                        ->paginate(10);

        // D. RIWAYAT UNIT SELESAI (5 TERAKHIR)
        $finishedOrders = WorkOrder::query()->with(['vehicle', 'allocations'])
                        ->where('status', 'selesai')
                        ->latest('updated_at')
                        ->take(5)
                        ->get();

        return view('foreman.dashboard', compact(
            'stats', 'workOrders', 'finishedOrders', 'pendingSpks',
            'statusPending', 'statusProses', 'statusSelesai',
            'repairRegular', 'repairQuick'
        ));
    }
    
    /**
     * =================================================================
     * 2. HALAMAN PROGRES KERJA (INDEX & EDIT TERPISAH)
     * =================================================================
     */

    public function progressIndex(Request $request)
    {
        $query = WorkOrder::query()->with(['vehicle', 'mechanic']) 
                        ->whereIn('status', ['pending', 'proses', 'selesai']);

        if ($request->has('search') && $request->search != null) {
            $query->whereHas('vehicle', function($q) use ($request) {
                $q->where('nopol', 'LIKE', "%{$request->search}%")
                  ->orWhere('merk', 'LIKE', "%{$request->search}%");
            });
        }

        $workOrders = $query->orderByRaw("FIELD(status, 'proses', 'pending', 'selesai')")
                            ->orderBy('estimasi_selesai', 'asc')
                            ->get();

        return view('foreman.progress.index', compact('workOrders'));
    }

    public function editProgress($id)
    {
        $selectedSPK = WorkOrder::query()->with(['allocations', 'vehicle'])->findOrFail($id);
        $workOrder = $selectedSPK; 
        $mechanics = Mechanic::query()->where('is_active', true)->orderBy('name', 'asc')->get();
        
        $allocations = [];
        foreach($selectedSPK->allocations as $alloc) {
            $allocations[$alloc->stage] = [
                'mechanic_id' => $alloc->mechanic_id,
                'start_time' => $alloc->start_time ? date('H:i', strtotime($alloc->start_time)) : null,
                'end_time' => $alloc->end_time ? date('H:i', strtotime($alloc->end_time)) : null
            ];
        }

        return view('foreman.progress.edit', compact('selectedSPK', 'workOrder', 'mechanics', 'allocations'));
    }

    /**
     * =================================================================
     * 3. ACTION: UPDATE PROGRES + UPLOAD FOTO SESUDAH
     * =================================================================
     */
    public function updateProgress(Request $request)
    {
        $stageConfig = [
            'Menunggu'          => ['field' => null,                   'percent' => 0],
            'Body Repair'       => ['field' => 'mechanic_body',        'percent' => 25],
            'Preparation'       => ['field' => 'mechanic_preparation', 'percent' => 50],
            'Paint / Oven'      => ['field' => 'mechanic_paint',       'percent' => 75],
            'Poles / Finishing' => ['field' => 'mechanic_poles',       'percent' => 90],
            'Washing'           => ['field' => 'mechanic_washing',     'percent' => 100],
        ];

        $rules = [
            'work_order_id' => 'required',
            'repair_stage'  => 'required',
            'foto_sesudah'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];

        if (isset($stageConfig[$request->repair_stage]) && $stageConfig[$request->repair_stage]['field'] != null) {
            $rules[$stageConfig[$request->repair_stage]['field']] = 'required';
            $messages = [
                $stageConfig[$request->repair_stage]['field'].'.required' => "Waduh! Teknisi untuk tahap " . $request->repair_stage . " wajib dipilih!"
            ];
            $request->validate($rules, $messages);
        } else {
            $request->validate($rules);
        }

        $wo = WorkOrder::query()->findOrFail($request->work_order_id);

        $fotoSesudahPath = $wo->foto_sesudah;
        
        if ($request->input('hapus_foto_sesudah') == '1') {
            if ($wo->foto_sesudah && Storage::disk('public')->exists($wo->foto_sesudah)) {
                Storage::disk('public')->delete($wo->foto_sesudah);
            }
            $fotoSesudahPath = null;
        }

        if ($request->hasFile('foto_sesudah')) {
            if ($wo->foto_sesudah && Storage::disk('public')->exists($wo->foto_sesudah)) {
                Storage::disk('public')->delete($wo->foto_sesudah);
            }
            $fotoSesudahPath = $request->file('foto_sesudah')->store('work_orders/sesudah', 'public');
        }

        // 🔥 PERBAIKAN LOGIC ADA DI SINI BRO 🔥
        $currentPIC = $wo->mechanic_id;
        $newStatus = $wo->status;

        // Kalo Foreman balikin stage jadi "Menunggu"
        if ($request->repair_stage == 'Menunggu') {
            $newStatus = 'pending'; // Balikin status jadi antrian awal
            $currentPIC = null;     // Hapus nama PIC dari tampilan
        } else {
            // Kalo stage selain menunggu, pastikan status jalan jadi proses
            if ($wo->status == 'pending') {
                $newStatus = 'proses';
            }
            // Update PIC sesuai stage yang aktif
            if (isset($stageConfig[$request->repair_stage]) && $stageConfig[$request->repair_stage]['field']) {
                $fieldName = $stageConfig[$request->repair_stage]['field'];
                if($request->has($fieldName)) {
                    $currentPIC = $request->input($fieldName);
                }
            }
        }
        
        $newProgress = $stageConfig[$request->repair_stage]['percent'] ?? $wo->progress;

        $wo->update([
            'status'       => $newStatus, 
            'repair_stage' => $request->repair_stage,
            'progress'     => $newProgress,
            'mechanic_id'  => $currentPIC, // PIC beneran diupdate kosong kalo nunggu
            'foto_sesudah' => $fotoSesudahPath 
        ]);

        // Simpan / Hapus data alokasi mekanik per stage
        $stages = ['Body', 'Preparation', 'Paint', 'Poles', 'Washing'];
        foreach ($stages as $stage) {
            $key = strtolower($stage);
            $mechanicId = $request->input("mechanic_" . $key);
            
            if ($mechanicId) {
                WorkOrderAllocation::query()->updateOrCreate(
                    ['work_order_id' => $wo->id, 'stage' => $stage],
                    [
                        'mechanic_id' => $mechanicId,
                        'start_time' => $request->input("start_" . $key),
                        'end_time' => $request->input("end_" . $key)
                    ]
                );
            } else {
                WorkOrderAllocation::query()->where('work_order_id', $wo->id)
                                   ->where('stage', $stage)
                                   ->delete();
            }
        }

        return redirect()->route('foreman.progress.index')
                         ->with('success', 'Update berhasil! Plotting Mekanik sudah disesuaikan. 🚀');
    }

    /**
     * =================================================================
     * 4. ACTION BUTTONS & PRINT
     * =================================================================
     */

    public function printProgress($id)
    {
        $wo = WorkOrder::query()->with(['vehicle.customer', 'allocations.mechanic', 'details'])
                        ->findOrFail($id);

        return view('foreman.print_progress', compact('wo'));
    }

    public function updatePanel(Request $request, $id) 
    { 
        return redirect()->back(); 
    }

    public function finishWorkOrder($id)
    {
        $wo = WorkOrder::query()->findOrFail($id);
        
        $wo->update([
            'repair_stage' => 'Washing',
            'progress' => 100, 
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Unit berhasil diproses sampai tahap Washing! Silakan infokan ke SA untuk QC Final & Serah Terima.');
    }

    public function reopenWorkOrder($id)
    {
        $wo = WorkOrder::query()->findOrFail($id);
        $wo->update(['status' => 'proses']);
        return redirect()->back()->with('warning', 'Status unit dibatalkan selesai.');
    }

    /**
     * =================================================================
     * 5. REKAP KINERJA MEKANIK (VERSI REAL-TIME PER TAHAP)
     * =================================================================
     */
    public function rekapKinerja(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $mechanics = Mechanic::query()->with(['allocations' => function($query) use ($bulan, $tahun) {
            $query->whereNotNull('end_time') 
                  ->whereMonth('end_time', $bulan)
                  ->whereYear('end_time', $tahun)
                  ->with('workOrder.vehicle');
        }])
        ->where('is_active', true)
        ->get();

        return view('foreman.rekap_mekanik', compact('mechanics', 'bulan', 'tahun'));
    }

    public function printRekap(Request $request)
    {
        $bulan = (int) $request->input('bulan', date('m'));
        $tahun = (int) $request->input('tahun', date('Y'));

        $mechanics = Mechanic::query()->with(['allocations' => function($query) use ($bulan, $tahun) {
            $query->whereNotNull('end_time')
                  ->whereMonth('end_time', $bulan)
                  ->whereYear('end_time', $tahun)
                  ->with('workOrder.vehicle'); 
        }])
        ->where('is_active', true)
        ->get();

        return view('foreman.print_rekap', compact('mechanics', 'bulan', 'tahun'));
    }
}