<!-- resources/views/backend/accinovasi.blade.php -->

{{-- @extends('backend/layouts.template') --}}
{{-- @section('content1') --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Inovasi Pokja 4</title>

    <!-- Favicons -->
    <link href="backend/assets/img/favicon.png" rel="icon">
    <link href="backend/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">

    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS -->
    <link href="backend/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="backend/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="backend/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="backend/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="backend/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="backend/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="backend/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Main CSS -->
    <link href="backend/assets/css/style.css" rel="stylesheet">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

    <link href="{{ asset('backend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/style.css') }}" rel="stylesheet">

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

    <!-- HEADER -->
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

    <!-- SIDEBAR -->
    @include('backend.includes.sidebar')

    <!-- MAIN -->
    <main id="main" class="main">

        <!-- PAGE TITLE -->
        <div class="pagetitle">

            <h1>Inovasi Pokja 4</h1>

        </div>

        <!-- SECTION -->
        <section class="section dashboard">

            <div class="row">

                <!-- CARD PRIORITAS -->
                <div class="col-xxl-6 col-md-6">

                    <div class="card info-card sales-card">

                        <a href="{{ route('prioritas.index') }}">

                            <div class="card-body">

                                <h5 class="card-title">
                                    Prioritas
                                </h5>

                                <div class="d-flex align-items-center">

                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">

                                        <i class="bi bi-star-fill text-warning"></i>

                                    </div>

                                    <div class="ps-3">

                                        <h6>{{ $prioritas ?? 0 }}</h6>

                                        <span class="text-muted small pt-2 ps-1">
                                            Jumlah total prioritas
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </a>

                    </div>

                </div>

                <!-- CARD UNGGULAN -->
                <div class="col-xxl-6 col-md-6">

                    <div class="card info-card sales-card">

                        <a href="{{ route('unggulan.index') }}">

                            <div class="card-body">

                                <h5 class="card-title">
                                    Unggulan
                                </h5>

                                <div class="d-flex align-items-center">

                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">

                                        <i class="bi bi-award-fill text-primary"></i>

                                    </div>

                                    <div class="ps-3">

                                        <h6>{{ $unggulan ?? 0 }}</h6>

                                        <span class="text-muted small pt-2 ps-1">
                                            Jumlah total unggulan
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </a>

                    </div>

                </div>

            </div>

        </section>

    </main>

    <!-- BACK TO TOP -->
    <a href="#"
        class="back-to-top d-flex align-items-center justify-content-center">

        <i class="bi bi-arrow-up-short"></i>

    </a>

    <!-- JS -->
    <script src="backend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="backend/assets/js/main.js"></script>

</body>

</html>

{{-- @endsection --}}
