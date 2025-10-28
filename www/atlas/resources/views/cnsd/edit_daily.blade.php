@extends('layouts.main_dashboard')

@section('content')
<div class="p-6 md:p-8">
    {{-- Header Halaman --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <a href="{{ route('cnsd.daily') }}" class="p-2 rounded-md hover:bg-gray-200" aria-label="Kembali ke Daftar Daily">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 ml-4">Edit Kesiapan Fasilitas CNSD</h1>
        </div>
    </div>

    {{-- Form Edit Daily --}}
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        {{-- Arahkan ke route update, pakai method PUT --}}
        <form id="edit-daily-form" action="{{ route('cnsd.daily.update', $report) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT') {{-- PENTING untuk update --}}

            {{-- Baris ID Daily, Tanggal, Jam, Dinas (2 Kolom) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 items-start">
                {{-- Kolom Kiri: ID & Tanggal --}}
                <div class="space-y-4">
                    <div>
                        <label for="daily_id_custom" class="block text-sm font-medium text-gray-700 mb-1">ID_DAILY*</label>
                        {{-- ID biasanya tidak diedit --}}
                        <input type="text" id="daily_id_custom" name="report_id_custom" value="{{ $report->report_id_custom }}" readonly class="block w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm p-2 text-gray-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label for="daily_tanggal" class="block text-sm font-medium text-gray-700 mb-1">TANGGAL*</label>
                        <input type="date" id="daily_tanggal" name="tanggal" required value="{{ old('tanggal', $report->tanggal->format('Y-m-d')) }}" class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 @error('tanggal') border-red-500 @enderror">
                        @error('tanggal') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
                {{-- Kolom Kanan: Jam & Dinas --}}
                <div class="space-y-4">
                    <div>
                        <label for="daily_jam" class="block text-sm font-medium text-gray-700 mb-1">JAM</label>
                        <input type="time" id="daily_jam" name="jam" required value="{{ old('jam', \Carbon\Carbon::parse($report->jam)->format('H:i')) }}" class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 @error('jam') border-red-500 @enderror">
                        @error('jam') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">DINAS*</label>
                        <div class="flex rounded-lg border border-gray-300 overflow-hidden">
                            <label class="flex-1 text-center cursor-pointer transition-colors has-[:checked]:bg-indigo-600 has-[:checked]:text-white">
                                <input type="radio" name="dinas" value="Pagi" class="sr-only" {{ old('dinas', $report->dinas) == 'Pagi' ? 'checked' : '' }}>
                                <span class="block rounded-l-md px-3 py-2 text-gray-600">PAGI</span>
                            </label>
                            <label class="flex-1 text-center cursor-pointer border-l border-r border-gray-300 transition-colors has-[:checked]:bg-indigo-600 has-[:checked]:text-white">
                                <input type="radio" name="dinas" value="Siang" class="sr-only" {{ old('dinas', $report->dinas) == 'Siang' ? 'checked' : '' }}>
                                <span class="block px-3 py-2 text-gray-600">SIANG</span>
                            </label>
                            <label class="flex-1 text-center cursor-pointer transition-colors has-[:checked]:bg-indigo-600 has-[:checked]:text-white">
                                <input type="radio" name="dinas" value="Malam" class="sr-only" {{ old('dinas', $report->dinas) == 'Malam' ? 'checked' : '' }}>
                                <span class="block rounded-r-md px-3 py-2 text-gray-600">MALAM</span>
                            </label>
                        </div>
                        @error('dinas') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- Peralatan CNSD --}}
            <h4 class="text-lg font-semibold text-indigo-700 border-t pt-4 mt-6">Peralatan CNSD</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                @foreach ($equipmentList as $equipment)
                @php
                $equipmentKey = Str::slug($equipment->name, '_');
                // Ambil status & keterangan tersimpan (jika ada)
                $savedStatus = $report->equipment_status[$equipmentKey]['status'] ?? 'NORMAL';
                $savedKeterangan = $report->equipment_status[$equipmentKey]['keterangan'] ?? '';
                @endphp
                <div class="equipment-item">
                    <label for="status_{{ $equipmentKey }}" class="block text-sm font-medium text-gray-700">{{ $equipment->name }}</label>
                    <select id="status_{{ $equipmentKey }}" name="equipment_status[{{ $equipmentKey }}][status]"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 equipment-status-select @error('equipment_status.'.$equipmentKey.'.status') border-red-500 @enderror">
                        <option value="NORMAL" {{ old('equipment_status.'.$equipmentKey.'.status', $savedStatus) == 'NORMAL' ? 'selected' : '' }}>NORMAL</option>
                        <option value="GANGGUAN" {{ old('equipment_status.'.$equipmentKey.'.status', $savedStatus) == 'GANGGUAN' ? 'selected' : '' }}>GANGGUAN</option>
                        <option value="U/S" {{ old('equipment_status.'.$equipmentKey.'.status', $savedStatus) == 'U/S' ? 'selected' : '' }}>U/S</option>
                        <option value="SINGLE" {{ old('equipment_status.'.$equipmentKey.'.status', $savedStatus) == 'SINGLE' ? 'selected' : '' }}>SINGLE</option>
                    </select>
                    {{-- Keterangan (muncul kondisional) --}}
                    <div class="mt-2 keterangan-wrapper {{ $savedStatus == 'NORMAL' ? 'hidden' : '' }}"> {{-- Tampilkan jika status awal BUKAN NORMAL --}}
                        <label for="keterangan_{{ $equipmentKey }}" class="block text-xs font-medium text-gray-500">KETERANGAN</label>
                        <textarea id="keterangan_{{ $equipmentKey }}" name="equipment_status[{{ $equipmentKey }}][keterangan]"
                            rows="2" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 @error('equipment_status.'.$equipmentKey.'.keterangan') border-red-500 @enderror">{{ old('equipment_status.'.$equipmentKey.'.keterangan', $savedKeterangan) }}</textarea>
                        @error('equipment_status.'.$equipmentKey.'.keterangan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    @error('equipment_status.'.$equipmentKey.'.status') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
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
                        <select id="mantek" name="mantek" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 @error('mantek') border-red-500 @enderror">
                            <option value="">Pilih Mantek</option>
                            @foreach ($userList as $id => $name)
                            <option value="{{ $name }}" {{ old('mantek', $report->mantek) == $name ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('mantek') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="daily_kode" class="block text-sm font-medium text-gray-700">KODE</label>
                        {{-- Kode biasanya tidak diedit --}}
                        <input type="text" id="daily_kode" name="kode" value="{{ $report->kode }}" readonly class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm p-2 text-gray-500 cursor-not-allowed">
                    </div>
                </div>
                {{-- Kanan: Acknowledge, Jadwal Dinas --}}
                <div class="space-y-4">
                    <div>
                        <label for="acknowledge" class="block text-sm font-medium text-gray-700">ACKNOWLEDGE</label>
                        <select id="acknowledge" name="acknowledge" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 @error('acknowledge') border-red-500 @enderror">
                            <option value="">Pilih Acknowledge</option>
                            @foreach ($userList as $id => $name)
                            <option value="{{ $name }}" {{ old('acknowledge', $report->acknowledge) == $name ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('acknowledge') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="jadwal_dinas" class="block text-sm font-medium text-gray-700">JADWAL DINAS</label>
                        {{-- Jadwal Dinas mungkin perlu diambil ulang atau disimpan --}}
                        <textarea id="jadwal_dinas" name="jadwal_dinas" rows="4" readonly class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm p-2 text-gray-500 cursor-not-allowed">{{ old('jadwal_dinas', $report->jadwal_dinas) }}</textarea>
                        @error('jadwal_dinas') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end items-center border-t pt-6 mt-6 space-x-2">
                <a href="{{ route('cnsd.daily') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Kembali
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Report
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Script untuk show/hide keterangan equipment
    document.addEventListener('DOMContentLoaded', function() {
        const equipmentStatusSelects = document.querySelectorAll('.equipment-status-select');
        equipmentStatusSelects.forEach(select => {
            // Cek kondisi awal saat halaman load
            const parentDiv = select.closest('.equipment-item');
            const keteranganWrapper = parentDiv.querySelector('.keterangan-wrapper');
            if (select.value !== 'NORMAL' && keteranganWrapper) {
                keteranganWrapper.classList.remove('hidden');
            }

            // Tambah event listener untuk perubahan
            select.addEventListener('change', function() {
                const parentDiv = this.closest('.equipment-item');
                const keteranganWrapper = parentDiv.querySelector('.keterangan-wrapper');
                if (this.value !== 'NORMAL' && keteranganWrapper) {
                    keteranganWrapper.classList.remove('hidden');
                } else if (keteranganWrapper) {
                    keteranganWrapper.classList.add('hidden');
                    const textarea = keteranganWrapper.querySelector('textarea');
                    // if (textarea) textarea.value = ''; // Jangan reset value saat edit
                }
            });
        });

        // Optional: Script AJAX untuk update Jadwal Dinas jika Tanggal/Dinas diubah
        const tanggalInput = document.getElementById('daily_tanggal');
        const dinasRadios = document.querySelectorAll('#edit-daily-form input[name="dinas"]');
        const jadwalDinasTextarea = document.getElementById('jadwal_dinas');

        const fetchJadwalEdit = async () => {
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
                    /* ... headers ... */
                });
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

        // if(tanggalInput) tanggalInput.addEventListener('change', fetchJadwalEdit);
        // dinasRadios.forEach(radio => { radio.addEventListener('change', fetchJadwalEdit); });
    });
</script>
@endpush