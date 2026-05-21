<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>TP - PKK Kabupaten Nganjuk</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset ('frontend/assets/img/favicon.png')}}" rel="icon">
  <link href="{{ asset ('frontend/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset ('frontend/assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{ asset ('frontend/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset ('frontend/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ asset ('frontend/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{ asset ('frontend/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{ asset ('frontend/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset ('frontend/assets/css/style.css')}}" rel="stylesheet">

  <style>
    /* ===== KONSISTENSI WARNA BUTTON BIRU ===== */
    :root {
      --bs-primary: #016AA3;
      --bs-primary-rgb: 1, 106, 163;
    }
    .btn-primary {
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
    /* ===== END BUTTON ===== */
  </style>
</head>

<body>

  @include('frontend/layouts.navbar')

  @yield('content')


  <!-- ======= Footer ======= -->
  <footer id="footer" style="background-color: #07304A !important; padding: 0;">

    <div class="footer-top" style="background-color: #07304A !important; padding: 45px 0 35px 0;">
      <div class="container">
        <div class="row align-items-center justify-content-between">

          <!-- Kolom 1: Judul + Alamat -->
          <div class="col-lg-4 col-md-4 mb-3 mb-lg-0">
            <h3 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 16px; color: #fff; margin-bottom: 18px; line-height: 1.6;">
              Pemberdayaan Kesejahteraan Keluarga<br>Kabupaten Nganjuk
            </h3>
            
            <p style="font-family: 'Poppins', sans-serif; font-size: 13px; color: #d0d0d0; line-height: 1.7; margin-bottom: 0; font-weight: 400;">
              Jl. Dermojoyo No.21, Payaman, Kec. Nganjuk,<br>Kabupaten Nganjuk, Jawa Timur 64418
            </p>
          </div>

          <!-- Kolom 2: Kontak -->
          <div class="col-lg-3 col-md-3 mb-3 mb-lg-0">
            <h4 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 16px; color: #fff; margin-bottom: 18px;">Kontak :</h4>
            <div style="font-family: 'Poppins', sans-serif; font-size: 13px; color: #d0d0d0; line-height: 2; font-weight: 400;">
              <p style="margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-telephone-fill" style="color: #fff; font-size: 14px;"></i> 
                <span>087754215178</span>
              </p>
              <p style="margin-bottom: 0; display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-envelope-fill" style="color: #fff; font-size: 14px;"></i> 
                <span>admin@pkk-nganjuk.my.id</span>
              </p>
            </div>
          </div>

          <!-- Kolom 3: Lokasi PKK dengan Maps -->
          <div class="col-lg-3 col-md-3">
            <div style="background: #fff; border-radius: 12px; overflow: hidden; padding: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.25);">
              <a href="https://maps.app.goo.gl/37AmTwodTWA6hius7" target="_blank" style="display: block;">
                <iframe 
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.9876543210987!2d111.90345678901234!3d-7.603456789012345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7856f123456789%3A0x1234567890abcdef!2sJl.%20Dermojoyo%20No.21%2C%20Payaman%2C%20Kec.%20Nganjuk%2C%20Kabupaten%20Nganjuk%2C%20Jawa%20Timur%2064418!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid" 
                  width="100%" 
                  height="110" 
                  style="border:0; border-radius: 6px; display: block;" 
                  allowfullscreen="" 
                  loading="lazy" 
                  referrerpolicy="no-referrer-when-downgrade">
                </iframe>
              </a>
              <p style="font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 600; color: #07304A; text-align: center; margin: 8px 0 0 0;">
                Lokasi PKK
              </p>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Garis Pemisah -->
    <div style="border-top: 1px solid rgba(255,255,255,0.2); margin: 0;"></div>

    <!-- Copyright Bar -->
    <div style="background-color: #07304A; padding: 16px 0;">
      <div class="container">
        <div class="text-center">
          <p style="font-family: 'Poppins', sans-serif; font-size: 13px; color: #b0b0b0; margin: 0; font-weight: 400;">
            <i class="bi bi-c-circle" style="font-size: 12px;"></i> 2026 PKK Kab. Nganjuk. All Rights Reserved.
          </p>
        </div>
      </div>
    </div>

  </footer><!-- End Footer -->

  <style>
    /* Override footer background color */
    #footer,
    #footer .footer-top {
      background-color: #07304A !important;
    }
    
    #footer .footer-links a:hover {
      color: #4fc3f7 !important;
    }
  </style>

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset ('frontend/assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
  <script src="{{ asset ('frontend/assets/vendor/aos/aos.js')}}"></script>
  <script src="{{ asset ('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset ('frontend/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{ asset ('frontend/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{ asset ('frontend/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{ asset ('frontend/assets/vendor/waypoints/noframework.waypoints.js')}}"></script>
  <script src="{{ asset ('frontend/assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset ('frontend/assets/js/main.js')}}"></script>

  <script>
    const lines = [
      "Pemberdayaan",
      "Kesejahteraan",
      "Keluarga"
    ];

    const sub = "Kabupaten Nganjuk";

    let fullText = lines.join("\n");

    let i = 0;
    let subIndex = 0;

    let phase = "typingMain";
    // typingMain → typingSub → deletingSub → deletingMain

    const speed = 80;
    const deleteSpeed = 40;
    const delay = 1200;

    function typeEffect() {
      const el = document.getElementById("typing-text");
      const subEl = document.getElementById("typing-sub");

      // =======================
      // 1. NGETIK TEXT UTAMA
      // =======================
      if (phase === "typingMain") {
        el.innerHTML = fullText.substring(0, i).replace(/\n/g, "<br>");
        i++;

        if (i > fullText.length) {
          phase = "typingSub";
          setTimeout(typeEffect, 300);
          return;
        }

        setTimeout(typeEffect, speed);
      }

      // =======================
      // 2. NGETIK SUB
      // =======================
      else if (phase === "typingSub") {
        subEl.innerHTML = sub.substring(0, subIndex);
        subIndex++;

        if (subIndex > sub.length) {
          phase = "deletingSub";
          setTimeout(typeEffect, delay);
          return;
        }

        setTimeout(typeEffect, speed);
      }

      // =======================
      // 3. HAPUS SUB DULU
      // =======================
      else if (phase === "deletingSub") {
        subEl.innerHTML = sub.substring(0, subIndex);
        subIndex--;

        if (subIndex < 0) {
          phase = "deletingMain";
          setTimeout(typeEffect, 300);
          return;
        }

        setTimeout(typeEffect, deleteSpeed);
      }

      // =======================
      // 4. HAPUS TEXT UTAMA
      // =======================
      else if (phase === "deletingMain") {
        el.innerHTML = fullText.substring(0, i).replace(/\n/g, "<br>");
        i--;

        if (i < 0) {
          // RESET
          phase = "typingMain";
          i = 0;
          subIndex = 0;
          setTimeout(typeEffect, 300);
          return;
        }

        setTimeout(typeEffect, deleteSpeed);
      }
    }

    typeEffect();
  </script>
  <!-- About -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {

      const elements = document.querySelectorAll('.app-section, #about');

      function revealOnScroll() {
        const windowHeight = window.innerHeight;

        elements.forEach(el => {
          const position = el.getBoundingClientRect().top;

          if (position < windowHeight - 100) {
            el.classList.add("active");
          }
        });
      }

      window.addEventListener("scroll", revealOnScroll);
    });
  </script>
  <!-- Gambar -->
  <script>
    const appImg = document.querySelector('.app-img img');

    if (appImg) {
      setInterval(() => {
        appImg.style.transform = "translateY(-10px)";
        setTimeout(() => {
          appImg.style.transform = "translateY(0)";
        }, 800);
      }, 2000);
    }
  </script>
  <!-- Ketua -->
  <script>
    const ketua = document.querySelector('.img-box img');

    if (ketua) {
      ketua.addEventListener('mouseenter', () => {
        ketua.style.transform = "scale(1.05)";
      });

      ketua.addEventListener('mouseleave', () => {
        ketua.style.transform = "scale(1)";
      });
    }
  </script>
  <!-- Button Slied -->
  <script>
    function scrollGaleri(direction) {
      const container = document.querySelector('.galeri-slider');
      container.scrollBy({
        left: direction * 300,
        behavior: 'smooth'
      });
    }
  </script>
  <script>
    document.querySelectorAll('.galeri-item').forEach(item => {
      item.addEventListener('click', () => {
        item.classList.toggle('active');
      });
    });

    const slider = document.querySelector('.portfolio-slider');

    let isDown = false;
    let startX;
    let scrollLeft;

    slider.addEventListener('mousedown', (e) => {
      isDown = true;
      startX = e.pageX - slider.offsetLeft;
      scrollLeft = slider.scrollLeft;
    });

    slider.addEventListener('mouseleave', () => isDown = false);
    slider.addEventListener('mouseup', () => isDown = false);

    slider.addEventListener('mousemove', (e) => {
      if (!isDown) return;
      e.preventDefault();
      const x = e.pageX - slider.offsetLeft;
      const walk = (x - startX) * 2;
      slider.scrollLeft = scrollLeft - walk;
    });
  </script>

  {{-- Auto-dismiss semua alert session (success/error/warning/info) setelah 3 detik --}}
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const alerts = document.querySelectorAll('.alert-success, .alert-warning, .alert-info');
      alerts.forEach(function (alert) {
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

</body>

</html>