@extends('admin.layouts.admin')
@section('title', 'Laporan Penjualan')

@section('content')
<div class="p-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Laporan Penjualan</h1>
    </div>

    {{-- Filter Tanggal --}}
    <form method="GET" class="bg-white rounded-2xl border border-gray-200 p-5 mb-6 flex items-end gap-4">
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Dari Tanggal</label>
            <input type="date" name="dari" value="{{ $dari }}"
                   class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Sampai Tanggal</label>
            <input type="date" name="sampai" value="{{ $sampai }}"
                   class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="submit"
                class="flex items-center gap-2 bg-navy-700 text-white font-bold px-6 py-2.5 rounded-xl text-sm hover:bg-navy-800 transition-colors"
                style="background-color:#0d1b2e;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
            </svg>
            Tampilkan
        </button>
       {{-- 🔥 EXPORT EXCEL (FIX UTAMA) --}}
<a href="{{ route('admin.laporan.export', ['dari' => $dari, 'sampai' => $sampai]) }}"
   class="flex items-center gap-2 border border-gray-200 bg-white text-gray-700 font-bold px-6 py-2.5 rounded-xl text-sm hover:bg-green-50 hover:border-green-300 hover:text-green-700 transition-colors">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    Export Excel
</a>
    </form>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-3 gap-5 mb-8">
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-green-500">+12%</span>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($totalTransaksi) }}</p>
            <p class="text-sm text-gray-500 mt-1">Transaksi Selesai</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-blue-500">+8.4%</span>
            </div>
            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalPendapatan / 1000000, 1) }}M</p>
            <p class="text-sm text-gray-500 mt-1">Total Pendapatan</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-purple-500">+2.1%</span>
            </div>
            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($rataRataTransaksi / 1000, 1) }}k</p>
            <p class="text-sm text-gray-500 mt-1">Rata-rata Transaksi</p>
        </div>
    </div>

    {{-- Tabel Produk Terlaris --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <p class="font-bold text-gray-900">Produk Terlaris</p>
        </div>
        <table class="w-full">
            <thead>
                <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 bg-gray-50">
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">Nama Produk</th>
                    <th class="px-6 py-3 text-left">Kategori</th>
                    <th class="px-6 py-3 text-left">Terjual</th>
                    <th class="px-6 py-3 text-left">Pendapatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($produkTerlaris as $i => $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm font-bold text-gray-300">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                                @if($item->produk && $item->produk->gambar)
                                    <img src="{{ asset('storage/' . $item->produk->gambar) }}"
                                         class="w-full h-full object-cover" alt="">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <span class="text-sm font-semibold text-gray-800">
                                {{ $item->produk->nama ?? 'Produk dihapus' }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($item->produk && $item->produk->kategori)
                        <span class="text-xs font-semibold bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full">
                            {{ $item->produk->kategori }}
                        </span>
                        @else
                        <span class="text-xs text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ number_format($item->total_terjual) }}</td>
                    <td class="px-6 py-4 text-sm font-bold text-navy-700">
                        Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">Belum ada data penjualan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection