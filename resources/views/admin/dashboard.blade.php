<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Super Admin</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Kartu Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-blue-600 text-white rounded-lg p-6 shadow-lg">
                    <h3 class="text-lg font-bold">Total Tim Dipesan</h3>
                    <p class="text-4xl font-extrabold mt-2">{{ $totalTim }} Tim</p>
                </div>
                <div class="bg-indigo-600 text-white rounded-lg p-6 shadow-lg">
                    <h3 class="text-lg font-bold">Total Baju Diproduksi</h3>
                    <p class="text-4xl font-extrabold mt-2">{{ $totalBaju }} Pcs</p>
                </div>
            </div>
            
            <!-- Tombol Jalan Pintas -->
            <div class="bg-white p-6 rounded-lg shadow">
                <a href="{{ route('admin.teams.index') }}" class="inline-block bg-gray-800 text-white px-4 py-2 rounded hover:bg-black">Kelola Semua Pesanan &rarr;</a>
                <a href="{{ route('admin.users.index') }}" class="inline-block bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-800 ml-2">Kelola Users &rarr;</a>
            </div>
        </div>
    </div>
</x-app-layout>
