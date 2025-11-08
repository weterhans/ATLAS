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
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-6">

        {{-- Kartu Jadwal --}}
        {{-- Nanti ganti href="#" dengan route('cnsd.jadwal') --}}
        <a href="{{ route('cnsd.jadwal') }}" class="card bg-white p-4 rounded-xl shadow-md text-center">
            <img src="{{ asset('img/Jadwal.png') }}" alt="Ilustrasi Jadwal TFP" class="rounded-md mb-4 w-full h-48 object-cover" onerror="this.onerror=null;this.src='https://placehold.co/600x400/A7F3D0/10B981?text=Jadwal';">
            <h3 class="font-semibold text-gray-800">JADWAL</h3>
        </a>

        {{-- Kartu Daily --}}
        {{-- Nanti ganti href="#" dengan route('cnsd.daily') --}}
        <a href="{{ route('cnsd.daily') }}" class="card bg-white p-4 rounded-xl shadow-md text-center">
            <img src="{{ asset('img/Daily.png') }}" alt="Ilustrasi Jadwal TFP" class="rounded-md mb-4 w-full h-48 object-cover" onerror="this.onerror=null;this.src='https://placehold.co/600x400/A7F3D0/10B981?text=Daily';">
            <h3 class="font-semibold text-gray-800">REPORT</h3>
        </a>

        {{-- Kartu Kegiatan --}}
        {{-- Nanti ganti href="#" dengan route('cnsd.kegiatan') --}}
        <a href="{{ route('cnsd.kegiatan') }}" class="card bg-white p-4 rounded-xl shadow-md text-center">
            <img src="{{ asset('img/Kegiatan CNSD.png') }}" alt="Ilustrasi Jadwal TFP" class="rounded-md mb-4 w-full h-48 object-cover" onerror="this.onerror=null;this.src='https://placehold.co/600x400/A7F3D0/10B981?text=Kegiatan';">
            <h3 class="font-semibold text-gray-800">KEGIATAN</h3>
        </a>

        {{-- Kartu Save --}}
        {{-- Nanti ganti href="#" dengan route('cnsd.save') --}}
        <a href="{{ route('cnsd.save_data') }}" class="card bg-white p-4 rounded-xl shadow-md text-center">
            <img src="{{ asset('img/Save Data.png') }}" alt="Ilustrasi Jadwal TFP" class="rounded-md mb-4 w-full h-48 object-cover" onerror="this.onerror=null;this.src='https://placehold.co/600x400/A7F3D0/10B981?text=Save';">
            <h3 class="font-semibold text-gray-800">DATA SAVE</h3>
        </a>

    </div>
</div>
@endsection
