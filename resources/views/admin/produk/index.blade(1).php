@extends('admin.layouts.admin')
@section('title', 'Kelola Produk')

@section('content')
<div class="p-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Produk</h1>
            <p class="text-gray-500 mt-1">Kelola inventaris material bangunan Anda.</p>
        </div>
        <a href="{{ route('admin.produk.create') }}"
           class="flex items-center gap-2 text-white font-bold px-5 py-3 rounded-xl text-sm hover:opacity-90 transition-opacity"
           style="background-color:#0d1b2e;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Produk
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="mb-5 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Search & Filter --}}
    <form method="GET" class="flex gap-3 mb-6">
        <div class="relative flex-1">
            <svg class="absolute left-4 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama produk atau SKU..."
                   class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <select name="kategori"
                class="border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white min-w-[180px]">
            <option value="semua">Semua Kategori</option>
            @foreach($kategoriList as $kat)
            <option value="{{ $kat['db'] }}" {{ request('kategori') === $kat['db'] ? 'selected' : '' }}>
                {{ $kat['icon'] }} {{ $kat['nama'] }}
            </option>
            @endforeach
        </select>
        <button type="submit"
                class="flex items-center gap-2 border border-gray-200 bg-white text-gray-600 font-semibold px-4 py-3 rounded-xl text-sm hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
            </svg>
            Filter
        </button>
    </form>

    {{-- Tabel Produk --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden"
         x-data="{ showModal: false, deleteId: null, deleteName: '' }">

        <table class="w-full">
            <thead>
                <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 bg-gray-50">
                    <th class="px-6 py-4 text-left w-12">No</th>
                    <th class="px-6 py-4 text-left">Produk</th>
                    <th class="px-6 py-4 text-left">Kategori</th>
                    <th class="px-6 py-4 text-left">Harga</th>
                    <th class="px-6 py-4 text-left">Stok</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($produks as $i => $produk)
                <tr class="hover:bg-gray-50 transition-colors">

                    {{-- No --}}
                    <td class="px-6 py-4 text-sm font-bold text-gray-300">
                        {{ str_pad($produks->firstItem() + $i, 2, '0', STR_PAD_LEFT) }}
                    </td>

                    {{-- Produk --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                                @if($produk->gambar)
                                    <img src="{{ asset('storage/' . $produk->gambar) }}"
                                         class="w-full h-full object-cover" alt="{{ $produk->nama }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">{{ $produk->nama }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">SKU: {{ $produk->sku }}</p>
                                @if(!$produk->is_published)
                                <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded mt-1 inline-block">
                                    Draft
                                </span>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- Kategori --}}
                    <td class="px-6 py-4">
                        <span class="text-xs font-semibold bg-blue-50 text-blue-700 px-3 py-1 rounded-full">
                            {{ $produk->kategori }}
                        </span>
                    </td>

                    {{-- Harga --}}
                    <td class="px-6 py-4 text-sm font-bold text-navy-700">
                        {{ $produk->harga_format }}
                    </td>

                    {{-- Stok --}}
                    <td class="px-6 py-4">
                        <span class="text-sm font-bold {{ $produk->stok_menipis ? 'text-red-500' : 'text-gray-800' }}">
                            {{ $produk->stok }}
                        </span>
                        @if($produk->stok_menipis)
                        <span class="block text-xs text-red-400">Menipis!</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            {{-- Edit --}}
                            <a href="{{ route('admin.produk.edit', $produk->id) }}"
                               class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center hover:bg-blue-100 transition-colors"
                               title="Edit">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            {{-- Hapus (buka modal) --}}
                            <button @click="showModal=true; deleteId={{ $produk->id }}; deleteName='{{ addslashes($produk->nama) }}'"
                                    class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center hover:bg-red-100 transition-colors"
                                    title="Hapus">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <p class="text-gray-400 font-semibold">Tidak ada produk ditemukan</p>
                        <a href="{{ route('admin.produk.create') }}"
                           class="text-sm text-blue-600 hover:underline mt-1 inline-block">
                            + Tambah produk pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($produks->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
            <span>Menampilkan {{ $produks->firstItem() }}-{{ $produks->lastItem() }} dari {{ $produks->total() }} Produk</span>
            <div class="flex items-center gap-1">
                {{-- Prev --}}
                @if($produks->onFirstPage())
                    <span class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 text-gray-300 cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </span>
                @else
                    <a href="{{ $produks->appends(request()->query())->previousPageUrl() }}"
                       class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                @endif

                {{-- Page numbers --}}
                @foreach($produks->appends(request()->query())->getUrlRange(
                    max(1, $produks->currentPage()-2),
                    min($produks->lastPage(), $produks->currentPage()+2)
                ) as $page => $url)
                <a href="{{ $url }}"
                   class="w-9 h-9 flex items-center justify-center rounded-xl text-sm font-semibold transition-colors
                          {{ $page == $produks->currentPage()
                                ? 'text-white'
                                : 'border border-gray-200 hover:bg-gray-50 text-gray-600' }}"
                   style="{{ $page == $produks->currentPage() ? 'background-color:#0d1b2e;' : '' }}">
                    {{ $page }}
                </a>
                @endforeach

                {{-- Next --}}
                @if($produks->hasMorePages())
                    <a href="{{ $produks->appends(request()->query())->nextPageUrl() }}"
                       class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @else
                    <span class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 text-gray-300 cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                @endif
            </div>
        </div>
        @endif

        {{-- ===== MODAL HAPUS (Alpine.js) ===== --}}
        <div x-show="showModal"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="fixed inset-0 z-50 flex items-center justify-center"
             style="display:none; background-color: rgba(15,23,42,0.5);">

            <div @click.stop
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="bg-white rounded-3xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden">

                {{-- Ikon Warning --}}
                <div class="pt-8 pb-4 px-8 text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-3">Hapus Produk?</h2>

                    {{-- Pesan warning dengan border kiri merah --}}
                    <div class="border-l-4 border-red-400 bg-red-50 rounded-r-xl p-4 text-left mb-6">
                        <p class="text-sm text-gray-700">
                            Apakah Anda yakin ingin menghapus
                            <strong x-text="deleteName" class="text-gray-900"></strong>?
                            Tindakan ini tidak dapat dibatalkan dan semua data terkait produk ini
                            akan dihapus permanen dari sistem.
                        </p>
                    </div>
                    <p class="text-xs font-bold text-gray-400 tracking-widest uppercase mb-6">
                        Technical Specification Update
                    </p>
                </div>

                {{-- Tombol --}}
                <div class="px-8 pb-6 flex gap-3">
                    <button @click="showModal=false"
                            class="flex-1 font-bold py-3.5 rounded-xl border-2 border-gray-200 text-gray-700 hover:bg-gray-50 transition-colors text-sm">
                        Batal
                    </button>
                    <form :action="'/admin/produk/' + deleteId" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full font-bold py-3.5 rounded-xl bg-red-500 text-white hover:bg-red-600 transition-colors text-sm flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>

                {{-- Footer info --}}
                <div class="bg-gray-50 px-8 py-3 flex justify-between">
                    <span class="text-xs text-gray-400">ACTION_ID: DEL_PRD_<span x-text="deleteId"></span></span>
                    <span class="text-xs text-gray-400">IP: 192.168.1.XX</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection