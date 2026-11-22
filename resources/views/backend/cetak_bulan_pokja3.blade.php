<!DOCTYPE html>
<html>

<head>
    <title>Cetak Laporan Perbulan - Pokja 3</title>
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
            <h2>Laporan Perbulan</h2>
            {{-- PENGAMAN TANGGAL --}}
            <h4>Bulan : {{ $tanggal ?? date('F Y') }}</h4>
        </div>

        <div class="separator"></div>
        <div class="signature">
            <p>Tanggal Cetak : {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        </div>

        {{-- SAKLAR TABEL --}}
        {{-- JURUS KEBAL ANTI ERROR --}}
        @php
        $bidang = $bidang ?? 'semua';
        $pangan = $pangan ?? [];
        $sandang = $sandang ?? [];
        $perumahan = $perumahan ?? [];
        $laporanpokja3 = $laporanpokja3 ?? [];
        @endphp

        {{-- [PERUBAHAN 2026-10-09] Kode lama dinonaktifkan:
        @if($bidang == 'semua' || $bidang == 'pangan')
        <h3>Laporan Program Pangan</h3>
        <table align="center">
            <thead>
                <tr style="background: #e0f2fe;">
                    <th align="center"><b>NO</b></th>
                    <th align="center"><b>Kecamatan</b></th>
                    ...
                </tr>
            </thead>
            ...
        </table>
        @endif
        ... (sandang, perumahan, kader)
        --}}

        {{-- ========================================================= --}}
        {{-- 1. TABEL PANGAN                                            --}}
        {{-- ========================================================= --}}
        @if($bidang == 'semua' || $bidang == 'pangan')
        <h3>Laporan Program Pangan</h3>
        <table align="center" style="font-size: 11px; width: 100%; border-collapse: collapse; margin-bottom: 25px;">
            <thead>
                {{-- [PERUBAHAN 2026-10-09] Header diselaraskan dengan decpangan (3 baris hierarki) --}}
                <tr style="background: #e0f2fe;">
                    <th scope="col" rowspan="3" align="center" style="vertical-align: middle;">No</th>
                    @if (Auth::guard('web')->check())
                    <th scope="col" rowspan="3" align="center" style="vertical-align: middle;">Kecamatan</th>
                    <th scope="col" rowspan="3" align="center" style="vertical-align: middle;">Desa</th>
                    @elseif (Auth::guard('pengguna')->check())
                    <th scope="col" rowspan="3" align="center" style="vertical-align: middle;">Desa</th>
                    @endif
                    <th scope="col" colspan="9" align="center">PANGAN</th>
                </tr>
                <tr style="background: #e0f2fe;">
                    <th scope="col" colspan="2" align="center">MAKANAN POKOK</th>
                    <th scope="col" colspan="6" align="center">PEMANFAATAN PEKARANGAN / HATINYA PKK</th>
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">TANAMAN LAINNYA</th>
                </tr>
                <tr style="background: #e0f2fe;">
                    <th scope="col" align="center">Beras</th>
                    <th scope="col" align="center">Non Beras</th>
                    <th scope="col" align="center">Peternakan</th>
                    <th scope="col" align="center">Perikanan</th>
                    <th scope="col" align="center">Warung Hidup</th>
                    <th scope="col" align="center">Lumbung Hidup</th>
                    <th scope="col" align="center">Toga</th>
                    <th scope="col" align="center">Tan. Keras</th>
                </tr>
            </thead>
            <tbody>
                @php
                $no_png = 1;
                $t_beras = 0; $t_nberas = 0; $t_ternak = 0; $t_ikan = 0;
                $t_warung = 0; $t_lumbung = 0; $t_toga = 0; $t_keras = 0; $t_lainnya = 0;
                @endphp
                @forelse($pangan as $item)
                @php
                $t_beras += $item->beras ?? 0; $t_nberas += $item->non_beras ?? 0;
                $t_ternak += $item->peternakan ?? 0; $t_ikan += $item->perikanan ?? 0;
                $t_warung += $item->warung_hidup ?? 0; $t_lumbung += $item->lumbung_hidup ?? 0;
                $t_toga += $item->toga ?? 0; $t_keras += $item->tanaman_keras ?? 0;
                $t_lainnya += $item->tanaman_lainnya ?? 0;
                @endphp
                <tr>
                    <td align="center">{{ $no_png++ }}</td>
                    @if (Auth::guard('web')->check())
                    <td align="center">{{ $item->nama_kec ?? '-' }}</td>
                    <td align="center">{{ $item->nama_desa ?? '-' }}</td>
                    @elseif (Auth::guard('pengguna')->check())
                    <td align="center">{{ $item->nama_desa ?? '-' }}</td>
                    @endif
                    <td align="center">{{ $item->beras ?? 0 }}</td>
                    <td align="center">{{ $item->non_beras ?? 0 }}</td>
                    <td align="center">{{ $item->peternakan ?? 0 }}</td>
                    <td align="center">{{ $item->perikanan ?? 0 }}</td>
                    <td align="center">{{ $item->warung_hidup ?? 0 }}</td>
                    <td align="center">{{ $item->lumbung_hidup ?? 0 }}</td>
                    <td align="center">{{ $item->toga ?? 0 }}</td>
                    <td align="center">{{ $item->tanaman_keras ?? 0 }}</td>
                    <td align="center">{{ $item->tanaman_lainnya ?? 0 }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ Auth::guard('web')->check() ? 12 : 11 }}" align="center"><i>Tidak ada data laporan untuk dicetak</i></td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background-color: #f2f2f2; font-weight: bold;">
                    <td colspan="{{ Auth::guard('web')->check() ? 3 : 2 }}" align="center">TOTAL</td>
                    <td align="center">{{ $t_beras }}</td>
                    <td align="center">{{ $t_nberas }}</td>
                    <td align="center">{{ $t_ternak }}</td>
                    <td align="center">{{ $t_ikan }}</td>
                    <td align="center">{{ $t_warung }}</td>
                    <td align="center">{{ $t_lumbung }}</td>
                    <td align="center">{{ $t_toga }}</td>
                    <td align="center">{{ $t_keras }}</td>
                    <td align="center">{{ $t_lainnya }}</td>
                </tr>
            </tfoot>
        </table>
        @endif

        {{-- ========================================================= --}}
        {{-- 2. TABEL SANDANG (INDUSTRI RUMAH TANGGA)                  --}}
        {{-- ========================================================= --}}
        @if($bidang == 'semua' || $bidang == 'sandang')
        <h3>Laporan Industri Rumah Tangga</h3>
        <table align="center" style="font-size: 11px; width: 100%; border-collapse: collapse; margin-bottom: 25px;">
            <thead>
                {{-- [PERUBAHAN 2026-10-09] Header diselaraskan dengan decsandang (2 baris hierarki) --}}
                <tr style="background: #e0f2fe;">
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">No</th>
                    @if (Auth::guard('web')->check())
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">Kecamatan</th>
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">Desa</th>
                    @elseif (Auth::guard('pengguna')->check())
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">Desa</th>
                    @endif
                    <th scope="col" colspan="3" align="center">JUMLAH INDUSTRI RUMAH TANGGA</th>
                </tr>
                <tr style="background: #e0f2fe;">
                    <th scope="col" align="center">Pangan</th>
                    <th scope="col" align="center">Sandang</th>
                    <th scope="col" align="center">Jasa</th>
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
                    @if (Auth::guard('web')->check())
                    <td align="center">{{ $item->nama_kec ?? '-' }}</td>
                    <td align="center">{{ $item->nama_desa ?? '-' }}</td>
                    @elseif (Auth::guard('pengguna')->check())
                    <td align="center">{{ $item->nama_desa ?? '-' }}</td>
                    @endif
                    <td align="center">{{ $item->pangan ?? 0 }}</td>
                    <td align="center">{{ $item->sandang ?? 0 }}</td>
                    <td align="center">{{ $item->jasa ?? 0 }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ Auth::guard('web')->check() ? 6 : 5 }}" align="center"><i>Tidak ada data laporan untuk dicetak</i></td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background-color: #f2f2f2; font-weight: bold;">
                    <td colspan="{{ Auth::guard('web')->check() ? 3 : 2 }}" align="center">TOTAL</td>
                    <td align="center">{{ $t_pang }}</td>
                    <td align="center">{{ $t_sand }}</td>
                    <td align="center">{{ $t_jasa }}</td>
                </tr>
            </tfoot>
        </table>
        @endif

        {{-- ========================================================= --}}
        {{-- 3. TABEL PERUMAHAN DAN TATA LAKSANA RUMAH TANGGA          --}}
        {{-- ========================================================= --}}
        @if($bidang == 'semua' || $bidang == 'perumahan')
        <h3>Laporan Program Perumahan Dan Tata Laksana Rumah Tangga</h3>
        <table align="center" style="font-size: 11px; width: 100%; border-collapse: collapse; margin-bottom: 25px;">
            <thead>
                {{-- [PERUBAHAN 2026-10-09] Header diselaraskan dengan decperumahan (2 baris hierarki) --}}
                <tr style="background: #e0f2fe;">
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">NO</th>
                    @if (Auth::guard('web')->check())
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">KECAMATAN</th>
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">DESA</th>
                    @elseif (Auth::guard('pengguna')->check())
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">DESA</th>
                    @endif
                    <th scope="col" colspan="2" align="center">JUMLAH RUMAH</th>
                </tr>
                <tr style="background: #e0f2fe;">
                    <th scope="col" align="center">SEHAT & LAYAK HUNI</th>
                    <th scope="col" align="center">TIDAK SEHAT & TIDAK LAYAK HUNI</th>
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
                    @if (Auth::guard('web')->check())
                    <td align="center">{{ $item->nama_kec ?? '-' }}</td>
                    <td align="center">{{ $item->nama_desa ?? '-' }}</td>
                    @elseif (Auth::guard('pengguna')->check())
                    <td align="center">{{ $item->nama_desa ?? '-' }}</td>
                    @endif
                    <td align="center">{{ $item->layak_huni ?? 0 }}</td>
                    <td align="center">{{ $item->tidak_layak ?? 0 }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ Auth::guard('web')->check() ? 5 : 4 }}" align="center"><i>Tidak ada data laporan untuk dicetak</i></td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background-color: #f2f2f2; font-weight: bold;">
                    <td colspan="{{ Auth::guard('web')->check() ? 3 : 2 }}" align="center">TOTAL</td>
                    <td align="center">{{ $t_layak }}</td>
                    <td align="center">{{ $t_tidak }}</td>
                </tr>
            </tfoot>
        </table>
        @endif

        {{-- ========================================================= --}}
        {{-- 4. TABEL KADER POKJA 3                                     --}}
        {{-- ========================================================= --}}
        @if($bidang == 'semua' || $bidang == 'kader')
        <h3>Laporan Kader Pokja 3</h3>
        <table align="center" style="font-size: 11px; width: 100%; border-collapse: collapse; margin-bottom: 25px;">
            <thead>
                {{-- [PERUBAHAN 2026-10-09] Header diselaraskan dengan declaporanpokja3 (2 baris hierarki; label web 'Jasa' untuk tata_laksana_rumah) --}}
                <tr style="background: #e0f2fe;">
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">No</th>
                    @if (Auth::guard('web')->check())
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">Kecamatan</th>
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">Desa</th>
                    @elseif (Auth::guard('pengguna')->check())
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">Desa</th>
                    @endif
                    <th scope="col" colspan="3" align="center">JUMLAH KADER</th>
                </tr>
                <tr style="background: #e0f2fe;">
                    <th scope="col" align="center">Pangan</th>
                    <th scope="col" align="center">Sandang</th>
                    <th scope="col" align="center">Jasa</th>
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
                    @if (Auth::guard('web')->check())
                    <td align="center">{{ $item->nama_kec ?? '-' }}</td>
                    <td align="center">{{ $item->nama_desa ?? '-' }}</td>
                    @elseif (Auth::guard('pengguna')->check())
                    <td align="center">{{ $item->nama_desa ?? '-' }}</td>
                    @endif
                    <td align="center">{{ $item->pangan ?? 0 }}</td>
                    <td align="center">{{ $item->sandang ?? 0 }}</td>
                    <td align="center">{{ $item->tata_laksana_rumah ?? 0 }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ Auth::guard('web')->check() ? 6 : 5 }}" align="center"><i>Tidak ada data laporan untuk dicetak</i></td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background-color: #f2f2f2; font-weight: bold;">
                    <td colspan="{{ Auth::guard('web')->check() ? 3 : 2 }}" align="center">TOTAL</td>
                    <td align="center">{{ $t_kpang }}</td>
                    <td align="center">{{ $t_ksand }}</td>
                    <td align="center">{{ $t_ktata }}</td>
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