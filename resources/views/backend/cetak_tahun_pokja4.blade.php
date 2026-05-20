<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cetak Laporan Pertahun - Pokja 4</title>
    <style>
        body { font-family: Arial, sans-serif; font-size:11px; margin:25px; color:#000; }
        table { width:100%; border-collapse:collapse; margin-bottom: 20px; }
        th, td { border:1px solid #000; padding:6px; text-align:center; vertical-align:middle; }
        .no-border td { border:none !important; padding:0; }
        .header { width:100%; margin-bottom:20px; }
        .logo { width:75px; }
        .text-left { text-align:left; }
        .text-center { text-align:center; }
        .judul { font-size:18px; font-weight:bold; margin-bottom:5px; }
        .subjudul { font-size:13px; font-weight:bold; }
        .ttd { margin-top:40px; width:100%; border:none; }
        .ttd td { border:none; width:50%; text-align:center; vertical-align:top; }
        .nama { margin-top:60px; text-decoration:underline; font-weight:bold; }
    </style>
</head>

<body onload="window.print()">

{{-- HEADER --}}
<table class="no-border header">
    <tr>
        <td style="width:90px;"><img src="{{ asset('frontend/assets/img/favicon.png') }}" class="logo"></td>
        <td class="text-left">
            <b>Pemberdayaan Kesejahteraan Keluarga</b><br>Kab. Nganjuk, Jawa Timur
        </td>
        <td class="text-center">
            <div class="judul">LAPORAN POKJA IV</div>
            <div class="subjudul">Tahun : {{ $tahun ?? date('Y') }}</div>
        </td>
    </tr>
</table>

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
        <tr>
            <th>NO</th><th>Kecamatan</th><th>Posyandu</th><th>Posyandu Iterasi</th><th>KLP</th><th>Anggota</th><th>Kartu Gratis</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; $t_pos = 0; $t_iter = 0; $t_klp = 0; $t_ang = 0; $t_grt = 0; @endphp
        @forelse($kesehatan as $item)
        <tr>
            <td>{{ $no++ }}</td><td class="text-left">{{ $item->nama_kec }}</td>
            <td>{{ $item->jumlah_posyandu }}</td><td>{{ $item->jumlah_posyandu_iterasi }}</td>
            <td>{{ $item->jumlah_klp }}</td><td>{{ $item->jumlah_anggota }}</td><td>{{ $item->jumlah_kartu_gratis }}</td>
        </tr>
        @php $t_pos += $item->jumlah_posyandu; $t_iter += $item->jumlah_posyandu_iterasi; $t_klp += $item->jumlah_klp; $t_ang += $item->jumlah_anggota; $t_grt += $item->jumlah_kartu_gratis; @endphp
        @empty
            <tr><td colspan="7">Tidak ada data</td></tr>
        @endforelse
    </tbody>
    <tr style="background:#f2f2f2; font-weight:bold;">
        <td colspan="2">Total</td><td>{{$t_pos}}</td><td>{{$t_iter}}</td><td>{{$t_klp}}</td><td>{{$t_ang}}</td><td>{{$t_grt}}</td>
    </tr>
</table>
@endif

{{-- TABEL KELESTARIAN --}}
@if($bidang == 'semua' || $bidang == 'kelestarian')
<h3>Laporan Kelestarian Lingkungan Hidup</h3>
<table>
    <tr>
        <th>NO</th><th>Kecamatan</th><th>Jamban</th><th>Spal</th><th>TPS</th><th>MCK</th><th>PDAM</th><th>Sumur</th><th>Dll</th>
    </tr>
    @php $no = 1; $t1=0; $t2=0; $t3=0; $t4=0; $t5=0; $t6=0; $t7=0; @endphp
    @forelse($kelestarian as $item)
    <tr>
        <td>{{ $no++ }}</td><td class="text-left">{{ $item->nama_kec }}</td>
        <td>{{ $item->jamban }}</td><td>{{ $item->spal }}</td><td>{{ $item->tps }}</td>
        <td>{{ $item->mck }}</td><td>{{ $item->pdam }}</td><td>{{ $item->sumur }}</td><td>{{ $item->dll }}</td>
    </tr>
    @php $t1+=$item->jamban; $t2+=$item->spal; $t3+=$item->tps; $t4+=$item->mck; $t5+=$item->pdam; $t6+=$item->sumur; $t7+=$item->dll; @endphp
    @empty
        <tr><td colspan="9">Tidak ada data</td></tr>
    @endforelse
    <tr style="background:#f2f2f2; font-weight:bold;">
        <td colspan="2">Total</td><td>{{$t1}}</td><td>{{$t2}}</td><td>{{$t3}}</td><td>{{$t4}}</td><td>{{$t5}}</td><td>{{$t6}}</td><td>{{$t7}}</td>
    </tr>
</table>
@endif

{{-- TABEL PERENCANAAN --}}
@if($bidang == 'semua' || $bidang == 'perencanaan')
<h3>Laporan Perencanaan Sehat</h3>
<table>
    <tr>
        <th>NO</th><th>Kecamatan</th><th>Perempuan Subur</th><th>Wanita Subur</th><th>KB Pria</th><th>KB Wanita</th><th>KK TBG</th>
    </tr>
    @php $no = 1; $t1=0; $t2=0; $t3=0; $t4=0; $t5=0; @endphp
    @forelse($perencanaan as $item)
    <tr>
        <td>{{ $no++ }}</td><td class="text-left">{{ $item->nama_kec }}</td>
        <td>{{ $item->J_Psubur }}</td><td>{{ $item->J_Wsubur }}</td><td>{{ $item->Kb_p }}</td>
        <td>{{ $item->Kb_w }}</td><td>{{ $item->Kk_tbg }}</td>
    </tr>
    @php $t1+=$item->J_Psubur; $t2+=$item->J_Wsubur; $t3+=$item->Kb_p; $t4+=$item->Kb_w; $t5+=$item->Kk_tbg; @endphp
    @empty
        <tr><td colspan="7">Tidak ada data</td></tr>
    @endforelse
    <tr style="background:#f2f2f2; font-weight:bold;">
        <td colspan="2">Total</td><td>{{$t1}}</td><td>{{$t2}}</td><td>{{$t3}}</td><td>{{$t4}}</td><td>{{$t5}}</td>
    </tr>
</table>
@endif

{{-- TABEL KADER POKJA 4 --}}
@if($bidang == 'semua' || $bidang == 'kader')
<h3>Laporan Kader Pokja 4</h3>
<table>
    <tr style="background:#f2f2f2;">
        <th>NO</th><th>Kecamatan</th><th>Posyandu</th><th>Gizi</th><th>Kesling</th><th>Peny. Narkoba</th><th>PHBS</th><th>KB</th>
    </tr>
    @php $no = 1; $t1=0; $t2=0; $t3=0; $t4=0; $t5=0; $t6=0; @endphp
    @forelse($laporanpokja4 as $item)
    <tr>
        <td>{{ $no++ }}</td><td class="text-left">{{ $item->nama_kec }}</td>
        <td>{{ $item->posyandu }}</td><td>{{ $item->gizi }}</td><td>{{ $item->kesling }}</td>
        <td>{{ $item->penyuluhan_narkoba }}</td><td>{{ $item->PHBS }}</td><td>{{ $item->KB }}</td>
    </tr>
    @php $t1+=$item->posyandu; $t2+=$item->gizi; $t3+=$item->kesling; $t4+=$item->penyuluhan_narkoba; $t5+=$item->PHBS; $t6+=$item->KB; @endphp
    @empty
        <tr><td colspan="8">Tidak ada data</td></tr>
    @endforelse
    <tr style="background:#f2f2f2; font-weight:bold;">
        <td colspan="2">Total</td><td>{{$t1}}</td><td>{{$t2}}</td><td>{{$t3}}</td><td>{{$t4}}</td><td>{{$t5}}</td><td>{{$t6}}</td>
    </tr>
</table>
@endif

{{-- 🚨 TABEL INOVASI (PENTING! MENGGABUNGKAN 4 TABEL) --}}
@if(strpos($bidang, 'inovasi') !== false || $bidang == 'semua')
    @php 
        $labelInovasi = "";
        if($bidang == 'inovasi_prioritas') $labelInovasi = "(Prioritas)";
        if($bidang == 'inovasi_unggulan') $labelInovasi = "(Unggulan)";
        
        // Menggabungkan data Inovasi dari 4 tabel yang berbeda
        $allInovasi = collect($inovasiRDB)->merge($inovasiRDT)->merge($inovasiPos)->merge($inovasiKP4); 
    @endphp
    
    <h3>Laporan Inovasi {{ $labelInovasi }}</h3>
    <table>
        <tr style="background:#e0f2fe;">
            <th width="5%">NO</th><th width="15%">Kecamatan</th><th width="10%">Kategori</th><th>Detail Data (Dari 4 Tabel Berbeda)</th>
        </tr>
        @forelse($allInovasi as $no => $item)
        <tr>
            <td>{{ $no+1 }}</td><td class="text-left">{{ $item->nama_kec }}</td><td>{{ ucfirst($item->kategori ?? '-') }}</td>
            <td style="text-align: left; padding-left: 10px; font-size:10px;">
                @foreach((array)$item as $key => $val)
                    @if(!in_array($key, ['id', 'uuid', 'nama_kec', 'kategori', 'status', 'created_at', 'updated_at', 'id_user', 'id_role', 'id_subdistrict', 'id_organization']))
                        <b>{{ ucfirst(str_replace('_', ' ', $key)) }}:</b> {{ $val }} |
                    @endif
                @endforeach
            </td>
        </tr>
        @empty
        <tr><td colspan="4">Tidak ada data Inovasi</td></tr>
        @endforelse
    </table>
@endif

{{-- TTD --}}
<table class="ttd">
    <tr>
        <td>
            Mengetahui,<br>Ketua Pokja IV
            <div class="nama">{{ $ketua[0]->nama_terang ?? '__________________' }}</div>
        </td>   
        <td>
            Nganjuk, {{ date('d-m-Y') }}<br>Admin
            <div class="nama">{{ $wakil[0]->nama_terang ?? '__________________' }}</div>
        </td>
    </tr>
</table>

</body>
</html>