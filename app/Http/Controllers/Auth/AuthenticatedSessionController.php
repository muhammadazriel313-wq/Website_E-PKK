<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input form
        $request->validate([
            'email' => ['required', 'string'], 
            'password' => ['required', 'string'],
        ]);

        $loginId = $request->input('email');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // 2. Coba login sebagai Admin (Guard 'web' -> tabel 'users')
        if (Auth::guard('web')->attempt(['email' => $loginId, 'password' => $password], $remember)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        // 3. Login Kecamatan (Guard 'pengguna' -> tabel 'users_mobile').
        //    Tabel users_mobile TIDAK punya kolom 'email', kredensialnya adalah 'phone_number'.
        //    Nomor HP bisa sama di beberapa akun, jadi cocokkan password ke semua kandidat.
        $phone = trim($loginId);

        $kandidat = Pengguna::where('phone_number', $phone)->get()
            ->filter(fn ($u) => Hash::check($password, $u->password));

        $kecamatan = $kandidat->firstWhere('id_role', 2);
        if ($kecamatan) {
            // remember = false: users_mobile tidak punya kolom remember_token
            Auth::guard('pengguna')->login($kecamatan, false);
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        if ($kandidat->firstWhere('id_role', 1)) {
            throw ValidationException::withMessages([
                'email' => 'Akun Desa hanya dapat digunakan di aplikasi mobile.',
            ]);
        }

        // 4. Jika gagal login karena salah password atau akun tidak terdaftar
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => 'Email / Nomor WhatsApp atau password salah.',
        ]);
    }

    /**
     * Dipakai tombol "Masuk Admin" di navbar publik.
     * Bila sesi masih aktif, sesi diakhiri lebih dulu supaya pengguna
     * diarahkan ke form login, bukan langsung ke dashboard.
     */
    public function masukAdmin(Request $request): RedirectResponse
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        if (Auth::guard('pengguna')->check()) {
            Auth::guard('pengguna')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function destroy(Request $request)
    {
        // 1. Pastikan kedua guard benar-benar di-logout
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        if (Auth::guard('pengguna')->check()) {
            Auth::guard('pengguna')->logout();
        }

        // 2. Hancurkan sisa-sisa sesi di browser
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 3. Lempar ke halaman Home
        return redirect('/home')->with('success', 'Sampai jumpa! Anda telah aman keluar dari sistem E-PKK.');
    }
}