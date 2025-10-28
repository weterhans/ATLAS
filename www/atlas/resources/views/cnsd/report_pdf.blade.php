<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Harian CNSD</title>
    <style>
        @media screen {

            /* Terapkan hanya untuk layar (browser), bukan print/pdf */
            body {
                background: #eee;
                /* Warna latar belakang abu-abu di luar kertas */
                margin: 0;
                /* Hapus margin default body */
                padding: 0;
                /* Hapus padding default body */
            }

            .page-preview {
                background: white;
                /* Warna kertas putih */
                width: 210mm;
                /* Lebar A4 */
                min-height: 297mm;
                /* Tinggi A4 (gunakan min-height agar bisa lebih panjang jika konten melebihi) */
                padding: 15mm;
                /* Margin/Padding kertas (sesuaikan) */
                margin: 1cm auto;
                /* Posisi kertas di tengah layar */
                border: 1px solid #ccc;
                /* Garis batas kertas (opsional) */
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                /* Efek bayangan (opsional) */
                box-sizing: border-box;
                /* Padding termasuk dalam width/height */
            }

            /* Hindari page-break-before di preview karena bisa aneh */
            .personnel-table {
                page-break-before: auto;
            }
        }

        /* Style khusus untuk PDF (mungkin diabaikan oleh browser) */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            /* Reset margin untuk print */
            .personnel-table {
                page-break-before: always;
                /* Pastikan tetap ada untuk PDF */
            }

            /* Sembunyikan style preview saat print/pdf */
            .page-preview {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }

        body {
            font-family: sans-serif;
            font-size: 10pt;
        }

        .header-table {
            width: 100%;
            margin-bottom: 10px;
            border: none;
        }

        .header-table td {
            vertical-align: top;
            padding: 5px;
        }

        .header-table .info {
            padding-top: 70px;
            text-align: left;
        }

        .header-table .logo {
            text-align: right;
        }

        .logo-container {
            text-align: right;
            /* Jaga agar konten defaultnya rata kanan jika perlu */

            /* Lebar area logo kanan */
            vertical-align: top;
            /* Pastikan rata atas dengan info kiri */
            /* Pastikan rapat kanan */
        }

        /* [BARU] Style untuk teks di bawah logo */
        .logo-text {
            margin-top: 10px;
            width: 60px;
            /* [BARU] Samakan lebar dengan gambar logo */
            font-size: 8pt;
            font-family: 'Times New Roman', Times, serif;
            /* Pastikan font ini tersedia */
            color: #255A9B;
            text-align: center;
            /* [PERUBAHAN] Center-kan teks di dalam div */
            display: block;
            /* Pastikan div ini block */
            margin-left: auto;
            /* [BARU] Dorong block div ke kanan */
            margin-right: 0;
            /* Sedikit padding kanan agar lurus logo */
        }

        /* [BARU] Style untuk garis horizontal */
        .header-line {
            border-bottom: 2px solid black;
            /* Garis hitam tebal */
            margin-bottom: 20px;
            /* Jarak ke tabel utama */
        }

        /* Atur tinggi logo */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }

        .main-table th {
            background-color: #255A9B;
            color: white;
            text-align: center;
            font-weight: bold;
        }

        .main-table td.center {
            text-align: center;
        }

        .main-table td.number {
            text-align: center;
            width: 30px;
        }

        /* Kolom NO */
        .personnel-table {
            width: 100%;
            border-collapse: collapse;
            page-break-before: always;
        }

        /* Paksa halaman baru */
        .personnel-table th,
        .personnel-table td {
            border: 1px solid black;
            padding: 5px;
        }

        .personnel-table th {
            background-color: #255A9B;
            color: white;
            text-align: center;
            font-weight: bold;
        }

        .personnel-table td.number {
            text-align: center;
            width: 30px;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
            width: 250px;
            margin-left: auto;
        }

        .signature .label {
            margin-bottom: 60px;
        }

        .signature .name {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="page-preview">
        {{-- Header --}}
        <table class="header-table">
            <tr>
                <td class="info">
                    TANGGAL : {{ $tanggal }} <br>
                    DINAS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $dinas }}
                </td>
                {{-- [PERUBAHAN] Ganti class td dan tambahkan div text --}}
                <td class="logo-container">
                    <img src="{{ public_path('img/airnav_logo.png') }}" style="width: 60px;" alt="AirNav Logo">
                    {{-- [BARU] Teks di bawah logo --}}
                    <div class="logo-text">AirNav Indonesia</div>
                </td>
            </tr>
        </table>

        {{-- [BARU] Garis Horizontal --}}
        <div class="header-line"></div>

        {{-- Tabel Kondisi Peralatan --}}
        <table class="main-table">
            <thead>
                <tr>
                    <th colspan="4">KONDISI HARIAN PERALATAN</th>
                </tr>
                <tr>
                    <th>NO</th>
                    <th>ALAT</th>
                    <th>STATUS</th>
                    <th>KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($equipmentList as $index => $equipment)
                <tr>
                    <td class="number">{{ $index + 1 }}</td>
                    <td>{{ $equipment->name ?? '-' }}</td>
                    <td class="center">NORMAL</td> {{-- Asumsi selalu normal sesuai gambar --}}
                    <td></td> {{-- Keterangan kosong --}}
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="center">Data Equipment tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Tabel Personel (Halaman Baru) --}}
        <table class="personnel-table">
            <thead>
                <tr>
                    <th colspan="6">PERSONEL YANG BERDINAS</th>
                </tr>
                <tr>
                    <th>NO</th>
                    <th>NAMA</th>
                    <th>PARAF</th>
                    <th>NO</th>
                    <th>NAMA</th>
                    <th>PARAF</th>
                </tr>
            </thead>
            <tbody>
                @php $totalPersonnel = count($personnel); @endphp
                @for ($i = 0; $i < 3; $i++)
                    <tr>
                    <td class="number">{{ $i + 1 }}.</td>
                    <td>{{ $personnel[$i] ?? '' }}</td>
                    <td></td> {{-- Paraf Kosong --}}
                    <td class="number">{{ $i + 4 }}.</td>
                    <td>{{ $personnel[$i + 3] ?? '' }}</td>
                    <td></td> {{-- Paraf Kosong --}}
                    </tr>
                    @endfor
            </tbody>
        </table>

        {{-- Tanda Tangan --}}
        <div class="signature">
            <div class="label">Mengetahui,<br>MANTEK</div>
            <div class="name">{{ $mantekName ?? '-' }}</div>
        </div>
    </div>

</body>

</html>