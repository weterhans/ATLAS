@extends('layouts.main_dashboard')

@section('content')

{{--
  CSS Kustom untuk halaman Data Personal.
--}}
<style>
    /* ... (CSS Anda sebelumnya) ... */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    .main-container {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
        max-width: 1400px;
        margin: 0 auto;
    }
    .header {
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #e5e7eb;
    }
    .header-title-container {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .back-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: none;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 50%;
        transition: background-color 0.2s;
    }
    .back-button:hover {
        background-color: #f3f4f6;
    }
    .header h1 {
        font-size: 24px;
        font-weight: 600;
    }
    .btn {
        padding: 0.6rem 1.2rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem; /* Jarak antara ikon dan teks */
    }
    .btn-primary {
        background: #1daa1d;
        color: white;
    }
    .btn-primary:hover {
        background: #059669;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4);
    }
    .btn-info {
        background-color: #3498db;
        color: white;
    }
    .btn-info:hover {
        background-color: #2980b9;
    }
    .btn-danger {
        background-color: #e74c3c;
        color: white;
        width: 30px;
        height: 30px;
        font-size: 16px;
        line-height: 1;
        padding: 0; /* Pastikan padding tidak merusak ukuran */
    }
    .btn-danger:hover {
        background-color: #c0392b;
    }
    .btn-secondary {
        background-color: #f1f1f1;
        color: #555;
    }
    .btn-secondary:hover {
        background-color: #e0e0e0;
    }

    /* MODIFIKASI: Tombol konfirmasi hapus (agar tidak bentrok dengan ikon) */
    .btn-danger-confirm {
        background-color: #e74c3c;
        color: white;
    }
    .btn-danger-confirm:hover {
        background-color: #c0392b;
    }

    /* Data Table */
    .data-section {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
    }
    .table-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .search-box {
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        width: 250px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    thead {
        background: #f8f9fa;
    }
    th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #555;
        border-bottom: 2px solid #ddd;
        font-size: 13px;
    }
    td {
        padding: 1rem;
        border-bottom: 1px solid #eee;
        font-size: 13px;
    }
    td.actions-cell {
        display: flex;
        gap: 8px; /* Jarak antar tombol */
    }
    tbody tr:last-child td {
        border-bottom: none;
    }
    tbody tr:hover {
        background: #f8f9fa;
    }
    .action-btn {
        background: #3498db;
        color: white;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        padding: 0;
    }
    .action-btn:hover {
        background: #2980b9;
    }
    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #eee;
    }
    .pagination {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .page-btn {
        padding: 0.4rem 0.8rem;
        border: 1px solid #ddd;
        background: white;
        cursor: pointer;
        border-radius: 5px;
        transition: all 0.2s;
    }
    .page-btn.active {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }
    .page-btn:hover:not(.active) {
        background: #f0f0f0;
    }
    .entry-info {
        font-size: 13px;
        color: #666;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 1000;
        align-items: flex-start; /* Align to top */
        justify-content: center;
        padding-top: 5vh; /* Margin from top */
        overflow-y: auto;
    }
    .modal.active {
        display: flex;
    }
    .modal-content {
        background: white;
        border-radius: 10px;
        padding: 2rem;
        max-width: 1200px;
        width: 90%;
        position: relative;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .modal-content.modal-sm {
        max-width: 600px;
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }
    .modal-header h2, .modal-header h3 {
        font-size: 20px;
        color: #333;
    }
    .close-btn {
        background: #e74c3c;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
    }
    .close-btn:hover {
        background: #c0392b;
    }
    .close-btn.icon-close {
        background: none;
        color: #888;
        font-size: 24px;
        padding: 0;
        width: 30px;
        height: 30px;
        line-height: 30px;
        text-align: center;
    }
    .close-btn.icon-close:hover {
        background: #f1f1f1;
    }

    .work-order-sections {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 2rem;
    }
    .section {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }
    .section h3 {
        font-size: 16px;
        color: #555;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #ddd;
    }
    .info-row {
        display: grid;
        grid-template-columns: 120px 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
        align-items: center;
    }
    .info-row.align-start {
        align-items: start;
    }
    .info-label {
        font-weight: 600;
        color: #555;
        font-size: 13px;
        padding-top: 0.5rem; /* Menambahkan padding agar sejajar */
    }
    .info-value {
        color: #333;
        font-size: 13px;
        background: white;
        padding: 0.5rem 0.75rem;
        border-radius: 5px;
        border: 1px solid #ddd;
    }
    .info-value select, .info-value input, .info-value textarea {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 3px;
        background: white;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .info-value.no-padding {
        padding: 0;
        border: none;
        background: none;
    }
    .info-value .btn { font-size: 12px; padding: 5px 15px; }
    .work-order-table-section {
        grid-column: 1 / -1;
    }
    .simpan-btn {
        float: right;
    }

    /* Style untuk Modal Detail */
    .modal-detail {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.75); /* Lebih gelap */
        z-index: 1050; /* Di atas modal pertama */
        align-items: center;
        justify-content: center;
    }
    .modal-detail.active {
        display: flex;
    }
    .modal-detail-content {
        background: white;
        border-radius: 10px;
        padding: 2rem;
        max-width: 600px;
        width: 90%;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .modal-detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
    }
    .modal-detail-header h3 {
        font-size: 20px;
        font-weight: 600;
    }
    .modal-detail-body .detail-item {
        margin-bottom: 1rem;
    }
    .modal-detail-body .detail-label {
        font-size: 12px;
        color: #666;
        font-weight: 600;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
    }
    .modal-detail-body .detail-value {
        font-size: 16px;
        color: #333;
        background: #f8f9fa;
        padding: 0.75rem;
        border-radius: 5px;
        border: 1px solid #e5e7eb;
        white-space: pre-wrap; /* Agar deskripsi panjang bisa wrap */
        word-wrap: break-word;
    }

    /* MODIFIKASI: Style untuk Pop-up Toast (dipindahkan ke tengah) */
    .toast {
        display: none;
        position: fixed;
        top: 50%; /* Pindah ke tengah */
        left: 50%; /* Pindah ke tengah */
        transform: translate(-50%, -50%); /* Centering */
        background-color: #2ecc71; /* Hijau sukses */
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 5px;
        z-index: 2000;
        font-size: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Konten HTML dari personal.html --}}
<div class="p-6 md:p-8">

    <div class="flex items-center mb-6 justify-between items-center">
         <div class="flex items-center">
            <a href="{{ route('dashboard') }}" class="p-2 rounded-md hover:bg-gray-200" aria-label="Kembali ke Dashboard">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 ml-4">Data Personal</h1>
        </div>
         <div class="flex items-center gap-4">
            <a href="#" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2 7.5C2 10.5376 4.46243 13 7.5 13C9.07394 13 10.51 12.3524 11.553 11.3093L11.9999 11.7563V10H10.2436L10.6906 10.447C9.88335 11.2543 8.75139 11.75 7.5 11.75C5.13629 11.75 3.25 9.86371 3.25 7.5C3.25 5.13629 5.13629 3.25 7.5 3.25C8.56586 3.25 9.54131 3.63321 10.2854 4.28542L9.20703 5.36377L12.0355 5.64219L12.3139 2.81377L11.2355 3.89219C10.2816 3.04285 9.00122 2.5 7.5 2.5C4.46243 2.5 2 4.96243 2 7.5ZM13.1862 9.68615L10.3578 9.40773L9.27942 10.4861C8.53533 9.83391 7.55987 9.45071 6.5 9.45071C5.24861 9.45071 4.11665 9.94563 3.30938 10.753L3.75635 10.306V12H5.5127L5.06573 11.553C6.01957 12.4024 7.29994 12.9507 8.81377 12.9507C8.95319 12.9507 9.09131 12.9436 9.22784 12.9301L8.91421 13.2437L10.0253 14.3548L11.1364 13.2437L10.0253 12.1326L8.53552 10.6429L9.64663 9.53176L10.7577 10.6429L11.8688 9.53176L13.1862 9.68615Z"/>
                </svg>
                <span>Sinkronisasi Data</span>
            </a>
            <button class="btn btn-info" id="openAddStaffBtn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path></svg>
                <span>Tambah Staf</span>
            </button>
         </div>
    </div>

    <div class="data-section">
        <div class="table-controls">
            <div>
                <label class="text-sm text-gray-700">Show
                    <select id="entriesSelect" class="mx-1 pl-2 pr-8 py-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity:50">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    entries
                </label>
            </div>
            <input type="text" class="search-box" placeholder="Search..." id="searchInput">
        </div>

        <table id="dataTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Kelamin</th>
                    <th>Jabatan</th>
                    <th>Level Jabatan</th>
                    <th>Lokasi</th>
                    <th>Lokasi Induk</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                </tbody>
        </table>

        <div class="table-footer">
             <div class="entry-info" id="mainEntryInfo"></div>
             <div class="pagination" id="mainPagination">
                </div>
        </div>
    </div>
</div>

<div id="workOrderModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Data Work Order Personil : <span id="modalPersonName">Nama Personil</span></h2>
            <button class="close-btn" onclick="closeModal()">✕</button>
            <input type="hidden" id="modalPersonalId">
        </div>

        <div class="work-order-sections">
            <div class="section">
                <h3>Data Personal</h3>
                <div class="info-row">
                    <div class="info-label">Pernium</div>
                    <div class="info-value" id="modalPernium"></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Nama</div>
                    <div class="info-value" id="modalNama"></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Jabatan</div>
                    <div class="info-value" id="modalJabatan"></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Level Jabatan</div>
                    <div class="info-value" id="modalLevel"></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Lokasi</div>
                    <div class="info-value" id="modalLokasi"></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Lokasi Induk</div>
                    <div class="info-value" id="modalLokasiInduk"></div>
                </div>
            </div>

            <div class="section">
                <h3>Tambah Work Order</h3>
                 <div class="info-row">
                    <div class="info-label">Tanggal</div>
                    <div class="info-value no-padding">
                        <input type="date" id="woTanggal">
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Kategori</div>
                    <div class="info-value no-padding">
                        <select id="woKategori">
                            <option value="">--- Kosongkan ---</option>
                            <option value="Communication">Communication</option>
                            <option value="Navigation">Navigation</option>
                            <option value="Surveillance">Surveillance</option>
                            <option value="Automation">Automation</option>
                            <option value="Data Processing">Data Processing</option>
                        </select>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Jenis Peralatan</div>
                    <div class="info-value no-padding">
                        <input type="text" placeholder="Pilih Jenis Peralatan" id="woJenis">
                    </div>
                </div>
                <div class="info-row align-start">
                    <div class="info-label">Deskripsi</div>
                    <div class="info-value no-padding">
                        <textarea id="woDeskripsi" rows="3" placeholder="Deskripsi singkat pekerjaan..."></textarea>
                    </div>
                </div>
                <button class="btn btn-primary simpan-btn" id="simpanWoBtn">Simpan</button>
            </div>

            <div class="section work-order-table-section">
                <h3>Daftar Work Order [Existing]</h3>
                <div class="table-controls">
                    <div>
                        <label class="text-sm text-gray-700">Show
                            <select id="woEntriesSelect" class="mx-1 pl-2 pr-8 py-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity:50">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                            </select>
                            entries
                        </label>
                    </div>
                    <input type="text" class="search-box" placeholder="Search..." id="woSearchInput">
                </div>
                <table id="woDataTable" style="margin-top: 1rem;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Fasilitas</th>
                            <th>Jenis</th>
                            <th>Deskripsi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="woTableBody">
                    </tbody>
                </table>
                <div class="table-footer">
                    <div class="entry-info" id="woEntryInfo"></div>
                    <div class="pagination" id="woPagination">
                    </div>
               </div>
            </div>
        </div>
    </div>
</div>

<div id="workOrderDetailModal" class="modal-detail">
    <div class="modal-detail-content">
        <div class="modal-detail-header">
            <h3>Detail Work Order</h3>
            <button class="close-btn icon-close" onclick="closeDetailModal()">✕</button>
        </div>
        <div class="modal-detail-body">
            <div class="detail-item">
                <div class="detail-label">Tanggal</div>
                <div class="detail-value" id="detailTanggal"></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Fasilitas / Kategori</div>
                <div class="detail-value" id="detailKategori"></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Jenis Peralatan</div>
                <div class="detail-value" id="detailJenis"></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Deskripsi</div>
                <div class="detail-value" id="detailDeskripsi"></div>
            </div>
        </div>
    </div>
</div>

<div id="addStaffModal" class="modal">
    <div class="modal-content modal-sm">
        <div class="modal-header">
            <h3>Tambah Staf Personal Baru</h3>
            <button class="close-btn icon-close" onclick="closeAddStaffModal()">✕</button>
        </div>

        <div class="section" style="background: white; border: none; padding: 0;">
            <div class="info-row">
                <div class="info-label">NIK</div>
                <div class="info-value no-padding">
                    <input type="text" id="staffNik" placeholder="Nomor Induk Karyawan">
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Nama</div>
                <div class="info-value no-padding">
                    <input type="text" id="staffNama" placeholder="Nama Lengkap">
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Kelamin</div>
                <div class="info-value no-padding">
                    <select id="staffKelamin">
                        <option value="L">Laki-laki (L)</option>
                        <option value="P">Perempuan (P)</option>
                    </select>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Jabatan</div>
                <div class="info-value no-padding">
                    <input type="text" id="staffJabatan" placeholder="Nama Jabatan">
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Level Jabatan</div>
                <div class="info-value no-padding">
                    <input type="text" id="staffLevel" placeholder="15">
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Lokasi</div>
                <div class="info-value no-padding">
                    <input type="text" id="staffLokasi" value="Cabang Surabaya">
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Lokasi Induk</div>
                <div class="info-value no-padding">
                    <input type="text" id="staffLokasiInduk" value="Surabaya">
                </div>
            </div>
            <button class="btn btn-primary simpan-btn" id="simpanStafBtn">Simpan</button>
        </div>
    </div>
</div>

<div id="toast-notification" class="toast">
    <span id="toast-message"></span>
</div>

<div id="deleteConfirmModal" class="modal-detail" style="z-index: 1100;">
    <div class="modal-detail-content" style="max-width: 450px;">
        <div class="modal-detail-header" style="border-bottom: none; margin-bottom: 0.5rem;">
            <h3 id="deleteConfirmTitle">Konfirmasi Hapus Data</h3>
            {{-- MODIFIKASI: Tombol 'X' di modal hapus dihilangkan --}}
            {{-- <button class="close-btn icon-close" onclick="closeDeleteConfirm()">✕</button> --}}
        </div>
        <div class="modal-detail-body">
            <p style="margin-bottom: 0.5rem; font-size: 16px;">Anda yakin ingin menghapus data:</p>
            <p id="deleteConfirmMessage" style="font-weight: 600; margin-bottom: 1rem; font-size: 16px;"></p>
            <p style="color: #e74c3c; font-size: 14px; margin-bottom: 1.5rem;">Tindakan ini tidak dapat dibatalkan.</p>
            <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                <button class="btn btn-secondary" style="width: auto;" onclick="closeDeleteConfirm()">Batal</button>
                {{-- MODIFIKASI: Class diubah dari btn-danger ke btn-danger-confirm --}}
                <button class="btn btn-danger-confirm" id="confirmDeleteBtn" style="width: auto;">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>


{{--
  JavaScript Kustom untuk halaman Data Personal.
--}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    // =========================================================================
    // SCRIPT NOTIFIKASI & KONFIRMASI
    // =========================================================================

    // --- Pop-up Toast Notifikasi ---
    let toastTimeout;
    window.showToast = (message) => {
        const toast = document.getElementById('toast-notification');
        const messageEl = document.getElementById('toast-message');

        messageEl.textContent = message;
        toast.style.display = 'block';

        if (toastTimeout) {
            clearTimeout(toastTimeout);
        }
        toastTimeout = setTimeout(() => {
            toast.style.display = 'none';
        }, 3000);
    }

    // --- Pop-up Konfirmasi Hapus ---
    let deleteCallback = null;
    const deleteConfirmModal = document.getElementById('deleteConfirmModal');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const deleteConfirmMessage = document.getElementById('deleteConfirmMessage');

    window.openDeleteConfirm = (message, callback) => {
        deleteConfirmMessage.textContent = message;
        deleteCallback = callback;
        deleteConfirmModal.classList.add('active');
    }

    window.closeDeleteConfirm = () => {
        deleteConfirmModal.classList.remove('active');
        deleteCallback = null;
    }

    confirmDeleteBtn.addEventListener('click', () => {
        if (deleteCallback) {
            deleteCallback();
        }
        closeDeleteConfirm();
    });


    // =========================================================================
    // SCRIPT UTAMA (DATA PERSONAL)
    // =========================================================================

    let allData = @json($personals);
    let currentPage = 1;
    let entriesPerPage = 10;
    let filteredData = [...allData];

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Fungsi untuk membuka modal WO
    window.openModal = async (personalId, nik, nama, jabatan, level) => {
        const modal = document.getElementById('workOrderModal');

        document.getElementById('modalPersonName').textContent = nama;
        document.getElementById('modalPernium').textContent = nik;
        document.getElementById('modalNama').textContent = nama;
        document.getElementById('modalJabatan').textContent = jabatan;
        document.getElementById('modalLevel').textContent = level;
        document.getElementById('modalLokasi').textContent = 'Cabang Surabaya';
        document.getElementById('modalLokasiInduk').textContent = 'Surabaya';
        document.getElementById('modalPersonalId').value = personalId;

        modal.classList.add('active');

        // Set tanggal hari ini saat modal WO dibuka
        setTodayDateForWorkOrder();

        try {
            const response = await fetch(`/personal/${personalId}/workorders`);
            const data = await response.json();
            workOrderData = data;
            filteredWoData = data;
            currentWoPage = 1;
            renderWorkOrderTable();
        } catch (error) {
            console.error('Gagal mengambil data Work Order:', error);
            document.getElementById('woTableBody').innerHTML = `<tr><td colspan="6" class="text-center text-red-500">Gagal memuat data</td></tr>`;
        }
    }

    // Fungsi untuk menutup modal WO
    window.closeModal = () => {
        document.getElementById('workOrderModal').classList.remove('active');
        workOrderData = [];
        filteredWoData = [];
        currentWoPage = 1;
        document.getElementById('woSearchInput').value = '';
    }

    // Menutup modal saat mengklik di luar area konten modal
    window.onclick = function(event) {
        const modal = document.getElementById('workOrderModal');
        const detailModal = document.getElementById('workOrderDetailModal');
        const addStaffModal = document.getElementById('addStaffModal');
        const deleteModal = document.getElementById('deleteConfirmModal');

        if (event.target === modal) closeModal();
        if (event.target === detailModal) closeDetailModal();
        if (event.target === addStaffModal) closeAddStaffModal();
        if (event.target === deleteModal) closeDeleteConfirm();
    }

    // Fungsi untuk merender ulang tabel UTAMA
    const renderTable = () => {
        const tableBody = document.getElementById('tableBody');
        if (!tableBody) return;

        filteredData.sort((a, b) => b.level_jabatan - a.level_jabatan);

        const start = (currentPage - 1) * entriesPerPage;
        const end = start + entriesPerPage;
        const pageData = filteredData.slice(start, end);

        tableBody.innerHTML = '';
        pageData.forEach((row, index) => {
            const tr = document.createElement('tr');

            const safeNama = row.nama.replace(/'/g, "\\'");
            const safeJabatan = row.jabatan.replace(/'/g, "\\'");

            tr.innerHTML = `
                <td>${start + index + 1}</td>
                <td>${row.nik}</td>
                <td>${row.nama}</td>
                <td>${row.kelamin}</td>
                <td>${row.jabatan}</td>
                <td>${row.level_jabatan}</td>
                <td>${row.lokasi}</td>
                <td>${row.lokasi_induk}</td>
                <td class="actions-cell">
                    <button class="action-btn" onclick="openModal(${row.id}, '${row.nik}', '${safeNama}', '${safeJabatan}', '${row.level_jabatan}')" title="Lihat Work Order">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"></path></svg>
                    </button>
                    <button class="btn btn-danger" onclick="deleteStaff(${row.id}, '${safeNama}')" title="Hapus Staf">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path></svg>
                    </button>
                </td>
            `;
            tableBody.appendChild(tr);
        });

        updatePagination();
        updateEntryInfo();
    }

    // Paginasi UTAMA
    const updatePagination = () => {
        const paginationDiv = document.getElementById('mainPagination');
        if (!paginationDiv) return;
        const totalPages = Math.ceil(filteredData.length / entriesPerPage);

        let paginationHTML = `<button class="page-btn" onclick="changePage('prev')">Previous</button>`;
        for (let i = 1; i <= totalPages; i++) {
            paginationHTML += `<button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
        }
        paginationHTML += `<button class="page-btn" onclick="changePage('next')">Next</button>`;
        paginationDiv.innerHTML = paginationHTML;
    }

    // Info Entri UTAMA
    const updateEntryInfo = () => {
        const entryInfo = document.getElementById('mainEntryInfo');
        if (!entryInfo) return;
        const start = filteredData.length > 0 ? (currentPage - 1) * entriesPerPage + 1 : 0;
        const end = Math.min(start + entriesPerPage - 1, filteredData.length);
        entryInfo.textContent = `Showing ${start} to ${end} of ${filteredData.length} entries`;
    }

    // Ganti Halaman UTAMA
    window.changePage = (page) => {
        const totalPages = Math.ceil(filteredData.length / entriesPerPage);
        if (page === 'prev') {
            if (currentPage > 1) currentPage--;
        } else if (page === 'next') {
            if (currentPage < totalPages) currentPage++;
        } else {
            currentPage = page;
        }
        renderTable();
    }

    // Event listener 'Show entries' UTAMA
    const entriesSelect = document.getElementById('entriesSelect');
    if (entriesSelect) {
        entriesSelect.addEventListener('change', function() {
            entriesPerPage = parseInt(this.value);
            currentPage = 1;
            renderTable();
        });
    }

    // Fungsionalitas pencarian UTAMA
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            filteredData = allData.filter(row => {
                const nik = String(row.nik).toLowerCase();
                const nama = String(row.nama).toLowerCase();
                const jabatan = String(row.jabatan).toLowerCase();
                const level = String(row.level_jabatan).toLowerCase();

                return nik.includes(searchTerm) ||
                       nama.includes(searchTerm) ||
                       jabatan.includes(searchTerm) ||
                       level.includes(searchTerm);
            });
            currentPage = 1;
            renderTable();
        });
    }

    // Render tabel utama saat pertama kali halaman dimuat
    renderTable();

    // =========================================================================
    // SCRIPT TAMBAH/HAPUS STAF (AJAX)
    // =========================================================================

    window.openAddStaffModal = () => {
        document.getElementById('addStaffModal').classList.add('active');
        document.getElementById('staffNik').focus();
    }

    window.closeAddStaffModal = () => {
        document.getElementById('addStaffModal').classList.remove('active');
        document.getElementById('staffNik').value = '';
        document.getElementById('staffNama').value = '';
        document.getElementById('staffKelamin').value = 'L';
        document.getElementById('staffJabatan').value = '';
        document.getElementById('staffLevel').value = '';
    }

    document.getElementById('openAddStaffBtn').addEventListener('click', openAddStaffModal);

    document.getElementById('simpanStafBtn').addEventListener('click', async () => {
        const newData = {
            nik: document.getElementById('staffNik').value,
            nama: document.getElementById('staffNama').value,
            kelamin: document.getElementById('staffKelamin').value,
            jabatan: document.getElementById('staffJabatan').value,
            level_jabatan: document.getElementById('staffLevel').value,
            lokasi: document.getElementById('staffLokasi').value,
            lokasi_induk: document.getElementById('staffLokasiInduk').value,
        };

        if (!newData.nik || !newData.nama || !newData.jabatan || !newData.level_jabatan) {
            alert('NIK, Nama, Jabatan, dan Level Jabatan tidak boleh kosong!');
            return;
        }

        try {
            const response = await fetch('{{ route("personal.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(newData)
            });

            if (!response.ok) {
                const errorData = await response.json();
                const errorMessages = Object.values(errorData.errors).join('\n');
                throw new Error(errorMessages);
            }

            const addedStaff = await response.json();
            allData.push(addedStaff);

            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            filteredData = allData.filter(row => {
                return Object.values(row).some(val =>
                    String(val).toLowerCase().includes(searchTerm)
                );
            });

            renderTable();
            closeAddStaffModal();
            showToast('Staf baru berhasil ditambahkan!');

        } catch (error) {
            console.error('Gagal menambah staf:', error);
            alert('Gagal menambah staf:\n' + error.message);
        }
    });

    // Fungsi deleteStaff diubah untuk memanggil modal konfirmasi
    window.deleteStaff = (id, nama) => {
        openDeleteConfirm(`Staf: ${nama}?`, async () => {
            try {
                const response = await fetch(`/personal/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });
                if (!response.ok) throw new Error('Gagal menghapus data.');

                allData = allData.filter(s => s.id !== id);
                filteredData = filteredData.filter(s => s.id !== id);
                if (filteredData.length <= (currentPage - 1) * entriesPerPage && currentPage > 1) {
                    currentPage--;
                }
                renderTable();
                showToast('Staf berhasil dihapus.');
            } catch (error) {
                console.error('Gagal menghapus staf:', error);
                alert('Gagal menghapus staf.');
            }
        });
    }

    // Navigasi 'Enter' di Modal Tambah Staf
    const staffModal = document.getElementById('addStaffModal');
    const focusableInputs = Array.from(
        staffModal.querySelectorAll('input, select')
    );
    focusableInputs.forEach((input, index) => {
        input.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                const nextInput = focusableInputs[index + 1];
                if (nextInput) {
                    nextInput.focus();
                } else {
                    document.getElementById('simpanStafBtn').click();
                }
            }
        });
    });


    // =========================================================================
    // SCRIPT TABEL MODAL (WORK ORDER) (AJAX)
    // =========================================================================

    // Helper untuk dapatkan tanggal YYYY-MM-DD
    const getTodayYYYYMMDD = () => {
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0'); // Bulan 0-indexed
        const dd = String(today.getDate()).padStart(2, '0');
        return `${yyyy}-${mm}-${dd}`;
    };

    // Fungsi untuk set tanggal WO ke hari ini
    const setTodayDateForWorkOrder = () => {
        const tanggalInput = document.getElementById('woTanggal');
        if (tanggalInput) {
            tanggalInput.value = getTodayYYYYMMDD();
        }
    };

    let workOrderData = [];
    let filteredWoData = [];
    let currentWoPage = 1;
    let entriesPerWoPage = 5;

    window.renderWorkOrderTable = () => {
        const tableBody = document.getElementById('woTableBody');
        if (!tableBody) return;

        let dataToRender = [...filteredWoData];
        dataToRender.sort((a, b) => new Date(b.tanggal) - new Date(a.tanggal));

        const start = (currentWoPage - 1) * entriesPerWoPage;
        const end = start + entriesPerWoPage;
        const pageData = dataToRender.slice(start, end);

        tableBody.innerHTML = '';
        pageData.forEach((row, index) => {
            const tr = document.createElement('tr');
            const deskripsiSingkat = (row.deskripsi && row.deskripsi.length > 30) ? row.deskripsi.substring(0, 30) + '...' : (row.deskripsi || '');

            tr.innerHTML = `
                <td>${start + index + 1}</td>
                <td>${row.tanggal}</td>
                <td>${row.fasilitas}</td>
                <td>${row.jenis}</td>
                <td title="${row.deskripsi || ''}">${deskripsiSingkat}</td>
                <td class="actions-cell">
                    <button class="btn action-btn" onclick="openDetailModal(${row.id})" title="Lihat Detail">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"></path></svg>
                    </button>
                    <button class="btn btn-danger" onclick="deleteWorkOrder(${row.id}, '${row.jenis}')" title="Hapus">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path></svg>
                    </button>
                </td>
            `;
            tableBody.appendChild(tr);
        });

        updateWoPagination(dataToRender.length);
        updateWoEntryInfo(dataToRender.length);
    }

    // Fungsi Hapus WO diubah untuk memanggil modal konfirmasi
    window.deleteWorkOrder = (id, jenis) => {
        openDeleteConfirm(`Work Order: ${jenis}?`, async () => {
            try {
                const response = await fetch(`/workorders/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });
                if (!response.ok) throw new Error('Gagal menghapus WO.');

                workOrderData = workOrderData.filter(item => item.id !== id);
                filteredWoData = filteredWoData.filter(item => item.id !== id);
                if (filteredWoData.length <= (currentWoPage - 1) * entriesPerWoPage && currentWoPage > 1) {
                    currentWoPage--;
                }
                renderWorkOrderTable();
                showToast('Work order berhasil dihapus.');
            } catch (error) {
                console.error('Gagal menghapus WO:', error);
                alert('Gagal menghapus WO.');
            }
        });
    }

    // Paginasi WO
    const updateWoPagination = (totalFilteredItems) => {
        const paginationDiv = document.getElementById('woPagination');
        if (!paginationDiv) return;
        const totalPages = Math.ceil(totalFilteredItems / entriesPerWoPage);

        paginationDiv.innerHTML = '';
        if (totalPages <= 1) return;

        let paginationHTML = `<button class="page-btn" onclick="changeWoPage('prev')">Previous</button>`;
        for (let i = 1; i <= totalPages; i++) {
            paginationHTML += `<button class="page-btn ${i === currentWoPage ? 'active' : ''}" onclick="changeWoPage(${i})">${i}</button>`;
        }
        paginationHTML += `<button class="page-btn" onclick="changeWoPage('next')">Next</button>`;
        paginationDiv.innerHTML = paginationHTML;
    }

    // Info Entri WO
    const updateWoEntryInfo = (totalFilteredItems) => {
        const entryInfo = document.getElementById('woEntryInfo');
        if (!entryInfo) return;
        const start = totalFilteredItems > 0 ? (currentWoPage - 1) * entriesPerWoPage + 1 : 0;
        const end = Math.min(start + entriesPerWoPage - 1, totalFilteredItems);
        entryInfo.textContent = `Showing ${start} to ${end} of ${totalFilteredItems} entries`;
    }

    // Ganti Halaman WO
    window.changeWoPage = (page) => {
        const totalPages = Math.ceil(filteredWoData.length / entriesPerWoPage);
        if (page === 'prev') {
            if (currentWoPage > 1) currentWoPage--;
        } else if (page === 'next') {
            if (currentWoPage < totalPages) currentWoPage++;
        } else {
            currentWoPage = page;
        }
        renderWorkOrderTable();
    }

    // Event listener 'Show entries' WO
    const woEntriesSelect = document.getElementById('woEntriesSelect');
    if (woEntriesSelect) {
        woEntriesSelect.addEventListener('change', function() {
            entriesPerWoPage = parseInt(this.value);
            currentWoPage = 1;
            renderWorkOrderTable();
        });
    }

    // Event listener pencarian WO
    const woSearchInput = document.getElementById('woSearchInput');
    if (woSearchInput) {
        woSearchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            filteredWoData = workOrderData.filter(row => {
                return Object.values(row).some(val =>
                    String(val).toLowerCase().includes(searchTerm)
                );
            });
            currentWoPage = 1;
            renderWorkOrderTable();
        });
    }

    // Event listener tombol 'Simpan' WO (AJAX)
    const simpanWoBtn = document.getElementById('simpanWoBtn');
    if (simpanWoBtn) {
        simpanWoBtn.addEventListener('click', async () => {
            const personalId = document.getElementById('modalPersonalId').value;
            const newData = {
                tanggal: document.getElementById('woTanggal').value,
                fasilitas: document.getElementById('woKategori').value,
                jenis: document.getElementById('woJenis').value,
                deskripsi: document.getElementById('woDeskripsi').value,
            };

            if (!newData.tanggal || !newData.fasilitas || !newData.jenis) {
                alert('Tanggal, Kategori, dan Jenis Peralatan tidak boleh kosong!');
                return;
            }

            try {
                const response = await fetch(`/personal/${personalId}/workorders`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(newData)
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(Object.values(errorData.errors).join('\n'));
                }

                const addedWorkOrder = await response.json();

                workOrderData.unshift(addedWorkOrder);
                filteredWoData = [...workOrderData];

                currentWoPage = 1;
                renderWorkOrderTable();

                setTodayDateForWorkOrder();
                document.getElementById('woKategori').value = '';
                document.getElementById('woJenis').value = '';
                document.getElementById('woDeskripsi').value = '';

                showToast('Work order berhasil disimpan!');

            } catch (error) {
                console.error('Gagal menambah WO:', error);
                alert('Gagal menambah Work Order:\n' + error.message);
            }
        });
    }

    // Fungsi Modal Detail WO
    window.openDetailModal = (id) => {
        const wo = workOrderData.find(item => item.id === id);
        if (wo) {
            document.getElementById('detailTanggal').textContent = wo.tanggal;
            document.getElementById('detailKategori').textContent = wo.fasilitas;
            document.getElementById('detailJenis').textContent = wo.jenis;
            document.getElementById('detailDeskripsi').textContent = wo.deskripsi;
            document.getElementById('workOrderDetailModal').classList.add('active');
        }
    }

    window.closeDetailModal = () => {
        document.getElementById('workOrderDetailModal').classList.remove('active');
    }

});
</script>

@endsection
