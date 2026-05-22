@extends('admin.layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-6">Detail Pesanan</h2>

    {{-- INFO --}}
    <div class="grid grid-cols-2 gap-6">

        <div>
            <p class="text-sm text-gray-500">Kode Pesanan</p>
            <p class="font-semibold">{{ $pesanan->kode_pesanan }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Nama Pelanggan</p>
            <p class="font-semibold">{{ $pesanan->user->name }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Status</p>

            @php
                $colors = [
                    'menunggu_pembayaran' => 'bg-gray-100 text-gray-700',
                    'menunggu_verifikasi' => 'bg-yellow-100 text-yellow-700',
                    'diproses' => 'bg-blue-100 text-blue-700',
                    'dikirim' => 'bg-indigo-100 text-indigo-700',
                    'selesai' => 'bg-green-100 text-green-700',
                    'dibatalkan' => 'bg-red-100 text-red-700',
                ];
            @endphp

            <span class="px-3 py-1 rounded-full text-xs {{ $colors[$pesanan->status] ?? 'bg-gray-100' }}">
                {{ ucfirst(str_replace('_',' ', $pesanan->status)) }}
            </span>
        </div>

        <div>
            <p class="text-sm text-gray-500">Tanggal</p>
            <p class="font-semibold">{{ $pesanan->created_at->format('d M Y') }}</p>
        </div>

    </div>

    {{-- PRODUK --}}
    <div class="mt-6">
        <h3 class="font-bold mb-3">Produk</h3>

        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Produk</th>
                    <th class="text-left py-2">Qty</th>
                    <th class="text-left py-2">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesanan->details as $item)
                <tr class="border-b">
                    <td class="py-2">{{ $item->produk->nama }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>Rp {{ number_format($item->harga) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- TOTAL --}}
    <div class="mt-6 text-right">
        <p class="text-gray-500">Total</p>
        <p class="text-xl font-bold">Rp {{ number_format($pesanan->total) }}</p>
    </div>

    {{-- AKSI --}}
    <div class="mt-8 border-t pt-6">
        <h3 class="font-bold mb-4">Aksi Pesanan</h3>

        {{-- MENUNGGU VERIFIKASI --}}
        @if($pesanan->status == 'menunggu_verifikasi')
        <div class="flex gap-3">

            <form method="POST" action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="diproses">

                <button class="bg-green-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-green-700">
                    ✔ Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="dibatalkan">

                <button class="border border-red-500 text-red-600 px-5 py-2 rounded-lg text-sm hover:bg-red-50">
                    ✖ Tolak
                </button>
            </form>

        </div>
        @endif

        {{-- DIPROSES --}}
        @if($pesanan->status == 'diproses')
        <form method="POST" action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="dikirim">

            <button class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-blue-700">
                🚚 Kirim Barang
            </button>
        </form>
        @endif

        {{-- DIKIRIM --}}
        @if($pesanan->status == 'dikirim')
        <form method="POST" action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="selesai">

            <button class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-indigo-700">
                ✔ Selesaikan Pesanan
            </button>
        </form>
        @endif

        {{-- SELESAI --}}
        @if($pesanan->status == 'selesai')
        <p class="text-green-600 font-semibold">✔ Pesanan sudah selesai</p>
        @endif

    </div>

    {{-- BACK --}}
    <div class="mt-6">
        <a href="{{ route('admin.pesanan.index') }}"
           class="bg-gray-200 px-4 py-2 rounded-lg text-sm">
            ← Kembali
        </a>
    </div>

</div>
@endsection