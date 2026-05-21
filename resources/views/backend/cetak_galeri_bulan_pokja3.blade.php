<!DOCTYPE html>
<html>
<head>
    <title>Cetak Galeri</title>
    <style>
        table {
        width: 100%;
        border-collapse: collapse;
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

        .address {
            margin-bottom: 20px;
        }

        .address p {
            margin: 0;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-group label {
            display: inline-block;
            width: 120px;
            font-weight: bold;
        }

        .form-group .value {
            display: inline-block;
            width: calc(100% - 150px);
            vertical-align: top;
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
            grid-template-rows: 50% 50%;
        }

    </style>
     <!-- Vendor CSS Files -->
 <link href="{{ asset('backend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
 <link href="{{ asset('backend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
 <link href="{{ asset('backend/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
 <link href="{{ asset('backend/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
 <link href="{{ asset('backend/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
 <link href="{{ asset('backend/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
 <link href="{{ asset('backend/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
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
        <h2 style='font-size: 36px;' align="center">REKAPITULASI</h2>
        <h4 style='font-size: 28px;' align="center">JADWAL KEGIATAN TIM PENGGERAK PKK</br>
        KABUPATEN NGANJUK</br>
        TAHUN {{ $tanggal2 ?? date('Y') }}<br></h4>
    </div>

    <div class="separator"></div>
    <div class ="signature">
        <p>Tanggal Cetak : <?php
					echo '&nbsp;&nbsp;&nbsp;';
					echo date('d F Y');
					?></p></br>
    </div>

    <table align="center">
				<tr>
                    <td scope="row" colspan="3" style='font-size: 24px; background-color: #A9A9A9; border: 1px #000; padding: 10px 15px 10px 15px;' align="center"><b>Bulan {{$tanggal}} </b></td>
				</tr>
                <tr>
                  @php
                    $no = 1;
                  @endphp
                  <th scope="row" colspan="3" style='font-size: 18px; border: 1px #000;' align="justify">Bidang : Program Pangan</th>
                </tr>
                  @foreach($pangan as $tampil)
                <tr>
                    <th style='font-size: 15px; border: 1px #000; padding: 10px 15px 10px 15px;' align="justify">{{ $no++ }}.</th>
                    <td style='font-size: 15px; border: 1px #000; padding: 10px 45px 10px 45px;' align="justify">{{ \Carbon\Carbon::parse($tampil->tanggal)->isoFormat('D MMMM Y') }}</td>
                    <td style='font-size: 15px; border: 1px #000; padding: 10px 45px 10px 45px;' align="justify">{{ $tampil->deskripsi}}</td>
                </tr>
                @endforeach
                @if($pangan->isEmpty())
                <td scope="row" colspan="3" style='border: 1px #000;' align="justify">Tidak ada data pada bidang ini.</td>
                @endif

                <tr>
                  @php
                    $no = 1;
                  @endphp
                  <th scope="row" colspan="3" style='font-size: 18px; border: 1px #000;' align="justify">Bidang : Program Sandang</th>
                </tr>
                  @foreach($sandang as $tampil1)
                <tr>
                    <th style='font-size: 15px; border: 1px #000; padding: 10px 15px 10px 15px;' align="justify">{{ $no++ }}.</th>
                    <td style='font-size: 15px; border: 1px #000; padding: 10px 45px 10px 45px;' align="justify">{{ \Carbon\Carbon::parse($tampil1->tanggal)->isoFormat('D MMMM Y') }}</td>
                    <td style='font-size: 15px; border: 1px #000; padding: 10px 45px 10px 45px;' align="justify">{{ $tampil1->deskripsi}}</td>
                </tr>
                @endforeach
                @if($sandang->isEmpty())
                <td scope="row" colspan="3" style='border: 1px #000;' align="justify">Tidak ada data pada bidang ini.</td>
                @endif

                <tr>
                    @php
                      $no = 1;
                    @endphp
                    <th scope="row" colspan="3" style='font-size: 18px; border: 1px #000;' align="justify">Bidang : Program Perumahan Dan Tata Laksana Rumah Tangga</th>
                  </tr>
                    @foreach($perumahan as $tampil1)
                  <tr>
                      <th style='font-size: 15px; border: 1px #000; padding: 10px 15px 10px 15px;' align="justify">{{ $no++ }}.</th>
                      <td style='font-size: 15px; border: 1px #000; padding: 10px 45px 10px 45px;' align="justify">{{ \Carbon\Carbon::parse($tampil1->tanggal)->isoFormat('D MMMM Y') }}</td>
                      <td style='font-size: 15px; border: 1px #000; padding: 10px 45px 10px 45px;' align="justify">{{ $tampil1->deskripsi}}</td>
                  </tr>
                  @endforeach
                  @if($perumahan->isEmpty())
                  <td scope="row" colspan="3" style='border: 1px #000;' align="justify">Tidak ada data pada bidang ini.</td>
                  @endif

                  <tr>
                    @php
                      $no = 1;
                    @endphp
                    <th scope="row" colspan="3" style='font-size: 18px; border: 1px #000;' align="justify">Bidang : Kader Pokja 3</th>
                  </tr>
                    @foreach($laporanpokja3 as $tampil1)
                  <tr>
                      <th style='font-size: 15px; border: 1px #000; padding: 10px 15px 10px 15px;' align="justify">{{ $no++ }}.</th>
                      <td style='font-size: 15px; border: 1px #000; padding: 10px 45px 10px 45px;' align="justify">{{ \Carbon\Carbon::parse($tampil1->tanggal)->isoFormat('D MMMM Y') }}</td>
                      <td style='font-size: 15px; border: 1px #000; padding: 10px 45px 10px 45px;' align="justify">{{ $tampil1->deskripsi}}</td>
                  </tr>
                  @endforeach
                  @if($laporanpokja3->isEmpty())
                  <td scope="row" colspan="3" style='border: 1px #000;' align="justify">Tidak ada data pada bidang ini.</td>
                  @endif

    </table>

        {{-- <h4>Bidang : Penghayatan & Pengamalan Pancasila</h2>
        
        @forelse($penghayatan as $gas1)
        <h5>Tanggal : {{ \Carbon\Carbon::parse($gas1->tanggal)->isoFormat('D MMMM Y') }}</h3>
        @empty
        @endforelse
        @foreach($penghayatan as $gas)
        <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
            <div class="col-lg-3 col-md-3 portfolio-item filter-card">
            <img src="{{ asset('frontend2/gallery2/'.$gas->gambar) }}" class="rounded img" style="width: 150px" style="height: 100px" class="img-fluid" alt="">
            </div>
        </div>
    @endforeach --}}
    
      <div class="container-grid">
        <div style="text-align: left;">
            <div style="text-align: center;">
                <p></p>
            </div>
        </div>

        <div style="text-align: right;">
            <div style="text-align: center;">
                @forelse($ketua as $ketuaa)
                <a>Nganjuk, <?php
                          echo date('d F Y');
                          ?></a><br>
                <a>TP PKK Kabupaten Nganjuk</a><br>
                <a>{{ $ketuaa->pokja }}</a></br>
                <a>{{ $ketuaa->jabatan }}</a></br><br><br><br>
                <a>{{ $ketuaa->nama_terang }}</a>
                @empty
                tidak ada data
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
