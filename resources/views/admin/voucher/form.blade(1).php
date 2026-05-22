@extends('admin.layouts.admin')
@section('title', isset($voucher) ? 'Edit Voucher' : 'Buat Voucher')

@section('content')
<div class="p-8 max-w-2xl">

    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('admin.voucher.index') }}" class="text-sm text-gray-400 hover:text-navy-700">← Kembali</a>
            <h1 class="text-2xl font-bold text-gray-900 mt-1">
                {{ isset($voucher) ? 'Edit Voucher' : 'Buat Voucher Baru' }}
            </h1>
        </div>
        <button form="form-voucher" type="submit"
                class="text-white font-bold px-6 py-2.5 rounded-xl text-sm hover:opacity-90"
                style="background-color:#0d1b2e;">
            Simpan Voucher
        </button>
    </div>

    @if($errors->any())
    <div class="mb-5 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
        <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form id="form-voucher"
          method="POST"
          action="{{ isset($voucher) ? route('admin.voucher.update', $voucher->id) : route('admin.voucher.store') }}">
        @csrf
        @if(isset($voucher)) @method('PUT') @endif

    <div class="bg-white rounded-2xl border border-gray-200 p-6 space-y-5">

        {{-- Kode Voucher --}}
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kode Voucher</label>
            <div class="flex gap-2">
                <input type="text" name="kode" id="kodeInput"
                       value="{{ old('kode', $voucher->kode ?? '') }}"
                       placeholder="cth: PLAZZA30"
                       class="flex-1 border border-gray-200 rounded-xl px-4 py-3 text-sm uppercase font-mono focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="button" onclick="generateKode()"
                        class="px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                    Generate
                </button>
            </div>
            <p class="text-xs text-gray-400 mt-1">Gunakan huruf kapital dan angka saja. Pelanggan ketik kode ini saat checkout.</p>
        </div>

        {{-- Nama --}}
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Voucher</label>
            <input type="text" name="nama" value="{{ old('nama', $voucher->nama ?? '') }}"
                   placeholder="cth: Diskon Akhir Tahun 30%"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        {{-- Tipe + Nilai --}}
        <div class="grid grid-cols-2 gap-4" x-data="{ tipe: '{{ old('tipe', $voucher->tipe ?? 'nominal') }}' }">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tipe Diskon</label>
                <select name="tipe" x-model="tipe"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="nominal">Nominal (Rp)</option>
                    <option value="persen">Persentase (%)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                    Nilai Diskon (<span x-text="tipe === 'persen' ? '%' : 'Rp'"></span>)
                </label>
                <input type="number" name="nilai" min="0" step="0.01"
                       value="{{ old('nilai', $voucher->nilai ?? '') }}"
                       placeholder="cth: 50000 atau 30 (untuk 30%)"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Maks diskon (hanya untuk persen) --}}
            <div x-show="tipe === 'persen'" class="col-span-2">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                    Maksimum Diskon (Rp) — opsional
                </label>
                <input type="number" name="maks_diskon" min="0"
                       value="{{ old('maks_diskon', $voucher->maks_diskon ?? '') }}"
                       placeholder="cth: 100000 → diskon maks Rp 100.000"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        {{-- Min Belanja + Kuota --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                    Minimum Belanja (Rp)
                </label>
                <input type="number" name="min_belanja" min="0"
                       value="{{ old('min_belanja', $voucher->min_belanja ?? 0) }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                    Kuota (kosongkan = unlimited)
                </label>
                <input type="number" name="kuota" min="1"
                       value="{{ old('kuota', $voucher->kuota ?? '') }}"
                       placeholder="cth: 100"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        {{-- Tanggal --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai"
                       value="{{ old('tanggal_mulai', isset($voucher) && $voucher->tanggal_mulai ? $voucher->tanggal_mulai->format('Y-m-d') : '') }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Berakhir</label>
                <input type="date" name="tanggal_selesai"
                       value="{{ old('tanggal_selesai', isset($voucher) && $voucher->tanggal_selesai ? $voucher->tanggal_selesai->format('Y-m-d') : '') }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        {{-- is_active --}}
        <div class="flex items-center gap-3">
            <input type="checkbox" name="is_active" id="is_active" value="1"
                   {{ old('is_active', $voucher->is_active ?? true) ? 'checked' : '' }}
                   class="w-5 h-5 rounded accent-blue-600">
            <label for="is_active" class="text-sm font-semibold text-gray-700 cursor-pointer">
                Aktifkan voucher ini
            </label>
        </div>

    </div>
    </form>
</div>

<script>
async function generateKode() {
    const res = await fetch('/admin/voucher/generate-kode');
    const data = await res.json();
    document.getElementById('kodeInput').value = data.kode;
}
</script>
@endsection