<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\WorkOrder;
use App\Models\WorkOrderDetail;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tangkap filter bulan & tahun dari dropdown, paksa jadi (int) biar gak error 500
        $bulan = (int) $request->input('bulan', date('m'));
        $tahun = (int) $request->input('tahun', date('Y'));

        // 2. Filter tabel PO berdasarkan bulan & tahun
        $purchaseOrders = PurchaseOrder::with(['items', 'workOrder.vehicle'])
                            ->whereMonth('order_date', $bulan)
                            ->whereYear('order_date', $tahun)
                            ->latest()
                            ->paginate(10)
                            ->appends($request->all()); // Biar pas pindah page (pagination), filternya gak ilang

        // FITUR SAKTI: Cari SPK yang ada barang status 'Order' (Request dari SA)
        $pendingSpks = WorkOrder::with('vehicle')
            ->whereHas('details', function($q) {
                $q->where('part_status', 'Order');
            })
            ->with(['details' => function($q) {
                $q->where('part_status', 'Order');
            }])
            ->latest()
            ->get();

        // 3. Jangan lupa lempar variabel $bulan dan $tahun ke view
        return view('spareparts.purchases.index', compact('purchaseOrders', 'pendingSpks', 'bulan', 'tahun'));
    }

    public function create(Request $request)
    {
        // JURUS ANTI NYANGKUT: Tarik SPK yang Pending/Proses, ATAU yang masih punya utang part_status = 'Order'
        $allSpks = WorkOrder::with('vehicle')
                    ->where(function($q) {
                        $q->whereIn('status', ['Pending', 'PENDING', 'Proses', 'PROSES', 'Open', 'OPEN'])
                          ->orWhereHas('details', function($q2) {
                              $q2->where('part_status', 'Order');
                          });
                    })
                    ->latest()
                    ->get();

        $selectedSpk = null;
        if ($request->has('spk_id')) {
            $selectedSpk = WorkOrder::with(['vehicle', 'details' => function($q) {
                $q->where('part_status', 'Order'); 
            }])->findOrFail($request->spk_id);
        }

        return view('spareparts.purchases.create', compact('allSpks', 'selectedSpk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_name' => 'required|string',
            'order_date'    => 'required|date',
            'items'         => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            $isGudang = str_contains(strtolower(trim($request->supplier_name)), 'gudang');
            $poStatus = $isGudang ? 'Received' : 'Ordered';

            $po = PurchaseOrder::create([
                'work_order_id' => $request->work_order_id, 
                'po_number'     => 'PO-' . date('Ymd') . '-' . rand(100, 999),
                'supplier_name' => $request->supplier_name,
                'order_date'    => $request->order_date,
                'status'        => $poStatus, 
                'notes'         => $request->notes,
                'total_amount'  => 0 
            ]);

            $grandTotal = 0;

            foreach ($request->items as $item) {
                $qty = $item['qty'] ?? 1;
                $price = $item['price'] ?? 0;
                $subtotal = $qty * $price;
                $grandTotal += $subtotal;

                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'item_name'         => $item['name'],
                    'qty'               => $qty,
                    'price'             => $price,
                    'subtotal'          => $subtotal,
                ]);

                if ($isGudang) {
                    $stokTersedia = WorkOrderDetail::whereNull('work_order_id')
                                        ->where('part_status', 'Ready')
                                        ->where('panel_name', $item['name'])
                                        ->limit($qty)
                                        ->get();
                    
                    foreach($stokTersedia as $stok) {
                        $stok->delete(); 
                    }
                    $partStatusUpdate = 'Received'; 
                } else {
                    $partStatusUpdate = 'Ordered'; 
                }

                if ($request->work_order_id) {
                    WorkOrderDetail::where('work_order_id', $request->work_order_id)
                        ->where('panel_name', $item['name'])
                        ->where('part_status', 'Order')
                        ->update(['part_status' => $partStatusUpdate]);
                }
            }

            $po->update(['total_amount' => $grandTotal]);
            DB::commit();
            return redirect()->route('spareparts.purchases.index')->with('success', 'PO Berhasil Dibuat & SPK otomatis diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal Simpan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $po = PurchaseOrder::with('items')->findOrFail($id);
        
        $allSpks = WorkOrder::with('vehicle')
                    ->where(function($q) {
                        $q->whereIn('status', ['Pending', 'PENDING', 'Proses', 'PROSES', 'Open', 'OPEN'])
                          ->orWhereHas('details', function($q2) {
                              $q2->where('part_status', 'Order');
                          });
                    })
                    ->latest()
                    ->get();

        return view('spareparts.purchases.edit', compact('po', 'allSpks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_name' => 'required|string',
            'order_date'    => 'required|date',
            'status'        => 'required|string',
            'items'         => 'required|array',
        ]);

        $po = PurchaseOrder::with('items')->findOrFail($id);

        DB::beginTransaction();
        try {
            $wasGudang = str_contains(strtolower($po->supplier_name), 'gudang');
            $isGudangNow = str_contains(strtolower($request->supplier_name), 'gudang');

            if ($wasGudang) {
                foreach ($po->items as $item) {
                    for ($i = 0; $i < $item->qty; $i++) {
                        WorkOrderDetail::create([
                            'work_order_id' => null,
                            'panel_name'    => $item->item_name,
                            'harga'         => $item->price,
                            'kerusakan'     => 'Retur Revisi PO (' . $po->po_number . ')',
                            'part_status'   => 'Ready',
                            'part_location' => 'Gudang (Retur Revisi)',
                            'part_eta'      => date('Y-m-d'),
                        ]);
                    }
                }
            }

            if ($po->work_order_id) {
                $oldItemNames = $po->items->pluck('item_name')->toArray();
                WorkOrderDetail::where('work_order_id', $po->work_order_id)
                    ->whereIn('panel_name', $oldItemNames)
                    ->update(['part_status' => 'Order']);
            }

            $po->items()->delete();
            
            $newStatus = $request->status;
            if ($isGudangNow) {
                $newStatus = 'Received';
            } elseif ($wasGudang && !$isGudangNow && $request->status == 'Received') {
                $newStatus = 'Ordered'; 
            }

            $po->update([
                'work_order_id' => $request->work_order_id,
                'supplier_name' => $request->supplier_name,
                'order_date'    => $request->order_date,
                'status'        => $newStatus,
            ]);
            
            $grandTotal = 0;

            foreach ($request->items as $item) {
                if(isset($item['name']) && !empty($item['name'])) {
                    $qty = $item['qty'] ?? 1;
                    $price = $item['price'] ?? 0;
                    $subtotal = $qty * $price;
                    $grandTotal += $subtotal;

                    PurchaseOrderItem::create([
                        'purchase_order_id' => $po->id,
                        'item_name'         => $item['name'],
                        'qty'               => $qty,
                        'price'             => $price,
                        'subtotal'          => $subtotal,
                    ]);

                    if ($isGudangNow) {
                        $stokTersedia = WorkOrderDetail::whereNull('work_order_id')
                                            ->where('part_status', 'Ready')
                                            ->where('panel_name', $item['name'])
                                            ->limit($qty)
                                            ->get();
                        
                        foreach($stokTersedia as $stok) {
                            $stok->delete(); 
                        }
                        $partStatusUpdate = 'Received';
                    } else {
                        $partStatusUpdate = ($newStatus == 'Received') ? 'Received' : 'Ordered';
                    }

                    if ($request->work_order_id) {
                        WorkOrderDetail::where('work_order_id', $request->work_order_id)
                            ->where('panel_name', $item['name'])
                            ->where('part_status', 'Order')
                            ->update(['part_status' => $partStatusUpdate]);
                    }
                }
            }

            $po->update(['total_amount' => $grandTotal]);

            DB::commit();
            return redirect()->route('spareparts.purchases.index')->with('success', 'Perubahan PO & Relokasi Stok Berhasil Diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal Update: ' . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $po = PurchaseOrder::with('items')->findOrFail($id);
            $isGudang = str_contains(strtolower($po->supplier_name), 'gudang');

            if ($po->work_order_id) {
                $itemNames = $po->items->pluck('item_name')->toArray();
                WorkOrderDetail::where('work_order_id', $po->work_order_id)
                    ->whereIn('panel_name', $itemNames)
                    ->update(['part_status' => 'Order']);
            }

            if ($isGudang) {
                foreach ($po->items as $item) {
                    for ($i = 0; $i < $item->qty; $i++) {
                        WorkOrderDetail::create([
                            'work_order_id' => null, 
                            'panel_name'    => $item->item_name,
                            'harga'         => $item->price,
                            'kerusakan'     => 'Retur Batal PO (' . $po->po_number . ')',
                            'part_status'   => 'Ready', 
                            'part_location' => 'Gudang (Retur Batal PO)',
                            'part_eta'      => date('Y-m-d'),
                        ]);
                    }
                }
            }

            $po->items()->delete();
            $po->delete(); 
            
            DB::commit();
            return back()->with('success', 'PO Berhasil Dihapus. SPK dan Stok telah direstore!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal Menghapus: ' . $e->getMessage());
        }
    }

    public function print($id)
    {
        $po = PurchaseOrder::with(['items', 'workOrder.vehicle'])->findOrFail($id);
        return view('spareparts.purchases.print_single', compact('po'));
    }

    public function recap(Request $request)
    {
        // Paksa jadi (int) biar library tanggal (Carbon) gak ngambek
        $bulan = (int) $request->input('bulan', date('m'));
        $tahun = (int) $request->input('tahun', date('Y'));

        // Query cetak laporan berdasarkan filter
        $orders = PurchaseOrder::with('items')
                    ->whereMonth('order_date', $bulan)
                    ->whereYear('order_date', $tahun)
                    ->latest()
                    ->get();  
                    
        return view('spareparts.purchases.print_recap', compact('orders', 'bulan', 'tahun'));
    }
    
    public function monitoring()
    {
        $trackings = PurchaseOrder::with(['items', 'workOrder.vehicle'])
                        ->latest()
                        ->paginate(12);
        return view('spareparts.monitoring.index', compact('trackings'));
    }
}