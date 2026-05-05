<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::orderBy('urutan')->orderByDesc('created_at')->paginate(15);
        return view('admin.promo.index', compact('promos'));
    }

    public function create()
    {
        return view('admin.promo.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'gambar'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'badge_text'      => 'nullable|string|max:50',
            'badge_color'     => 'nullable|string|in:red,blue,green,orange',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'urutan'          => 'nullable|integer|min:0',
            'is_active'       => 'nullable',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('promo', 'public');
        }

        $data['slug']      = Str::slug($request->judul) . '-' . time();
        $data['is_active'] = $request->has('is_active');

        Promo::create($data);

        return redirect()->route('admin.promo.index')
                         ->with('success', 'Promo berhasil ditambahkan.');
    }

    public function edit(Promo $promo)
    {
        return view('admin.promo.form', compact('promo'));
    }

    public function update(Request $request, Promo $promo)
    {
        $data = $request->validate([
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'gambar'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'badge_text'      => 'nullable|string|max:50',
            'badge_color'     => 'nullable|string|in:red,blue,green,orange',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'urutan'          => 'nullable|integer|min:0',
            'is_active'       => 'nullable',
        ]);

        if ($request->hasFile('gambar')) {
            if ($promo->gambar) Storage::disk('public')->delete($promo->gambar);
            $data['gambar'] = $request->file('gambar')->store('promo', 'public');
        } else {
            unset($data['gambar']);
        }

        $data['is_active'] = $request->has('is_active');

        $promo->update($data);

        return redirect()->route('admin.promo.index')
                         ->with('success', 'Promo berhasil diperbarui.');
    }

    public function destroy(Promo $promo)
    {
        if ($promo->gambar) Storage::disk('public')->delete($promo->gambar);
        $promo->delete();
        return back()->with('success', 'Promo berhasil dihapus.');
    }
}