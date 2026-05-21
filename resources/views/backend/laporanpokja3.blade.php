{{-- @extends('backend/layouts.template')

@section('content') --}}

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Laporan Kader Pokja 3</title>

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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      border-radius: 10px;
      box-shadow: 0 4px 18px rgba(0,0,0,0.06);
    }
    .table-responsive table {
      min-width: 1000px;
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
    
    .header-group-title { font-size: 12px; font-weight: 700; color: #1e293b; }
    .header-sub-title { font-size: 11px; font-weight: 600; color: #64748b; }
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

    /* SweetAlert2 Modern */
    .swal2-popup { font-family: 'Poppins', sans-serif !important; border-radius: 24px !important; padding: 40px 32px 32px !important; box-shadow: 0 24px 64px rgba(0,0,0,0.12) !important; max-width: 400px !important; }
    .swal2-title { font-family: 'Poppins', sans-serif !important; font-size: 20px !important; font-weight: 700 !important; color: #1a1a2e !important; }
    .swal2-html-container { font-family: 'Poppins', sans-serif !important; font-size: 14px !important; color: #6b7280 !important; }
    .swal2-icon.swal2-warning { border: none !important; background: #ffe4e6 !important; border-radius: 50% !important; width: 72px !important; height: 72px !important; }
    .swal2-icon.swal2-warning .swal2-icon-content { font-size: 36px !important; color: #ef4444 !important; font-weight: 700 !important; }
    .swal2-actions { gap: 12px !important; margin-top: 28px !important; width: 100% !important; padding: 0 !important; }
    .swal2-confirm { font-family: 'Poppins', sans-serif !important; font-size: 15px !important; font-weight: 600 !important; border-radius: 14px !important; padding: 12px 0 !important; flex: 1 !important; background-color: #ef4444 !important; border: none !important; color: #fff !important; }
    .swal2-confirm:hover { background-color: #dc2626 !important; }
    .swal2-cancel { font-family: 'Poppins', sans-serif !important; font-size: 15px !important; font-weight: 600 !important; border-radius: 14px !important; padding: 12px 0 !important; flex: 1 !important; background-color: #fff !important; border: 2px solid #e5e7eb !important; color: #374151 !important; }
    .swal2-cancel:hover { background-color: #f9fafb !important; border-color: #d1d5db !important; }
  </style>
</head>

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
      <h1>Daftar Laporan Kader Pokja 3</h1>
    </div>

    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
      <i class="bi bi-check-circle me-1"></i> {{ $message }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card mt-2">
      <div class="card-body">
        
        <div class="alert alert-info d-flex align-items-center mt-3" role="alert">
          <i class="bi bi-info-circle-fill me-2"></i>
          <div>Scroll horizontal untuk melihat semua kolom data.</div>
        </div>

        <div class="table-responsive mt-3">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th scope="col" rowspan="2" class="text-center align-middle">No</th>
                @if (Auth::guard('web')->check())
                  <th class="text-center align-middle" rowspan="2" scope="col">Kecamatan</th>
                  <th class="text-center align-middle" rowspan="2" scope="col">Desa</th>
                @elseif (Auth::guard('pengguna')->check())
                  <th class="text-center align-middle" rowspan="2" scope="col">Desa</th>
                @endif
                
                <th scope="col" colspan="3" class="text-center header-group-title" style="background-color: #fcf8e3;">JUMLAH KADER</th>
                <th scope="col" rowspan="2" class="text-center align-middle">Status</th>
                <th scope="col" rowspan="2" class="text-center align-middle">Tanggal</th>
                <th scope="col" rowspan="2" class="text-center align-middle">Aksi</th>
              </tr>
              
              <tr>
                <th class="text-center header-sub-title" scope="col" style="background-color: #fffaf0;">Pangan</th>
                <th class="text-center header-sub-title" scope="col" style="background-color: #fffaf0;">Sandang</th>
                <th class="text-center header-sub-title" scope="col" style="background-color: #fffaf0;">Tata Laksana RT</th>
              </tr>
            </thead>
            <tbody>
              @php $no = 1; @endphp
              @forelse ($data as $got1)
              <tr>
                <th scope="row" class="text-center">{{ $no++ }}</th>
                @if (Auth::guard('web')->check())
                  <td class="text-center">{{ $got1->nama_kec ?? '-' }}</td>
                  <td class="text-center">{{ $got1->nama_desa ?? '-' }}</td>
                @elseif (Auth::guard('pengguna')->check())
                  <td class="text-center">{{ $got1->nama_desa ?? '-' }}</td>
                @endif
                
                <td class="text-center">{{ $got1->pangan ?? '0' }}</td>
                <td class="text-center">{{ $got1->sandang ?? '0' }}</td>
                <td class="text-center">{{ $got1->tata_laksana_rumah ?? '0' }}</td>
                
                <td class="text-center">
                  @if(in_array(strtolower($got1->status), ['proses', 'revisi']))
                    <span class="badge bg-warning text-dark">{{ $got1->status }}</span>
                  @elseif(in_array(strtolower($got1->status), ['disetujui1', 'disetujui2']))
                    <span class="badge bg-success">{{ $got1->status }}</span>
                  @else
                    <span class="badge bg-secondary">{{ $got1->status }}</span>
                  @endif
                </td>
                
                <td class="text-center">{{ \Carbon\Carbon::parse($got1->created_at)->format('d/m/Y H:i') }}</td>
                <td class="text-center" style="white-space: nowrap;">
                  <a href="{{ route('laporanpokja3.edit', $got1->id_kader_pokja3) }}" class="btn btn-sm btn-info text-white me-1" data-bs-toggle="tooltip" title="Review Data">
                    <i class="bi bi-search"></i>
                  </a>
                  
                  <form action="{{ route('laporanpokja3.destroy', $got1->id_kader_pokja3)}}" method="POST" class="d-inline delete-form">
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
                <td colspan="10" class="text-center py-5">
                  <div class="alert alert-danger mb-0">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Tidak ada data laporan kader pokja 3.
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