<!DOCTYPE html>
<html>
<head>
    <title>Cetak Galeri Pokja II</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px; /* Tambahan jarak antar tabel bulan */
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
            margin-top: 40px;
            text-align: right;
        }

        .signature p {
            margin-bottom: 5px;
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
        <h2 style='font-size: 32px;' align="center">REKAPITULASI GALERI</h2>
        <h4 style='font-size: 24px; font-weight: normal; line-height: 1.4;' align="center">
            LAGU & DOKUMEN KEGIATAN KELOMPOK KERJA I (POKJA 1)<br>
            @if(Auth::guard('pengguna')->check())
                KECAMATAN {{ strtoupper(Auth::guard('pengguna')->user()->name ?? '') }}<br>
            @endif
            TAHUN {{ $tanggal2 }}<br>
        </h4>
    </div>

    <div class="separator"></div>
    <div class ="signature">
        <p>Tanggal Cetak : 
            <?php
                echo '&nbsp;&nbsp;&nbsp;';
                echo date('d F Y');
            ?>
        </p>
    </div>

    <table align="center">
        <thead>
            <tr>
                <td colspan="3" style='font-size: 28px; background-color: #A9A9A9; border: 1px #000; padding: 10px 25px;' align="center"><b>Bulan Januari</b></td>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($jan as $item)
            <tr>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 15px;' align="center">{{ $no++ }}.</td> 
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ \Carbon\Carbon::parse($item->tanggal ?? $item->created_at)->locale('id')->translatedFormat('d F Y') }}</td>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ $item->deskripsi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style='font-size: 18px; border: 1px #000; padding: 10px;' align="center"><i>Tidak ada data pada bulan ini.</i></td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table align="center">
        <thead>
            <tr>
                <td colspan="3" style='font-size: 28px; background-color: #A9A9A9; border: 1px #000; padding: 10px 25px;' align="center"><b>Bulan Februari</b></td>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($feb as $item)
            <tr>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 15px;' align="center">{{ $no++ }}.</td> 
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ \Carbon\Carbon::parse($item->tanggal ?? $item->created_at)->locale('id')->translatedFormat('d F Y') }}</td>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ $item->deskripsi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style='font-size: 18px; border: 1px #000; padding: 10px;' align="center"><i>Tidak ada data pada bulan ini.</i></td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table align="center">
        <thead>
            <tr>
                <td colspan="3" style='font-size: 28px; background-color: #A9A9A9; border: 1px #000; padding: 10px 25px;' align="center"><b>Bulan Maret</b></td>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($mar as $item)
            <tr>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 15px;' align="center">{{ $no++ }}.</td> 
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ \Carbon\Carbon::parse($item->tanggal ?? $item->created_at)->locale('id')->translatedFormat('d F Y') }}</td>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ $item->deskripsi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style='font-size: 18px; border: 1px #000; padding: 10px;' align="center"><i>Tidak ada data pada bulan ini.</i></td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table align="center">
        <thead>
            <tr>
                <td colspan="3" style='font-size: 28px; background-color: #A9A9A9; border: 1px #000; padding: 10px 25px;' align="center"><b>Bulan April</b></td>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($apr as $item)
            <tr>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 15px;' align="center">{{ $no++ }}.</td> 
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ \Carbon\Carbon::parse($item->tanggal ?? $item->created_at)->locale('id')->translatedFormat('d F Y') }}</td>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ $item->deskripsi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style='font-size: 18px; border: 1px #000; padding: 10px;' align="center"><i>Tidak ada data pada bulan ini.</i></td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table align="center">
        <thead>
            <tr>
                <td colspan="3" style='font-size: 28px; background-color: #A9A9A9; border: 1px #000; padding: 10px 25px;' align="center"><b>Bulan Mei</b></td>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($mei as $item)
            <tr>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 15px;' align="center">{{ $no++ }}.</td> 
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ \Carbon\Carbon::parse($item->tanggal ?? $item->created_at)->locale('id')->translatedFormat('d F Y') }}</td>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ $item->deskripsi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style='font-size: 18px; border: 1px #000; padding: 10px;' align="center"><i>Tidak ada data pada bulan ini.</i></td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table align="center">
        <thead>
            <tr>
                <td colspan="3" style='font-size: 28px; background-color: #A9A9A9; border: 1px #000; padding: 10px 25px;' align="center"><b>Bulan Juni</b></td>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($jun as $item)
            <tr>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 15px;' align="center">{{ $no++ }}.</td> 
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ \Carbon\Carbon::parse($item->tanggal ?? $item->created_at)->locale('id')->translatedFormat('d F Y') }}</td>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ $item->deskripsi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style='font-size: 18px; border: 1px #000; padding: 10px;' align="center"><i>Tidak ada data pada bulan ini.</i></td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table align="center">
        <thead>
            <tr>
                <td colspan="3" style='font-size: 28px; background-color: #A9A9A9; border: 1px #000; padding: 10px 25px;' align="center"><b>Bulan Juli</b></td>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($jul as $item)
            <tr>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 15px;' align="center">{{ $no++ }}.</td> 
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ \Carbon\Carbon::parse($item->tanggal ?? $item->created_at)->locale('id')->translatedFormat('d F Y') }}</td>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ $item->deskripsi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style='font-size: 18px; border: 1px #000; padding: 10px;' align="center"><i>Tidak ada data pada bulan ini.</i></td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table align="center">
        <thead>
            <tr>
                <td colspan="3" style='font-size: 28px; background-color: #A9A9A9; border: 1px #000; padding: 10px 25px;' align="center"><b>Bulan Agustus</b></td>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($agu as $item)
            <tr>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 15px;' align="center">{{ $no++ }}.</td> 
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ \Carbon\Carbon::parse($item->tanggal ?? $item->created_at)->locale('id')->translatedFormat('d F Y') }}</td>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ $item->deskripsi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style='font-size: 18px; border: 1px #000; padding: 10px;' align="center"><i>Tidak ada data pada bulan ini.</i></td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table align="center">
        <thead>
            <tr>
                <td colspan="3" style='font-size: 28px; background-color: #A9A9A9; border: 1px #000; padding: 10px 25px;' align="center"><b>Bulan September</b></td>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($sep as $item)
            <tr>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 15px;' align="center">{{ $no++ }}.</td> 
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ \Carbon\Carbon::parse($item->tanggal ?? $item->created_at)->locale('id')->translatedFormat('d F Y') }}</td>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ $item->deskripsi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style='font-size: 18px; border: 1px #000; padding: 10px;' align="center"><i>Tidak ada data pada bulan ini.</i></td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table align="center">
        <thead>
            <tr>
                <td colspan="3" style='font-size: 28px; background-color: #A9A9A9; border: 1px #000; padding: 10px 25px;' align="center"><b>Bulan Oktober</b></td>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($okt as $item)
            <tr>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 15px;' align="center">{{ $no++ }}.</td> 
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ \Carbon\Carbon::parse($item->tanggal ?? $item->created_at)->locale('id')->translatedFormat('d F Y') }}</td>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ $item->deskripsi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style='font-size: 18px; border: 1px #000; padding: 10px;' align="center"><i>Tidak ada data pada bulan ini.</i></td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table align="center">
        <thead>
            <tr>
                <td colspan="3" style='font-size: 28px; background-color: #A9A9A9; border: 1px #000; padding: 10px 25px;' align="center"><b>Bulan November</b></td>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($nov as $item)
            <tr>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 15px;' align="center">{{ $no++ }}.</td> 
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ \Carbon\Carbon::parse($item->tanggal ?? $item->created_at)->locale('id')->translatedFormat('d F Y') }}</td>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ $item->deskripsi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style='font-size: 18px; border: 1px #000; padding: 10px;' align="center"><i>Tidak ada data pada bulan ini.</i></td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table align="center">
        <thead>
            <tr>
                <td colspan="3" style='font-size: 28px; background-color: #A9A9A9; border: 1px #000; padding: 10px 25px;' align="center"><b>Bulan Desember</b></td>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($des as $item)
            <tr>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 15px;' align="center">{{ $no++ }}.</td> 
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ \Carbon\Carbon::parse($item->tanggal ?? $item->created_at)->locale('id')->translatedFormat('d F Y') }}</td>
                <td style='font-size: 18px; border: 1px #000; padding: 10px 45px;'>{{ $item->deskripsi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style='font-size: 18px; border: 1px #000; padding: 10px;' align="center"><i>Tidak ada data pada bulan ini.</i></td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="container-grid">
        <div style="text-align: left;">
            <div style="text-align: center;">
                <p></p>
            </div>
        </div>

        <div style="text-align: right;">
            <div style="text-align: center;">
                @forelse($ketua as $ketuaa)
                <a>Nganjuk, <?php echo date('d F Y'); ?></a><br>
                <a>TP PKK Kabupaten Nganjuk</a><br>
                <a>{{ $ketuaa->pokja }}</a><br>
                <a>{{ $ketuaa->jabatan }}</a><br><br><br><br>
                <a>{{ $ketuaa->nama_terang }}</a>
                @empty
                <a>Tidak ada data pimpinan</a>
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