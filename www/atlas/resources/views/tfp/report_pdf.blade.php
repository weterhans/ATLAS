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
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
        }

        .header-table {
            width: 100%;
            margin-bottom: 5px;
            border: none;
        }

        .header-table td {
            vertical-align: top;
            padding: 5px;
        }

        .header-table .info {
            vertical-align: bottom;
            text-align: left;
        }

        .header-table .logo {
            text-align: right;
        }

        .logo-container {
            width: 30%;
            vertical-align: top;
            text-align: right;
            /* Pastikan konten default rata kanan */
        }

        /* [BARU] Nested table di dalam TD logo */
        .nested-logo-table {
            width: auto;
            /* Biarkan lebar mengikuti konten */
            margin-left: auto;
            /* Dorong tabel ke kanan */
            margin-right: 0;
            border-collapse: collapse;
            /* Hapus spasi antar sel */
        }

        /* [BARU] Cell di dalam nested table */
        .nested-logo-cell {
            padding: 0;
            /* Hapus padding default */
            text-align: center;
            /* Center-kan konten di dalamnya */
            vertical-align: top;
        }

        /* [PERUBAHAN] Styling Gambar Logo */
        .logo-image {
            width: 60px;
            /* Atur lebar logo */
            height: auto;
            display: block;
            /* Pastikan block */
            margin: 0 auto 5px auto;
            /* Center horizontal, margin bawah */
        }

        /* [PERUBAHAN] Styling Teks di Bawah Logo */
        .logo-text {
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
            color: #255A9B;
            text-align: center;
            /* Pastikan teks center */
            /* Hapus semua margin/width/display block sebelumnya */
            line-height: 1;
            /* Atur line-height agar lebih rapat jika perlu */
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

        /* [BARU] Style untuk cell paraf dan gambar signature */
        .paraf-cell {
            height: 40px;
            /* Beri tinggi agar gambar muat */
            text-align: center;
            vertical-align: middle;
        }

        .signature-image {
            max-height: 35px;
            /* Sesuaikan tinggi max ttd personel */
            max-width: 100px;
            /* Batasi lebar juga jika perlu */
            width: auto;
            height: auto;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
            width: 250px;
            margin-left: auto;
        }

        .signature .label {
            margin-bottom: 5px;
            /* Kurangi jarak label ke ttd */
        }

        /* [BARU] Container untuk gambar ttd Mantek */
        .signature-image-container {
            height: 60px;
            /* Beri ruang untuk ttd mantek */
            vertical-align: bottom;
            /* Rata bawah jika perlu */
            margin-bottom: 5px;
            /* Jarak ke nama */
        }

        .mantek-signature-image {
            max-height: 50px;
            /* Sesuaikan tinggi max ttd mantek */
            max-width: 150px;
            width: auto;
            height: auto;
            display: block;
            /* Agar margin bekerja */
            margin-left: auto;
            /* Rata kanan di dalam div signature */
            margin-right: 0;
        }

        .signature .name {
            font-weight: bold;
            text-decoration: underline;
        }

        /* [BARU] Sembunyikan style A4 jika generate PDF (agar tidak ada background abu2) */
        @media print {
            .page-preview {
                background: none;
                margin: 0;
                padding: 0;
                border: none;
                box-shadow: none;
                width: auto;
                min-height: auto;
            }
        }
    </style>
</head>

<body>
    {{-- Hapus div.page-preview jika masih ada, atau biarkan jika ingin mempertahankan preview --}}
    {{-- <div class="page-preview"> --}}

    {{-- Header --}}
    <table class="header-table">
        <tr>
            <td class="info">
                TANGGAL : {{ $tanggal }} <br>
                DINAS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $dinas }}
            </td>
            <td class="logo-container">
                <table class="nested-logo-table">
                    <tr>
                        <td class="nested-logo-cell">
                            {{-- Logo tetap di public_path, karena ini aset statis --}}
                            @php
                            $logoPath = public_path('img/airnav_logo.png');
                            if (file_exists($logoPath)) {
                            $logoType = 'image/png';
                            $logoData = file_get_contents($logoPath);
                            $logoBase64 = base64_encode($logoData);
                            } else {
                            $logoBase64 = null;
                            }
                            @endphp
                            @if($logoBase64)
                            <img src="data:{{ $logoType }};base64,{{ $logoBase64 }}" alt="AirNav Logo" class="logo-image">
                            @endif
                            <div class="logo-text">AirNav Indonesia</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
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
            @php
            $status = 'N/A'; // Default status
            $keterangan = ''; // Default keterangan

            // --- [PERBAIKAN v3 - Logika Slugify Baru] ---

            // 1. Ambil nama alat
            $equipmentName = $equipment->name ?? '';

            // 2. Ubah ke huruf kecil
            $lookupKey = strtolower($equipmentName);

            // 3. GANTI karakter separator ('-', '&', '/') dengan SPASI
            $lookupKey = str_replace(['-', '&', '/'], ' ', $lookupKey);

            // 4. HAPUS karakter yang tidak diinginkan (kurung, titik)
            $lookupKey = str_replace(['(', ')', '.'], '', $lookupKey);

            // 5. GANTI satu atau lebih SPASI (berurutan) dengan SATU underscore
            $lookupKey = preg_replace('/\s+/', '_', $lookupKey);

            // 6. (Opsional tapi aman) Hapus jika ada underscore di awal/akhir
            $lookupKey = trim($lookupKey, '_');


            // 7. Cek apakah data JSON ($equipmentStatus) ada DAN key yang baru kita buat tadi
            if ($equipmentStatus && $lookupKey && isset($equipmentStatus[$lookupKey])) {
            $itemStatusData = $equipmentStatus[$lookupKey];

            if (is_array($itemStatusData) && isset($itemStatusData['status'])) {
            $status = $itemStatusData['status'];
            $keterangan = $itemStatusData['keterangan'] ?? '';
            } elseif (is_string($itemStatusData)) {
            $status = $itemStatusData;
            }
            } else {
            // \Illuminate\Support\Facades\Log::warning('Equipment key not found in status JSON', [
            // 'generated_key' => $lookupKey,
            // 'original_name' => $equipment->name
            // ]);
            }
            // --- [AKHIR PERBAIKAN v3] ---
            @endphp
            <tr>
                <td class="number">{{ $index + 1 }}</td>
                <td>{{ $equipment->name ?? '-' }}</td>
                {{-- Tampilkan status yang didapat --}}
                <td class="center">{{ $status }}</td>
                {{-- Tampilkan keterangan yang didapat --}}
                <td>{{ $keterangan }}</td>
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
            {{-- [PERBAIKAN LOGIKA TANDA TANGAN v6 - Perbaikan URL Kacau] --}}
            @php $totalPersonnel = count($personnel); @endphp
            @for ($i = 0; $i < 3; $i++)
                @php
                // Ambil data personel (objek) untuk kolom kiri dan kanan
                $personnel1=$personnel[$i] ?? null;
                $personnel2=$personnel[$i + 3] ?? null;
                @endphp
                <tr>
                <td class="number">{{ $i + 1 }}.</td>
                <td>{{ $personnel1->name ?? '' }}</td> {{-- Tampilkan nama dari objek --}}
                <td class="paraf-cell">
                    {{-- Cek apakah personel ada DAN signature_url-nya ada --}}
                    @if($personnel1 && $personnel1->signature_url)
                    @php
                    // [LOGIKA BARU] Bersihkan URL
                    $cleanedSignaturePath_1 = $personnel1->signature_url; // Default
                    if (strpos($personnel1->signature_url, '?') !== false) {
                    $parts = explode('?', $personnel1->signature_url, 2);
                    $path = $parts[0]; $query = $parts[1];
                    if (preg_match('/(\.png|\.jpg|\.jpeg|\.gif)$/i', $query, $matches)) {
                    $cleanedSignaturePath_1 = $path . $matches[0]; // Gabung path + ekstensi
                    } else { $cleanedSignaturePath_1 = $path; } // Fallback
                    }
                    $sigPath_system = storage_path('app/public/' . $cleanedSignaturePath_1);
                    @endphp
                    {{-- Cek apakah file-nya benar-benar ada di server --}}
                    @if(file_exists($sigPath_system))
                    @php
                    $imageData = file_get_contents($sigPath_system);
                    $imageType = 'image/png'; // Asumsi .png
                    $imageBase64 = base64_encode($imageData);
                    @endphp
                    <img src="data:{{ $imageType }};base64,{{ $imageBase64 }}" alt="Paraf" class="signature-image">
                    @endif
                    @endif
                </td>

                <td class="number">{{ $i + 4 }}.</td>
                <td>{{ $personnel2->name ?? '' }}</td> {{-- Tampilkan nama dari objek --}}
                <td class="paraf-cell">
                    {{-- Lakukan hal yang sama untuk personel kedua --}}
                    @if($personnel2 && $personnel2->signature_url)
                    @php
                    // [LOGIKA BARU] Bersihkan URL
                    $cleanedSignaturePath_2 = $personnel2->signature_url; // Default
                    if (strpos($personnel2->signature_url, '?') !== false) {
                    $parts = explode('?', $personnel2->signature_url, 2);
                    $path = $parts[0]; $query = $parts[1];
                    if (preg_match('/(\.png|\.jpg|\.jpeg|\.gif)$/i', $query, $matches)) {
                    $cleanedSignaturePath_2 = $path . $matches[0]; // Gabung path + ekstensi
                    } else { $cleanedSignaturePath_2 = $path; } // Fallback
                    }
                    $sigPath_system_2 = storage_path('app/public/' . $cleanedSignaturePath_2);
                    @endphp
                    @if(file_exists($sigPath_system_2))
                    @php
                    $imageData_2 = file_get_contents($sigPath_system_2);
                    $imageType_2 = 'image/png';
                    $imageBase64_2 = base64_encode($imageData_2);
                    @endphp
                    <img src="data:{{ $imageType_2 }};base64,{{ $imageBase64_2 }}" alt="Paraf" class="signature-image">
                    @endif
                    @endif
                </td>
                </tr>
                @endfor
                {{-- [AKHIR PERBAIKAN LOGIKA TANDA TANGAN v6] --}}
        </tbody>
    </table>

    {{-- Tanda Tangan --}}
    <div class="signature">
        <div class="label">Mengetahui,<br>MANTEK</div>

        <div class="signature-image-container">
            @if(!empty($mantekSignatureUrl))
            @php
            // Langsung coba cari path yang benar berdasarkan data DB yang sudah dikonfirmasi
            $correctMantekPath = storage_path('app/public/' . $mantekSignatureUrl);
            $mantekImageBase64 = null; // Default null

            // Cek jika file dengan path yang benar itu ada
            if(file_exists($correctMantekPath)) {
            try {
            $mantekImageData = file_get_contents($correctMantekPath);
            $mantekImageType = 'image/png'; // Asumsi PNG
            $mantekImageBase64 = base64_encode($mantekImageData);
            } catch (\Exception $e) {
            // Opsional: Log jika gagal baca file meski file_exists true (masalah permission?)
            \Illuminate\Support\Facades\Log::error('Gagal membaca file TTD Mantek: ' . $e->getMessage(), ['path' => $correctMantekPath]);
            }
            } else {
            // Opsional: Log jika file_exists masih false meski DB sudah benar
            \Illuminate\Support\Facades\Log::warning('File TTD Mantek tidak ditemukan di storage', ['expected_path' => $correctMantekPath, 'db_url' => $mantekSignatureUrl]);
            }
            @endphp

            {{-- Tampilkan gambar HANYA jika Base64 berhasil dibuat --}}
            @if($mantekImageBase64)
            <img src="data:{{ $mantekImageType }};base64,{{ $mantekImageBase64 }}" alt="TTD Mantek" class="mantek-signature-image">
            @endif
            @endif
        </div>
        <div class="name">{{ $mantekName ?? '-' }}</div>
    </div>

    {{-- </div> --}} {{-- Akhir div.page-preview jika dipakai --}}
</body>

</html>