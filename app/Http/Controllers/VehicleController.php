<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Customer; // <--- Wajib import Customer
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // 1. Tampilkan Daftar Mobil
    public function index(Request $request)
    {
        // Eager Loading 'customer' biar query ringan
        $query = Vehicle::with('customer')->latest();

        // Fitur Search (Nopol / Merk / Nama Customer)
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nopol', 'like', "%{$search}%")
                  ->orWhere('merk', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $vehicles = $query->paginate(10);
        return view('vehicles.index', compact('vehicles'));
    }

    // 2. Form Tambah
    public function create()
    {
        // Kirim data customer buat dropdown
        $customers = Customer::orderBy('name', 'ASC')->get();
        return view('vehicles.create', compact('customers'));
    }

    // 3. Simpan Data
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'nopol' => 'required|string|unique:vehicles,nopol|max:15',
            'merk' => 'required|string',
            'model' => 'required|string',
            'warna' => 'required|string',
            'tahun' => 'nullable|numeric',
            'no_rangka' => 'nullable|string',
            'no_mesin' => 'nullable|string',
        ]);

        Vehicle::create($request->all());

        return redirect()->route('vehicles.index')->with('success', 'Data kendaraan berhasil ditambahkan!');
    }

    // 4. Form Edit
    public function edit(Vehicle $vehicle)
    {
        $customers = Customer::orderBy('name', 'ASC')->get();
        return view('vehicles.edit', compact('vehicle', 'customers'));
    }

    // 5. Update Data
    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            // Ignore unique rule untuk nopol mobil ini sendiri
            'nopol' => 'required|string|max:15|unique:vehicles,nopol,'.$vehicle->id,
            'merk' => 'required|string',
            'model' => 'required|string',
            'warna' => 'required|string',
        ]);

        $vehicle->update($request->all());

        return redirect()->route('vehicles.index')->with('success', 'Data kendaraan berhasil diperbarui!');
    }

    // 6. Hapus Data
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Data kendaraan dihapus.');
    }

    // Fitur Print Laporan
    public function print()
    {
        $vehicles = Vehicle::with('customer')->orderBy('nopol', 'ASC')->get();
        return view('vehicles.print', compact('vehicles'));
    }
}