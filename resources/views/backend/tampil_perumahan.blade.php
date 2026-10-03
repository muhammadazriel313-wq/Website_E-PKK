{{-- @extends('backend/layouts.template') --}}



{{-- @section('content1') --}}



<!DOCTYPE html>

,<html lang="en">



<head>

  <meta charset="utf-8">

  <meta content="width=device-width, initial-scale=1.0" name="viewport">



  <title>Laporan</title>

  <meta content="" name="description">

  <meta content="" name="keywords">



  <!-- Favicons -->

  <link href="{{ asset('backend/assets/img/favicon.png') }}" rel="icon">

  <link href="{{ asset('backend/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">



  <!-- Google Fonts -->

  <link href="https://fonts.gstatic.com" rel="preconnect">

  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">



  <!-- Vendor CSS Files -->

  <link href="{{ asset('backend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

  <link href="{{ asset('backend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

  <link href="{{ asset('backend/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">

  <link href="{{ asset('backend/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">

  <link href="{{ asset('backend/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">

  <link href="{{ asset('backend/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">

  <link href="{{ asset('backend/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">



  <!-- Template Main CSS File -->

  <link href="{{ asset('backend/assets/css/style.css') }}" rel="stylesheet">



  {{-- fontawesome --}}

  <link rel="stylesheet" type="text/css" href="{{ asset('fontawesome/css/all.min.css') }}">




  <style>
    * {
      font-family: "Poppins", sans-serif !important;
    }

    body {
      background: #f6f9ff !important;
    }

    .header {
      background: #fff !important;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08) !important;
      height: 70px !important;
      padding: 0 20px !important;
      z-index: 998 !important;
    }

    .header .logo {
      min-width: auto;
      padding: 0;
      margin-left: 15px;
    }

    .header .logo img {
      max-height: 50px;
      width: 50px;
      border-radius: 50%;
      margin-right: 15px;
      flex-shrink: 0;
    }

    .header .logo span {
      font-size: 15px;
      font-weight: 700;
      font-family: "Poppins", sans-serif !important;
      line-height: 1.3;
      color: #1a1a1a;
      white-space: nowrap;
      display: inline-block;
    }

    .toggle-sidebar-btn {
      color: #1a1a1a !important;
      font-size: 24px !important;
      cursor: pointer !important;
      padding: 10px 15px !important;
    }

    .sidebar {
      width: 300px !important;
      top: 70px !important;
      background: #fff !important;
      border-right: 1px solid #e5e7eb !important;
      z-index: 997 !important;
    }

    .toggle-sidebar .sidebar {
      width: 80px !important;
    }

    .toggle-sidebar .sidebar .nav-link span {
      display: none !important;
    }

    .toggle-sidebar .sidebar .nav-link {
      justify-content: center !important;
      padding: 12px 0 !important;
    }

    #main {
      margin-left: 300px !important;
      margin-top: 70px !important;
      padding: 25px 35px !important;
      background: #f6f9ff !important;
      min-height: calc(100vh - 70px) !important;
    }

    .toggle-sidebar #main {
      margin-left: 80px !important;
    }

    .sidebar-nav .nav-link:not(.collapsed) {
      background: #e8ecff;
      color: #4154f1;
      border-radius: 6px;
    }

    .sidebar-nav .nav-link:not(.collapsed) i {
      color: #4154f1;
    }

    .sidebar-nav .nav-item {
      margin-bottom: 4px;
    }

    .sidebar-nav .nav-link {
      display: flex;
      align-items: center;
      padding: 12px 20px;
      font-size: 15px;
      font-weight: 400;
      font-family: "Poppins", sans-serif !important;
      color: #4b5563;
      transition: all 0.3s;
    }

    .sidebar-nav .nav-link i {
      font-size: 18px;
      margin-right: 12px;
      color: #6b7280;
    }

    .sidebar-nav .nav-link:hover {
      background: #f3f4f6;
      color: #4154f1;
    }

    i,
    .bi,
    [class^="bi-"],
    [class*=" bi-"],
    [class^="fa"],
    [class*=" fa-"] {
      font-family: unset !important;
    }
  </style>
</head>



<body>



  <!-- ======= Header ======= -->

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
  </header><!-- End Header -->



  <!-- ======= Sidebar ======= -->
  @include('backend.includes.sidebar')
  <!-- End Sidebar-->



  <main id="main" class="main">



    <section class="section">

      <div class="row">

        <div class="col-md-12 mx-auto mt-2">

          <div class="pagetitle">

            <h1>Review Laporan Program Perumahan Dan Tata Laksana Rumah Tangga</h1>

          </div><!-- End Page Title -->

          <div class="card">

            <div class="card-body mt-4">

              <form action="{{ route('perumahan.update', $data->id_pokja3_bidang3) }}" method="POST"
                enctype="multipart/form-data" onsubmit="event.preventDefault(); confirmSubmission(event)">



                @csrf

                @method('PUT')

                <div class="form-outline mb-4">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-outline mb-3">
                        <label for="id_pokja3_bidang3" class="form-label fw-semibold text-secondary">
                          <i class="bi bi-hash me-1 text-primary"></i> ID Laporan
                        </label>
                        <input type="text" name="id_pokja3_bidang3" id="id_pokja3_bidang3" class="form-control bg-light" required readonly value="{{ $data->id_pokja3_bidang3 }}" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-outline mb-3">
                        <label for="tanggal" class="form-label fw-semibold text-secondary">
                          <i class="bi bi-calendar3 me-1 text-primary"></i> Tanggal Pengiriman
                        </label>
                        <input type="text" name="tanggal" id="tanggal" class="form-control bg-light" required readonly value="{{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y, H:i') }}" />
                      </div>
                    </div>
                  </div>

                  {{-- SECTION: DATA JUMLAH RUMAH --}}
                  <h5 class="fw-bold mt-3 mb-3 pb-2 border-bottom" style="font-size: 16px; color: #1e293b;">
                    <i class="bi bi-houses-fill me-2" style="color: #ea580c;"></i> Data Jumlah Rumah
                  </h5>

                  <div class="row g-3 mb-4">
                    <div class="col-md-6">
                      <div class="p-3 rounded-3" style="background-color: #f0fdf4; border: 1px solid #bbf7d0;">
                        <label for="layak_huni" class="form-label fw-semibold text-dark mb-1">
                          <i class="bi bi-check-circle-fill me-1 text-success"></i> Rumah Sehat & Layak Huni
                        </label>
                        <input type="text" name="layak_huni" id="layak_huni" class="form-control fw-bold fs-4 text-success text-center bg-white" required readonly value="{{ $data->layak_huni ?? 0 }}" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="p-3 rounded-3" style="background-color: #fef2f2; border: 1px solid #fecaca;">
                        <label for="tidak_layak" class="form-label fw-semibold text-dark mb-1">
                          <i class="bi bi-exclamation-octagon-fill me-1 text-danger"></i> Rumah Tidak Sehat & Tidak Layak Huni
                        </label>
                        <input type="text" name="tidak_layak" id="tidak_layak" class="form-control fw-bold fs-4 text-danger text-center bg-white" required readonly value="{{ $data->tidak_layak ?? 0 }}" />
                      </div>
                    </div>
                  </div>

                  {{-- SECTION: STATUS & CATATAN --}}
                  <h5 class="fw-bold mt-4 mb-3 pb-2 border-bottom" style="font-size: 16px; color: #1e293b;">
                    <i class="bi bi-clipboard-check me-2" style="color: #4154f1;"></i> Status Verifikasi & Catatan
                  </h5>

                  <div id="statusAlert" class="alert alert-danger d-none" role="alert">
                    Harap pilih status laporan.
                  </div>

                  <div class="row g-3">
                    <div class="col-md-6">
                      <div class="form-outline mb-3">
                        <label for="status" class="form-label fw-semibold">Pilih Status Tindakan <span class="text-danger">*</span></label>
                        <select name="status" class="form-select form-select-lg" required>
                          <option value="">-- Pilih Status --</option>
                          <option value="Revisi">Revisi</option>
                          @if(Auth::guard('pengguna')->check())
                            <option value="Disetujui1">Disetujui (Kecamatan)</option>
                          @else
                            <option value="Disetujui2">Disetujui (Kabupaten)</option>
                          @endif
                        </select>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-outline mb-3">
                        <label for="catatan" class="form-label fw-semibold">Catatan Review</label>
                        <input type="text" name="catatan" id="catatan" class="form-control form-control-lg" placeholder="Tuliskan catatan jika perlu perbaikan..." value="{{ $data->catatan }}" />
                        <small class="text-muted d-block mt-1">*Catatan wajib diisi jika status laporan adalah <b>Revisi</b>.</small>
                      </div>
                    </div>
                  </div>

                  <input type="hidden" name="id_user" value="{{ $data->id_user }}" />

                  <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary px-4 py-2 fw-semibold">Kembali</a>
                    <button class="btn btn-primary px-4 py-2 fw-semibold" type="submit">
                      <i class="bi bi-check-lg me-1"></i> Simpan Hasil Review
                    </button>
                  </div>
                </div>



              </form>



            </div>

          </div>



        </div>

      </div>

    </section>



  </main><!-- End #main -->



  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>



  <!-- Vendor JS Files -->

  <script src="{{ asset('backend/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>

  <script src="{{ asset('backend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <script src="{{ asset('backend/assets/vendor/chart.js/chart.umd.js') }}"></script>

  <script src="{{ asset('backend/assets/vendor/echarts/echarts.min.js') }}"></script>

  <script src="{{ asset('backend/assets/vendor/quill/quill.min.js') }}"></script>

  <script src="{{ asset('backend/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>

  <script src="{{ asset('backend/assets/vendor/tinymce/tinymce.min.js') }}"></script>

  <script src="{{ asset('backend/assets/vendor/php-email-form/validate.js') }}"></script>



  <!-- Template Main JS File -->

  <script src="{{ asset('backend/assets/js/main.js') }}"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function confirmSubmission(e) {
      var status = document.querySelector('select[name="status"]').value;
      var alertBox = document.getElementById('statusAlert');
      alertBox.classList.add('d-none');

      if (status === "Revisi") {
        Swal.fire({
          title: 'Konfirmasi Revisi',
          text: 'Apakah Anda yakin ingin mengubah status menjadi Revisi? Catatan perlu diisi.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, Ubah',
          cancelButtonText: 'Batal',
        }).then((result) => {
          if (result.isConfirmed) {
            e.target.submit(); // ✅ submit form jika user klik "Ya, Ubah"
          }
        });
        return false; // ⛔ cegah submit default
      } else if (status === "Disetujui1" || status === "Disetujui2") {
        Swal.fire({
          title: 'Konfirmasi Persetujuan',
          text: 'Apakah Anda yakin ingin menyetujui laporan ini?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Ya, Setujui',
          cancelButtonText: 'Batal',
        }).then((result) => {
          if (result.isConfirmed) {
            e.target.submit(); // ✅ submit form jika disetujui
          }
        });
        return false;
      } else {
        alertBox.classList.remove('d-none');
        alertBox.innerText = 'Harap pilih status laporan.';
        return false;
      }
    }
  </script>

</body>



{{--

</html> --}}

{{-- @endsection --}}