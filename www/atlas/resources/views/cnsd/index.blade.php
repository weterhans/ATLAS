@extends('layouts.main_dashboard')

@section('content')

<div class="p-6 md:p-8">
    {{-- Header Halaman --}}
    <div class="flex items-center mb-6">
        {{-- Tombol Kembali ke Dashboard --}}
        <a href="{{ route('dashboard') }}" class="p-2 rounded-md hover:bg-gray-200" aria-label="Kembali ke Dashboard">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800 ml-4">Harian CNSD</h1>
    </div>

    {{-- Konten Grid 4 Kartu --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        {{-- Kartu Jadwal --}}
        {{-- Nanti ganti href="#" dengan route('cnsd.jadwal') --}}
        <a href="{{ route('cnsd.jadwal') }}" class="block bg-white p-4 rounded-lg shadow hover:shadow-lg transition-shadow text-center">
            <div class="h-40 bg-gray-200 rounded-md flex items-center justify-center mb-4">
                <span class="text-4xl font-bold text-gray-700">Jadwal</span>
            </div>
            <h3 class="font-semibold text-gray-800">JADWAL CNSD</h3>
        </a>

        {{-- Kartu Daily --}}
        {{-- Nanti ganti href="#" dengan route('cnsd.daily') --}}
        <a href="{{ route('cnsd.daily') }}" class="block bg-white p-4 rounded-lg shadow hover:shadow-lg transition-shadow text-center">
            <div class="h-40 bg-gray-200 rounded-md flex items-center justify-center mb-4">
                <span class="text-4xl font-bold text-gray-700">Daily</span>
            </div>
            <h3 class="font-semibold text-gray-800">DAILY CNSD</h3>
        </a>

        {{-- Kartu Kegiatan --}}
        {{-- Nanti ganti href="#" dengan route('cnsd.kegiatan') --}}
        <a href="{{ route('cnsd.kegiatan') }}" class="block bg-white p-4 rounded-lg shadow hover:shadow-lg transition-shadow text-center">
            <div class="h-40 bg-gray-200 rounded-md flex items-center justify-center mb-4">
                <span class="text-4xl font-bold text-gray-700">Kegiatan</span>
            </div>
            <h3 class="font-semibold text-gray-800">KEGIATAN CNSD</h3>
        </a>

        {{-- Kartu Save --}}
        {{-- Nanti ganti href="#" dengan route('cnsd.save') --}}
        <a href="{{ route('cnsd.save_data') }}" class="block bg-white p-4 rounded-lg shadow hover:shadow-lg transition-shadow text-center">
            <div class="h-40 bg-gray-200 rounded-md flex items-center justify-center mb-4">
                <span class="text-4xl font-bold text-gray-700">Save</span>
            </div>
            <h3 class="font-semibold text-gray-800">SAVE DATA CNSD</h3>
        </a>

    </div>
</div>
@endsection