<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    // =========================================================================
    // 1. AREA CUSTOMER (SUBMIT KOMPLAIN)
    // =========================================================================
    public function store(Request $request)
    {
        $request->validate([
            'work_order_id' => 'required|exists:work_orders,id',
            'keluhan'       => 'required|string',
            'foto_bukti'    => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Simpan foto bukti dari customer
        $fotoPath = $request->file('foto_bukti')->store('complaints', 'public');

        Complaint::create([
            'work_order_id' => $request->work_order_id,
            'keluhan'       => $request->keluhan,
            'foto_bukti'    => $fotoPath,
            'status'        => 'menunggu'
        ]);

        return redirect()->back()->with('success', 'Komplain berhasil dikirim! Silakan tunggu konfirmasi dari Service Advisor Wira Toyota.');
    }

    // =========================================================================
    // 2. AREA SERVICE ADVISOR (SA) - KELOLA KOMPLAIN
    // =========================================================================
    public function indexSA()
    {
        // Tarik semua komplain lengkap sama data SPK dan customernya
        $complaints = Complaint::with(['workOrder.vehicle.customer'])
                        ->latest()
                        ->get();
                        
        return view('sa.complaints.index', compact('complaints'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status'     => 'required|in:disetujui,ditolak',
            'catatan_sa' => 'required|string'
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->update([
            'status'     => $request->status,
            'catatan_sa' => $request->catatan_sa
        ]);

        return redirect()->back()->with('success', 'Status garansi/komplain berhasil diupdate!');
    }

    // Batalkan keputusan SA (disetujui/ditolak) -> balikin lagi ke 'menunggu' biar bisa direview ulang
    public function cancelDecision($id)
    {
        $complaint = Complaint::findOrFail($id);

        if (in_array($complaint->status, ['disetujui', 'ditolak'])) {
            $complaint->update([
                'status'     => 'menunggu',
                'catatan_sa' => null
            ]);

            return redirect()->back()->with('success', 'Keputusan dibatalkan, klaim dikembalikan ke status Menunggu Review.');
        }

        return redirect()->back()->with('error', 'Gagal! Klaim ini masih menunggu review, belum ada keputusan yang bisa dibatalkan.');
    }

    // =========================================================================
    // AREA CUSTOMER (TAMPILAN KOMPLAIN)
    // =========================================================================
    public function indexCustomer()
    {
        $customer = \App\Models\Customer::where('email', Auth::user()->email)->first();

        if (!$customer) {
            abort(403, 'Data Customer tidak ditemukan.');
        }

        // Tarik riwayat komplain customer ini
        $complaints = \App\Models\Complaint::with(['workOrder.vehicle'])
                        ->whereHas('workOrder.vehicle', function($q) use ($customer) {
                            $q->where('customer_id', $customer->id);
                        })
                        ->latest()
                        ->get();

        // Tarik SPK yang statusnya 'selesai' buat di dropdown Form Komplain
        $eligibleSpks = \App\Models\WorkOrder::with('vehicle')
                        ->whereHas('vehicle', function($q) use ($customer) {
                            $q->where('customer_id', $customer->id);
                        })
                        ->where('status', 'selesai')
                        ->latest()
                        ->get();

        return view('customers.complaints', compact('complaints', 'eligibleSpks'));
    } 
    
    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);

        // Validasi: Komplain yang masih 'menunggu' ATAU sudah 'ditolak' boleh dibatalkan
        // (Kalo udah 'disetujui' gak boleh, soalnya udah diproses garansinya)
        if (in_array($complaint->status, ['menunggu', 'ditolak'])) {
            
            // Hapus file foto bukti dari storage biar hardisk server/hosting gak penuh
            if (Storage::disk('public')->exists($complaint->foto_bukti)) {
                Storage::disk('public')->delete($complaint->foto_bukti);
            }
            
            // Hapus data dari database
            $complaint->delete();
            
            return redirect()->back()->with('success', 'Pengajuan komplain berhasil dibatalkan dan ditarik kembali.');
        }

        return redirect()->back()->with('error', 'Gagal! Komplain sudah disetujui oleh Service Advisor dan tidak bisa dibatalkan.');
    }
}