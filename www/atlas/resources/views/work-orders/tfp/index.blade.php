@extends('layouts.main_dashboard')

@section('content')
<div class="p-6 md:p-8">

    {{-- Header Halaman --}}
    <div class="flex items-center justify-between pb-6 border-b border-gray-200">
        <div class="flex items-center gap-4">
            <a href="{{ url()->previous() }}" class="text-gray-600 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Work Orders TFP</h1>
        </div>
        <div>
            <img src="www\atlas\public\img\airnav_logo.png" alt="Logo Airnav" class="h-10">
        </div>
    </div>
    {{-- Tombol Aksi --}}
    <div class="mt-6 flex items-center gap-4">
        <a href="#" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
            Buat Work Order Baru
        </a>
        <a href="#" class="px-5 py-2.5 text-sm font-medium text-white bg-gray-800 rounded-lg shadow-md hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300">
            Lihat Daftar WO
        </a>
    </div>

    {{-- Daftar Work Order Card --}}
    <div class="mt-8 bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Daftar Work Order</h2>

            {{-- Tabel Work Order --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">No. WO</th>
                            <th scope="col" class="px-6 py-3">Tanggal</th>
                            <th scope="col" class="px-6 py-3">Deskripsi</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($workOrders as $wo)
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $wo->wo_number }}</td>
                            <td class="px-6 py-4">{{ $wo->tanggal }}</td>
                            <td class="px-6 py-4">{{ $wo->deskripsi }}</td>
                            <td class="px-6 py-4">{{ $wo->status }}</td>
                            <td class="px-6 py-4 flex items-center gap-4">
                                <a href="#" class="font-medium text-blue-600 hover:underline">Edit</a>
                                <a href="#" class="font-medium text-red-600 hover:underline">Hapus</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data Work Order.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
