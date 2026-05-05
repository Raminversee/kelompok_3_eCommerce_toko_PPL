<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        return view('profil.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'foto'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name'    => $request->name,
            'phone'   => $request->phone,
            'address' => $request->address,
        ];

        // ✅ UPLOAD FOTO (FIX FINAL)
        if ($request->hasFile('foto')) {

            // hapus lama
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            // simpan baru
            $path = $request->file('foto')->store('users', 'public');

            $data['foto'] = $path;
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function ubahPassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password'      => ['required', 'confirmed', Password::min(8)],
        ]);

        if (!Hash::check($request->password_lama, auth()->user()->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak cocok.']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success_password', 'Password berhasil diubah.');
    }
}