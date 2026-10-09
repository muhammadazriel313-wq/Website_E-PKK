<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Dashboard</title>

  <!-- Favicons -->
  <link href="{{ asset('backend/assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('backend/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS -->
  <link href="{{ asset('backend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <!-- Main CSS -->
  <link href="{{ asset('backend/assets/css/style.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

  <style>
    * { font-family: "Poppins", sans-serif !important; }
    i, .bi, [class^="bi-"], [class*=" bi-"],
    [class^="fa"], [class*=" fa-"], .fas, .far, .fal, .fab {
      font-family: unset !important;
    }
    body { background: #f6f9ff; }

    /* ===== KONSISTENSI WARNA BUTTON BIRU ===== */
    :root {
      --bs-primary: #016AA3;
      --bs-primary-rgb: 1, 106, 163;
      --bs-btn-bg: #016AA3;
      --bs-btn-border-color: #016AA3;
      --bs-btn-hover-bg: #015a8a;
      --bs-btn-hover-border-color: #015a8a;
      --bs-btn-active-bg: #014d77;
      --bs-btn-active-border-color: #014d77;
      --bs-link-color: #016AA3;
      --bs-link-hover-color: #015a8a;
    }
    .btn-primary,
    .btn-primary.background-blue-1 {
      background-color: #016AA3 !important;
      border-color: #016AA3 !important;
      color: #fff !important;
    }
    .btn-primary:hover,
    .btn-primary:focus,
    .btn-primary:active,
    .btn-primary.active {
      background-color: #015a8a !important;
      border-color: #015a8a !important;
      color: #fff !important;
    }
    /* btn-info juga disamakan ke biru tua */
    .btn-info,
    .btn-info.text-white {
      background-color: #016AA3 !important;
      border-color: #016AA3 !important;
      color: #fff !important;
    }
    .btn-info:hover,
    .btn-info:focus,
    .btn-info:active {
      background-color: #015a8a !important;
      border-color: #015a8a !important;
      color: #fff !important;
    }
    .btn-outline-primary {
      color: #016AA3 !important;
      border-color: #016AA3 !important;
    }
    .btn-outline-primary:hover,
    .btn-outline-primary:focus {
      background-color: #016AA3 !important;
      border-color: #016AA3 !important;
      color: #fff !important;
    }
    a.text-primary, .text-primary { color: #016AA3 !important; }
    .bg-primary { background-color: #016AA3 !important; }
    /* background-blue-1 override */
    .background-blue-1 {
      background-color: #016AA3 !important;
      border-color: #016AA3 !important;
    }
    /* ===== END BUTTON ===== */

    /* ===== SWEETALERT2 MODERN STYLE ===== */
    .swal2-popup {
      font-family: 'Poppins', sans-serif !important;
      border-radius: 24px !important;
      padding: 40px 32px 32px !important;
      box-shadow: 0 24px 64px rgba(0, 0, 0, 0.12) !important;
      max-width: 400px !important;
    }
    .swal2-title {
      font-family: 'Poppins', sans-serif !important;
      font-size: 20px !important;
      font-weight: 700 !important;
      color: #1a1a2e !important;
      padding: 0 !important;
      margin-bottom: 8px !important;
    }
    .swal2-html-container,
    .swal2-content {
      font-family: 'Poppins', sans-serif !important;
      font-size: 14px !important;
      color: #6b7280 !important;
      line-height: 1.6 !important;
    }
    /* Ikon warning — lingkaran pink dengan ikon merah */
    .swal2-icon.swal2-warning {
      border: none !important;
      background: #ffe4e6 !important;
      border-radius: 50% !important;
      width: 72px !important;
      height: 72px !important;
      margin: 0 auto 20px !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
    }
    .swal2-icon.swal2-warning .swal2-icon-content {
      font-size: 36px !important;
      color: #ef4444 !important;
      font-weight: 700 !important;
    }
    /* Tombol area */
    .swal2-actions {
      gap: 12px !important;
      margin-top: 28px !important;
      width: 100% !important;
      padding: 0 !important;
    }
    /* Tombol Hapus (confirm) — merah penuh */
    .swal2-confirm {
      font-family: 'Poppins', sans-serif !important;
      font-size: 15px !important;
      font-weight: 600 !important;
      border-radius: 14px !important;
      padding: 12px 0 !important;
      flex: 1 !important;
      background-color: #ef4444 !important;
      border: none !important;
      color: #fff !important;
      letter-spacing: 0.2px !important;
      transition: background 0.2s !important;
    }
    .swal2-confirm:hover {
      background-color: #dc2626 !important;
    }
    /* Tombol Batal (cancel) — outline putih */
    .swal2-cancel {
      font-family: 'Poppins', sans-serif !important;
      font-size: 15px !important;
      font-weight: 600 !important;
      border-radius: 14px !important;
      padding: 12px 0 !important;
      flex: 1 !important;
      background-color: #fff !important;
      border: 2px solid #e5e7eb !important;
      color: #374151 !important;
      letter-spacing: 0.2px !important;
      transition: all 0.2s !important;
    }
    .swal2-cancel:hover {
      background-color: #f9fafb !important;
      border-color: #d1d5db !important;
    }
    /* Ikon success */
    .swal2-icon.swal2-success {
      border-color: #016AA3 !important;
      color: #016AA3 !important;
    }
    .swal2-icon.swal2-success [class^=swal2-success-line] {
      background-color: #016AA3 !important;
    }
    .swal2-icon.swal2-success .swal2-success-ring {
      border-color: rgba(1, 106, 163, 0.3) !important;
    }
    /* ===== END SWEETALERT2 ===== */

    /* Header styling */
    .header {
      background: #fff !important;
      box-shadow: 0 2px 4px rgba(0,0,0,0.08) !important;
      height: 70px !important;
      padding: 0 20px !important;
      left: 0 !important;
      width: 100% !important;
      z-index: 998 !important;
    }
    
    /* Header logo */
    .header .logo {
      min-width: auto;
      padding: 0;
      margin-left: 15px;
      max-width: 400px;
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
      margin-right: 0 !important;
      cursor: pointer !important;
      padding: 10px 15px !important;
      margin-left: 0 !important;
    }

    /* Sidebar Width - Make it wider */
    .sidebar {
      width: 300px !important;
      transition: all 0.3s ease;
      top: 70px !important;
      background: #fff !important;
      border-right: 1px solid #e5e7eb !important;
      left: 0 !important;
      z-index: 997 !important;
    }
    
    /* Sidebar collapsed state - only show icons */
    .toggle-sidebar .sidebar {
      width: 80px !important;
      left: 0 !important;
    }
    
    .toggle-sidebar .sidebar .nav-link span,
    .toggle-sidebar .sidebar .logo span,
    .toggle-sidebar .sidebar .nav-heading {
      display: none !important;
    }
    
    .toggle-sidebar .sidebar .nav-link {
      justify-content: center !important;
      padding: 12px 0 !important;
    }
    
    .toggle-sidebar .sidebar .nav-link i {
      margin-right: 0 !important;
      font-size: 20px !important;
    }
    
    .toggle-sidebar .sidebar .logo {
      justify-content: center !important;
    }
    
    .toggle-sidebar .sidebar .logo img {
      margin-right: 0 !important;
    }

    /* Adjust main content when sidebar is toggled */
    #main {
      margin-left: 300px !important;
      margin-top: 70px !important;
      transition: all 0.3s ease;
      padding: 25px 35px !important;
      background: #f6f9ff !important;
      min-height: calc(100vh - 70px) !important;
    }
    
    .toggle-sidebar #main {
      margin-left: 80px !important;
    }

    /* Remove extra spacing in sections */
    .section {
      padding: 0 !important;
    }
    
    .section .row {
      margin: 0 !important;
    }

    /* Sidebar nav active state */
    .sidebar-nav .nav-link:not(.collapsed) {
      background: #e8ecff;
      color: #4154f1;
      border-radius: 6px;
    }
    .sidebar-nav .nav-link:not(.collapsed) i {
      color: #4154f1;
    }
    
    /* Sidebar nav items spacing */
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
      transition: all 0.3s;
    }
    
    .sidebar-nav .nav-link:hover {
      background: #f3f4f6;
      color: #4154f1;
    }
    
    .sidebar-nav .nav-link:hover i {
      color: #4154f1;
    }
    
    /* Hide dropdown arrow when sidebar is collapsed */
    .toggle-sidebar .sidebar .nav-link .bi-chevron-down {
      display: none !important;
    }
    
    /* Hide nav-content (dropdown items) when sidebar is collapsed */
    .toggle-sidebar .sidebar .nav-content {
      display: none !important;
    }
    
    /* Nav heading styling */
    .sidebar-nav .nav-heading {
      font-size: 11px;
      text-transform: uppercase;
      color: #899bbd;
      font-weight: 600;
      margin: 20px 0 10px 20px;
    }

    /* TTD Page Styling */
    .page-heading {
        font-size: 24px !important;
        font-weight: 600 !important;
        font-family: "Poppins", sans-serif !important;
        color: #2d3748 !important;
        margin-bottom: 20px !important;
        margin-top: 0 !important;
        padding-top: 0 !important;
    }

    .form-card {
        background: #fff !important;
        border-radius: 8px !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
        padding: 32px !important;
        margin-bottom: 40px !important;
        border: 1px solid #e2e8f0 !important;
        overflow: hidden !important;
    }
    
    .form-card form {
        overflow: hidden !important;
    }

    .form-card .form-label {
        font-size: 14px !important;
        font-weight: 600 !important;
        font-family: "Poppins", sans-serif !important;
        color: #4a5568 !important;
        margin-bottom: 8px !important;
        display: block !important;
    }

    .form-card .form-control,
    .form-card .form-select {
        border: 1px solid #cbd5e0 !important;
        border-radius: 6px !important;
        font-size: 14px !important;
        font-family: "Poppins", sans-serif !important;
        height: 42px !important;
        padding: 8px 14px !important;
        color: #2d3748 !important;
        background: #fff !important;
        width: 100% !important;
        transition: all 0.2s !important;
    }
    
    .form-card .form-control::placeholder {
        color: #a0aec0 !important;
        font-family: "Poppins", sans-serif !important;
    }

    .form-card .form-control:focus,
    .form-card .form-select:focus {
        border-color: #0369a1 !important;
        box-shadow: 0 0 0 3px rgba(3,105,161,.1) !important;
        outline: none !important;
    }

    .form-card .form-group {
        margin-bottom: 20px !important;
    }

    .btn-kirim {
        background-color: #0369a1 !important;
        border: none !important;
        color: #fff !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        font-family: "Poppins", sans-serif !important;
        padding: 10px 32px !important;
        border-radius: 6px !important;
        cursor: pointer !important;
        float: right !important;
        margin-top: 0 !important;
        transition: all 0.2s !important;
    }
    .btn-kirim:hover { 
        background-color: #0284c7 !important;
        color: #fff !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 8px rgba(3,105,161,0.2) !important;
    }
    
    /* Clearfix for button container */
    .text-end::after {
        content: "" !important;
        display: table !important;
        clear: both !important;
    }

    .table-card {
        background: #fff !important;
        border-radius: 8px !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
        overflow: hidden !important;
        border: 1px solid #e2e8f0 !important;
    }

    .table-ttd {
        width: 100% !important;
        border-collapse: collapse !important;
        font-size: 14px !important;
        font-family: "Poppins", sans-serif !important;
    }

    .table-ttd thead tr {
        background: #f7fafc !important;
        border-bottom: 2px solid #e2e8f0 !important;
    }

    .table-ttd thead th {
        font-weight: 600 !important;
        font-family: "Poppins", sans-serif !important;
        color: #4a5568 !important;
        padding: 16px 20px !important;
        text-align: left !important;
    }

    .table-ttd tbody tr {
        border-bottom: 1px solid #e2e8f0 !important;
        transition: background 0.2s !important;
    }
    
    .table-ttd tbody tr:hover {
        background: #f7fafc !important;
    }

    .table-ttd tbody td {
        padding: 16px 20px !important;
        color: #4a5568 !important;
        font-family: "Poppins", sans-serif !important;
        vertical-align: middle !important;
    }

    .btn-act {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 36px !important;
        height: 36px !important;
        border-radius: 6px !important;
        border: none !important;
        cursor: pointer !important;
        font-size: 14px !important;
        margin-right: 6px !important;
        transition: all 0.2s !important;
    }

    .btn-act-edit  { 
        background: #22c55e !important; 
        color: #fff !important; 
    }
    .btn-act-edit:hover { 
        background: #16a34a !important; 
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 8px rgba(34,197,94,0.3) !important;
    }
    
    .btn-act-delete { 
        background: #ef4444 !important; 
        color: #fff !important; 
    }
    .btn-act-delete:hover { 
        background: #dc2626 !important; 
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 8px rgba(239,68,68,0.3) !important;
    }

    /* ===== RESPONSIVE MOBILE BACKEND ===== */
    @media (max-width: 991px) {
      /* Sembunyikan sidebar sepenuhnya di mobile */
      .sidebar {
        left: -300px !important;
        width: 280px !important;
        transition: all 0.3s ease !important;
        z-index: 9999 !important;
      }

      /* Saat toggle-sidebar aktif di mobile, sidebar muncul */
      .toggle-sidebar .sidebar {
        left: 0 !important;
        width: 280px !important;
      }

      /* Main content FULL WIDTH di mobile — tidak ada margin kiri */
      #main {
        margin-left: 0 !important;
        padding: 16px 12px !important;
        width: 100% !important;
      }

      .toggle-sidebar #main {
        margin-left: 0 !important;
      }

      /* Header full width */
      .header {
        padding: 0 12px !important;
        left: 0 !important;
        width: 100% !important;
      }

      .header .logo span {
        font-size: 12px !important;
        white-space: normal !important;
        line-height: 1.2 !important;
        max-width: 200px !important;
      }

      .header .logo img {
        width: 38px !important;
        height: 38px !important;
        margin-right: 8px !important;
      }

      /* Form card padding lebih kecil */
      .form-card {
        padding: 16px !important;
      }

      /* Page heading */
      .page-heading, .pagetitle h1 {
        font-size: 18px !important;
      }

      /* Tabel responsive */
      .table-responsive {
        font-size: 13px !important;
      }
    }

    @media (max-width: 576px) {
      #main {
        padding: 12px 8px !important;
        margin-left: 0 !important;
      }

      .card-body {
        padding: 14px !important;
      }

      .pagetitle h1 {
        font-size: 16px !important;
      }

      .btn-sm {
        padding: 4px 8px !important;
        font-size: 12px !important;
      }

      .form-control, .form-select {
        font-size: 14px !important;
      }

      /* Info cards di dashboard — 1 kolom */
      .col-xxl-4, .col-xxl-3, .col-xxl-6,
      .col-xl-4, .col-xl-3, .col-xl-6 {
        flex: 0 0 100% !important;
        max-width: 100% !important;
      }
    }
    /* ===== END RESPONSIVE MOBILE ===== */
  </style>
</head>

<body>

  <!-- Header -->
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

  @yield('content')
  @yield('content1')

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- Vendor JS -->
  <script src="{{ asset('backend/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/quill/quill.min.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('backend/assets/js/main.js') }}"></script>

  {{-- Auto-dismiss semua alert session (success/error/warning/info) setelah 3 detik --}}
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const alerts = document.querySelectorAll('.alert-success, .alert-warning, .alert-info');
      alerts.forEach(function (alert) {
        // Hanya dismiss alert yang bukan statusAlert (validasi form) dan bukan d-none
        if (!alert.id && !alert.classList.contains('d-none')) {
          setTimeout(function () {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(function () { alert.remove(); }, 500);
          }, 3000);
        }
      });
    });
  </script>

  @yield('scripts')
  @stack('scripts')

</body>
</html>
