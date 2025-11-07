@extends('layouts.main_dashboard')

@section('content')
<div class="p-6 md:p-8">
    {{-- Header Halaman --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            {{-- Tombol kembali ke Dashboard --}}
            <a href="{{ route('tfp.index') }}" class="p-2 rounded-md hover:bg-gray-200" aria-label="Kembali">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 ml-4">Kesiapan Fasilitas TFP</h1> {{-- Judul diubah --}}
        </div>

        <a href="#" id="add-daily-btn-tfp" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
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
                            <a href="{{ route('tfp.daily.edit', $report) }}" class="font-medium text-indigo-600 hover:underline">Detail/Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr class="bg-white border-b">
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Data daily report TFP masih kosong. {{-- Teks diubah --}}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- >>> AWAL MODAL TAMBAH DAILY TFP <<< --}}
<div id="add-daily-modal-tfp"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center hidden z-50 p-4"
    aria-labelledby="modal-title-tfp-daily" role="dialog" aria-modal="true">

    <div class="relative mx-auto border w-full max-w-4xl shadow-lg rounded-xl bg-white">
        {{-- Form Tambah Report TFP --}}
        <form id="add-daily-form-tfp" action="{{ route('tfp.daily.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="kode" id="hidden_daily_kode_tfp">
            <input type="hidden" name="jadwal_dinas" id="hidden_jadwal_dinas_tfp">

            {{-- Header Modal --}}
            <div class="flex justify-between items-center border-b p-4 sticky top-0 bg-white rounded-t-xl z-10">
                <h3 id="modal-title-tfp-daily" class="text-xl font-semibold text-gray-900">REPORT TFP FORM</h3>
                <button type="button" id="close-daily-modal-btn-tfp" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" aria-label="Close modal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            {{-- Konten Modal --}}
            <div class="p-4 md:p-6 space-y-6 max-h-[70vh] overflow-y-auto">

                {{-- Baris ID, Tanggal, Jam, Dinas (2 Kolom) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 items-start">
                    {{-- Kolom Kiri: ID & Tanggal --}}
                    <div class="space-y-4">
                        <div>
                            <label for="daily_id_custom_tfp" class="block text-sm font-medium text-gray-700 mb-1">ID_REPORT*</label>
                            <input type="text" id="daily_id_custom_tfp" name="report_id_custom" readonly class="block w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm p-2 text-gray-500 cursor-not-allowed">
                        </div>
                        <div>
                            <label for="daily_tanggal_tfp" class="block text-sm font-medium text-gray-700 mb-1">TANGGAL*</label>
                            <input type="date" id="daily_tanggal_tfp" name="tanggal" required class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                        </div>
                    </div>
                    {{-- Kolom Kanan: Jam & Dinas --}}
                    <div class="space-y-4">
                        <div>
                            <label for="daily_jam_tfp" class="block text-sm font-medium text-gray-700 mb-1">JAM</label>
                            <input type="time" id="daily_jam_tfp" name="jam" required class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">DINAS*</label>
                            <div class="flex rounded-lg border border-gray-300 overflow-hidden">
                                <label class="flex-1 text-center cursor-pointer transition-colors has-[:checked]:bg-indigo-600 has-[:checked]:text-white">
                                    <input type="radio" name="dinas" value="Pagi" class="sr-only">
                                    <span class="block rounded-l-md px-3 py-2 text-gray-600">PAGI</span>
                                </label>
                                <label class="flex-1 text-center cursor-pointer border-l border-r border-gray-300 transition-colors has-[:checked]:bg-indigo-600 has-[:checked]:text-white">
                                    <input type="radio" name="dinas" value="Siang" class="sr-only">
                                    <span class="block px-3 py-2 text-gray-600">SIANG</span>
                                </label>
                                <label class="flex-1 text-center cursor-pointer transition-colors has-[:checked]:bg-indigo-600 has-[:checked]:text-white">
                                    <input type="radio" name="dinas" value="Malam" class="sr-only">
                                    <span class="block rounded-r-md px-3 py-2 text-gray-600">MALAM</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Peralatan TFP --}}
                <h4 class="text-lg font-semibold text-indigo-700 border-t pt-4 mt-6">Peralatan TFP</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                    @foreach ($equipmentList as $equipment)
                    @php $equipmentKey = Str::slug($equipment->name, '_'); @endphp
                    <div class="equipment-item-tfp">
                        <label for="status_{{ $equipmentKey }}_tfp" class="block text-sm font-medium text-gray-700">{{ $equipment->name }}</label>
                        <select id="status_{{ $equipmentKey }}_tfp" name="equipment_status[{{ $equipmentKey }}][status]" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 equipment-status-select-tfp">
                            <option value="NORMAL" selected>NORMAL</option>
                            <option value="GANGGUAN">GANGGUAN</option>
                            <option value="U/S">U/S</option>
                            <option value="SINGLE">SINGLE</option>
                        </select>
                        <div class="mt-2 hidden keterangan-wrapper-tfp">
                            <label for="keterangan_{{ $equipmentKey }}_tfp" class="block text-xs font-medium text-gray-500">KETERANGAN</label>
                            <textarea id="keterangan_{{ $equipmentKey }}_tfp" name="equipment_status[{{ $equipmentKey }}][keterangan]" rows="2" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"></textarea>
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
                            <label for="mantek_tfp" class="block text-sm font-medium text-gray-700">MANTEK</label>
                            <select id="mantek_tfp" name="mantek" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                                <option value="">Pilih Mantek</option>
                                @foreach ($userList as $id => $name) <option value="{{ $name }}">{{ $name }}</option> @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="daily_kode_tfp" class="block text-sm font-medium text-gray-700">KODE</label>
                            <input type="text" id="daily_kode_tfp" name="kode" readonly class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm p-2 text-gray-500 cursor-not-allowed">
                        </div>
                    </div>
                    {{-- Kanan: Acknowledge, Jadwal Dinas --}}
                    <div class="space-y-4">
                        <div>
                            <label for="acknowledge_tfp" class="block text-sm font-medium text-gray-700">ACKNOWLEDGE</label>
                            <select id="acknowledge_tfp" name="acknowledge" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                                <option value="">Pilih Acknowledge</option>
                                @foreach ($userList as $id => $name) <option value="{{ $name }}">{{ $name }}</option> @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="jadwal_dinas_tfp" class="block text-sm font-medium text-gray-700">JADWAL DINAS</label>
                            <textarea id="jadwal_dinas_tfp" name="jadwal_dinas" rows="4" readonly class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm p-2 text-gray-500 cursor-not-allowed">Memuat jadwal...</textarea>
                        </div>
                    </div>
                </div>

            </div>{{-- End Konten Scrollable --}}

            {{-- Footer Modal --}}
            <div class="flex justify-end items-center border-t p-4 space-x-2 sticky bottom-0 bg-white rounded-b-xl z-10">
                <button type="button" id="cancel-daily-modal-btn-tfp" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
{{-- >>> AKHIR MODAL TAMBAH DAILY TFP <<< --}}
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // === ELEMEN MODAL & FORM TFP ===
        const modal = document.getElementById('add-daily-modal-tfp');
        const openModalBtn = document.getElementById('add-daily-btn-tfp');
        const closeModalBtn = document.getElementById('close-daily-modal-btn-tfp');
        const cancelModalBtn = document.getElementById('cancel-daily-modal-btn-tfp');
        const addDailyForm = document.getElementById('add-daily-form-tfp');

        // === ELEMEN INPUT UTAMA TFP ===
        const tanggalInput = document.getElementById('daily_tanggal_tfp');
        const jamInput = document.getElementById('daily_jam_tfp');
        // Pastikan selector ini tepat menargetkan radio button di dalam modal TFP
        const dinasRadios = document.querySelectorAll('#add-daily-modal-tfp input[name="dinas"]');
        const dailyIdInput = document.getElementById('daily_id_custom_tfp');
        const dailyKodeInput = document.getElementById('daily_kode_tfp');
        const jadwalDinasTextarea = document.getElementById('jadwal_dinas_tfp');
        const equipmentStatusSelects = document.querySelectorAll('.equipment-status-select-tfp');

        // === ELEMEN INPUT HIDDEN TFP ===
        const hiddenKodeInput = document.getElementById('hidden_daily_kode_tfp');
        const hiddenJadwalInput = document.getElementById('hidden_jadwal_dinas_tfp');

        // === FUNGSI GENERATE ID & KODE (VERSI TFP) ===
        const generateIds = () => {
            if (!tanggalInput || !dailyIdInput || !dailyKodeInput || !hiddenKodeInput) return;

            const tanggal = tanggalInput.value; // Format: YYYY-MM-DD
            let dinasValue = 'SIANG'; // Default
            dinasRadios.forEach(radio => {
                if (radio.checked) dinasValue = radio.value.toUpperCase();
            });

            if (tanggal && dinasValue) {
                const dateParts = tanggal.split('-'); // [YYYY, MM, DD]
                const formattedDateForId = `${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`; // DD/MM/YYYY
                const formattedDateForKode = `${dateParts[2]}${dateParts[1]}${dateParts[0]}`; // DDMMYYYY

                dailyIdInput.value = `${dinasValue}-${formattedDateForId}-TFP`; // Ganti Suffix
                dailyKodeInput.value = `${dinasValue}${formattedDateForKode}TFPA`; // Ganti Suffix & Kode (sesuaikan TFPA jika perlu)
                hiddenKodeInput.value = dailyKodeInput.value; // Update hidden input
            } else {
                dailyIdInput.value = '';
                dailyKodeInput.value = '';
                hiddenKodeInput.value = '';
            }
        };

        // === FUNGSI FETCH JADWAL DINAS TFP VIA AJAX ===
        const fetchJadwal = async () => {
            if (!tanggalInput || !jadwalDinasTextarea || !hiddenJadwalInput) return;

            const tanggal = tanggalInput.value;
            let dinasValue = 'SIANG';
            dinasRadios.forEach(radio => {
                if (radio.checked) dinasValue = radio.value;
            });

            if (!tanggal || !dinasValue) {
                jadwalDinasTextarea.value = 'Pilih Tanggal dan Dinas terlebih dahulu.';
                hiddenJadwalInput.value = '';
                return;
            }

            jadwalDinasTextarea.value = 'Memuat jadwal...';
            hiddenJadwalInput.value = ''; // Kosongkan saat loading

            try {
                // Pastikan route name ini benar
                const response = await fetch(`{{ route('tfp.daily.getSchedule') }}?tanggal=${tanggal}&dinas=${dinasValue}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();

                if (data.success && data.jadwal) {
                    jadwalDinasTextarea.value = data.jadwal;
                    hiddenJadwalInput.value = data.jadwal; // Update hidden input
                } else {
                    jadwalDinasTextarea.value = data.message || 'Tidak ada jadwal TFP ditemukan.';
                    hiddenJadwalInput.value = '';
                }
            } catch (error) {
                console.error('Error fetching TFP schedule:', error);
                jadwalDinasTextarea.value = 'Gagal memuat jadwal TFP.';
                hiddenJadwalInput.value = '';
            }
        };

        // === FUNGSI BUKA MODAL ===
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

            // Reset status equipment ke NORMAL & sembunyikan keterangan
            equipmentStatusSelects.forEach(select => {
                select.value = 'NORMAL';
                const parentDiv = select.closest('.equipment-item-tfp');
                const keteranganWrapper = parentDiv.querySelector('.keterangan-wrapper-tfp');
                if (keteranganWrapper) {
                    keteranganWrapper.classList.add('hidden');
                    const textarea = keteranganWrapper.querySelector('textarea');
                    if (textarea) textarea.value = '';
                }
            });

            modal.classList.remove('hidden'); // Tampilkan modal
        };

        // === FUNGSI TUTUP MODAL ===
        const closeModal = () => {
            if (modal) modal.classList.add('hidden');
            if (addDailyForm) addDailyForm.reset(); // Reset form
            // Reset keterangan fields secara eksplisit
            document.querySelectorAll('.keterangan-wrapper-tfp').forEach(wrapper => {
                wrapper.classList.add('hidden');
                const textarea = wrapper.querySelector('textarea');
                if (textarea) textarea.value = '';
            });
            // Reset jadwal textarea
            if (jadwalDinasTextarea) jadwalDinasTextarea.value = 'Memuat jadwal...';
        };

        // === EVENT LISTENERS ===
        // Tombol Buka/Tutup Modal
        if (openModalBtn) openModalBtn.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        });
        if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
        if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeModal);
        // Klik di luar modal
        if (modal) modal.addEventListener('click', (event) => {
            if (event.target === modal) closeModal();
        });

        // Update ID, Kode, dan Jadwal saat Tanggal/Dinas berubah
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

        // Tampilkan/Sembunyikan Keterangan Equipment
        equipmentStatusSelects.forEach(select => {
            select.addEventListener('change', function() {
                const parentDiv = this.closest('.equipment-item-tfp');
                const keteranganWrapper = parentDiv.querySelector('.keterangan-wrapper-tfp');
                if (this.value !== 'NORMAL' && keteranganWrapper) {
                    keteranganWrapper.classList.remove('hidden');
                } else if (keteranganWrapper) {
                    keteranganWrapper.classList.add('hidden');
                    const textarea = keteranganWrapper.querySelector('textarea');
                    if (textarea) textarea.value = ''; // Kosongkan textarea saat disembunyikan
                }
            });
        });
    });
</script>
@endpush
