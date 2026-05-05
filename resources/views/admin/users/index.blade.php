@extends('admin.layouts.admin')
@section('title', 'Kelola User')

@section('content')
<div class="p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola User</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar pelanggan yang terdaftar di sistem</p>
        </div>
        <a href="{{ route('admin.users.create') }}"
           class="flex items-center gap-2 bg-navy-700 text-white font-bold
                  px-5 py-2.5 rounded-xl hover:bg-navy-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Akun User
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
        {{ session('error') }}
    </div>
    @endif

    {{-- Filter --}}
    <form method="GET" class="flex gap-3 mb-5">
        <input type="text" name="q" value="{{ request('q') }}"
               placeholder="Cari nama atau email..."
               class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm
                      focus:outline-none focus:ring-2 focus:ring-navy-700">
        <select name="status"
                class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm
                       focus:outline-none focus:ring-2 focus:ring-navy-700">
            <option value="">Semua Status</option>
            <option value="aktif"    {{ request('status') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        </select>
        <button type="submit"
                class="bg-navy-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-navy-800">
            Filter
        </button>
        <a href="{{ route('admin.users.index') }}"
           class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50">
            Reset
        </a>
    </form>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600">User</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600">Telepon</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600">Terdaftar</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600">Login Terakhir</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600">Status</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            {{-- Avatar --}}
                            <div class="w-9 h-9 rounded-full flex-shrink-0 overflow-hidden">
                                @if($user->foto_url)
                                <img src="{{ $user->foto_url }}" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full bg-navy-700 flex items-center justify-center
                                            text-white text-sm font-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-gray-600">{{ $user->phone ?? '-' }}</td>
                    <td class="px-5 py-4 text-gray-500 text-xs">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td class="px-5 py-4 text-gray-500 text-xs">
                        {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum pernah' }}
                    </td>
                    <td class="px-5 py-4">
                        @if($user->is_active)
                        <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-full">
                            Aktif
                        </span>
                        @else
                        <span class="bg-red-100 text-red-700 text-xs font-bold px-2.5 py-1 rounded-full">
                            Nonaktif
                        </span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">
                            {{-- Toggle Status --}}
                            <form method="POST" action="{{ route('admin.users.toggleStatus', $user) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors
                                               {{ $user->is_active
                                                  ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200'
                                                  : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>

                            {{-- Reset Password (modal sederhana) --}}
                            <button onclick="resetPass({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                    class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-blue-100
                                           text-blue-700 hover:bg-blue-200 transition-colors">
                                Reset PW
                            </button>

                            {{-- Hapus --}}
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                  onsubmit="return confirm('Hapus akun {{ addslashes($user->name) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-red-100
                                               text-red-700 hover:bg-red-200 transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-12 text-gray-400">
                        <div class="text-4xl mb-2">👤</div>
                        <p>Belum ada user terdaftar</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-5">{{ $users->links('vendor.pagination.tailwind') }}</div>
</div>

{{-- Modal Reset Password --}}
<div id="modalResetPw"
     class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm mx-4">
        <h3 class="font-bold text-gray-900 mb-1">Reset Password</h3>
        <p class="text-sm text-gray-500 mb-5" id="modalUserName"></p>
        <form method="POST" id="formResetPw" action="">
            @csrf
            <div class="mb-3">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                    Password Baru
                </label>
                <input type="password" name="password" required minlength="8"
                       placeholder="Min. 8 karakter"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                              focus:outline-none focus:ring-2 focus:ring-navy-700">
            </div>
            <div class="mb-5">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                    Konfirmasi Password
                </label>
                <input type="password" name="password_confirmation" required
                       placeholder="Ulangi password"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                              focus:outline-none focus:ring-2 focus:ring-navy-700">
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeModal()"
                        class="flex-1 border border-gray-200 text-gray-700 font-semibold
                               py-2.5 rounded-xl hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 bg-navy-700 text-white font-semibold
                               py-2.5 rounded-xl hover:bg-navy-800">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function resetPass(userId, userName) {
    document.getElementById('modalUserName').textContent = 'User: ' + userName;
    document.getElementById('formResetPw').action = '/admin/users/' + userId + '/reset-password';
    document.getElementById('modalResetPw').classList.remove('hidden');
}
function closeModal() {
    document.getElementById('modalResetPw').classList.add('hidden');
}
</script>
@endsection