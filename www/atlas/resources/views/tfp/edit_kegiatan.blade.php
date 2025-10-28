@extends('layouts.main_dashboard')

@section('content')
<div class="p-6 md:p-8">
    {{-- Header Halaman --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            {{-- GANTI ROUTE --}}
            <a href="{{ route('tfp.kegiatan') }}" class="p-2 rounded-md hover:bg-gray-200" aria-label="Kembali ke Log Kegiatan TFP">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            {{-- GANTI JUDUL --}}
            <h1 class="text-2xl font-bold text-gray-800 ml-4">Edit Kegiatan TFP</h1>
        </div>
        {{-- Tombol Simpan ditaruh di bawah form --}}
    </div>

    {{-- Form Edit Kegiatan --}}
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        {{-- GANTI ROUTE --}}
        <form action="{{ route('tfp.kegiatan.update', $activity) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Baris Kode, Dinas, Tanggal, Waktu Mulai, Selesai, Alat --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                {{-- Kode --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kode</label>
                    <input type="text" value="{{ $activity->kode }}" readonly
                        class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm p-2 text-gray-500 cursor-not-allowed text-sm">
                </div>
                {{-- Dinas --}}
                <div>
                    <label for="kegiatan_dinas" class="block text-sm font-medium text-gray-700">Dinas</label>
                    <select id="kegiatan_dinas" name="dinas" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm p-2 text-sm @error('dinas') border-red-500 @enderror">
                        <option value="Pagi" {{ old('dinas', $activity->dinas) == 'Pagi' ? 'selected' : '' }}>Pagi</option>
                        <option value="Siang" {{ old('dinas', $activity->dinas) == 'Siang' ? 'selected' : '' }}>Siang</option>
                        <option value="Malam" {{ old('dinas', $activity->dinas) == 'Malam' ? 'selected' : '' }}>Malam</option>
                    </select>
                    @error('dinas') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                {{-- Tanggal --}}
                <div>
                    <label for="kegiatan_tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" id="kegiatan_tanggal" name="tanggal" required value="{{ old('tanggal', $activity->tanggal ? $activity->tanggal->format('Y-m-d') : '') }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm p-2 text-sm @error('tanggal') border-red-500 @enderror">
                    @error('tanggal') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                {{-- Waktu Mulai --}}
                <div>
                    <label for="kegiatan_waktu_mulai" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                    <input type="time" id="kegiatan_waktu_mulai" name="waktu_mulai" required value="{{ old('waktu_mulai', \Carbon\Carbon::parse($activity->waktu_mulai)->format('H:i')) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm p-2 text-sm @error('waktu_mulai') border-red-500 @enderror">
                    @error('waktu_mulai') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                {{-- Waktu Selesai --}}
                <div>
                    <label for="kegiatan_waktu_selesai" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                    <input type="time" id="kegiatan_waktu_selesai" name="waktu_selesai" required value="{{ old('waktu_selesai', \Carbon\Carbon::parse($activity->waktu_selesai)->format('H:i')) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm p-2 text-sm @error('waktu_selesai') border-red-500 @enderror">
                    @error('waktu_selesai') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                {{-- Alat --}}
                <div>
                    <label for="kegiatan_alat" class="block text-sm font-medium text-gray-700">Alat</label>
                    <input type="text" id="kegiatan_alat" name="alat" required value="{{ old('alat', $activity->alat) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm p-2 text-sm @error('alat') border-red-500 @enderror">
                    @error('alat') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Textarea Permasalahan --}}
            <div>
                <label for="kegiatan_permasalahan" class="block text-sm font-medium text-gray-700">Permasalahan</label>
                <textarea id="kegiatan_permasalahan" name="permasalahan" rows="3" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm p-2 text-sm @error('permasalahan') border-red-500 @enderror">{{ old('permasalahan', $activity->permasalahan) }}</textarea>
                @error('permasalahan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            {{-- Textarea Tindakan --}}
            <div>
                <label for="kegiatan_tindakan" class="block text-sm font-medium text-gray-700">Tindakan</label>
                <textarea id="kegiatan_tindakan" name="tindakan" rows="3" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm p-2 text-sm @error('tindakan') border-red-500 @enderror">{{ old('tindakan', $activity->tindakan) }}</textarea>
                @error('tindakan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            {{-- Textarea Hasil --}}
            <div>
                <label for="kegiatan_hasil" class="block text-sm font-medium text-gray-700">Hasil</label>
                <textarea id="kegiatan_hasil" name="hasil" rows="3" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm p-2 text-sm @error('hasil') border-red-500 @enderror">{{ old('hasil', $activity->hasil) }}</textarea>
                @error('hasil') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Baris Status & Waktu Terputus --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                {{-- Status --}}
                <div>
                    <label for="kegiatan_status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="kegiatan_status" name="status" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm p-2 text-sm @error('status') border-red-500 @enderror">
                        <option value="Selesai" {{ old('status', $activity->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Belum Selesai" {{ old('status', $activity->status) == 'Belum Selesai' ? 'selected' : '' }}>Belum Selesai</option>
                        <option value="Pending" {{ old('status', $activity->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                    @error('status') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                {{-- Waktu Terputus --}}
                <div>
                    <label for="kegiatan_waktu_terputus" class="block text-sm font-medium text-gray-700">Waktu Terputus</label>
                    <input type="text" id="kegiatan_waktu_terputus" name="waktu_terputus" value="{{ old('waktu_terputus', $activity->waktu_terputus) }}" placeholder="cth: 1 jam 15 mnt" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm p-2 text-sm @error('waktu_terputus') border-red-500 @enderror">
                    @error('waktu_terputus') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Teknisi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teknisi</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                    @for ($i = 0; $i < 6; $i++)
                        @php
                        $fieldName='teknisi.' . $i;
                        $selectedTeknisi=old($fieldName, (is_array($activity->teknisi) && isset($activity->teknisi[$i])) ? $activity->teknisi[$i] : null);
                        @endphp
                        <select name="teknisi[]" class="block w-full border-gray-300 rounded-lg shadow-sm p-2 text-sm @error($fieldName) border-red-500 @enderror">
                            <option value="">-- Pilih Teknisi {{ $i + 1 }} {{ $i > 2 ? '(Opsional)' : '' }} --</option>
                            @foreach ($allTeknisi as $namaTeknisi)
                            <option value="{{ $namaTeknisi }}" {{ $selectedTeknisi == $namaTeknisi ? 'selected' : '' }}>
                                {{ $namaTeknisi }}
                            </option>
                            @endforeach
                        </select>
                        @error($fieldName) <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        @endfor
                </div>
                @error('teknisi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Lampiran --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Lampiran</label>
                {{-- Container Utama: menampung preview lama, preview baru, dan tombol tambah --}}
                <div class="mt-2 flex flex-wrap gap-4 items-start">

                    {{-- 1. Tampilkan Lampiran Lama --}}
                    @if(is_array($activity->lampiran) && count(array_filter($activity->lampiran)) > 0)
                    @foreach(array_filter($activity->lampiran) as $lampiranPath)
                    <div class="relative group w-24 h-24 border rounded-lg overflow-hidden existing-lampiran-item">
                        {{-- Wrapper Link untuk klik (buka file/lightbox) --}}
                        @php
                        $isImage = Str::is(['*.jpg','*.jpeg','*.png','*.gif','*.bmp','*.svg','*.webp'], strtolower(basename($lampiranPath)));
                        $fileUrl = Storage::url($lampiranPath);
                        @endphp
                        <a href="{{ $fileUrl }}"
                            @if($isImage)
                            data-lightbox-url="{{ $fileUrl }}" {{-- Data URL untuk JS --}}
                            class="block w-full h-full cursor-pointer js-lightbox-trigger" {{-- Class penanda untuk JS --}}
                            @else
                            target="_blank" {{-- Buka di tab baru jika bukan gambar --}}
                            class="block w-full h-full"
                            @endif
                            title="Lihat: {{ basename($lampiranPath) }}">
                            {{-- Konten preview gambar/ikon file --}}
                            <div class="w-full h-full flex flex-col items-center justify-center bg-gray-100 text-gray-500 p-1 text-center">
                                @if($isImage)
                                <img src="{{ $fileUrl }}" alt="{{ basename($lampiranPath) }}" class="object-cover w-full h-full">
                                @else
                                <svg class="w-10 h-10 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-xs truncate px-1" title="{{ basename($lampiranPath) }}">
                                    {{ \Illuminate\Support\Str::limit(basename($lampiranPath), 15) }}
                                </span>
                                @endif
                            </div>
                        </a>
                        {{-- Checkbox Hapus (tetap absolute) --}}
                        <label class="absolute top-1 right-1 cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity z-10" title="Hapus lampiran ini">
                            <input type="checkbox" name="delete_lampiran[]" value="{{ $lampiranPath }}" class="sr-only peer/delete delete-lampiran-checkbox">
                            <span class="flex items-center justify-center w-5 h-5 bg-red-500 text-white rounded-full text-xs font-bold peer-checked/delete:bg-red-700">&times;</span>
                        </label>
                    </div>
                    @endforeach
                    @endif

                    {{-- 2. Area Preview File BARU --}}
                    <div id="file-preview-container" class="flex flex-wrap gap-4">
                        {{-- Preview file BARU akan muncul di sini (w-24 h-24) --}}
                    </div>

                    {{-- 3. Tombol/Area Tambah File (Selalu di paling kanan/akhir wrap) --}}
                    <label id="add-file-button-label" for="kegiatan_lampiran_input"
                        class="flex flex-col items-center justify-center w-24 h-24 {{-- Ukuran disamakan preview --}}
                                  border-2 border-gray-300 border-dashed rounded-lg
                                  cursor-pointer bg-gray-50
                                  hover:bg-gray-100 hover:border-indigo-400 order-last"> {{-- 'order-last' memaksa ke kanan --}}
                        <div class="flex flex-col items-center justify-center text-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="text-xs text-gray-500">Tambah file</p>
                        </div>
                        {{-- GANTI ACCEPT SESUAI VALIDASI --}}
                        <input id="kegiatan_lampiran_input" name="lampiran[]" type="file" class="sr-only" multiple
                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx">
                    </label>

                </div>
                {{-- Keterangan Tipe File --}}
                <p class="mt-1 text-xs text-gray-500">PNG, JPG, PDF, DOCX, XLSX. Total maks 5 file.</p>
                {{-- Error messages --}}
                @error('delete_lampiran.*') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                @error('lampiran.*') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                @error('lampiran') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>


            {{-- Tombol Aksi --}}
            <div class="flex justify-end items-center border-t pt-6 mt-6 space-x-2">
                {{-- GANTI ROUTE --}}
                <a href="{{ route('tfp.kegiatan') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Kembali
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Lightbox (jika belum ada di layout utama) --}}
{{-- GANTI ID/ARIA --}}
<div id="image-lightbox" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 hidden z-[60]" aria-labelledby="lightbox-title-tfp-kegiatan-edit" role="dialog" aria-modal="true">
    {{-- GANTI ALT --}}
    <img id="lightbox-image" src="" alt="Preview Lampiran TFP" class="max-w-full max-h-full object-contain">
    <button id="close-lightbox-btn" class="absolute top-4 right-4 text-white text-3xl font-bold" aria-label="Close lightbox">&times;</button>
    <p id="lightbox-title-tfp-kegiatan-edit" class="sr-only">Image Preview</p>
</div>
@endsection

@push('scripts')
{{--
====================================================================
SCRIPT DI BAWAH INI SAMA PERSIS DENGAN PUNYA CNSD.
TIDAK PERLU ADA YANG DIUBAH SAMA SEKALI.
====================================================================
--}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // === ELEMEN FORM & FILE INPUT ===
        const fileInput = document.getElementById('kegiatan_lampiran_input'); // Input file BARU
        const previewContainer = document.getElementById('file-preview-container'); // Area preview file BARU
        let currentFiles = []; // Array untuk file BARU yang dipilih

        // === ELEMEN & FUNGSI LIGHTBOX ===
        const imageLightbox = document.getElementById('image-lightbox'); // ID Lightbox
        const lightboxImage = document.getElementById('lightbox-image'); // IMG di dalam Lightbox
        const closeLightboxBtn = document.getElementById('close-lightbox-btn'); // Tombol close Lightbox

        /**
         * Menampilkan lightbox dengan gambar yang diklik.
         * @param {string} imageUrl URL gambar yang akan ditampilkan.
         */
        function showLightbox(imageUrl) {
            if (imageLightbox && lightboxImage) {
                if (imageUrl && typeof imageUrl === 'string') {
                    lightboxImage.src = imageUrl;
                    imageLightbox.classList.remove('hidden');
                } else {
                    console.error('URL gambar tidak valid untuk lightbox:', imageUrl);
                }
            }
        }

        /**
         * Menutup lightbox.
         */
        function closeLightbox() {
            if (imageLightbox) {
                imageLightbox.classList.add('hidden');
                if (lightboxImage) lightboxImage.src = ''; // Kosongkan src saat ditutup
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
        // --- Akhir Bagian Lightbox ---


        // === EVENT LISTENER UNTUK LAMPIRAN LAMA (PREVIEW) ===
        // Kode ini nyari semua link gambar lama yg kita kasih class tadi
        const existingLampiranLinks = document.querySelectorAll('.js-lightbox-trigger');

        // Looping semua link yg ketemu
        existingLampiranLinks.forEach(link => {

            // Tempelin event 'click' ke masing-masing link
            link.addEventListener('click', function(event) {
                event.preventDefault(); // Stop biar browser nggak buka link-nya

                // Ambil URL yg tadi kita simpen di 'data-lightbox-url'
                const imageUrl = this.dataset.lightboxUrl;

                // Panggil fungsi showLightbox (yg lokal) pake URL tadi
                if (imageUrl && typeof showLightbox === 'function') {
                    showLightbox(imageUrl);
                }
            });
        });
        // --- Akhir Event Listener Lampiran Lama ---


        // === FUNGSI UPDATE FILE INPUT ASLI ===
        // Memastikan file di <input type="file"> sesuai dengan array currentFiles
        const updateFileInput = () => {
            const dataTransfer = new DataTransfer();
            currentFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
            if (fileInput) fileInput.files = dataTransfer.files;
        };

        // === FUNGSI HANDLE FILE BARU (PREVIEW, VALIDASI, DELETE) ===
        function handleFiles() {
            // Tipe file yang diizinkan dan ukuran maksimal
            const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            const maxSize = 5 * 1024 * 1024; // 5MB

            if (!previewContainer || !fileInput || !fileInput.files) return;

            previewContainer.innerHTML = ''; // Kosongkan preview file BARU
            currentFiles = []; // Kosongkan array file BARU

            const files = Array.from(fileInput.files);

            // Hitung lampiran lama yang TIDAK dicentang hapus
            const existingLampiranCheckboxes = document.querySelectorAll('.delete-lampiran-checkbox');
            let existingKeptCount = 0;
            existingLampiranCheckboxes.forEach(checkbox => {
                if (!checkbox.checked) {
                    existingKeptCount++;
                }
            });

            const maxNewFiles = 5 - existingKeptCount; // Maksimal 5 total
            const filesToProcess = files.slice(0, Math.max(0, maxNewFiles));

            // Beri peringatan jika user memilih lebih dari batas
            if (files.length > filesToProcess.length) {
                alert(`Anda hanya bisa menambahkan ${Math.max(0, maxNewFiles)} lampiran baru (total maks 5). File berlebih akan diabaikan.`);
                // Potong file di input asli agar sesuai batas
                const limitedFiles = files.slice(0, Math.max(0, maxNewFiles));
                const dataTransfer = new DataTransfer();
                limitedFiles.forEach(file => dataTransfer.items.add(file));
                if (fileInput) fileInput.files = dataTransfer.files;
                // Panggil handleFiles lagi rekursif untuk render ulang preview yang valid
                setTimeout(handleFiles, 0);
                return;
            } else if (maxNewFiles < 0 && files.length > 0) {
                alert('Jumlah lampiran sudah mencapai batas maksimal (5). Hapus lampiran lama jika ingin menambah baru.');
                if (fileInput) fileInput.value = ''; // Kosongkan input file baru
                return;
            }

            // Proses file baru yang valid
            filesToProcess.forEach((file) => {
                // Double check validasi
                if (!allowedTypes.includes(file.type) || file.size > maxSize) {
                    console.warn(`File baru dilewati (tipe/ukuran salah): ${file.name}`);
                    return;
                }

                currentFiles.push(file); // Tambahkan ke array file BARU
                const fileIndex = currentFiles.length - 1;

                // Buat elemen preview
                const previewWrapper = document.createElement('div');
                previewWrapper.classList.add('relative', 'group', 'w-24', 'h-24', 'border', 'rounded-lg', 'overflow-hidden');
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
                        if (typeof showLightbox === 'function') { // Panggil lightbox jika ada
                            img.onclick = () => showLightbox(e.target.result);
                        }
                        previewContent.innerHTML = '';
                        previewContent.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Jika bukan gambar (ikon file)
                    previewContent.innerHTML = `<svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg><span class="absolute bottom-1 left-1 right-1 text-xs text-center text-gray-600 bg-white bg-opacity-75 truncate px-1" title="${file.name}">${file.name}</span>`;
                    previewContent.classList.add('relative');
                }

                // Tombol Hapus untuk file BARU
                const deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.innerHTML = '&times;';
                deleteButton.classList.add('absolute', 'top-1', 'right-1', 'bg-red-500', 'text-white', 'rounded-full', 'w-5', 'h-5', 'flex', 'items-center', 'justify-center', 'text-xs', 'font-bold', 'opacity-0', 'group-hover:opacity-100', 'transition-opacity', 'z-10');
                deleteButton.dataset.index = fileIndex; // Index di array currentFiles
                deleteButton.onclick = function() {
                    const indexToRemove = parseInt(this.dataset.index);
                    currentFiles.splice(indexToRemove, 1); // Hapus dari array file BARU
                    updateFileInput(); // Update input asli
                    updateDeleteButtonIndices(); // Update index tombol hapus lain di preview BARU
                    this.closest('.relative').remove(); // Hapus preview BARU
                };

                previewWrapper.appendChild(previewContent);
                previewWrapper.appendChild(deleteButton);
                previewContainer.appendChild(previewWrapper);
            });
            updateFileInput(); // Update input asli setelah loop selesai
        }

        // === FUNGSI UPDATE INDEX TOMBOL HAPUS (FILE BARU) ===
        function updateDeleteButtonIndices() {
            if (!previewContainer) return;
            const deleteButtons = previewContainer.querySelectorAll('button[data-index]');
            deleteButtons.forEach((button, newIndex) => {
                button.dataset.index = newIndex;
            });
        }

        // === EVENT LISTENERS ===
        // Listener untuk input file baru
        if (fileInput && previewContainer) {
            fileInput.addEventListener('change', handleFiles);
            // Tambahkan Drag n Drop listener jika perlu
            const dropArea = document.getElementById('add-file-button-label'); // Sesuaikan ID jika beda
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

        // Listener untuk checkbox hapus file LAMA
        const deleteCheckboxes = document.querySelectorAll('.delete-lampiran-checkbox');
        deleteCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                // Saat checkbox berubah, panggil handleFiles lagi untuk revalidasi batas file BARU
                if (fileInput && fileInput.files.length > 0) {
                    handleFiles(); // Re-trigger validasi & preview file baru
                }
                // Efek visual untuk item lampiran lama
                const item = checkbox.closest('.existing-lampiran-item');
                if (item) {
                    item.classList.toggle('opacity-50', checkbox.checked); // Buat item jadi redup jika dicentang
                    item.classList.toggle('ring-2', checkbox.checked); // Tambah ring merah
                    item.classList.toggle('ring-red-500', checkbox.checked);
                }
            });
        });

        // Optional: Reset file input value saat halaman load ulang (jika ada error validasi)
        if (fileInput) {
            fileInput.value = '';
        }

    });
</script>
@endpush