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
 <link href="backend/assets/img/favicon.png" rel="icon">
 <link href="backend/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

 <!-- Google Fonts -->
 <link href="https://fonts.gstatic.com" rel="preconnect">
 <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

 <!-- Vendor CSS Files -->
 <link href="backend/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
 <link href="backend/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
 <link href="backend/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
 <link href="backend/assets/vendor/quill/quill.snow.css" rel="stylesheet">
 <link href="backend/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
 <link href="backend/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
 <link href="backend/assets/vendor/simple-datatables/style.css" rel="stylesheet">

 <!-- Template Main CSS File -->
 <link href="backend/assets/css/style.css" rel="stylesheet">

  {{-- fontawesome --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('fontawesome/css/all.min.css') }}">


  <style>
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


    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Laporan Program Industri Rumah Tangga</h1>
          </div><!-- End Page Title -->

      <section class="section dashboard">
        <div class="row">
    
            <!-- Left side columns -->
    
              <div class="row">
    
                <!-- Sales Card -->
                <div class="col-xxl-6 col-md-6">
                  <div class="card info-card sales-card">
                    <a href="{{ route('sandang.index') }}">
                    <div class="card-body">
                      <h5 class="card-title">Menunggu Persetujuan</h5>
    
                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background:#fef2f2;"><i class="bi bi-hourglass-split" style="color:#ef4444; font-size:20px;"></i></div>
                        <div class="ps-3">
                          <h6>{{ $sand1 }}</h6>
                          <span class="text-muted small pt-2 ps-1">Jumlah total laporan</span>
    
                        </div>
                      </div>
                    </div>
                </a>
                  </div>
                </div><!-- End Sales Card -->
    
                <!-- Revenue Card -->
                <div class="col-xxl-6 col-md-6">
                  <div class="card info-card sales-card">
                    <a href="{{ route('decsandang.index') }}">
                    <div class="card-body">
                      <h5 class="card-title">Sudah Disetujui</h5>
    
                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background:#f0fdf4;"><i class="bi bi-patch-check-fill" style="color:#10b981; font-size:20px;"></i></div>
                        <div class="ps-3">
                          <h6>{{ $sand2 }}</h6>
                          <span class="text-muted small pt-2 ps-1">Jumlah total laporan</span>
                        </div>
                      </div>
                    </div>
                </a>
                  </div>
                </div><!-- End Revenue Card -->
                
                <div class="col-md-12 mx-auto mt-2">
        </div>
    
    
          </div>
        </div>
      </section>
    
      </main><!-- End #main -->
    

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="backend/assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="backend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="backend/assets/vendor/chart.js/chart.umd.js"></script>
<script src="backend/assets/vendor/echarts/echarts.min.js"></script>
<script src="backend/assets/vendor/quill/quill.min.js"></script>
<script src="backend/assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="backend/assets/vendor/tinymce/tinymce.min.js"></script>
<script src="backend/assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="backend/assets/js/main.js"></script>

<script type="text/javascript">
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone('#pdf', {
          maxFilesize: 1,
          acceptedFiles: ".pdf",
          addRemoveLinks: true,
          autoProcessQueue: false,
          init: function() {
            $("button").click(function (e) {
              e.preventDefault();
              myDropzone.processQueue();
            });

            this.on('sending', function(file, xhr, formData) {
              var data = $('#pdf').serializeArray();
              $.each(data, function(key, el) {
                formData.append(el.name, el.value);
              });
            });
          }
        });
</script>

</body>

{{-- </html> --}}
{{-- @endsection --}}