@extends('frontend/layouts.template')

@section('content')

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">
  <div class="overlay"></div>

  <div class="container">
    <div class="hero-content d-flex align-items-center gap-2">
      <!-- LOGO -->
      <img src="{{ asset('frontend/assets/img/favicon.png') }}" class="hero-logo" alt="Logo PKK">
      <!-- TEXT -->
      <div>
        <h1 id="typing-text"></h1>
        <p id="typing-sub"></p>
      </div>
    </div>
  </div>
</section>
<!-- End Hero -->

{{-- ========================================================== --}}
{{-- POP-UP SWEETALERT KHUSUS LOGOUT / NOTIFIKASI               --}}
{{-- ========================================================== --}}
@if (session('success') || session('status') || session('message'))
<!-- Panggil Library SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const preloader = document.querySelector('#preloader');
    if (preloader) {
      preloader.style.display = 'none';
    }

    Swal.fire({
      icon: 'success',
      title: 'Berhasil Logout!',
      html: '<span style="font-family: \'Poppins\', sans-serif; font-size: 14px; color: #6b7280;">{{ session("success") ?? session("status") ?? session("message") ?? "Sampai jumpa! Anda telah aman keluar dari sistem E-PKK." }}</span>',
      showConfirmButton: true,
      confirmButtonText: '<i class="bi bi-house-door-fill me-2"></i> Tutup',
      confirmButtonColor: '#016AA3',
      timer: 3000,
      timerProgressBar: true,
      backdrop: 'rgba(15, 23, 42, 0.5)',
      customClass: {
        popup: 'swal2-modern-popup',
        title: 'swal2-modern-title',
        confirmButton: 'swal2-modern-confirm',
        timerProgressBar: 'swal2-modern-timer'
      },
      showClass: {
        popup: 'animate__animated animate__zoomIn animate__faster'
      },
      hideClass: {
        popup: 'animate__animated animate__zoomOut animate__faster'
      }
    });
  });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
  .swal2-modern-popup {
    font-family: 'Poppins', sans-serif !important;
    border-radius: 24px !important;
    padding: 40px 32px 32px !important;
    box-shadow: 0 24px 64px rgba(0, 0, 0, 0.12) !important;
    max-width: 420px !important;
  }
  .swal2-modern-title {
    font-family: 'Poppins', sans-serif !important;
    font-size: 22px !important;
    font-weight: 700 !important;
    color: #1a1a2e !important;
  }
  .swal2-modern-confirm {
    font-family: 'Poppins', sans-serif !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    border-radius: 50px !important;
    padding: 12px 32px !important;
    background-color: #016AA3 !important;
    border: none !important;
    letter-spacing: 0.2px !important;
    transition: all 0.2s ease !important;
  }
  .swal2-modern-confirm:hover {
    background-color: #015a8a !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 16px rgba(1, 106, 163, 0.35) !important;
  }
  .swal2-modern-timer {
    background: #016AA3 !important;
  }
  /* Ikon success — warna biru tua */
  .swal2-modern-popup .swal2-icon.swal2-success {
    border-color: #016AA3 !important;
  }
  .swal2-modern-popup .swal2-icon.swal2-success [class^=swal2-success-line] {
    background-color: #016AA3 !important;
  }
  .swal2-modern-popup .swal2-icon.swal2-success .swal2-success-ring {
    border-color: rgba(1, 106, 163, 0.25) !important;
  }
</style>
@endif

<main id="main">

  <section class="app-section">
    <div class="container">
      <div class="row align-items-center">

        <!-- KIRI (GAMBAR HP) -->
        <div class="col-lg-6 text-center animate-on-scroll" data-animation="slide-right">
          <div class="app-img floating-animation">
            <img src="{{ asset('frontend/assets/img/gadget.png') }}" class="img-fluid" alt="">
          </div>
        </div>

        <!-- KANAN (TEXT) -->
        <div class="col-lg-6 animate-on-scroll" data-animation="slide-left">
          <h3 class="app-title gradient-text">E-PKK Kab.Nganjuk App</h3>
          <p class="fade-in-text">
            E-PKK Kab. Nganjuk adalah aplikasi digital yang digunakan untuk mendukung pelaksanaan program PKK agar lebih mudah, cepat, dan teratur. Aplikasi ini memudahkan pengguna dalam melakukan pelaporan kegiatan secara langsung melalui perangkat genggam.

            Selain itu, E-PKK juga menyediakan fitur unggah galeri untuk mendokumentasikan kegiatan PKK dalam bentuk foto maupun laporan. Dengan fitur ini, seluruh aktivitas dapat tercatat dengan rapi, mudah diakses, dan terdokumentasi dengan baik dalam satu sistem.
          </p>

          <a href="#" class="btn-app pulse-animation">Download Sekarang</a>
        </div>

      </div>
    </div>
  </section>

  <!-- ======= About Section ======= -->
  <section id="about" class="about section-bg">
    <div class="container">

      <div class="row align-items-center">

        <!-- KIRI -->
        <div class="col-lg-4 animate-on-scroll" data-animation="fade-up">
          <h5>
            <b>Ketua PPK Kab. Nganjuk</b>
          </h5>
          <p>
            Ketua Tim Penggerak PKK (TP PKK) Kabupaten Nganjuk saat ini adalah
            Ny. S. Wahyuni Marhaen, S.E. Beliau aktif memimpin program pemberdayaan keluarga,
            penurunan stunting, dan kesehatan masyarakat, didampingi pengurus TP PKK lainnya di Kabupaten Nganjuk.
          </p>
        </div>

        <!-- TENGAH (FOTO) -->
        <div class="col-lg-4 text-center animate-on-scroll" data-animation="zoom-in">
          <div class="img-box hover-lift">
            <img src="{{ asset('frontend/assets/img/ketuapkk.png') }}" class="img-fluid">
          </div>
        </div>

        <!-- KANAN -->
        <div class="col-lg-4 animate-on-scroll" data-animation="fade-up" data-delay="200">
          <h5><b>Visi Utama</b></h5>
          <p>
            Mewujudkan keluarga sehat, cerdas, berdaya, beriman, dan bertaqwa menuju Nganjuk Melesat
            (Maju, Sejahtera, Bermartabat).
          </p>

          <h5 class="mt-3"><b>Misi Utama</b></h5>
          <ul class="animated-list">
            <li>Sinergi Daerah</li>
            <li>Digitalisasi PKK</li>
            <li>Pemberdayaan Keluarga</li>
            <li>Kolaborasi</li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!-- End About -->

  <!-- ======= Portfolio Section ======= -->
  <section id="portfolio" class="portfolio">
    <div class="container" data-aos="fade-up">

      <div class="section-title animate-on-scroll" data-animation="fade-up">
        <div class="section-badge">GALERI</div>
        <h3>Galeri PKK <span class="gradient-text">Kab Nganjuk</span></h3>
        <p>Dokumentasi acara PKK Nganjuk</p>
      </div>

      <!-- Swiper Carousel with Staggered Layout -->
      <div class="gallery-carousel-wrapper animate-on-scroll" data-animation="fade-up" data-delay="200">
        <div class="swiper gallerySwiper">
          <div class="swiper-wrapper">
            @php $index = 0; @endphp
            @forelse ($galerys as $tampil)
            <div class="swiper-slide">
              <div class="gallery-card staggered-{{ $index % 3 }} hover-3d">
                <div class="gallery-image">
                  <img src="{{ asset('storage/gallery/' . $tampil->gambar) }}" alt="{{ $tampil->deskripsi }}">
                  <div class="gallery-overlay">
                    <div class="gallery-caption-box">
                      <p class="gallery-title">{{ $tampil->deskripsi }}</p>
                      <p class="gallery-date">{{ \Carbon\Carbon::parse($tampil->tanggal)->format('Y-m-d') }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @php $index++; @endphp
            @empty
            <div class="swiper-slide">
              <div class="gallery-card">
                <div class="gallery-empty">
                  <p>Data Post belum Tersedia.</p>
                </div>
              </div>
            </div>
            @endforelse
          </div>

          <!-- Navigation Buttons -->
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        </div>
      </div>

    </div>

    <div class="d-flex justify-content-center fs-2 gap-4 p-4">
      <a href="{{ route('galery.index') }}" class="btn btn-primary modern-btn">
        Galeri Lainnya
      </a>
    </div>

  </section>
  <!-- End Portfolio -->

</main> <!-- Tutup Tag Main -->

<!-- Swiper JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


<!-- Modern Millennial Animations CSS -->
<style>
  /* ========== SECTION BADGE ========== */
  .section-badge {
    display: inline-block;
    background: linear-gradient(135deg, #1C6EA4 0%, #2E8BC0 100%);
    color: #ffffff;
    font-size: 14px;
    font-weight: 700;
    font-family: 'Poppins', sans-serif;
    padding: 8px 24px;
    border-radius: 50px;
    margin-bottom: 16px;
    letter-spacing: 2px;
    text-transform: uppercase;
    box-shadow: 0 4px 12px rgba(28, 110, 164, 0.3);
    animation: badgePulse 2s ease-in-out infinite;
  }

  @keyframes badgePulse {

    0%,
    100% {
      transform: scale(1);
      box-shadow: 0 4px 12px rgba(28, 110, 164, 0.3);
    }

    50% {
      transform: scale(1.05);
      box-shadow: 0 6px 16px rgba(28, 110, 164, 0.4);
    }
  }

  /* ========== SECTION TITLE CUSTOM COLORS ========== */
  .section-title h2 {
    color: #1C6EA4 !important;
    margin-top: 12px;
  }

  .section-title h3 {
    color: #2c3e50 !important;
  }

  .section-title h3 span {
    color: #1C6EA4 !important;
  }

  .section-title p {
    color: #7f8c8d !important;
  }

  /* ========== MODERN ANIMATIONS ========== */

  /* Gradient Text Effects */
  .gradient-text {
    background: linear-gradient(135deg, #1C6EA4 0%, #2E8BC0 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: gradientShift 3s ease infinite;
  }

  .gradient-text-alt {
    background: linear-gradient(135deg, #1C6EA4 0%, #145A8C 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  @keyframes gradientShift {

    0%,
    100% {
      filter: hue-rotate(0deg);
    }

    50% {
      filter: hue-rotate(20deg);
    }
  }

  /* Floating Animation */
  .floating-animation {
    animation: floating 3s ease-in-out infinite;
  }

  @keyframes floating {

    0%,
    100% {
      transform: translateY(0px);
    }

    50% {
      transform: translateY(-20px);
    }
  }

  /* Pulse Animation for Buttons */
  .pulse-animation {
    animation: pulse 2s ease-in-out infinite;
    position: relative;
    overflow: hidden;
  }

  .pulse-animation::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
  }

  .pulse-animation:hover::before {
    width: 300px;
    height: 300px;
  }

  @keyframes pulse {

    0%,
    100% {
      box-shadow: 0 0 0 0 rgba(28, 110, 164, 0.7);
    }

    50% {
      box-shadow: 0 0 0 20px rgba(28, 110, 164, 0);
    }
  }

  /* Scroll Animations */
  .animate-on-scroll {
    opacity: 0;
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .animate-on-scroll.animated {
    opacity: 1;
  }

  .animate-on-scroll[data-animation="fade-up"] {
    transform: translateY(50px);
  }

  .animate-on-scroll[data-animation="fade-up"].animated {
    transform: translateY(0);
  }

  .animate-on-scroll[data-animation="slide-left"] {
    transform: translateX(100px);
  }

  .animate-on-scroll[data-animation="slide-left"].animated {
    transform: translateX(0);
  }

  .animate-on-scroll[data-animation="slide-right"] {
    transform: translateX(-100px);
  }

  .animate-on-scroll[data-animation="slide-right"].animated {
    transform: translateX(0);
  }

  .animate-on-scroll[data-animation="zoom-in"] {
    transform: scale(0.8);
  }

  .animate-on-scroll[data-animation="zoom-in"].animated {
    transform: scale(1);
  }

  /* Hover 3D Effect */
  .hover-3d {
    transition: transform 0.3s ease;
    transform-style: preserve-3d;
  }

  .hover-3d:hover {
    transform: perspective(1000px) rotateY(5deg) rotateX(5deg);
  }

  /* Hover Lift Effect */
  .hover-lift {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .hover-lift:hover {
    transform: translateY(-15px) scale(1.05);
    filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.2));
  }

  /* Animated List */
  .animated-list li {
    opacity: 0;
    transform: translateX(-20px);
    animation: slideInList 0.5s ease forwards;
  }

  .animated-list li:nth-child(1) {
    animation-delay: 0.1s;
  }

  .animated-list li:nth-child(2) {
    animation-delay: 0.2s;
  }

  .animated-list li:nth-child(3) {
    animation-delay: 0.3s;
  }

  .animated-list li:nth-child(4) {
    animation-delay: 0.4s;
  }

  @keyframes slideInList {
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }

  /* Modern Button */
  .modern-btn {
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    background: linear-gradient(135deg, #1C6EA4 0%, #2E8BC0 100%);
    border: none;
    color: white !important;
    padding: 12px 32px;
    border-radius: 50px;
    font-weight: 600;
    font-family: 'Poppins', sans-serif;
  }

  .modern-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.5s;
  }

  .modern-btn:hover::before {
    left: 100%;
  }

  .modern-btn:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 10px 30px rgba(28, 110, 164, 0.4);
  }

  /* Parallax Effect */
  .parallax-section {
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
  }

  /* Fade In Text */
  .fade-in-text {
    animation: fadeInText 1s ease-in-out;
  }

  @keyframes fadeInText {
    from {
      opacity: 0;
      transform: translateY(20px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Shimmer Effect */
  .shimmer {
    position: relative;
    overflow: hidden;
  }

  .shimmer::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    animation: shimmer 2s infinite;
  }

  @keyframes shimmer {
    to {
      left: 100%;
    }
  }

  /* Smooth Scroll */
  html {
    scroll-behavior: smooth;
  }

  /* Enhanced Gallery Card Animations */
  .gallery-card {
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .gallery-card:hover {
    transform: translateY(-15px) scale(1.02);
  }

  .gallery-image {
    position: relative;
    overflow: hidden;
  }

  .gallery-image::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.7s;
    z-index: 1;
  }

  .gallery-card:hover .gallery-image::before {
    left: 100%;
  }

  /* Responsive Animations */
  @media (max-width: 768px) {

    .animate-on-scroll[data-animation="slide-left"],
    .animate-on-scroll[data-animation="slide-right"] {
      transform: translateY(30px);
    }

    .animate-on-scroll[data-animation="slide-left"].animated,
    .animate-on-scroll[data-animation="slide-right"].animated {
      transform: translateY(0);
    }

    .hover-3d:hover {
      transform: none;
    }
  }
</style>

<!-- Gallery Carousel Styles -->
<style>
  .gallery-carousel-wrapper {
    padding: 60px 0;
    position: relative;
    overflow: hidden;
    background: #ffffff;
    font-family: 'Poppins', sans-serif;
  }

  .gallerySwiper {
    width: 100%;
    padding: 80px 60px !important;
    overflow: visible;
  }

  .swiper-wrapper {
    align-items: flex-start;
  }

  .gallery-card {
    background: transparent;
    border-radius: 0;
    overflow: visible;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    position: relative;
    width: 100%;
    height: auto;
  }

  /* Staggered Heights - Zig Zag Effect */
  .staggered-0 {
    margin-top: 0;
  }

  .staggered-1 {
    margin-top: 50px;
  }

  .staggered-2 {
    margin-top: 25px;
  }

  .gallery-card:hover {
    transform: translateY(-10px);
  }

  .gallery-image {
    width: 100%;
    height: 320px;
    overflow: hidden;
    background: #f0f0f0;
    position: relative;
    border-radius: 24px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
  }

  .gallery-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .gallery-card:hover .gallery-image {
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
  }

  .gallery-card:hover .gallery-image img {
    transform: scale(1.08);
  }

  .gallery-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 0;
    display: flex;
    align-items: flex-end;
    pointer-events: none;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.85) 100%);
    min-height: 120px;
  }

  .gallery-card:hover .gallery-overlay {
    opacity: 1;
    transform: translateY(0);
  }

  .gallery-caption-box {
    background: transparent;
    backdrop-filter: none;
    border-radius: 0;
    padding: 24px 20px;
    box-shadow: none;
    width: 100%;
    transition: all 0.3s ease;
    border: none;
    font-family: 'Poppins', sans-serif;
  }

  .gallery-card:hover .gallery-caption-box {
    background: transparent;
    box-shadow: none;
  }

  .gallery-title {
    font-size: 16px;
    font-weight: 600;
    color: #ffffff;
    margin: 0 0 8px 0;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    font-family: 'Poppins', sans-serif;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
    letter-spacing: 0.3px;
  }

  .gallery-date {
    font-size: 13px;
    font-weight: 500;
    color: #ffffff;
    margin: 0;
    font-family: 'Poppins', sans-serif;
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
    opacity: 0.95;
    letter-spacing: 0.5px;
  }

  .gallery-empty {
    padding: 80px 20px;
    text-align: center;
    color: #999;
    height: 320px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f0f0f0;
    border-radius: 24px;
    font-family: 'Poppins', sans-serif;
  }

  /* Swiper Navigation Buttons */
  .swiper-button-next,
  .swiper-button-prev {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 50%;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    transition: all 0.3s ease;
  }

  .swiper-button-next:after,
  .swiper-button-prev:after {
    font-size: 20px;
    font-weight: bold;
    color: #2c3e50;
  }

  .swiper-button-next:hover,
  .swiper-button-prev:hover {
    background: #2c3e50;
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
  }

  .swiper-button-next:hover:after,
  .swiper-button-prev:hover:after {
    color: #fff;
  }

  /* Responsive */
  @media (min-width: 1400px) {
    .gallery-image {
      height: 360px;
    }
  }

  @media (max-width: 1024px) {
    .gallerySwiper {
      padding: 60px 50px !important;
    }

    .staggered-0,
    .staggered-1,
    .staggered-2 {
      margin-top: 0;
    }

    .gallery-image {
      height: 300px;
    }
  }

  @media (max-width: 768px) {
    .gallerySwiper {
      padding: 50px 40px !important;
    }

    .gallery-image {
      height: 280px;
    }

    .swiper-button-next,
    .swiper-button-prev {
      width: 42px;
      height: 42px;
    }

    .swiper-button-next:after,
    .swiper-button-prev:after {
      font-size: 16px;
    }

    .gallery-overlay {
      min-height: 100px;
    }

    .gallery-caption-box {
      padding: 20px 16px;
    }

    .gallery-title {
      font-size: 14px;
    }

    .gallery-date {
      font-size: 12px;
    }
  }

  @media (max-width: 480px) {
    .gallerySwiper {
      padding: 40px 30px !important;
    }

    .gallery-image {
      height: 260px;
    }

    .gallery-overlay {
      min-height: 90px;
      padding: 0;
    }

    .gallery-caption-box {
      padding: 18px 14px;
    }
  }
</style>

<!-- Initialize Swiper -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Swiper Initialization
    const swiper = new Swiper('.gallerySwiper', {
      slidesPerView: 1,
      spaceBetween: 25,
      centeredSlides: false,
      loop: true,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      },
      speed: 1000,
      effect: 'slide',
      grabCursor: true,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints: {
        640: {
          slidesPerView: 2,
          spaceBetween: 20,
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 25,
        },
        1400: {
          slidesPerView: 4,
          spaceBetween: 30,
        },
      },
    });

    // ========== SCROLL ANIMATIONS ==========
    const animateOnScroll = () => {
      const elements = document.querySelectorAll('.animate-on-scroll');

      elements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const elementBottom = element.getBoundingClientRect().bottom;
        const windowHeight = window.innerHeight;

        // Trigger animation when element is 80% visible
        if (elementTop < windowHeight * 0.8 && elementBottom > 0) {
          const delay = element.getAttribute('data-delay') || 0;
          setTimeout(() => {
            element.classList.add('animated');
          }, delay);
        }
      });
    };

    // Run on scroll
    window.addEventListener('scroll', animateOnScroll);

    // Run on load
    animateOnScroll();

    // ========== PARALLAX EFFECT ==========
    window.addEventListener('scroll', () => {
      const scrolled = window.pageYOffset;
      const parallaxElements = document.querySelectorAll('.floating-animation');

      parallaxElements.forEach(element => {
        const speed = 0.5;
        element.style.transform = `translateY(${scrolled * speed}px)`;
      });
    });

    // ========== SMOOTH SCROLL FOR LINKS ==========
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href !== '#' && document.querySelector(href)) {
          e.preventDefault();
          document.querySelector(href).scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });

    // ========== MOUSE MOVE 3D EFFECT ==========
    const hover3DElements = document.querySelectorAll('.hover-3d');

    hover3DElements.forEach(element => {
      element.addEventListener('mousemove', (e) => {
        const rect = element.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const centerX = rect.width / 2;
        const centerY = rect.height / 2;

        const rotateX = (y - centerY) / 10;
        const rotateY = (centerX - x) / 10;

        element.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.05)`;
      });

      element.addEventListener('mouseleave', () => {
        element.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale(1)';
      });
    });

    // ========== INTERSECTION OBSERVER FOR BETTER PERFORMANCE ==========
    if ('IntersectionObserver' in window) {
      const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
      };

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('animated');
            observer.unobserve(entry.target);
          }
        });
      }, observerOptions);

      document.querySelectorAll('.animate-on-scroll').forEach(element => {
        observer.observe(element);
      });
    }

    // ========== LOADING ANIMATION ==========
    window.addEventListener('load', () => {
      document.body.classList.add('loaded');
    });
  });
</script>

<!-- ======= Services Section ======= -->
<section id="service" class="services section-bg">
  <div class="container" data-aos="fade-up">

    <div class="section-title">
      <h2>Program Kerja</h2>
      <h3>Program Kerja PKK <span>Kabupaten Nganjuk</span></h3>
      <p>Program Kerja yang akan dikerjakan Ketua PKK Kabupaten Nganjuk.</p>
    </div>

    <div class="row gy-4">

      <!-- Card 1 -->
      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="program-card">
          <div class="program-card-img">
            <img src="{{ asset('frontend/assets/img/l.jpg') }}" class="img-fluid" alt="">
            <div class="program-overlay"></div>
          </div>
          <div class="program-content">
            <h3>
              <a href="{{ route('pokja.index') }}" class="stretched-link">
                Kelompok Kerja 1
              </a>
            </h3>
            <p>
              Membidangi Pembinaan Karakter dalam Keluarga...
            </p>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="program-card">
          <div class="program-card-img">
            <img src="{{ asset('frontend/assets/img/p.jpeg') }}" class="img-fluid" alt="">
            <div class="program-overlay"></div>
          </div>
          <div class="program-content">
            <h3>
              <a href="{{ route('pokjathu.index') }}" class="stretched-link">
                Kelompok Kerja 2
              </a>
            </h3>
            <p>
              Membidangi Pendidikan & Peningkatan Ekonomi Keluarga...
            </p>
          </div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
        <div class="program-card">
          <div class="program-card-img">
            <img src="{{ asset('frontend/assets/img/t.jpeg') }}" class="img-fluid" alt="">
            <div class="program-overlay"></div>
          </div>
          <div class="program-content">
            <h3>
              <a href="{{ route('pokjatre.index') }}" class="stretched-link">
                Kelompok Kerja 3
              </a>
            </h3>
            <p>
              Membidangi penguatan ketahanan keluarga...
            </p>
          </div>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="500">
        <div class="program-card">
          <div class="program-card-img">
            <img src="{{ asset('frontend/assets/img/i.jpeg') }}" class="img-fluid" alt="">
            <div class="program-overlay"></div>
          </div>
          <div class="program-content">
            <h3>
              <a href="{{ route('pokjafou.index') }}" class="stretched-link">
                Kelompok Kerja 4
              </a>
            </h3>
            <p>
              Membidangi Kesehatan Keluarga dan Lingkungan...
            </p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
<!-- End Services -->

<!-- Modern Program Card Styles -->
<style>
  .program-card {
    background: #ffffff;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
  }

  .program-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 16px 48px rgba(28, 110, 164, 0.2);
  }

  .program-card-img {
    width: 100%;
    height: 240px;
    overflow: hidden;
    position: relative;
  }

  .program-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .program-card:hover .program-card-img img {
    transform: scale(1.15);
  }

  .program-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, transparent 0%, rgba(28, 110, 164, 0.7) 100%);
    opacity: 0;
    transition: opacity 0.4s ease;
  }

  .program-card:hover .program-overlay {
    opacity: 1;
  }

  .program-content {
    padding: 28px 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  .program-content h3 {
    font-size: 20px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 12px;
    font-family: 'Poppins', sans-serif;
    line-height: 1.4;
  }

  .program-content h3 a {
    color: #2c3e50;
    text-decoration: none;
    transition: color 0.3s ease;
    position: relative;
  }

  .program-content h3 a::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 0;
    width: 0;
    height: 3px;
    background: linear-gradient(135deg, #1C6EA4 0%, #2E8BC0 100%);
    transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 2px;
  }

  .program-card:hover .program-content h3 a {
    color: #1C6EA4;
  }

  .program-card:hover .program-content h3 a::after {
    width: 100%;
  }

  .program-content p {
    font-size: 14px;
    color: #7f8c8d;
    line-height: 1.6;
    margin: 0;
    font-family: 'Poppins', sans-serif;
  }

  /* Responsive */
  @media (max-width: 992px) {
    .program-card-img {
      height: 220px;
    }

    .program-content {
      padding: 24px 20px;
    }

    .program-content h3 {
      font-size: 18px;
    }
  }

  @media (max-width: 768px) {
    .program-card {
      border-radius: 20px;
    }

    .program-card-img {
      height: 200px;
    }

    .program-content {
      padding: 20px 18px;
    }

    .program-content h3 {
      font-size: 17px;
    }

    .program-content p {
      font-size: 13px;
    }
  }
</style>

</main>
<!-- End Main -->

@endsection