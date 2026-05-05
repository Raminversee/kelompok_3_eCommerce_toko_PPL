@extends('layouts.app')
@section('title', $produk->nama)

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    {{-- BREADCRUMB --}}
    <p class="text-sm text-gray-500 mb-6">
        Beranda / Produk / <span class="font-semibold">{{ $produk->nama }}</span>
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

        {{-- ================= LEFT: IMAGE ================= --}}
        <div class="bg-white rounded-xl border p-6 flex items-center justify-center">
            <img src="{{ $produk->gambar_url }}"
                 class="max-h-[400px] object-contain">
        </div>

        {{-- ================= RIGHT: DETAIL ================= --}}
        <div class="bg-white rounded-xl border p-6">

            <h1 class="text-2xl font-bold mb-2">
                {{ $produk->nama }}
            </h1>

            <p class="text-2xl font-bold text-blue-600 mb-2">
                Rp {{ number_format($produk->harga, 0, ',', '.') }}
            </p>

            <p class="text-green-600 text-sm mb-4">
                ✔ Stok tersedia ({{ $produk->stok }})
            </p>

            <p class="text-gray-500 text-sm mb-6">
                {{ $produk->deskripsi }}
            </p>

            {{-- QTY --}}
            <div class="flex items-center gap-3 mb-6">
                <button onclick="decreaseQty()" class="px-3 py-1 border">-</button>
                <input type="text" id="qty" value="1"
                       class="w-12 text-center border">
                <button onclick="increaseQty()" class="px-3 py-1 border">+</button>
            </div>

            {{-- BUTTON --}}
            <div class="flex gap-3">

                @auth

                {{-- TAMBAH KE KERANJANG --}}
                <form action="{{ route('keranjang.tambah', $produk->id) }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="qty" id="qtyInput" value="1">

                    <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                        + Keranjang
                    </button>
                </form>

                {{-- BELI LANGSUNG (FIX) --}}
                <form action="{{ route('beli.langsung') }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                    <input type="hidden" name="qty" id="qtyInputBeli" value="1">

                    <button type="submit"
                            class="w-full text-white py-3 rounded-lg font-semibold hover:opacity-90 transition"
                            style="background-color:#0d1b2e;">
                        Beli Sekarang
                    </button>
                </form>

                @else

                <a href="{{ route('login') }}"
                   class="flex-1 text-center bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Login untuk Beli
                </a>

                @endauth

            </div>

        </div>

    </div>

</div>

{{-- SCRIPT --}}
<script>
function increaseQty() {
    let qty = document.getElementById('qty');
    qty.value = parseInt(qty.value) + 1;

    document.getElementById('qtyInput').value = qty.value;
    document.getElementById('qtyInputBeli').value = qty.value;
}

function decreaseQty() {
    let qty = document.getElementById('qty');

    if (parseInt(qty.value) > 1) {
        qty.value = parseInt(qty.value) - 1;
    }

    document.getElementById('qtyInput').value = qty.value;
    document.getElementById('qtyInputBeli').value = qty.value;
}
</script>

@endsection