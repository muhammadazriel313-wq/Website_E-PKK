<!DOCTYPE html>
<html>

<head>
    <title>Cetak Laporan Perbulan - Pokja 1</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 30px;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid black;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            margin-bottom: 20px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 100px;
            height: auto;
            margin-right: 20px;
        }

        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 14px;
            margin: 0;
        }

        .separator {
            margin-bottom: 10px;
            border-top: 2px solid #000;
        }

        .signature {
            margin-top: 20px;
            text-align: right;
            font-size: 13px;
        }

        .container-grid {
            width: 100%;
            border: none;
            padding: 5px;
            margin-top: 40px;
            box-sizing: border-box;
            display: grid;
            grid-template-columns: 50% 50%;
            font-size: 14px;
        }

        h3 {
            background-color: #f8f9fa;
            padding: 10px;
            font-size: 16px;
        }

        @page {
            size: landscape;
            margin: 10mm;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo-container">
                <img class="logo" src="{{ asset('frontend/assets/img/favicon.png') }}" alt="Logo PKK">
                <div>
                    <h1>Pemberdayaan Kesejahteraan Keluarga</h1>
                    <p>Kab. Nganjuk, Jawa Timur</p>
                </div>
            </div>
            <h2>Laporan Perbulan</h2>
            {{-- PENGAMAN: Mengganti $created_at menjadi $tanggal agar tidak error --}}
            <h4>Bulan : {{ $tanggal ?? date('F Y') }}</h4>
        </div>

        <div class="separator"></div>
        <div class="signature">
            <p>Tanggal Cetak : {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        </div>

        {{-- JURUS KEBAL: Jika $bidang tidak dikirim Controller, otomatis set ke 'semua' --}}
        @php
        $bidang = $bidang ?? 'semua';
        @endphp



        @if($bidang == 'semua' || $bidang == 'penghayatan')
        <h3>Laporan Penghayatan Dan Pengamalan Pancasila</h3>
        <table align="center" style="font-size:10px;">
            <thead>
                <tr style="background: #e0f2fe;">
                    <th align="center" rowspan="2"><b>NO</b></th>
                    <th align="center" rowspan="2"><b>Kecamatan</b></th>
                    <th align="center" colspan="4"><b>KISAH</b></th>
                    <th align="center" colspan="4"><b>KRISAN</b></th>
                    <th align="center" colspan="4"><b>KILAS</b></th>
                    <th align="center" colspan="4"><b>KIAT</b></th>
                    <th align="center" colspan="4"><b>KISAK</b></th>
                    <th align="center" colspan="4"><b>PKBN</b></th>
                </tr>
                <tr style="background: #e0f2fe;">
                    <th align="center">Keg</th><th align="center">Vol</th><th align="center">Metode</th><th align="center">Sasaran</th>
                    <th align="center">Keg</th><th align="center">Vol</th><th align="center">Metode</th><th align="center">Sasaran</th>
                    <th align="center">Keg</th><th align="center">Vol</th><th align="center">Metode</th><th align="center">Sasaran</th>
                    <th align="center">Keg</th><th align="center">Vol</th><th align="center">Metode</th><th align="center">Sasaran</th>
                    <th align="center">Keg</th><th align="center">Vol</th><th align="center">Metode</th><th align="center">Sasaran</th>
                    <th align="center">Keg</th><th align="center">Vol</th><th align="center">Metode</th><th align="center">Sasaran</th>
                </tr>
            </thead>
            <tbody>
                @php $no_ph = 1; @endphp
                @forelse($penghayatan as $item)
                <tr>
                    <td align="center">{{ $no_ph++ }}</td>
                    <td align="center">{{ $item->nama_kec }}</td>
                    <td align="center">{{ $item->kisah_kegiatan }}</td><td align="center">{{ $item->kisah_vol }}</td><td align="center">{{ $item->kisah_metode }}</td><td align="center">{{ $item->kisah_sasaran }}</td>
                    <td align="center">{{ $item->krisan_kegiatan }}</td><td align="center">{{ $item->krisan_vol }}</td><td align="center">{{ $item->krisan_metode }}</td><td align="center">{{ $item->krisan_sasaran }}</td>
                    <td align="center">{{ $item->kilas_kegiatan }}</td><td align="center">{{ $item->kilas_vol }}</td><td align="center">{{ $item->kilas_metode }}</td><td align="center">{{ $item->kilas_sasaran }}</td>
                    <td align="center">{{ $item->kiat_kegiatan }}</td><td align="center">{{ $item->kiat_vol }}</td><td align="center">{{ $item->kiat_metode }}</td><td align="center">{{ $item->kiat_sasaran }}</td>
                    <td align="center">{{ $item->kisak_kegiatan }}</td><td align="center">{{ $item->kisak_vol }}</td><td align="center">{{ $item->kisak_metode }}</td><td align="center">{{ $item->kisak_sasaran }}</td>
                    <td align="center">{{ $item->pkbn_kegiatan }}</td><td align="center">{{ $item->pkbn_vol }}</td><td align="center">{{ $item->pkbn_metode }}</td><td align="center">{{ $item->pkbn_sasaran }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="26" align="center"><i>Tidak ada data laporan untuk dicetak</i></td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @endif

        @if($bidang == 'semua' || $bidang == 'kader')
        <h3>Laporan Kader Pokja 1</h3>
        <table align="center">
            <thead>
                <tr style="background: #e0f2fe;">
                    <th align="center" rowspan="2"><b>NO</b></th>
                    <th align="center" rowspan="2"><b>Kecamatan</b></th>
                    <th align="center" colspan="2"><b>JML KADER</b></th>
                </tr>
                <tr style="background: #e0f2fe;">
                    <th align="center">Umum</th>
                    <th align="center">Khusus</th>
                </tr>
            </thead>
            <tbody>
                @php $no_pk = 1; $t_umum = 0; $t_khusus = 0; @endphp
                @forelse($laporanpokja1 as $item)
                @php
                $t_umum += $item->kader_umum ?? 0; $t_khusus += $item->kader_khusus ?? 0;
                @endphp
                <tr>
                    <td align="center">{{ $no_pk++ }}</td>
                    <td align="center">{{ $item->nama_kec }}</td>
                    <td align="center">{{ $item->kader_umum }}</td>
                    <td align="center">{{ $item->kader_khusus }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" align="center"><i>Tidak ada data laporan untuk dicetak</i></td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background-color: #f2f2f2;">
                    <td colspan="2" align="center"><b>TOTAL</b></td>
                    <td align="center"><b>{{ $t_umum }}</b></td>
                    <td align="center"><b>{{ $t_khusus }}</b></td>
                </tr>
            </tfoot>
        </table>
        @endif

        @php

        $wakil = \Illuminate\Support\Facades\DB::table('ttds')
        ->whereNull('pokja')
        ->first();

        $ketua = \Illuminate\Support\Facades\DB::table('ttds')
        ->where('pokja', 'Kelompok Kerja I')
        ->where('jabatan', 'Ketua')
        ->first();

        @endphp

        <div class="container-grid">

            {{-- KIRI --}}
            <div style="text-align: left;">
                <div style="text-align: center;">

                    @if($wakil)

                    <a>Mengetahui</a><br>
                    <a>TIM PENGGERAK PKK KABUPATEN NGANJUK</a><br>
                    <a>{{ $wakil->jabatan }}</a><br><br><br><br>

                    <a style="font-weight: bold; text-decoration: underline;">
                        {{ $wakil->nama_terang }}
                    </a>

                    @endif

                </div>
            </div>


            {{-- KANAN --}}
            <div style="text-align: right;">
                <div style="text-align: center;">

                    @if($ketua)

                    <a>
                        Nganjuk,
                        {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                    </a><br>

                    <a>{{ $ketua->pokja }}</a><br>
                    <a>{{ $ketua->jabatan }}</a><br><br><br><br>

                    <a style="font-weight: bold; text-decoration: underline;">
                        {{ $ketua->nama_terang }}
                    </a>

                    @endif

                </div>
            </div>

        </div>


        <script>
            window.onload = function() {
                window.print();
            };
        </script>
    </div>
</body>

</html>