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
            <h1 class="text-2xl font-bold text-gray-800 ml-4">Jadwal Dinas TFP</h1> {{-- Judul diubah --}}
        </div>

        <a href="#" id="add-schedule-btn-tfp" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
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
                    {{-- Loop data '$schedules' dari Controller --}}
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
                            <a href="{{ route('tfp.jadwal.edit', $schedule) }}" class="font-medium text-indigo-600 hover:underline">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr class="bg-white border-b">
                        <td colspan="13" class="px-6 py-4 text-center text-gray-500">
                            Data jadwal TFP masih kosong. {{-- Teks diubah --}}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- >>> AWAL MODAL TAMBAH JADWAL TFP <<< --}}
<div id="add-schedule-modal-tfp"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center hidden z-50 px-4"
    aria-labelledby="modal-title-tfp-jadwal" role="dialog" aria-modal="true">

    <div class="relative mx-auto p-6 border w-full max-w-lg shadow-lg rounded-xl bg-white">
        {{-- Header Modal --}}
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 id="modal-title-tfp-jadwal" class="text-xl font-semibold text-gray-900">Tambah Jadwal Baru (TFP)</h3>
            <button id="close-modal-btn-tfp" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" aria-label="Close modal">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>

        {{-- Form Tambah Jadwal --}}
        <form id="add-schedule-form-tfp" action="{{ route('tfp.jadwal.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- ID Jadwal --}}
            <div>
                <label for="schedule_id_custom_tfp" class="block text-sm font-medium text-gray-700">ID Jadwal</label>
                <input type="text" id="schedule_id_custom_tfp" name="schedule_id_custom" readonly
                    class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm p-2 text-gray-500 cursor-not-allowed">
            </div>

            {{-- Tanggal --}}
            <div>
                <label for="tanggal_tfp" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" id="tanggal_tfp" name="tanggal" required
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
            </div>

            {{-- Dinas --}}
            <div>
                <label for="dinas_tfp" class="block text-sm font-medium text-gray-700">Dinas</label>
                <select id="dinas_tfp" name="dinas" required
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                    <option value="">Pilih Dinas</option>
                    <option value="Pagi">Pagi</option>
                    <option value="Siang">Siang</option>
                    <option value="Malam">Malam</option>
                </select>
            </div>

            {{-- Teknisi 1-6 --}}
            @for ($i = 1; $i <= 6; $i++)
                <div>
                <label for="teknisi_{{ $i }}_tfp" class="block text-sm font-medium text-gray-700">
                    Pilih Teknisi {{ $i }} {{ $i > 3 ? '(Opsional)' : '' }}
                </label>
                <select id="teknisi_{{ $i }}_tfp" name="teknisi_{{ $i }}"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"
                    {{ $i <= 3 ? 'required' : '' }}>
                    <option value="">-- Pilih Teknisi --</option>
                    {{-- Loop $teknisiList dari Controller --}}
                    @foreach ($teknisiList as $namaTeknisi)
                    <option value="{{ $namaTeknisi }}">{{ $namaTeknisi }}</option>
                    @endforeach
                </select>
    </div>
    @endfor

    {{-- Tombol Aksi Modal --}}
    <div class="flex justify-end items-center border-t pt-4 mt-6 space-x-2">
        <button type="button" id="cancel-modal-btn-tfp" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
            Batal
        </button>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Simpan Jadwal
        </button>
    </div>
    </form>
</div>
</div>
{{-- >>> AKHIR MODAL TAMBAH JADWAL TFP <<< --}}
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ganti semua ID selector dengan suffix '-tfp'
        const modal = document.getElementById('add-schedule-modal-tfp');
        const openModalBtn = document.getElementById('add-schedule-btn-tfp');
        const closeModalBtn = document.getElementById('close-modal-btn-tfp');
        const cancelModalBtn = document.getElementById('cancel-modal-btn-tfp');
        const addScheduleForm = document.getElementById('add-schedule-form-tfp');
        const tanggalInput = document.getElementById('tanggal_tfp');
        const dinasSelect = document.getElementById('dinas_tfp');
        const scheduleIdInput = document.getElementById('schedule_id_custom_tfp');

        const openModal = () => {
            if (!modal) return;
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            const currentHour = today.getHours();

            if (tanggalInput) tanggalInput.value = `${year}-${month}-${day}`;

            let currentDinas = 'Malam';
            if (currentHour >= 7 && currentHour < 13) currentDinas = 'Pagi';
            else if (currentHour >= 13 && currentHour < 19) currentDinas = 'Siang';
            if (dinasSelect) dinasSelect.value = currentDinas;

            generateId(); // Panggil generate ID
            modal.classList.remove('hidden');
        };

        const closeModal = () => {
            if (modal) modal.classList.add('hidden');
            if (addScheduleForm) addScheduleForm.reset();
        };

        // Fungsi Generate ID (ubah CNSD jadi TFP)
        const generateId = () => {
            if (!tanggalInput || !dinasSelect || !scheduleIdInput) return;
            const tanggal = tanggalInput.value;
            const dinas = dinasSelect.value.toUpperCase();
            if (tanggal && dinas) {
                const dateParts = tanggal.split('-');
                const formattedDate = `${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`;
                scheduleIdInput.value = `${dinas}-${formattedDate}-TFP`; // <-- Ganti jadi TFP
            } else {
                scheduleIdInput.value = '';
            }
        };

        // Event Listeners (pakai ID baru)
        if (openModalBtn) openModalBtn.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        });
        if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
        if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeModal);
        if (modal) modal.addEventListener('click', (event) => {
            if (event.target === modal) closeModal();
        });
        if (tanggalInput) tanggalInput.addEventListener('change', generateId);
        if (dinasSelect) dinasSelect.addEventListener('change', generateId);

    });
</script>
@endpush