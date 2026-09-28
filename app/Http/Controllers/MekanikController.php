<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\Request;

class MekanikController extends Controller
{
    /**
     * TAMPILKAN LIST MEKANIK
     */
    public function index(Request $request)
    {
        $query = Mechanic::query();

        // Fitur Cari Nama atau Posisi
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('specialist', 'LIKE', "%{$search}%");
        }

        // Urutkan: Aktif dulu, terus Leader dulu, baru Nama
        $mechanics = $query->orderBy('is_active', 'desc')
                           ->orderBy('position', 'asc') // Leader (L) sebelum Teknisi (T)
                           ->orderBy('name', 'asc')
                           ->paginate(10);

        return view('foreman.mekanik.index', compact('mechanics')); // Pastikan path view lu bener ya bro
    }

    /**
     * FORM TAMBAH
     */
    public function create()
    {
        return view('foreman.mekanik.create'); // Pastikan path view lu bener ya bro
    }

    /**
     * SIMPAN DATA BARU
     */
    public function store(Request $request)
    {
        // VALIDASI DENGAN PESAN CUSTOM
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string',   
            'specialist' => 'required|string',
            'phone' => 'nullable|string', 
        ], [
            // Ini pesan errornya bro, biar user ngeh salahnya dimana
            'name.required' => 'Waduh, Nama Personil wajib diisi bro!',
            'position.required' => 'Jabatan belum dipilih!',
            'specialist.required' => 'Spesialis (Stel) harus dipilih!',
        ]);

        Mechanic::create([
            'name' => $request->name,
            'position' => $request->position, 
            'specialist' => $request->specialist,
            'phone' => $request->phone,
            
            // LOGIC AJAIB TOGGLE: Tangkap angka 0 kalo mati, atau 1 kalo idup
            'is_active' => $request->input('is_active', 0)
        ]);

        return redirect()->route('mekanik.index')->with('success', 'Personil baru berhasil ditambahkan! 👨‍🔧');
    }

    /**
     * FORM EDIT
     */
    public function edit($id)
    {
        $mechanic = Mechanic::findOrFail($id);
        return view('foreman.mekanik.edit', compact('mechanic')); // Pastikan path view lu bener ya bro
    }

    /**
     * UPDATE DATA
     */
    public function update(Request $request, $id)
    {
        // VALIDASI UPDATE JUGA SAMA
        $request->validate([
            'name' => 'required',
            'position' => 'required', 
            'specialist' => 'required',
            'phone' => 'nullable|string', 
        ], [
            'name.required' => 'Nama gak boleh dikosongin ya!',
            'position.required' => 'Jabatan wajib ada!',
            'specialist.required' => 'Spesialisnya apa nih?',
        ]);

        $mechanic = Mechanic::findOrFail($id);
        
        $mechanic->update([
            'name' => $request->name,
            'position' => $request->position, 
            'specialist' => $request->specialist,
            'phone' => $request->phone,
            
            // LOGIC AJAIB TOGGLE: Tangkap angka 0 kalo mati, atau 1 kalo idup
            'is_active' => $request->input('is_active', 0)
        ]);

        return redirect()->route('mekanik.index')->with('success', 'Data personil berhasil diupdate! ✅');
    }

    /**
     * HAPUS DATA
     */
    public function destroy($id)
    {
        $mechanic = Mechanic::findOrFail($id);
        $mechanic->delete();

        return redirect()->route('mekanik.index')->with('success', 'Mekanik berhasil dihapus dari sistem.');
    }

    /**
     * CETAK LAPORAN
     */
    public function print()
    {
        $mechanics = Mechanic::orderBy('position', 'asc')->orderBy('name', 'asc')->get();
        return view('foreman.mekanik.print', compact('mechanics')); // Pastikan path view lu bener ya bro
    }
}