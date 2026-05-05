<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    @vite(['resources/css/app.css'])

    {{-- ✅ WAJIB: AlpineJS untuk modal --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 font-sans">

<div class="flex min-h-screen">

    {{-- ================= SIDEBAR ================= --}}
    <aside class="w-64 bg-[#0d1b2e] text-white flex flex-col justify-between">

        <div>
            {{-- Logo --}}
            <div class="px-6 py-5 border-b border-white/10">
                <h1 class="text-lg font-bold tracking-wide">PLAZZA ADMIN</h1>
                <p class="text-xs text-gray-400">Management System</p>
            </div>

            {{-- MENU --}}
            <nav class="p-4 space-y-2 text-sm">

                <a href="{{ route('admin.dashboard') }}"
                   class="block px-4 py-2 rounded-lg transition
                   {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600' : 'hover:bg-white/10' }}">
                    Dashboard
                </a>

                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg transition
                   {{ request()->routeIs('admin.users*') ? 'bg-blue-600' : 'hover:bg-white/10' }}">
                    Kelola User
                </a>

                <a href="{{ route('admin.produk.index') }}"
                   class="block px-4 py-2 rounded-lg transition
                   {{ request()->routeIs('admin.produk.*') ? 'bg-blue-600' : 'hover:bg-white/10' }}">
                    Products
                </a>

                <a href="{{ route('admin.promo.index') }}"
                    class="block px-4 py-2 rounded-lg transition
                    {{ request()->routeIs('admin.promo.*') ? 'bg-blue-600' : 'hover:bg-white/10' }}">
                        Promo
                    </a>

                <a href="{{ route('admin.voucher.index') }}"
                    class="block px-4 py-2 rounded-lg transition
                    {{ request()->routeIs('admin.voucher.*') ? 'bg-blue-600' : 'hover:bg-white/10' }}">
                        Voucher
                    </a>

                <a href="{{ route('admin.stok.index') }}"
                   class="block px-4 py-2 rounded-lg transition
                   {{ request()->routeIs('admin.stok.*') ? 'bg-blue-600' : 'hover:bg-white/10' }}">
                    Stock
                </a>

                <a href="{{ route('admin.pesanan.index') }}"
                   class="block px-4 py-2 rounded-lg transition
                   {{ request()->routeIs('admin.pesanan.*') ? 'bg-blue-600' : 'hover:bg-white/10' }}">
                    Orders
                </a>

                <a href="{{ route('admin.laporan.index') }}"
                   class="block px-4 py-2 rounded-lg transition
                   {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-600' : 'hover:bg-white/10' }}">
                    Reports
                </a>

            </nav>
        </div>

        {{-- LOGOUT --}}
        <div class="p-4 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-4 py-2 rounded-lg hover:bg-red-500/20 text-sm">
                    Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- ================= MAIN ================= --}}
    <div class="flex-1 flex flex-col">

        {{-- TOPBAR --}}
        <div class="flex items-center justify-between px-8 py-4 bg-white border-b">

            <h2 class="text-lg font-semibold text-gray-800">
                @yield('title')
            </h2>

            <div class="flex items-center gap-4">

                {{-- SEARCH --}}
                <form method="GET" action="{{ url()->current() }}">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari ID Pesanan..."
                           class="px-4 py-2 text-sm border rounded-xl w-64 focus:outline-none focus:ring">
                </form>

                {{-- NOTIF --}}
                <button class="relative">
                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a3 3 0 11-6 0"/>
                    </svg>

                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-4 h-4 flex items-center justify-center rounded-full">
                        3
                    </span>
                </button>

                {{-- USER --}}
                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-gray-300 rounded-full"></div>
                    <div class="text-sm">
                        <p class="font-semibold text-gray-800">@auth
    {{ auth()->user()->name }}
@else
    Guest
@endauth</p>
                        <p class="text-xs text-gray-400">Admin</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- CONTENT --}}
        <main class="flex-1">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>