@extends('admin.layouts.admin')
@section('title', 'Dashboard Overview')

@section('content')
<div class="p-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Overview</h1>
            <p class="text-gray-500 mt-1">Sistem Manajemen Plazza Bangunan Sukses</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden">
                <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-800">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Super Admin</p>
            </div>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-4 gap-5 mb-8">

        {{-- Total Produk --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-navy-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Live</span>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($totalProduk) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Produk</p>
        </div>

        {{-- Pesanan Hari Ini --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-green-500 uppercase tracking-wider">+Today</span>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $pesananHariIni }}</p>
            <p class="text-sm text-gray-500 mt-1">Pesanan Hari Ini</p>
        </div>

        {{-- Menunggu Verifikasi --}}
        <div class="bg-white rounded-2xl p-6 border border-red-200 shadow-sm">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-red-500 uppercase tracking-wider">Urgent</span>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $menungguVerifikasi }}</p>
            <p class="text-sm text-gray-500 mt-1">Menunggu Verifikasi</p>
        </div>

        {{-- Pendapatan Bulan Ini --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Month</span>
            </div>
            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($pendapatanBulanIni / 1000000, 1) }}M</p>
            <p class="text-sm text-gray-500 mt-1">Pendapatan</p>
        </div>

    </div>

    {{-- Pesanan Terbaru + Stok Menipis --}}
    <div class="grid grid-cols-3 gap-5">

        {{-- Pesanan Terbaru --}}
        <div class="col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <p class="font-bold text-gray-900">Pesanan Terbaru</p>
                    <p class="text-xs text-gray-400 mt-0.5">Update data real-time transaksi pelanggan</p>
                </div>
                <a href="{{ route('admin.pesanan.index') }}"
                   class="text-sm font-semibold text-blue-600 hover:text-blue-700">Lihat Semua</a>
            </div>
            <table class="w-full">
                <thead>
                    <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-3 text-left">Order ID</th>
                        <th class="px-6 py-3 text-left">Pelanggan</th>
                        <th class="px-6 py-3 text-left">Total</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($pesananTerbaru as $p)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm font-bold text-navy-700">{{ $p->kode_pesanan }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $p->user->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $p->total_format }}</td>
                        <td class="px-6 py-4">
                            @php
                                $c = ['selesai'=>'green','dikirim'=>'purple','diproses'=>'indigo','menunggu_verifikasi'=>'blue','menunggu_pembayaran'=>'yellow','dibatalkan'=>'red'][$p->status]??'gray';
                            @endphp
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-{{ $c }}-100 text-{{ $c }}-700 uppercase">
                                {{ $p->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-400">{{ $p->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Stok Menipis --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-5 py-5 border-b border-gray-100">
                <p class="font-bold text-gray-900">Stok Menipis</p>
                <p class="text-xs text-gray-400 mt-0.5">Segera lakukan pemesanan ulang</p>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($stokMenipis as $produk)
                <div class="px-5 py-4 flex items-start justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ $produk->nama }}</p>
                        <p class="text-xs text-gray-400">SKU: {{ $produk->sku ?? '-' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-red-600">{{ $produk->stok }}</p>
                        <p class="text-xs text-gray-400">Min: {{ $produk->min_stok ?? 10 }}</p>
                    </div>
                </div>
                @empty
                <div class="px-5 py-8 text-center text-sm text-gray-400">
                    Semua stok aman ✅
                </div>
                @endforelse
            </div>
            <div class="p-4 border-t border-gray-100">
                <a href="{{ route('admin.produk.index') }}"
                   class="block w-full text-center bg-navy-700 text-white font-semibold py-3 rounded-xl text-sm hover:bg-navy-800 transition-colors"
                   style="background-color: #0d1b2e;">
                    Kelola Produk
                </a>
            </div>
        </div>

    </div>

</div>
@endsection