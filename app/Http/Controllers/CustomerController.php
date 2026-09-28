<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\WorkOrder;
use App\Models\PurchaseOrder; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // =========================================================================
    // 1. AREA ADMIN (CRUD DATA CUSTOMER)
    // =========================================================================
    
    public function index(Request $request)
    {
        $query = Customer::latest();
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
        }
        $customers = $query->paginate(10);
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'address' => 'nullable|string',
            'email'   => 'required|email|unique:users,email', 
        ]);
        
        DB::beginTransaction();
        try {
            // Bikin akun login
            User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'role'     => 'customer',
                'password' => Hash::make('12345678'), 
            ]);

            // Simpan profil customer TANPA user_id
            Customer::create([
                'name'    => $request->name,
                'phone'   => $request->phone,
                'address' => $request->address,
                'email'   => $request->email,
            ]);

            DB::commit();
            return redirect()->route('customers.index')->with('success', 'Sip! Pelanggan ditambah. Password Login web: 12345678');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Waduh sistem error bro: ' . $e->getMessage());
        }
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        // Validasi, kecualikan email si user yang lagi diedit biar gak error "email already taken"
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'address' => 'nullable|string',
            'email'   => 'required|email',
        ]);
        
        DB::beginTransaction();
        try {
            // 1. Cari dulu akun loginnya PAKE EMAIL LAMA sebelum di-update
            $user = User::where('email', $customer->email)->first();

            // 2. Update data profil di tabel Customer
            $customer->update([
                'name'    => $request->name,
                'phone'   => $request->phone,
                'address' => $request->address,
                'email'   => $request->email,
            ]);

            // 3. Kalau akunnya ketemu, update juga email dan namanya di tabel Users
            if ($user) {
                $user->update([
                    'name'  => $request->name,
                    'email' => $request->email, // Email otomatis ke-update bro!
                ]);
            }

            DB::commit();
            return redirect()->route('customers.index')->with('success', 'Data customer berhasil diperbarui!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal update bro: ' . $e->getMessage());
        }
    }

    public function destroy(Customer $customer)
    {
        DB::beginTransaction();
        try {
            // 1. Cari dulu akun login User-nya (berdasarkan email) sebelum profilnya dihapus
            $user = User::where('email', $customer->email)->first();

            // 2. Hapus data profil di tabel Customer
            $customer->delete();

            // 3. Kalau akun loginnya ketemu, sekalian dimusnahkan bro!
            if ($user) {
                $user->delete();
            }

            DB::commit();
            return redirect()->route('customers.index')->with('success', 'Sip bro! Data customer beserta akun loginnya berhasil dihapus permanen.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal hapus data bro: ' . $e->getMessage());
        }
    }

    public function print()
    {
        $customers = Customer::orderBy('name', 'ASC')->get();
        return view('customers.print', compact('customers'));
    }

    // =========================================================================
    // 2. AREA CUSTOMER LOGIN (PORTAL PELANGGAN - TRACK MY CAR)
    // =========================================================================

    private function getLoggedInCustomer()
    {
        $user = Auth::user();
        return Customer::where('email', $user->email)->first(); // Cari pake email
    }

    public function dashboard()
    {
        $customer = $this->getLoggedInCustomer();

        if (!$customer) {
            dd('ERROR: Akun login tidak terhubung dengan Master Data Customer!');
        }

        $histories = WorkOrder::with(['vehicle', 'details', 'mechanic', 'bahanSpks.bahan'])
            ->whereHas('vehicle', function($q) use ($customer) {
                $q->where('customer_id', $customer->id);
            })
            ->latest()
            ->get();

        return view('dashboard', compact('histories'));
    }

    public function spareparts()
    {
        $customer = $this->getLoggedInCustomer();

        if (!$customer) {
            return view('customers.spareparts', ['trackings' => collect([])]);
        }

        $trackings = PurchaseOrder::with(['items', 'workOrder.vehicle'])
            ->whereHas('workOrder.vehicle', function($q) use ($customer) {
                $q->where('customer_id', $customer->id); 
            })
            ->latest()
            ->get();

        return view('customers.spareparts', compact('trackings'));
    }

    public function history()
    {
        $customer = $this->getLoggedInCustomer();

        if (!$customer) {
            return view('customers.history', ['histories' => collect([])]);
        }

        $histories = WorkOrder::with(['vehicle', 'details']) 
            ->whereHas('vehicle', function($q) use ($customer) {
                $q->where('customer_id', $customer->id); 
            })
            ->where('status', 'selesai') 
            ->latest()
            ->get();

        return view('customers.history', compact('histories'));
    }
}