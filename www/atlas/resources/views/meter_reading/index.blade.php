@extends('layouts.main_dashboard')

@section('content')

{{-- Header --}}
<div class="p-6 md:p-8">
    {{-- Header Halaman --}}
    <div class="flex items-center mb-6">
        {{-- Tombol Kembali ke Dashboard --}}
        <a href="{{ route('dashboard') }}" class="p-2 rounded-md hover:bg-gray-200" aria-label="Kembali ke Dashboard">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800 ml-4">Meter Reading</h1>
    </div>

    {{-- Grid untuk 2 Kartu --}}

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        {{-- Kartu METER READING CNSD --}}
        <a href="{{ route('meter_reading.cnsd') }}" class="card bg-white p-4 rounded-xl shadow-md text-center transition-transform duration-300 ease-in-out hover:transform hover:-translate-y-1 hover:shadow-lg">
            {{-- Ganti 'img/meter_cnsd.jpg' dengan path gambar Anda dari image_5e48cd.jpg --}}
            <img src="{{ asset('img/meter_cnsd.jpg') }}" alt="Meter Reading CNSD" class="rounded-lg mb-4 w-full h-48 object-cover">
            <h3 class="font-semibold text-gray-800">METER READING CNSD</h3>
        </a>

        {{-- Kartu METER READING TFP --}}
        <a href="{{ route('meter_reading.tfp') }}" class="card bg-white p-4 rounded-xl shadow-md text-center transition-transform duration-300 ease-in-out hover:transform hover:-translate-y-1 hover:shadow-lg">
            {{-- Ganti 'img/meter_tfp.jpg' dengan path gambar Anda dari image_5e48cd.jpg --}}
            <img src="{{ asset('img/meter_tfp.jpg') }}" alt="Meter Reading TFP" class="rounded-lg mb-4 w-full h-48 object-cover">
            <h3 class="font-semibold text-gray-800">METER READING TFP</h3>
        </a>

    </div>
</div>
@endsection
