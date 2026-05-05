<footer class="bg-white border-t mt-16">
    <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8 text-sm">

        {{-- BRAND --}}
        <div>
            <h3 class="font-bold text-lg mb-3">Plazza Bangunan Sukses</h3>
            <p class="text-gray-500">
                Solusi terlengkap untuk kebutuhan konstruksi,
                renovasi, dan dekorasi rumah Anda dengan
                kualitas material premium.
            </p>
        </div>

        {{-- PERUSAHAAN --}}
        <div>
            <h4 class="font-bold mb-3">Perusahaan</h4>
            <ul class="space-y-2 text-gray-500">
                <li><a href="#">About Us</a></li>
                <li><a href="#">Store Locator</a></li>
                <li><a href="#">Contact Support</a></li>
            </ul>
        </div>

        {{-- LAYANAN --}}
        <div>
            <h4 class="font-bold mb-3">Layanan</h4>
            <ul class="space-y-2 text-gray-500">
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Track Order</a></li>
            </ul>
        </div>

        {{-- NEWSLETTER --}}
        <div>
            <h4 class="font-bold mb-3">Newsletter</h4>
            <p class="text-gray-500 mb-3">
                Dapatkan info produk terbaru dan promo eksklusif.
            </p>
            <div class="flex gap-2">
                <input type="email" placeholder="Email Address"
                       class="flex-1 border px-3 py-2 rounded-lg text-sm">
                <button class="bg-navy-700 text-white px-3 py-2 rounded-lg">
                    Daftar
                </button>
            </div>
        </div>
    </div>
    {{-- COPYRIGHT --}}
    <div class="text-center text-xs text-gray-400 py-4">
        © {{ date('Y') }} Plazza Bangunan Sukses
    </div>
</footer>