@extends('layouts.main_dashboard')

@section('content')
<div class="p-6 md:p-8">
    {{-- Header Halaman --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            {{-- Tombol kembali ke Dashboard --}}
            <a href="{{ route('dashboard') }}" class="p-2 rounded-md hover:bg-gray-200" aria-label="Kembali">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 ml-4">Save Data TFP</h1> {{-- Judul diubah --}}
        </div>
        
        {{-- Tombol Tambah (+) Floating --}}
    </div>

    {{-- Daftar Data Tersimpan --}}
    <div class="space-y-6">
        {{-- Loop data '$groupedData' dari Controller --}}
        @forelse ($groupedData as $date => $items)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            {{-- Header Tanggal --}}
            <div class="px-6 py-3 bg-gray-50 border-b border-gray-200">
                <h2 class="text-sm font-semibold text-gray-600 uppercase">
                    {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM YYYY') }}
                </h2>
            </div>
            
            {{-- List Item per Tanggal --}}
            <ul class="divide-y divide-gray-200">
                @foreach ($items as $item)
                <li class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                    {{-- Nama File / Info Utama --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            @if($item->file_name)
                                {{ $item->file_name }}
                            @else
                                {{ $item->type }} - {{ $item->dinas ?? $item->nama_alat ?? 'Data' }} 
                                (Oleh: {{ $item->mantek ?? 'N/A' }})
                            @endif
                        </p>
                        {{-- Info tambahan --}}
                        <p class="text-sm text-gray-500">
                            Tipe: {{ $item->type }} 
                            @if($item->dinas) | Dinas: {{ $item->dinas }} @endif
                            @if($item->sampai) | Sampai: {{ $item->sampai->format('d M Y') }} @endif
                        </p>
                    </div>

                    {{-- Tombol Aksi di Kanan --}}
                    <div class="ml-4 flex-shrink-0 flex items-center space-x-3">
                         <span class="text-sm text-gray-500 hidden sm:inline">
                            {{ $item->mantek ?? ($item->nama_alat === 'ALL Equipment' ? 'Semua Alat' : ($item->print === 'YA' ? 'Teknisi B' : '-')) }}
                         </span>
                         
                         <button title="Copy Info" class="p-1 text-gray-400 hover:text-gray-600">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                         </button>
                         <button title="Edit" class="p-1 text-gray-400 hover:text-indigo-600">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                         </button>
                         <button title="Delete" class="p-1 text-gray-400 hover:text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                         </button>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        @empty
        <div class="text-center py-10 text-gray-500">
            Belum ada data TFP yang tersimpan. {{-- Teks diubah --}}
        </div>
        @endforelse
    </div>

    {{-- Tombol Tambah (+) Floating --}}
    <button class="fixed bottom-8 right-8 p-4 bg-indigo-600 text-white rounded-full shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
    </button>
</div>
@endsection