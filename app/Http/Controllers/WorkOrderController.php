<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\WorkOrderDetail;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WorkOrderController extends Controller
{
    // 1. Index (List SPK) - DITAMBAHIN LOGIC FILTER HISTORIS
    public function index(Request $request)
    {
        $query = WorkOrder::query()->with('vehicle.customer')->latest();

        // =========================================================
        // JURUS SKRIPSI: Filter Log Historis (Aktif vs Selesai)
        // =========================================================
        if ($request->has('filter')) {
            if ($request->filter == 'aktif') {
                $query->whereIn('status', ['pending', 'proses']);
            } elseif ($request->filter == 'selesai') {
                $query->where('status', 'selesai');
            }
        }

        // Filter Pencarian (Search)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_spk', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhereHas('vehicle', function($v) use ($search) {
                      $v->where('nopol', 'like', "%{$search}%")
                        ->orWhere('merk', 'like', "%{$search}%")
                        ->orWhere('model', 'like', "%{$search}%");
                  })
                  ->orWhereHas('vehicle.customer', function($c) use ($search) {
                      $c->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $workOrders = $query->paginate(10)->withQueryString();
        return view('work_orders.index', compact('workOrders'));
    }

    // 2. Form Create
    public function create()
    {
        $vehicles = Vehicle::with('customer')->orderBy('nopol', 'ASC')->get();
        
        $latestSpk = WorkOrder::whereYear('created_at', date('Y'))
                              ->whereMonth('created_at', date('m'))
                              ->orderBy('id', 'desc')
                              ->first();
        $urut = 1;
        if ($latestSpk && preg_match('/-(\d{4})$/', $latestSpk->nomor_spk, $matches)) {
            $urut = (int)$matches[1] + 1;
        }
        $nomorSpk = 'SPK-' . date('Ym') . '-' . sprintf("%04d", $urut);

        return view('work_orders.create', compact('vehicles', 'nomorSpk'));
    }

    // 3. Store (MURNI SIMPAN SPK + FOTO SEBELUM)
    public function store(Request $request)
    {
        $reqData = $request->all();
        if(isset($reqData['estimasi_biaya'])) {
            $reqData['estimasi_biaya'] = (int) str_replace(['Rp', '.', ',', ' '], '', $reqData['estimasi_biaya']);
        }
        if(isset($reqData['harga']) && is_array($reqData['harga'])) {
            foreach($reqData['harga'] as $k => $v) {
                $reqData['harga'][$k] = (int) str_replace(['Rp', '.', ',', ' '], '', $v);
            }
        }
        $request->replace($reqData); 

        if (!$request->filled('nomor_spk')) {
            $latestSpk = WorkOrder::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->orderBy('id', 'desc')->first();
            $urut = 1;
            if ($latestSpk && preg_match('/-(\d{4})$/', $latestSpk->nomor_spk, $matches)) {
                $urut = (int)$matches[1] + 1;
            }
            $request->merge(['nomor_spk' => 'SPK-' . date('Ym') . '-' . sprintf("%04d", $urut)]);
        }

        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required',
            'nomor_spk' => 'required|unique:work_orders',
            'status' => 'required',
            'tanggal_masuk' => 'required|date',
            'panel_name' => 'nullable|array', 
            'foto_sebelum' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            dd('GAGAL SIMPAN BRO! Cek Error Ini:', $validator->errors()->all(), 'Data yg dikirim:', $request->all());
        }

        $fotoSebelumPath = null;
        if ($request->hasFile('foto_sebelum')) {
            $fotoSebelumPath = $request->file('foto_sebelum')->store('work_orders/sebelum', 'public');
        }

        $spk = WorkOrder::create([
            'vehicle_id' => $request->vehicle_id,
            'nomor_spk' => $request->nomor_spk,
            'status' => $request->status,            
            'repair_type' => $request->repair_type, 
            'keluhan_customer' => $request->keluhan_customer,
            'tanggal_masuk' => $request->tanggal_masuk,
            'estimasi_selesai' => $request->estimasi_selesai,
            'diskon' => $request->diskon ?? 0, 
            'estimasi_biaya' => $request->estimasi_biaya ?? 0, 
            'foto_sebelum' => $fotoSebelumPath,
        ]);

        if ($request->has('panel_name')) {
            foreach ($request->panel_name as $key => $panel) {
                if (!empty($panel)) {
                    $partStatus = $request->part_status[$key] ?? 'Ready';
                    WorkOrderDetail::create([
                        'work_order_id' => $spk->id,
                        'panel_name'    => $panel,
                        'kerusakan'     => $request->kerusakan[$key] ?? '-',
                        'harga'         => $request->harga[$key] ?? 0,
                        'part_status'   => $partStatus, 
                    ]);
                }
            }
        }

        return redirect()->route('work-orders.index')->with('success', 'SPK dan Foto Unit Berhasil Dibuat! (Request Sparepart masuk antrian Logistik)');
    }

    // 4. Form Edit
    public function edit(WorkOrder $workOrder)
    {
        $vehicles = Vehicle::with('customer')->orderBy('nopol', 'ASC')->get();
        $details = $workOrder->details;

        $workOrder->estimasi_biaya = (int) $workOrder->estimasi_biaya;
        foreach ($details as $detail) {
            $detail->harga = (int) $detail->harga;
        }

        return view('work_orders.edit', compact('workOrder', 'vehicles', 'details'));
    }

    // 5. Update
    public function update(Request $request, WorkOrder $workOrder)
    {
        $reqData = $request->all();
        if(isset($reqData['estimasi_biaya'])) {
            $reqData['estimasi_biaya'] = (int) str_replace(['Rp', '.', ',', ' '], '', $reqData['estimasi_biaya']);
        }
        if(isset($reqData['harga']) && is_array($reqData['harga'])) {
            foreach($reqData['harga'] as $k => $v) {
                $reqData['harga'][$k] = (int) str_replace(['Rp', '.', ',', ' '], '', $v);
            }
        }
        $request->replace($reqData);

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'vehicle_id' => 'required',
            'status' => 'required',
            'panel_name' => 'nullable|array',
            'foto_sebelum' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            dd('GAGAL UPDATE BRO! Cek Error Ini:', $validator->errors()->all(), 'Data yg dikirim:', $request->all());
        }

        $fotoSebelumPath = $workOrder->foto_sebelum; 
        
        // --- TAMBAHAN LOGIC HAPUS FOTO ---
        if ($request->input('hapus_foto_sebelum') == '1') {
            if ($workOrder->foto_sebelum && \Illuminate\Support\Facades\Storage::disk('public')->exists($workOrder->foto_sebelum)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($workOrder->foto_sebelum);
            }
            $fotoSebelumPath = null;
        }

        if ($request->hasFile('foto_sebelum')) {
            if ($workOrder->foto_sebelum && \Illuminate\Support\Facades\Storage::disk('public')->exists($workOrder->foto_sebelum)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($workOrder->foto_sebelum);
            }
            $fotoSebelumPath = $request->file('foto_sebelum')->store('work_orders/sebelum', 'public');
        }

        $statusLama = $workOrder->status;

        $workOrder->update([
            'vehicle_id' => $request->vehicle_id,
            'status' => $request->status,
            'repair_type' => $request->repair_type, 
            'keluhan_customer' => $request->keluhan_customer,
            'tanggal_masuk' => $request->tanggal_masuk,
            'estimasi_selesai' => $request->estimasi_selesai,
            'diskon' => $request->diskon ?? 0,
            'estimasi_biaya' => $request->estimasi_biaya ?? 0, 
            'foto_sebelum' => $fotoSebelumPath, 
        ]);

        $oldDetails = WorkOrderDetail::where('work_order_id', $workOrder->id)->get()->keyBy('panel_name');
        WorkOrderDetail::where('work_order_id', $workOrder->id)->delete();

        if ($request->has('panel_name')) {
            foreach ($request->panel_name as $key => $panel) {
                if (!empty($panel)) {
                    $partStatus = $request->part_status[$key] ?? 'Ready';
                    if (isset($oldDetails[$panel])) {
                        $oldStatus = $oldDetails[$panel]->part_status;
                        if (in_array($oldStatus, ['Ordered', 'Received'])) {
                            $partStatus = $oldStatus;
                        }
                    }
                    WorkOrderDetail::create([
                        'work_order_id' => $workOrder->id,
                        'panel_name'    => $panel,
                        'kerusakan'     => $request->kerusakan[$key] ?? '-',
                        'harga'         => $request->harga[$key] ?? 0,
                        'part_status'   => $partStatus,
                    ]);
                }
            }
        }

        if ($statusLama !== 'selesai' && $request->status === 'selesai') {
            $woData = WorkOrder::with('vehicle.customer')->find($workOrder->id);
            $nomorCustomer = $woData->vehicle->customer->phone ?? null;
            
            if ($nomorCustomer) {
                $namaCustomer = $woData->vehicle->customer->name ?? 'Bapak/Ibu';
                $nopol = $woData->vehicle->nopol ?? '';
                
                $pesan = "Halo {$namaCustomer},\n\nMobil kesayangan Anda dengan plat nomor *{$nopol}* sudah selesai diperbaiki dan dipoles mulus di Body & Paint Wira Toyota Banjarmasin.\n\nSilakan datang ke bengkel untuk serah terima unit ya. Terima kasih! 🚗✨";

                try {
                    \Illuminate\Support\Facades\Http::withHeaders([
                        'Authorization' => 'zy7KeVbgjote2Pu4R464' 
                    ])->post('https://api.fonnte.com/send', [
                        'target' => $nomorCustomer,
                        'message' => $pesan,
                    ]);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Gagal kirim WA Notif Selesai: ' . $e->getMessage());
                }
            }
        }

        return redirect()->route('work-orders.index')->with('success', 'Mantap Bro! Data SPK & Status Berhasil Diperbarui!');
    }

    // 6. Delete
    public function destroy(WorkOrder $workOrder)
    {
        if ($workOrder->foto_sebelum && \Illuminate\Support\Facades\Storage::disk('public')->exists($workOrder->foto_sebelum)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($workOrder->foto_sebelum);
        }
        if ($workOrder->foto_sesudah && \Illuminate\Support\Facades\Storage::disk('public')->exists($workOrder->foto_sesudah)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($workOrder->foto_sesudah);
        }

        $workOrder->details()->delete(); 
        \App\Models\WorkOrderAllocation::where('work_order_id', $workOrder->id)->delete();
        \Illuminate\Support\Facades\DB::table('bahan_spks')->where('work_order_id', $workOrder->id)->delete();
        \Illuminate\Support\Facades\DB::table('attendance_details')->where('work_order_id', $workOrder->id)->delete();
        $workOrder->delete(); 

        return redirect()->route('work-orders.index')->with('success', 'Mantap! SPK, Foto, dan seluruh riwayat datanya berhasil dihapus bersih tanpa sisa! 🗑️');
    }

    // 7. Cetak Invoice Satuan Kertas
    public function show(WorkOrder $workOrder)
    {
        $workOrder->load(['vehicle.customer', 'details', 'bahanSpks.bahan']);
        return view('work_orders.show', compact('workOrder'));
    }

    // 7B. Halaman Monitor Detail SA
    public function detail($id)
    {
        $workOrder = WorkOrder::with([
            'vehicle.customer', 'details', 'bahanSpks.bahan', 'bahanSpks.mechanic'
        ])->findOrFail($id);

        return view('work_orders.detail', compact('workOrder'));
    }

    // 8. Print Laporan Rekap
    public function print()
    {
        $workOrders = WorkOrder::with(['vehicle.customer'])->latest()->get();
        return view('work_orders.print_recap', compact('workOrders'));
    }
}