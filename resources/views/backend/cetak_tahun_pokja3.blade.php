<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Pertahun - Pokja 3</title>
    <style>
        table { width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 30px; }
        th, td { padding: 6px; border: 1px solid black; }
        body { font-family: Arial, sans-serif; }
        .container { width: 100%; margin: 0 auto; }
        .header { margin-bottom: 20px; }
        .logo-container { display: flex; align-items: center; margin-bottom: 20px; }
        .logo { max-width: 100px; height: auto; margin-right: 20px; }
        .header h1 { font-size: 18px; margin-bottom: 5px; }
        .header p { font-size: 14px; margin: 0; }
        .separator { margin-bottom: 10px; border-top: 2px solid #000; }
        .signature { margin-top: 20px; text-align: right; font-size: 13px; }
        .container-grid { width: 100%; border: none; padding: 5px; margin-top: 40px; box-sizing: border-box; display: grid; grid-template-columns: 50% 50%; font-size: 14px; }
        h3 { background-color: #f8f9fa; padding: 10px; border-left: 5px solid #000; font-size: 16px; }
        @page { size: landscape; margin: 10mm; }
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
        <h2>Laporan Pertahun - Kelompok Kerja (POKJA) 3</h2>
        <h4>Tahun : {{ $tanggal ?? date('Y') }}</h4>
    </div>

    <div class="separator"></div>
    <div class ="signature">
        <p>Tanggal Cetak : {{ $formattedDate ?? date('d F Y') }}</p>
    </div>

    {{-- JURUS KEBAL SAKLAR TABEL --}}
{{-- JURUS KEBAL ANTI ERROR --}}
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
                <tr>
                    <th align="center"><b>NO</b></th>
                    <th align="center"><b>Kecamatan</b></th>
                    <th align="center"><b>Beras</b></th>
                    <th align="center"><b>Non Beras</b></th>
                    <th align="center"><b>Peternakan</b></th>
                    <th align="center"><b>Perikanan</b></th>
                    <th align="center"><b>Warung Hidup</b></th>
                    <th align="center"><b>Lumbung Hidup</b></th>
                    <th align="center"><b>Toga</b></th>
                    <th align="center"><b>Tanaman Keras</b></th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $no_png = 1;
                    $t_beras = 0; $t_nberas = 0; $t_ternak = 0; $t_ikan = 0;
                    $t_warung = 0; $t_lumbung = 0; $t_toga = 0; $t_keras = 0;
                @endphp
                @forelse($pangan as $item)
                    @php
                        $t_beras += $item->beras ?? 0; $t_nberas += $item->non_beras ?? 0;
                        $t_ternak += $item->peternakan ?? 0; $t_ikan += $item->perikanan ?? 0;
                        $t_warung += $item->warung_hidup ?? 0; $t_lumbung += $item->lumbung_hidup ?? 0;
                        $t_toga += $item->toga ?? 0; $t_keras += $item->tanaman_keras ?? 0;
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
                    </tr>
                @empty
                    <tr><td colspan="10" align="center"><i>Tidak ada data laporan untuk dicetak</i></td></tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background-color: #f2f2f2;">
                    <td colspan="2" align="center"><b>TOTAL</b></td>
                    <td align="center"><b>{{ $t_beras }}</b></td>
                    <td align="center"><b>{{ $t_nberas }}</b></td>
                    <td align="center"><b>{{ $t_ternak }}</b></td>
                    <td align="center"><b>{{ $t_ikan }}</b></td>
                    <td align="center"><b>{{ $t_warung }}</b></td>
                    <td align="center"><b>{{ $t_lumbung }}</b></td>
                    <td align="center"><b>{{ $t_toga }}</b></td>
                    <td align="center"><b>{{ $t_keras }}</b></td>
                </tr>
            </tfoot>
        </table>
    @endif

    @if($bidang == 'semua' || $bidang == 'sandang')
        <h3>Laporan Sandang</h3>
        <table align="center">
            <thead>
                <tr>
                    <th align="center"><b>NO</b></th>
                    <th align="center"><b>Kecamatan</b></th>
                    <th align="center"><b>Pangan</b></th>
                    <th align="center"><b>Sandang</b></th>
                    <th align="center"><b>Jasa</b></th>
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
                    <tr><td colspan="5" align="center"><i>Tidak ada data laporan untuk dicetak</i></td></tr>
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
                <tr>
                    <th align="center"><b>NO</b></th>
                    <th align="center"><b>Kecamatan</b></th>
                    <th align="center"><b>Layak Huni</b></th>
                    <th align="center"><b>Tidak Layak</b></th>
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
                    <tr><td colspan="4" align="center"><i>Tidak ada data laporan untuk dicetak</i></td></tr>
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
                <tr>
                    <th align="center"><b>NO</b></th>
                    <th align="center"><b>Kecamatan</b></th>
                    <th align="center"><b>Pangan</b></th>
                    <th align="center"><b>Sandang</b></th>
                    <th align="center"><b>Tata Laksana Rumah</b></th>
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
                    <tr><td colspan="5" align="center"><i>Tidak ada data laporan untuk dicetak</i></td></tr>
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
        if (!isset($wakil) || count($wakil) == 0) {
            $wakil = \Illuminate\Support\Facades\DB::table('ttds')->where('pokja', 'Kelompok Kerja III')
                        ->where(function($q) { $q->where('jabatan', 'like', '%Wakil%')->orWhere('jabatan', 'like', '%Sekretaris%'); })->get();
        }
        if (!isset($ketua) || count($ketua) == 0) {
            $ketua = \Illuminate\Support\Facades\DB::table('ttds')->where('pokja', 'Kelompok Kerja III')->where('jabatan', 'Ketua')->get();
        }
    @endphp

    <div class="container-grid">
        <div style="text-align: left;">
            <div style="text-align: center;">
                @forelse($wakil as $wakill)
                    <a>Mengetahui</a><br>
                    <a>TIM PENGGERAK PKK KABUPATEN NGANJUK</a><br>
                    <a>{{ $wakill->jabatan }}</a><br><br><br><br>
                    <a style="text-decoration: underline; font-weight: bold;">{{ $wakill->nama_terang }}</a>
                @empty
                    <a>Mengetahui</a><br>
                    <a>TIM PENGGERAK PKK KABUPATEN NGANJUK</a><br>
                    <a>Wakil Ketua</a><br><br><br><br>
                    <a>( ......................................... )</a>
                @endforelse
            </div>
        </div>
        <div style="text-align: right;">
            <div style="text-align: center;">
                @forelse($ketua as $ketuaa)
                    <a>Nganjuk, {{ date('d F Y') }}</a><br>
                    <a>{{ $ketuaa->pokja ?? 'Kelompok Kerja III' }}</a><br>
                    <a>{{ $ketuaa->jabatan }}</a><br><br><br><br>
                    <a style="text-decoration: underline; font-weight: bold;">{{ $ketuaa->nama_terang }}</a>
                @empty
                    <a>Nganjuk, {{ date('d F Y') }}</a><br>
                    <a>Kelompok Kerja III</a><br>
                    <a>Ketua</a><br><br><br><br>
                    <a>( ......................................... )</a>
                @endforelse
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