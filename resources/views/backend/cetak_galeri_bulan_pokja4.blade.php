<!DOCTYPE html>
<html>

<head>
    <title>Cetak Kegiatan Bulanan Pokja IV</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
        }

        .container {
            width: 1000px;
            margin: auto;
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            margin-bottom: 20px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 90px;
            margin-right: 20px;
        }

        .instansi h2 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }

        .instansi p {
            margin: 5px 0 0;
            font-size: 16px;
        }

        /* =========================
           JUDUL
        ========================= */

        .judul {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .judul h1 {
            margin: 0;
            font-size: 42px;
            font-weight: bold;
        }

        .judul h2 {
            margin: 0;
            font-size: 30px;
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
            margin: 20px 0;
        }

        /* =========================
           TANGGAL CETAK
        ========================= */

        .tanggal-cetak {
            text-align: right;
            margin-bottom: 20px;
            font-size: 16px;
        }

        /* =========================
           BOX JUDUL
        ========================= */

        .judul-bidang {
            background: #b5b5b5;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            padding: 12px;
            margin-top: 25px;
            margin-bottom: 10px;
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
            padding: 10px;
            font-size: 16px;
            text-align: center;
        }

        table td {
            border: 1px solid #000;
            padding: 10px;
            font-size: 15px;
            vertical-align: top;
        }

        .center {
            text-align: center;
        }

        /* =========================
           TTD
        ========================= */

        .container-grid {
            width: 100%;
            margin-top: 70px;
            display: grid;
            grid-template-columns: 50% 50%;
        }

        .ttd {
            text-align: center;
            font-size: 18px;
            line-height: 1.8;
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

            <div class="logo-container">

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

                <h1>REKAPITULASI</h1>

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

        <div class="separator"></div>

        {{-- =========================
             TANGGAL CETAK
        ========================== --}}

        <div class="tanggal-cetak">

            Tanggal Cetak :
            {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}

        </div>

        {{-- =========================
             BULAN
        ========================== --}}

        <div class="judul-bidang">

            Bulan {{ $tanggal }}

        </div>

        {{-- =========================
             KESEHATAN
        ========================== --}}

        <div class="judul-bidang">
            Bidang : Kesehatan
        </div>

        <table>

            <thead>

                <tr>

                    <th width="5%">No</th>
                    <th width="20%">Tanggal</th>
                    <th width="30%">Lokasi Kegiatan</th>
                    <th width="30%">Deskripsi</th>
                    <th width="25%">Nama Peserta</th>

                </tr>

            </thead>

            <tbody>

                @php $no = 1; @endphp

                @forelse($kesehatan as $tampil)

                <tr>

                    <td class="center">
                        {{ $no++ }}
                    </td>

                    <td class="center">
                        {{ \Carbon\Carbon::parse($tampil->tanggal ?? $tampil->created_at)->translatedFormat('d F Y') }}
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
                        Tidak ada data pada bidang ini.
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

        {{-- =========================
             KELESTARIAN LINGKUNGAN
        ========================== --}}

        <div class="judul-bidang">
            Bidang : Kelestarian Lingkungan
        </div>

        <table>

            <thead>

                <tr>

                    <th width="5%">No</th>
                    <th width="20%">Tanggal</th>
                    <th width="30%">Lokasi Kegiatan</th>
                    <th width="30%">Deskripsi</th>
                    <th width="25%">Nama Peserta</th>

                </tr>

            </thead>

            <tbody>

                @php $no = 1; @endphp

                @forelse($kelestarian as $tampil1)

                <tr>

                    <td class="center">
                        {{ $no++ }}
                    </td>

                    <td class="center">
                        {{ \Carbon\Carbon::parse($tampil1->tanggal ?? $tampil1->created_at)->translatedFormat('d F Y') }}
                    </td>

                    <td>
                        {{ $tampil1->lokasi ?? '-' }}
                    </td>

                    <td>
                        {{ $tampil1->deskripsi }}
                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="4" class="center">
                        Tidak ada data pada bidang ini.
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

        {{-- =========================
             PERENCANAAN SEHAT
        ========================== --}}

        <div class="judul-bidang">
            Bidang : Perencanaan Sehat
        </div>

        <table>

            <thead>

                <tr>

                    <th width="5%">No</th>
                    <th width="20%">Tanggal</th>
                    <th width="30%">Lokasi Kegiatan</th>
                    <th width="30%">Deskripsi</th>
                    <th width="25%">Nama Peserta</th>

                </tr>

            </thead>

            <tbody>

                @php $no = 1; @endphp

                @forelse($perencanaan as $tampil2)

                <tr>

                    <td class="center">
                        {{ $no++ }}
                    </td>

                    <td class="center">
                        {{ \Carbon\Carbon::parse($tampil2->tanggal ?? $tampil2->created_at)->translatedFormat('d F Y') }}
                    </td>

                    <td>
                        {{ $tampil2->lokasi ?? '-' }}
                    </td>

                    <td>
                        {{ $tampil2->deskripsi }}
                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="4" class="center">
                        Tidak ada data pada bidang ini.
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

        {{-- =========================
             KADER POKJA IV
        ========================== --}}

        <div class="judul-bidang">
            Bidang : Kader Pokja IV
        </div>

        <table>

            <thead>

                <tr>

                    <th width="5%">No</th>
                    <th width="20%">Tanggal</th>
                    <th width="30%">Lokasi Kegiatan</th>
                    <th width="30%">Deskripsi</th>
                    <th width="25%">Nama Peserta</th>

                </tr>

            </thead>

            <tbody>

                @php $no = 1; @endphp

                @forelse($laporanpokja4 as $tampil3)

                <tr>

                    <td class="center">
                        {{ $no++ }}
                    </td>

                    <td class="center">
                        {{ \Carbon\Carbon::parse($tampil3->tanggal ?? $tampil3->created_at)->translatedFormat('d F Y') }}
                    </td>

                    <td>
                        {{ $tampil3->lokasi ?? '-' }}
                    </td>

                    <td>
                        {{ $tampil3->deskripsi }}
                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="4" class="center">
                        Tidak ada data pada bidang ini.
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

        {{-- =========================
     INOVASI
========================== --}}

        <div class="judul-bidang">
            Bidang : Inovasi
        </div>

        <table>

            <thead>

                <tr>

                    <th width="5%">No</th>
                    <th width="20%">Tanggal</th>
                    <th width="25%">Kategori Inovasi</th>
                    <th width="20%">Lokasi Kegiatan</th>
                    <th width="30%">Deskripsi</th>

                </tr>

            </thead>

            <tbody>

                @php $no = 1; @endphp

                @forelse($inovasi as $tampil4)

                <tr>

                    <td class="center">
                        {{ $no++ }}
                    </td>

                    <td class="center">
                        {{ \Carbon\Carbon::parse($tampil4->tanggal ?? $tampil4->created_at)->translatedFormat('d F Y') }}
                    </td>

                    <td class="center">
                        {{ $tampil4->bidang }}
                    </td>

                    <td>
                        {{ $tampil4->lokasi ?? '-' }}
                    </td>

                    <td>
                        {{ $tampil4->deskripsi }}
                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5" class="center">
                        Tidak ada data inovasi.
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

        {{-- =========================
             TANDA TANGAN
        ========================== --}}

        <div class="container-grid">

            <div></div>

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
                    Tidak ada data
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