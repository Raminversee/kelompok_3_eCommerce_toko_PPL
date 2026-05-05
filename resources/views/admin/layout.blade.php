<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-[#0d1b2e] text-white flex flex-col justify-between">
        <div>
            <div class="p-6 border-b border-white/10">
                <h1 class="font-bold text-lg">PLAZZA ADMIN</h1>
                <p class="text-xs text-gray-300">Management System</p>
            </div>

            <nav class="p-4 space-y-2 text-sm">

                <a href="{{ route('admin.dashboard') }}"
                   class="block px-4 py-2 rounded-lg hover:bg-white/10 {{ request()->routeIs('admin.dashboard') ? 'bg-white/10' : '' }}">
                    Dashboard
                </a>

                <a href="{{ route('admin.users.index') }}"
                   class="block px-4 py-2 rounded-lg hover:bg-white/10 {{ request()->routeIs('admin.users.*') ? 'bg-white/10' : '' }}">
                    Kelola User
                </a>

            </nav>
        </div>

        <div class="p-4 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-4 py-2 text-red-300 hover:bg-red-500/20 rounded-lg">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- CONTENT --}}
    <main class="flex-1 p-6">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-xl shadow-sm">

            <h2 class="text-lg font-semibold">@yield('title')</h2>

            @php $user = auth()->user(); @endphp

            <div class="flex items-center gap-3">

                {{-- FOTO PROFIL --}}
                <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <label class="cursor-pointer relative group">
                        @if($user->foto_url)
                            <img src="{{ $user->foto_url }}"
                                 class="w-10 h-10 rounded-full object-cover border">
                        @else
                            <div class="w-10 h-10 rounded-full bg-blue-700 text-white flex items-center justify-center font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif

                        {{-- Overlay hover --}}
                        <div class="absolute inset-0 bg-black/40 rounded-full hidden group-hover:flex items-center justify-center text-white text-xs">
                            Ganti
                        </div>

                        <input type="file" name="foto" class="hidden" onchange="this.form.submit()">
                    </label>
                </form>

                {{-- NAMA --}}
                <div class="text-sm">
                    <p class="font-semibold">{{ $user->name }}</p>
                    <p class="text-gray-400 text-xs capitalize">{{ $user->role }}</p>
                </div>

            </div>
        </div>

        {{-- ISI --}}
        @yield('content')

    </main>

</div>

</body>
</html>