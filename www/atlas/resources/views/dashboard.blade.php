@extends('layouts.main_dashboard')

@section('content')

{{-- Ini adalah <div id="dashboard-content" ...> --}}
<div id="dashboard-content" class="content-panel p-6 md:p-8">
    <h3 class="text-2xl font-bold mb-6">Akses Cepat</h3>

    <div id="quick-links-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Kartu Data Personal --}}
        <div class="quick-link-card bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
            {{-- PERUBAHAN LINK: href="personal.html" -> route('profile.edit') --}}
            <a href="{{ route('personal.index') }}" class="quick-link flex flex-col justify-between h-full" aria-label="Buka Data Personal">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-indigo-100 rounded-full"><svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg></div>
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
            <a href="{{ route('cnsd.index') }}" class="quick-link flex flex-col justify-between h-full" aria-label="Buka laporan Harian CNSD">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-100 rounded-full"><svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg></div>
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
            <a href="{{ route('tfp.index') }}" class="quick-link flex flex-col justify-between h-full" aria-label="Buka laporan Harian TFP">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-100 rounded-full"><svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg></div>
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
                        <div class="p-3 bg-yellow-100 rounded-full"><svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg></div>
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
                        <div class="p-3 bg-purple-100 rounded-full"><svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path>
                            </svg></div>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800">WO TFP</h4>
                    <p class="text-sm text-gray-500 mt-1">Kelola Work Order untuk TFP</p>
                </div>
                <span class="mt-4 text-sm font-semibold text-indigo-600 hover:text-indigo-800">Masuk &rarr;</span>
            </a>
        </div>

        {{-- Kartu Metereding --}}
        <div class="quick-link-card bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300">
            {{-- PERUBAHAN LINK: Ganti href="#" dengan route('meter_reading.index') --}}
            <a href="{{ route('meter_reading.index') }}" class="quick-link flex flex-col justify-between h-full" aria-label="Buka Meter Reading">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-red-100 rounded-full"><svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path>
                            </svg></div>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800">Meter Raeding</h4>
                    <p class="text-sm text-gray-500 mt-1">Lihat dan kelola meter reading</p>
                </div>
                <span class="mt-4 text-sm font-semibold text-indigo-600 hover:text-indigo-800">Masuk &rarr;</span>
            </a>
        </div>
    </div>

    <div class="mt-12">
        <div class="flex justify-between items-start mb-6">
            <h3 class="text-2xl font-bold">Jadwal Dinas Hari Ini</h3>
            <div class="flex flex-col items-end space-y-2">
                <h4 id="schedule-date" class="text-lg font-semibold text-gray-600">Memuat tanggal...</h4>
                {{-- Tombol ini sekarang mengarah ke Google Sheet --}}
                <a href="https://docs.google.com/spreadsheets/d/1MJk_RV_ufGHr11bKyMQMxxDlQqv_6GhpZ9rPYSkELy8/edit?usp=sharing" target="_blank" class="flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                    </svg>
                    Edit Jadwal
                </a>
            </div>
        </div>

        <div class="mb-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <h4 class="py-4 px-6 text-xl font-semibold text-center text-gray-700 bg-gray-50 border-b">Manager Teknik</h4>
                <table class="w-full">
                    <tbody id="manager-table-body" class="divide-y divide-gray-200">
                        </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <h4 class="py-4 px-6 text-xl font-semibold text-center text-gray-700 bg-gray-50 border-b">CNS</h4>
                    <table class="w-full">
                        <tbody id="cns-table-body" class="divide-y divide-gray-200">
                           </tbody>
                    </table>
                </div>
            </div>
            <div>
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <h4 class="py-4 px-6 text-xl font-semibold text-center text-gray-700 bg-gray-50 border-b">TFP</h4>
                    <table class="w-full">
                        <tbody id="tfp-table-body" class="divide-y divide-gray-200">
                           </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Fungsi untuk menampilkan tanggal hari ini
        function displayCurrentDate() {
            const dateElement = document.getElementById('schedule-date');
            const today = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            dateElement.textContent = today.toLocaleDateString('id-ID', options);
        }

        // Fungsi untuk mengisi tabel dengan data
        function populateTable(tbodyId, data) {
            const tbody = document.getElementById(tbodyId);
            tbody.innerHTML = ''; // Kosongkan tabel sebelum diisi

            if (data.length === 0) {
                tbody.innerHTML = '<tr><td class="p-4 text-center text-gray-500">Tidak ada jadwal</td></tr>';
                return;
            }

            data.forEach(person => {
                const row = `
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-gray-800">${person.name}</td>
                        <td class="p-4 text-right text-gray-600 font-medium">${person.shift}</td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }

        // Fungsi utama untuk mengambil data dari API
        async function fetchSchedule() {
            try {
                // Ganti '/api/schedule' jika route Anda berbeda
                const response = await fetch('/api/schedule');
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();

                // Isi setiap tabel dengan data yang sesuai
                populateTable('manager-table-body', data.manager);
                populateTable('cns-table-body', data.cns);
                populateTable('tfp-table-body', data.tfp);

            } catch (error) {
                console.error('Gagal mengambil data jadwal:', error);
                // Tampilkan pesan error di semua tabel
                document.getElementById('manager-table-body').innerHTML = '<tr><td class="p-4 text-center text-red-500">Gagal memuat data</td></tr>';
                document.getElementById('cns-table-body').innerHTML = '<tr><td class="p-4 text-center text-red-500">Gagal memuat data</td></tr>';
                document.getElementById('tfp-table-body').innerHTML = '<tr><td class="p-4 text-center text-red-500">Gagal memuat data</td></tr>';
            }
        }

        // Panggil fungsi-fungsi
        displayCurrentDate();
        fetchSchedule();
    });
</script>

@endsection
