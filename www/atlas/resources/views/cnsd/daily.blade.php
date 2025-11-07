@extends('layouts.main_dashboard')

@section('content')
<div class="p-6 md:p-8">
    {{-- Header Halaman --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            {{-- Tombol kembali ini sekarang ke Dashboard (atau ke cnsd.index jika ada) --}}
            <a href="{{ route('cnsd.index') }}" class="p-2 rounded-md hover:bg-gray-200" aria-label="Kembali">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 ml-4">Kesiapan Fasilitas CNSD</h1>
        </div>

        {{-- Tombol Tambah Baru --}}
        <a href="#" id="add-daily-btn" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            + Tambah Baru
        </a>
    </div>

    @if (session('success'))
    <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 text-sm shadow" role="alert">
        {{ session('success') }}
    </div>
    @endif

    {{-- Kontainer Tabel --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    {{-- Header tabel disesuaikan --}}
                    <tr>
                        <th scope="col" class="px-6 py-3">Tanggal</th>
                        <th scope="col" class="px-6 py-3">Mantek</th>
                        <th scope="col" class="px-6 py-3">Acknowledge</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop data '$reports' dari Controller --}}
                    @forelse ($reports as $report)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($report->tanggal)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">{{ $report->mantek }}</td>
                        <td class="px-6 py-4">{{ $report->acknowledge ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('cnsd.daily.edit', $report) }}" class="font-medium text-indigo-600 hover:underline">Detail/Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr class="bg-white border-b">
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Data daily report masih kosong.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


{{-- MODAL TAMBAH DAILY REPORT BARU --}}
<div id="add-daily-modal"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center hidden z-50 p-4">

    <div class="relative mx-auto border w-full max-w-4xl shadow-lg rounded-xl bg-white">
        {{-- Form Tambah Report --}}
        {{-- Nanti ganti action="#" dan method="post" --}}
        <form id="add-daily-form" action="{{ route('cnsd.daily.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="kode" id="hidden_daily_kode">
            <input type="hidden" name="jadwal_dinas" id="hidden_jadwal_dinas">

            {{-- Header Modal --}}
            <div class="flex justify-between items-center border-b p-4 sticky top-0 bg-white rounded-t-xl z-10">
                <h3 class="text-xl font-semibold text-gray-900">REPORT CNSD FORM</h3>
                <button type="button" id="close-daily-modal-btn" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            {{-- Konten Modal (scrollable) --}}
            <div class="p-4 md:p-6 space-y-6 max-h-[70vh] overflow-y-auto">

                {{-- Baris ID Daily, Tanggal, Jam, Dinas (2 Kolom) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 items-start"> {{-- Ubah jadi grid-cols-2 --}}

                    {{-- Kolom Kiri: ID & Tanggal --}}
                    <div class="space-y-4">
                        <div>
                            <label for="daily_id_custom" class="block text-sm font-medium text-gray-700 mb-1">ID_REPORT*</label>
                            <input type="text" id="daily_id_custom" name="report_id_custom" readonly
                                class="block w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm p-2 text-gray-500">
                        </div>
                        <div>
                            <label for="daily_tanggal" class="block text-sm font-medium text-gray-700 mb-1">TANGGAL*</label>
                            <input type="date" id="daily_tanggal" name="tanggal" required
                                class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                        </div>
                    </div>

                    {{-- Kolom Kanan: Jam & Dinas --}}
                    <div class="space-y-4">
                        <div>
                            <label for="daily_jam" class="block text-sm font-medium text-gray-700 mb-1">JAM</label>
                            <input type="time" id="daily_jam" name="jam" required
                                class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">DINAS*</label>
                            {{-- Kode untuk tombol radio Dinas biarkan sama --}}
                            <div class="flex rounded-lg border border-gray-300 overflow-hidden">
                                <label class="flex-1 text-center p-2 cursor-pointer transition-colors">
                                    <input type="radio" name="dinas" value="Pagi" class="sr-only peer/pagi">
                                    <span class="peer-checked/pagi:bg-indigo-600 peer-checked/pagi:text-white block rounded-l-md px-3 py-1 text-gray-600">PAGI</span>
                                </label>
                                <label class="flex-1 text-center p-2 cursor-pointer border-l border-r border-gray-300 transition-colors">
                                    <input type="radio" name="dinas" value="Siang" class="sr-only peer/siang">
                                    <span class="peer-checked/siang:bg-indigo-600 peer-checked/siang:text-white block px-3 py-1 text-gray-600">SIANG</span>
                                </label>
                                <label class="flex-1 text-center p-2 cursor-pointer transition-colors">
                                    <input type="radio" name="dinas" value="Malam" class="sr-only peer/malam">
                                    <span class="peer-checked/malam:bg-indigo-600 peer-checked/malam:text-white block rounded-r-md px-3 py-1 text-gray-600">MALAM</span>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Peralatan CNSD --}}
                <h4 class="text-lg font-semibold text-indigo-700 border-t pt-4 mt-6">Peralatan CNSD</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                    @foreach ($equipmentList as $equipment)
                    @php
                    // Buat key unik untuk nama input (ganti spasi/karakter aneh)
                    $equipmentKey = Str::slug($equipment->name, '_');
                    @endphp
                    <div class="equipment-item">
                        <label for="status_{{ $equipmentKey }}" class="block text-sm font-medium text-gray-700">{{ $equipment->name }}</label>
                        <select id="status_{{ $equipmentKey }}" name="equipment_status[{{ $equipmentKey }}][status]"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 equipment-status-select">
                            <option value="NORMAL" selected>NORMAL</option>
                            <option value="GANGGUAN">GANGGUAN</option>
                            <option value="U/S">U/S</option>
                            <option value="SINGLE">SINGLE</option>
                        </select>
                        {{-- Keterangan (muncul kondisional) --}}
                        <div class="mt-2 hidden keterangan-wrapper">
                            <label for="keterangan_{{ $equipmentKey }}" class="block text-xs font-medium text-gray-500">KETERANGAN</label>
                            <textarea id="keterangan_{{ $equipmentKey }}" name="equipment_status[{{ $equipmentKey }}][keterangan]"
                                rows="2" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"></textarea>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Administrasi --}}
                <h4 class="text-lg font-semibold text-indigo-700 border-t pt-4 mt-6">Administrasi</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 items-start">
                    {{-- Kiri: Mantek, Kode --}}
                    <div class="space-y-4">
                        <div>
                            <label for="mantek" class="block text-sm font-medium text-gray-700">MANTEK</label>
                            <select id="mantek" name="mantek" required
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                                <option value="">Pilih Mantek</option>
                                @foreach ($userList as $id => $name)
                                <option value="{{ $name }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="daily_kode" class="block text-sm font-medium text-gray-700">KODE</label>
                            <input type="text" id="daily_kode" name="kode" readonly
                                class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm p-2 text-gray-500">
                        </div>
                    </div>
                    {{-- Kanan: Acknowledge, Jadwal Dinas --}}
                    <div class="space-y-4">
                        <div>
                            <label for="acknowledge" class="block text-sm font-medium text-gray-700">ACKNOWLEDGE</label>
                            <select id="acknowledge" name="acknowledge"
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                                <option value="">Pilih Acknowledge</option>
                                @foreach ($userList as $id => $name)
                                <option value="{{ $name }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="jadwal_dinas" class="block text-sm font-medium text-gray-700">JADWAL DINAS</label>
                            <textarea id="jadwal_dinas" name="jadwal_dinas" rows="4" readonly
                                class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm p-2 text-gray-500">Memuat jadwal...</textarea>
                        </div>
                    </div>
                </div>

            </div>{{-- End Konten Scrollable --}}

            {{-- Footer Modal (Tombol Aksi) --}}
            <div class="flex justify-end items-center border-t p-4 space-x-2 sticky bottom-0 bg-white rounded-b-xl z-10">
                <button type="button" id="cancel-daily-modal-btn" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
@endsection {{-- Penutup @section('content') --}}

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('add-daily-modal');
        const openModalBtn = document.getElementById('add-daily-btn');
        const closeModalBtn = document.getElementById('close-daily-modal-btn');
        const cancelModalBtn = document.getElementById('cancel-daily-modal-btn');
        const addDailyForm = document.getElementById('add-daily-form');

        // Elemen form yg butuh di-update JS
        const tanggalInput = document.getElementById('daily_tanggal');
        const jamInput = document.getElementById('daily_jam');
        const dinasRadios = document.querySelectorAll('input[name="dinas"]');
        const dailyIdInput = document.getElementById('daily_id_custom');
        const dailyKodeInput = document.getElementById('daily_kode');
        const jadwalDinasTextarea = document.getElementById('jadwal_dinas');
        const equipmentStatusSelects = document.querySelectorAll('.equipment-status-select');

        // Fungsi Generate ID & Kode
        const generateIds = () => {
            if (!tanggalInput || !dailyIdInput || !dailyKodeInput) return;

            const hiddenKodeInput = document.getElementById('hidden_daily_kode');
            if (dailyKodeInput.value) {
                hiddenKodeInput.value = dailyKodeInput.value;
            } else {
                hiddenKodeInput.value = '';
            }

            const tanggal = tanggalInput.value; // YYYY-MM-DD
            let dinasValue = 'SIANG'; // Default
            dinasRadios.forEach(radio => {
                if (radio.checked) dinasValue = radio.value.toUpperCase();
            });

            if (tanggal && dinasValue) {
                const dateParts = tanggal.split('-'); // [YYYY, MM, DD]
                const formattedDateForId = `${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`; // DD/MM/YYYY
                const formattedDateForKode = `${dateParts[2]}${dateParts[1]}${dateParts[0]}`; // DDMMYYYY

                dailyIdInput.value = `${dinasValue}-${formattedDateForId}-CNSD`;
                dailyKodeInput.value = `${dinasValue}${formattedDateForKode}CNSA`; // Asumsi kode A
            } else {
                dailyIdInput.value = '';
                dailyKodeInput.value = '';
            }
        };

        // Fungsi Fetch Jadwal Dinas via AJAX
        const fetchJadwal = async () => {
            if (!tanggalInput || !jadwalDinasTextarea) return;
            const hiddenJadwalInput = document.getElementById('hidden_jadwal_dinas'); // Pindahin deklarasi ke sini

            const tanggal = tanggalInput.value;
            let dinasValue = 'SIANG';
            dinasRadios.forEach(radio => {
                if (radio.checked) dinasValue = radio.value;
            });

            if (!tanggal || !dinasValue) {
                jadwalDinasTextarea.value = 'Pilih Tanggal dan Dinas terlebih dahulu.';
                if (hiddenJadwalInput) hiddenJadwalInput.value = ''; // Update hidden input
                return;
            }

            jadwalDinasTextarea.value = 'Memuat jadwal...';
            if (hiddenJadwalInput) hiddenJadwalInput.value = ''; // Kosongkan saat loading

            try {
                const response = await fetch(`{{ route('cnsd.daily.getSchedule') }}?tanggal=${tanggal}&dinas=${dinasValue}`, {
                    /* ... headers ... */ });
                if (!response.ok) throw new Error('Network response was not ok');
                const data = await response.json();

                if (data.success && data.jadwal) {
                    jadwalDinasTextarea.value = data.jadwal;
                    if (hiddenJadwalInput) hiddenJadwalInput.value = data.jadwal; // <-- Update hidden di sini
                } else {
                    jadwalDinasTextarea.value = data.message || 'Tidak ada jadwal ditemukan.';
                    if (hiddenJadwalInput) hiddenJadwalInput.value = ''; // <-- Update hidden di sini
                }
            } catch (error) {
                console.error('Error fetching schedule:', error);
                jadwalDinasTextarea.value = 'Gagal memuat jadwal.';
                if (hiddenJadwalInput) hiddenJadwalInput.value = ''; // <-- Update hidden di sini
            }
        };

        // Fungsi Buka Modal
        const openModal = () => {
            if (!modal) return;

            // Set Tanggal & Jam Otomatis
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            if (tanggalInput) tanggalInput.value = `${year}-${month}-${day}`;
            if (jamInput) jamInput.value = `${hours}:${minutes}`;

            // Set Dinas Otomatis
            const currentHour = now.getHours();
            let currentDinas = 'Malam'; // Default
            if (currentHour >= 7 && currentHour < 13) currentDinas = 'Pagi';
            else if (currentHour >= 13 && currentHour < 19) currentDinas = 'Siang';

            dinasRadios.forEach(radio => {
                radio.checked = (radio.value === currentDinas);
            });

            // Generate ID & Kode awal
            generateIds();
            // Fetch Jadwal awal
            fetchJadwal();

            modal.classList.remove('hidden');
        };

        // Fungsi Tutup Modal
        const closeModal = () => {
            if (modal) modal.classList.add('hidden');
            if (addDailyForm) addDailyForm.reset(); // Reset form
            // Reset keterangan fields
            document.querySelectorAll('.keterangan-wrapper').forEach(wrapper => wrapper.classList.add('hidden'));
        };

        // Event Listener Tombol Modal
        if (openModalBtn) openModalBtn.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        });
        if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
        if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeModal);
        if (modal) modal.addEventListener('click', (event) => {
            if (event.target === modal) closeModal();
        });

        // Event Listener untuk Update ID, Kode, dan Jadwal
        if (tanggalInput) tanggalInput.addEventListener('change', () => {
            generateIds();
            fetchJadwal();
        });
        dinasRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                generateIds();
                fetchJadwal();
            });
        });

        // Event Listener untuk Keterangan Equipment
        equipmentStatusSelects.forEach(select => {
            select.addEventListener('change', function() {
                const parentDiv = this.closest('.equipment-item');
                const keteranganWrapper = parentDiv.querySelector('.keterangan-wrapper');
                if (this.value !== 'NORMAL' && keteranganWrapper) {
                    keteranganWrapper.classList.remove('hidden');
                } else if (keteranganWrapper) {
                    keteranganWrapper.classList.add('hidden');
                    // Kosongkan textarea saat disembunyikan
                    const textarea = keteranganWrapper.querySelector('textarea');
                    if (textarea) textarea.value = '';
                }
            });
        });
    });
</script>
@endpush
