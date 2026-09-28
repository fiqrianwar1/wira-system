<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\WorkOrderDetail;
use App\Models\PurchaseOrder; 
use App\Models\PurchaseOrderItem; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // Tambahan buat hapus foto nota lama

class SparepartController extends Controller
{
    // =================================================================
    // 1. DASHBOARD UTAMA GUDANG
    // =================================================================
    public function index()
    {
        $totalPO = PurchaseOrder::count();
                        
        $totalOtw = PurchaseOrderItem::whereHas('purchaseOrder', function ($query) {
            $query->where('status', 'Ordered');
        })->sum('qty');

        $totalReady = PurchaseOrderItem::whereHas('purchaseOrder', function ($query) {
            $query->where('status', 'Received');
        })->sum('qty');

        $totalBelanja = PurchaseOrder::sum('total_amount');

        $months = []; 
        $monthlySpending = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->startOfMonth()->subMonths($i);
            $months[] = $date->translatedFormat('M Y');
            
            $spend = PurchaseOrder::whereMonth('order_date', $date->month)
                                  ->whereYear('order_date', $date->year)
                                  ->sum('total_amount');
                                  
            $monthlySpending[] = $spend;
        }

        $recentPOs = PurchaseOrder::with('items')->latest()->take(4)->get();

        $pendingSpks = WorkOrder::with('vehicle')
            ->whereHas('details', function($q) {
                $q->where('part_status', 'Order')
                  ->where(function($sub) {
                      $sub->where('kerusakan', 'LIKE', '%GT%')
                          ->orWhere('kerusakan', 'LIKE', '%GC%')
                          ->orWhere('kerusakan', 'LIKE', '%Ganti%');
                  });
            })
            ->with(['details' => function($q) {
                $q->where('part_status', 'Order')
                  ->where(function($sub) {
                      $sub->where('kerusakan', 'LIKE', '%GT%')
                          ->orWhere('kerusakan', 'LIKE', '%GC%')
                          ->orWhere('kerusakan', 'LIKE', '%Ganti%');
                  });
            }])
            ->latest()
            ->get();

        return view('spareparts.dashboard', compact(
            'totalPO', 'totalOtw', 'totalReady', 'totalBelanja',
            'months', 'monthlySpending', 'recentPOs', 'pendingSpks' 
        ));
    }

    // =================================================================
    // 2. STOK GUDANG (VISUAL MONITORING & MANAJEMEN STOK)
    // =================================================================
    public function stockIndex()
    {
        $stockCounts = WorkOrderDetail::whereNull('work_order_id')
                        ->where('part_status', 'Ready')
                        ->select('panel_name', DB::raw('count(*) as total'))
                        ->groupBy('panel_name')
                        ->pluck('total', 'panel_name')
                        ->toArray();

        $rawHistory = WorkOrderDetail::where('kerusakan', 'LIKE', 'Stok Manual%')
                        ->latest()
                        ->take(50) 
                        ->get();

        $groupedHistory = $rawHistory->groupBy(function($item) {
            return $item->created_at->format('Y-m-d H:i:s') . '|' . $item->kerusakan;
        })->map(function ($items) {
            $firstItem = $items->first();
            
            $recapItems = $items->groupBy('panel_name')->map(function($group) {
                return [
                    'id'          => $group->first()->id, 
                    'panel_name'  => $group->first()->panel_name,
                    'qty'         => $group->count(), 
                    'unit_price'  => $group->first()->harga, 
                    'subtotal'    => $group->sum('harga'), 
                    'status'      => $group->first()->part_status
                ];
            })->values(); 

            return [
                'date'       => $firstItem->created_at,
                'eta'        => $firstItem->part_eta,
                'source'     => str_replace(['Stok Manual (', ')'], '', $firstItem->kerusakan),
                'location'   => $firstItem->part_location,
                'foto_nota'  => $firstItem->foto_nota,
                'total_qty'  => $items->count(),
                'total_cost' => $items->sum('harga'),
                'items'      => $recapItems 
            ];
        });

        $panelCategories = [
            'BAGIAN DEPAN (FRONT)' => [
                'items' => ['Bumper Depan', 'Bodykit Bumper Depan', 'Grill', 'Kap Mesin (Hood)', 'Kaca Depan', 'Headlamp Kanan', 'Headlamp Kiri'],
                'color' => 'blue',
                'icon'  => '<path fill="currentColor" d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/>'
            ],
            'SAMPING KANAN (RIGHT)' => [
                'items' => ['Fender Kanan Depan', 'Pintu Depan Kanan', 'Pintu Tengah Kanan', 'Pillar Kanan', 'Quarter Panel Kanan', 'Triplank Kanan', 'Molding Depan Kanan', 'Molding Belakang Kanan', 'Spion Kanan', 'Kaca Pintu Kanan'],
                'color' => 'indigo',
                'icon'  => '<path fill="currentColor" d="M21.5 10.5l-3.5-3.5A2 2 0 0 0 16.6 6.4h-5.2a3 3 0 0 0-2.4 1l-2.5 3.1H3.5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h.6a2.5 2.5 0 1 0 4.8 0h6.2a2.5 2.5 0 1 0 4.8 0h.6a1 1 0 0 0 1-1v-4a1 1 0 0 0-.5-.9zM6.5 17a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm11 0a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm-1-6.5h-5V8h2.6a1 1 0 0 1 .7.3l2.2 2.2z" />'
            ],
            'SAMPING KIRI (LEFT)' => [
                'items' => ['Fender Kiri Depan', 'Pintu Depan Kiri', 'Pintu Tengah Kiri', 'Pillar Kiri', 'Quarter Panel Kiri', 'Triplank Kiri', 'Molding Depan Kiri', 'Molding Belakang Kiri', 'Spion Kiri', 'Kaca Pintu Kiri'],
                'color' => 'purple',
                'icon'  => '<path fill="currentColor" transform="scale(-1, 1) translate(-24, 0)" d="M21.5 10.5l-3.5-3.5A2 2 0 0 0 16.6 6.4h-5.2a3 3 0 0 0-2.4 1l-2.5 3.1H3.5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h.6a2.5 2.5 0 1 0 4.8 0h6.2a2.5 2.5 0 1 0 4.8 0h.6a1 1 0 0 0 1-1v-4a1 1 0 0 0-.5-.9zM6.5 17a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm11 0a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm-1-6.5h-5V8h2.6a1 1 0 0 1 .7.3l2.2 2.2z" />'
            ],
            'BAGIAN BELAKANG (REAR)' => [
                'items' => ['Bagasi (Trunk)', 'Bumper Belakang', 'Bodykit Bumper Belakang', 'Kaca Belakang', 'Stoplamp Kanan', 'Stoplamp Kiri', 'Spoiler'],
                'color' => 'pink',
                'icon'  => '<path fill="currentColor" d="M19 8l-1.5-4h-11L5 8H3v9h2v2h3v-2h8v2h3v-2h2V8h-2zm-12-2h10l1 3H6l1-3zm-1 8H5v-2h1v2zm11 0h-1v-2h1v2zm-2.5-4h-5v-1h5v1z" />'
            ],
            'ATAP & LAINNYA' => [
                'items' => ['Atap (Roof)', 'Velg / Roda'],
                'color' => 'gray',
                'icon'  => '<path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"/>'
            ]
        ];

        return view('spareparts.stocks.index', compact('stockCounts', 'panelCategories', 'groupedHistory'));
    }

    public function stockCreate(Request $request)
    {
        $selectedPanel = $request->query('panel'); 
        $spkList = WorkOrder::whereIn('status', ['pending', 'proses'])->latest()->get();
        return view('spareparts.stocks.create', compact('selectedPanel', 'spkList'));
    }

    public function stockStore(Request $request)
    {
        $request->validate([
            'source'        => 'required|string',
            'part_location' => 'required|string',
            'part_eta'      => 'required|date',
            'panel_names'   => 'required|array',
            'panel_names.*' => 'required|string',
            'quantities'    => 'required|array',
            'quantities.*'  => 'required|integer|min:1',
            'prices'        => 'nullable|array',
            'foto_nota'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // Tambahan mimes
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_nota')) {
            $fotoPath = $request->file('foto_nota')->store('spareparts/nota', 'public');
        }

        // Pakai DB Transaction biar aman bro
        DB::beginTransaction();
        try {
            foreach ($request->panel_names as $index => $panelName) {
                $qty = $request->quantities[$index];
                $price = $request->prices[$index] ?? 0;

                for ($i = 0; $i < $qty; $i++) {
                    WorkOrderDetail::create([
                        'work_order_id' => null,
                        'panel_name'    => $panelName,
                        'harga'         => $price,
                        'kerusakan'     => 'Stok Manual (' . $request->source . ')',
                        'part_status'   => 'Ready', 
                        'part_location' => $request->part_location, 
                        'part_eta'      => $request->part_eta,
                        'foto_nota'     => $fotoPath,
                    ]);
                }
            }
            
            DB::commit();
            return redirect()->route('spareparts.stocks.index')
                             ->with('success', 'Stok dari ' . $request->source . ' berhasil diinput ke Rak ' . $request->part_location);
                             
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal simpan data: ' . $e->getMessage());
        }
    }
    
    public function stockEdit($panelName)
    {
        $panelName = hex2bin($panelName);

        $items = WorkOrderDetail::whereNull('work_order_id')
                    ->where('panel_name', $panelName)
                    ->where('part_status', 'Ready')
                    ->get();

        return view('spareparts.stocks.edit', compact('items', 'panelName'));
    }

    public function stockUpdate(Request $request)
    {
        if (!$request->has('ids')) {
            return redirect()->route('spareparts.stocks.index')
                             ->with('success', 'Semua barang berhasil dibersihkan dari rak.');
        }

        $request->validate([
            'ids'           => 'required|array',
            'locations'     => 'required|array',
            'prices'        => 'required|array',
            'etadates'      => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->ids as $index => $id) {
                $item = WorkOrderDetail::findOrFail($id);
                
                $item->update([
                    'part_location' => $request->locations[$index],
                    'harga'         => $request->prices[$index],
                    'part_eta'      => $request->etadates[$index] ?? $item->part_eta,
                ]);
            }
            
            DB::commit();
            return redirect()->route('spareparts.stocks.index')->with('success', 'Data stok berhasil diperbarui!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal update data: ' . $e->getMessage());
        }
    }

    public function stockPrint()
    {
        $panelCategories = [
            'BAGIAN DEPAN (FRONT)' => [ 'items' => ['Bumper Depan', 'Bodykit Bumper Depan', 'Grill', 'Kap Mesin (Hood)', 'Kaca Depan', 'Headlamp Kanan', 'Headlamp Kiri'] ],
            'SAMPING KANAN (RIGHT)' => [ 'items' => ['Fender Kanan Depan', 'Pintu Depan Kanan', 'Pintu Tengah Kanan', 'Pillar Kanan', 'Quarter Panel Kanan', 'Triplank Kanan', 'Molding Depan Kanan', 'Molding Belakang Kanan', 'Spion Kanan', 'Kaca Pintu Kanan'] ],
            'SAMPING KIRI (LEFT)' => [ 'items' => ['Fender Kiri Depan', 'Pintu Depan Kiri', 'Pintu Tengah Kiri', 'Pillar Kiri', 'Quarter Panel Kiri', 'Triplank Kiri', 'Molding Depan Kiri', 'Molding Belakang Kiri', 'Spion Kiri', 'Kaca Pintu Kiri'] ],
            'BAGIAN BELAKANG (REAR)' => [ 'items' => ['Bagasi (Trunk)', 'Bumper Belakang', 'Bodykit Bumper Belakang', 'Kaca Belakang', 'Stoplamp Kanan', 'Stoplamp Kiri', 'Spoiler'] ],
            'ATAP & LAINNYA' => [ 'items' => ['Atap (Roof)', 'Velg / Roda'] ]
        ];

        return view('spareparts.stocks.print', compact('panelCategories'));
    }

    public function stockDestroy($id)
    {
        DB::beginTransaction();
        try {
            $item = WorkOrderDetail::findOrFail($id);
            $panelName = $item->panel_name; 
            
            // Opsional: Hapus foto kalau item dihapus
            if ($item->foto_nota && Storage::disk('public')->exists($item->foto_nota)) {
                Storage::disk('public')->delete($item->foto_nota);
            }
            
            $item->delete();
            DB::commit();
            
            return back()->with('success', 'Satu item ' . $panelName . ' berhasil dihapus dari rak!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal hapus data: ' . $e->getMessage());
        }
    }
}