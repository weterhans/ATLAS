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
        <h1 class="text-2xl font-bold text-gray-800 ml-4">Meter Reading CNSD</h1>
    </div>


        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">

            {{-- CATATAN PENTING: --}}
            {{-- 1. Semua path 'src' diubah dari '../img/' menjadi '{{ asset('img/...') }}' --}}
            {{-- 2. Semua 'href' yang mengarah ke '.html' diubah menjadi '#' untuk sementara --}}

            <a href="{{ route('meter_reading.cnsd.kesiapan') }}" class="card bg-white p-4 rounded-xl shadow-md text-center">
                <img src="{{ asset('img/Kesiapan.png') }}" alt="Kesiapan Peralatan" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">Kesiapan Peralatan</h3>
            </a>
            <a href="#" class="card bg-white p-4 rounded-xl shadow-md text-center">
                <img src="{{ asset('img/ASMGCS.png') }}" alt="ASMGCS" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">ASMGCS</h3>
            </a>
            <a href="#" class="card bg-white p-4 rounded-xl shadow-md text-center">
                 <img src="{{ asset('img/DME.png') }}" alt="DME" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">DME</h3>
            </a>
            <a href="#" class="card bg-white p-4 rounded-xl shadow-md text-center">
                 <img src="https://i.ibb.co/JqjQRyQ/undraw_Save_to_bookmarks_re_8ajf_1.png" alt="T-DME" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">T-DME</h3>
            </a>
            <a href="#" class="card bg-white p-4 rounded-xl shadow-md text-center">
                 <img src="{{ asset('img/Radar.jpg') }}" alt="RADAR" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">RADAR</h3>
            </a>
            <a href="#" class="card bg-white p-4 rounded-xl shadow-md text-center">
                 <img src="https://i.ibb.co/yqg0NTz/undraw_Wireframing_re_qawp_1.png" alt="RECORDER" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">RECORDER</h3>
            </a>
            <a href="#" class="card bg-white p-4 rounded-xl shadow-md text-center">
                 <img src="https://i.ibb.co/yqg0NTz/undraw_Wireframing_re_qawp_1.png" alt="VCCS FREQ" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">VCCS FREQ</h3>
            </a>
            <a href="#" class="card bg-white p-4 rounded-xl shadow-md text-center">
                 <img src="https://i.ibb.co/yqg0NTz/undraw_Wireframing_re_qawp_1.png" alt="VCCS LES" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">VCCS LES</h3>
            </a>
            <a href="#" class="card bg-white p-4 rounded-xl shadow-md text-center">
                 <img src="{{ asset('img/ATC SYS.jpg') }}" alt="ATC SYSTEM" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">ATC SYSTEM</h3>
            </a>
            <a href="#" class="card bg-white p-4 rounded-xl shadow-md text-center">
                 <img src="{{ asset('img/Transmitter.jpg') }}" alt="TRANSMITTER" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">TRANSMITTER</h3>
            </a>
            <a href="#" class="card bg-white p-4 rounded-xl shadow-md text-center">
                 <img src="https://i.ibb.co/yqg0NTz/undraw_Wireframing_re_qawp_1.png" alt="RECEIVER" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">RECEIVER</h3>
            </a>
            <a href="#" class="card bg-white p-4 rounded-xl shadow-md text-center">
                 <img src="https://i.ibb.co/yqg0NTz/undraw_Wireframing_re_qawp_1.png" alt="AMSC" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">AMSC</h3>
            </a>
            <a href="{{ route('meter_reading.cnsd.atis') }}" class="card bg-white p-4 rounded-xl shadow-md text-center">
                 <img src="https://i.ibb.co/yqg0NTz/undraw_Wireframing_re_qawp_1.png" alt="ATIS" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">ATIS</h3>
            </a>
            <a href="#" class="card bg-white p-4 rounded-xl shadow-md text-center">
                 <img src="{{ asset('img/MM.jpg') }}" alt="MIDDLE MARKER" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">MIDDLE MARKER</h3>
            </a>
            <a href="#" class="card bg-white p-4 rounded-xl shadow-md text-center">
                 <img src="{{ asset('img/GP.png') }}" alt="GLIDE PATH NORMACH" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-semibold text-gray-800">GLIDE PATH NORMACH</h3>
            </a>
            {{-- ... tambahkan sisa kartu dari performance_cnsd.html dengan cara yang sama ... --}}

        </div>
    </div>

</div>
@endsection
