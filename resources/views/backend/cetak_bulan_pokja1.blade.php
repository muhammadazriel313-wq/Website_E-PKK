<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Perbulan - Pokja 1</title>
    <style>
        table { width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 30px; }
        th, td { padding: 8px; border: 1px solid black; }
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
            <h2>Laporan Perbulan - Kelompok Kerja (POKJA) 1</h2>
            {{-- PENGAMAN: Mengganti $created_at menjadi $tanggal agar tidak error --}}
            <h4>Bulan : {{ $tanggal ?? date('F Y') }}</h4>
        </div>

        <div class="separator"></div>
        <div class="signature">
            <p>Tanggal Cetak : {{ $formattedDate ?? date('d F Y') }}</p>
        </div>

        {{-- JURUS KEBAL: Jika $bidang tidak dikirim Controller, otomatis set ke 'semua' --}}
        @php
            $bidang = $bidang ?? 'semua';
        @endphp

        @if($bidang == 'semua' || $bidang == 'gotongroyong')
            <h3>Laporan Gotong Royong</h3>
            <table align="center">
                <thead>
                    <tr style="background: #e0f2fe;">
                        <th align="center"><b>NO</b></th>
                        <th align="center"><b>Kecamatan</b></th>
                        <th align="center"><b>Kerja Bakti</b></th>
                        <th align="center"><b>Rukun Kematian</b></th>
                        <th align="center"><b>Keagamaan</b></th>
                        <th align="center"><b>Jimpitan</b></th>
                        <th align="center"><b>Arisan</b></th>
                    </tr>
                </thead>
                <tbody>
                    @php $no_gr = 1; $t_kerja_bakti = 0; $t_rukun = 0; $t_agama = 0; $t_jimpitan = 0; $t_arisan = 0; @endphp
                    @forelse($gotongroyong as $item)
                        @php
                            $t_kerja_bakti += $item->kerja_bakti ?? 0; $t_rukun += $item->rukun_kematian ?? 0;
                            $t_agama += $item->keagamaan ?? 0; $t_jimpitan += $item->jimpitan ?? 0; $t_arisan += $item->arisan ?? 0;
                        @endphp
                        <tr>
                            <td align="center">{{ $no_gr++ }}</td>
                            <td align="center">{{ $item->nama_kec }}</td>
                            <td align="center">{{ $item->kerja_bakti }}</td>
                            <td align="center">{{ $item->rukun_kematian }}</td>
                            <td align="center">{{ $item->keagamaan }}</td>
                            <td align="center">{{ $item->jimpitan }}</td>
                            <td align="center">{{ $item->arisan }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" align="center"><i>Tidak ada data laporan untuk dicetak</i></td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr style="background-color: #f2f2f2;">
                        <td colspan="2" align="center"><b>TOTAL</b></td>
                        <td align="center"><b>{{ $t_kerja_bakti }}</b></td>
                        <td align="center"><b>{{ $t_rukun }}</b></td>
                        <td align="center"><b>{{ $t_agama }}</b></td>
                        <td align="center"><b>{{ $t_jimpitan }}</b></td>
                        <td align="center"><b>{{ $t_arisan }}</b></td>
                    </tr>
                </tfoot>
            </table>
        @endif

        @if($bidang == 'semua' || $bidang == 'penghayatan')
            <h3>Laporan Penghayatan Dan Pengamalan Pancasila</h3>
            <table align="center">
                <thead>
                    <tr style="background: #e0f2fe;">
                        <th align="center"><b>NO</b></th>
                        <th align="center"><b>Kecamatan</b></th>
                        <th align="center"><b>Jumlah Kel Simulasi 1</b></th>
                        <th align="center"><b>Jumlah Anggota 1</b></th>
                        <th align="center"><b>Jumlah Kel Simulasi 2</b></th>
                        <th align="center"><b>Jumlah Anggota 2</b></th>
                        <th align="center"><b>Jumlah Kel Simulasi 3</b></th>
                        <th align="center"><b>Jumlah Anggota 3</b></th>
                        <th align="center"><b>Jumlah Kel Simulasi 4</b></th>
                        <th align="center"><b>Jumlah Anggota 4</b></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no_ph = 1; $t_kel1 = 0; $t_ang1 = 0; $t_kel2 = 0; $t_ang2 = 0; $t_kel3 = 0; $t_ang3 = 0; $t_kel4 = 0; $t_ang4 = 0;
                    @endphp
                    @forelse($penghayatan as $item)
                        @php
                            $t_kel1 += $item->jumlah_kel_simulasi1 ?? 0; $t_ang1 += $item->jumlah_anggota1 ?? 0;
                            $t_kel2 += $item->jumlah_kel_simulasi2 ?? 0; $t_ang2 += $item->jumlah_anggota2 ?? 0;
                            $t_kel3 += $item->jumlah_kel_simulasi3 ?? 0; $t_ang3 += $item->jumlah_anggota3 ?? 0;
                            $t_kel4 += $item->jumlah_kel_simulasi4 ?? 0; $t_ang4 += $item->jumlah_anggota4 ?? 0;
                        @endphp
                        <tr>
                            <td align="center">{{ $no_ph++ }}</td>
                            <td align="center">{{ $item->nama_kec }}</td>
                            <td align="center">{{ $item->jumlah_kel_simulasi1 }}</td>
                            <td align="center">{{ $item->jumlah_anggota1 }}</td>
                            <td align="center">{{ $item->jumlah_kel_simulasi2 }}</td>
                            <td align="center">{{ $item->jumlah_anggota2 }}</td>
                            <td align="center">{{ $item->jumlah_kel_simulasi3 }}</td>
                            <td align="center">{{ $item->jumlah_anggota3 }}</td>
                            <td align="center">{{ $item->jumlah_kel_simulasi4 }}</td>
                            <td align="center">{{ $item->jumlah_anggota4 }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="10" align="center"><i>Tidak ada data laporan untuk dicetak</i></td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr style="background-color: #f2f2f2;">
                        <td colspan="2" align="center"><b>TOTAL</b></td>
                        <td align="center"><b>{{ $t_kel1 }}</b></td>
                        <td align="center"><b>{{ $t_ang1 }}</b></td>
                        <td align="center"><b>{{ $t_kel2 }}</b></td>
                        <td align="center"><b>{{ $t_ang2 }}</b></td>
                        <td align="center"><b>{{ $t_kel3 }}</b></td>
                        <td align="center"><b>{{ $t_ang3 }}</b></td>
                        <td align="center"><b>{{ $t_kel4 }}</b></td>
                        <td align="center"><b>{{ $t_ang4 }}</b></td>
                    </tr>
                </tfoot>
            </table>
        @endif

        @if($bidang == 'semua' || $bidang == 'kader')
            <h3>Laporan Kader Pokja 1</h3>
            <table align="center">
                <thead>
                    <tr style="background: #e0f2fe;">
                        <th align="center"><b>NO</b></th>
                        <th align="center"><b>Kecamatan</b></th>
                        <th align="center"><b>PKBN</b></th>
                        <th align="center"><b>PKDRT</b></th>
                        <th align="center"><b>Pola Asuh</b></th>
                    </tr>
                </thead>
                <tbody>
                    @php $no_pk = 1; $t_pkbn = 0; $t_pkdrt = 0; $t_pola = 0; @endphp
                    @forelse($laporanpokja1 as $item)
                        @php
                            $t_pkbn += $item->PKBN ?? 0; $t_pkdrt += $item->PKDRT ?? 0; $t_pola += $item->pola_asuh ?? 0;
                        @endphp
                        <tr>
                            <td align="center">{{ $no_pk++ }}</td>
                            <td align="center">{{ $item->nama_kec }}</td>
                            <td align="center">{{ $item->PKBN }}</td>
                            <td align="center">{{ $item->PKDRT }}</td>
                            <td align="center">{{ $item->pola_asuh }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" align="center"><i>Tidak ada data laporan untuk dicetak</i></td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr style="background-color: #f2f2f2;">
                        <td colspan="2" align="center"><b>TOTAL</b></td>
                        <td align="center"><b>{{ $t_pkbn }}</b></td>
                        <td align="center"><b>{{ $t_pkdrt }}</b></td>
                        <td align="center"><b>{{ $t_pola }}</b></td>
                    </tr>
                </tfoot>
            </table>
        @endif

        @php
            if (!isset($wakil) || count($wakil) == 0) {
                $wakil = \Illuminate\Support\Facades\DB::table('ttds')->where('pokja', 'Kelompok Kerja I')
                            ->where(function($q) { $q->where('jabatan', 'like', '%Wakil%')->orWhere('jabatan', 'like', '%Sekretaris%'); })->get();
            }
            if (!isset($ketua) || count($ketua) == 0) {
                $ketua = \Illuminate\Support\Facades\DB::table('ttds')->where('pokja', 'Kelompok Kerja I')->where('jabatan', 'Ketua')->get();
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
                        <a>{{ $ketuaa->pokja ?? 'Kelompok Kerja I' }}</a><br>
                        <a>{{ $ketuaa->jabatan }}</a><br><br><br><br>
                        <a style="text-decoration: underline; font-weight: bold;">{{ $ketuaa->nama_terang }}</a>
                    @empty
                        <a>Nganjuk, {{ date('d F Y') }}</a><br>
                        <a>Kelompok Kerja I</a><br>
                        <a>Ketua</a><br><br><br><br>
                        <a>( ......................................... )</a>
                    @endforelse
                </div>
            </div>
        </div>

        <script>
            window.onload = function () {
                window.print();
            };
        </script>
    </div>
</body>
</html>