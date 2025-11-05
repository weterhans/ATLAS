@extends('layouts.main_dashboard')

@section('content')

{{--
  CSS Kustom untuk halaman Data Personal.
--}}
<style>
    /* Reset dasar */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Konten dari .content-panel di dashboard Anda mungkin sudah memiliki padding.
      Jika terjadi padding ganda, Anda bisa menghapus 'padding: 2rem' dari body ini.
      Saya akan menggantinya agar menargetkan .main-container saja.
    */
    .main-container {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Header */
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

    /* MODIFIKASI:
      CSS untuk #entriesSelect dihapus.
      Kita akan menggunakan class Tailwind langsung di HTML.
    */

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

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }

    .modal-header h2 {
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

    .info-label {
        font-weight: 600;
        color: #555;
        font-size: 13px;
    }

    .info-value {
        color: #333;
        font-size: 13px;
        background: white;
        padding: 0.5rem 0.75rem;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    .info-value select, .info-value input {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 3px;
        background: white;
    }

    .info-value .btn { font-size: 12px; padding: 5px 15px; }

    .work-order-table-section {
        grid-column: 1 / -1;
    }

    .simpan-btn {
        float: right;
    }
</style>

{{-- Konten HTML dari personal.html --}}
<div class="p-6 md:p-8">

    <div class="flex justify-between items-center mb-6">
         <div class="flex items-center"> {{-- mb-6 dihapus dari sini --}}
            {{-- Tombol Kembali ke Dashboard --}}
            <a href="{{ route('dashboard') }}" class="p-2 rounded-md hover:bg-gray-200" aria-label="Kembali ke Dashboard">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 ml-4">Data Personal</h1>
        </div>
         <a href="#" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M2 7.5C2 10.5376 4.46243 13 7.5 13C9.07394 13 10.51 12.3524 11.553 11.3093L11.9999 11.7563V10H10.2436L10.6906 10.447C9.88335 11.2543 8.75139 11.75 7.5 11.75C5.13629 11.75 3.25 9.86371 3.25 7.5C3.25 5.13629 5.13629 3.25 7.5 3.25C8.56586 3.25 9.54131 3.63321 10.2854 4.28542L9.20703 5.36377L12.0355 5.64219L12.3139 2.81377L11.2355 3.89219C10.2816 3.04285 9.00122 2.5 7.5 2.5C4.46243 2.5 2 4.96243 2 7.5ZM13.1862 9.68615L10.3578 9.40773L9.27942 10.4861C8.53533 9.83391 7.55987 9.45071 6.5 9.45071C5.24861 9.45071 4.11665 9.94563 3.30938 10.753L3.75635 10.306V12H5.5127L5.06573 11.553C6.01957 12.4024 7.29994 12.9507 8.81377 12.9507C8.95319 12.9507 9.09131 12.9436 9.22784 12.9301L8.91421 13.2437L10.0253 14.3548L11.1364 13.2437L10.0253 12.1326L8.53552 10.6429L9.64663 9.53176L10.7577 10.6429L11.8688 9.53176L13.1862 9.68615Z"/>
            </svg>
            <span>Sinkronisasi Data</span>
        </a>
    </div>

    <div class="data-section">
        <div class="table-controls">
            <div>
                <label class="text-sm text-gray-700">Show
                    <select id="entriesSelect" class="mx-1 pl-2 pr-8 py-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
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
                    <th>Work Order</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                </tbody>
        </table>

        <div class="table-footer">
             <div class="entry-info">Menampilkan 1 dari 10 dari total 53 entri</div>
             <div class="pagination">
                </div>
        </div>
    </div>
</div>

<div id="workOrderModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Data Work Order Personil : <span id="modalPersonName">Nama Personil</span></h2>
            <button class="close-btn" onclick="closeModal()">✕ Kembali</button>
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
                <div class="info-row">
                    <div class="info-label">Kating</div>
                    <div class="info-value">
                        <button class="btn btn-primary">List Rating >></button>
                    </div>
                </div>
            </div>

            <div class="section">
                <h3>Tambah Work Order</h3>
                 <div class="info-row">
                    <div class="info-label">Bulan dari tahun</div>
                    <div class="info-value">
                        <div style="display: flex; gap: 0.5rem;">
                            <select>
                                <option>Januari</option>
                                <option>Februari</option>
                                <option>Maret</option>
                                <option>April</option>
                                <option>Mei</option>
                                <option>Juni</option>
                                <option>Juli</option>
                                <option>Agustus</option>
                                <option>September</option>
                                <option>Oktober</option>
                                <option>November</option>
                                <option>Desember</option>
                            </select>
                            <select>
                                <option>2024</option>
                                <option>2025</option>
                                <option>2026</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Kategori</div>
                    <div class="info-value">
                        <select>
                            <option>--- Kosongkan ---</option>
                            <option>Communication</option>
                            <option>Navigation</option>
                            <option>Surveillance</option>
                            <option>Data Processing</option>
                        </select>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Jenis Peralatan</div>
                    <div class="info-value">
                        <input type="text" placeholder="Pilih Jenis Peralatan">
                    </div>
                </div>
                <button class="btn btn-primary simpan-btn">📥 Simpan</button>
            </div>

            <div class="section work-order-table-section">
                <h3>Daftar Work Order [Existing]</h3>
                </div>
        </div>
    </div>
</div>

{{--
  JavaScript Kustom untuk halaman Data Personal.
  (Diambil dari renderer_personal.js)
--}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Data lengkap karyawan
    // CATATAN: Idealnya, data ini diambil dari database melalui Controller,
    // bukan di-hardcode di JavaScript.
    const allData = [
        {no: 1, nik: '10010069', nama: 'AN NAUFAL', kelamin: 'L', jabatan: 'MANAGER FASILITAS TEKNIK', level: '16', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 2, nik: '10083259', nama: 'AGUS DERMAWAN MUCHSIN', kelamin: 'L', jabatan: 'MANAGER TEKNIK 1', level: '15', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 3, nik: '10083380', nama: 'EFRIED NARA PERKASA', kelamin: 'L', jabatan: 'MANAGER TEKNIK 3', level: '15', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 4, nik: '10083435', nama: 'ANDI WIBOWO', kelamin: 'L', jabatan: 'MANAGER TEKNIK 2', level: '15', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 5, nik: 'ASN83713', nama: 'NETTY SEPTA CRISILA', kelamin: 'P', jabatan: 'MANAGER TEKNIK 5', level: '15', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 6, nik: 'ASN83472', nama: 'MOCH. ICHSAN', kelamin: 'L', jabatan: 'SUPERVISOR TEKNIK TELEKOMUNIKASI', level: '14', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 7, nik: 'ASN83883', nama: 'WIDI HANDOKO', kelamin: 'L', jabatan: 'JUNIOR MANAGER FASILITAS PENUNJANG', level: '14', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 8, nik: '10010419', nama: 'NUR HUKIM', kelamin: 'L', jabatan: 'SUPERVISOR TEKNIK TELEKOMUNIKASI', level: '13', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 9, nik: '10010503', nama: 'PRIYOKO', kelamin: 'L', jabatan: 'SUPERVISOR TEKNIK PENUNJANG', level: '13', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 10, nik: '10010842', nama: 'FAJAR KUSUMA WARDANA', kelamin: 'L', jabatan: 'SUPERVISOR TEKNIK PENUNJANG', level: '13', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 11, nik: '10011057', nama: 'ADITYA HUZAIRI PUTRA', kelamin: 'L', jabatan: 'TEKNIK TELEKOMUNIKASI', level: '13', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 12, nik: '10010987', nama: 'KHOIRUL M. A.', kelamin: 'L', jabatan: 'TEKNIK PENUNJANG', level: '12', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 13, nik: '10011234', nama: 'ARGO PRAGOLO', kelamin: 'L', jabatan: 'STAFF ADMINISTRASI', level: '12', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 14, nik: '10011456', nama: 'FEBRI DWI C.', kelamin: 'L', jabatan: 'TEKNISI SENIOR', level: '12', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 15, nik: '10011678', nama: 'M. YUSUF TRIONO', kelamin: 'L', jabatan: 'STAFF TEKNIK', level: '12', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 16, nik: '10011890', nama: 'RIYAN FAUZI', kelamin: 'L', jabatan: 'TEKNISI LAPANGAN', level: '12', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 17, nik: '10012123', nama: 'TEGUH MURDIYANTO', kelamin: 'L', jabatan: 'OPERATOR SISTEM', level: '12', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 18, nik: '10012345', nama: 'YUSRI HANDOKO', kelamin: 'L', jabatan: 'TEKNISI JARINGAN', level: '12', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 19, nik: '10012567', nama: 'MOH. SYAMSUDIN', kelamin: 'L', jabatan: 'STAFF DOKUMENTASI', level: '12', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 20, nik: '10012789', nama: 'ADAM BUKHORI', kelamin: 'L', jabatan: 'HELPER TEKNIK', level: '12', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 21, nik: '10013001', nama: 'AMIRZAN RIDHO W.', kelamin: 'L', jabatan: 'STAFF ADMINISTRASI', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 22, nik: '10013223', nama: 'SILVY RETNO ANDRIANI', kelamin: 'P', jabatan: 'TEKNISI LISTRIK', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 23, nik: '10013445', nama: 'TRIA SABDA UTAMA', kelamin: 'L', jabatan: 'OPERATOR', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 24, nik: '10013667', nama: 'DANI RIDZAL', kelamin: 'L', jabatan: 'TEKNISI AC', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 25, nik: '10013889', nama: 'NUR SHELLA FIRDAUS ', kelamin: 'P', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 26, nik: '10013889', nama: 'YORDAN C.P ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 27, nik: '10013889', nama: 'ROHMADONI SURYA KAHFI DEWANATA ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 28, nik: '10013889', nama: 'SAFIRA SARASWATI ', kelamin: 'P', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 29, nik: '10013889', nama: 'ALDHI DESKA P. ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 30, nik: '10013889', nama: 'ELVITA AGUSTINA ', kelamin: 'P', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 31, nik: '10013889', nama: 'RENDY PANCA A.P. ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 32, nik: '10013889', nama: 'I KADEK DWIJA S. ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 33, nik: '10013889', nama: 'DWIKI SETYO W. ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 34, nik: '10013889', nama: 'WINDI TRI SETYAWATI ', kelamin: 'P', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 35, nik: '10013889', nama: 'IQBAL MUSTIKA ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 36, nik: '10013889', nama: 'SOFI DWI HIDAYATI ', kelamin: 'P', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 37, nik: '10013889', nama: 'YOGA ARIFAL P. ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 38, nik: '10013889', nama: 'M. FEIZAR NOOR ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 39, nik: '10013889', nama: 'DWI PRASETYO ADI ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 40, nik: '10013889', nama: 'ANDHIKA BHASKARA J. ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 41, nik: '10013889', nama: 'AGUSTINA ANGGREINI ', kelamin: 'P', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 42, nik: '10013889', nama: 'DWI PUJI RAHAYU ', kelamin: 'P', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 43, nik: '10013889', nama: 'FRISZA VRADANA ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 44, nik: '10013889', nama: 'M. AIDIN EFFENDI ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '11', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 45, nik: '10013889', nama: 'PANDU INDRAJA ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '10', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 46, nik: '10013889', nama: 'SEPTI RAHMAN SARI ', kelamin: 'P', jabatan: 'STAFF SUPPORT', level: '10', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 47, nik: '10013889', nama: 'FAJAR NUGROHO ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '10', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 48, nik: '10013889', nama: 'SAIFUL BAHRIS ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '9', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 49, nik: '10013889', nama: 'KARANG SAMUDRA ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '9', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 50, nik: '10013889', nama: 'ILMIN SYARIF H. ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '9', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 51, nik: '10013889', nama: 'ERAZUARDI ZULFAHMI ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '9', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 52, nik: '10013889', nama: 'BIAN PRASETIA H ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '8', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
        {no: 53, nik: '10013889', nama: 'AHMAD MUJI YASIN ', kelamin: 'L', jabatan: 'STAFF SUPPORT', level: '8', lokasi: 'Cabang Surabaya', lokasiInduk: 'Surabaya'},
    ];

    let currentPage = 1;
    let entriesPerPage = 10;
    let filteredData = [...allData];

    // Fungsi untuk membuka modal
    window.openModal = (nama, pernium, jabatan, level) => {
        const modal = document.getElementById('workOrderModal');
        document.getElementById('modalPersonName').textContent = nama;
        document.getElementById('modalPernium').textContent = pernium;
        document.getElementById('modalNama').textContent = nama;
        document.getElementById('modalJabatan').textContent = jabatan;
        document.getElementById('modalLevel').textContent = level;
        document.getElementById('modalLokasi').textContent = 'Cabang Surabaya';
        document.getElementById('modalLokasiInduk').textContent = 'Surabaya';
        modal.classList.add('active');
    }

    // Fungsi untuk menutup modal
    window.closeModal = () => {
        const modal = document.getElementById('workOrderModal');
        modal.classList.remove('active');
    }

    // Menutup modal saat mengklik di luar area konten modal
    window.onclick = function(event) {
        const modal = document.getElementById('workOrderModal');
        if (event.target === modal) {
            closeModal();
        }
    }

    // Fungsi untuk merender ulang tabel
    const renderTable = () => {
        const tableBody = document.getElementById('tableBody');
        if (!tableBody) return;

        const start = (currentPage - 1) * entriesPerPage;
        const end = start + entriesPerPage;
        const pageData = filteredData.slice(start, end);

        tableBody.innerHTML = '';
        pageData.forEach(row => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${row.no}</td>
                <td>${row.nik}</td>
                <td>${row.nama}</td>
                <td>${row.kelamin}</td>
                <td>${row.jabatan}</td>
                <td>${row.level}</td>
                <td>${row.lokasi}</td>
                <td>${row.lokasiInduk}</td>
                <td><button class="action-btn" onclick="openModal('${row.nama}', '${row.nik}', '${row.jabatan}', '${row.level}')">👁</button></td>
            `;
            tableBody.appendChild(tr);
        });

        updatePagination();
        updateEntryInfo();
    }

    // Fungsi untuk memperbarui kontrol paginasi
    const updatePagination = () => {
        const paginationDiv = document.querySelector('.pagination');
        if (!paginationDiv) return;

        const totalPages = Math.ceil(filteredData.length / entriesPerPage);

        let paginationHTML = `<button class="page-btn" onclick="changePage('prev')">Previous</button>`;

        for (let i = 1; i <= totalPages; i++) {
            paginationHTML += `<button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
        }

        paginationHTML += `<button class="page-btn" onclick="changePage('next')">Next</button>`;
        paginationDiv.innerHTML = paginationHTML;
    }

    // Fungsi untuk memperbarui info jumlah entri
    const updateEntryInfo = () => {
        const entryInfo = document.querySelector('.entry-info');
        if (!entryInfo) return;

        const start = filteredData.length > 0 ? (currentPage - 1) * entriesPerPage + 1 : 0;
        const end = Math.min(start + entriesPerPage - 1, filteredData.length);
        entryInfo.textContent = `Showing ${start} to ${end} of ${filteredData.length} entries`;
    }

    // Fungsi untuk mengubah halaman
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

    // Event listener untuk pilihan jumlah entri per halaman
    const entriesSelect = document.getElementById('entriesSelect');
    if (entriesSelect) {
        entriesSelect.addEventListener('change', function() {
            entriesPerPage = parseInt(this.value);
            currentPage = 1;
            renderTable();
        });
    }

    // Fungsionalitas pencarian
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();

            filteredData = allData.filter(row => {
                return Object.values(row).some(val =>
                    String(val).toLowerCase().includes(searchTerm)
                );
            });

            currentPage = 1;
            renderTable();
        });
    }

    // Event listener untuk klik item menu (jika ada)
    const menuItems = document.querySelectorAll('.menu-item');
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            menuItems.forEach(mi => mi.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Render tabel saat pertama kali halaman dimuat
    renderTable();
});
</script>

@endsection
