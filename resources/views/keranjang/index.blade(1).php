@extends('layouts.app')
@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">

    <h1 class="text-3xl font-bold mb-1">Keranjang Belanja</h1>
    <p class="text-gray-500 mb-8 text-sm">
        Pastikan pesanan Anda sudah sesuai sebelum melanjutkan ke pembayaran.
    </p>

    @if($items->isEmpty())
        <div class="text-center py-20">
            <div class="text-5xl mb-3">🛒</div>
            <p class="text-gray-500 mb-4">Keranjang kosong</p>
            <a href="{{ route('produk.index') }}"
               class="inline-block text-white font-semibold px-6 py-3 rounded-xl hover:opacity-90"
               style="background-color:#0d1b2e;">
                Mulai Belanja
            </a>
        </div>
    @else

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ============ KIRI: ITEM KERANJANG ============ --}}
        <div class="lg:col-span-2 space-y-4">

            @foreach($items as $item)
            <div class="bg-white rounded-xl shadow-sm border p-4 flex items-center gap-4">

                <img src="{{ $item->produk->gambar_url }}"
                     class="w-14 h-14 rounded-lg object-cover border flex-shrink-0">

                <div class="flex-1 min-w-0">
                    <p class="text-[10px] text-blue-600 font-bold uppercase tracking-wider">
                        {{ $item->produk->kategori }}
                    </p>
                    <p class="font-semibold text-gray-800 truncate">{{ $item->produk->nama }}</p>
                    <p class="text-xs text-gray-400">SKU: {{ $item->produk->sku }}</p>
                </div>

                <div class="text-sm text-right w-24 flex-shrink-0">
                    <p class="text-gray-400 text-xs">Harga</p>
                    <p class="font-semibold">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</p>
                </div>

                <div x-data="{ qty: {{ $item->qty }} }" class="flex-shrink-0">
                    <div class="flex items-center bg-gray-100 rounded-lg px-2">
                        <button @click="qty = Math.max(1, qty - 1); updateQty({{ $item->id }}, qty)"
                                class="px-2 py-1 text-gray-600 font-bold text-lg leading-none">−</button>
                        <span class="px-3 font-semibold text-sm" x-text="qty"></span>
                        <button @click="qty = qty + 1; updateQty({{ $item->id }}, qty)"
                                class="px-2 py-1 text-gray-600 font-bold text-lg leading-none">+</button>
                    </div>
                </div>

                <div class="text-right w-28 flex-shrink-0">
                    <p class="text-xs text-gray-400">Subtotal</p>
                    <p class="font-bold text-blue-600 text-sm" id="subtotal-{{ $item->id }}">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </p>
                </div>

                <form method="POST" action="{{ route('keranjang.hapus', $item->id) }}" class="flex-shrink-0">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-400 hover:text-red-600 text-lg">🗑</button>
                </form>

            </div>
            @endforeach

            <div class="flex justify-between mt-4">
                <a href="{{ route('produk.index') }}" class="text-blue-600 text-sm font-semibold">
                    ← Lanjut Belanja
                </a>
                <form method="POST" action="{{ route('keranjang.kosongkan') }}">
                    @csrf @method('DELETE')
                    <button class="text-red-500 text-sm hover:underline">Kosongkan Keranjang</button>
                </form>
            </div>

        </div>

        {{-- ============ KANAN: RINGKASAN + DISKON ============ --}}
        <div
            x-data="diskonApp()"
            x-init="init()"
            class="space-y-4">

            {{-- Ringkasan Pesanan --}}
            <div class="rounded-xl overflow-hidden shadow">
                <div class="bg-[#0d1b2e] text-white p-4 font-semibold text-sm">
                    Ringkasan Pesanan
                </div>
                <div class="bg-white p-4 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Ongkos Kirim</span>
                        <span class="text-gray-400 text-xs">Dihitung saat checkout</span>
                    </div>
                    <div class="flex justify-between" x-show="diskon > 0">
                        <span class="text-green-600 font-semibold">Diskon</span>
                        <span class="text-green-600 font-semibold">- Rp <span x-text="formatAngka(diskon)"></span></span>
                    </div>
                    <hr>
                    <div class="flex justify-between font-bold text-base">
                        <span>Total</span>
                        <span>Rp <span x-text="formatAngka({{ $subtotal }} - diskon)"></span></span>
                    </div>
                </div>
            </div>

            {{-- ============ PANEL DISKON PROMO & VOUCHER ============ --}}
            <div class="bg-white rounded-xl shadow border overflow-hidden">

                {{-- Header Tab --}}
                <div class="flex border-b">
                    <button
                        @click="tab = 'voucher'"
                        :class="tab === 'voucher' ? 'bg-[#0d1b2e] text-white' : 'bg-gray-50 text-gray-600 hover:bg-gray-100'"
                        class="flex-1 py-3 text-xs font-bold uppercase tracking-wider transition-colors flex items-center justify-center gap-1.5">
                        🎟 Kode Voucher
                    </button>
                    <button
                        @click="tab = 'promo'"
                        :class="tab === 'promo' ? 'bg-[#0d1b2e] text-white' : 'bg-gray-50 text-gray-600 hover:bg-gray-100'"
                        class="flex-1 py-3 text-xs font-bold uppercase tracking-wider transition-colors flex items-center justify-center gap-1.5">
                        🏷 Promo Aktif
                    </button>
                </div>

                {{-- ===== TAB VOUCHER ===== --}}
                <div x-show="tab === 'voucher'" class="p-4 space-y-3">

                    {{-- Sudah apply voucher --}}
                    <div x-show="voucherApplied"
                         class="flex items-center justify-between bg-green-50 border border-green-200 rounded-xl px-4 py-3">
                        <div>
                            <p class="text-green-700 font-bold text-sm">
                                🎉 Voucher <span x-text="voucherKode" class="font-mono"></span> aktif!
                            </p>
                            <p class="text-green-600 text-xs mt-0.5">
                                Hemat Rp <span x-text="formatAngka(diskon)"></span>
                            </p>
                        </div>
                        <button @click="hapusDiskon()" class="text-xs text-red-500 font-semibold hover:underline ml-3">
                            Hapus
                        </button>
                    </div>

                    {{-- Form input voucher --}}
                    <div x-show="!voucherApplied">
                        <div class="flex gap-2">
                            <input
                                type="text"
                                x-model="inputVoucher"
                                @keydown.enter.prevent="applyVoucher()"
                                placeholder="Masukkan kode voucher..."
                                :class="errorMsg ? 'border-red-400' : 'border-gray-200'"
                                class="flex-1 border rounded-xl px-3 py-2.5 text-sm uppercase font-mono focus:outline-none focus:ring-2 focus:ring-blue-400"
                                :disabled="loading">
                            <button
                                @click="applyVoucher()"
                                :disabled="loading || !inputVoucher.trim()"
                                class="bg-[#0d1b2e] text-white px-4 py-2.5 rounded-xl text-sm font-bold hover:opacity-90 disabled:opacity-40 transition-opacity whitespace-nowrap">
                                <span x-show="!loading">Pakai</span>
                                <span x-show="loading">...</span>
                            </button>
                        </div>
                        <p x-show="errorMsg" x-text="errorMsg" class="text-red-500 text-xs mt-1.5"></p>
                        <p x-show="successMsg" x-text="successMsg" class="text-green-600 text-xs mt-1.5"></p>
                    </div>

                </div>

                {{-- ===== TAB PROMO ===== --}}
                <div x-show="tab === 'promo'" class="p-4">

                    @if($promos->isEmpty())
                        <div class="text-center py-6">
                            <p class="text-2xl mb-2">🏷</p>
                            <p class="text-gray-400 text-sm">Belum ada promo aktif saat ini.</p>
                        </div>
                    @else
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-3">
                            Promo tersedia
                        </p>
                        <div class="space-y-2 max-h-64 overflow-y-auto">
                           @foreach($promos as $promo)
                        <button
                            @click="applyPromo({{ $promo->id }}, {{ $promo->nilai_diskon ?? 0 }}, '{{ $promo->judul }}')"
                            class="w-full text-left border border-gray-100 rounded-xl p-3 hover:border-blue-300 hover:bg-blue-50 transition cursor-pointer">
                                <div class="flex items-start gap-3">
                                    {{-- Badge --}}
                                    @if($promo->badge_text)
                                    @php
                                        $bc = ['red'=>'bg-red-500','blue'=>'bg-blue-500','green'=>'bg-green-500','orange'=>'bg-orange-500'][$promo->badge_color ?? 'red'] ?? 'bg-red-500';
                                    @endphp
                                    <span class="{{ $bc }} text-white text-xs font-bold px-2 py-0.5 rounded-full whitespace-nowrap flex-shrink-0">
                                        {{ $promo->badge_text }}
                                    </span>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-gray-800">{{ $promo->judul }}</p>
                                        @if($promo->deskripsi)
                                        <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">{{ $promo->deskripsi }}</p>
                                        @endif
                                        @if($promo->tanggal_selesai)
                                        <p class="text-xs text-red-400 mt-1 flex items-center gap-1">
                                            ⏱ s/d {{ $promo->tanggal_selesai->format('d M Y') }}
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </button>
                            @endforeach
                        </div>
                        <a href="{{ route('promo.index') }}"
                           class="block text-center text-xs text-blue-600 font-semibold mt-3 hover:underline">
                            Lihat semua promo →
                        </a>
                    @endif

                </div>

            </div>

            {{-- Tombol Checkout --}}
            <a href="{{ route('checkout.index') }}"
               class="block text-white text-center py-3.5 rounded-xl font-bold hover:opacity-90 transition-opacity"
               style="background-color:#0d1b2e;">
                Checkout Sekarang →
            </a>

            {{-- Keamanan Transaksi --}}
            <div class="rounded-xl p-5 text-sm space-y-2" style="background-color:#0d1b2e;">
                <p class="text-xs font-bold text-blue-200 tracking-widest uppercase mb-3">
                    KEAMANAN TRANSAKSI
                </p>
                <div class="flex gap-2 text-blue-100"><span>✔</span><span>Enkripsi 256-bit SSL melindungi data Anda.</span></div>
                <div class="flex gap-2 text-blue-100"><span>✔</span><span>Customer Support 24/7 siap membantu.</span></div>
                <div class="flex gap-2 text-blue-100"><span>✔</span><span>Produk 100% asli dari distributor resmi.</span></div>
            </div>

        </div>
    </div>

    @endif

</div>

{{-- ============ SCRIPT ============ --}}
<script>
// Update qty item
function updateQty(id, qty) {
    fetch(`/keranjang/update/${id}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ qty })
    })
    .then(res => res.json())
    .then(() => location.reload());
}

// Alpine component untuk diskon
function diskonApp() {
    return {
        tab: 'voucher',

        // Voucher state
        voucherApplied: {{ $diskon > 0 ? 'true' : 'false' }},
        voucherKode: '{{ $voucher_kode ?? "" }}',
        inputVoucher: '',
        diskon: {{ $diskon > 0 ? $diskon : 0 }},
        loading: false,
        errorMsg: '',
        successMsg: '',

        // Promo state
        promoApplied: false,
        promoNama: '',

        init() {
            if (this.voucherApplied && this.voucherKode) {
                this.tab = 'voucher';
            }
        },

        formatAngka(n) {
            return Math.max(0, Math.round(n)).toLocaleString('id-ID');
        },

        // ================= VOUCHER =================
        async applyVoucher() {
            if (!this.inputVoucher.trim()) return;

            this.loading = true;
            this.errorMsg = '';
            this.successMsg = '';

            try {
                const res = await fetch('/voucher/apply', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ kode: this.inputVoucher.trim() }),
                });

                const data = await res.json();

                if (data.success) {
                    this.voucherApplied = true;
                    this.voucherKode = data.kode;
                    this.diskon = data.diskon;
                    this.successMsg = data.message;
                    this.inputVoucher = '';

                    // reload biar total update
                    setTimeout(() => location.reload(), 500);

                } else {
                    this.errorMsg = data.message;
                }
            } catch (e) {
                this.errorMsg = 'Terjadi kesalahan. Silakan coba lagi.';
            } finally {
                this.loading = false;
            }
        },

        async hapusDiskon() {
            await fetch('/voucher/remove', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            });

            location.reload();
        },

        // ================= PROMO =================
        applyPromo(id, nilai, nama) {
            // 🔥 FIX: langsung apply di frontend
            this.diskon = nilai;
            this.promoApplied = true;
            this.promoNama = nama;

            this.successMsg = 'Promo "' + nama + '" berhasil digunakan!';
            this.errorMsg = '';

            // OPTIONAL: kalau mau replace voucher
            this.voucherApplied = false;
            this.voucherKode = '';

            // reload biar konsisten (optional)
            setTimeout(() => location.reload(), 500);
        }
    };
}
</script>
@endsection
