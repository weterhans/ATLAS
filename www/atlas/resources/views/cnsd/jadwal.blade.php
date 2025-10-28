@extends('layouts.main_dashboard')

@section('content')
<div class="p-6 md:p-8">
    {{-- Header Halaman --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            {{-- Tombol kembali ini sekarang ke Dashboard --}}
            <a href="{{ route('cnsd.index') }}" class="p-2 rounded-md hover:bg-gray-200" aria-label="Kembali">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 ml-4">Jadwal Dinas CNSD</h1>
        </div>

        {{-- Tombol Tambah Baru --}}
        <a href="#" id="add-schedule-btn" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            + Tambah Baru
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 text-sm shadow animate-pulse-once" role="alert">
            {{ session('success') }}
        </div>
        {{-- 'animate-pulse-once' adalah contoh animasi sederhana, bisa dihapus/diganti --}}
        <style>
            @keyframes pulse-once { 0%, 100% { opacity: 1; } 50% { opacity: .7; } }
            .animate-pulse-once { animation: pulse-once 1.5s ease-in-out; }
        </style>
    @endif
    
    {{-- Kontainer Tabel --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID Jadwal</th>
                        <th scope="col" class="px-6 py-3">Tanggal</th>
                        <th scope="col" class="px-6 py-3">Hari</th>
                        <th scope="col" class="px-6 py-3">Dinas</th>
                        <th scope="col" class="px-6 py-3">Teknisi 1</th>
                        <th scope="col" class="px-6 py-3">Teknisi 2</th>
                        <th scope="col" class="px-6 py-3">Teknisi 3</th>
                        <th scope="col" class="px-6 py-3">Teknisi 4</th>
                        <th scope="col" class="px-6 py-3">Teknisi 5</th>
                        <th scope="col" class="px-6 py-3">Teknisi 6</th>
                        <th scope="col" class="px-6 py-3">Kode</th>
                        <th scope="col" class="px-6 py-3">Grup</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Kita loop data '$schedules' dari Controller --}}
                    @forelse ($schedules as $schedule)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $schedule->schedule_id_custom }}
                        </th>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($schedule->tanggal)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">{{ $schedule->hari }}</td>
                        <td class="px-6 py-4">{{ $schedule->dinas }}</td>
                        <td class="px-6 py-4">{{ $schedule->teknisi_1 ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $schedule->teknisi_2 ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $schedule->teknisi_3 ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $schedule->teknisi_4 ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $schedule->teknisi_5 ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $schedule->teknisi_6 ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $schedule->kode }}</td>
                        <td class="px-6 py-4">{{ $schedule->grup }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('cnsd.jadwal.edit', $schedule) }}" class="font-medium text-indigo-600 hover:underline">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr class="bg-white border-b">
                        <td colspan="13" class="px-6 py-4 text-center text-gray-500">
                            Data jadwal masih kosong.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

{{-- MODAL TAMBAH JADWAL BARU --}}
<div id="add-schedule-modal"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center hidden z-50 px-4">
    {{-- 'hidden' -> modal disembunyikan awalnya --}}
    {{-- 'z-50' -> biar modalnya di paling depan --}}

    <div class="relative mx-auto p-6 border w-full max-w-lg shadow-lg rounded-xl bg-white">
        {{-- Header Modal --}}
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 class="text-xl font-semibold text-gray-900">Tambah Jadwal Baru</h3>
            <button id="close-modal-btn" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>

        {{-- Form Tambah Jadwal --}}
        {{-- Nanti ganti action="#" dan method="post" --}}
        <form id="add-schedule-form" action="{{ route('cnsd.jadwal.store') }}" method="POST" class="space-y-4">
            @csrf {{-- Jangan lupa token CSRF --}}

            {{-- ID Jadwal (Readonly / Dibuat otomatis?) --}}
            <div>
                <label for="schedule_id_custom" class="block text-sm font-medium text-gray-700">ID Jadwal</label>
                <input type="text" id="schedule_id_custom" name="schedule_id_custom"
                    value="SIANG-27/10/2025-CNSD" {{-- Ini contoh, nanti diisi otomatis JS/backend --}}
                    readonly
                    class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm p-2 text-gray-500">
            </div>

            {{-- Tanggal --}}
            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" required
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
            </div>

            {{-- Dinas (Select) --}}
            <div>
                <label for="dinas" class="block text-sm font-medium text-gray-700">Dinas</label>
                <select id="dinas" name="dinas" required
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                    <option value="">Pilih Dinas</option>
                    <option value="Pagi">Pagi</option>
                    <option value="Siang">Siang</option>
                    <option value="Malam">Malam</option>
                </select>
            </div>

            {{-- Teknisi 1-6 (Select) --}}
            @for ($i = 1; $i <= 6; $i++)
                <div>
                <label for="teknisi_{{ $i }}" class="block text-sm font-medium text-gray-700">
                    Pilih Teknisi {{ $i }} {{ $i > 3 ? '(Opsional)' : '' }}
                </label>
                <select id="teknisi_{{ $i }}" name="teknisi_{{ $i }}"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"
                    {{ $i <= 3 ? 'required' : '' }}> {{-- Wajib isi untuk 1-3 --}}
                    <option value="">-- Pilih Teknisi --</option>
                    {{-- Loop list teknisi dari Controller --}}
                    @foreach ($teknisiList as $namaTeknisi)
                    <option value="{{ $namaTeknisi }}">{{ $namaTeknisi }}</option>
                    @endforeach
                </select>
    </div>
    @endfor

    {{-- Tombol Aksi Modal --}}
    <div class="flex justify-end items-center border-t pt-4 mt-6 space-x-2">
        <button type="button" id="cancel-modal-btn" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
            Batal
        </button>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
            Simpan Jadwal
        </button>
    </div>
    </form>
</div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('add-schedule-modal');
        const openModalBtn = document.getElementById('add-schedule-btn');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const cancelModalBtn = document.getElementById('cancel-modal-btn');
        const addScheduleForm = document.getElementById('add-schedule-form');

        // Fungsi buka modal
        const openModal = () => {
            if (!modal) return;

            // --- TAMBAHAN UNTUK TANGGAL & DINAS OTOMATIS ---
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Bulan mulai dari 0
            const day = String(today.getDate()).padStart(2, '0');
            const currentHour = today.getHours();

            // Set Tanggal Otomatis
            const tanggalInput = document.getElementById('tanggal');
            if (tanggalInput) {
                tanggalInput.value = `${year}-${month}-${day}`;
            }

            // Set Dinas Otomatis
            const dinasSelect = document.getElementById('dinas');
            let currentDinas = '';
            if (currentHour >= 7 && currentHour < 13) {
                currentDinas = 'Pagi';
            } else if (currentHour >= 13 && currentHour < 19) {
                currentDinas = 'Siang';
            } else {
                // Malam (19:00 - 06:59)
                currentDinas = 'Malam';
            }
            if (dinasSelect) {
                dinasSelect.value = currentDinas;
            }
            // Panggil fungsi generate ID setelah set tanggal & dinas
            generateId(); // <-- Panggil ini biar ID ikut ke-generate

            modal.classList.remove('hidden'); // Tampilkan modal
        };

        // Fungsi tutup modal
        const closeModal = () => {
            if (modal) modal.classList.add('hidden');
            if (addScheduleForm) addScheduleForm.reset(); // Reset form kalo ditutup
        };

        // Event listener
        if (openModalBtn) openModalBtn.addEventListener('click', (e) => {
            e.preventDefault(); // Biar link '#' tidak jalan
            openModal();
        });
        if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
        if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeModal);

        // Tutup modal kalo klik di luar area modal
        if (modal) {
            modal.addEventListener('click', (event) => {
                // Cek apakah kliknya di background gelap (modal itu sendiri)
                if (event.target === modal) {
                    closeModal();
                }
            });
        }

        // TODO: Nanti tambahin logic buat generate ID Jadwal otomatis
        // berdasarkan Tanggal & Dinas yang dipilih
        const tanggalInput = document.getElementById('tanggal');
        const dinasSelect = document.getElementById('dinas');
        const scheduleIdInput = document.getElementById('schedule_id_custom');

        const generateId = () => {
            if (!tanggalInput || !dinasSelect || !scheduleIdInput) return;

            const tanggal = tanggalInput.value; // format YYYY-MM-DD
            const dinas = dinasSelect.value.toUpperCase(); // Jaga2 kalo value bukan kapital

            if (tanggal && dinas) {
                // Ubah YYYY-MM-DD jadi DD/MM/YYYY
                const dateParts = tanggal.split('-');
                const formattedDate = `${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`;
                scheduleIdInput.value = `${dinas}-${formattedDate}-CNSD`;
            } else {
                scheduleIdInput.value = ''; // Kosongkan kalo belum lengkap
            }
        };

        if (tanggalInput) tanggalInput.addEventListener('change', generateId);
        if (dinasSelect) dinasSelect.addEventListener('change', generateId);

    });
</script>
@endpush