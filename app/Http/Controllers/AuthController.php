<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // ===============================
    // HALAMAN LOGIN
    // ===============================
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectAfterLogin();
        }

        return view('auth.login');
    }

    // ===============================
    // PROSES LOGIN
    // ===============================
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // Ambil user
        $user = User::where('email', $credentials['email'])->first();

        // ❌ User tidak ditemukan
        if (!$user) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // ❌ User belum aktif
        if (!$user->is_active) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Akun Anda belum aktif. Hubungi admin.']);
        }

        // ❌ Password salah
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau kata sandi salah.']);
        }

        // ✅ Login berhasil
        $request->session()->regenerate();

        // update last login
        $user->update([
            'last_login_at' => now()
        ]);

        return $this->redirectAfterLogin();
    }

    // ===============================
    // LOGOUT
    // ===============================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda berhasil keluar.');
    }

    // ===============================
    // REDIRECT BERDASARKAN ROLE
    // ===============================
    private function redirectAfterLogin()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // 🔥 SUPER FIX (lebih aman pakai helper)
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }
}