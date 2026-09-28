<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer; // <-- JANGAN LUPA PANGGIL MODEL CUSTOMER BRO
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi inputan dari form
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string'], // <-- Wajib ada validasi role dari form
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Simpan ke tabel users pake role dinamis dari pilihan form
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            // TAMBAHIN strtolower() DISINI BRO BIAR JADI HURUF KECIL SEMUA!
            'role' => strtolower($request->role), 
            'password' => Hash::make($request->password),
        ]);

        // 3. LOGIC SAKTI: Kalau rolenya Customer, otomatis bikinin profil di tabel customers
        if ($user->role === 'customer') {
            Customer::create([
                'user_id' => $user->id,
                'name'    => $user->name,
                'email'   => $user->email,
                'phone'   => '-', // Kasih strip dulu krn belum input WA
                'address' => '-', // Kasih strip dulu krn belum input Alamat
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}