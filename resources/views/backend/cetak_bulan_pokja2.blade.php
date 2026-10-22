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

        {{-- [PERUBAHAN 2026-10-09] Kode lama dinonaktifkan:
        @if($bidang == 'semua' || $bidang == 'pendidikan')
        <h3>Laporan Pendidikan Dan Keterampilan</h3>
        <table align="center">
            <thead>
                <tr style="background: #e0f2fe;">
                    <th align="center" rowspan="2"><b>NO</b></th>
                    <th align="center" rowspan="2"><b>Kecamatan</b></th>
                    ...
                </tr>
            </thead>
            ...
        </table>
        @endif
        @if($bidang == 'semua' || $bidang == 'koperasi')
        <h3>Laporan Pengembangan Kehidupan Berkoperasi</h3>
        <table align="center">
            ...
        </table>
        @endif
        --}}

        {{-- ========================================================= --}}
        {{-- 1. TABEL PENDIDIKAN DAN KETERAMPILAN                      --}}
        {{-- ========================================================= --}}
        @if($bidang == 'semua' || $bidang == 'pendidikan')
        <h3>Laporan Pendidikan Dan Keterampilan</h3>
        <table align="center" class="table-pendidikan" style="font-size: 8px; width: 100%; border-collapse: collapse; margin-bottom: 25px;">
            <thead>
                {{-- [PERUBAHAN 2026-10-09] Header diselaraskan dengan decpendidikan (4 baris hierarki) --}}
                <tr style="background: #e0f2fe;">
                    <th scope="col" rowspan="4" align="center" style="vertical-align: middle;">No</th>
                    @if (Auth::guard('web')->check())
                    <th scope="col" rowspan="4" align="center" style="vertical-align: middle;">Kecamatan</th>
                    <th scope="col" rowspan="4" align="center" style="vertical-align: middle;">Desa</th>
                    @elseif (Auth::guard('pengguna')->check())
                    <th scope="col" rowspan="4" align="center" style="vertical-align: middle;">Desa</th>
                    @endif
                    <th scope="col" colspan="23" align="center">PENDIDIKAN DAN KETERAMPILAN</th>
                    <th scope="col" rowspan="4" align="center" style="vertical-align: middle;">Keterangan</th>
                </tr>
                <tr style="background: #e0f2fe;">
                    <th scope="col" rowspan="3" align="center" style="vertical-align: middle;">Warga Buta</th>
                    <th scope="col" colspan="8" align="center">JUMLAH KELOMPOK BELAJAR</th>
                    <th scope="col" rowspan="3" align="center" style="vertical-align: middle;">PAUD<br>Sejenis</th>
                    <th scope="col" rowspan="3" align="center" style="vertical-align: middle;">Taman Bacaan /<br>Perpustakaan</th>
                    <th scope="col" colspan="4" align="center">BKB</th>
                    <th scope="col" colspan="5" align="center">KADER KHUSUS</th>
                    <th scope="col" colspan="3" align="center">JUMLAH KADER YANG SUDAH DILATIH</th>
                </tr>
                <tr style="background: #e0f2fe;">
                    <th scope="col" colspan="2" align="center">Paket A</th>
                    <th scope="col" colspan="2" align="center">Paket B</th>
                    <th scope="col" colspan="2" align="center">Paket C</th>
                    <th scope="col" colspan="2" align="center">KF</th>
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">Jml Kelompok</th>
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">Jml Ibu Peserta</th>
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">Jml APE (Set)</th>
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">Jml Klp Simulasi</th>
                    <th scope="col" colspan="2" align="center">Tutor</th>
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">BKB</th>
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">Koperasi</th>
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">Keterampilan</th>
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">LP3PKK</th>
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">TP3PKK</th>
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">Damas PKK</th>
                </tr>
                <tr style="background: #e0f2fe;">
                    @for ($i = 0; $i < 4; $i++)
                    <th scope="col" align="center" style="font-size: 7.5px;">Klp</th>
                    <th scope="col" align="center" style="font-size: 7.5px;">Warga</th>
                    @endfor
                    <th scope="col" align="center" style="font-size: 7.5px;">KF</th>
                    <th scope="col" align="center" style="font-size: 7.5px;">PAUD<br>Sejenis</th>
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
                    @if (Auth::guard('web')->check())
                    <td align="center">{{ $item->nama_kec ?? '-' }}</td>
                    <td align="center">{{ $item->nama_desa ?? '-' }}</td>
                    @elseif (Auth::guard('pengguna')->check())
                    <td align="center">{{ $item->nama_desa ?? '-' }}</td>
                    @endif
                    <td align="center">{{ $item->warga_buta ?? '0' }}</td>
                    <td align="center">{{ $item->kel_belajarA ?? '0' }}</td>
                    <td align="center">{{ $item->warga_belajarA ?? '0' }}</td>
                    <td align="center">{{ $item->kel_belajarB ?? '0' }}</td>
                    <td align="center">{{ $item->warga_belajarB ?? '0' }}</td>
                    <td align="center">{{ $item->kel_belajarC ?? '0' }}</td>
                    <td align="center">{{ $item->warga_belajarC ?? '0' }}</td>
                    <td align="center">{{ $item->kel_belajarKF ?? '0' }}</td>
                    <td align="center">{{ $item->warga_belajarKF ?? '0' }}</td>
                    <td align="center">{{ $item->paud ?? '0' }}</td>
                    <td align="center">{{ $item->taman_bacaan ?? '0' }}</td>
                    <td align="center">{{ $item->jumlah_klp ?? '0' }}</td>
                    <td align="center">{{ $item->jumlah_ibu_peserta ?? '0' }}</td>
                    <td align="center">{{ $item->jumlah_ape ?? '0' }}</td>
                    <td align="center">{{ $item->jumlah_kel_simulasi ?? '0' }}</td>
                    <td align="center">{{ $item->KF ?? '0' }}</td>
                    <td align="center">{{ $item->paud_tutor ?? '0' }}</td>
                    <td align="center">{{ $item->BKB ?? '0' }}</td>
                    <td align="center">{{ $item->koperasi ?? '0' }}</td>
                    <td align="center">{{ $item->ketrampilan ?? '0' }}</td>
                    <td align="center">{{ $item->LP3PKK ?? '0' }}</td>
                    <td align="center">{{ $item->TP3PKK ?? '0' }}</td>
                    <td align="center">{{ $item->damas_pkk ?? '0' }}</td>
                    <td align="center">{{ $item->catatan ?: '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ Auth::guard('web')->check() ? 27 : 26 }}" align="center"><i>Tidak ada data laporan untuk dicetak</i></td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background-color: #f2f2f2; font-weight: bold;">
                    <td colspan="{{ Auth::guard('web')->check() ? 3 : 2 }}" align="center">TOTAL</td>
                    <td align="center">{{ $t_wbuta }}</td>
                    <td align="center">{{ $t_kla }}</td>
                    <td align="center">{{ $t_wla }}</td>
                    <td align="center">{{ $t_klb }}</td>
                    <td align="center">{{ $t_wlb }}</td>
                    <td align="center">{{ $t_klc }}</td>
                    <td align="center">{{ $t_wlc }}</td>
                    <td align="center">{{ $t_klkf }}</td>
                    <td align="center">{{ $t_wlkf }}</td>
                    <td align="center">{{ $t_paud }}</td>
                    <td align="center">{{ $t_tb }}</td>
                    <td align="center">{{ $t_jklp }}</td>
                    <td align="center">{{ $t_jibu }}</td>
                    <td align="center">{{ $t_jape }}</td>
                    <td align="center">{{ $t_jsim }}</td>
                    <td align="center">{{ $t_kf }}</td>
                    <td align="center">{{ $t_ptutor }}</td>
                    <td align="center">{{ $t_bkb }}</td>
                    <td align="center">{{ $t_kop }}</td>
                    <td align="center">{{ $t_ket }}</td>
                    <td align="center">{{ $t_lp3 }}</td>
                    <td align="center">{{ $t_tp3 }}</td>
                    <td align="center">{{ $t_damas }}</td>
                    <td align="center">-</td>
                </tr>
            </tfoot>
        </table>
        @endif

        {{-- ========================================================= --}}
        {{-- 2. TABEL PENGEMBANGAN KEHIDUPAN BERKOPERASI              --}}
        {{-- ========================================================= --}}
        @if($bidang == 'semua' || $bidang == 'koperasi')
        <h3>Laporan Pengembangan Kehidupan Berkoperasi</h3>
        <table align="center" style="font-size: 10px; width: 100%; border-collapse: collapse; margin-bottom: 25px;">
            <thead>
                {{-- [PERUBAHAN 2026-10-09] Header diselaraskan dengan decpengembangan (4 baris hierarki) --}}
                <tr style="background: #e0f2fe;">
                    <th scope="col" rowspan="4" align="center" style="vertical-align: middle;">No</th>
                    @if (Auth::guard('web')->check())
                    <th scope="col" rowspan="4" align="center" style="vertical-align: middle;">Kecamatan</th>
                    <th scope="col" rowspan="4" align="center" style="vertical-align: middle;">Desa</th>
                    @elseif (Auth::guard('pengguna')->check())
                    <th scope="col" rowspan="4" align="center" style="vertical-align: middle;">Desa</th>
                    @endif
                    <th scope="col" colspan="10" align="center">PENGEMBANGAN KEHIDUPAN BERKOPERASI</th>
                    <th scope="col" rowspan="4" align="center" style="vertical-align: middle;">Keterangan</th>
                </tr>
                <tr style="background: #e0f2fe;">
                    <th scope="col" colspan="8" align="center">PRAKOPERASI / USAHA BERSAMA / UP2K</th>
                    <th scope="col" colspan="2" align="center">KOPERASI BERBADAN HUKUM</th>
                </tr>
                <tr style="background: #e0f2fe;">
                    <th scope="col" colspan="2" align="center">Pemula</th>
                    <th scope="col" colspan="2" align="center">Madya</th>
                    <th scope="col" colspan="2" align="center">Utama</th>
                    <th scope="col" colspan="2" align="center">Mandiri</th>
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">Jml</th>
                    <th scope="col" rowspan="2" align="center" style="vertical-align: middle;">Anggt</th>
                </tr>
                <tr style="background: #e0f2fe;">
                    @for ($i = 0; $i < 4; $i++)
                    <th scope="col" align="center">Jml Kel</th>
                    <th scope="col" align="center">Psrt</th>
                    @endfor
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
                    @if (Auth::guard('web')->check())
                    <td align="center">{{ $item->nama_kec ?? '-' }}</td>
                    <td align="center">{{ $item->nama_desa ?? '-' }}</td>
                    @elseif (Auth::guard('pengguna')->check())
                    <td align="center">{{ $item->nama_desa ?? '-' }}</td>
                    @endif
                    <td align="center">{{ $item->jumlah_kelompok_pemula ?? '0' }}</td>
                    <td align="center">{{ $item->jumlah_peserta_pemula ?? '0' }}</td>
                    <td align="center">{{ $item->jumlah_kelompok_madya ?? '0' }}</td>
                    <td align="center">{{ $item->jumlah_peserta_madya ?? '0' }}</td>
                    <td align="center">{{ $item->jumlah_kelompok_utama ?? '0' }}</td>
                    <td align="center">{{ $item->jumlah_peserta_utama ?? '0' }}</td>
                    <td align="center">{{ $item->jumlah_kelompok_mandiri ?? '0' }}</td>
                    <td align="center">{{ $item->jumlah_peserta_mandiri ?? '0' }}</td>
                    <td align="center">{{ $item->jumlah_kelompok_hukum ?? '0' }}</td>
                    <td align="center">{{ $item->jumlah_peserta_hukum ?? '0' }}</td>
                    <td align="center">{{ $item->catatan ?: '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ Auth::guard('web')->check() ? 14 : 13 }}" align="center"><i>Tidak ada data laporan untuk dicetak</i></td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background-color: #f2f2f2; font-weight: bold;">
                    <td colspan="{{ Auth::guard('web')->check() ? 3 : 2 }}" align="center">TOTAL</td>
                    <td align="center">{{ $t_kpem }}</td>
                    <td align="center">{{ $t_ppem }}</td>
                    <td align="center">{{ $t_kmad }}</td>
                    <td align="center">{{ $t_pmad }}</td>
                    <td align="center">{{ $t_kuta }}</td>
                    <td align="center">{{ $t_puta }}</td>
                    <td align="center">{{ $t_kman }}</td>
                    <td align="center">{{ $t_pman }}</td>
                    <td align="center">{{ $t_khuk }}</td>
                    <td align="center">{{ $t_phuk }}</td>
                    <td align="center">-</td>
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