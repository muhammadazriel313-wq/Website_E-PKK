<!DOCTYPE html>
<html>

<head>
    <title>Cetak Laporan Pertahun - Pokja 3</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-bottom: 30px;
        }

        th,
        td {
            padding: 6px;
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
            <h2>Laporan Pertahun</h2>
            <h4>Tahun : {{ $tanggal ?? date('Y') }}</h4>
        </div>

        <div class="separator"></div>
        <div class="signature">
            <p>Tanggal Cetak : {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        </div>

        {{-- JURUS KEBAL SAKLAR TABEL --}}
        @php
        $bidang = $bidang ?? 'semua';
        $pangan = $pangan ?? [];
        $sandang = $sandang ?? [];
        $perumahan = $perumahan ?? [];
        $laporanpokja3 = $laporanpokja3 ?? [];
        @endphp

        @if($bidang == 'semua' || $bidang == 'pangan')
        <h3>Laporan Program Pangan</h3>

        <table align="center">
            <thead>
                <tr style="background: #e0f2fe;">
                    <th><b>NO</b></th>
                    <th><b>Kecamatan</b></th>
                    <th><b>Beras</b></th>
                    <th><b>Non Beras</b></th>
                    <th><b>Peternakan</b></th>
                    <th><b>Perikanan</b></th>
                    <th><b>Warung Hidup</b></th>
                    <th><b>Lumbung Hidup</b></th>
                    <th><b>Toga</b></th>
                    <th><b>Tanaman Keras</b></th>
                    <th><b>Tanaman Lainnya</b></th>
                </tr>
            </thead>

            <tbody>
                @php
                $no_png = 1;

                $t_beras = 0;
                $t_nberas = 0;
                $t_ternak = 0;
                $t_ikan = 0;
                $t_warung = 0;
                $t_lumbung = 0;
                $t_toga = 0;
                $t_keras = 0;
                $t_lainnya = 0;
                @endphp

                @forelse($pangan as $item)

                @php
                $t_beras += $item->beras ?? 0;
                $t_nberas += $item->non_beras ?? 0;
                $t_ternak += $item->peternakan ?? 0;
                $t_ikan += $item->perikanan ?? 0;
                $t_warung += $item->warung_hidup ?? 0;
                $t_lumbung += $item->lumbung_hidup ?? 0;
                $t_toga += $item->toga ?? 0;
                $t_keras += $item->tanaman_keras ?? 0;
                $t_lainnya += $item->tanaman_lainnya ?? 0;
                @endphp

                <tr>
                    <td align="center">{{ $no_png++ }}</td>

                    <td align="center">{{ $item->nama_kec }}</td>

                    <td align="center">{{ $item->beras }}</td>

                    <td align="center">{{ $item->non_beras }}</td>

                    <td align="center">{{ $item->peternakan }}</td>

                    <td align="center">{{ $item->perikanan }}</td>

                    <td align="center">{{ $item->warung_hidup }}</td>

                    <td align="center">{{ $item->lumbung_hidup }}</td>

                    <td align="center">{{ $item->toga }}</td>

                    <td align="center">{{ $item->tanaman_keras }}</td>

                    <td align="center">{{ $item->tanaman_lainnya }}</td>
                </tr>

                @empty

                <tr>
                    <td colspan="11" align="center">
                        <i>Tidak ada data laporan untuk dicetak</i>
                    </td>
                </tr>

                @endforelse
            </tbody>

            <tfoot>
                <tr style="background-color: #f2f2f2;">
                    <td colspan="2" align="center">
                        <b>TOTAL</b>
                    </td>

                    <td align="center">
                        <b>{{ $t_beras }}</b>
                    </td>

                    <td align="center">
                        <b>{{ $t_nberas }}</b>
                    </td>

                    <td align="center">
                        <b>{{ $t_ternak }}</b>
                    </td>

                    <td align="center">
                        <b>{{ $t_ikan }}</b>
                    </td>

                    <td align="center">
                        <b>{{ $t_warung }}</b>
                    </td>

                    <td align="center">
                        <b>{{ $t_lumbung }}</b>
                    </td>

                    <td align="center">
                        <b>{{ $t_toga }}</b>
                    </td>

                    <td align="center">
                        <b>{{ $t_keras }}</b>
                    </td>

                    <td align="center">
                        <b>{{ $t_lainnya }}</b>
                    </td>
                </tr>
            </tfoot>
        </table>
        @endif

        @if($bidang == 'semua' || $bidang == 'sandang')
        <h3>Laporan Industri Rumah Tangga</h3>
        <table align="center">
            <thead>
                <tr style="background: #e0f2fe;">
                    <th><b>NO</b></th>
                    <th><b>Kecamatan</b></th>
                    <th><b>Pangan</b></th>
                    <th><b>Sandang</b></th>
                    <th><b>Jasa</b></th>
                </tr>
            </thead>
            <tbody>
                @php
                $no_sdg = 1;
                $t_pang = 0; $t_sand = 0; $t_jasa = 0;
                @endphp
                @forelse($sandang as $item)
                @php
                $t_pang += $item->pangan ?? 0; $t_sand += $item->sandang ?? 0; $t_jasa += $item->jasa ?? 0;
                @endphp
                <tr>
                    <td align="center">{{ $no_sdg++ }}</td>
                    <td align="center">{{ $item->nama_kec }}</td>
                    <td align="center">{{ $item->pangan }}</td>
                    <td align="center">{{ $item->sandang }}</td>
                    <td align="center">{{ $item->jasa }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" align="center"><i>Tidak ada data laporan untuk dicetak</i></td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background-color: #f2f2f2;">
                    <td colspan="2" align="center"><b>TOTAL</b></td>
                    <td align="center"><b>{{ $t_pang }}</b></td>
                    <td align="center"><b>{{ $t_sand }}</b></td>
                    <td align="center"><b>{{ $t_jasa }}</b></td>
                </tr>
            </tfoot>
        </table>
        @endif

        @if($bidang == 'semua' || $bidang == 'perumahan')
        <h3>Laporan Program Perumahan Dan Tata Laksana Rumah Tangga</h3>
        <table align="center">
            <thead>
                <tr style="background: #e0f2fe;">
                    <th><b>NO</b></th>
                    <th><b>Kecamatan</b></th>
                    <th><b>Layak Huni</b></th>
                    <th><b>Tidak Layak</b></th>
                </tr>
            </thead>
            <tbody>
                @php
                $no_rmh = 1;
                $t_layak = 0; $t_tidak = 0;
                @endphp
                @forelse($perumahan as $item)
                @php
                $t_layak += $item->layak_huni ?? 0; $t_tidak += $item->tidak_layak ?? 0;
                @endphp
                <tr>
                    <td align="center">{{ $no_rmh++ }}</td>
                    <td align="center">{{ $item->nama_kec }}</td>
                    <td align="center">{{ $item->layak_huni }}</td>
                    <td align="center">{{ $item->tidak_layak }}</td>
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
                    <td align="center"><b>{{ $t_layak }}</b></td>
                    <td align="center"><b>{{ $t_tidak }}</b></td>
                </tr>
            </tfoot>
        </table>
        @endif

        @if($bidang == 'semua' || $bidang == 'kader')
        <h3>Laporan Kader Pokja 3</h3>
        <table align="center">
            <thead>
                <tr style="background: #e0f2fe;">
                    <th><b>NO</b></th>
                    <th><b>Kecamatan</b></th>
                    <th><b>Pangan</b></th>
                    <th><b>Sandang</b></th>
                    <th><b>Tata Laksana Rumah</b></th>
                </tr>
            </thead>
            <tbody>
                @php
                $no_kdr = 1;
                $t_kpang = 0; $t_ksand = 0; $t_ktata = 0;
                @endphp
                @forelse($laporanpokja3 as $item)
                @php
                $t_kpang += $item->pangan ?? 0; $t_ksand += $item->sandang ?? 0; $t_ktata += $item->tata_laksana_rumah ?? 0;
                @endphp
                <tr>
                    <td align="center">{{ $no_kdr++ }}</td>
                    <td align="center">{{ $item->nama_kec }}</td>
                    <td align="center">{{ $item->pangan }}</td>
                    <td align="center">{{ $item->sandang }}</td>
                    <td align="center">{{ $item->tata_laksana_rumah }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" align="center"><i>Tidak ada data laporan untuk dicetak</i></td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background-color: #f2f2f2;">
                    <td colspan="2" align="center"><b>TOTAL</b></td>
                    <td align="center"><b>{{ $t_kpang }}</b></td>
                    <td align="center"><b>{{ $t_ksand }}</b></td>
                    <td align="center"><b>{{ $t_ktata }}</b></td>
                </tr>
            </tfoot>
        </table>
        @endif

        @php

        $wakil = \Illuminate\Support\Facades\DB::table('ttds')
        ->whereNull('pokja')
        ->first();

        $ketua = \Illuminate\Support\Facades\DB::table('ttds')
        ->where('pokja', 'Kelompok Kerja III')
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