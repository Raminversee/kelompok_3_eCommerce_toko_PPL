<nav class="bg-white border-b sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between gap-6">

        {{-- LOGO --}}
        <a href="{{ route('home') }}" class="font-bold text-lg text-navy-700">
            Plazza Bangunan Sukses
        </a>

        {{-- MENU --}}
        <div class="hidden md:flex items-center gap-6 text-sm font-semibold text-gray-700">
            <a href="{{ route('home') }}" class="hover:text-navy-700">Home</a>
            <a href="{{ route('produk.index') }}" class="hover:text-navy-700">Produk</a>
            <a href="{{ route('promo.index') }}"
                class="hover:text-navy-700 {{ request()->routeIs('promo.*') ? 'text-navy-700 font-bold border-b-2 border-navy-700' : '' }}">
                    Promo
                </a>
        </div>

        {{-- 🔥 SEARCH FIX TOTAL --}}
        <form action="{{ route('produk.index') }}" method="GET" class="flex-1 max-w-md">
            <input 
                type="text" 
                name="q"
                value="{{ request('q') }}" {{-- 🔥 biar value gak hilang --}}
                placeholder="Cari bahan bangunan..."
                class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-navy-700"
            >

            {{-- 🔥 WAJIB: biar ENTER pasti submit --}}
            <button type="submit" hidden></button>
        </form>

        {{-- RIGHT --}}
        <div class="flex items-center gap-4">

            {{-- CART --}}
            @auth
            @php
                $cartCount = \App\Models\Keranjang::where('user_id', auth()->id())->sum('qty');
            @endphp

            <a href="{{ route('keranjang.index') }}" class="relative text-xl">
                🛒
                @if($cartCount > 0)
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-1 rounded-full">
                    {{ $cartCount }}
                </span>
                @endif
            </a>
            @endauth

            {{-- USER --}}
            @auth
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                        class="bg-navy-700 text-white px-4 py-2 rounded-lg text-sm">
                    {{ auth()->user()->name ?? 'User' }} {{-- 🔥 anti error --}}
                </button>

                <div x-show="open" @click.outside="open=false"
                     class="absolute right-0 mt-2 w-44 bg-white border rounded-lg shadow">

                    <a href="{{ route('profil.index') }}"
                       class="block px-4 py-2 hover:bg-gray-100 text-sm">
                        Profil
                    </a>

                    <a href="{{ route('riwayat.index') }}"
                       class="block px-4 py-2 hover:bg-gray-100 text-sm">
                        Pesanan Saya
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left px-4 py-2 text-red-500 hover:bg-gray-100 text-sm">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
            @else
            <a href="{{ route('login') }}" class="text-sm">Login</a>
            @endauth

        </div>
    </div>
</nav>