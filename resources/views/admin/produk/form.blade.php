@extends('admin.layouts.admin')
@section('title', isset($produk) ? 'Edit Produk' : 'Tambah Produk')

@section('content')
<div class="p-8">

    {{-- Breadcrumb + Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <nav class="flex items-center gap-2 text-sm text-gray-400 mb-2">
                <a href="{{ route('admin.produk.index') }}" class="hover:text-navy-700 transition-colors">Products</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-600">{{ isset($produk) ? 'Edit Product' : 'Add Product' }}</span>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900">Product Specification</h1>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.produk.index') }}"
               class="font-semibold px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors text-sm">
                Batal
            </a>
            <button form="form-produk" type="submit"
                    class="font-bold px-6 py-2.5 rounded-xl text-white text-sm hover:opacity-90 transition-opacity"
                    style="background-color:#0d1b2e;">
                Simpan Perubahan
            </button>
        </div>
    </div>

    <form id="form-produk"
          method="POST"
          action="{{ isset($produk) ? route('admin.produk.update', $produk->id) : route('admin.produk.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if(isset($produk)) @method('PUT') @endif

    <div class="grid grid-cols-3 gap-5">

        {{-- ===== KOLOM KIRI (2/3): Form Fields ===== --}}
        <div class="col-span-2 space-y-5">

            {{-- Card Utama --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

                {{-- Nama Produk --}}
                <div class="mb-5">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Product Name
                    </label>
                    <input type="text" name="nama"
                           value="{{ old('nama', $produk->nama ?? '') }}"
                           placeholder="Contoh: Semen Gresik Portland 50kg"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                  @error('nama') border-red-400 @enderror">
                    @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori + SKU --}}
                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                            Category
                        </label>
                        <div class="relative">
                            <select name="kategori"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500
                                           @error('kategori') border-red-400 @enderror">
                                <option value="">Pilih Kategori...</option>
                                @foreach($kategoriList as $kat)
                                <option value="{{ $kat['db'] }}"
                                        {{ old('kategori', $produk->kategori ?? '') === $kat['db'] ? 'selected' : '' }}>
                                    {{ $kat['icon'] }} {{ $kat['nama'] }}
                                </option>
                                @endforeach
                            </select>
                            <svg class="absolute right-3 top-3.5 w-4 h-4 text-gray-400 pointer-events-none"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        @error('kategori')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                            SKU Identifier
                        </label>
                        <input type="text" name="sku"
                               value="{{ old('sku', $produk->sku ?? '') }}"
                               placeholder="Contoh: SMN-001-GRS"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                      @error('sku') border-red-400 @enderror">
                        @error('sku')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Harga + Stok --}}
                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                            Price (Rp)
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-sm text-gray-400 font-semibold">Rp</span>
                            <input type="number" name="harga"
                                   value="{{ old('harga', $produk->harga ?? '') }}"
                                   placeholder="0"
                                   class="w-full pl-10 pr-4 border border-gray-200 rounded-xl py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                          @error('harga') border-red-400 @enderror">
                        </div>
                        @error('harga')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                            Stock (Units)
                        </label>
                        <input type="number" name="stok"
                               value="{{ old('stok', $produk->stok ?? '') }}"
                               placeholder="0"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                      @error('stok') border-red-400 @enderror">
                        @error('stok')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Description
                    </label>
                    <textarea name="deskripsi" rows="5"
                              placeholder="Tulis deskripsi produk lengkap di sini..."
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('deskripsi', $produk->deskripsi ?? '') }}</textarea>
                </div>
            </div>

            {{-- Advanced Attributes --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Advanced Attributes
                </p>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Weight</label>
                        <input type="text" name="berat"
                               value="{{ old('berat', $produk->berat ?? '') }}"
                               placeholder="cth: 12.5 kg"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Dimensions</label>
                        <input type="text" name="dimensi"
                               value="{{ old('dimensi', $produk->dimensi ?? '') }}"
                               placeholder="cth: 60×60×1 cm"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Material</label>
                        <input type="text" name="material"
                               value="{{ old('material', $produk->material ?? '') }}"
                               placeholder="cth: Hardened Porcelain"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

        </div>

        {{-- ===== KOLOM KANAN (1/3): Gambar + Status ===== --}}
        <div class="space-y-5">

            {{-- Product Imagery --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Product Imagery</p>

                {{-- Preview gambar existing --}}
                @if(isset($produk) && $produk->gambar)
                <div class="relative mb-4" x-data="{ showImg: true }">
                    <div class="w-full h-48 rounded-xl overflow-hidden bg-gray-100">
                        <img src="{{ asset('storage/' . $produk->gambar) }}"
                             class="w-full h-full object-cover" alt="{{ $produk->nama }}"
                             id="preview-img">
                    </div>
                    {{-- Tombol hapus gambar lama (visual only) --}}
                    <button type="button"
                            onclick="document.getElementById('preview-img').style.opacity='0.3'"
                            class="absolute top-2 right-2 w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center hover:bg-red-600 transition-colors">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
                @endif

                {{-- Upload Zone --}}
                <label for="gambar"
                       class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300
                              rounded-xl cursor-pointer hover:border-navy-700 hover:bg-blue-50 transition-all group"
                       x-data="{ fileName: '' }"
                       @dragover.prevent
                       @drop.prevent="
                           fileName = $event.dataTransfer.files[0]?.name || '';
                           document.getElementById('gambar').files = $event.dataTransfer.files;
                       ">
                    <div class="text-center px-4" x-show="!fileName">
                        <svg class="w-8 h-8 text-gray-300 group-hover:text-navy-700 mx-auto mb-2 transition-colors"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-xs font-semibold text-gray-500 group-hover:text-navy-700">
                            Click to upload or drag and drop
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">PNG, JPG or WEBP (MAX. 2MB)</p>
                    </div>
                    <div x-show="fileName" class="text-center px-4">
                        <svg class="w-8 h-8 text-green-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs font-semibold text-green-600" x-text="fileName"></p>
                    </div>
                    <input type="file" name="gambar" id="gambar"
                           accept=".jpg,.jpeg,.png,.webp"
                           class="hidden"
                           @change="fileName = $el.files[0]?.name || ''">
                </label>
            </div>

            {{-- Publish Status --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
                <div class="flex items-center justify-between"
                     x-data="{ published: {{ isset($produk) ? ($produk->is_published ? 'true' : 'false') : 'true' }} }">
                    <div>
                        <p class="text-sm font-bold text-gray-800">Publish Status</p>
                        <p class="text-xs text-gray-400 mt-0.5" x-text="published ? 'Visible in public store' : 'Hidden (Draft)'"></p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="is_published" :value="published ? '1' : '0'">
                        <button type="button" @click="published = !published"
                                :class="published ? 'bg-blue-600' : 'bg-gray-300'"
                                class="relative w-12 h-6 rounded-full transition-colors duration-200">
                            <span :class="published ? 'translate-x-6' : 'translate-x-1'"
                                  class="inline-block w-5 h-5 bg-white rounded-full shadow transform transition-transform duration-200">
                            </span>
                        </button>
                    </label>
                </div>
            </div>

            {{-- Metadata (edit mode only) --}}
            @if(isset($produk))
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Last Modified</span>
                    <span class="text-gray-700 font-semibold">
                        {{ $produk->updated_at->format('d M Y, H:i') }}
                    </span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Created By</span>
                    <span class="text-gray-700 font-semibold">Admin</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Active Promotions</span>
                    <span class="text-blue-600 font-bold text-xs">NONE</span>
                </div>
            </div>
            @endif

        </div>
    </div>

    </form>
</div>
@endsection