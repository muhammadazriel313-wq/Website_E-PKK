{{-- @extends('backend/layouts.template')

@section('content1') --}}

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Laporan Pengembangan Kehidupan Berkoperasi (Riwayat)</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="{{ asset('backend/assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('backend/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="{{ asset('backend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <link href="{{ asset('backend/assets/css/style.css') }}" rel="stylesheet">

  {{-- fontawesome --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('fontawesome/css/all.min.css') }}">

  <style>
    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      border-radius: 10px;
      box-shadow: 0 4px 14px rgba(0,0,0,0.06);
      background: #ffffff;
    }

    .table-responsive table {
      min-width: 1700px;
      white-space: nowrap;
      margin-bottom: 0;
      border-collapse: collapse;
    }

    .table-responsive thead th {
      position: sticky;
      top: 0;
      background: #f8fafc; 
      color: #334155;
      z-index: 2;
      font-size: 11px;
      font-weight: 600;
      padding: 12px 8px;
      vertical-align: middle;
      border: 1px solid #e2e8f0;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .table-responsive tbody td {
      font-size: 12px;
      padding: 10px 8px;
      vertical-align: middle;
      background-color: #ffffff;
      color: #475569;
    }

    .table-responsive tbody tr:hover td {
      background-color: #f1f5f9;
    }

    .table-bordered th,
    .table-bordered td {
      border: 1px solid #e2e8f0;
    }

    .table-responsive::-webkit-scrollbar {
      height: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
      background: #f1f5f9;
      border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }

    .header-group-title {
      font-size: 12px;
      font-weight: 700;
      color: #1e293b;
    }

    .header-sub-title {
      font-size: 10px;
      font-weight: 600;
      color: #64748b;
    }
  
    /* ===== SIDEBAR & NAVBAR FIX ===== */
    body { background: #f6f9ff !important; }
    .header { background: #fff !important; box-shadow: 0 2px 4px rgba(0,0,0,0.08) !important; height: 70px !important; padding: 0 20px !important; z-index: 998 !important; }
    .header .logo { min-width: auto; padding: 0; margin-left: 15px; }
    .header .logo img { max-height: 50px; width: 50px; border-radius: 50%; margin-right: 15px; flex-shrink: 0; }
    .header .logo span { font-size: 15px; font-weight: 700; line-height: 1.3; color: #1a1a1a; white-space: nowrap; display: inline-block; }
    .toggle-sidebar-btn { color: #1a1a1a !important; font-size: 24px !important; cursor: pointer !important; padding: 10px 15px !important; }
    .sidebar { width: 300px !important; top: 70px !important; background: #fff !important; border-right: 1px solid #e5e7eb !important; z-index: 997 !important; }
    .toggle-sidebar .sidebar { width: 80px !important; }
    .toggle-sidebar .sidebar .nav-link span { display: none !important; }
    .toggle-sidebar .sidebar .nav-link { justify-content: center !important; padding: 12px 0 !important; }
    #main { margin-left: 300px !important; margin-top: 70px !important; padding: 25px 35px !important; background: #f6f9ff !important; min-height: calc(100vh - 70px) !important; }
    .toggle-sidebar #main { margin-left: 80px !important; }
    .sidebar-nav .nav-link:not(.collapsed) { background: #e8ecff; color: #4154f1; border-radius: 6px; }
    .sidebar-nav .nav-link:not(.collapsed) i { color: #4154f1; }
    .sidebar-nav .nav-item { margin-bottom: 4px; }
    .sidebar-nav .nav-link { display: flex; align-items: center; padding: 12px 20px; font-size: 15px; font-weight: 400; font-family: "Poppins", sans-serif !important; color: #4b5563; transition: all 0.3s; }
    .sidebar-nav .nav-link i { font-size: 18px; margin-right: 12px; color: #6b7280; }
    .sidebar-nav .nav-link:hover { background: #f3f4f6; color: #4154f1; }
    i, .bi, [class^="bi-"], [class*=" bi-"], [class^="fa"], [class*=" fa-"] { font-family: unset !important; }
  </style>

</head>

<body>

  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center w-100">
      <i class="bi bi-list toggle-sidebar-btn"></i>
      <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center" style="text-decoration:none;">
        <img src="{{ asset('backend/assets/img/pkk.png') }}" alt="PKK">
        <span class="d-none d-lg-block">
          Pemberdayaan Kesejahteraan Keluarga<br>Kabupaten Nganjuk
        </span>
      </a>
    </div>
    <nav class="header-nav ms-auto"></nav>
  </header>

  @include('backend.includes.sidebar')

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Daftar Laporan Pengembangan Kehidupan Berkoperasi (Riwayat)</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Laporan Pengembangan Kehidupan Berkoperasi</li>
        </ol>
      </nav>
    </div>@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i>
      {{ $message }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card mt-2">
      <div class="card-body">
        <div class="alert alert-info d-flex align-items-center mt-3" role="alert">
          <i class="bi bi-info-circle-fill me-2"></i>
          <div>Scroll horizontal untuk melihat semua kolom</div>
        </div>
        
        <div class="table-responsive mt-3">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th scope="col" rowspan="4" class="text-center align-middle">No</th>
                @if (Auth::guard('web')->check())
                  <th scope="col" rowspan="4" class="text-center align-middle">Kecamatan</th>
                  <th scope="col" rowspan="4" class="text-center align-middle">Desa</th>
                @elseif (Auth::guard('pengguna')->check())
                  <th scope="col" rowspan="4" class="text-center align-middle">Desa</th>
                @endif
                <th scope="col" colspan="10" class="text-center header-group-title">PENGEMBANGAN KEHIDUPAN BERKOPERASI</th>
                <th scope="col" rowspan="4" class="text-center align-middle">Keterangan</th>
                <th scope="col" rowspan="4" class="text-center align-middle">Status</th>
                <th scope="col" rowspan="4" class="text-center align-middle">Tanggal</th>
                <th scope="col" rowspan="4" class="text-center align-middle">Aksi</th>
              </tr>

              <tr>
                <th scope="col" colspan="8" class="text-center header-group-title">PRAKOPERASI / USAHA BERSAMA / UP2K</th>
                <th scope="col" colspan="2" class="text-center header-group-title">KOPERASI BERBADAN HUKUM</th>
              </tr>

              <tr>
                <th scope="col" colspan="2" class="text-center header-sub-title">Pemula</th>
                <th scope="col" colspan="2" class="text-center header-sub-title">Madya</th>
                <th scope="col" colspan="2" class="text-center header-sub-title">Utama</th>
                <th scope="col" colspan="2" class="text-center header-sub-title">Mandiri</th>
                <th scope="col" rowspan="2" class="text-center align-middle header-sub-title">Jml</th>
                <th scope="col" rowspan="2" class="text-center align-middle header-sub-title">Anggt</th>
              </tr>

              <tr>
                @for ($i = 0; $i < 4; $i++)
                  <th scope="col" class="text-center header-sub-title">Jml Kel</th>
                  <th scope="col" class="text-center header-sub-title">Psrt</th>
                @endfor
              </tr>
            </thead>
            <tbody>
              @php $no = 1; @endphp
              @forelse ($data2 as $peng1)
                <tr>
                  <th scope="row" class="text-center">{{ $no++ }}</th>
                  
                  @if (Auth::guard('web')->check())
                    <td class="text-center">{{ $peng1->nama_kec }}</td>
                    <td class="text-center">{{ $peng1->nama_desa }}</td>
                  @elseif (Auth::guard('pengguna')->check())
                    <td class="text-center">{{ $peng1->nama_desa }}</td>
                  @endif

                  <td class="text-center">{{ $peng1->jumlah_kelompok_pemula ?? '0' }}</td>
                  <td class="text-center">{{ $peng1->jumlah_peserta_pemula ?? '0' }}</td>
                  <td class="text-center">{{ $peng1->jumlah_kelompok_madya ?? '0' }}</td>
                  <td class="text-center">{{ $peng1->jumlah_peserta_madya ?? '0' }}</td>
                  <td class="text-center">{{ $peng1->jumlah_kelompok_utama ?? '0' }}</td>
                  <td class="text-center">{{ $peng1->jumlah_peserta_utama ?? '0' }}</td>
                  <td class="text-center">{{ $peng1->jumlah_kelompok_mandiri ?? '0' }}</td>
                  <td class="text-center">{{ $peng1->jumlah_peserta_mandiri ?? '0' }}</td>
                  <td class="text-center">{{ $peng1->jumlah_kelompok_hukum ?? '0' }}</td>
                  <td class="text-center">{{ $peng1->jumlah_peserta_hukum ?? '0' }}</td>
                  <td class="text-center">{{ $peng1->catatan ?: '-' }}</td>

                  <td class="text-center">
                    @if(in_array(strtolower($peng1->status), ['proses', 'revisi']))
                      <span class="badge bg-warning text-dark">{{ $peng1->status }}</span>
                    @elseif(in_array(strtolower($peng1->status), ['disetujui1', 'disetujui2']))
                      <span class="badge bg-success">{{ $peng1->status }}</span>
                    @else
                      <span class="badge bg-secondary">{{ $peng1->status }}</span>
                    @endif
                  </td>
                  
                  <td class="text-center">{{ \Carbon\Carbon::parse($peng1->created_at)->format('d/m/Y H:i') }}</td>
                  
                  <td class="text-center">
                    <form action="{{ route('decpengembangan.destroy', $peng1->id_pokja2_bidang2)}}" method="POST" class="d-inline delete-form">
                      @csrf
                      @method('DELETE')
                      <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this)" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="17" class="text-center py-5">
                    <div class="alert alert-danger mb-0">
                      <i class="bi bi-exclamation-triangle-fill me-2"></i> 
                      Tidak ada data laporan pengembangan kehidupan berkoperasi
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </main><a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="{{ asset('backend/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/quill/quill.min.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="{{ asset('backend/assets/js/main.js') }}"></script>

  <script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    function confirmDelete(button) {
      Swal.fire({
        title: 'Yakin hapus data?',
        text: "Data yang dihapus tidak bisa dikembalikan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          button.closest('form').submit();
        }
      });
    }
  </script>

</body>
</html>
{{-- @endsection --}}