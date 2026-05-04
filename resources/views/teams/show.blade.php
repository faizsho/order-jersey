<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tim: {{ $team->nama_team }}
            </h2>
            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-bold">
                Status: {{ strtoupper($team->status_order) }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- TAMPILKAN PESAN ERROR JIKA ADA -->
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ $errors->first() }}
                </div>
            @endif
            
            <!-- CEK STATUS: JIKA DRAFT DAN BUKAN READ-ONLY BISA INPUT, JIKA BUKAN MAKA HILANG -->
            @if($team->status_order === 'draft' && auth()->user()->role !== 'read')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Tambah Anggota / Baju</h3>
                <form action="{{ route('jerseys.store', $team->id) }}" method="POST" class="flex flex-wrap gap-4 items-end">
                    @csrf
                    <!-- Input Nama, Nomor, Ukuran dll sama persis kaya admin -->
                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-sm text-gray-600 mb-1">Nama Punggung</label>
                        <input type="text" name="nama_punggung" required class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="w-24">
                        <label class="block text-sm text-gray-600 mb-1">Nomor</label>
                        <input type="text" name="nomor_punggung" required class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="w-24">
                        <label class="block text-sm text-gray-600 mb-1">Ukuran</label>
                        <select name="ukuran" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option>S</option><option>M</option><option>L</option><option>XL</option><option>XXL</option>
                        </select>
                    </div>
                    <div class="w-32">
                        <label class="block text-sm text-gray-600 mb-1">Lengan</label>
                        <select name="lengan" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option>Pendek</option><option>Panjang</option>
                        </select>
                    </div>
                    <div class="w-32">
                        <label class="block text-sm text-gray-600 mb-1">Kategori</label>
                        <select name="kategori" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option>Player</option><option>Kiper</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded shadow">+ Tambah</button>
                    </div>
                </form>
            </div>
            @else
            <!-- NOTIFIKASI JIKA STATUS BUKAN DRAFT ATAU AKUN READ-ONLY -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700 font-bold">Perhatian: Mode Hanya Lihat (Read-Only) / Pesanan Dikunci.</p>
                        <p class="text-sm text-yellow-700">Anda hanya dapat melihat daftar pesanan dan tidak dapat menambah atau menghapus data baju.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Tabel Daftar Baju + Fitur Excel & Sorting -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- HEADER TABEL, SORT & TOMBOL EXCEL -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 border-b pb-4 gap-4">
                    <h3 class="text-lg font-bold">Daftar Baju ({{ $team->jerseys->count() }} Pcs)</h3>
                    
                    <div class="flex flex-wrap items-center gap-2">
                        
                        <!-- FITUR SORTING (BARU) -->
                        <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2 mr-2">
                            <span class="text-sm text-gray-600 font-bold">Urutkan:</span>
                            <select name="sort" onchange="this.form.submit()" class="text-sm border-gray-300 rounded shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 cursor-pointer">
                                <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Input Terbaru</option>
                                <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama Punggung (A-Z)</option>
                                <option value="nomor" {{ request('sort') == 'nomor' ? 'selected' : '' }}>Nomor (Kecil ke Besar)</option>
                                <option value="ukuran" {{ request('sort') == 'ukuran' ? 'selected' : '' }}>Ukuran</option>
                            </select>
                        </form>

                        <!-- TOMBOL EXPORT -->
                        <a href="{{ route('jerseys.export', $team->id) }}" class="bg-green-600 hover:bg-green-800 text-white text-sm font-bold py-2 px-4 rounded shadow">
                            Download Excel
                        </a>

                        <!-- FORM IMPORT (Disembunyikan jika Read-Only atau pesanan bukan DRAFT) -->
                        @if(auth()->user()->role !== 'read' && (auth()->user()->role === 'super_admin' || $team->status_order === 'draft'))
                        <form action="{{ route('jerseys.import', $team->id) }}" method="POST" enctype="multipart/form-data" class="flex gap-2 items-center">
                            @csrf
                            <input type="file" name="file_excel" required accept=".xlsx, .xls, .csv" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white text-sm font-bold py-2 px-4 rounded shadow whitespace-nowrap">
                                Upload Excel
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                <!-- LOGIKA SORTING KOLEKSI -->
                @php
                    $jerseys = $team->jerseys;
                    if (request('sort') === 'nama') {
                        $jerseys = $jerseys->sortBy('nama_punggung')->values();
                    } elseif (request('sort') === 'nomor') {
                        $jerseys = $jerseys->sortBy('nomor_punggung', SORT_NATURAL)->values();
                    } elseif (request('sort') === 'ukuran') {
                        $jerseys = $jerseys->sortBy('ukuran')->values();
                    }
                @endphp

                <!-- TABEL DATA -->
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="py-2 px-4">No</th>
                            <th class="py-2 px-4">Nama Punggung</th>
                            <th class="py-2 px-4 text-center">Nomor</th>
                            <th class="py-2 px-4">Ukuran</th>
                            <th class="py-2 px-4">Lengan</th>
                            <th class="py-2 px-4">Kategori</th>   
                            <th class="py-2 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jerseys as $index => $jersey)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4">{{ $index + 1 }}</td>
                            <td class="py-2 px-4 font-bold">{{ $jersey->nama_punggung }}</td>
                            <td class="py-2 px-4 text-center font-mono">{{ $jersey->nomor_punggung }}</td>
                            <td class="py-2 px-4">{{ $jersey->ukuran }}</td>
                            <td class="py-2 px-4">{{ $jersey->lengan }}</td>
                            <td class="py-2 px-4">{{ $jersey->kategori }}</td>
                            <td class="py-2 px-4">
                                <!-- PENGECEKAN ROLE UNTUK TOMBOL HAPUS -->
                                @if(auth()->user()->role !== 'read')
                                <form action="{{ route('jerseys.destroy', ['team' => $team->id, 'jersey' => $jersey->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus baju ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-sm">Hapus</button>
                                </form>
                                @else
                                <span class="text-gray-400 text-xs italic">Akses ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-4 text-center text-gray-500 italic">Belum ada data baju di tim ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>