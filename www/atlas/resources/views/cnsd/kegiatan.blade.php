@extends('layouts.main_dashboard')

@section('content')
<div class="p-6 md:p-8">
    {{-- Header Halaman --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            {{-- Tombol kembali (ke dashboard atau cnsd.index) --}}
            <a href="{{ route('cnsd.index') }}" class="p-2 rounded-md hover:bg-gray-200" aria-label="Kembali">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 ml-4">Log Kegiatan CNSD</h1>
        </div>

        {{-- Tombol Tambah Kegiatan --}}
        <a href="#" id="add-kegiatan-btn" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            + Tambah Kegiatan
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
                        <th scope="col" class="px-6 py-3">Kode</th>
                        <th scope="col" class="px-6 py-3">Dinas</th>
                        <th scope="col" class="px-6 py-3">Tanggal</th>
                        <th scope="col" class="px-6 py-3">Mulai</th>
                        <th scope="col" class="px-6 py-3">Selesai</th>
                        <th scope="col" class="px-6 py-3">Alat</th>
                        <th scope="col" class="px-6 py-3">Permasalahan</th>
                        <th scope="col" class="px-6 py-3">Tindakan</th>
                        <th scope="col" class="px-6 py-3">Hasil</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Teknisi</th>
                        <th scope="col" class="px-6 py-3">Waktu Terputus</th>
                        <th scope="col" class="px-6 py-3">Lampiran</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop data '$activities' dari Controller --}}
                    @forelse ($activities as $activity)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $activity->kode }}</td>
                        <td class="px-6 py-4">{{ $activity->dinas }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $activity->tanggal->format('d M Y') }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($activity->waktu_mulai)->format('H:i') }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($activity->waktu_selesai)->format('H:i') }}</td>
                        <td class="px-6 py-4">{{ $activity->alat }}</td>
                        {{-- Batasi teks panjang dengan 'Str::limit' --}}
                        <td class="px-6 py-4 max-w-xs truncate" title="{{ $activity->permasalahan }}">{{ \Illuminate\Support\Str::limit($activity->permasalahan, 50) }}</td>
                        <td class="px-6 py-4 max-w-xs truncate" title="{{ $activity->tindakan }}">{{ \Illuminate\Support\Str::limit($activity->tindakan, 50) }}</td>
                        <td class="px-6 py-4 max-w-xs truncate" title="{{ $activity->hasil }}">{{ \Illuminate\Support\Str::limit($activity->hasil, 50) }}</td>
                        <td class="px-6 py-4">{{ $activity->status }}</td>
                        <td class="px-6 py-4">
                            {{-- Gabungkan nama teknisi dari array JSON --}}
                            {{ is_array($activity->teknisi) ? implode(', ', $activity->teknisi) : '-' }}
                        </td>
                        <td class="px-6 py-4">{{ $activity->waktu_terputus ?? '-' }}</td>
                        <td class="px-6 py-4">
                            {{-- Tampilkan jumlah lampiran jika ada --}}
                            @if(is_array($activity->lampiran) && count($activity->lampiran) > 0)
                            <span class="text-blue-600">{{ count($activity->lampiran) }} Lampiran</span>
                            @else
                            -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('cnsd.kegiatan.edit', $activity) }}" class="font-medium text-indigo-600 hover:underline">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr class="bg-white border-b">
                        <td colspan="14" class="px-6 py-4 text-center text-gray-500">
                            Data kegiatan masih kosong.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- >>> AWAL MODAL TAMBAH KEGIATAN <<< --}}
<div id="add-kegiatan-modal"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center hidden z-50 p-4">

    <div class="relative mx-auto border w-full max-w-2xl shadow-lg rounded-xl bg-white">
        {{-- Form Tambah Kegiatan --}}
        <form id="add-kegiatan-form" action="{{ route('cnsd.kegiatan.store') }}" method="POST" enctype="multipart/form-data"> {{-- Jangan lupa enctype --}}
            @csrf

            {{-- Header Modal --}}
            <div class="flex justify-between items-center border-b p-4 sticky top-0 bg-white rounded-t-xl z-10">
                <h3 class="text-xl font-semibold text-gray-900">Tambah Kegiatan Baru</h3>
                <button type="button" id="close-kegiatan-modal-btn" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            {{-- Konten Modal (scrollable) --}}
            <div class="p-4 md:p-6 space-y-4 max-h-[70vh] overflow-y-auto">

                {{-- Baris Kode, Dinas, Tanggal, Waktu Mulai --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <label for="kegiatan_kode" class="block text-sm font-medium text-gray-700">Kode</label>
                        <input type="text" id="kegiatan_kode" name="kode" readonly
                            class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm p-2 text-gray-500">
                    </div>
                    <div>
                        <label for="kegiatan_dinas" class="block text-sm font-medium text-gray-700">Dinas</label>
                        <select id="kegiatan_dinas" name="dinas" required
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                            <option value="Pagi">Pagi</option>
                            <option value="Siang">Siang</option>
                            <option value="Malam">Malam</option>
                        </select>
                    </div>
                    <div>
                        <label for="kegiatan_tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" id="kegiatan_tanggal" name="tanggal" required
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                    </div>
                    <div>
                        <label for="kegiatan_waktu_mulai" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                        <input type="time" id="kegiatan_waktu_mulai" name="waktu_mulai" required
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                    </div>
                    <div>
                        <label for="kegiatan_waktu_selesai" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                        <input type="time" id="kegiatan_waktu_selesai" name="waktu_selesai" required
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                    </div>
                    <div>
                        <label for="kegiatan_alat" class="block text-sm font-medium text-gray-700">Alat</label>
                        <input type="text" id="kegiatan_alat" name="alat" required
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                    </div>
                </div>

                {{-- Textarea (Permasalahan, Tindakan, Hasil) --}}
                <div>
                    <label for="kegiatan_permasalahan" class="block text-sm font-medium text-gray-700">Permasalahan</label>
                    <textarea id="kegiatan_permasalahan" name="permasalahan" rows="3" required
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"></textarea>
                </div>
                <div>
                    <label for="kegiatan_tindakan" class="block text-sm font-medium text-gray-700">Tindakan</label>
                    <textarea id="kegiatan_tindakan" name="tindakan" rows="3" required
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"></textarea>
                </div>
                <div>
                    <label for="kegiatan_hasil" class="block text-sm font-medium text-gray-700">Hasil</label>
                    <textarea id="kegiatan_hasil" name="hasil" rows="3" required
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"></textarea>
                </div>

                {{-- Baris Status & Waktu Terputus --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <label for="kegiatan_status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="kegiatan_status" name="status" required
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                            <option value="Selesai">Selesai</option>
                            <option value="Belum Selesai">Belum Selesai</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                    <div>
                        <label for="kegiatan_waktu_terputus" class="block text-sm font-medium text-gray-700">Waktu Terputus</label>
                        <input type="text" id="kegiatan_waktu_terputus" name="waktu_terputus"
                            placeholder="cth: 1 jam 15 mnt"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                    </div>
                </div>

                {{-- Teknisi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teknisi</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                        @for ($i = 0; $i < 6; $i++) {{-- Kita pakai index 0-5 untuk array --}}
                            <select name="teknisi[]" {{-- Nama input jadi array --}}
                            class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 teknisi-select">
                            <option value="">-- Pilih Teknisi {{ $i + 1 }} {{ $i > 2 ? '(Opsional)' : '' }} --</option>
                            {{-- Loop list SEMUA teknisi dari Controller --}}
                            @foreach ($allTeknisi as $namaTeknisi)
                            <option value="{{ $namaTeknisi }}">{{ $namaTeknisi }}</option>
                            @endforeach
                            </select>
                            @endfor
                    </div>
                </div>

                {{-- Lampiran --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Lampiran</label>
                    <div class="mt-2 flex flex-wrap gap-4 items-start"> {{-- Pakai Flexbox --}}

                        {{-- Area Preview File (Maksimal 5?) --}}
                        <div id="file-preview-container" class="flex flex-wrap gap-4">
                            {{-- Preview akan muncul di sini --}}
                        </div>

                        {{-- Tombol/Area Tambah File --}}
                        <label for="kegiatan_lampiran_input"
                            class="flex flex-col items-center justify-center w-32 h-24 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-indigo-400">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="text-xs text-gray-500">Tambah file</p>
                            </div>
                            {{-- Input file tetap tersembunyi --}}
                            <input id="kegiatan_lampiran_input" name="lampiran[]" type="file" class="sr-only" multiple
                                accept="image/png, image/jpeg, image/jpg, application/pdf, application/msword, ..."> {{-- Sesuaikan accept --}}
                        </label>

                    </div>
                    <p class="mt-1 text-xs text-gray-500">PNG, JPG, PDF, DOCX, XLSX hingga 5MB. Maksimal 5 file.</p> {{-- Keterangan tambahan --}}
                </div>

            </div>{{-- End Konten Scrollable --}}

            {{-- Footer Modal --}}
            <div class="flex justify-end items-center border-t p-4 space-x-2 sticky bottom-0 bg-white rounded-b-xl z-10">
                <button type="button" id="cancel-kegiatan-modal-btn" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Simpan Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>
{{-- >>> AKHIR MODAL TAMBAH KEGIATAN <<< --}}


@endsection {{-- Penutup @section('content') --}}


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('add-kegiatan-modal');
        const openModalBtn = document.getElementById('add-kegiatan-btn');
        const closeModalBtn = document.getElementById('close-kegiatan-modal-btn');
        const cancelModalBtn = document.getElementById('cancel-kegiatan-modal-btn');
        const addKegiatanForm = document.getElementById('add-kegiatan-form');

        // Elemen form yg butuh di-update JS
        const kodeInput = document.getElementById('kegiatan_kode');
        const tanggalInput = document.getElementById('kegiatan_tanggal');
        const dinasSelect = document.getElementById('kegiatan_dinas');
        const waktuMulaiInput = document.getElementById('kegiatan_waktu_mulai');
        const waktuSelesaiInput = document.getElementById('kegiatan_waktu_selesai');
        const teknisiSelects = document.querySelectorAll('.teknisi-select'); // Semua dropdown teknisi
        const fileInput = document.getElementById('kegiatan_lampiran_input');
        const previewContainer = document.getElementById('file-preview-container');
        const imageLightbox = document.getElementById('image-lightbox');
        const lightboxImage = document.getElementById('lightbox-image');
        const closeLightboxBtn = document.getElementById('close-lightbox-btn');

        let currentFiles = [];

        // Fungsi Generate Kode Kegiatan
        const generateKode = () => {
            if (!kodeInput) return;
            const now = new Date();
            // Format: KG-CNSD-XXXXXX (6 digit acak)
            const randomPart = Math.floor(100000 + Math.random() * 900000);
            kodeInput.value = `KG-CNSD-${randomPart}`;
        };

        // Fungsi Fetch Teknisi Dinas via AJAX & Autofill
        const fetchAndSetTeknisi = async () => {
            if (!tanggalInput || !dinasSelect || teknisiSelects.length === 0) return;

            const tanggal = tanggalInput.value;
            const dinas = dinasSelect.value;

            if (!tanggal || !dinas) return; // Jangan fetch kalo belum lengkap

            // Reset dulu semua dropdown teknisi
            teknisiSelects.forEach(select => select.value = '');

            try {
                const response = await fetch(`{{ route('cnsd.kegiatan.getTeknisi') }}?tanggal=${tanggal}&dinas=${dinas}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                if (!response.ok) throw new Error('Gagal fetch teknisi');

                const data = await response.json();

                if (data.success && data.teknisi && data.teknisi.length > 0) {
                    // Isi dropdown sesuai urutan teknisi yang dinas
                    data.teknisi.forEach((nama, index) => {
                        if (teknisiSelects[index]) {
                            // Cek apakah nama tsb ada di option, baru set value
                            const optionExists = Array.from(teknisiSelects[index].options).some(opt => opt.value === nama);
                            if (optionExists) {
                                teknisiSelects[index].value = nama;
                            } else {
                                console.warn(`Teknisi "${nama}" dari jadwal tidak ditemukan di daftar dropdown.`);
                                // Opsional: Tambahkan option baru jika tidak ada?
                            }
                        }
                    });
                } else {
                    console.log(data.message || 'Jadwal teknisi tidak ditemukan.');
                    // Biarkan dropdown kosong
                }
            } catch (error) {
                console.error('Error fetching teknisi:', error);
                // Biarkan dropdown kosong
            }
        };

        // Fungsi Buka Modal
        const openModal = () => {
            if (!modal) return;

            // Generate Kode awal
            generateKode();

            // Set Tanggal & Waktu otomatis
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            if (tanggalInput) tanggalInput.value = `${year}-${month}-${day}`;
            if (waktuMulaiInput) waktuMulaiInput.value = `${hours}:${minutes}`;
            // Waktu selesai bisa dikosongkan atau default +1 jam
            // if (waktuSelesaiInput) waktuSelesaiInput.value = `${String(now.getHours()+1).padStart(2,'0')}:${minutes}`;

            // Set Dinas Otomatis
            const currentHour = now.getHours();
            let currentDinas = 'Malam';
            if (currentHour >= 7 && currentHour < 13) currentDinas = 'Pagi';
            else if (currentHour >= 13 && currentHour < 19) currentDinas = 'Siang';
            if (dinasSelect) dinasSelect.value = currentDinas;

            // Fetch Teknisi awal
            fetchAndSetTeknisi();

            modal.classList.remove('hidden');
        };

        // Fungsi Tutup Modal
        const closeModal = () => {
            if (modal) modal.classList.add('hidden');
            if (addKegiatanForm) addKegiatanForm.reset();
            // Ganti fileListDiv jadi previewContainer
            if (previewContainer) previewContainer.innerHTML = ''; // <-- Fix typo
            currentFiles = [];
            updateFileInput();
        };

        // Event Listener Modal
        if (openModalBtn) openModalBtn.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        });
        if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
        if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeModal);
        if (modal) modal.addEventListener('click', (event) => {
            if (event.target === modal) closeModal();
        });

        // Event Listener untuk Fetch Ulang Teknisi
        if (tanggalInput) tanggalInput.addEventListener('change', fetchAndSetTeknisi);
        if (dinasSelect) dinasSelect.addEventListener('change', fetchAndSetTeknisi);

        // Event Listener untuk File Input (Tampilkan nama file)
        if (fileInput && previewContainer) {
            fileInput.addEventListener('change', handleFiles);

            // Juga handle drag and drop (opsional tapi bagus)
            const dropArea = fileInput.closest('div.border-dashed'); // Ambil area drop
            if (dropArea) {
                dropArea.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    dropArea.classList.add('border-indigo-400'); // Efek visual saat drag over
                });
                dropArea.addEventListener('dragleave', () => {
                    dropArea.classList.remove('border-indigo-400');
                });
                dropArea.addEventListener('drop', (e) => {
                    e.preventDefault();
                    dropArea.classList.remove('border-indigo-400');
                    if (e.dataTransfer.files) {
                        // Perbarui file input dengan file yg di-drop
                        fileInput.files = e.dataTransfer.files;
                        // Panggil handler file
                        handleFiles();
                    }
                });
            }
        }

        function handleFiles() {
            const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            const maxSize = 5 * 1024 * 1024; // 5MB
            previewContainer.innerHTML = ''; // Kosongkan preview lama
            currentFiles = []; // Kosongkan array file

            const files = Array.from(fileInput.files);
            // Batasi jumlah file (misal 5)
            const filesToProcess = files.slice(0, 5);

            filesToProcess.forEach((file, index) => {
                // ... (Validasi tipe & ukuran file biarkan sama) ...
                if (!allowedTypes.includes(file.type) || file.size > maxSize) {
                    return;
                }

                currentFiles.push(file);
                const fileIndex = currentFiles.length - 1; // Index di array currentFiles

                // Buat elemen preview
                const previewWrapper = document.createElement('div');
                previewWrapper.classList.add('relative', 'group', 'w-24', 'h-24', 'border', 'rounded-lg', 'overflow-hidden'); // Ukuran fixed

                // Konten preview
                const previewContent = document.createElement('div');
                previewContent.classList.add('w-full', 'h-full', 'flex', 'items-center', 'justify-center', 'bg-gray-100');

                if (file.type.startsWith('image/')) {
                    // Jika gambar
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = file.name;
                        img.classList.add('object-cover', 'w-full', 'h-full', 'cursor-pointer'); // Tambah cursor-pointer

                        // EVENT LISTENER UNTUK LIGHTBOX
                        img.onclick = () => showLightbox(e.target.result);

                        previewContent.innerHTML = '';
                        previewContent.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                } else {
                    // Jika bukan gambar (ikon file)
                    previewContent.innerHTML = `
                    <svg class="w-10 h-10 text-gray-400" ...></svg> 
                    <span class="absolute bottom-1 left-1 right-1 text-xs text-center text-gray-600 bg-white bg-opacity-75 truncate px-1">${file.name}</span>
                `; // Tambah nama file kecil
                    previewContent.classList.add('relative'); // Biar nama file bisa absolute
                }

                // Tombol Hapus
                const deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.innerHTML = '&times;';
                deleteButton.classList.add(
                    'absolute', 'top-1', 'right-1', // Posisi
                    'bg-red-500', 'text-white', // Warna
                    'rounded-full', 'w-5', 'h-5', // Ukuran & Bentuk
                    'flex', 'items-center', 'justify-center', // Layout
                    'text-xs', 'font-bold', // Font
                    'opacity-0', 'group-hover:opacity-100', 'transition-opacity', // Efek Hover
                    'z-10' // Biar di atas gambar
                );
                deleteButton.dataset.index = fileIndex; // Simpan index

                deleteButton.onclick = function() {
                    const indexToRemove = parseInt(this.dataset.index);
                    currentFiles.splice(indexToRemove, 1);
                    updateFileInput();
                    updateDeleteButtonIndices(); // Update index tombol lain
                    this.closest('.relative').remove(); // Hapus preview
                };
                deleteButton.dataset.index = fileIndex; // Pakai fileIndex

                deleteButton.onclick = function() {
                    const indexToRemove = parseInt(this.dataset.index);
                    currentFiles.splice(indexToRemove, 1);
                    updateFileInput();
                    // Update index tombol hapus lainnya
                    updateDeleteButtonIndices();
                    this.closest('.relative').remove();
                };

                previewWrapper.appendChild(previewContent);
                previewWrapper.appendChild(deleteButton);
                previewContainer.appendChild(previewWrapper);
            });
            updateFileInput();
        }

        // Fungsi baru untuk update index tombol hapus setelah ada yg dihapus
        function updateDeleteButtonIndices() {
            const deleteButtons = previewContainer.querySelectorAll('button[data-index]');
            deleteButtons.forEach((button, newIndex) => {
                button.dataset.index = newIndex;
            });
        }

        // Fungsi untuk update file input (biarkan sama)
        function updateFileInput() {
            /* ... */
        }

        // Fungsi untuk menampilkan Lightbox
        function showLightbox(imageUrl) {
            if (imageLightbox && lightboxImage) {
                lightboxImage.src = imageUrl;
                imageLightbox.classList.remove('hidden');
            }
        }

        // Fungsi untuk menutup Lightbox
        function closeLightbox() {
            if (imageLightbox) {
                imageLightbox.classList.add('hidden');
                lightboxImage.src = ''; // Kosongkan src
            }
        }

        // Event listener untuk tombol close lightbox & klik background
        if (closeLightboxBtn) closeLightboxBtn.addEventListener('click', closeLightbox);
        if (imageLightbox) imageLightbox.addEventListener('click', (event) => {
            // Tutup hanya jika klik di background (bukan di gambar)
            if (event.target === imageLightbox) {
                closeLightbox();
            }
        });

        // Fungsi untuk update file di <input type="file">
        function updateFileInput() {
            const dataTransfer = new DataTransfer();
            currentFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
            fileInput.files = dataTransfer.files;
        }
    });
</script>
@endpush

<div id="image-lightbox"
    class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 hidden z-[60]"> {{-- z-[60] biar di atas modal --}}
    <img id="lightbox-image" src="" alt="Preview Lampiran" class="max-w-full max-h-full object-contain">
    <button id="close-lightbox-btn" class="absolute top-4 right-4 text-white text-3xl font-bold">&times;</button>
</div>