@extends('layouts.app')
@section('title', 'Checkout — Plazza Bangunan Sukses')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">

    {{-- STEP --}}
    <div class="flex items-center justify-center mb-10">
        @foreach([['1','DATA PENGIRIMAN',true], ['2','KONFIRMASI',false], ['3','SELESAI',false]] as [$n,$label,$active])
        <div class="flex items-center {{ !$loop->last ? 'flex-1' : '' }}">
            <div class="flex flex-col items-center">
                <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm
                            {{ $active ? 'bg-navy-700 text-white' : 'bg-gray-200 text-gray-500' }}">
                    {{ $n }}
                </div>
                <span class="text-xs mt-1 font-semibold
                             {{ $active ? 'text-navy-700' : 'text-gray-400' }}">
                    {{ $label }}
                </span>
            </div>
            @if(!$loop->last)
            <div class="flex-1 h-0.5 bg-gray-200 mb-5 mx-2"></div>
            @endif
        </div>
        @endforeach
    </div>

    <form method="POST" action="{{ route('checkout.proses') }}" class="space-y-5">
        @csrf

        {{-- ================= PENGIRIMAN ================= --}}
        <div class="bg-white rounded-2xl border p-6">
            <h2 class="text-lg font-bold mb-5">Informasi Pengiriman</h2>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <input type="text" name="nama_penerima"
                       value="{{ old('nama_penerima', $user->name) }}"
                       placeholder="Nama Lengkap"
                       class="border rounded-xl px-4 py-2.5 text-sm">

                <input type="text" name="telepon"
                       value="{{ old('telepon') }}"
                       placeholder="Telepon"
                       class="border rounded-xl px-4 py-2.5 text-sm">
            </div>

            <textarea name="alamat" rows="3"
                      class="w-full border rounded-xl px-4 py-2.5 text-sm mb-4"
                      placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>

            <div class="grid grid-cols-3 gap-4">
                <input type="text" name="kota" placeholder="Kota" class="border rounded-xl px-4 py-2.5 text-sm">
                <input type="text" name="provinsi" placeholder="Provinsi" class="border rounded-xl px-4 py-2.5 text-sm">
                <input type="text" name="kode_pos" placeholder="Kode Pos" class="border rounded-xl px-4 py-2.5 text-sm">
            </div>
        </div>

        {{-- ================= VOUCHER ================= --}}
        <div class="bg-white rounded-2xl border p-5"
             x-data="voucherApp()" x-init="init()">

            <h3 class="font-bold mb-3">Kode Voucher</h3>

            {{-- INPUT --}}
            <div x-show="!applied" class="flex gap-2">
                <input type="text" x-model="kode"
                       placeholder="Masukkan kode voucher"
                       @keydown.enter.prevent="applyVoucher()"
                       class="flex-1 border rounded-xl px-4 py-2.5 text-sm uppercase">

                <button type="button"
                        @click="applyVoucher()"
                        class="bg-orange-500 text-white px-5 py-2.5 rounded-xl text-sm">
                    Pakai
                </button>
            </div>

            {{-- SUCCESS --}}
            <div x-show="applied"
                 class="bg-green-50 border rounded-xl px-4 py-3 flex justify-between items-center">

                <div>
                    <p class="text-green-700 font-bold"
                       x-text="'Voucher ' + kode + ' aktif'"></p>

                    <p class="text-xs text-green-600"
                       x-text="'Hemat ' + diskonFormat"></p>
                </div>

                <button type="button"
                        @click="removeVoucher()"
                        class="text-red-500 text-xs font-semibold">
                    Hapus
                </button>
            </div>

            {{-- ERROR --}}
            <p x-show="error" x-text="error"
               class="text-red-500 text-xs mt-2"></p>

            <input type="hidden" name="voucher_kode" :value="applied ? kode : ''">
        </div>

        {{-- ================= RINGKASAN ================= --}}
        <div class="bg-white rounded-2xl border p-6">
            <h2 class="text-lg font-bold mb-4">Ringkasan Pesanan</h2>

            <div class="space-y-3 mb-4">
                @foreach($items as $item)
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gray-50 rounded-xl border">
                        <img src="{{ $item->produk->gambar_url }}"
                             class="w-full h-full object-contain p-1">
                    </div>

                    <div class="flex-1">
                        <p class="text-sm font-semibold">{{ $item->produk->nama }}</p>
                        <p class="text-xs text-gray-400">
                            {{ $item->qty }} x Rp {{ number_format($item->produk->harga,0,',','.') }}
                        </p>
                    </div>

                    <p class="font-bold text-sm">
                        Rp {{ number_format($item->subtotal,0,',','.') }}
                    </p>
                </div>
                @endforeach
            </div>

            <div class="border-t pt-4 space-y-2 text-sm">

                <div class="flex justify-between text-gray-500">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>

                <div class="flex justify-between text-gray-500">
                    <span>Ongkos Kirim</span>
                    <span>Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                </div>

                @if($diskon > 0)
                <div class="flex justify-between text-green-600 font-semibold">
                    <span>Diskon Voucher ({{ $voucher_kode }})</span>
                    <span>- Rp {{ number_format($diskon, 0, ',', '.') }}</span>
                </div>
                @endif

                <div class="border-t pt-3 flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- SUBMIT --}}
        <button class="w-full bg-navy-700 text-white py-4 rounded-xl font-bold">
            Buat Pesanan
        </button>

    </form>
</div>

{{-- ================= SCRIPT ================= --}}
<script>
function voucherApp() {
    return {
        kode: '',
        applied: false,
        diskon: 0,
        loading: false,
        error: '',

        init() {
            this.kode   = '{{ $voucher_kode ?? '' }}';
            this.diskon = {{ $diskon ?? 0 }};
            this.applied = this.kode ? true : false;
        },

        get diskonFormat() {
            return 'Rp ' + this.diskon.toLocaleString('id-ID');
        },

        async applyVoucher() {
            if (!this.kode.trim()) {
                this.error = 'Masukkan kode voucher dulu';
                return;
            }

            this.loading = true;
            this.error   = '';

            try {
                const res = await fetch("{{ route('voucher.apply') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ kode: this.kode })
                });

                const data = await res.json();

                if (!data.success) {
                    this.error = data.message;
                    return;
                }

                this.applied = true;
                this.diskon  = data.diskon;

                location.reload();
            } catch (e) {
                this.error = 'Terjadi kesalahan';
            } finally {
                this.loading = false;
            }
        },

        async removeVoucher() {
            await fetch("{{ route('voucher.remove') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            });

            location.reload();
        }
    }
}
</script>

@endsection