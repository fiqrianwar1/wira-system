<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mechanic;
use App\Models\Attendance;
use App\Models\WorkOrder;
use App\Models\AttendanceDetail; // Tambahin ini biar aman
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /**
     * 1. INDEX
     */
    public function index(Request $request)
    {
        // PERBAIKAN DISINI:
        // Dulu: with(['mechanic', 'workOrder.vehicle']) -> ERROR
        // Sekarang: with(['mechanic', 'details.workOrder.vehicle']) -> BENER
        // Kita load 'details' dulu, baru dalemnya ada 'workOrder'
        $query = Attendance::with(['mechanic', 'details.workOrder.vehicle']);

        if ($request->has('search') && $request->search != null) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('mechanic', function($subQ) use ($search) {
                    $subQ->where('name', 'LIKE', "%{$search}%");
                })
                // Cari di dalam details -> workOrder -> vehicle
                ->orWhereHas('details.workOrder.vehicle', function($subQ) use ($search) {
                    $subQ->where('nopol', 'LIKE', "%{$search}%");
                });
            });
        }

        if ($request->has('date') && $request->date != null) {
            $query->whereDate('date', $request->date);
        }

        $attendances = $query->orderBy('date', 'desc')
                             ->orderBy('created_at', 'desc')
                             ->paginate(10);

        return view('foreman.absensi.index', compact('attendances'));
    }

    /**
     * 2. PRINT LAPORAN
     */
    public function print(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));

        // PERBAIKAN DISINI JUGA:
        // Load 'details.workOrder.vehicle'
        $attendances = Attendance::with(['mechanic', 'details.workOrder.vehicle'])
                        ->whereDate('date', $date)
                        ->orderBy('created_at', 'asc')
                        ->get();

        return view('foreman.absensi.print', compact('attendances', 'date'));
    }

    /**
     * 3. CREATE
     */
    public function create()
    {
        $mechanics = Mechanic::where('is_active', true)->orderBy('position', 'asc')->get();
        $activeSPKs = WorkOrder::whereIn('status', ['pending', 'proses'])->with('vehicle')->orderBy('created_at', 'desc')->get();
        return view('foreman.absensi.create', compact('mechanics', 'activeSPKs'));
    }

    /**
     * 4. STORE (SIMPAN BANYAK JOB)
     */
    public function store(Request $request)
    {
        $request->validate([
            'mechanic_id' => 'required',
            'date' => 'required|date',
            'status' => 'required',
            'spk_ids' => 'nullable|array', // Validasi Array
            'mechanic_id' => 'unique:attendances,mechanic_id,NULL,id,date,' . $request->date
        ]);

        // 1. Simpan Induk
        $attendance = Attendance::create([
            'mechanic_id' => $request->mechanic_id,
            'date' => $request->date,
            'status' => $request->status,
            'note' => $request->note
        ]);

        // 2. Simpan Anak (Detail Job)
        if ($request->has('spk_ids') && $request->status == 'Hadir') {
            foreach ($request->spk_ids as $spk_id) {
                if (!empty($spk_id)) {
                    AttendanceDetail::create([
                        'attendance_id' => $attendance->id,
                        'work_order_id' => $spk_id
                    ]);
                }
            }
        }

        return redirect()->route('absensi.index')->with('success', 'Data berhasil disimpan!');
    }

    /**
     * 5. EDIT
     */
    public function edit($id)
    {
        // Load details biar muncul pas diedit
        $attendance = Attendance::with('details')->findOrFail($id);
        
        $mechanics = Mechanic::orderBy('name', 'asc')->get();
        
        // Ambil SPK aktif + SPK yang udah dipake di data ini (biar gak ilang dr dropdown)
        // Kita ambil ID SPK yang ada di detail
        $usedSpkIds = $attendance->details->pluck('work_order_id')->toArray();
        
        $activeSPKs = WorkOrder::whereIn('status', ['pending', 'proses'])
                               ->orWhereIn('id', $usedSpkIds)
                               ->with('vehicle')
                               ->get();

        return view('foreman.absensi.edit', compact('attendance', 'mechanics', 'activeSPKs'));
    }

    /**
     * 6. UPDATE (LOGIC UPDATE BANYAK JOB)
     */
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        // 1. Update Induk
        $attendance->update([
            'mechanic_id' => $request->mechanic_id,
            'date' => $request->date,
            'status' => $request->status,
            'note' => $request->note
        ]);

        // 2. Update Anak (Hapus Lama -> Simpan Baru)
        // Ini cara paling gampang biar gak ribet ngecek satu-satu
        
        // Hapus semua job lama milik absen ini
        AttendanceDetail::where('attendance_id', $id)->delete();

        // Simpan ulang job baru yang dipilih
        if ($request->has('spk_ids') && $request->status == 'Hadir') {
            foreach ($request->spk_ids as $spk_id) {
                if (!empty($spk_id)) {
                    AttendanceDetail::create([
                        'attendance_id' => $attendance->id,
                        'work_order_id' => $spk_id
                    ]);
                }
            }
        }

        return redirect()->route('absensi.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * 7. DESTROY
     */
    public function destroy($id)
    {
        // Karena di migration udah pake cascadeOnDelete, 
        // pas induk dihapus, anaknya (detail) otomatis kehapus. Aman.
        Attendance::findOrFail($id)->delete();
        return redirect()->route('absensi.index')->with('success', 'Data dihapus.');
    }
}