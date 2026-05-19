<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Pertahun - Pokja 4</title>
    <style>
        table { width: 100%; border-collapse: collapse; font-size: 10px; margin-bottom: 30px; }
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
            <h2>Laporan Pertahun - Kelompok Kerja (POKJA) 4</h2>
            <h4>Tahun : {{ $tanggal ?? date('Y') }}</h4>
        </div>

        <div class="separator"></div>
        <div class="signature">
            <p>Tanggal Cetak : {{ $formattedDate ?? date('d F Y') }}</p>
        </div>

        {{-- JURUS KEBAL --}}
        @php
            $bidang = $bidang ?? 'semua';
            $kesehatan = $kesehatan ?? [];
            $kelestarian = $kelestarian ?? [];
            $perencanaan = $perencanaan ?? [];
            $laporanpokja4 = $laporanpokja4 ?? [];
            $inovasiPrioritas = $inovasiPrioritas ?? [];
            $inovasiUnggulan = $inovasiUnggulan ?? [];
        @endphp

        @if($bidang == 'semua' || $bidang == 'kesehatan')
            <h3>Laporan Bidang Kesehatan</h3>
            <table align="center">
                <thead>
                    <tr>
                        <th align="center"><b>NO</b></th>
                        <th align="center"><b>Kecamatan</b></th>
                        <th align="center"><b>Jml Posyandu</b></th>
                        <th align="center"><b>Jml Posyandu Terintegrasi</b></th>
                        <th align="center"><b>Jml Kelompok</b></th>
                        <th align="center"><b>Jml Anggota</b></th>
                        <th align="center"><b>Jml Kartu Gratis</b></th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $no_kes = 1; $t_pos = 0; $t_posit = 0; $t_klp = 0; $t_ang = 0; $t_krt = 0;
                    @endphp
                    @forelse($kesehatan as $item)
                        @php
                            $t_pos += $item->jumlah_posyandu ?? 0; $t_posit += $item->jumlah_posyandu_iterasi ?? 0;
                            $t_klp += $item->jumlah_klp ?? 0; $t_ang += $item->jumlah_anggota ?? 0;
                            $t_krt += $item->jumlah_kartu_gratis ?? 0;
                        @endphp
                        <tr>
                            <td align="center">{{ $no_kes++ }}</td>
                            <td align="center">{{ $item->nama_kec }}</td>
                            <td align="center">{{ $item->jumlah_posyandu }}</td>
                            <td align="center">{{ $item->jumlah_posyandu_iterasi }}</td>
                            <td align="center">{{ $item->jumlah_klp }}</td>
                            <td align="center">{{ $item->jumlah_anggota }}</td>
                            <td align="center">{{ $item->jumlah_kartu_gratis }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" align="center"><i>Tidak ada data laporan untuk dicetak</i></td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr style="background-color: #f2f2f2;">
                        <td colspan="2" align="center"><b>TOTAL</b></td>
                        <td align="center"><b>{{ $t_pos }}</b></td>
                        <td align="center"><b>{{ $t_posit }}</b></td>
                        <td align="center"><b>{{ $t_klp }}</b></td>
                        <td align="center"><b>{{ $t_ang }}</b></td>
                        <td align="center"><b>{{ $t_krt }}</b></td>
                    </tr>
                </tfoot>
            </table>
        @endif

        @if($bidang == 'semua' || $bidang == 'kelestarian')
            <h3>Laporan Kelestarian Lingkungan Hidup</h3>
            <table align="center">
                <thead>
                    <tr>
                        <th align="center"><b>NO</b></th>
                        <th align="center"><b>Kecamatan</b></th>
                        <th align="center"><b>Jamban</b></th>
                        <th align="center"><b>SPAL</b></th>
                        <th align="center"><b>TPS</b></th>
                        <th align="center"><b>MCK</b></th>
                        <th align="center"><b>PDAM</b></th>
                        <th align="center"><b>Sumur</b></th>
                        <th align="center"><b>Lain-lain</b></th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $no_kel = 1; $t_jam = 0; $t_spal = 0; $t_tps = 0; $t_mck = 0; $t_pdam = 0; $t_sumur = 0; $t_dll = 0;
                    @endphp
                    @forelse($kelestarian as $item)
                        @php
                            $t_jam += $item->jamban ?? 0; $t_spal += $item->spal ?? 0; $t_tps += $item->tps ?? 0;
                            $t_mck += $item->mck ?? 0; $t_pdam += $item->pdam ?? 0; $t_sumur += $item->sumur ?? 0; $t_dll += $item->dll ?? 0;
                        @endphp
                        <tr>
                            <td align="center">{{ $no_kel++ }}</td>
                            <td align="center">{{ $item->nama_kec }}</td>
                            <td align="center">{{ $item->jamban }}</td>
                            <td align="center">{{ $item->spal }}</td>
                            <td align="center">{{ $item->tps }}</td>
                            <td align="center">{{ $item->mck }}</td>
                            <td align="center">{{ $item->pdam }}</td>
                            <td align="center">{{ $item->sumur }}</td>
                            <td align="center">{{ $item->dll }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="9" align="center"><i>Tidak ada data laporan untuk dicetak</i></td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr style="background-color: #f2f2f2;">
                        <td colspan="2" align="center"><b>TOTAL</b></td>
                        <td align="center"><b>{{ $t_jam }}</b></td>
                        <td align="center"><b>{{ $t_spal }}</b></td>
                        <td align="center"><b>{{ $t_tps }}</b></td>
                        <td align="center"><b>{{ $t_mck }}</b></td>
                        <td align="center"><b>{{ $t_pdam }}</b></td>
                        <td align="center"><b>{{ $t_sumur }}</b></td>
                        <td align="center"><b>{{ $t_dll }}</b></td>
                    </tr>
                </tfoot>
            </table>
        @endif

        @if($bidang == 'semua' || $bidang == 'perencanaan')
            <h3>Laporan Perencanaan Sehat</h3>
            <table align="center">
                <thead>
                    <tr>
                        <th align="center"><b>NO</b></th>
                        <th align="center"><b>Kecamatan</b></th>
                        <th align="center"><b>Jml PUS</b></th>
                        <th align="center"><b>Jml WUS</b></th>
                        <th align="center"><b>KB Pria</b></th>
                        <th align="center"><b>KB Wanita</b></th>
                        <th align="center"><b>KK Tabungan</b></th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $no_ren = 1; $t_pus = 0; $t_wus = 0; $t_kbp = 0; $t_kbw = 0; $t_tbg = 0;
                    @endphp
                    @forelse($perencanaan as $item)
                        @php
                            $t_pus += $item->J_Psubur ?? 0; $t_wus += $item->J_Wsubur ?? 0; $t_kbp += $item->Kb_p ?? 0;
                            $t_kbw += $item->Kb_w ?? 0; $t_tbg += $item->Kk_tbg ?? 0;
                        @endphp
                        <tr>
                            <td align="center">{{ $no_ren++ }}</td>
                            <td align="center">{{ $item->nama_kec }}</td>
                            <td align="center">{{ $item->J_Psubur }}</td>
                            <td align="center">{{ $item->J_Wsubur }}</td>
                            <td align="center">{{ $item->Kb_p }}</td>
                            <td align="center">{{ $item->Kb_w }}</td>
                            <td align="center">{{ $item->Kk_tbg }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" align="center"><i>Tidak ada data laporan untuk dicetak</i></td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr style="background-color: #f2f2f2;">
                        <td colspan="2" align="center"><b>TOTAL</b></td>
                        <td align="center"><b>{{ $t_pus }}</b></td>
                        <td align="center"><b>{{ $t_wus }}</b></td>
                        <td align="center"><b>{{ $t_kbp }}</b></td>
                        <td align="center"><b>{{ $t_kbw }}</b></td>
                        <td align="center"><b>{{ $t_tbg }}</b></td>
                    </tr>
                </tfoot>
            </table>
        @endif

        @if($bidang == 'semua' || $bidang == 'kader')
            <h3>Laporan Kader Pokja 4</h3>
            <table align="center">
                <thead>
                    <tr>
                        <th align="center"><b>NO</b></th>
                        <th align="center"><b>Kecamatan</b></th>
                        <th align="center"><b>Posyandu</b></th>
                        <th align="center"><b>Gizi</b></th>
                        <th align="center"><b>Kesling</b></th>
                        <th align="center"><b>Penyuluhan Narkoba</b></th>
                        <th align="center"><b>PHBS</b></th>
                        <th align="center"><b>KB</b></th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $no_kdr = 1; $t_posk = 0; $t_gizi = 0; $t_keslk = 0; $t_nark = 0; $t_phbs = 0; $t_kbk = 0;
                    @endphp
                    @forelse($laporanpokja4 as $item)
                        @php
                            $t_posk += $item->posyandu ?? 0; $t_gizi += $item->gizi ?? 0; $t_keslk += $item->kesling ?? 0;
                            $t_nark += $item->penyuluhan_narkoba ?? 0; $t_phbs += $item->PHBS ?? 0; $t_kbk += $item->KB ?? 0;
                        @endphp
                        <tr>
                            <td align="center">{{ $no_kdr++ }}</td>
                            <td align="center">{{ $item->nama_kec }}</td>
                            <td align="center">{{ $item->posyandu }}</td>
                            <td align="center">{{ $item->gizi }}</td>
                            <td align="center">{{ $item->kesling }}</td>
                            <td align="center">{{ $item->penyuluhan_narkoba }}</td>
                            <td align="center">{{ $item->PHBS }}</td>
                            <td align="center">{{ $item->KB }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" align="center"><i>Tidak ada data laporan untuk dicetak</i></td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr style="background-color: #f2f2f2;">
                        <td colspan="2" align="center"><b>TOTAL</b></td>
                        <td align="center"><b>{{ $t_posk }}</b></td>
                        <td align="center"><b>{{ $t_gizi }}</b></td>
                        <td align="center"><b>{{ $t_keslk }}</b></td>
                        <td align="center"><b>{{ $t_nark }}</b></td>
                        <td align="center"><b>{{ $t_phbs }}</b></td>
                        <td align="center"><b>{{ $t_kbk }}</b></td>
                    </tr>
                </tfoot>
            </table>
        @endif

        @if($bidang == 'semua' || $bidang == 'inovasi_prioritas')
            <h3>Laporan Inovasi (Kategori Prioritas)</h3>
            <table align="center" style="font-size: 8px;">
                <thead>
                    <tr>
                        <th align="center"><b>NO</b></th>
                        <th align="center"><b>Kecamatan</b></th>
                        <th>Kader Kes</th><th>Gizi</th><th>Kesling</th><th>PHBS</th><th>KB</th><th>Posyandu</th><th>Imunisasi</th>
                        <th>PKG</th><th>TBC</th><th>Jamban</th><th>SPAL</th><th>TPS</th><th>MCK</th><th>PDAM</th><th>Sumur</th>
                        <th>Lain</th><th>PUS</th><th>WUS</th><th>Aksep L</th><th>Aksep P</th><th>Tabungan</th><th>Asuransi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no_ip = 1; @endphp
                    @forelse($inovasiPrioritas as $item)
                        <tr>
                            <td align="center">{{ $no_ip++ }}</td>
                            <td align="center">{{ $item->nama_kec }}</td>
                            <td align="center">{{ $item->kader_kesehatan }}</td><td align="center">{{ $item->gizi }}</td><td align="center">{{ $item->kesling }}</td>
                            <td align="center">{{ $item->phbs }}</td><td align="center">{{ $item->kb }}</td><td align="center">{{ $item->posyandu }}</td>
                            <td align="center">{{ $item->imunisasi_vaksinasi_bayi_balita }}</td><td align="center">{{ $item->pkg }}</td><td align="center">{{ $item->tbc }}</td>
                            <td align="center">{{ $item->jamban_wc }}</td><td align="center">{{ $item->spal }}</td><td align="center">{{ $item->tps }}</td>
                            <td align="center">{{ $item->jumlah_mck }}</td><td align="center">{{ $item->pdam }}</td><td align="center">{{ $item->sumur }}</td>
                            <td align="center">{{ $item->lain_lain }}</td><td align="center">{{ $item->jml_pus }}</td><td align="center">{{ $item->jml_wus }}</td>
                            <td align="center">{{ $item->akseptor_kb_l }}</td><td align="center">{{ $item->akseptor_kb_p }}</td>
                            <td align="center">{{ $item->kk_memiliki_tabungan }}</td><td align="center">{{ $item->kk_memiliki_asuransi }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="24" align="center"><i>Tidak ada data laporan Inovasi Prioritas</i></td></tr>
                    @endforelse
                </tbody>
            </table>
        @endif

        @if($bidang == 'semua' || $bidang == 'inovasi_unggulan')
            <h3>Laporan Inovasi (Kategori Unggulan)</h3>
            <table align="center" style="font-size: 8px;">
                <thead>
                    <tr>
                        <th align="center"><b>NO</b></th>
                        <th align="center"><b>Kecamatan</b></th>
                        <th>Kader Kes</th><th>Gizi</th><th>Kesling</th><th>PHBS</th><th>KB</th><th>Posyandu</th><th>Imunisasi</th>
                        <th>PKG</th><th>TBC</th><th>Jamban</th><th>SPAL</th><th>TPS</th><th>MCK</th><th>PDAM</th><th>Sumur</th>
                        <th>Lain</th><th>PUS</th><th>WUS</th><th>Aksep L</th><th>Aksep P</th><th>Tabungan</th><th>Asuransi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no_iu = 1; @endphp
                    @forelse($inovasiUnggulan as $item)
                        <tr>
                            <td align="center">{{ $no_iu++ }}</td>
                            <td align="center">{{ $item->nama_kec }}</td>
                            <td align="center">{{ $item->kader_kesehatan }}</td><td align="center">{{ $item->gizi }}</td><td align="center">{{ $item->kesling }}</td>
                            <td align="center">{{ $item->phbs }}</td><td align="center">{{ $item->kb }}</td><td align="center">{{ $item->posyandu }}</td>
                            <td align="center">{{ $item->imunisasi_vaksinasi_bayi_balita }}</td><td align="center">{{ $item->pkg }}</td><td align="center">{{ $item->tbc }}</td>
                            <td align="center">{{ $item->jamban_wc }}</td><td align="center">{{ $item->spal }}</td><td align="center">{{ $item->tps }}</td>
                            <td align="center">{{ $item->jumlah_mck }}</td><td align="center">{{ $item->pdam }}</td><td align="center">{{ $item->sumur }}</td>
                            <td align="center">{{ $item->lain_lain }}</td><td align="center">{{ $item->jml_pus }}</td><td align="center">{{ $item->jml_wus }}</td>
                            <td align="center">{{ $item->akseptor_kb_l }}</td><td align="center">{{ $item->akseptor_kb_p }}</td>
                            <td align="center">{{ $item->kk_memiliki_tabungan }}</td><td align="center">{{ $item->kk_memiliki_asuransi }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="24" align="center"><i>Tidak ada data laporan Inovasi Unggulan</i></td></tr>
                    @endforelse
                </tbody>
            </table>
        @endif

        @php
            if (!isset($wakil) || count($wakil) == 0) {
                $wakil = \Illuminate\Support\Facades\DB::table('ttds')->where('pokja', 'Kelompok Kerja IV')
                            ->where(function($q) { $q->where('jabatan', 'like', '%Wakil%')->orWhere('jabatan', 'like', '%Sekretaris%'); })->get();
            }
            if (!isset($ketua) || count($ketua) == 0) {
                $ketua = \Illuminate\Support\Facades\DB::table('ttds')->where('pokja', 'Kelompok Kerja IV')->where('jabatan', 'Ketua')->get();
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
                        <a>{{ $ketuaa->pokja ?? 'Kelompok Kerja IV' }}</a><br>
                        <a>{{ $ketuaa->jabatan }}</a><br><br><br><br>
                        <a style="text-decoration: underline; font-weight: bold;">{{ $ketuaa->nama_terang }}</a>
                    @empty
                        <a>Nganjuk, {{ date('d F Y') }}</a><br>
                        <a>Kelompok Kerja IV</a><br>
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