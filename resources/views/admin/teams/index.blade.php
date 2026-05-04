<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Pesanan Jersey
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Nama Tim</th>
                            <th class="py-2">Pemesan</th>
                            <th class="py-2">Jumlah Baju</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teams as $team)
                        <tr class="border-b">
                            <td class="py-2">{{ $team->nama_team }}</td>
                            <td class="py-2">{{ $team->user->name }}</td>
                            <td class="py-2">{{ $team->jerseys->count() }} Pcs</td>
                            <td class="py-2">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                                    {{ strtoupper($team->status_order) }}
                                </span>
                            </td>
                            <td class="py-2">
                                <!-- TOMBOL DETAIL -->
   				 <a href="{{ route('admin.teams.show', $team->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">Detail</a>

  				 <!-- TOMBOL HAPUS (Form) -->
  				 <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tim ini? SEMUA data baju di dalamnya juga akan ikut terhapus permanen!');">
       				 @csrf
       				 @method('DELETE')
        			 <button type="submit" class="text-red-600 hover:text-red-900 font-bold cursor-pointer">Hapus</button>
   				 </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
