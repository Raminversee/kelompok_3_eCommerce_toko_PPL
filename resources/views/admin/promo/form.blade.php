@extends('admin.layouts.admin')
@section('title', isset($promo) ? 'Edit Promo' : 'Tambah Promo')

@section('content')
<div class="p-8 max-w-3xl">

    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('admin.promo.index') }}" class="text-sm text-gray-400 hover:text-navy-700">← Kembali</a>
            <h1 class="text-2xl font-bold text-gray-900 mt-1">
                {{ isset($promo) ? 'Edit Promo' : 'Tambah Promo Baru' }}
            </h1>
        </div>
        <button form="form-promo" type="submit"
                class="text-white font-bold px-6 py-2.5 rounded-xl text-sm hover:opacity-90"
                style="background-color:#0d1b2e;">
            Simpan
        </button>
    </div>

    @if($errors->any())
    <div class="mb-5 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form id="form-promo"
          method="POST"
          action="{{ isset($promo) ? route('admin.promo.update', $promo->id) : route('admin.promo.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if(isset($promo)) @method('PUT') @endif

        <div class="bg-white rounded-2xl border border-gray-200 p-6 space-y-5">

            {{-- Judul --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Judul Promo</label>
                <input type="text" name="judul" value="{{ old('judul', $promo->judul ?? '') }}"
                       placeholder="cth: Promo Akhir Tahun — Diskon 30%"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                          placeholder="Tulis detail promo, syarat & ketentuan, produk yang didiskon, dll."
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('deskripsi', $promo->deskripsi ?? '') }}</textarea>
            </div>

            {{-- Badge --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Badge Teks</label>
                    <input type="text" name="badge_text" value="{{ old('badge_text', $promo->badge_text ?? '') }}"
                           placeholder="cth: HEMAT 30%, GRATIS ONGKIR"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Warna Badge</label>
                    <select name="badge_color"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach(['red'=>'🔴 Merah','blue'=>'🔵 Biru','green'=>'🟢 Hijau','orange'=>'🟠 Orange'] as $val=>$lab)
                        <option value="{{ $val }}" {{ old('badge_color', $promo->badge_color ?? 'red') === $val ? 'selected' : '' }}>
                            {{ $lab }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Tanggal --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai"
                           value="{{ old('tanggal_mulai', isset($promo) && $promo->tanggal_mulai ? $promo->tanggal_mulai->format('Y-m-d') : '') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai"
                           value="{{ old('tanggal_selesai', isset($promo) && $promo->tanggal_selesai ? $promo->tanggal_selesai->format('Y-m-d') : '') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            {{-- Urutan + is_active --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Urutan Tampil</label>
                    <input type="number" name="urutan" min="0"
                           value="{{ old('urutan', $promo->urutan ?? 0) }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-400 mt-1">Angka kecil = tampil lebih dulu</p>
                </div>
                <div class="flex items-end pb-1">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $promo->is_active ?? true) ? 'checked' : '' }}
                               class="w-5 h-5 rounded accent-blue-600">
                        <span class="text-sm font-semibold text-gray-700">Aktifkan Promo</span>
                    </label>
                </div>
            </div>

            {{-- Gambar --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Gambar Banner</label>
                @if(isset($promo) && $promo->gambar)
                <div class="mb-3 w-full h-40 rounded-xl overflow-hidden bg-gray-100">
                    <img src="{{ $promo->gambar_url }}" class="w-full h-full object-cover" alt="">
                </div>
                @endif
                <label for="gambar"
                       class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-navy-700 hover:bg-blue-50 transition-all"
                       x-data="{ fileName: '' }">
                    <div class="text-center" x-show="!fileName">
                        <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-xs text-gray-500">{{ isset($promo) && $promo->gambar ? 'Ganti gambar (opsional)' : 'Upload gambar banner (PNG, JPG, WEBP, max 2MB)' }}</p>
                    </div>
                    <p x-show="fileName" class="text-xs text-green-600 font-semibold" x-text="'✓ ' + fileName"></p>
                    <input type="file" name="gambar" id="gambar" accept=".jpg,.jpeg,.png,.webp"
                           class="hidden" @change="fileName = $el.files[0]?.name || ''">
                </label>
            </div>

        </div>
    </form>
</div>
@endsection