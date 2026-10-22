<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Cetak Laporan Perbulan - Pokja 4</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 25px;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            vertical-align: middle;
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

        .nama {
            margin-top: 60px;
            text-decoration: underline;
            font-weight: bold;
        }

        @page {
            size: landscape;
            margin: 10mm;
        }

        @media print {
            body {
                margin: 5mm;
                font-size: 10px;
            }
            table {
                font-size: 9px;
                table-layout: auto;
                word-wrap: break-word;
            }
            th, td {
                padding: 3px 4px;
            }
            h3 {
                font-size: 13px;
                padding: 4px;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="container">
        <div class="header">
            <div class="logo-container">
                <img class="logo"
                    src="{{ asset('frontend/assets/img/favicon.png') }}"
                    alt="Logo PKK">
                <div>
                    <h1>Pemberdayaan Kesejahteraan Keluarga</h1>
                    <p>Kab. Nganjuk, Jawa Timur</p>
                </div>
            </div>
            <h2>Laporan Perbulan</h2>
            <h4>Bulan : {{ $tanggal ?? date('F Y') }}</h4>
        </div>

        <div class="separator"></div>

        <div class="signature">
            <p>
                Tanggal Cetak :
                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </p>
        </div>

        {{-- JURUS KEBAL --}}
        @php
        $bidang = $bidang ?? 'semua';
        $kesehatan = $kesehatan ?? [];
        $kelestarian = $kelestarian ?? [];
        $perencanaan = $perencanaan ?? [];
        $laporanpokja4 = $laporanpokja4 ?? [];
        $inovasiRDB = $inovasiRDB ?? [];
        $inovasiRDT = $inovasiRDT ?? [];
        $inovasiPos = $inovasiPos ?? [];
        $inovasiKP4 = $inovasiKP4 ?? [];
        @endphp

        {{-- [PERUBAHAN 2026-10-09] Header, kolom desa, catatan, dan total diselaraskan persis dengan web acuan (deckesehatan, deckelestarian, decperencanaan, declaporanpokja4) --}}
        {{-- TABEL KESEHATAN --}}
        @if($bidang == 'semua' || $bidang == 'kesehatan')
        <h3>Laporan Kesehatan</h3>
        <table>
            <thead>
                <tr style="background:#e0f2fe;">
                    <th rowspan="4">No</th>
                    @if (Auth::guard('web')->check())
                        <th rowspan="4">Kecamatan</th>
                        <th rowspan="4">Desa</th>
                    @elseif (Auth::guard('pengguna')->check())
                        <th rowspan="4">Desa</th>
                    @endif
                    <th colspan="5">Kesehatan</th>
                    <th rowspan="4">Keterangan</th>
                </tr>
                <tr style="background:#e0f2fe;">
                    <th colspan="5">Posyandu</th>
                </tr>
                <tr style="background:#e0f2fe;">
                    <th rowspan="2">Jumlah</th>
                    <th rowspan="2">Terintegrasi</th>
                    <th colspan="3">Lansia</th>
                </tr>
                <tr style="background:#e0f2fe;">
                    <th>Jml Klp</th>
                    <th>Jml Anggota</th>
                    <th>Jml yg Memiliki<br>Kartu Berobat Gratis</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $no = 1; 
                    $t_pos = 0; 
                    $t_iter = 0; 
                    $t_klp = 0; 
                    $t_ang = 0; 
                    $t_grt = 0; 
                @endphp
                @forelse($kesehatan as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    @if (Auth::guard('web')->check())
                        <td>{{ $item->nama_kec ?? '-' }}</td>
                        <td>{{ $item->nama_desa ?? '-' }}</td>
                    @elseif (Auth::guard('pengguna')->check())
                        <td>{{ $item->nama_desa ?? '-' }}</td>
                    @endif
                    <td>{{ $item->jumlah_posyandu ?? '0' }}</td>
                    <td>{{ $item->jumlah_posyandu_iterasi ?? '0' }}</td>
                    <td>{{ $item->jumlah_klp ?? '0' }}</td>
                    <td>{{ $item->jumlah_anggota ?? '0' }}</td>
                    <td>{{ $item->jumlah_kartu_gratis ?? '0' }}</td>
                    <td>{{ $item->catatan ?: '-' }}</td>
                </tr>
                @php 
                    $t_pos += (int)($item->jumlah_posyandu ?? 0); 
                    $t_iter += (int)($item->jumlah_posyandu_iterasi ?? 0); 
                    $t_klp += (int)($item->jumlah_klp ?? 0); 
                    $t_ang += (int)($item->jumlah_anggota ?? 0); 
                    $t_grt += (int)($item->jumlah_kartu_gratis ?? 0); 
                @endphp
                @empty
                <tr>
                    <td colspan="{{ Auth::guard('web')->check() ? 9 : 8 }}">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background:#f2f2f2; font-weight:bold;">
                    <td colspan="{{ Auth::guard('web')->check() ? 3 : 2 }}">Total</td>
                    <td>{{ $t_pos }}</td>
                    <td>{{ $t_iter }}</td>
                    <td>{{ $t_klp }}</td>
                    <td>{{ $t_ang }}</td>
                    <td>{{ $t_grt }}</td>
                    <td>-</td>
                </tr>
            </tfoot>
        </table>
        @endif

        {{-- TABEL KELESTARIAN --}}
        @if($bidang == 'semua' || $bidang == 'kelestarian')
        <h3>Laporan Kelestarian Lingkungan Hidup</h3>
        <table>
            <thead>
                <tr style="background:#e0f2fe;">
                    <th rowspan="3">No</th>
                    @if (Auth::guard('web')->check())
                        <th rowspan="3">Kecamatan</th>
                        <th rowspan="3">Desa</th>
                    @elseif (Auth::guard('pengguna')->check())
                        <th rowspan="3">Desa</th>
                    @endif
                    <th colspan="7">Kelestarian Lingkungan Hidup</th>
                    <th rowspan="3">Keterangan</th>
                </tr>
                <tr style="background:#e0f2fe;">
                    <th colspan="3">Jumlah Rumah yang Memiliki</th>
                    <th rowspan="2">Jumlah MCK</th>
                    <th colspan="3">Jumlah KK yang Menggunakan Air</th>
                </tr>
                <tr style="background:#e0f2fe;">
                    <th>Jamban</th>
                    <th>SPAL</th>
                    <th>Tempat Pembuangan Sampah</th>
                    <th>PDAM</th>
                    <th>Sumur</th>
                    <th>Lain Lain</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $no = 1; 
                    $t_jam = 0; $t_spal = 0; $t_tps = 0; $t_mck = 0; 
                    $t_pdam = 0; $t_sumur = 0; $t_dll = 0; 
                @endphp
                @forelse($kelestarian as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    @if (Auth::guard('web')->check())
                        <td>{{ $item->nama_kec ?? '-' }}</td>
                        <td>{{ $item->nama_desa ?? '-' }}</td>
                    @elseif (Auth::guard('pengguna')->check())
                        <td>{{ $item->nama_desa ?? '-' }}</td>
                    @endif
                    <td>{{ $item->jamban ?? '0' }}</td>
                    <td>{{ $item->spal ?? '0' }}</td>
                    <td>{{ $item->tps ?? '0' }}</td>
                    <td>{{ $item->mck ?? '0' }}</td>
                    <td>{{ $item->pdam ?? '0' }}</td>
                    <td>{{ $item->sumur ?? '0' }}</td>
                    <td>{{ $item->dll ?? '0' }}</td>
                    <td>{{ $item->catatan ?: '-' }}</td>
                </tr>
                @php 
                    $t_jam += (int)($item->jamban ?? 0); 
                    $t_spal += (int)($item->spal ?? 0); 
                    $t_tps += (int)($item->tps ?? 0); 
                    $t_mck += (int)($item->mck ?? 0); 
                    $t_pdam += (int)($item->pdam ?? 0); 
                    $t_sumur += (int)($item->sumur ?? 0); 
                    $t_dll += (int)($item->dll ?? 0); 
                @endphp
                @empty
                <tr>
                    <td colspan="{{ Auth::guard('web')->check() ? 11 : 10 }}">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background:#f2f2f2; font-weight:bold;">
                    <td colspan="{{ Auth::guard('web')->check() ? 3 : 2 }}">Total</td>
                    <td>{{ $t_jam }}</td>
                    <td>{{ $t_spal }}</td>
                    <td>{{ $t_tps }}</td>
                    <td>{{ $t_mck }}</td>
                    <td>{{ $t_pdam }}</td>
                    <td>{{ $t_sumur }}</td>
                    <td>{{ $t_dll }}</td>
                    <td>-</td>
                </tr>
            </tfoot>
        </table>
        @endif

        {{-- TABEL PERENCANAAN --}}
        @if($bidang == 'semua' || $bidang == 'perencanaan')
        <h3>Laporan Perencanaan Sehat</h3>
        <table>
            <thead>
                <tr style="background:#e0f2fe;">
                    <th rowspan="3">No</th>
                    @if (Auth::guard('web')->check())
                        <th rowspan="3">Kecamatan</th>
                        <th rowspan="3">Desa</th>
                    @elseif (Auth::guard('pengguna')->check())
                        <th rowspan="3">Desa</th>
                    @endif
                    <th colspan="5">Perencanaan Sehat</th>
                    <th rowspan="3">Keterangan</th>
                </tr>
                <tr style="background:#e0f2fe;">
                    <th rowspan="2">Jumlah PUS</th>
                    <th rowspan="2">Jumlah WUS</th>
                    <th colspan="2">Jumlah Aseptor KB</th>
                    <th rowspan="2">Jumlah KK yang Memiliki Tabungan</th>
                </tr>
                <tr style="background:#e0f2fe;">
                    <th>L</th>
                    <th>P</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $no = 1; 
                    $t_pus = 0; $t_wus = 0; $t_kbp = 0; $t_kbw = 0; $t_tbg = 0; 
                @endphp
                @forelse($perencanaan as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    @if (Auth::guard('web')->check())
                        <td>{{ $item->nama_kec ?? '-' }}</td>
                        <td>{{ $item->nama_desa ?? '-' }}</td>
                    @elseif (Auth::guard('pengguna')->check())
                        <td>{{ $item->nama_desa ?? '-' }}</td>
                    @endif
                    <td>{{ $item->J_Psubur ?? '0' }}</td>
                    <td>{{ $item->J_Wsubur ?? '0' }}</td>
                    <td>{{ $item->Kb_p ?? '0' }}</td>
                    <td>{{ $item->Kb_w ?? '0' }}</td>
                    <td>{{ $item->Kk_tbg ?? '0' }}</td>
                    <td>{{ $item->catatan ?: '-' }}</td>
                </tr>
                @php 
                    $t_pus += (int)($item->J_Psubur ?? 0); 
                    $t_wus += (int)($item->J_Wsubur ?? 0); 
                    $t_kbp += (int)($item->Kb_p ?? 0); 
                    $t_kbw += (int)($item->Kb_w ?? 0); 
                    $t_tbg += (int)($item->Kk_tbg ?? 0); 
                @endphp
                @empty
                <tr>
                    <td colspan="{{ Auth::guard('web')->check() ? 9 : 8 }}">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background:#f2f2f2; font-weight:bold;">
                    <td colspan="{{ Auth::guard('web')->check() ? 3 : 2 }}">Total</td>
                    <td>{{ $t_pus }}</td>
                    <td>{{ $t_wus }}</td>
                    <td>{{ $t_kbp }}</td>
                    <td>{{ $t_kbw }}</td>
                    <td>{{ $t_tbg }}</td>
                    <td>-</td>
                </tr>
            </tfoot>
        </table>
        @endif

        {{-- TABEL KADER --}}
        @if($bidang == 'semua' || $bidang == 'kader')
        <h3>Laporan Jumlah Kader Pokja 4</h3>
        <table>
            <thead>
                <tr style="background:#e0f2fe;">
                    <th rowspan="2">No</th>
                    @if (Auth::guard('web')->check())
                        <th rowspan="2">Kecamatan</th>
                        <th rowspan="2">Desa</th>
                    @elseif (Auth::guard('pengguna')->check())
                        <th rowspan="2">Desa</th>
                    @endif
                    <th colspan="6">Jumlah Kader</th>
                    <th rowspan="2">Keterangan</th>
                </tr>
                <tr style="background:#e0f2fe;">
                    <th>Posyandu</th>
                    <th>Gizi</th>
                    <th>Kesling</th>
                    <th>Penyuluhan Narkoba</th>
                    <th>PHBS</th>
                    <th>KB</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $no = 1; 
                    $t_posk = 0; $t_giz = 0; $t_kes = 0; $t_nar = 0; $t_phbs = 0; $t_kb = 0; 
                @endphp
                @forelse($laporanpokja4 as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    @if (Auth::guard('web')->check())
                        <td>{{ $item->nama_kec ?? '-' }}</td>
                        <td>{{ $item->nama_desa ?? '-' }}</td>
                    @elseif (Auth::guard('pengguna')->check())
                        <td>{{ $item->nama_desa ?? '-' }}</td>
                    @endif
                    <td>{{ $item->posyandu ?? '0' }}</td>
                    <td>{{ $item->gizi ?? '0' }}</td>
                    <td>{{ $item->kesling ?? '0' }}</td>
                    <td>{{ $item->penyuluhan_narkoba ?? '0' }}</td>
                    <td>{{ $item->PHBS ?? '0' }}</td>
                    <td>{{ $item->KB ?? '0' }}</td>
                    <td>{{ $item->catatan ?: '-' }}</td>
                </tr>
                @php 
                    $t_posk += (int)($item->posyandu ?? 0); 
                    $t_giz += (int)($item->gizi ?? 0); 
                    $t_kes += (int)($item->kesling ?? 0); 
                    $t_nar += (int)($item->penyuluhan_narkoba ?? 0); 
                    $t_phbs += (int)($item->PHBS ?? 0); 
                    $t_kb += (int)($item->KB ?? 0); 
                @endphp
                @empty
                <tr>
                    <td colspan="{{ Auth::guard('web')->check() ? 10 : 9 }}">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background:#f2f2f2; font-weight:bold;">
                    <td colspan="{{ Auth::guard('web')->check() ? 3 : 2 }}">Total</td>
                    <td>{{ $t_posk }}</td>
                    <td>{{ $t_giz }}</td>
                    <td>{{ $t_kes }}</td>
                    <td>{{ $t_nar }}</td>
                    <td>{{ $t_phbs }}</td>
                    <td>{{ $t_kb }}</td>
                    <td>-</td>
                </tr>
            </tfoot>
        </table>
        @endif

        {{-- ===================================================== --}}
        {{-- LAPORAN INOVASI --}}
        {{-- ===================================================== --}}

        @if(strpos($bidang, 'inovasi') !== false || $bidang == 'semua')

        @php
        $labelInovasi = "";

        if($bidang == 'inovasi_prioritas') {
        $labelInovasi = "(Prioritas)";
        }

        if($bidang == 'inovasi_unggulan') {
        $labelInovasi = "(Unggulan)";
        }
        @endphp

        <h3>Laporan Inovasi {{ $labelInovasi }}</h3>

        {{-- [PERUBAHAN 2026-10-09] Penyelarasan kolom wilayah (Kecamatan + Desa / Desa), hierarki header, dan total tabel Inovasi Pokja 4 --}}
        {{-- ===================================================== --}}
        {{-- REKAP DESA BULANAN --}}
        {{-- ===================================================== --}}

        @if(count($inovasiRDB) > 0)

        <h4>Rekap Desa Bulanan</h4>

        <table>
            <thead>
                <tr style="background:#e0f2fe;">
                    <th rowspan="3">NO</th>
                    @if (Auth::guard('web')->check())
                        <th rowspan="3">Kecamatan</th>
                        <th rowspan="3">Desa</th>
                    @elseif (Auth::guard('pengguna')->check())
                        <th rowspan="3">Desa</th>
                    @endif
                    <th rowspan="3">Kategori</th>

                    <th colspan="3">JUMLAH</th>
                    <th colspan="4">JUMLAH IBU</th>
                    <th colspan="6">JUMLAH BAYI</th>
                    <th colspan="2">BALITA MENINGGAL</th>
                </tr>
                <tr style="background:#e0f2fe;">
                    <th rowspan="2">RW</th>
                    <th rowspan="2">RT</th>
                    <th rowspan="2">Dasa Wisma</th>

                    <th rowspan="2">Hamil</th>
                    <th rowspan="2">Melahirkan</th>
                    <th rowspan="2">Nifas</th>
                    <th rowspan="2">Meninggal</th>

                    <th colspan="2">Lahir</th>
                    <th colspan="2">Akte</th>
                    <th colspan="2">Meninggal</th>

                    <th colspan="2"></th>
                </tr>
                <tr style="background:#e0f2fe;">
                    <th>L</th>
                    <th>P</th>

                    <th>Ada</th>
                    <th>Tidak</th>

                    <th>L</th>
                    <th>P</th>

                    <th>L</th>
                    <th>P</th>
                </tr>
            </thead>

            <tbody>
                @forelse($inovasiRDB as $no => $item)
                <tr>
                    <td>{{ $no + 1 }}</td>
                    @if (Auth::guard('web')->check())
                        <td>{{ $item->nama_kec ?? '-' }}</td>
                        <td>{{ $item->nama_desa ?? '-' }}</td>
                    @elseif (Auth::guard('pengguna')->check())
                        <td>{{ $item->nama_desa ?? '-' }}</td>
                    @endif
                    <td>{{ ucfirst($item->kategori ?? '-') }}</td>

                    <td>{{ $item->rw ?? 0 }}</td>
                    <td>{{ $item->rt ?? 0 }}</td>
                    <td>{{ $item->dasa_wisma ?? 0 }}</td>

                    <td>{{ $item->hamil ?? 0 }}</td>
                    <td>{{ $item->melahirkan ?? 0 }}</td>
                    <td>{{ $item->nifas ?? 0 }}</td>
                    <td>{{ $item->meninggal ?? 0 }}</td>

                    <td>{{ $item->bayi_lahir_l ?? 0 }}</td>
                    <td>{{ $item->bayi_lahir_p ?? 0 }}</td>

                    <td>{{ $item->akte_kelahiran_ada ?? 0 }}</td>
                    <td>{{ $item->akte_kelahiran_tidak ?? 0 }}</td>

                    <td>{{ $item->bayi_meninggal_l ?? 0 }}</td>
                    <td>{{ $item->bayi_meninggal_p ?? 0 }}</td>

                    <td>{{ $item->balita_meninggal_l ?? 0 }}</td>
                    <td>{{ $item->balita_meninggal_p ?? 0 }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ Auth::guard('web')->check() ? 19 : 18 }}" align="center">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background:#f1f5f9; font-weight:bold;">
                    <td colspan="{{ Auth::guard('web')->check() ? 4 : 3 }}" align="center">TOTAL</td>
                    <td>{{ $inovasiRDB->sum('rw') }}</td>
                    <td>{{ $inovasiRDB->sum('rt') }}</td>
                    <td>{{ $inovasiRDB->sum('dasa_wisma') }}</td>
                    <td>{{ $inovasiRDB->sum('hamil') }}</td>
                    <td>{{ $inovasiRDB->sum('melahirkan') }}</td>
                    <td>{{ $inovasiRDB->sum('nifas') }}</td>
                    <td>{{ $inovasiRDB->sum('meninggal') }}</td>
                    <td>{{ $inovasiRDB->sum('bayi_lahir_l') }}</td>
                    <td>{{ $inovasiRDB->sum('bayi_lahir_p') }}</td>
                    <td>{{ $inovasiRDB->sum('akte_kelahiran_ada') }}</td>
                    <td>{{ $inovasiRDB->sum('akte_kelahiran_tidak') }}</td>
                    <td>{{ $inovasiRDB->sum('bayi_meninggal_l') }}</td>
                    <td>{{ $inovasiRDB->sum('bayi_meninggal_p') }}</td>
                    <td>{{ $inovasiRDB->sum('balita_meninggal_l') }}</td>
                    <td>{{ $inovasiRDB->sum('balita_meninggal_p') }}</td>
                </tr>
            </tfoot>
        </table>

        @endif


        {{-- ===================================================== --}}
        {{-- REKAP DESA TAHUNAN --}}
        {{-- ===================================================== --}}

        @if(count($inovasiRDT) > 0)

        <h4>Rekap Desa Tahunan</h4>

        <table>
            <thead>
                <tr style="background:#e0f2fe;">
                    <th rowspan="2">NO</th>
                    @if (Auth::guard('web')->check())
                        <th rowspan="2">Kecamatan</th>
                        <th rowspan="2">Desa</th>
                    @elseif (Auth::guard('pengguna')->check())
                        <th rowspan="2">Desa</th>
                    @endif
                    <th rowspan="2">Kategori</th>

                    <th colspan="5">Kesehatan</th>
                    <th colspan="7">Lingkungan</th>
                    <th colspan="4">Program Lingkungan</th>
                    <th colspan="4">KB</th>
                    <th colspan="5">Program PKK</th>
                </tr>

                <tr style="background:#e0f2fe;">
                    {{-- KESEHATAN --}}
                    <th>Kader</th>
                    <th>Gizi</th>
                    <th>Kesling</th>
                    <th>PHBS</th>
                    <th>KB</th>

                    {{-- LINGKUNGAN --}}
                    <th>Posyandu</th>
                    <th>Imunisasi</th>
                    <th>PKG</th>
                    <th>TBC</th>
                    <th>Jamban</th>
                    <th>SPAL</th>
                    <th>TPS</th>

                    {{-- PROGRAM LINGKUNGAN --}}
                    <th>MCK</th>
                    <th>PDAM</th>
                    <th>Sumur</th>
                    <th>Lain</th>

                    {{-- KB --}}
                    <th>PUS</th>
                    <th>WUS</th>
                    <th>Akseptor L</th>
                    <th>Akseptor P</th>

                    {{-- PROGRAM PKK --}}
                    <th>KK Tabungan</th>
                    <th>KK Asuransi</th>
                    <th>Kes. Program</th>
                    <th>Lingkungan</th>
                    <th>Perencanaan</th>
                </tr>
            </thead>

            <tbody>
                @forelse($inovasiRDT as $no => $item)
                <tr>
                    <td>{{ $no + 1 }}</td>
                    @if (Auth::guard('web')->check())
                        <td>{{ $item->nama_kec ?? '-' }}</td>
                        <td>{{ $item->nama_desa ?? '-' }}</td>
                    @elseif (Auth::guard('pengguna')->check())
                        <td>{{ $item->nama_desa ?? '-' }}</td>
                    @endif
                    <td>{{ ucfirst($item->kategori ?? '-') }}</td>

                    {{-- KESEHATAN --}}
                    <td>{{ $item->kader_kesehatan ?? 0 }}</td>
                    <td>{{ $item->gizi ?? 0 }}</td>
                    <td>{{ $item->kesling ?? 0 }}</td>
                    <td>{{ $item->phbs ?? 0 }}</td>
                    <td>{{ $item->kb ?? 0 }}</td>

                    {{-- LINGKUNGAN --}}
                    <td>{{ $item->posyandu ?? 0 }}</td>
                    <td>{{ $item->imunisasi_vaksinasi_bayi_balita ?? 0 }}</td>
                    <td>{{ $item->pkg ?? 0 }}</td>
                    <td>{{ $item->tbc ?? 0 }}</td>
                    <td>{{ $item->jamban_wc ?? 0 }}</td>
                    <td>{{ $item->spal ?? 0 }}</td>
                    <td>{{ $item->tps ?? 0 }}</td>

                    {{-- PROGRAM LINGKUNGAN --}}
                    <td>{{ $item->jumlah_mck ?? 0 }}</td>
                    <td>{{ $item->pdam ?? 0 }}</td>
                    <td>{{ $item->sumur ?? 0 }}</td>
                    <td>{{ $item->lain_lain ?? 0 }}</td>

                    {{-- KB --}}
                    <td>{{ $item->jml_pus ?? 0 }}</td>
                    <td>{{ $item->jml_wus ?? 0 }}</td>
                    <td>{{ $item->akseptor_kb_l ?? 0 }}</td>
                    <td>{{ $item->akseptor_kb_p ?? 0 }}</td>

                    {{-- PROGRAM PKK --}}
                    <td>{{ $item->jml_kk_tabungan ?? 0 }}</td>
                    <td>{{ $item->jml_kk_asuransi ?? 0 }}</td>
                    <td>{{ $item->kesehatan_program ?? 0 }}</td>
                    <td>{{ $item->kelestarian_lingkungan_hidup ?? 0 }}</td>
                    <td>{{ $item->perencanaan_sehat_program ?? 0 }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ Auth::guard('web')->check() ? 30 : 29 }}" align="center">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background:#f1f5f9; font-weight:bold;">
                    <td colspan="{{ Auth::guard('web')->check() ? 4 : 3 }}" align="center">TOTAL</td>
                    <td>{{ $inovasiRDT->sum('kader_kesehatan') }}</td>
                    <td>{{ $inovasiRDT->sum('gizi') }}</td>
                    <td>{{ $inovasiRDT->sum('kesling') }}</td>
                    <td>{{ $inovasiRDT->sum('phbs') }}</td>
                    <td>{{ $inovasiRDT->sum('kb') }}</td>
                    <td>{{ $inovasiRDT->sum('posyandu') }}</td>
                    <td>{{ $inovasiRDT->sum('imunisasi_vaksinasi_bayi_balita') }}</td>
                    <td>{{ $inovasiRDT->sum('pkg') }}</td>
                    <td>{{ $inovasiRDT->sum('tbc') }}</td>
                    <td>{{ $inovasiRDT->sum('jamban_wc') }}</td>
                    <td>{{ $inovasiRDT->sum('spal') }}</td>
                    <td>{{ $inovasiRDT->sum('tps') }}</td>
                    <td>{{ $inovasiRDT->sum('jumlah_mck') }}</td>
                    <td>{{ $inovasiRDT->sum('pdam') }}</td>
                    <td>{{ $inovasiRDT->sum('sumur') }}</td>
                    <td>{{ $inovasiRDT->sum('lain_lain') }}</td>
                    <td>{{ $inovasiRDT->sum('jml_pus') }}</td>
                    <td>{{ $inovasiRDT->sum('jml_wus') }}</td>
                    <td>{{ $inovasiRDT->sum('akseptor_kb_l') }}</td>
                    <td>{{ $inovasiRDT->sum('akseptor_kb_p') }}</td>
                    <td>{{ $inovasiRDT->sum('jml_kk_tabungan') }}</td>
                    <td>{{ $inovasiRDT->sum('jml_kk_asuransi') }}</td>
                    <td>{{ $inovasiRDT->sum('kesehatan_program') }}</td>
                    <td>{{ $inovasiRDT->sum('kelestarian_lingkungan_hidup') }}</td>
                    <td>{{ $inovasiRDT->sum('perencanaan_sehat_program') }}</td>
                </tr>
            </tfoot>
        </table>

        @endif


        {{-- ===================================================== --}}
        {{-- POSYANDU --}}
        {{-- ===================================================== --}}

        @if(count($inovasiPos) > 0)

        <h4>Data Posyandu</h4>

        <table>
            <thead>
                <tr style="background:#e0f2fe;">
                    <th rowspan="2">NO</th>
                    @if (Auth::guard('web')->check())
                        <th rowspan="2">Kecamatan</th>
                        <th rowspan="2">Desa</th>
                    @elseif (Auth::guard('pengguna')->check())
                        <th rowspan="2">Desa</th>
                    @endif
                    <th rowspan="2">Kategori</th>
                    <th rowspan="2">Bulan</th>

                    <th colspan="4">Ibu</th>
                    <th colspan="7">KB</th>
                    <th colspan="2">Balita</th>
                    <th colspan="2">Buku KIA</th>
                    <th colspan="2">Datang</th>
                    <th colspan="2">Naik</th>
                    <th colspan="2">Vit A</th>
                    <th colspan="2">PMT</th>
                    <th colspan="2">Imunisasi TT</th>
                </tr>

                <tr style="background:#e0f2fe;">
                    {{-- IBU --}}
                    <th>Ibu Hamil</th>
                    <th>Diperiksa</th>
                    <th>Fe Tablet</th>
                    <th>Ibu Menyusui</th>

                    {{-- KB --}}
                    <th>Kondom</th>
                    <th>Pil</th>
                    <th>Implant</th>
                    <th>MOP</th>
                    <th>MOW</th>
                    <th>IUD</th>
                    <th>Suntikan</th>

                    {{-- BALITA --}}
                    <th>L</th>
                    <th>P</th>

                    {{-- BUKU KIA --}}
                    <th>L</th>
                    <th>P</th>

                    {{-- DATANG --}}
                    <th>L</th>
                    <th>P</th>

                    {{-- NAIK --}}
                    <th>L</th>
                    <th>P</th>

                    {{-- VIT A --}}
                    <th>L</th>
                    <th>P</th>

                    {{-- PMT --}}
                    <th>L</th>
                    <th>P</th>

                    {{-- TT --}}
                    <th>TT1</th>
                    <th>TT2</th>
                </tr>
            </thead>

            <tbody>
                @forelse($inovasiPos as $no => $item)
                <tr>
                    <td>{{ $no + 1 }}</td>
                    @if (Auth::guard('web')->check())
                        <td>{{ $item->nama_kec ?? '-' }}</td>
                        <td>{{ $item->nama_desa ?? '-' }}</td>
                    @elseif (Auth::guard('pengguna')->check())
                        <td>{{ $item->nama_desa ?? '-' }}</td>
                    @endif
                    <td>{{ ucfirst($item->kategori ?? '-') }}</td>
                    <td>{{ $item->bulan ?? '-' }}</td>

                    {{-- IBU --}}
                    <td>{{ $item->jml_ibu_hamil ?? 0 }}</td>
                    <td>{{ $item->diperiksa ?? 0 }}</td>
                    <td>{{ $item->fe_tablet_darah ?? 0 }}</td>
                    <td>{{ $item->jml_ibu_menyusui ?? 0 }}</td>

                    {{-- KB --}}
                    <td>{{ $item->kondom ?? 0 }}</td>
                    <td>{{ $item->pil ?? 0 }}</td>
                    <td>{{ $item->implant ?? 0 }}</td>
                    <td>{{ $item->mop ?? 0 }}</td>
                    <td>{{ $item->mow ?? 0 }}</td>
                    <td>{{ $item->iud ?? 0 }}</td>
                    <td>{{ $item->suntikan ?? 0 }}</td>

                    {{-- BALITA --}}
                    <td>{{ $item->jml_balita_l ?? 0 }}</td>
                    <td>{{ $item->jml_balita_p ?? 0 }}</td>

                    {{-- BUKU KIA --}}
                    <td>{{ $item->buku_kia_l ?? 0 }}</td>
                    <td>{{ $item->buku_kia_p ?? 0 }}</td>

                    {{-- DATANG --}}
                    <td>{{ $item->datang_l ?? 0 }}</td>
                    <td>{{ $item->datang_p ?? 0 }}</td>

                    {{-- NAIK --}}
                    <td>{{ $item->naik_l ?? 0 }}</td>
                    <td>{{ $item->naik_p ?? 0 }}</td>

                    {{-- VIT A --}}
                    <td>{{ $item->vit_a_l ?? 0 }}</td>
                    <td>{{ $item->vit_a_p ?? 0 }}</td>

                    {{-- PMT --}}
                    <td>{{ $item->pmt_l ?? 0 }}</td>
                    <td>{{ $item->pmt_p ?? 0 }}</td>

                    {{-- IMUNISASI --}}
                    <td>{{ $item->imunisasi_tt_1 ?? 0 }}</td>
                    <td>{{ $item->imunisasi_tt_2 ?? 0 }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ Auth::guard('web')->check() ? 29 : 28 }}" align="center">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background:#f1f5f9; font-weight:bold;">
                    <td colspan="{{ Auth::guard('web')->check() ? 5 : 4 }}" align="center">TOTAL</td>
                    {{-- IBU --}}
                    <td>{{ $inovasiPos->sum('jml_ibu_hamil') }}</td>
                    <td>{{ $inovasiPos->sum('diperiksa') }}</td>
                    <td>{{ $inovasiPos->sum('fe_tablet_darah') }}</td>
                    <td>{{ $inovasiPos->sum('jml_ibu_menyusui') }}</td>

                    {{-- KB --}}
                    <td>{{ $inovasiPos->sum('kondom') }}</td>
                    <td>{{ $inovasiPos->sum('pil') }}</td>
                    <td>{{ $inovasiPos->sum('implant') }}</td>
                    <td>{{ $inovasiPos->sum('mop') }}</td>
                    <td>{{ $inovasiPos->sum('mow') }}</td>
                    <td>{{ $inovasiPos->sum('iud') }}</td>
                    <td>{{ $inovasiPos->sum('suntikan') }}</td>

                    {{-- BALITA --}}
                    <td>{{ $inovasiPos->sum('jml_balita_l') }}</td>
                    <td>{{ $inovasiPos->sum('jml_balita_p') }}</td>

                    {{-- BUKU KIA --}}
                    <td>{{ $inovasiPos->sum('buku_kia_l') }}</td>
                    <td>{{ $inovasiPos->sum('buku_kia_p') }}</td>

                    {{-- DATANG --}}
                    <td>{{ $inovasiPos->sum('datang_l') }}</td>
                    <td>{{ $inovasiPos->sum('datang_p') }}</td>

                    {{-- NAIK --}}
                    <td>{{ $inovasiPos->sum('naik_l') }}</td>
                    <td>{{ $inovasiPos->sum('naik_p') }}</td>

                    {{-- VIT A --}}
                    <td>{{ $inovasiPos->sum('vit_a_l') }}</td>
                    <td>{{ $inovasiPos->sum('vit_a_p') }}</td>

                    {{-- PMT --}}
                    <td>{{ $inovasiPos->sum('pmt_l') }}</td>
                    <td>{{ $inovasiPos->sum('pmt_p') }}</td>

                    {{-- IMUNISASI --}}
                    <td>{{ $inovasiPos->sum('imunisasi_tt_1') }}</td>
                    <td>{{ $inovasiPos->sum('imunisasi_tt_2') }}</td>
                </tr>
            </tfoot>
        </table>

        @endif


        {{-- ===================================================== --}}
        {{-- KEGIATAN POKJA 4 --}}
        {{-- ===================================================== --}}

        @if(count($inovasiKP4) > 0)

        <h4>Data Kegiatan Pokja 4</h4>

        <table>
            <thead>
                <tr style="background:#e0f2fe;">
                    <th rowspan="2">NO</th>
                    @if (Auth::guard('web')->check())
                        <th rowspan="2">Kecamatan</th>
                        <th rowspan="2">Desa</th>
                    @elseif (Auth::guard('pengguna')->check())
                        <th rowspan="2">Desa</th>
                    @endif
                    <th rowspan="2">Kategori</th>

                    <th colspan="9">Kesehatan</th>
                    <th colspan="7">Kelestarian Lingkungan Hidup</th>
                    <th colspan="6">Perencanaan Sehat</th>
                    <th colspan="3">Program Unggulan GKSTTB</th>
                </tr>

                <tr style="background:#e0f2fe;">
                    {{-- KESEHATAN --}}
                    <th>Kader Kesehatan</th>
                    <th>Gizi</th>
                    <th>Kesling</th>
                    <th>PHBS</th>
                    <th>KB</th>
                    <th>Posyandu</th>
                    <th>Imunisasi Bayi Balita</th>
                    <th>PKG</th>
                    <th>TBC</th>

                    {{-- KELESTARIAN --}}
                    <th>Jamban WC</th>
                    <th>SPAL</th>
                    <th>TPS</th>
                    <th>Jumlah MCK</th>
                    <th>PDAM</th>
                    <th>Sumur</th>
                    <th>Lain-lain</th>

                    {{-- PERENCANAAN --}}
                    <th>Jml PUS</th>
                    <th>Jml WUS</th>
                    <th>Akseptor KB L</th>
                    <th>Akseptor KB P</th>
                    <th>KK Memiliki Tabungan</th>
                    <th>KK Memiliki Asuransi</th>

                    {{-- PROGRAM --}}
                    <th>Kesehatan</th>
                    <th>Kelestarian Lingkungan</th>
                    <th>Perencanaan Sehat</th>
                </tr>
            </thead>

            <tbody>
                @forelse($inovasiKP4 as $no => $item)
                <tr>
                    <td>{{ $no + 1 }}</td>
                    @if (Auth::guard('web')->check())
                        <td>{{ $item->nama_kec ?? '-' }}</td>
                        <td>{{ $item->nama_desa ?? '-' }}</td>
                    @elseif (Auth::guard('pengguna')->check())
                        <td>{{ $item->nama_desa ?? '-' }}</td>
                    @endif
                    <td>{{ ucfirst($item->kategori ?? '-') }}</td>

                    {{-- KESEHATAN --}}
                    <td>{{ $item->kader_kesehatan ?? 0 }}</td>
                    <td>{{ $item->gizi ?? 0 }}</td>
                    <td>{{ $item->kesling ?? 0 }}</td>
                    <td>{{ $item->phbs ?? 0 }}</td>
                    <td>{{ $item->kb ?? 0 }}</td>
                    <td>{{ $item->posyandu ?? 0 }}</td>
                    <td>{{ $item->imunisasi_vaksinasi_bayi_balita ?? 0 }}</td>
                    <td>{{ $item->pkg ?? 0 }}</td>
                    <td>{{ $item->tbc ?? 0 }}</td>

                    {{-- KELESTARIAN --}}
                    <td>{{ $item->jamban_wc ?? 0 }}</td>
                    <td>{{ $item->spal ?? 0 }}</td>
                    <td>{{ $item->tps ?? 0 }}</td>
                    <td>{{ $item->jumlah_mck ?? 0 }}</td>
                    <td>{{ $item->pdam ?? 0 }}</td>
                    <td>{{ $item->sumur ?? 0 }}</td>
                    <td>{{ $item->lain_lain ?? 0 }}</td>

                    {{-- PERENCANAAN --}}
                    <td>{{ $item->jml_pus ?? 0 }}</td>
                    <td>{{ $item->jml_wus ?? 0 }}</td>
                    <td>{{ $item->akseptor_kb_l ?? 0 }}</td>
                    <td>{{ $item->akseptor_kb_p ?? 0 }}</td>
                    <td>{{ $item->kk_memiliki_tabungan ?? 0 }}</td>
                    <td>{{ $item->kk_memiliki_asuransi ?? 0 }}</td>

                    {{-- PROGRAM --}}
                    <td>{{ $item->kesehatan ?? 0 }}</td>
                    <td>{{ $item->kelestarian_lingkungan_hidup ?? 0 }}</td>
                    <td>{{ $item->perencanaan_sehat ?? 0 }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ Auth::guard('web')->check() ? 30 : 29 }}" align="center">
                        Tidak ada data Kegiatan Pokja 4
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background:#f1f5f9; font-weight:bold;">
                    <td colspan="{{ Auth::guard('web')->check() ? 4 : 3 }}" align="center">TOTAL</td>
                    <td>{{ $inovasiKP4->sum('kader_kesehatan') }}</td>
                    <td>{{ $inovasiKP4->sum('gizi') }}</td>
                    <td>{{ $inovasiKP4->sum('kesling') }}</td>
                    <td>{{ $inovasiKP4->sum('phbs') }}</td>
                    <td>{{ $inovasiKP4->sum('kb') }}</td>
                    <td>{{ $inovasiKP4->sum('posyandu') }}</td>
                    <td>{{ $inovasiKP4->sum('imunisasi_vaksinasi_bayi_balita') }}</td>
                    <td>{{ $inovasiKP4->sum('pkg') }}</td>
                    <td>{{ $inovasiKP4->sum('tbc') }}</td>
                    <td>{{ $inovasiKP4->sum('jamban_wc') }}</td>
                    <td>{{ $inovasiKP4->sum('spal') }}</td>
                    <td>{{ $inovasiKP4->sum('tps') }}</td>
                    <td>{{ $inovasiKP4->sum('jumlah_mck') }}</td>
                    <td>{{ $inovasiKP4->sum('pdam') }}</td>
                    <td>{{ $inovasiKP4->sum('sumur') }}</td>
                    <td>{{ $inovasiKP4->sum('lain_lain') }}</td>
                    <td>{{ $inovasiKP4->sum('jml_pus') }}</td>
                    <td>{{ $inovasiKP4->sum('jml_wus') }}</td>
                    <td>{{ $inovasiKP4->sum('akseptor_kb_l') }}</td>
                    <td>{{ $inovasiKP4->sum('akseptor_kb_p') }}</td>
                    <td>{{ $inovasiKP4->sum('kk_memiliki_tabungan') }}</td>
                    <td>{{ $inovasiKP4->sum('kk_memiliki_asuransi') }}</td>
                    <td>{{ $inovasiKP4->sum('kesehatan') }}</td>
                    <td>{{ $inovasiKP4->sum('kelestarian_lingkungan_hidup') }}</td>
                    <td>{{ $inovasiKP4->sum('perencanaan_sehat') }}</td>
                </tr>
            </tfoot>
        </table>

        @endif

        @php

        $wakil = \Illuminate\Support\Facades\DB::table('ttds')
        ->whereNull('pokja')
        ->first();

        $ketua = \Illuminate\Support\Facades\DB::table('ttds')
        ->where('pokja', 'Kelompok Kerja IV')
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