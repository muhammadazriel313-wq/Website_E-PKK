<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Perbulan - Bidang Umum</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th, td {
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

        .signature p {
            margin-bottom: 5px;
        }

        .container-grid {
            width: 100%;
            border: none;
            padding: 5px;
            margin-top: 30px;
            box-sizing: border-box;
            display: grid;
            grid-template-columns: 50% 50%;
            font-size: 14px;
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
        <h2>Laporan Pertahun - Bidang Umum</h2>
        <h4>Tahun : {{ $tanggal ?? date('Y') }}</h4>    
    </div>

    <div class="separator"></div>
    <div class="signature">
        <p>Tanggal Cetak : {{ $formattedDate ?? date('d F Y') }}</p>
    </div>

    <table align="center">
        <thead>
            <tr style="background: #e0f2fe;">
                <th align="center"><b>NO</b></th>
                <th align="center"><b>Kecamatan</b></th>
                <th align="center"><b>Dusun Lingkungan</b></th>
                <th align="center"><b>PKK RW</b></th>
                <th align="center"><b>Desa Wisma</b></th>
                <th align="center"><b>KRT</b></th>
                <th align="center"><b>KK</b></th>
                <th align="center"><b>Jiwa Laki</b></th>
                <th align="center"><b>Jiwa Perempuan</b></th>
                <th align="center"><b>Anggota Laki</b></th>
                <th align="center"><b>Anggota Perempuan</b></th>
                <th align="center"><b>Umum Laki</b></th>
                <th align="center"><b>Umum Perempuan</b></th>
                <th align="center"><b>Khusus Laki</b></th>
                <th align="center"><b>Khusus Perempuan</b></th>
                <th align="center"><b>Honorer Laki</b></th>
                <th align="center"><b>Honorer Perempuan</b></th>
                <th align="center"><b>Bantuan Laki</b></th>
                <th align="center"><b>Bantuan Perempuan</b></th>
            </tr>
        </thead>

        <tbody>
            @php
                $no = 1;
                $t_pkk_rw = 0; $t_desa_wisma = 0; $t_krt = 0; $t_kk = 0;
                $t_jiwa_l = 0; $t_jiwa_p = 0; $t_anggota_l = 0; $t_anggota_p = 0;
                $t_umum_l = 0; $t_umum_p = 0; $t_khusus_l = 0; $t_khusus_p = 0;
                $t_honorer_l = 0; $t_honorer_p = 0; $t_bantuan_l = 0; $t_bantuan_p = 0;
            @endphp

            @forelse($bidangumum as $item)
                @php
                    $t_pkk_rw += $item->PKK_RW ?? 0;
                    $t_desa_wisma += $item->desa_wisma ?? 0;
                    $t_krt += $item->KRT ?? 0;
                    $t_kk += $item->KK ?? 0;
                    $t_jiwa_l += $item->jiwa_laki ?? 0;
                    $t_jiwa_p += $item->jiwa_perempuan ?? 0;
                    $t_anggota_l += $item->anggota_laki ?? 0;
                    $t_anggota_p += $item->anggota_perempuan ?? 0;
                    $t_umum_l += $item->umum_laki ?? 0;
                    $t_umum_p += $item->umum_perempuan ?? 0;
                    $t_khusus_l += $item->khusus_laki ?? 0;
                    $t_khusus_p += $item->khusus_perempuan ?? 0;
                    $t_honorer_l += $item->honorer_laki ?? 0;
                    $t_honorer_p += $item->honorer_perempuan ?? 0;
                    $t_bantuan_l += $item->bantuan_laki ?? 0;
                    $t_bantuan_p += $item->bantuan_perempuan ?? 0;
                @endphp
                <tr>
                    <td align="center">{{ $no++ }}</td>
                    <td align="center">{{ $item->nama_kec }}</td>
                    <td align="center">{{ $item->dusun_lingkungan }}</td>
                    <td align="center">{{ $item->PKK_RW }}</td>
                    <td align="center">{{ $item->desa_wisma }}</td>
                    <td align="center">{{ $item->KRT }}</td>
                    <td align="center">{{ $item->KK }}</td>
                    <td align="center">{{ $item->jiwa_laki }}</td>
                    <td align="center">{{ $item->jiwa_perempuan }}</td>
                    <td align="center">{{ $item->anggota_laki }}</td>
                    <td align="center">{{ $item->anggota_perempuan }}</td>
                    <td align="center">{{ $item->umum_laki }}</td>
                    <td align="center">{{ $item->umum_perempuan }}</td>
                    <td align="center">{{ $item->khusus_laki }}</td>
                    <td align="center">{{ $item->khusus_perempuan }}</td>
                    <td align="center">{{ $item->honorer_laki }}</td>
                    <td align="center">{{ $item->honorer_perempuan }}</td>
                    <td align="center">{{ $item->bantuan_laki }}</td>
                    <td align="center">{{ $item->bantuan_perempuan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="19" align="center"><i>Tidak ada data laporan untuk dicetak</i></td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr style="background-color: #f2f2f2;">
                <td colspan="3" align="center"><b>TOTAL KESELURUHAN</b></td>
                <td align="center"><b>{{ $t_pkk_rw }}</b></td>
                <td align="center"><b>{{ $t_desa_wisma }}</b></td>
                <td align="center"><b>{{ $t_krt }}</b></td>
                <td align="center"><b>{{ $t_kk }}</b></td>
                <td align="center"><b>{{ $t_jiwa_l }}</b></td>
                <td align="center"><b>{{ $t_jiwa_p }}</b></td>
                <td align="center"><b>{{ $t_anggota_l }}</b></td>
                <td align="center"><b>{{ $t_anggota_p }}</b></td>
                <td align="center"><b>{{ $t_umum_l }}</b></td>
                <td align="center"><b>{{ $t_umum_p }}</b></td>
                <td align="center"><b>{{ $t_khusus_l }}</b></td>
                <td align="center"><b>{{ $t_khusus_p }}</b></td>
                <td align="center"><b>{{ $t_honorer_l }}</b></td>
                <td align="center"><b>{{ $t_honorer_p }}</b></td>
                <td align="center"><b>{{ $t_bantuan_l }}</b></td>
                <td align="center"><b>{{ $t_bantuan_p }}</b></td>
            </tr>
        </tfoot>
    </table>

    {{-- KODE PENGAMAN: Menarik data langsung dari database jika Controller lupa mengirimnya --}}
    @php
        if (!isset($wakil)) {
            // Menarik data Sekretaris untuk Bidang Umum
            $wakil = \Illuminate\Support\Facades\DB::table('ttds')
                        ->where('pokja', 'Bidang Umum')
                        ->get();
        }

        if (!isset($ketua)) {
            // Menarik data Ketua Umum (pokja kosong/NULL)
            $ketua = \Illuminate\Support\Facades\DB::table('ttds')
                        ->where('jabatan', 'Ketua')
                        ->whereNull('pokja')
                        ->get();
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
                    <a>Sekretaris / Wakil Ketua</a><br><br><br><br>
                    <a>( ......................................... )</a>
                @endforelse
            </div>
        </div>

        <div style="text-align: right;">
            <div style="text-align: center;">
                @forelse($ketua as $ketuaa)
                    <a>Nganjuk, {{ date('d F Y') }}</a><br>
                    <a>{{ $ketuaa->pokja ?? 'Ketua Umum' }}</a><br>
                    <a>{{ $ketuaa->jabatan }}</a><br><br><br><br>
                    <a style="text-decoration: underline; font-weight: bold;">{{ $ketuaa->nama_terang }}</a>
                @empty
                    <a>Nganjuk, {{ date('d F Y') }}</a><br>
                    <a>TIM PENGGERAK PKK KABUPATEN NGANJUK</a><br>
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