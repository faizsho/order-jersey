<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Tim: {{ $team->nama_team }}
            </h2>
            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-bold">
                Status: {{ strtoupper($team->status_order) }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(auth()->user()->role === 'super_admin')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Status Management</h3>
                <div class="flex flex-wrap gap-4 items-center">
                    <p class="text-sm text-gray-600">Ubah status pesanan ke:</p>
                    
                    <form action="{{ route('admin.teams.update-status', $team->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="draft">
                        <button type="submit" class="px-4 py-2 bg-gray-500 text-white rounded text-sm font-bold hover:bg-gray-700 {{ $team->status_order == 'draft' ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $team->status_order == 'draft' ? 'disabled' : '' }}>
                            DRAFT
                        </button>
                    </form>

                    <form action="{{ route('admin.teams.update-status', $team->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="produksi">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded text-sm font-bold hover:bg-blue-800 {{ $team->status_order == 'proses' ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $team->status_order == 'proses' ? 'disabled' : '' }}>
                            PROSES (Produksi)
                        </button>
                    </form>

                    <form action="{{ route('admin.teams.update-status', $team->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="selesai">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded text-sm font-bold hover:bg-green-800 {{ $team->status_order == 'selesai' ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $team->status_order == 'selesai' ? 'disabled' : '' }}>
                            SELESAI (Dikirim)
                        </button>
                    </form>
                </div>
            </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Desain Jersey</h3>
                
                <form action="{{ route('admin.teams.update-desain', $team->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="border rounded-lg p-4 bg-gray-50 text-center">
                            <p class="font-semibold text-gray-700 mb-2">Desain Player</p>
                            @if($team->desain_player)
                                <a href="{{ asset('storage/' . $team->desain_player) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $team->desain_player) }}" alt="Desain Player" class="max-h-64 mx-auto rounded shadow-sm hover:opacity-80 transition cursor-pointer mb-3">
                                </a>
                            @else
                                <p class="text-sm text-gray-500 italic py-10">Belum ada desain player yang diupload.</p>
                            @endif

                            @if(auth()->user()->role === 'super_admin')
                            <div class="mt-2 text-left bg-white p-2 rounded border">
                                <label class="block text-xs font-bold text-gray-600 mb-1">Ganti/Upload Desain Player:</label>
                                <input type="file" name="desain_player" accept="image/*" class="text-sm w-full file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            @endif
                        </div>

                        <div class="border rounded-lg p-4 bg-gray-50 text-center">
                            <p class="font-semibold text-gray-700 mb-2">Desain Kiper</p>
                            @if($team->desain_kiper)
                                <a href="{{ asset('storage/' . $team->desain_kiper) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $team->desain_kiper) }}" alt="Desain Kiper" class="max-h-64 mx-auto rounded shadow-sm hover:opacity-80 transition cursor-pointer mb-3">
                                </a>
                            @else
                                <p class="text-sm text-gray-500 italic py-10">Belum ada desain kiper yang diupload.</p>
                            @endif

                            @if(auth()->user()->role === 'super_admin')
                            <div class="mt-2 text-left bg-white p-2 rounded border">
                                <label class="block text-xs font-bold text-gray-600 mb-1">Ganti/Upload Desain Kiper:</label>
                                <input type="file" name="desain_kiper" accept="image/*" class="text-sm w-full file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            @endif
                        </div>

                    </div>

                    @if(auth()->user()->role === 'super_admin')
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white text-sm font-bold py-2 px-6 rounded shadow">
                            Simpan Revisi Desain
                        </button>
                    </div>
                    @endif
                </form>
            </div>
            @if($team->status_order === 'draft' && auth()->user()->role !== 'read')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Tambah Daftar Baju</h3>
                <form action="{{ route('jerseys.store', $team->id) }}" method="POST" class="flex flex-wrap gap-4 items-end">
                    @csrf
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
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                        </select>
                    </div>
                    <div class="w-32">
                        <label class="block text-sm text-gray-600 mb-1">Lengan</label>
                        <select name="lengan" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="Pendek">Pendek</option>
                            <option value="Panjang">Panjang</option>
                        </select>
                    </div>
                    <div class="w-32">
                        <label class="block text-sm text-gray-600 mb-1">Kategori</label>
                        <select name="kategori" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="Player">Player</option>
                            <option value="Kiper">Kiper</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded shadow">
                            + Tambah
                        </button>
                    </div>
                </form>
            </div>
            @else
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700 font-bold">Perhatian: Mode Read-Only / Pesanan Dikunci.</p>
                        <p class="text-sm text-yellow-700">Anda tidak dapat menambah, menghapus, atau mengupload data baju.</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 border-b pb-4 gap-4">
                    <h3 class="text-lg font-bold">Daftar Baju ({{ $team->jerseys->count() }} Pcs)</h3>
                    
                    <div class="flex flex-wrap items-center gap-2">
                        
                        <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2 mr-2">
                            <span class="text-sm text-gray-600 font-bold">Urutkan:</span>
                            <select name="sort" onchange="this.form.submit()" class="text-sm border-gray-300 rounded shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 cursor-pointer">
                                <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Input Terbaru</option>
                                <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama Punggung (A-Z)</option>
                                <option value="nomor" {{ request('sort') == 'nomor' ? 'selected' : '' }}>Nomor (Kecil ke Besar)</option>
                                <option value="ukuran" {{ request('sort') == 'ukuran' ? 'selected' : '' }}>Ukuran</option>
                            </select>
                        </form>

                        <a href="{{ route('jerseys.export', $team->id) }}" class="bg-green-600 hover:bg-green-800 text-white text-sm font-bold py-2 px-4 rounded shadow">
                            Download Excel
                        </a>

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
                                @if(auth()->user()->role !== 'read' && $team->status_order === 'draft')
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