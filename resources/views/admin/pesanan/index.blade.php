@extends('admin.layouts.admin')

@section('title', 'Kelola Pesanan')

@section('content')

{{-- FILTER --}}
<div class="flex gap-2 mb-6">
    @php
        $statuses = [
            'semua' => 'Semua',
            'menunggu_pembayaran' => 'Menunggu',
            'diproses' => 'Diproses',
            'dikirim' => 'Dikirim',
            'selesai' => 'Selesai'
        ];
    @endphp

    @foreach($statuses as $key => $label)
        <a href="?status={{ $key }}"
           class="px-4 py-2 text-sm rounded-xl font-medium
           {{ request('status','semua') == $key ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

{{-- TABLE --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-400 text-xs uppercase">
            <tr>
                <th class="p-3 text-left">No</th>
                <th class="p-3 text-left">Order ID</th>
                <th class="p-3 text-left">Pelanggan</th>
                <th class="p-3 text-left">Total</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-left">Tanggal</th>
                <th class="p-3 text-left">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse($pesanans as $i => $p)
            <tr class="hover:bg-gray-50">
                <td class="p-3">{{ $pesanans->firstItem() + $i }}</td>
                <td class="p-3 font-semibold text-blue-600">{{ $p->kode_pesanan }}</td>
                <td class="p-3">{{ $p->user->name ?? '-' }}</td>
                <td class="p-3">Rp {{ number_format($p->total) }}</td>

                <td class="p-3">
                    @php
                        $colors = [
                            'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-700',
                            'diproses' => 'bg-blue-100 text-blue-700',
                            'dikirim' => 'bg-purple-100 text-purple-700',
                            'selesai' => 'bg-green-100 text-green-700',
                            'dibatalkan' => 'bg-red-100 text-red-700',
                        ];
                    @endphp
                    <span class="px-3 py-1 text-xs rounded-full {{ $colors[$p->status] ?? 'bg-gray-100' }}">
                        {{ str_replace('_',' ', $p->status) }}
                    </span>
                </td>

                <td class="p-3">{{ $p->created_at->format('d M Y') }}</td>

                <td class="p-3">
                    <a href="{{ route('admin.pesanan.show', $p->id) }}"
                       class="bg-blue-600 text-white px-3 py-1 text-xs rounded-lg">
                        Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center p-4 text-gray-400">
                    Belum ada pesanan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="p-4">
        {{ $pesanans->links() }}
    </div>
</div>

{{-- STATS --}}
<div class="grid grid-cols-4 gap-4 mt-6">
    <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-xs text-gray-400">Total Penjualan</p>
        <p class="font-bold">Rp {{ number_format($stats['total_penjualan']) }}</p>
    </div>

    <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-xs text-gray-400">Pesanan Baru</p>
        <p class="font-bold">{{ $stats['pesanan_baru'] }}</p>
    </div>

    <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-xs text-gray-400">Siap Kirim</p>
        <p class="font-bold">{{ $stats['siap_kirim'] }}</p>
    </div>

    <div class="bg-white p-4 rounded-xl shadow">
        <p class="text-xs text-gray-400">Komplain</p>
        <p class="font-bold text-red-500">0</p>
    </div>
</div>

@endsection