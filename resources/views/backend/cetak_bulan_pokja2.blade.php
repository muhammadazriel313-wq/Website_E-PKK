<!DOCTYPE html>
<html>

<head>
    <title>Cetak Laporan Perbulan - Pokja 2</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
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
            {{-- PENGAMAN: Mengganti $created_at menjadi $tanggal --}}
            <h4>Bulan : {{ $tanggal ?? date('F Y') }}</h4>
        </div>

        <div class="separator"></div>
        <div class="signature">
            <p>Tanggal Cetak : {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        </div>

        {{-- JURUS KEBAL SAKLAR TABEL --}}
        @php
        $bidang = $bidang ?? 'semua';
        @endphp

        @if($bidang == 'semua' || $bidang == 'pendidikan')
        <h3>Laporan Pendidikan Dan Keterampilan</h3>
        <table align="center">
            <thead>
                <tr style="background: #e0f2fe;">
                    <th align="center" rowspan="2"><b>NO</b></th>
                    <th align="center" rowspan="2"><b>Kecamatan</b></th>
                    <th align="center" rowspan="2"><b>Warga Buta</b></th>
                    <th align="center" colspan="2"><b>Paket A</b></th>
                    <th align="center" colspan="2"><b>Paket B</b></th>
                    <th align="center" colspan="2"><b>Paket C</b></th>
                    <th align="center" colspan="2"><b>KF</b></th>
                    <th align="center" rowspan="2"><b>Paud</b></th>
                    <th align="center" rowspan="2"><b>Taman Bacaan</b></th>
                    <th align="center" rowspan="2"><b>Jumlah Klp</b></th>
                    <th align="center" rowspan="2"><b>JumLah Ibu Peserta</b></th>
                    <th align="center" rowspan="2"><b>JumLah Ape</b></th>
                    <th align="center" rowspan="2"><b>JumLah Kel Simulasi</b></th>
                    <th align="center" rowspan="2"><b>KF</b></th>
                    <th align="center" rowspan="2"><b>Paud Tutor</b></th>
                    <th align="center" rowspan="2"><b>BKB</b></th>
                    <th align="center" rowspan="2"><b>Koperasi</b></th>
                    <th align="center" rowspan="2"><b>Ketrampilan</b></th>
                    <th align="center" rowspan="2"><b>LP3PKK</b></th>
                    <th align="center" rowspan="2"><b>TP3PKK</b></th>
                    <th align="center" rowspan="2"><b>Damas PKK</b></th>
                </tr>
                <tr style="background: #e0f2fe;">
                    <th align="center"><b>Kel Belajar</b></th>
                    <th align="center"><b>Warga Belajar</b></th>
                    <th align="center"><b>Kel Belajar</b></th>
                    <th align="center"><b>Warga Belajar</b></th>
                    <th align="center"><b>Kel Belajar</b></th>
                    <th align="center"><b>Warga Belajar</b></th>
                    <th align="center"><b>Kel Belajar</b></th>
                    <th align="center"><b>Warga Belajar</b></th>
                </tr>
            </thead>
            <tbody>
                @php
                $no_pd = 1;
                $t_wbuta = 0; $t_kla = 0; $t_wla = 0; $t_klb = 0; $t_wlb = 0; $t_klc = 0; $t_wlc = 0;
                $t_klkf = 0; $t_wlkf = 0; $t_paud = 0; $t_tb = 0; $t_jklp = 0; $t_jibu = 0; $t_jape = 0;
                $t_jsim = 0; $t_kf = 0; $t_ptutor = 0; $t_bkb = 0; $t_kop = 0; $t_ket = 0; $t_lp3 = 0;
                $t_tp3 = 0; $t_damas = 0;
                @endphp
                @forelse($pendidikan as $item)
                @php
                $t_wbuta += $item->warga_buta ?? 0; $t_kla += $item->kel_belajarA ?? 0; $t_wla += $item->warga_belajarA ?? 0;
                $t_klb += $item->kel_belajarB ?? 0; $t_wlb += $item->warga_belajarB ?? 0; $t_klc += $item->kel_belajarC ?? 0;
                $t_wlc += $item->warga_belajarC ?? 0; $t_klkf += $item->kel_belajarKF ?? 0; $t_wlkf += $item->warga_belajarKF ?? 0;
                $t_paud += $item->paud ?? 0; $t_tb += $item->taman_bacaan ?? 0; $t_jklp += $item->jumlah_klp ?? 0;
                $t_jibu += $item->jumlah_ibu_peserta ?? 0; $t_jape += $item->jumlah_ape ?? 0; $t_jsim += $item->jumlah_kel_simulasi ?? 0;
                $t_kf += $item->KF ?? 0; $t_ptutor += $item->paud_tutor ?? 0; $t_bkb += $item->BKB ?? 0; $t_kop += $item->koperasi ?? 0;
                $t_ket += $item->ketrampilan ?? 0; $t_lp3 += $item->LP3PKK ?? 0; $t_tp3 += $item->TP3PKK ?? 0; $t_damas += $item->damas_pkk ?? 0;
                @endphp
                <tr>
                    <td align="center">{{ $no_pd++ }}</td>
                    <td align="center">{{ $item->nama_kec }}</td>
                    <td align="center">{{ $item->warga_buta }}</td>
                    <td align="center">{{ $item->kel_belajarA }}</td>
                    <td align="center">{{ $item->warga_belajarA }}</td>
                    <td align="center">{{ $item->kel_belajarB }}</td>
                    <td align="center">{{ $item->warga_belajarB }}</td>
                    <td align="center">{{ $item->kel_belajarC }}</td>
                    <td align="center">{{ $item->warga_belajarC }}</td>
                    <td align="center">{{ $item->kel_belajarKF }}</td>
                    <td align="center">{{ $item->warga_belajarKF }}</td>
                    <td align="center">{{ $item->paud }}</td>
                    <td align="center">{{ $item->taman_bacaan }}</td>
                    <td align="center">{{ $item->jumlah_klp }}</td>
                    <td align="center">{{ $item->jumlah_ibu_peserta }}</td>
                    <td align="center">{{ $item->jumlah_ape }}</td>
                    <td align="center">{{ $item->jumlah_kel_simulasi }}</td>
                    <td align="center">{{ $item->KF }}</td>
                    <td align="center">{{ $item->paud_tutor }}</td>
                    <td align="center">{{ $item->BKB }}</td>
                    <td align="center">{{ $item->koperasi }}</td>
                    <td align="center">{{ $item->ketrampilan }}</td>
                    <td align="center">{{ $item->LP3PKK }}</td>
                    <td align="center">{{ $item->TP3PKK }}</td>
                    <td align="center">{{ $item->damas_pkk }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="25" align="center"><i>Tidak ada data laporan untuk dicetak</i></td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background-color: #f2f2f2;">
                    <td colspan="2" align="center"><b>TOTAL</b></td>
                    <td align="center"><b>{{ $t_wbuta }}</b></td>
                    <td align="center"><b>{{ $t_kla }}</b></td>
                    <td align="center"><b>{{ $t_wla }}</b></td>
                    <td align="center"><b>{{ $t_klb }}</b></td>
                    <td align="center"><b>{{ $t_wlb }}</b></td>
                    <td align="center"><b>{{ $t_klc }}</b></td>
                    <td align="center"><b>{{ $t_wlc }}</b></td>
                    <td align="center"><b>{{ $t_klkf }}</b></td>
                    <td align="center"><b>{{ $t_wlkf }}</b></td>
                    <td align="center"><b>{{ $t_paud }}</b></td>
                    <td align="center"><b>{{ $t_tb }}</b></td>
                    <td align="center"><b>{{ $t_jklp }}</b></td>
                    <td align="center"><b>{{ $t_jibu }}</b></td>
                    <td align="center"><b>{{ $t_jape }}</b></td>
                    <td align="center"><b>{{ $t_jsim }}</b></td>
                    <td align="center"><b>{{ $t_kf }}</b></td>
                    <td align="center"><b>{{ $t_ptutor }}</b></td>
                    <td align="center"><b>{{ $t_bkb }}</b></td>
                    <td align="center"><b>{{ $t_kop }}</b></td>
                    <td align="center"><b>{{ $t_ket }}</b></td>
                    <td align="center"><b>{{ $t_lp3 }}</b></td>
                    <td align="center"><b>{{ $t_tp3 }}</b></td>
                    <td align="center"><b>{{ $t_damas }}</b></td>
                </tr>
            </tfoot>
        </table>
        @endif

        @if($bidang == 'semua' || $bidang == 'koperasi')
        <h3>Laporan Pengembangan Kehidupan Berkoperasi</h3>
        <table align="center">
            <thead>
                <tr style="background: #e0f2fe;">
                    <th align="center"><b>NO</b></th>
                    <th align="center"><b>Kecamatan</b></th>
                    <th align="center"><b>Jumlah Kel Pemula</b></th>
                    <th align="center"><b>Jumlah Peserta Pemula</b></th>
                    <th align="center"><b>Jumlah Kel Madya</b></th>
                    <th align="center"><b>Jumlah Peserta Madya</b></th>
                    <th align="center"><b>Jumlah Kel Utama</b></th>
                    <th align="center"><b>Jumlah Peserta Utama</b></th>
                    <th align="center"><b>Jumlah Kel Mandiri</b></th>
                    <th align="center"><b>Jumlah Peserta Mandiri</b></th>
                    <th align="center"><b>Jumlah Kel Hukum</b></th>
                    <th align="center"><b>Jumlah Peserta Hukum</b></th>
                </tr>
            </thead>
            <tbody>
                @php
                $no_kop = 1;
                $t_kpem = 0; $t_ppem = 0; $t_kmad = 0; $t_pmad = 0;
                $t_kuta = 0; $t_puta = 0; $t_kman = 0; $t_pman = 0;
                $t_khuk = 0; $t_phuk = 0;
                @endphp
                @forelse($pengembangan as $item)
                @php
                $t_kpem += $item->jumlah_kelompok_pemula ?? 0; $t_ppem += $item->jumlah_peserta_pemula ?? 0;
                $t_kmad += $item->jumlah_kelompok_madya ?? 0; $t_pmad += $item->jumlah_peserta_madya ?? 0;
                $t_kuta += $item->jumlah_kelompok_utama ?? 0; $t_puta += $item->jumlah_peserta_utama ?? 0;
                $t_kman += $item->jumlah_kelompok_mandiri ?? 0; $t_pman += $item->jumlah_peserta_mandiri ?? 0;
                $t_khuk += $item->jumlah_kelompok_hukum ?? 0; $t_phuk += $item->jumlah_peserta_hukum ?? 0;
                @endphp
                <tr>
                    <td align="center">{{ $no_kop++ }}</td>
                    <td align="center">{{ $item->nama_kec }}</td>
                    <td align="center">{{ $item->jumlah_kelompok_pemula }}</td>
                    <td align="center">{{ $item->jumlah_peserta_pemula }}</td>
                    <td align="center">{{ $item->jumlah_kelompok_madya }}</td>
                    <td align="center">{{ $item->jumlah_peserta_madya }}</td>
                    <td align="center">{{ $item->jumlah_kelompok_utama }}</td>
                    <td align="center">{{ $item->jumlah_peserta_utama }}</td>
                    <td align="center">{{ $item->jumlah_kelompok_mandiri }}</td>
                    <td align="center">{{ $item->jumlah_peserta_mandiri }}</td>
                    <td align="center">{{ $item->jumlah_kelompok_hukum }}</td>
                    <td align="center">{{ $item->jumlah_peserta_hukum }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="12" align="center"><i>Tidak ada data laporan untuk dicetak</i></td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background-color: #f2f2f2;">
                    <td colspan="2" align="center"><b>TOTAL</b></td>
                    <td align="center"><b>{{ $t_kpem }}</b></td>
                    <td align="center"><b>{{ $t_ppem }}</b></td>
                    <td align="center"><b>{{ $t_kmad }}</b></td>
                    <td align="center"><b>{{ $t_pmad }}</b></td>
                    <td align="center"><b>{{ $t_kuta }}</b></td>
                    <td align="center"><b>{{ $t_puta }}</b></td>
                    <td align="center"><b>{{ $t_kman }}</b></td>
                    <td align="center"><b>{{ $t_pman }}</b></td>
                    <td align="center"><b>{{ $t_khuk }}</b></td>
                    <td align="center"><b>{{ $t_phuk }}</b></td>
                </tr>
            </tfoot>
        </table>
        @endif

        @php

        $wakil = \Illuminate\Support\Facades\DB::table('ttds')
        ->whereNull('pokja')
        ->first();

        $ketua = \Illuminate\Support\Facades\DB::table('ttds')
        ->where('pokja', 'Kelompok Kerja II')
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