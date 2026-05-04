<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Pengguna (Users)</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ $errors->first() }}
                </div>
            @endif
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Tambah Pengguna Baru</h3>
                <form action="{{ route('admin.users.store') }}" method="POST" class="flex flex-wrap gap-4 items-end">
                    @csrf
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm text-gray-600 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full border-gray-300 rounded shadow-sm focus:ring-purple-500 focus:border-purple-500">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm text-gray-600 mb-1">Email</label>
                        <input type="email" name="email" required class="w-full border-gray-300 rounded shadow-sm focus:ring-purple-500 focus:border-purple-500">
                    </div>
                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-sm text-gray-600 mb-1">Password (Min. 8)</label>
                        <input type="password" name="password" required minlength="8" class="w-full border-gray-300 rounded shadow-sm focus:ring-purple-500 focus:border-purple-500">
                    </div>
                    <div class="w-40">
                        <label class="block text-sm text-gray-600 mb-1">Role Akun</label>
                        <select name="role" class="w-full border-gray-300 rounded shadow-sm focus:ring-purple-500 focus:border-purple-500">
                            <option value="user">User Biasa</option>
                            <option value="read">Read Only</option>
                            <option value="super_admin">Super Admin</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="bg-purple-600 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded shadow">
                            + Tambah User
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="py-3 px-4">Nama</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Role Saat Ini</th>
                            <th class="py-3 px-4">Ubah Role</th>
                            <th class="py-3 px-4">Aksi</th>
                            <th class="py-3 px-4">Reset Password</th> <th class="py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $user->name }}</td>
                            <td class="py-3 px-4">{{ $user->email }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded text-xs text-white {{ $user->role === 'super_admin' ? 'bg-purple-600' : ($user->role === 'read' ? 'bg-orange-500' : 'bg-gray-500') }}">
                                    {{ strtoupper($user->role ?? 'USER') }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.update-role', $user->id) }}" method="POST" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="text-sm border-gray-300 rounded shadow-sm">
                                        <option value="user" {{ $user->role === 'user' || $user->role === null ? 'selected' : '' }}>User Biasa</option>
                                        <option value="read" {{ $user->role === 'read' ? 'selected' : '' }}>Read Only</option>
                                        <option value="super_admin" {{ $user->role === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                    </select>
                                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-800">Ubah</button>
                                </form>
                                @else
                                <span class="text-sm text-gray-400 italic">Akun Anda Sendiri</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini? Semua data pesanan miliknya mungkin akan ikut terhapus!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline font-bold text-sm">Hapus Akun</button>
                                </form>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.update-password', $user->id) }}" method="POST" class="flex gap-2" onsubmit="return confirm('Yakin ingin mereset password user ini?');">
                                    @csrf
                                    @method('PATCH')
                                    <input type="text" name="password" placeholder="Pass baru..." required minlength="8" class="text-sm border-gray-300 rounded shadow-sm w-32 focus:ring-purple-500 focus:border-purple-500">
                                    <button type="submit" class="bg-gray-600 text-white px-3 py-1 rounded text-sm hover:bg-gray-800">Save</button>
                                </form>
                                @else
                                <span class="text-sm text-gray-400 italic">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>