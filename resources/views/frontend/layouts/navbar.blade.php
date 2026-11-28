<!-- ======= Header ======= -->
<header id="header" class="d-flex align-items-center">
  <div class="container d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-3">
      <img src="{{ asset('frontend/assets/img/favicon.png') }}" class="logo-img" alt="">

      <div class="site-title">
        <h1 class="mb-0">
          <a href="home">
            Pemberdayaan Kesejahteraan Keluarga <br>
            Kabupaten Nganjuk
          </a>
        </h1>
      </div>
    </div>

    <nav id="navbar" class="navbar">
      <ul>
        <li><a class="nav-link scrollto" href="{{ route('home.index') }}#hero">Beranda</a></li>
        <li><a class="nav-link scrollto" href="{{ route('home.index') }}#portfolio">Galeri</a></li>
        <li><a class="nav-link scrollto " href="{{ route('home.index') }}#service">Program Kerja</a></li>

        <li><a class="nav-link scrollto" href="{{ route('home.index') }}#berita">Berita</a></li>
        <li class="dropdown"><a href="#"><span>Profil</span> <i class="bi bi-chevron-down"></i></a>
          <ul class="dropdown-menu-profile">
            <li><a href="{{ route('visimisi.index') }}">Visi Misi</a></li>
            <li><a href="lambangpkk">Arti Lambang PKK</a></li>
            <li><a href="sejarah">Sejarah</a></li>
            <li><a href="mars">Mars PKK</a></li>
            <li class="admin-login-wrapper">
              <form action="{{ route('masuk-admin') }}" method="POST" class="form-masuk-admin">
                @csrf
                <button type="submit" class="btn-masuk-admin">
                  <i class="bi bi-shield-lock-fill"></i>
                  <span>Masuk Admin</span>
                </button>
              </form>
            </li>
          </ul>
        </li>
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->
  </div>
</header>
<!-- End Header -->

<style>
  /* ===== DROPDOWN PROFIL & TOMBOL MASUK ADMIN ===== */
  .navbar .dropdown ul {
    border-radius: 14px !important;
    box-shadow: 0 12px 36px rgba(0, 0, 0, 0.15) !important;
    border: 1px solid rgba(0, 0, 0, 0.08) !important;
    padding: 8px 0 8px 0 !important;
    overflow: hidden;
  }

  /* Pastikan dropdown profil di paling kanan terbuka ke arah dalam (ke kiri), tidak terpotong tepi layar */
  @media (min-width: 992px) {
    .navbar .dropdown:last-child ul,
    .navbar .dropdown ul.dropdown-menu-profile {
      left: auto !important;
      right: 0 !important;
      min-width: 220px !important;
    }
  }

  .navbar .dropdown ul li a {
    font-size: 14px;
    font-weight: 500;
    color: #334155;
    padding: 10px 22px;
    transition: all 0.2s ease;
  }

  .navbar .dropdown ul li a:hover {
    color: #016AA3;
    padding-left: 26px;
    background-color: #f8fafc;
  }

  /* Kotak Pembatas & Tombol Masuk Admin */
  .navbar .dropdown ul .admin-login-wrapper {
    margin-top: 6px;
    padding: 10px 14px 10px 14px !important;
    border-top: 1px solid #e2e8f0;
    background-color: #f8fafc;
  }

  .navbar .dropdown ul .form-masuk-admin {
    margin: 0;
  }

  .navbar .dropdown ul .btn-masuk-admin {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    border: none !important;
    cursor: pointer;
    font-family: inherit;
    background: linear-gradient(135deg, #016AA3 0%, #0284c7 100%) !important;
    color: #ffffff !important;
    font-weight: 600 !important;
    font-size: 13px !important;
    padding: 10px 16px !important;
    border-radius: 8px !important;
    text-align: center;
    box-shadow: 0 4px 12px rgba(1, 106, 163, 0.25) !important;
    transition: all 0.25s ease !important;
    width: 100% !important;
    box-sizing: border-box !important;
  }

  .navbar .dropdown ul .btn-masuk-admin:hover {
    background: linear-gradient(135deg, #01507d 0%, #016AA3 100%) !important;
    color: #ffffff !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 16px rgba(1, 106, 163, 0.35) !important;
    padding-left: 16px !important;
  }

  .navbar .dropdown ul .btn-masuk-admin i {
    font-size: 14px !important;
    color: #ffffff !important;
    margin: 0 !important;
  }

  /* Tampilan Mobile */
  @media (max-width: 991px) {
    .navbar-mobile .dropdown ul .admin-login-wrapper {
      padding: 10px 20px !important;
      background: transparent;
      border-top: 1px solid #e2e8f0;
      margin-top: 8px;
    }

    .navbar-mobile .dropdown ul .btn-masuk-admin {
      width: 100%;
      justify-content: center;
    }
  }
</style>
