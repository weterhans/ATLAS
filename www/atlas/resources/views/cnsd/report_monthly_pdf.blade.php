<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $reportTitle ?? 'Laporan Bulanan' }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            color: #000000ff;
            line-height: 1.4;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-image {
            width: 80px;
            /* Atur lebar logo */
            height: auto;
            display: block;
            margin: 0 auto 5px auto;
        }

        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }

        .header h1 {
            font-family: 'Times New Roman', Times, serif;
            color: #255A9B;
            font-size: 22px;
            margin: 0;
            font-weight: bold;
        }

        .header h2 {
            font-weight: bold;
            font-size: 14px;
            margin: 5px 0 0 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #000000ff;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }

        table th {
            background-color: #255A9B;
            /* Warna biru tua AirNav */
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }

        table td:nth-child(1),
        table td:nth-child(2),
        table td:nth-child(3),
        table td:nth-child(5) {
            text-align: center;
            /* Tanggal, Jam, Terputus */
            width: 12%;
        }

        table td:nth-child(4) {
            width: 20%;
        }

        /* Nama Alat */
        table td:nth-child(5) {
            width: 42%;
        }

        /* Kegiatan */

        /* Untuk kolom JAM */
        table th.jam-header {
            text-align: center;
        }

        table th.jam-subheader {
            text-align: center;
            font-size: 14px;
            padding: 2px 4px;
        }

        table td.jam-subheader {
            text-align: center;
            vertical-align: middle;
            font-size: 13px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            @php
            $logoPath = public_path('img/airnav_logo.png'); // Pastikan nama file logo ini bener
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
            <h1>AirNav Indonesia</h1>
            <h2>{{ $dateRange }}</h2>
        </div>

        <table>
            <thead class="header-table">
                <tr>
                    <th rowspan="2" style="vertical-align: middle;">TANGGAL</th>
                    <th colspan="2" class="jam-header">JAM</th>
                    <th rowspan="2" style="vertical-align: middle;">NAMA ALAT</th>
                    <th rowspan="2" style="vertical-align: middle;">KEGIATAN</th>
                    <th rowspan="2" style="vertical-align: middle;">TERPUTUS</th>
                </tr>
                <tr>
                    <th class="jam-subheader">MULAI</th>
                    <th class="jam-subheader">SELESAI</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($activities as $activity)
                <tr>
                    <td>{{ $activity->tanggal_formatted }}</td>
                    <td class="jam-subheader">{{ $activity->jam_mulai }}</td>
                    <td class="jam-subheader">{{ $activity->jam_selesai }}</td>
                    <td style="text-align: center;">{{ $activity->nama_alat }}</td>
                    <td style="text-align: left;">
                        {{-- Ubah format 'kegiatan' (tindakan) jika perlu --}}
                        {!! nl2br(e($activity->kegiatan)) !!}
                    </td>
                    <td style="text-align: center;">{{ $activity->terputus }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">
                        Tidak ada data kegiatan yang ditemukan untuk kriteria ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>