<!DOCTYPE html>
<html>

<head>
    <title>Cetak Galeri Bulanan</title>

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
            height: auto;
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
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        /* =========================
           BIDANG
        ========================= */

        .bidang {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        /* =========================
           TABEL
        ========================= */

        table {
            width: 100%;
            border-collapse: collapse;
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

            {{-- =========================
             JUDUL
        ========================== --}}

            <div class="judul">

                <h1>
                    REKAPITULASI
                </h1>

                <h2>
                    JADWAL KEGIATAN TIM PENGGERAK PKK
                </h2>

                <h3>
                    KABUPATEN NGANJUK
                </h3>

                <h3>
                    TAHUN {{ $tanggal2 ?? date('Y') }}
                </h3>

            </div>

        </div>

        {{-- GARIS --}}
        <div class="separator"></div>

        {{-- =========================
         TANGGAL CETAK
    ========================== --}}

        <div class="tanggal-cetak">

            Tanggal Cetak :
            {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}

        </div>

        {{-- =========================
         JUDUL BULAN
    ========================== --}}

        <div class="judul-bulan">

            Bulan {{ $tanggal }}

        </div>

        {{-- =========================
         BIDANG
    ========================== --}}

        <div class="bidang">

            Bidang : Bidang Umum

        </div>

        {{-- =========================
         TABEL
    ========================== --}}

        <table>

            <thead>

                <tr>

                    <th width="5%">
                        No
                    </th>

                    <th width="18%">
                        Tanggal
                    </th>

                    <th width="30%">
                        Lokasi Kegiatan
                    </th>

                    <th width="47%">
                        Deskripsi
                    </th>

                </tr>

            </thead>

            <tbody>

                @php
                $no = 1;
                @endphp

                @forelse($bidangumum as $tampil)

                <tr>

                    <td class="center">

                        {{ $no++ }}

                    </td>

                    <td class="center">

                        {{ \Carbon\Carbon::parse($tampil->tanggal)->isoFormat('D MMMM Y') }}

                    </td>

                    <td>

                        {{ $tampil->lokasi ?? '-' }}

                    </td>

                    <td>

                        {{ $tampil->deskripsi }}

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="4" class="center">

                        Tidak ada data

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

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

                Tidak ada data

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