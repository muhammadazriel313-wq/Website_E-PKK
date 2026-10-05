{{-- @extends('backend/layouts.template')

@section('content') --}}

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Laporan Perencanaan Sehat</title>

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
  <link rel="stylesheet" type="text/css" href="{{ asset('fontawesome/css/all.min.css') }}">

  <style>
    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      border-radius: 10px;
      box-shadow: 0 4px 18px rgba(0,0,0,0.06);
    }
    .table-responsive table {
      min-width: 1200px;
      white-space: nowrap;
      margin-bottom: 0;
    }
    .table-responsive thead th {
      position: sticky;
      top: 0;
      background: #f8fafc; 
      color: #334155; 
      z-index: 2;
      font-size: 12px;
      font-weight: 600;
      padding: 15px 10px;
      vertical-align: middle;
      border: 1px solid #e2e8f0;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .table-responsive tbody td {
      font-size: 13px;
      padding: 12px 10px;
      vertical-align: middle;
      background-color: white;
      color: #475569;
    }
    .table-responsive tbody tr:hover td {
      background-color: #f1f5f9;
    }
    .table-bordered th, .table-bordered td {
      border: 1px solid #e2e8f0;
    }
    .table-responsive::-webkit-scrollbar { height: 8px; }
    .table-responsive::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
    .table-responsive::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .table-responsive::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
  </style>

  <style>
    * { font-family: "Poppins", sans-serif !important; }
    body { background: #f6f9ff !important; }
    .header { background: #fff !important; box-shadow: 0 2px 4px rgba(0,0,0,0.08) !important; height: 70px !important; padding: 0 20px !important; z-index: 998 !important; }
    .header .logo { min-width: auto; padding: 0; margin-left: 15px; }
    .header .logo img { max-height: 50px; width: 50px; border-radius: 50%; margin-right: 15px; flex-shrink: 0; }
    .header .logo span { font-size: 15px; font-weight: 700; font-family: "Poppins", sans-serif !important; line-height: 1.3; color: #1a1a1a; white-space: nowrap; display: inline-block; }
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
      <h1>Daftar Laporan Perencanaan Sehat</h1>
    </div>

    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i> {{ $message }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card mt-2">
      <div class="card-body">
        
        <div class="table-responsive mt-3">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th scope="col" rowspan="3" class="text-center align-middle">No</th>
                @if (Auth::guard('web')->check())
                  <th class="text-center align-middle" rowspan="3" scope="col">Kecamatan</th>
                  <th class="text-center align-middle" rowspan="3" scope="col">Desa</th>
                @elseif (Auth::guard('pengguna')->check())
                  <th class="text-center align-middle" rowspan="3" scope="col">Desa</th>
                @endif
                <th scope="col" colspan="5" class="text-center align-middle">Perencanaan Sehat</th>
                <th scope="col" rowspan="3" class="text-center align-middle">Keterangan</th>
                <th scope="col" rowspan="3" class="text-center align-middle">Status</th>
                <th scope="col" rowspan="3" class="text-center align-middle">Tanggal</th>
                <th scope="col" rowspan="3" class="text-center align-middle">Aksi</th>
              </tr>
              <tr>
                <th scope="col" rowspan="2" class="text-center align-middle">Jumlah PUS</th>
                <th scope="col" rowspan="2" class="text-center align-middle">Jumlah WUS</th>
                <th scope="col" colspan="2" class="text-center align-middle">Jumlah Aseptor KB</th>
                <th scope="col" rowspan="2" class="text-center align-middle">Jumlah KK yang Memiliki Tabungan</th>
              </tr>
              <tr>
                <th scope="col" class="text-center align-middle">L</th>
                <th scope="col" class="text-center align-middle">P</th>
              </tr>
            </thead>
            <tbody>
              @php $no = 1; @endphp
              @forelse ($data as $p_sehat)
              <tr>
                <th scope="row" class="text-center">{{ $no++ }}</th>
                @if (Auth::guard('web')->check())
                  <td class="text-center">{{ $p_sehat->nama_kec ?? '-' }}</td>
                  <td class="text-center">{{ $p_sehat->nama_desa ?? '-' }}</td>
                @elseif (Auth::guard('pengguna')->check())
                  <td class="text-center">{{ $p_sehat->nama_desa ?? '-' }}</td>
                @endif
                <td class="text-center">{{ $p_sehat->J_Psubur ?? '0' }}</td>
                <td class="text-center">{{ $p_sehat->J_Wsubur ?? '0' }}</td>
                <td class="text-center">{{ $p_sehat->Kb_p ?? '0' }}</td>
                <td class="text-center">{{ $p_sehat->Kb_w ?? '0' }}</td>
                <td class="text-center">{{ $p_sehat->Kk_tbg ?? '0' }}</td>
                <td class="text-center">{{ $p_sehat->catatan ?: '-' }}</td>
                
                <td class="text-center">
                  @if(in_array(strtolower($p_sehat->status), ['proses', 'revisi']))
                    <span class="badge bg-warning text-dark">{{ $p_sehat->status }}</span>
                  @elseif(in_array(strtolower($p_sehat->status), ['disetujui1', 'disetujui2']))
                    <span class="badge bg-success">{{ $p_sehat->status }}</span>
                  @else
                    <span class="badge bg-secondary">{{ $p_sehat->status }}</span>
                  @endif
                </td>
                
                <td class="text-center">{{ \Carbon\Carbon::parse($p_sehat->created_at)->format('d/m/Y H:i') }}</td>
                <td class="text-center" style="white-space: nowrap;">
                  <a href="{{ route('perencanaan_sehat.edit', $p_sehat->id_pokja4_bidang3) }}" class="btn btn-sm btn-info text-white me-1" data-bs-toggle="tooltip" title="Review Data">
                    <i class="bi bi-search"></i>
                  </a>
                  
                  <form action="{{ route('perencanaan_sehat.destroy', $p_sehat->id_pokja4_bidang3)}}" method="POST" class="d-inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this)" data-bs-toggle="tooltip" title="Hapus Data">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="12" class="text-center py-5">
                  <div class="alert alert-danger mb-0">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Tidak ada data laporan perencanaan sehat.
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </main>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="{{ asset('backend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('backend/assets/js/main.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
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
        confirmButtonText: 'Ya, Hapus!'
      }).then((result) => {
        if (result.isConfirmed) button.closest('form').submit();
      });
    }
  </script>
</body>
</html>
{{-- @endsection --}}