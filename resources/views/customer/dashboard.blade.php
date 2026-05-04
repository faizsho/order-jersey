<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Pelanggan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold">Tim Saya</h3>
                    <a href="{{ route('teams.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-800">
                     @if(auth()->user()->role !== 'read')
                     <a href="{{ route('teams.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-800">+ Buat Tim Baru</a>
                     @endif
                    </a>
                </div>
                
                <ul class="divide-y divide-gray-200">
                    @forelse($myTeams as $tim)
                        <li class="py-4 flex justify-between items-center">
                            <div>
                               <a href="{{ route('teams.show', $tim->id) }}" class="font-bold text-blue-600 hover:underline">{{ $tim->nama_team }} &rarr;</a>)                                <p class="text-sm text-gray-500">Status: <span class="font-semibold text-blue-600">{{ strtoupper($tim->status_order) }}</span></p>
                            </div>
                        </li>
                    @empty
                        <li class="py-4 text-gray-500 italic">Belum ada pesanan. Yuk buat tim pertamamu!</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
