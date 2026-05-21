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

        {{-- TABEL KESEHATAN --}}
        @if($bidang == 'semua' || $bidang == 'kesehatan')
        <h3>Laporan Kesehatan</h3>
        <table>
            <thead>
                <tr style="background:#e0f2fe;">
                    <th>NO</th>
                    <th>Kecamatan</th>
                    <th>Posyandu</th>
                    <th>Posyandu Iterasi</th>
                    <th>KLP</th>
                    <th>Anggota</th>
                    <th>Kartu Gratis</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; $t_pos = 0; $t_iter = 0; $t_klp = 0; $t_ang = 0; $t_grt = 0; @endphp
                @forelse($kesehatan as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td class="text-left">{{ $item->nama_kec }}</td>
                    <td>{{ $item->jumlah_posyandu }}</td>
                    <td>{{ $item->jumlah_posyandu_iterasi }}</td>
                    <td>{{ $item->jumlah_klp }}</td>
                    <td>{{ $item->jumlah_anggota }}</td>
                    <td>{{ $item->jumlah_kartu_gratis }}</td>
                </tr>
                @php $t_pos += $item->jumlah_posyandu; $t_iter += $item->jumlah_posyandu_iterasi; $t_klp += $item->jumlah_klp; $t_ang += $item->jumlah_anggota; $t_grt += $item->jumlah_kartu_gratis; @endphp
                @empty
                <tr>
                    <td colspan="7">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
            <tr style="background:#f2f2f2; font-weight:bold;">
                <td colspan="2">Total</td>
                <td>{{$t_pos}}</td>
                <td>{{$t_iter}}</td>
                <td>{{$t_klp}}</td>
                <td>{{$t_ang}}</td>
                <td>{{$t_grt}}</td>
            </tr>
        </table>
        @endif

        {{-- TABEL KELESTARIAN --}}
        @if($bidang == 'semua' || $bidang == 'kelestarian')
        <h3>Laporan Kelestarian Lingkungan Hidup</h3>
        <table>
            <tr style="background:#e0f2fe;">
                <th>NO</th>
                <th>Kecamatan</th>
                <th>Jamban</th>
                <th>Spal</th>
                <th>TPS</th>
                <th>MCK</th>
                <th>PDAM</th>
                <th>Sumur</th>
                <th>Dll</th>
            </tr>
            @php $no = 1; $t1=0; $t2=0; $t3=0; $t4=0; $t5=0; $t6=0; $t7=0; @endphp
            @forelse($kelestarian as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-left">{{ $item->nama_kec }}</td>
                <td>{{ $item->jamban }}</td>
                <td>{{ $item->spal }}</td>
                <td>{{ $item->tps }}</td>
                <td>{{ $item->mck }}</td>
                <td>{{ $item->pdam }}</td>
                <td>{{ $item->sumur }}</td>
                <td>{{ $item->dll }}</td>
            </tr>
            @php $t1+=$item->jamban; $t2+=$item->spal; $t3+=$item->tps; $t4+=$item->mck; $t5+=$item->pdam; $t6+=$item->sumur; $t7+=$item->dll; @endphp
            @empty
            <tr>
                <td colspan="9">Tidak ada data</td>
            </tr>
            @endforelse
            <tr style="background:#f2f2f2; font-weight:bold;">
                <td colspan="2">Total</td>
                <td>{{$t1}}</td>
                <td>{{$t2}}</td>
                <td>{{$t3}}</td>
                <td>{{$t4}}</td>
                <td>{{$t5}}</td>
                <td>{{$t6}}</td>
                <td>{{$t7}}</td>
            </tr>
        </table>
        @endif

        {{-- TABEL PERENCANAAN --}}
        @if($bidang == 'semua' || $bidang == 'perencanaan')
        <h3>Laporan Perencanaan Sehat</h3>
        <table>
            <tr style="background:#e0f2fe;">
                <th>NO</th>
                <th>Kecamatan</th>
                <th>Perempuan Subur</th>
                <th>Wanita Subur</th>
                <th>KB Pria</th>
                <th>KB Wanita</th>
                <th>KK TBG</th>
            </tr>
            @php $no = 1; $t1=0; $t2=0; $t3=0; $t4=0; $t5=0; @endphp
            @forelse($perencanaan as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-left">{{ $item->nama_kec }}</td>
                <td>{{ $item->J_Psubur }}</td>
                <td>{{ $item->J_Wsubur }}</td>
                <td>{{ $item->Kb_p }}</td>
                <td>{{ $item->Kb_w }}</td>
                <td>{{ $item->Kk_tbg }}</td>
            </tr>
            @php $t1+=$item->J_Psubur; $t2+=$item->J_Wsubur; $t3+=$item->Kb_p; $t4+=$item->Kb_w; $t5+=$item->Kk_tbg; @endphp
            @empty
            <tr>
                <td colspan="7">Tidak ada data</td>
            </tr>
            @endforelse
            <tr style="background:#f2f2f2; font-weight:bold;">
                <td colspan="2">Total</td>
                <td>{{$t1}}</td>
                <td>{{$t2}}</td>
                <td>{{$t3}}</td>
                <td>{{$t4}}</td>
                <td>{{$t5}}</td>
            </tr>
        </table>
        @endif

        {{-- TABEL KADER --}}
        @if($bidang == 'semua' || $bidang == 'kader')
        <h3>Laporan Kader Pokja 4</h3>
        <table>
            <tr style="background:#e0f2fe;">
                <th>NO</th>
                <th>Kecamatan</th>
                <th>Posyandu</th>
                <th>Gizi</th>
                <th>Kesling</th>
                <th>Peny. Narkoba</th>
                <th>PHBS</th>
                <th>KB</th>
            </tr>
            @php $no = 1; $t1=0; $t2=0; $t3=0; $t4=0; $t5=0; $t6=0; @endphp
            @forelse($laporanpokja4 as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td class="text-left">{{ $item->nama_kec }}</td>
                <td>{{ $item->posyandu }}</td>
                <td>{{ $item->gizi }}</td>
                <td>{{ $item->kesling }}</td>
                <td>{{ $item->penyuluhan_narkoba }}</td>
                <td>{{ $item->PHBS }}</td>
                <td>{{ $item->KB }}</td>
            </tr>
            @php $t1+=$item->posyandu; $t2+=$item->gizi; $t3+=$item->kesling; $t4+=$item->penyuluhan_narkoba; $t5+=$item->PHBS; $t6+=$item->KB; @endphp
            @empty
            <tr>
                <td colspan="8">Tidak ada data</td>
            </tr>
            @endforelse
            <tr style="background:#f2f2f2; font-weight:bold;">
                <td colspan="2">Total</td>
                <td>{{$t1}}</td>
                <td>{{$t2}}</td>
                <td>{{$t3}}</td>
                <td>{{$t4}}</td>
                <td>{{$t5}}</td>
                <td>{{$t6}}</td>
            </tr>
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

        {{-- ===================================================== --}}
        {{-- REKAP DESA BULANAN --}}
        {{-- ===================================================== --}}

        @if(count($inovasiRDB) > 0)

        <h4>Rekap Desa Bulanan</h4>

        <table>
            <thead>
                <tr style="background:#e0f2fe;">
                    <th>NO</th>
                    <th>Kecamatan</th>
                    <th>Kategori</th>

                    <th>RW</th>
                    <th>RT</th>
                    <th>Dasa Wisma</th>

                    <th>Hamil</th>
                    <th>Melahirkan</th>
                    <th>Nifas</th>
                    <th>Meninggal</th>

                    <th>Bayi Lahir L</th>
                    <th>Bayi Lahir P</th>

                    <th>Akte Ada</th>
                    <th>Akte Tidak</th>

                    <th>Bayi Meninggal L</th>
                    <th>Bayi Meninggal P</th>

                    <th>Balita Meninggal L</th>
                    <th>Balita Meninggal P</th>
                </tr>
            </thead>

            <tbody>

                @forelse($inovasiRDB as $no => $item)

                <tr>

                    <td>{{ $no + 1 }}</td>

                    <td>{{ $item->nama_kec }}</td>

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
                    <td colspan="18" align="center">
                        Tidak ada data
                    </td>
                </tr>

                @endforelse

            </tbody>
            {{-- ===================================================== --}}
            {{-- TOTAL REKAP DESA BULANAN --}}
            {{-- ===================================================== --}}

            <tfoot>

                <tr style="background:#f1f5f9; font-weight:bold;">

                    <td colspan="3" align="center">TOTAL</td>

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

                    <th rowspan="2">Kecamatan</th>

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

                    <td>{{ $item->nama_kec }}</td>

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

                    <td colspan="29" align="center">

                        Tidak ada data

                    </td>

                </tr>

                @endforelse

            </tbody>
            {{-- ===================================================== --}}
            {{-- TOTAL REKAP DESA TAHUNAN --}}
            {{-- ===================================================== --}}

            <tfoot>

                <tr style="background:#f1f5f9; font-weight:bold;">

                    <td colspan="3" align="center">TOTAL</td>

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

                    <th rowspan="2">Kecamatan</th>

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

                    <td>{{ $item->nama_kec }}</td>

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

                    <td colspan="31" align="center">

                        Tidak ada data Posyandu

                    </td>

                </tr>

                @endforelse

            </tbody>
            {{-- ===================================================== --}}
            {{-- TOTAL POSYANDU --}}
            {{-- ===================================================== --}}

            <tfoot>

                <tr style="background:#f1f5f9; font-weight:bold;">

                    <td colspan="4" align="center">TOTAL</td>

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

                    <th>NO</th>

                    <th>Kecamatan</th>

                    <th>Kategori</th>

                    <th>Kader Kesehatan</th>

                    <th>Gizi</th>

                    <th>Kesling</th>

                    <th>PHBS</th>

                    <th>KB</th>

                    <th>Posyandu</th>

                    <th>Imunisasi Bayi Balita</th>

                    <th>PKG</th>

                    <th>TBC</th>

                    <th>Jamban WC</th>

                    <th>SPAL</th>

                    <th>TPS</th>

                    <th>Jumlah MCK</th>

                    <th>PDAM</th>

                    <th>Sumur</th>

                    <th>Lain-lain</th>

                    <th>Jml PUS</th>

                    <th>Jml WUS</th>

                    <th>Akseptor KB L</th>

                    <th>Akseptor KB P</th>

                    <th>KK Memiliki Tabungan</th>

                    <th>KK Memiliki Asuransi</th>

                    <th>Kesehatan</th>

                    <th>Kelestarian Lingkungan</th>

                    <th>Perencanaan Sehat</th>

                </tr>

            </thead>

            <tbody>

                @forelse($inovasiKP4 as $no => $item)

                <tr>

                    <td>{{ $no + 1 }}</td>

                    <td>{{ $item->nama_kec }}</td>

                    <td>{{ ucfirst($item->kategori ?? '-') }}</td>

                    <td>{{ $item->kader_kesehatan ?? 0 }}</td>

                    <td>{{ $item->gizi ?? 0 }}</td>

                    <td>{{ $item->kesling ?? 0 }}</td>

                    <td>{{ $item->phbs ?? 0 }}</td>

                    <td>{{ $item->kb ?? 0 }}</td>

                    <td>{{ $item->posyandu ?? 0 }}</td>

                    <td>{{ $item->imunisasi_vaksinasi_bayi_balita ?? 0 }}</td>

                    <td>{{ $item->pkg ?? 0 }}</td>

                    <td>{{ $item->tbc ?? 0 }}</td>

                    <td>{{ $item->jamban_wc ?? 0 }}</td>

                    <td>{{ $item->spal ?? 0 }}</td>

                    <td>{{ $item->tps ?? 0 }}</td>

                    <td>{{ $item->jumlah_mck ?? 0 }}</td>

                    <td>{{ $item->pdam ?? 0 }}</td>

                    <td>{{ $item->sumur ?? 0 }}</td>

                    <td>{{ $item->lain_lain ?? 0 }}</td>

                    <td>{{ $item->jml_pus ?? 0 }}</td>

                    <td>{{ $item->jml_wus ?? 0 }}</td>

                    <td>{{ $item->akseptor_kb_l ?? 0 }}</td>

                    <td>{{ $item->akseptor_kb_p ?? 0 }}</td>

                    <td>{{ $item->kk_memiliki_tabungan ?? 0 }}</td>

                    <td>{{ $item->kk_memiliki_asuransi ?? 0 }}</td>

                    <td>{{ $item->kesehatan ?? 0 }}</td>

                    <td>{{ $item->kelestarian_lingkungan_hidup ?? 0 }}</td>

                    <td>{{ $item->perencanaan_sehat ?? 0 }}</td>

                </tr>

                @empty

                <tr>

                    <td colspan="28" align="center">

                        Tidak ada data Kegiatan Pokja 4

                    </td>

                </tr>

                @endforelse

            </tbody>
            {{-- ===================================================== --}}
            {{-- TOTAL KEGIATAN POKJA 4 --}}
            {{-- ===================================================== --}}

            <tfoot>

                <tr style="background:#f1f5f9; font-weight:bold;">

                    <td colspan="3" align="center">TOTAL</td>

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