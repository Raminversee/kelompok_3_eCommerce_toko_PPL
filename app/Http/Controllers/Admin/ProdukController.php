<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    // ✅ Ambil kategori dari config (BUKAN HARDCODE)
    private function getKategoriList()
    {
        return config('plazza.kategoris');
    }

    public function index(Request $request)
    {
        $query = Produk::latest();

        // 🔍 SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        // 🔥 FILTER KATEGORI — value dari request sudah sesuai kolom 'db' di config
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            // Validasi: pastikan kategori yang dikirim ada di daftar resmi (cegah injection)
            $validKategoris = collect($this->getKategoriList())->pluck('db')->toArray();
            if (in_array($request->kategori, $validKategoris)) {
                $query->where('kategori', $request->kategori);
            }
        }

        $produks = $query->paginate(15)->withQueryString();
        $kategoriList = $this->getKategoriList();

        return view('admin.produk.index', compact('produks', 'kategoriList'));
    }

    public function create()
    {
        $kategoriList = $this->getKategoriList();
        return view('admin.produk.form', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'         => 'required|string|max:255',
            'kategori'     => 'required|string',
            'sku'          => 'required|string|unique:produks,sku',
            'harga'        => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
            'min_stok'     => 'nullable|integer|min:0',
            'deskripsi'    => 'nullable|string',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_published' => 'nullable',
            'berat'        => 'nullable|string|max:50',
            'dimensi'      => 'nullable|string|max:100',
            'material'     => 'nullable|string|max:100',
        ]);

        // ✅ SLUG UNIQUE
        $slug = Str::slug($data['nama']);
        $count = Produk::where('slug', 'LIKE', "$slug%")->count();
        $data['slug'] = $count ? $slug . '-' . ($count + 1) : $slug;

        // ✅ UPLOAD GAMBAR (FIX)
   if ($request->hasFile('gambar')) {

    $file = $request->file('gambar');

    $namaFile = time() . '_' . $file->getClientOriginalName();

    $tujuan = public_path('storage/produk');

    if (!file_exists($tujuan)) {
        mkdir($tujuan, 0777, true);
    }

    $file->move($tujuan, $namaFile);

    $data['gambar'] = 'produk/' . $namaFile;
}

        // ✅ STATUS
        $data['is_published'] = $request->has('is_published');
        $data['is_active'] = true;

        Produk::create($data);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        $kategoriList = $this->getKategoriList();
        return view('admin.produk.form', compact('produk', 'kategoriList'));
    }

    public function update(Request $request, Produk $produk)
    {
        $data = $request->validate([
            'nama'         => 'required|string|max:255',
            'kategori'     => 'required|string',
            'sku'          => 'required|string|unique:produks,sku,' . $produk->id,
            'harga'        => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
            'min_stok'     => 'nullable|integer|min:0',
            'deskripsi'    => 'nullable|string',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_published' => 'nullable',
            'berat'        => 'nullable|string|max:50',
            'dimensi'      => 'nullable|string|max:100',
            'material'     => 'nullable|string|max:100',
        ]);

        // ✅ UPDATE SLUG kalau nama berubah
        if ($produk->nama !== $data['nama']) {
            $slug = Str::slug($data['nama']);
            $count = Produk::where('slug', 'LIKE', "$slug%")
                ->where('id', '!=', $produk->id)
                ->count();

            $data['slug'] = $count ? $slug . '-' . ($count + 1) : $slug;
        }

        // ✅ UPDATE GAMBAR
        if ($request->hasFile('gambar')) {

    if ($produk->gambar && file_exists(public_path('storage/' . $produk->gambar))) {
        unlink(public_path('storage/' . $produk->gambar));
    }

    $file = $request->file('gambar');

    $namaFile = time() . '_' . $file->getClientOriginalName();

    $tujuan = public_path('storage/produk');

    if (!file_exists($tujuan)) {
        mkdir($tujuan, 0777, true);
    }

    $file->move($tujuan, $namaFile);

    $data['gambar'] = 'produk/' . $namaFile;
}

        // ✅ STATUS
        $data['is_published'] = $request->has('is_published');

        $produk->update($data);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return back()->with('success', 'Produk berhasil dihapus.');
    }
}