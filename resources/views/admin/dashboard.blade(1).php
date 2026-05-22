@extends('admin.layout')

@section('title', 'Dashboard Overview')

@section('content')

{{-- STAT CARDS --}}
<div class="grid grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-2xl p-6 border-l-4 border-blue-500 shadow-sm">
        <p class="text-xs font-bold text-gray-400 uppercase">Live</p>
        <p class="text-3xl font-bold mt-2">{{ $totalProduk }}</p>
        <p class="text-sm text-gray-500">Total Produk</p>
    </div>

    <div class="bg-white rounded-2xl p-6 border-l-4 border-green-500 shadow-sm">
        <p class="text-xs font-bold text-green-500 uppercase">+Today</p>
        <p class="text-3xl font-bold mt-2">{{ $pesananHariIni }}</p>
        <p class="text-sm text-gray-500">Pesanan Hari Ini</p>
    </div>

    <div class="bg-white rounded-2xl p-6 border-l-4 border-red-500 shadow-sm">
        <p class="text-xs font-bold text-red-500 uppercase">Urgent</p>
        <p class="text-3xl font-bold mt-2">{{ $menungguVerifikasi }}</p>
        <p class="text-sm text-gray-500">Menunggu Verifikasi</p>
    </div>

    <div class="bg-white rounded-2xl p-6 border-l-4 border-indigo-500 shadow-sm">
        <p class="text-xs font-bold text-gray-400 uppercase">Month</p>
        <p class="text-2xl font-bold mt-2">Rp {{ number_format($pendapatanBulanIni) }}</p>
        <p class="text-sm text-gray-500">Pendapatan</p>
    </div>

</div>


{{-- TABLE + STOK --}}
<div class="grid grid-cols-3 gap-6">

    {{-- TABLE --}}
    <div class="col-span-2 bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="font-bold">Pesanan Terbaru</h2>
        </div>

        <table class="w-full text-sm">
            <thead class="text-xs text-gray-400 uppercase border-b">
                <tr>
                    <th class="px-6 py-3 text-left">Order</th>
                    <th class="px-6 py-3 text-left">User</th>
                    <th class="px-6 py-3 text-left">Total</th>
                    <th class="px-6 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesananTerbaru as $p)
                <tr class="border-b hover:bg-gray-50">

                    <td class="px-6 py-4 font-semibold">{{ $p->kode_pesanan }}</td>
                    <td class="px-6 py-4">{{ $p->user->name ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $p->total_format }}</td>

                    <td class="px-6 py-4">
                        @php
                        $color = match($p->status) {
                            'selesai' => 'green',
                            'diproses' => 'blue',
                            'menunggu_verifikasi' => 'yellow',
                            'dibatalkan' => 'red',
                            default => 'gray'
                        };
                        @endphp

                        <span class="px-2 py-1 text-xs rounded-full bg-{{ $color }}-100 text-{{ $color }}-700">
                            {{ $p->status }}
                        </span>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    {{-- STOK MENIPIS --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b">
            <h2 class="font-bold">Stok Menipis</h2>
        </div>

        <div class="divide-y">
            @forelse($stokMenipis as $produk)
            <div class="p-4 flex justify-between items-center">
                <div>
                    <p class="font-semibold text-sm">{{ $produk->nama }}</p>
                    <p class="text-xs text-gray-400">Min: {{ $produk->min_stok ?? 10 }}</p>
                </div>
                <span class="text-red-600 font-bold text-sm">
                    {{ $produk->stok }}
                </span>
            </div>
            @empty
            <p class="p-4 text-gray-400 text-sm">Semua aman</p>
            @endforelse
        </div>
    </div>

</div>

@endsection