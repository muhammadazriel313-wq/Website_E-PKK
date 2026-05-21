<!DOCTYPE html>
<html>
<head>
    <title>Cetak Galeri Pokja II</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 8px;
            border: 1px solid black;
        }
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 800px;
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
            font-size: 16px;
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
        }

        .container-grid {
            width: 100%;
            border: none;
            padding: 5px;
            margin-top: 50px;
            box-sizing: border-box;
            display: grid;
            grid-template-columns: 50% 50%;
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
        <h2 style='font-size: 28px;' align="center">REKAPITULASI GALERI</h2>
        <h4 style='font-size: 20px; font-weight: normal; line-height: 1.4;' align="center">
            LAGU & DOKUMEN KEGIATAN KELOMPOK KERJA II (POKJA 2)<br>
            @if(Auth::guard('pengguna')->check())
                KECAMATAN {{ strtoupper(Auth::guard('pengguna')->user()->name ?? '') }}<br>
            @endif
            TAHUN {{ $tanggal2 }}
        </h4>
    </div>

    <div class="separator"></div>
    <div class="signature">
        <p>Tanggal Cetak : {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
    </div>

    @php
        $daftarBulan = [
            'Januari' => $jan, 'Februari' => $feb, 'Maret' => $mar, 'April' => $apr,
            'Mei' => $mei, 'Juni' => $jun, 'Juli' => $jul, 'Agustus' => $agu,
            'September' => $sep, 'Oktober' => $okt, 'November' => $nov, 'Desember' => $des
        ];
    @endphp

    {{-- LOOPING PER BULAN --}}
    @foreach($daftarBulan as $namaBulan => $dataBulan)
        <table align="center">
            <thead>
                <tr>
                    <td colspan="4" style='font-size: 20px; background-color: #A9A9A9; color: #000;' align="center">
                        <b>Bulan {{ $namaBulan }}</b>
                    </td>
                </tr>
                @if($dataBulan->isNotEmpty())
                <tr style="background-color: #f2f2f2;">
                    <th style="width: 50px;">No</th>
                    <th style="width: 150px;">Tanggal</th>
                    <th>Bidang</th>
                    <th>Deskripsi</th>
                </tr>
                @endif
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @forelse($dataBulan as $tampil)
                <tr>
                    <td align="center">{{ $no++ }}.</td>
                    <td align="center">{{ \Carbon\Carbon::parse($tampil->created_at)->isoFormat('D MMMM Y') }}</td>
                    <td align="center">{{ $tampil->bidang }}</td>
                    <td>{{ $tampil->deskripsi }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" align="center" style="padding: 15px;"><i>Tidak ada data galeri pada bulan ini.</i></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach

    {{-- TANDA TANGAN --}}
    <div class="container-grid">
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
</body>
</html>