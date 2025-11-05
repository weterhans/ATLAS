@extends('layouts.main_dashboard')

@section('content')

<div class="p-6 md:p-8">
    {{-- Header Halaman --}}
    <div class="flex items-center mb-6">
        {{-- Tombol Kembali ke Dashboard --}}
        <a href="{{ route('meter_reading.index') }}" class="p-2 rounded-md hover:bg-gray-200" aria-label="Kembali ke Meter Reading">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800 ml-4">Meter Reading TFP</h1>
    </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">

            {{-- CATATAN PENTING: --}}
            {{-- 1. Semua path 'src' diubah dari '../img/' menjadi '{{ asset('img/...') }}' --}}
            {{-- 2. Semua 'href' yang mengarah ke '.html' diubah menjadi '#' untuk sementara --}}

            <a href="#" class="card bg-white p-4 rounded-xl shadow-md text-center">
                <img src="{{ asset('img/AOB.jpg') }}" alt="AOB Lt. Ground" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">AOB Lt. GROUND</h3>
            </a>
            <a href="#" class="card bg-white p-4 rounded-xl shadow-md text-center">
                <img src="{{ asset('img/AOB.jpg') }}" alt="AOB Lt. 1 & 2" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">AOB Lt. 1 & 2</h3>
            </a>
            <a href="#" class="card bg-white p-4 rounded-xl shadow-md text-center">
                <img src="{{ asset('img/Transmitter.jpg') }}" alt="Transmitter" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">TRANSMITTER</h3>
            </a>
            <a href="#" class="card bg-white p-4 rounded-xl shadow-md text-center">
                <img src="{{ asset('img/Localiz.jpg') }}" alt="Localizer" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">LOCALIZER</h3>
            </a>
            <a href="#" class="card bg-white p-4 rounded-xl shadow-md text-center">
                <img src="https://i.ibb.co/3W83sHq/undraw_Checklist_re_qw37_1.png" alt="MIDLE MARKER" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">MIDLE MARKER</h3>
            </a>
            <a href="#" class="card bg-white p-4 rounded-xl shadow-md text-center">
                <img src="{{ asset('img/DVOR.jpg') }}" alt="DVOR" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">DVOR</h3>
            </a>

            {{-- ... tambahkan sisa kartu dari performance_tfp.html dengan cara yang sama ... --}}

        </div>
    </div>
</div>
@endsection
