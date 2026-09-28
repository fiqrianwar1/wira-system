<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- IMPORT CONTROLLERS ---
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\CustomerController; 
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\SparepartController; 
use App\Http\Controllers\PurchaseOrderController; 
use App\Http\Controllers\MekanikController;
use App\Http\Controllers\ForemanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\ComplaintController; // <-- TAMBAHIN INI BRO

/*
|--------------------------------------------------------------------------
| Web Routes (Jalur Aplikasi Wira Toyota)
|--------------------------------------------------------------------------
*/

// 1. HALAMAN DEPAN
Route::get('/', function () { return view('welcome'); });

// 2. DASHBOARD & AUTH
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// 3. AREA KHUSUS (LOGIN REQUIRED)
Route::middleware('auth')->group(function () {
    
    // ====================================================
    // USER PROFILE
    // ====================================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ====================================================
    // MASTER DATA (CUSTOMER & VEHICLE)
    // ====================================================
    Route::get('customers/print', [CustomerController::class, 'print'])->name('customers.print');
    Route::resource('customers', CustomerController::class);
    
    Route::get('vehicles/print', [VehicleController::class, 'print'])->name('vehicles.print');
    Route::resource('vehicles', VehicleController::class);

    // ====================================================
    // OPERASIONAL (SPK / WORK ORDERS) - SERVICE ADVISOR
    // ====================================================
    Route::get('work-orders/print', [WorkOrderController::class, 'print'])->name('work-orders.print');
    // KELOLA KOMPLAIN & GARANSI (SA)
    Route::prefix('sa/complaints')->name('sa.complaints.')->group(function () {
        Route::get('/', [ComplaintController::class, 'indexSA'])->name('index');
        Route::put('/{id}/update', [ComplaintController::class, 'updateStatus'])->name('update');
    });
    Route::put('/sa/complaints/{id}/cancel-decision', [ComplaintController::class, 'cancelDecision'])
    ->name('sa.complaints.cancelDecision');
    
    // TAMBAHAN BARU: Rute Layar Monitor SA (Ngecek Bahan & Profit)
    Route::get('work-orders/{id}/detail', [WorkOrderController::class, 'detail'])->name('work-orders.detail');
    
    Route::resource('work-orders', WorkOrderController::class);

    // ====================================================
    // LOGISTIK & GUDANG (SPAREPART)
    // ====================================================
    Route::prefix('spareparts')->name('spareparts.')->group(function () {

        // Monitoring Tracking Khusus SA
        Route::get('/monitoring', [PurchaseOrderController::class, 'monitoring'])->name('monitoring');

        // Modul Utama & Stok
        Route::controller(SparepartController::class)->group(function () {
            Route::get('/', 'index')->name('index');

            // Manajemen Stok
            Route::prefix('stocks')->name('stocks.')->group(function() {
                Route::get('/', 'stockIndex')->name('index');            
                Route::post('/{id}/use', 'stockUse')->name('use');       
                Route::post('/{id}/empty', 'stockEmpty')->name('empty'); 
                Route::get('/print/{id?}', 'stockPrint')->name('print'); 
                
                Route::get('/create', 'stockCreate')->name('create');
                Route::post('/', 'stockStore')->name('store');
                
                Route::get('/edit/{panel}', 'stockEdit')->name('edit');
                Route::put('/update-data', 'stockUpdate')->name('update'); 

                // 👇 INI YANG KURANG BRO, WAJIB DITAMBAHIN BIAR BISA HAPUS STOK 👇
                Route::delete('/{id}', 'stockDestroy')->name('destroy'); 
            });
        });

        // Modul Purchase Order (PO)
        Route::controller(PurchaseOrderController::class)->prefix('purchases')->name('purchases.')->group(function() {
            Route::get('/', 'index')->name('index');       
            Route::get('/create', 'create')->name('create'); 
            Route::post('/', 'store')->name('store');      
            Route::get('/recap', 'recap')->name('recap');  
            Route::get('/print/{id}', 'print')->name('print'); 
            Route::get('/{id}/edit', 'edit')->name('edit'); 
            Route::put('/{id}', 'update')->name('update');  
            Route::delete('/{id}', 'destroy')->name('destroy'); 
        });
    });

    // ====================================================
    // AREA GUDANG BAHAN (TINTER / OPLOS CAT)
    // ====================================================
    Route::prefix('bahan')->name('bahan.')->group(function () {
        
        // Dashboard Utama Gudang Bahan
        Route::get('/dashboard', [BahanController::class, 'dashboard'])->name('dashboard');

        // Manajemen Stok Bahan
        Route::controller(BahanController::class)->prefix('stok')->name('stok.')->group(function() {
            Route::get('/', 'stokIndex')->name('index');        
            Route::get('/create', 'stokCreate')->name('create'); 
            Route::post('/store', 'stokStore')->name('store');  
            Route::get('/print', 'stokPrint')->name('print'); 
            Route::get('/{id}/edit', 'stokEdit')->name('edit');  
            Route::put('/{id}', 'stokUpdate')->name('update');  
            Route::delete('/{id}', 'stokDestroy')->name('destroy'); 
        });

        // Pemakaian Bahan Per SPK
        Route::controller(BahanController::class)->prefix('spk')->name('spk.')->group(function() {
            Route::get('/', 'spkIndex')->name('index');        
            Route::get('/{id}/input', 'spkInput')->name('input'); 
            Route::post('/{id}/store', 'spkStore')->name('store');  
            Route::delete('/{id}/destroy', 'spkDestroy')->name('destroy'); 
            Route::get('/{id}/print', 'spkPrint')->name('print');
        });
    });

    // ====================================================
    // AREA FOREMAN
    // ====================================================
    Route::prefix('foreman')->name('foreman.')->group(function () {
        Route::get('/dashboard', [ForemanController::class, 'index'])->name('dashboard');
        
        // 👇 Route buat Rekap Kinerja Bulanan
        Route::get('/rekap', [ForemanController::class, 'rekapKinerja'])->name('rekap');
        
        // 👇 TAMBAHIN INI BUAT CETAK REKAP
        Route::get('/rekap/print', [ForemanController::class, 'printRekap'])->name('rekap.print');
        
        // Progress Kerja
        Route::controller(ForemanController::class)->prefix('progres-kerja')->name('progress.')->group(function() {
            Route::get('/', 'progressIndex')->name('index');
            Route::get('/{id}/edit', 'editProgress')->name('edit');
            Route::post('/update', 'updateProgress')->name('update');
            Route::get('/{id}/print', 'printProgress')->name('print');
            
            // 👇 TAMBAHAN BARU: Route buat Tombol Selesai (Trigger WA Fonnte) 👇
            Route::post('/{id}/finish', 'finishWorkOrder')->name('finish');
        });

        Route::patch('/reopen/{id}', [ForemanController::class, 'reopenWorkOrder'])->name('reopen');
    });

    // ====================================================
    // MANAJEMEN SDM
    // ====================================================
    Route::get('/foreman/mekanik/print', [MekanikController::class, 'print'])->name('mekanik.print');
    Route::resource('/foreman/mekanik', MekanikController::class)->names('mekanik');

    Route::get('/absensi/print', [AbsensiController::class, 'print'])->name('absensi.print');
    Route::resource('absensi', AbsensiController::class);

    // KODE ROUTE BAHAN FOREMAN UDAH GW HAPUS DI SINI BIAR BERSIH

    // ====================================================
    // CUSTOMER PORTAL
    // ====================================================
    Route::get('/my-spareparts', [CustomerController::class, 'spareparts'])->name('customer.spareparts');
    Route::get('/my-history', [CustomerController::class, 'history'])->name('customer.history');

    // Route khusus tampilan TV (Full Screen)
    Route::get('/monitor/tv', [DashboardController::class, 'monitorTv'])->name('monitor.tv');

    // KOMPLAIN & GARANSI (CUSTOMER)
    Route::get('/my-complaints', [ComplaintController::class, 'indexCustomer'])->name('customer.complaints');
    Route::post('/my-complaints/store', [ComplaintController::class, 'store'])->name('customer.complaints.store');
    Route::delete('/customer/complaints/{id}', [ComplaintController::class, 'destroy'])->name('customer.complaints.destroy');
    
});

require __DIR__.'/auth.php';