<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\WorkOrder;
use App\Models\WorkOrderDetail;
use App\Models\Mechanic;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // ==========================================
        // 1. AKUN PETUGAS (Password: 12345678)
        // ==========================================
        User::create([
            'name' => 'Service Advisor',
            'email' => 'sa@wira.com',
            'role' => 'sa',
            'password' => Hash::make('12345678')
        ]);

        User::create([
            'name' => 'Foreman Controller',
            'email' => 'foreman@wira.com',
            'role' => 'foreman',
            'password' => Hash::make('12345678')
        ]);

        // Gudang Sparepart (Mengurus Part Kaca, Bumper, Pintu)
        User::create([
            'name' => 'Gudang Sparepart',
            'email' => 'part@wira.com',
            'role' => 'sparepart', // Role khusus sparepart
            'password' => Hash::make('12345678')
        ]);

        // Gudang Bahan (Mengurus Cat, Thinner, Pernis)
        User::create([
            'name' => 'Gudang Bahan',
            'email' => 'bahan@wira.com',
            'role' => 'bahan', // Role khusus bahan
            'password' => Hash::make('12345678')
        ]);

        // ==========================================
        // 2. AKUN CUSTOMER LOGIN (BUDI)
        // ==========================================
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com', // LOGIN PAKE INI
            'role' => 'customer',
            'password' => Hash::make('12345678')
        ]);

        // ==========================================
        // 3. DATA CUSTOMER BENGKEL
        // ==========================================
        
        // BUDI SANTOSO (Harus match emailnya sama User di atas biar connect)
        $cust1 = Customer::create([
            'name' => 'Budi Santoso',
            'phone' => '081234567890',
            'email' => 'budi@gmail.com', 
            'address' => 'Jl. A. Yani Km. 5, Banjarmasin'
        ]);

        // SITI (Customer Lain - Buat test isolasi data)
        $cust2 = Customer::create([
            'name' => 'Siti Aminah',
            'phone' => '089876543210',
            'email' => 'siti@yahoo.com',
            'address' => 'Jl. Sultan Adam, Banjarmasin'
        ]);

        // ==========================================
        // 4. KENDARAAN (MOBIL)
        // ==========================================
        
        // MOBIL 1 BUDI: Fortuner (Lagi Rusak/Proses)
        $veh1 = Vehicle::create([
            'customer_id' => $cust1->id, 
            'nopol' => 'DA 1688 AB', 
            'merk' => 'Toyota', 
            'model' => 'Fortuner VRZ', 
            'warna' => 'Hitam Metalik', 
            'tahun' => '2023', 
            'no_rangka' => 'MHF1234567890', 
            'no_mesin' => '2GD-998877'
        ]);

        // MOBIL 2 BUDI: Innova (Udah Selesai Servis Bulan Lalu) -> BIAR RIWAYAT NONGOL
        $veh3 = Vehicle::create([
            'customer_id' => $cust1->id, // Tetap punya Budi
            'nopol' => 'DA 1234 XYZ', 
            'merk' => 'Toyota', 
            'model' => 'Kijang Innova Reborn', 
            'warna' => 'Putih Mutiara', 
            'tahun' => '2021', 
            'no_rangka' => 'MHF9876543210', 
            'no_mesin' => '1TR-112233'
        ]);

        // MOBIL SITI (Buat pembanding)
        $veh2 = Vehicle::create([
            'customer_id' => $cust2->id,
            'nopol' => 'DA 4545 CD', 
            'merk' => 'Honda', 
            'model' => 'Jazz RS', 
            'warna' => 'Merah Ferari', 
            'tahun' => '2019', 
            'no_rangka' => 'HJM456123789', 
            'no_mesin' => 'L15-445566'
        ]);

        // ==========================================
        // 5. SPK & WORK ORDER
        // ==========================================

        // --- KASUS 1: BUDI - FORTUNER (STATUS: PROSES) ---
        // Skenario: Menunggu Part Kap Mesin
        $spk1 = WorkOrder::create([
            'vehicle_id' => $veh1->id,
            'nomor_spk' => 'SPK-'.date('my').'-001',
            'status' => 'proses',
            'repair_stage' => 'Preparation', // Tahap sekarang
            'repair_type' => 'Regular',
            'keluhan_customer' => 'Tabrakan depan, kap mesin penyok parah, bumper pecah',
            'tanggal_masuk' => date('Y-m-d'),
            'estimasi_selesai' => date('Y-m-d', strtotime('+7 days')),
            'estimasi_biaya' => 4500000, 
        ]);

        WorkOrderDetail::create([
            'work_order_id' => $spk1->id,
            'panel_name' => 'Kap Mesin (Hood)',
            'kerusakan' => 'Ganti Baru (GC)',
            'part_status' => 'OTW', // Status Part OTW (Gudang Sparepart Monitoring ini)
            'part_eta' => date('Y-m-d', strtotime('+3 days')),
            'harga' => 3500000, 
        ]);
        
        WorkOrderDetail::create([
            'work_order_id' => $spk1->id,
            'panel_name' => 'Bumper Depan',
            'kerusakan' => 'Repair & Cat (KC)',
            'part_status' => 'Ready', 
            'harga' => 1000000, 
        ]);

        // --- KASUS 2: BUDI - INNOVA (STATUS: SELESAI) ---
        // Skenario: History bulan lalu
        $spk3 = WorkOrder::create([
            'vehicle_id' => $veh3->id, // Innova Budi
            'nomor_spk' => 'SPK-'.date('my', strtotime('-1 month')).'-099',
            'status' => 'selesai', // <--- PENTING: Status Selesai
            'repair_type' => 'Quick Repair',
            'keluhan_customer' => 'Gores panjang di pintu kiri kena pagar',
            'tanggal_masuk' => date('Y-m-d', strtotime('-1 month')),
            'estimasi_selesai' => date('Y-m-d', strtotime('-25 days')),
            'estimasi_biaya' => 750000,
            'updated_at' => date('Y-m-d H:i:s', strtotime('-25 days')), // Biar tanggal update mundur
        ]);

        WorkOrderDetail::create([
            'work_order_id' => $spk3->id,
            'panel_name' => 'Pintu Depan Kiri',
            'kerusakan' => 'Solpet / Spot Repair',
            'part_status' => 'Ready',
            'harga' => 350000, 
        ]);

        WorkOrderDetail::create([
            'work_order_id' => $spk3->id,
            'panel_name' => 'Pintu Tengah Kiri',
            'kerusakan' => 'Poles Body',
            'part_status' => 'Ready',
            'harga' => 400000, 
        ]);

        // --- KASUS 3: SITI (Customer Lain) ---
        // Gak boleh muncul di dashboard Budi
        $spk2 = WorkOrder::create([
            'vehicle_id' => $veh2->id,
            'nomor_spk' => 'SPK-2601-005',
            'status' => 'selesai',
            'repair_type' => 'Quick Repair',
            'keluhan_customer' => 'Lecet spion',
            'tanggal_masuk' => date('Y').'-01-15',
            'estimasi_selesai' => date('Y').'-01-16',
            'estimasi_biaya' => 250000,
        ]);

        // ==========================================
        // 6. SEEDER MEKANIK
        // ==========================================
        
        // 1. Body (Ketok)
        Mechanic::create([
            'name' => 'Ahmad Junaidi',
            'position' => 'Leader', 
            'specialist' => 'Body', 
            'phone' => '0812-3456-7890',
            'is_active' => true
        ]);
        
        Mechanic::create([
            'name' => 'Rahmat Hidayat',
            'position' => 'Teknisi',
            'specialist' => 'Body',
            'phone' => '0857-1234-5678',
            'is_active' => true
        ]);

        // 2. Preparation (Dempul)
        Mechanic::create([
            'name' => 'Budi Santoso',
            'position' => 'Teknisi',
            'specialist' => 'Preparation',
            'phone' => '0813-9988-7766',
            'is_active' => true
        ]);

        // 3. Paint (Cat)
        Mechanic::create([
            'name' => 'Dani Firmansyah',
            'position' => 'Leader',
            'specialist' => 'Paint',
            'phone' => '0878-5544-3322',
            'is_active' => true
        ]);

        // 4. Poles
        Mechanic::create([
            'name' => 'Eko Prasetyo',
            'position' => 'Teknisi',
            'specialist' => 'Poles',
            'phone' => '0896-1122-3344',
            'is_active' => true
        ]);

        // 5. Washing (Cuci)
        Mechanic::create([
            'name' => 'Ujang Suherman',
            'position' => 'Leader',
            'specialist' => 'Washing',
            'phone' => '0851-5566-7788',
            'is_active' => true
        ]);
        
        Mechanic::create([
            'name' => 'Tono Sutono',
            'position' => 'Teknisi',
            'specialist' => 'Washing',
            'phone' => '0812-9900-1122',
            'is_active' => true
        ]);
    }
}