<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  @php
  $isAdmin = Auth::guard('web')->check();
  $isPengguna = Auth::guard('pengguna')->check();
  @endphp

  <ul class="sidebar-nav" id="sidebar-nav">

    {{-- Dashboard --}}
    @if ($isAdmin)
    <li class="nav-item">
      <a class="nav-link {{ Request::is('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
      </a>
    </li>
  @elseif ($isPengguna)
    <li class="nav-item">
      <a class="nav-link {{ Request::is('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
      </a>
    </li>
  @endif

    {{-- Admin Only --}}
    @if ($isAdmin)
    <li class="nav-item">
      <a class="nav-link {{ Request::is('ttd*') ? '' : 'collapsed' }}" href="{{ route('ttd.index') }}">
      <i class="fa-solid fa-signature"></i>
      <span>Tanda Tangan</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ Request::is('input_berita*') ? '' : 'collapsed' }}" href="input_berita">
      <i class="fa-solid fa-newspaper"></i>
      <span>Berita</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ Request::is('input_pengumuman*') ? '' : 'collapsed' }}" href="input_pengumuman">
      <i class="fa-sharp fa-solid fa-bullhorn"></i>
      <span>Pengumuman</span>
      </a>
    </li>
  @endif

    {{-- Galeri (admin & pengguna) --}}
    @if ($isAdmin || $isPengguna)
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#galeri_nav" data-bs-toggle="collapse" href="#">
      <i class="fa-solid fa-image"></i><span>Kegiatan</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="galeri_nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
      <li><a href="{{ route('galeribidangumum.index') }}"><i class="bi bi-circle"></i><span>Bidang Umum</span></a>
      </li>
      <li><a href="{{ route('galeripokja1.index') }}"><i class="bi bi-circle"></i><span>Kelompok Kerja 1</span></a>
      </li>
      <li><a href="{{ route('galeripokja2.index') }}"><i class="bi bi-circle"></i><span>Kelompok Kerja 2</span></a>
      </li>
      <li><a href="{{ route('galeripokja3.index') }}"><i class="bi bi-circle"></i><span>Kelompok Kerja 3</span></a>
      </li>
      <li><a href="{{ route('galeripokja4.index') }}"><i class="bi bi-circle"></i><span>Kelompok Kerja 4</span></a>
      </li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ Request::is('accbidangumum*') || Request::is('pokja1*') || Request::is('pokja2*') || Request::is('pokja3*') || Request::is('pokja4*') ? '' : 'collapsed' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
      <i class="fa-solid fa-book"></i><span>Kelompok Kerja</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="components-nav" class="nav-content collapse {{ Request::is('accbidangumum*') || Request::is('pokja1*') || Request::is('pokja2*') || Request::is('pokja3*') || Request::is('pokja4*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
      <li><a href="{{ route('accbidangumum.index') }}" class="{{ Request::is('accbidangumum*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Bidang Umum</span></a></li>
      <li><a href="{{ route('pokja1.index') }}" class="{{ Request::is('pokja1*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Kelompok Kerja 1</span></a></li>
      <li><a href="{{ route('pokja2.index') }}" class="{{ Request::is('pokja2*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Kelompok Kerja 2</span></a></li>
      <li><a href="{{ route('pokja3.index') }}" class="{{ Request::is('pokja3*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Kelompok Kerja 3</span></a></li>
      <li><a href="{{ route('pokja4.index') }}" class="{{ Request::is('pokja4*') ? 'active' : '' }}"><i class="bi bi-circle"></i><span>Kelompok Kerja 4</span></a></li>
      </ul>
    </li>
  @endif

    {{-- Profil & Logout (semua user) --}}
    <li class="nav-heading">Halaman</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="profile">
        <i class="fa-solid fa-user"></i>
        <span>Profil</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="#" onclick="confirmLogout(event)">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span>Keluar</span>
      </a>
    </li>

  </ul>

</aside><!-- End Sidebar -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function confirmLogout(event) {
    event.preventDefault();
    Swal.fire({
      title: 'Apakah anda yakin ingin Logout?',
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#d1d5db',
      confirmButtonText: 'Logout',
      cancelButtonText: 'Batal',
      customClass: {
        popup: 'logout-popup',
        title: 'logout-title',
        confirmButton: 'logout-confirm-btn',
        cancelButton: 'logout-cancel-btn'
      },
      buttonsStyling: false,
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = 'logout';
      }
    });
  }
</script>

<style>
  .logout-popup {
    border-radius: 20px !important;
    padding: 40px 30px !important;
    width: 450px !important;
  }
  
  .logout-title {
    font-family: 'Poppins', sans-serif !important;
    font-size: 24px !important;
    font-weight: 600 !important;
    color: #2d3748 !important;
    margin-bottom: 30px !important;
  }
  
  .logout-confirm-btn {
    background-color: #ef4444 !important;
    color: white !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 16px !important;
    font-weight: 600 !important;
    padding: 12px 50px !important;
    border-radius: 10px !important;
    border: none !important;
    cursor: pointer !important;
    transition: all 0.2s !important;
  }
  
  .logout-confirm-btn:hover {
    background-color: #dc2626 !important;
  }
  
  .logout-cancel-btn {
    background-color: #e5e7eb !important;
    color: #4b5563 !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 16px !important;
    font-weight: 600 !important;
    padding: 12px 50px !important;
    border-radius: 10px !important;
    border: none !important;
    cursor: pointer !important;
    transition: all 0.2s !important;
    margin-right: 10px !important;
  }
  
  .logout-cancel-btn:hover {
    background-color: #d1d5db !important;
  }
  
  .swal2-actions {
    gap: 10px !important;
  }
</style>