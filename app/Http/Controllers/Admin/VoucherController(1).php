<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->paginate(15);
        return view('admin.voucher.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.voucher.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode'            => 'required|string|max:50|unique:vouchers,kode',
            'nama'            => 'required|string|max:255',
            'tipe'            => 'required|in:persen,nominal',
            'nilai'           => 'required|numeric|min:0',
            'min_belanja'     => 'nullable|numeric|min:0',
            'maks_diskon'     => 'nullable|numeric|min:0',
            'kuota'           => 'nullable|integer|min:1',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_active'       => 'nullable',
        ]);

        $data['kode']      = strtoupper($data['kode']);
        $data['is_active'] = $request->has('is_active');

        Voucher::create($data);

        return redirect()->route('admin.voucher.index')
                         ->with('success', 'Voucher berhasil dibuat.');
    }

    public function edit(Voucher $voucher)
    {
        return view('admin.voucher.form', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $data = $request->validate([
            'kode'            => 'required|string|max:50|unique:vouchers,kode,' . $voucher->id,
            'nama'            => 'required|string|max:255',
            'tipe'            => 'required|in:persen,nominal',
            'nilai'           => 'required|numeric|min:0',
            'min_belanja'     => 'nullable|numeric|min:0',
            'maks_diskon'     => 'nullable|numeric|min:0',
            'kuota'           => 'nullable|integer|min:1',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'is_active'       => 'nullable',
        ]);

        $data['kode']      = strtoupper($data['kode']);
        $data['is_active'] = $request->has('is_active');

        $voucher->update($data);

        return redirect()->route('admin.voucher.index')
                         ->with('success', 'Voucher berhasil diperbarui.');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return back()->with('success', 'Voucher berhasil dihapus.');
    }

    // Auto-generate kode
    public function generateKode()
    {
        $kode = 'PLZ-' . strtoupper(Str::random(6));
        while (Voucher::where('kode', $kode)->exists()) {
            $kode = 'PLZ-' . strtoupper(Str::random(6));
        }
        return response()->json(['kode' => $kode]);
    }
}