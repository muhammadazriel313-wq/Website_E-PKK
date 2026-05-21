<!DOCTYPE html>
<html>

<head>
    <title>Cetak Galeri Tahunan Pokja I</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 1000px;
            margin: auto;
            padding: 20px;
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            width: 100%;
            margin-bottom: 20px;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
        }

        .logo {
            width: 85px;
            margin-right: 18px;
        }

        .instansi h2 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }

        .instansi p {
            margin-top: 5px;
            font-size: 16px;
        }

        /* =========================
           JUDUL
        ========================= */

        .judul {
            text-align: center;
            margin-top: 40px;
            margin-bottom: 25px;
        }

        .judul h1 {
            margin: 0;
            font-size: 42px;
            font-weight: bold;
        }

        .judul h2 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }

        .judul h3 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        /* =========================
           GARIS
        ========================= */

        .separator {
            border-top: 2px solid #000;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        /* =========================
           TANGGAL CETAK
        ========================= */

        .tanggal-cetak {
            text-align: right;
            font-size: 16px;
            margin-bottom: 20px;
        }

        /* =========================
           JUDUL BULAN
        ========================= */

        .judul-bulan {
            width: 100%;
            background: #b5b5b5;
            text-align: center;
            padding: 12px;
            font-size: 28px;
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        /* =========================
           TABEL
        ========================= */

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        table th {
            background: #d9d9d9;
            border: 1px solid #000;
            padding: 12px;
            font-size: 16px;
            text-align: center;
        }

        table td {
            border: 1px solid #000;
            padding: 12px;
            font-size: 15px;
            vertical-align: top;
        }

        .center {
            text-align: center;
        }

        /* =========================
           TTD
        ========================= */

        .ttd-wrapper {
            width: 100%;
            margin-top: 70px;
        }

        .ttd {
            width: 320px;
            margin-left: auto;
            text-align: center;
            line-height: 1.8;
            font-size: 18px;
        }

        .nama-ttd {
            margin-top: 80px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>

</head>

<body>

    <div class="container">

        {{-- =========================
         HEADER
    ========================== --}}

        <div class="header">

            <div class="logo-wrapper">

                <img
                    class="logo"
                    src="{{ asset('frontend/assets/img/favicon.png') }}"
                    alt="Logo PKK">

                <div class="instansi">

                    <h2>
                        Pemberdayaan Kesejahteraan Keluarga
                    </h2>

                    <p>
                        Kab. Nganjuk, Jawa Timur
                    </p>

                </div>

            </div>

            <div class="judul">

                <h1>
                    REKAPITULASI GALERI
                </h1>

                <h2>
                    JADWAL KEGIATAN KELOMPOK KERJA I
                </h2>

                <h3>
                    TIM PENGGERAK PKK
                </h3>

                @if(Auth::guard('pengguna')->check())

                <h3>
                    KECAMATAN
                    {{ strtoupper(Auth::guard('pengguna')->user()->name ?? '') }}
                </h3>

                @endif

                <h3>
                    TAHUN {{ $tanggal2 }}
                </h3>

            </div>

        </div>

        <div class="separator"></div>

        {{-- =========================
         TANGGAL CETAK
    ========================== --}}

        <div class="tanggal-cetak">

            Tanggal Cetak :
            {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}

        </div>

        {{-- =========================
         ARRAY BULAN
    ========================== --}}

        @php

        $bulanData = [

        'Januari' => $jan,
        'Februari' => $feb,
        'Maret' => $mar,
        'April' => $apr,
        'Mei' => $mei,
        'Juni' => $jun,
        'Juli' => $jul,
        'Agustus' => $agu,
        'September' => $sep,
        'Oktober' => $okt,
        'November' => $nov,
        'Desember' => $des,

        ];

        @endphp

        {{-- =========================
         LOOP BULAN
    ========================== --}}

        @foreach($bulanData as $namaBulan => $dataBulan)

        <div class="judul-bulan">

            Bulan {{ $namaBulan }}

        </div>

        <table>

            <thead>

                <tr>

                    <th width="5%">
                        No
                    </th>

                    <th width="18%">
                        Tanggal
                    </th>

                    <th width="27%">
                        Bidang
                    </th>

                    <th width="20%">
                        Lokasi Kegiatan
                    </th>

                    <th width="30%">
                        Deskripsi
                    </th>

                </tr>

            </thead>

            <tbody>

                @php
                $no = 1;
                @endphp

                @forelse($dataBulan as $item)

                <tr>

                    <td class="center">

                        {{ $no++ }}

                    </td>

                    <td class="center">

                        {{ \Carbon\Carbon::parse($item->tanggal ?? $item->created_at)->locale('id')->translatedFormat('d F Y') }}

                    </td>

                    <td class="center">

                        {{ $item->bidang ?? '-' }}

                    </td>

                    <td>

                        {{ $item->lokasi ?? '-' }}

                    </td>

                    <td>

                        {{ $item->deskripsi }}

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5" class="center">

                        <i>
                            Tidak ada data pada bulan ini.
                        </i>

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

        @endforeach

        {{-- =========================
         TANDA TANGAN
    ========================== --}}

        <div class="ttd-wrapper">

            <div class="ttd">

                @forelse($ketua as $ketuaa)

                <div>

                    Nganjuk,
                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}

                </div>

                <div>
                    TP PKK Kabupaten Nganjuk
                </div>

                <div>
                    {{ $ketuaa->pokja }}
                </div>

                <div>
                    {{ $ketuaa->jabatan }}
                </div>

                <div class="nama-ttd">

                    {{ $ketuaa->nama_terang }}

                </div>

                @empty

                <div>
                    Tidak ada data pimpinan
                </div>

                @endforelse

            </div>

        </div>

    </div>

    <script>
        window.onload = function() {

            window.print();

        }
    </script>

</body>

</html>