<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // --- LOGIKA REDIRECT OTOMATIS (AUTO PILAH FIX) ---
        
        // 1. Ambil data User yang baru aja berhasil login
        $user = $request->user();

        // 2A. Cek duluan, apakah ini orang Gudang Bahan?
        // (Wajib dicek pertama biar gak ketikung sama rule 'Gudang' Sparepart di bawahnya)
        if (str_contains($user->name, 'Bahan')) {
            // INI YANG BENER SESUAI WEB.PHP LU
            return redirect()->intended(route('bahan.dashboard', absolute: false)); 
        }

        // 2B. Kalo bukan Bahan, cek apakah ini orang Gudang Sparepart / Logistik?
        elseif (str_contains($user->name, 'Gudang') || str_contains($user->name, 'Logistik')) {
            return redirect()->intended(route('spareparts.index', absolute: false));
        }

        // 3. Kalau gak ada kata Gudang/Bahan (berarti SA, Admin, Foreman, dll), lempar ke Dashboard Utama
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}