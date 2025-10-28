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
            <h1 class="text-2xl font-bold text-gray-800 ml-4">Log Kegiatan TFP</h1> {{-- Judul diubah --}}
        </div>

        <a href="#" id="add-kegiatan-btn-tfp" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
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
                        <td class="px-6 py-4 max-w-xs truncate" title="{{ $activity->permasalahan }}">{{ \Illuminate\Support\Str::limit($activity->permasalahan, 50) }}</td>
                        <td class="px-6 py-4 max-w-xs truncate" title="{{ $activity->tindakan }}">{{ \Illuminate\Support\Str::limit($activity->tindakan, 50) }}</td>
                        <td class="px-6 py-4 max-w-xs truncate" title="{{ $activity->hasil }}">{{ \Illuminate\Support\Str::limit($activity->hasil, 50) }}</td>
                        <td class="px-6 py-4">{{ $activity->status }}</td>
                        <td class="px-6 py-4">
                            {{ is_array($activity->teknisi) ? implode(', ', $activity->teknisi) : '-' }}
                        </td>
                        <td class="px-6 py-4">{{ $activity->waktu_terputus ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if(is_array($activity->lampiran) && count($activity->lampiran) > 0)
                            <span class="text-blue-600">{{ count($activity->lampiran) }} Lampiran</span>
                            @else
                            -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('tfp.kegiatan.edit', $activity) }}" class="font-medium text-indigo-600 hover:underline">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr class="bg-white border-b">
                        <td colspan="14" class="px-6 py-4 text-center text-gray-500">
                            Data kegiatan TFP masih kosong. {{-- Teks diubah --}}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- >>> AWAL MODAL TAMBAH KEGIATAN TFP <<< --}}
<div id="add-kegiatan-modal-tfp"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center hidden z-50 p-4"
    aria-labelledby="modal-title-tfp-kegiatan" role="dialog" aria-modal="true">

    <div class="relative mx-auto border w-full max-w-2xl shadow-lg rounded-xl bg-white">
        {{-- Form Tambah Kegiatan TFP --}}
        <form id="add-kegiatan-form-tfp" action="{{ route('tfp.kegiatan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Header Modal --}}
            <div class="flex justify-between items-center border-b p-4 sticky top-0 bg-white rounded-t-xl z-10">
                <h3 id="modal-title-tfp-kegiatan" class="text-xl font-semibold text-gray-900">Tambah Kegiatan Baru (TFP)</h3>
                <button type="button" id="close-kegiatan-modal-btn-tfp" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" aria-label="Close modal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            {{-- Konten Modal --}}
            <div class="p-4 md:p-6 space-y-4 max-h-[70vh] overflow-y-auto">

                {{-- Baris Kode, Dinas, Tanggal, Waktu Mulai --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <label for="kegiatan_kode_tfp" class="block text-sm font-medium text-gray-700">Kode</label>
                        <input type="text" id="kegiatan_kode_tfp" name="kode" readonly class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm p-2 text-gray-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label for="kegiatan_dinas_tfp" class="block text-sm font-medium text-gray-700">Dinas</label>
                        <select id="kegiatan_dinas_tfp" name="dinas" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                            <option value="Pagi">Pagi</option>
                            <option value="Siang">Siang</option>
                            <option value="Malam">Malam</option>
                        </select>
                    </div>
                    <div>
                        <label for="kegiatan_tanggal_tfp" class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" id="kegiatan_tanggal_tfp" name="tanggal" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                    </div>
                    <div>
                        <label for="kegiatan_waktu_mulai_tfp" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                        <input type="time" id="kegiatan_waktu_mulai_tfp" name="waktu_mulai" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                    </div>
                    <div>
                        <label for="kegiatan_waktu_selesai_tfp" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                        <input type="time" id="kegiatan_waktu_selesai_tfp" name="waktu_selesai" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                    </div>
                    <div>
                        <label for="kegiatan_alat_tfp" class="block text-sm font-medium text-gray-700">Alat</label>
                        <input type="text" id="kegiatan_alat_tfp" name="alat" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                    </div>
                </div>

                {{-- Textarea --}}
                <div>
                    <label for="kegiatan_permasalahan_tfp" class="block text-sm font-medium text-gray-700">Permasalahan</label>
                    <textarea id="kegiatan_permasalahan_tfp" name="permasalahan" rows="3" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"></textarea>
                </div>
                <div>
                    <label for="kegiatan_tindakan_tfp" class="block text-sm font-medium text-gray-700">Tindakan</label>
                    <textarea id="kegiatan_tindakan_tfp" name="tindakan" rows="3" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"></textarea>
                </div>
                <div>
                    <label for="kegiatan_hasil_tfp" class="block text-sm font-medium text-gray-700">Hasil</label>
                    <textarea id="kegiatan_hasil_tfp" name="hasil" rows="3" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"></textarea>
                </div>

                {{-- Baris Status & Waktu Terputus --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <label for="kegiatan_status_tfp" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="kegiatan_status_tfp" name="status" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                            <option value="Selesai">Selesai</option>
                            <option value="Belum Selesai">Belum Selesai</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                    <div>
                        <label for="kegiatan_waktu_terputus_tfp" class="block text-sm font-medium text-gray-700">Waktu Terputus</label>
                        <input type="text" id="kegiatan_waktu_terputus_tfp" name="waktu_terputus" placeholder="cth: 1 jam 15 mnt" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                    </div>
                </div>

                {{-- Teknisi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teknisi</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                        @for ($i = 0; $i < 6; $i++)
                            <select name="teknisi[]" class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 teknisi-select-tfp">
                            <option value="">-- Pilih Teknisi {{ $i + 1 }} {{ $i > 2 ? '(Opsional)' : '' }} --</option>
                            {{-- Loop $allTeknisi dari Controller --}}
                            @foreach ($allTeknisi as $namaTeknisi) <option value="{{ $namaTeknisi }}">{{ $namaTeknisi }}</option> @endforeach
                            </select>
                            @endfor
                    </div>
                </div>

                {{-- Lampiran --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Lampiran</label>
                    <div class="mt-2 flex flex-wrap gap-4 items-start">
                        <div id="file-preview-container-tfp" class="flex flex-wrap gap-4"></div>
                        <label id="add-file-button-label-tfp" for="kegiatan_lampiran_input_tfp" class="flex flex-col items-center justify-center w-32 h-24 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-indigo-400">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="text-xs text-gray-500">Tambah file</p>
                            </div>
                            <input id="kegiatan_lampiran_input_tfp" name="lampiran[]" type="file" class="sr-only" multiple accept="image/png, image/jpeg, image/jpg, application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">PNG, JPG, PDF, DOCX, XLSX hingga 5MB. Maksimal 5 file.</p>
                </div>

            </div>{{-- End Konten Scrollable --}}

            {{-- Footer Modal --}}
            <div class="flex justify-end items-center border-t p-4 space-x-2 sticky bottom-0 bg-white rounded-b-xl z-10">
                <button type="button" id="cancel-kegiatan-modal-btn-tfp" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>
{{-- >>> AKHIR MODAL TAMBAH KEGIATAN TFP <<< --}}

{{-- Kode Lightbox TFP (biarkan di sini) --}}
<div id="image-lightbox-tfp"
    class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 hidden z-[60]"> {{-- z-[60] biar di atas modal --}}
    <img id="lightbox-image" src="" alt="Preview Lampiran" class="max-w-full max-h-full object-contain">
    <button id="close-lightbox-btn" class="absolute top-4 right-4 text-white text-3xl font-bold">&times;</button>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // === ELEMEN MODAL & FORM TFP ===
        const modal = document.getElementById('add-kegiatan-modal-tfp');
        const openModalBtn = document.getElementById('add-kegiatan-btn-tfp');
        const closeModalBtn = document.getElementById('close-kegiatan-modal-btn-tfp');
        const cancelModalBtn = document.getElementById('cancel-kegiatan-modal-btn-tfp');
        const addKegiatanForm = document.getElementById('add-kegiatan-form-tfp');

        // === ELEMEN INPUT UTAMA TFP ===
        const kodeInput = document.getElementById('kegiatan_kode_tfp');
        const tanggalInput = document.getElementById('kegiatan_tanggal_tfp');
        const dinasSelect = document.getElementById('kegiatan_dinas_tfp');
        const waktuMulaiInput = document.getElementById('kegiatan_waktu_mulai_tfp');
        const teknisiSelects = document.querySelectorAll('.teknisi-select-tfp'); // Class unik
        const fileInput = document.getElementById('kegiatan_lampiran_input_tfp');
        const previewContainer = document.getElementById('file-preview-container-tfp');

        // === ELEMEN LIGHTBOX TFP ===
        const imageLightbox = document.getElementById('image-lightbox-tfp');
        const lightboxImage = document.getElementById('lightbox-image'); // <-- BENER (hapus -tfp)
        const closeLightboxBtn = document.getElementById('close-lightbox-btn'); // <-- BENER (hapus -tfp)

        // === VARIABEL GLOBAL UNTUK FILE ===
        let currentFiles = [];

        // === FUNGSI GENERATE KODE (VERSI TFP) ===
        const generateKode = () => {
            if (!kodeInput) return;
            const randomPart = Math.floor(100000 + Math.random() * 900000);
            kodeInput.value = `KG-TFP-${randomPart}`; // Ganti jadi TFP
        };

        // === FUNGSI FETCH TEKNISI DINAS TFP VIA AJAX ===
        const fetchAndSetTeknisi = async () => {
            if (!tanggalInput || !dinasSelect || teknisiSelects.length === 0) return;

            const tanggal = tanggalInput.value;
            const dinas = dinasSelect.value;

            if (!tanggal || !dinas) return; // Jangan fetch kalo belum lengkap

            // Reset dulu semua dropdown teknisi
            teknisiSelects.forEach(select => select.value = '');

            try {
                // Pastikan route name ini benar
                const response = await fetch(`{{ route('tfp.kegiatan.getTeknisi') }}?tanggal=${tanggal}&dinas=${dinas}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                if (!response.ok) throw new Error('Gagal fetch TFP teknisi');

                const data = await response.json();

                if (data.success && data.teknisi && data.teknisi.length > 0) {
                    data.teknisi.forEach((nama, index) => {
                        if (teknisiSelects[index]) {
                            const optionExists = Array.from(teknisiSelects[index].options).some(opt => opt.value === nama);
                            if (optionExists) {
                                teknisiSelects[index].value = nama;
                            } else {
                                console.warn(`Teknisi TFP "${nama}" dari jadwal tidak ditemukan di daftar dropdown.`);
                            }
                        }
                    });
                } else {
                    console.log(data.message || 'Jadwal TFP teknisi tidak ditemukan.');
                }
            } catch (error) {
                console.error('Error fetching TFP teknisi:', error);
            }
        };

        // === FUNGSI BUKA MODAL ===
        const openModal = () => {
            if (!modal) return;
            generateKode(); // Generate Kode awal

            // Set Tanggal & Waktu otomatis
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            if (tanggalInput) tanggalInput.value = `${year}-${month}-${day}`;
            if (waktuMulaiInput) waktuMulaiInput.value = `${hours}:${minutes}`;

            // Set Dinas Otomatis
            const currentHour = now.getHours();
            let currentDinas = 'Malam';
            if (currentHour >= 7 && currentHour < 13) currentDinas = 'Pagi';
            else if (currentHour >= 13 && currentHour < 19) currentDinas = 'Siang';
            if (dinasSelect) dinasSelect.value = currentDinas;

            fetchAndSetTeknisi(); // Fetch Teknisi awal
            modal.classList.remove('hidden'); // Tampilkan modal
        };

        // === FUNGSI TUTUP LIGHTBOX ===
        const closeLightbox = () => {
            if (imageLightbox) {
                imageLightbox.classList.add('hidden');
                if (lightboxImage) lightboxImage.src = '';
            }
        };

        // === FUNGSI UPDATE FILE INPUT ASLI ===
        const updateFileInput = () => {
            const dataTransfer = new DataTransfer();
            currentFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
            if (fileInput) fileInput.files = dataTransfer.files;
        };

        // === FUNGSI TUTUP MODAL ===
        const closeModal = () => {
            if (modal) modal.classList.add('hidden');
            if (addKegiatanForm) addKegiatanForm.reset();
            // Kosongkan preview container & array file saat modal ditutup
            if (previewContainer) previewContainer.innerHTML = '';
            currentFiles = [];
            updateFileInput(); // Update file input jadi kosong
            closeLightbox(); // Tutup lightbox jika terbuka
        };

        // === FUNGSI HANDLE FILE (PREVIEW, VALIDASI, DELETE) ===
        function handleFiles() {
            // Tipe file yang diizinkan dan ukuran maksimal
            const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            const maxSize = 5 * 1024 * 1024; // 5MB

            previewContainer.innerHTML = ''; // Kosongkan preview lama
            currentFiles = []; // Kosongkan array file

            const files = Array.from(fileInput.files);
            const filesToProcess = files.slice(0, 5); // Ambil maks 5 file

            filesToProcess.forEach((file) => { // Index tidak dipakai langsung di sini
                // Validasi
                if (!allowedTypes.includes(file.type) || file.size > maxSize) {
                    console.warn(`File TFP dilewati (tipe/ukuran salah): ${file.name}`);
                    return; // Lewati file ini
                }

                // File valid, tambahkan ke array
                currentFiles.push(file);
                const fileIndex = currentFiles.length - 1; // Index di array currentFiles

                // Buat elemen preview
                const previewWrapper = document.createElement('div');
                previewWrapper.classList.add('relative', 'group', 'w-24', 'h-24', 'border', 'rounded-lg', 'overflow-hidden');

                // Konten preview (gambar atau ikon)
                const previewContent = document.createElement('div');
                previewContent.classList.add('w-full', 'h-full', 'flex', 'items-center', 'justify-center', 'bg-gray-100');

                if (file.type.startsWith('image/')) {
                    // Jika gambar
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = file.name;
                        img.classList.add('object-cover', 'w-full', 'h-full', 'cursor-pointer');
                        img.onclick = () => showLightbox(e.target.result); // Panggil lightbox TFP
                        previewContent.innerHTML = '';
                        previewContent.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                } else {
                    // Jika bukan gambar (ikon file)
                    previewContent.innerHTML = `
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        <span class="absolute bottom-1 left-1 right-1 text-xs text-center text-gray-600 bg-white bg-opacity-75 truncate px-1">${file.name}</span>
                    `;
                    previewContent.classList.add('relative');
                }

                // Tombol Hapus
                const deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.innerHTML = '&times;';
                deleteButton.classList.add('absolute', 'top-1', 'right-1', 'bg-red-500', 'text-white', 'rounded-full', 'w-5', 'h-5', 'flex', 'items-center', 'justify-center', 'text-xs', 'font-bold', 'opacity-0', 'group-hover:opacity-100', 'transition-opacity', 'z-10');
                deleteButton.dataset.index = fileIndex; // Simpan index

                deleteButton.onclick = function() {
                    const indexToRemove = parseInt(this.dataset.index);
                    currentFiles.splice(indexToRemove, 1); // Hapus dari array
                    updateFileInput(); // Update input asli
                    updateDeleteButtonIndices(); // Update index tombol lain
                    this.closest('.relative').remove(); // Hapus preview
                };

                previewWrapper.appendChild(previewContent);
                previewWrapper.appendChild(deleteButton);
                previewContainer.appendChild(previewWrapper);
            });
            updateFileInput(); // Update input asli setelah loop
        }

        // === FUNGSI UPDATE INDEX TOMBOL HAPUS ===
        function updateDeleteButtonIndices() {
            const deleteButtons = previewContainer.querySelectorAll('button[data-index]');
            deleteButtons.forEach((button, newIndex) => {
                button.dataset.index = newIndex;
            });
        }

        // === FUNGSI TAMPILKAN LIGHTBOX ===
        function showLightbox(imageUrl) {
            if (imageLightbox && lightboxImage) {
                lightboxImage.src = imageUrl;
                imageLightbox.classList.remove('hidden');
            }
        }

        // === EVENT LISTENERS ===
        // Tombol Modal
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

        // Update Teknisi saat Tanggal/Dinas berubah
        if (tanggalInput) tanggalInput.addEventListener('change', fetchAndSetTeknisi);
        if (dinasSelect) dinasSelect.addEventListener('change', fetchAndSetTeknisi);

        // File Input & Drag n Drop
        if (fileInput && previewContainer) {
            fileInput.addEventListener('change', handleFiles);
            // Cari area drop yang benar (labelnya)
            const dropArea = document.getElementById('add-file-button-label-tfp');
            if (dropArea) {
                dropArea.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    dropArea.classList.add('border-indigo-400', 'bg-indigo-50');
                });
                dropArea.addEventListener('dragleave', () => {
                    dropArea.classList.remove('border-indigo-400', 'bg-indigo-50');
                });
                dropArea.addEventListener('drop', (e) => {
                    e.preventDefault();
                    dropArea.classList.remove('border-indigo-400', 'bg-indigo-50');
                    if (e.dataTransfer.files) {
                        fileInput.files = e.dataTransfer.files;
                        handleFiles();
                    }
                });
            }
        }

        // Lightbox Close
        if (closeLightboxBtn) closeLightboxBtn.addEventListener('click', closeLightbox);
        if (imageLightbox) imageLightbox.addEventListener('click', (event) => {
            // Tutup hanya jika klik di background
            if (event.target === imageLightbox) closeLightbox();
        });

    });
</script>
@endpush