@extends('layouts.main_dashboard')

@section('content')

{{-- Ini adalah <div id="dashboard-content" ...> --}}
<div id="dashboard-content" class="content-panel p-6 md:p-8">
    <h3 class="text-2xl font-bold mb-6">Akses Cepat</h3>
    
    <div id="quick-links-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
        {{-- Kartu Data Personal --}}
        <div class="quick-link-card bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
            {{-- PERUBAHAN LINK: href="personal.html" -> route('profile.edit') --}}
            <a href="{{ route('profile.edit') }}" class="quick-link flex flex-col justify-between h-full" aria-label="Buka Data Personal">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-indigo-100 rounded-full"><svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></div>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800">Data Personal</h4>
                    <p class="text-sm text-gray-500 mt-1">Lihat dan kelola data personal</p>
                </div>
                <span class="mt-4 text-sm font-semibold text-indigo-600 hover:text-indigo-800">Masuk &rarr;</span>
            </a>
        </div>
        
        {{-- Kartu Harian CNSD --}}
        <div class="quick-link-card bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
             {{-- PERUBAHAN LINK: data-target="..." -> href="#" (ganti # kalo udah ada rutenya) --}}
            <a href="#" class="quick-link flex flex-col justify-between h-full" aria-label="Buka laporan Harian CNSD">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-100 rounded-full"><svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800">Harian CNSD</h4>
                    <p class="text-sm text-gray-500 mt-1">Kelola laporan harian CNSD</p>
                </div>
                <span class="mt-4 text-sm font-semibold text-indigo-600 hover:text-indigo-800">Masuk &rarr;</span>
            </a>
        </div>

        {{-- Kartu Harian TFP --}}
        <div class="quick-link-card bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
            {{-- PERUBAHAN LINK: data-target="..." -> href="#" --}}
            <a href="#" class="quick-link flex flex-col justify-between h-full" aria-label="Buka laporan Harian TFP">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-100 rounded-full"><svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg></div>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800">Harian TFP</h4>
                    <p class="text-sm text-gray-500 mt-1">Kelola laporan harian TFP</p>
                </div>
                <span class="mt-4 text-sm font-semibold text-indigo-600 hover:text-indigo-800">Masuk &rarr;</span>
            </a>
        </div>

        {{-- Kartu WO CNSD --}}
        <div class="quick-link-card bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
            {{-- PERUBAHAN LINK: href="...html" -> href="#" --}}
            <a href="#" class="quick-link flex flex-col justify-between h-full" aria-label="Lihat Work Order CNSD">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-yellow-100 rounded-full"><svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg></div>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800">WO CNSD</h4>
                    <p class="text-sm text-gray-500 mt-1">Kelola Work Order untuk CNSD</p>
                </div>
                <span class="mt-4 text-sm font-semibold text-indigo-600 hover:text-indigo-800">Masuk &rarr;</span>
            </a>
        </div>

        {{-- Kartu WO TFP --}}
        <div class="quick-link-card bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
            {{-- PERUBAHAN LINK: href="...html" -> href="#" --}}
            <a href="#" class="quick-link flex flex-col justify-between h-full" aria-label="Lihat Work Order TFP">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-purple-100 rounded-full"><svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path></svg></div>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800">WO TFP</h4>
                    <p class="text-sm text-gray-500 mt-1">Kelola Work Order untuk TFP</p>
                </div>
                <span class="mt-4 text-sm font-semibold text-indigo-600 hover:text-indigo-800">Masuk &rarr;</span>
            </a>
        </div>
        
        {{-- Kartu Metereding --}}
        <div class="quick-link-card bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
            {{-- PERUBAHAN LINK: data-target="..." -> href="#" --}}
            <a href="#" class="quick-link flex flex-col justify-between h-full" aria-label="Buka Metereding">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-red-100 rounded-full"><svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path></svg></div>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800">Metereding</h4>
                    <p class="text-sm text-gray-500 mt-1">Lihat dan kelola metereding</p>
                </div>
                <span class="mt-4 text-sm font-semibold text-indigo-600 hover:text-indigo-800">Masuk &rarr;</span>
            </a>
        </div>

    </div>
</div>
@endsection