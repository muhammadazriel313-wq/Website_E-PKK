{{-- @extends('backend/layouts.template') --}}

{{-- @section('content1') --}}

<!DOCTYPE html>
,<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Edit Berita</title>
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
            <h1>Edit Berita</h1>
          </div><!-- End Page Title -->
          <div class="card">
            <div class="card-body mt-4">
              <form action="{{ route('input_berita.update', $data->id) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')
                <div class="form-outline mb-4">
                  <label for="image" class="form-label">Gambar</label>
                  <input type="file" name="image" id="image" class="form-control mb-2"
                    oninput="this.setCustomValidity('')" />
                  <input type="text" name="gambaru" id="gambaru" disabled class="form-control mt-3"
                    value="{{ $data->image }}" />
                  @if ($data->image)
            <img src="{{ asset('storage/berita/' . $data->image) }}" alt="{{ $data->judul }}" class="rounded mt-3"
            width="200" height="200">
          @endif


                </div>

                <div class="form-outline mb-4">
                  <label for="judul" class="form-label">Judul</label>
                  <input type="text" name="judul" id="judul" class="form-control" required
                    oninvalid="this.setCustomValidity('Harap lengkapi judul')" oninput="this.setCustomValidity('')"
                    placeholder="Masukkan Judul" value="{{ $data->judul }}" />
                </div>

                <div class="form-outline mb-4">
                  <label for="deskripsi" class="form-label">Deskripsi</label>
                  <textarea class="form-control" name="deskripsi" rows="6" id="deskripsi"
                    placeholder="Masukkan Deskripsi Berita" required
                    oninvalid="this.setCustomValidity('Harap lengkapi deskripsi')"
                    oninput="this.setCustomValidity('')">{{ $data->deskripsi }}</textarea>
                  <div class="invalid-feedback">
                    Harap lengkapi deskripsi
                  </div>
                </div>

                <div class="form-outline mb-4">
                  <label for="file" class="form-label">Upload PDF (Opsional)</label>
                  <input type="file" name="file" id="file" class="form-control" class="dropzone"
                    oninput="this.setCustomValidity('')" />

                  <input type="text" name="files" id="files" disabled class="form-control mt-2"
                    value="{{ $data->file }}" />
                </div>

                <div class="text-end pt-1 pb-1 mt-4">
                  <button class="btn btn-primary ps-xxl-5 pe-xxl-5 mr-auto background-blue-1 mb-2 fw-semibold fs-5"
                    style="background-color: #016AA3 !important; border-color: #016AA3 !important;"
                    type="submit">Edit</button>
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

</body>

{{--

</html> --}}
{{-- @endsection --}}