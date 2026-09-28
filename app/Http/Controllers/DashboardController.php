<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // JURUS ANTI BADAI: Paksa jadi huruf kecil semua & ilangin spasi ga sengaja
        $role = strtolower(trim($user->role)); 

        // 1. CEK FOREMAN
        if ($role === 'foreman') {
            return redirect()->route('foreman.dashboard');
        }

        // 2. CEK GUDANG SPAREPART
        if ($role === 'sparepart') {
            return redirect()->route('spareparts.index');
        }

        // 3. CEK GUDANG BAHAN (Tinter / Tukang Oplos)
        if ($role === 'bahan') {
            return redirect()->route('bahan.dashboard'); 
        }

        // 4. CEK CUSTOMER
        if ($role === 'customer') {
            $customerProfile = Customer::where('email', $user->email)->first();

            // Kalau email belum terdaftar di Data Pelanggan, kirim collection kosong
            if (!$customerProfile) {
                return view('customers.dashboard', [
                    'histories' => collect()
                ]);
            }

            // Tarik SEMUA SPK punya customer ini beserta relasi detail panelnya
            $histories = WorkOrder::with(['vehicle', 'details'])
                            ->whereHas('vehicle', function($q) use ($customerProfile) {
                                $q->where('customer_id', $customerProfile->id);
                            })
                            ->latest()
                            ->get();

            return view('customers.dashboard', compact('histories'));
        }

        // 👇 TAMBAHIN INI BRO BUAT LAYAR TV 👇
        // 4.5 CEK MONITOR TV
        if ($role === 'monitor') {
            return redirect()->route('monitor.tv');
        }
        

        // =========================================================
        // 5. DASHBOARD ADMIN / SA (DEFAULT)
        // =========================================================
        
        // Data Keuangan & Total
        $totalPendapatan = WorkOrder::where('status', 'selesai')->sum('estimasi_biaya');
        $totalSpk = WorkOrder::count();
        
        // Data Status (Buat Grafik Donut)
        $statusPending = WorkOrder::where('status', 'pending')->count();
        $statusProses = WorkOrder::where('status', 'proses')->count();
        $statusSelesai = WorkOrder::where('status', 'selesai')->count();
        
        // Variabel buat Kartu Statistik
        $totalUnitProses = $statusProses;
        $totalUnitSelesai = $statusSelesai;
        
        // Tipe Perbaikan (Buat Grafik Batang)
        $repairRegular = WorkOrder::where('repair_type', 'Regular')->count();
        $repairQuick = WorkOrder::where('repair_type', 'Quick Repair')->count();

        // Grafik Omzet Bulanan
        $currentYear = date('Y');
        $monthlyIncome = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyIncome[] = WorkOrder::whereYear('tanggal_masuk', $currentYear)
                                    ->whereMonth('tanggal_masuk', $i)
                                    ->where('status', 'selesai')
                                    ->sum('estimasi_biaya');
        }

        // Tabel Monitoring
        $monitoringUnits = WorkOrder::with(['vehicle', 'mechanic'])
                            ->where('status', 'proses')
                            ->orderBy('updated_at', 'desc')
                            ->get();

        $recentSpk = WorkOrder::with('vehicle.customer')
                        ->latest()
                        ->take(5)
                        ->get();

        // Kirim SEMUA variabel ke View
        return view('dashboard', compact(
            'role',
            'totalPendapatan', 'totalSpk', 
            'totalUnitProses', 'totalUnitSelesai',
            'statusPending', 'statusProses', 'statusSelesai',
            'repairRegular', 'repairQuick',
            'monthlyIncome', 
            'monitoringUnits',
            'recentSpk'
        ));
    }

    // =========================================================
    // METHOD KHUSUS TAMPILAN TV MONITOR
    // =========================================================
    public function monitorTv()
    {
        // Tarik data: Pending, Proses, dan Selesai
        $workOrders = \App\Models\WorkOrder::with(['vehicle', 'mechanic'])
                        ->whereIn('status', ['pending', 'proses', 'selesai'])
                        // Urutin yang Proses/Pending di atas, Selesai di bawah, lalu berdasarkan Tanggal Masuk
                        ->orderByRaw("FIELD(status, 'proses', 'pending', 'selesai')")
                        ->orderBy('tanggal_masuk', 'desc')
                        ->get();

        return view('monitor.tv', compact('workOrders'));
    }
}