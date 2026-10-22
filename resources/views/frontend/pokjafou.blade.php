@extends('frontend/layouts.template')

@section('content')

{{-- CSS Khusus Pokja 4 (Scoped di bawah .pokja) --}}
<link rel="stylesheet" href="{{ asset('css/pokja.css') }}?v={{ filemtime(public_path('css/pokja.css')) }}">

<div class="pokja">
  <div class="pokja-container">

    <!-- 1. BANNER UTAMA -->
    <section class="pokja-banner" aria-label="Banner Kelompok Kerja 4">
      <div class="pokja-banner-text">
        <h1 class="pokja-banner-title">Kelompok Kerja 4 (Pokja 4)</h1>
        <p class="pokja-banner-desc">
          Membidangi Kesehatan Keluarga dan Lingkungan, diantaranya mengelola program kesehatan, kelestarian lingkungan hidup dan perencanaan sehat.
        </p>
      </div>
      <div class="pokja-banner-logo-box">
        <img src="{{ asset('frontend/assets/img/favicon.png') }}" alt="Logo PKK Kabupaten Nganjuk" width="80" height="80">
      </div>
    </section>

    <!-- 2. MISI POKJA 4 -->
    <section class="pokja-box" aria-label="Misi Pokja 4">
      <div class="pokja-visi-wrap">
        <div class="pokja-icon-circle" aria-hidden="true">
          <!-- Ikon Misi / Kesehatan -->
          <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
          </svg>
        </div>
        <div class="pokja-visi-content">
          <div class="pokja-visi-label">Misi Pokja 4</div>
          <p class="pokja-visi-text">
            Menciptakan keluarga sehat melalui pembiasaan <strong class="pokja-highlight">pola hidup bersih dan sehat</strong>, peningkatan <strong class="pokja-highlight">kelestarian lingkungan hidup</strong> dan <strong class="pokja-highlight">perencanaan sehat</strong>.
          </p>
        </div>
      </div>
    </section>

    <!-- 3. PROGRAM POKOK POKJA 4 -->
    <section class="pokja-box" aria-label="Program Pokok Pokja 4">
      <h2 class="pokja-box-title">Program pokok Pokja 4</h2>
      <div class="pokja-grid-3">
        
        <!-- Kartu Program 1 -->
        <div class="pokja-card pokja-program-card">
          <div class="pokja-icon-circle" aria-hidden="true">
            <!-- Ikon Kesehatan / Detak Jantung -->
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
            </svg>
          </div>
          <div class="pokja-card-body">
            <h3 class="pokja-card-title">Kesehatan</h3>
            <p class="pokja-card-desc">
              Membina Perilaku Hidup Bersih dan Sehat (PHBS), revitalisasi posyandu, keluarga sadar gizi (KADARZI), dan pencegahan penyakit menular.
            </p>
          </div>
        </div>

        <!-- Kartu Program 2 -->
        <div class="pokja-card pokja-program-card">
          <div class="pokja-icon-circle" aria-hidden="true">
            <!-- Ikon Kelestarian Lingkungan / Daun -->
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"></path>
              <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"></path>
            </svg>
          </div>
          <div class="pokja-card-body">
            <h3 class="pokja-card-title">Kelestarian Lingkungan Hidup</h3>
            <p class="pokja-card-desc">
              Pengelolaan sanitasi jamban &amp; SPAL, pemilahan sampah organik/anorganik, pemanfaatan biopori, serta gerakan tanam dan pelihara pohon.
            </p>
          </div>
        </div>

        <!-- Kartu Program 3 -->
        <div class="pokja-card pokja-program-card">
          <div class="pokja-icon-circle" aria-hidden="true">
            <!-- Ikon Perencanaan Sehat / Masa Depan -->
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <circle cx="12" cy="12" r="10"></circle>
              <polyline points="12 6 12 12 14 14"></polyline>
            </svg>
          </div>
          <div class="pokja-card-body">
            <h3 class="pokja-card-title">Perencanaan Sehat</h3>
            <p class="pokja-card-desc">
              Penguatan program Keluarga Berencana (KB), membudayakan hidup hemat dan gemar menabung, serta menjaga keseimbangan finansial rumah tangga.
            </p>
          </div>
        </div>

      </div>
    </section>

    <!-- 4. PITA STATISTIK -->
    <section class="pokja-stats-ribbon" aria-label="Statistik Pokja 4">
      <div class="pokja-stat-item">
        <div class="pokja-stat-number">3</div>
        <div class="pokja-stat-label">Program pokok</div>
      </div>
      <div class="pokja-stat-item">
        <div class="pokja-stat-number">8</div>
        <div class="pokja-stat-label">Tugas</div>
      </div>
      <div class="pokja-stat-item">
        <div class="pokja-stat-number">12</div>
        <div class="pokja-stat-label">Prioritas kesehatan</div>
      </div>
      <div class="pokja-stat-item">
        <div class="pokja-stat-number">16</div>
        <div class="pokja-stat-label">Lingkungan &amp; perencanaan</div>
      </div>
    </section>

    <!-- 5. TUGAS POKJA 4 -->
    <section class="pokja-box" aria-label="Daftar Tugas Pokja 4">
      <div class="pokja-tugas-header">
        <h2 class="pokja-tugas-title">Tugas Pokja 4</h2>
        <p class="pokja-tugas-subtitle">Pokja 4 memiliki 8 tugas pokok pelaksanaan program.</p>
      </div>

      <div class="pokja-tugas-container">
        <!-- Tugas 01 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">01</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Tujuan pembangunan milenium (MDGs)</h3>
            <p class="pokja-tugas-item-desc">
              Meningkatkan pencapaian tujuan pembangunan millennium.
            </p>
          </div>
        </div>

        <!-- Tugas 02 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">02</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Budaya Perilaku Hidup Bersih dan Sehat (PHBS)</h3>
            <p class="pokja-tugas-item-desc">
              Meningkatkan budaya Perilaku Hidup Bersih dan Sehat (PHBS).
            </p>
          </div>
        </div>

        <!-- Tugas 03 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">03</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Pembinaan kegiatan Posyandu</h3>
            <p class="pokja-tugas-item-desc">
              Mengembangkan dan membina pelaksanaan kegiatan POSYANDU.
            </p>
          </div>
        </div>

        <!-- Tugas 04 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">04</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Sistem Informasi Posyandu (SIP)</h3>
            <p class="pokja-tugas-item-desc">
              Memonitor pelaksanaan Sistem Informasi Posyandu (SIP).
            </p>
          </div>
        </div>

        <!-- Tugas 05 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">05</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Pencatatan kesehatan ibu dan anak</h3>
            <p class="pokja-tugas-item-desc">
              Melaksanakan pencatatan Ibu hamil, melahirkan, nifas, ibu meninggal, kelahiran dan kematian bayi dan balita.
            </p>
          </div>
        </div>

        <!-- Tugas 06 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">06</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Kelestarian lingkungan &amp; tanam pohon</h3>
            <p class="pokja-tugas-item-desc">
              Tanam dan pelihara pohon dalam rangka mewujudkan kelestarian lingkungan.
            </p>
          </div>
        </div>

        <!-- Tugas 07 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">07</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Keluarga berkualitas &amp; program KB</h3>
            <p class="pokja-tugas-item-desc">
              Mewujudkan keluarga kecil, bahagia, sejahtera dengan melaksanakan program KB agar tercapai generasi yang sehat, cerdas dan tangguh.
            </p>
          </div>
        </div>

        <!-- Tugas 08 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">08</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Budaya hidup hemat &amp; menabung</h3>
            <p class="pokja-tugas-item-desc">
              Meningkatkan pengetahuan tentang budaya hidup hemat, membudayakan kebiasaan menabung dan melaksanakan tatalaksana keuangan keluarga dalam rangka mendukung perencanaan sehat.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- 6. PRIORITAS PROGRAM: KESEHATAN -->
    <section class="pokja-box" aria-label="Prioritas Program Kesehatan">
      <h2 class="pokja-box-title">Prioritas program: Kesehatan</h2>
      <p class="pokja-gotong-intro">
        Fokus utama pada penurunan angka stunting dan gizi buruk balita, imunisasi lengkap, kesehatan ibu dan anak, serta penguatan posyandu dan UKS.
      </p>

      <div class="pokja-grid-2">
        <!-- Sehat 1 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon KADARZI -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M12 6v6l4 2"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Keluarga Sadar Gizi (KADARZI)</h3>
                <span class="pokja-badge">KADARZI</span>
              </div>
              <p class="pokja-card-desc">
                Memantapkan Keluarga Sadar Gizi (KADARZI) dalam upaya menurunkan prefalensi anak balita kurang gizi.
              </p>
            </div>
          </div>
        </div>

        <!-- Sehat 2 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon PMT-AS -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                <line x1="6" y1="1" x2="6" y2="4"></line>
                <line x1="10" y1="1" x2="10" y2="4"></line>
                <line x1="14" y1="1" x2="14" y2="4"></line>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Makanan Tambahan Anak Sekolah</h3>
                <span class="pokja-badge">PMT-AS</span>
              </div>
              <p class="pokja-card-desc">
                Penyediaan Makanan Tambahan bagi Anak Sekolah (PMT-AS).
              </p>
            </div>
          </div>
        </div>

        <!-- Sehat 3 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon PHBS -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Pembiasaan PHBS Sehari-hari</h3>
                <span class="pokja-badge">PHBS</span>
              </div>
              <p class="pokja-card-desc">
                Menjadikan PHBS sebagai kebiasaan hidup sehari-hari.
              </p>
            </div>
          </div>
        </div>

        <!-- Sehat 4 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon UKS -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Usaha Kesehatan Sekolah</h3>
                <span class="pokja-badge">UKS</span>
              </div>
              <p class="pokja-card-desc">
                Usaha Kesehatan Sekolah.
              </p>
            </div>
          </div>
        </div>

        <!-- Sehat 5 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon LIL Imunisasi -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <polyline points="20 6 9 17 4 12"></polyline>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Lima Imunisasi Dasar Lengkap</h3>
                <span class="pokja-badge">LIL RUTIN</span>
              </div>
              <p class="pokja-card-desc">
                Membudayakan Lima Imunisasi Dasar Lengkap (LIL) dan rutin untuk menurunkan angka kematian anak dan ibu.
              </p>
            </div>
          </div>
        </div>

        <!-- Sehat 6 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon PUS & Kontrasepsi -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Kesadaran Alat Kontrasepsi (PUS)</h3>
                <span class="pokja-badge">PUS / KB</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan kesadaran Pasangan Usia Subur (PUS) tentang manfaat pemakaian alat kontrasepsi.
              </p>
            </div>
          </div>
        </div>

        <!-- Sehat 7 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Penyakit Menular -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Pencegahan Penyakit Menular &amp; Tidak Menular</h3>
                <span class="pokja-badge">PENYULUHAN</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan penyuluhan pencegahan penyakit menular dan tidak menular.
              </p>
            </div>
          </div>
        </div>

        <!-- Sehat 8 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Tanam Pohon Lingkungan -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 22v-8"></path>
                <path d="M9 14l3-3 3 3"></path>
                <path d="M4 14l8-8 8 8"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Tanam Pohon &amp; Mitigasi Pemanasan Global</h3>
                <span class="pokja-badge">PENGHIJAUAN</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan tanam dan pelihara pohon dalam upaya kelestarian lingkungan hidup, mengurangi dampak global warming (pemanasan global).
              </p>
            </div>
          </div>
        </div>

        <!-- Sehat 9 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon AKI AKB AKBAL -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Penurunan Angka Kematian Ibu &amp; Bayi</h3>
                <span class="pokja-badge">AKI / AKB / AKBAL</span>
              </div>
              <p class="pokja-card-desc">
                Mendorong swadaya masyarakat dalam upaya penurunan Angka Kematian Ibu (AKI), Angka Kematian Bayi (AKB), Angka Kematian Balita (AKBAL).
              </p>
            </div>
          </div>
        </div>

        <!-- Sehat 10 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Administrasi Kependudukan -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Tertib Administrasi Kependudukan</h3>
                <span class="pokja-badge">ADMINDUK</span>
              </div>
              <p class="pokja-card-desc">
                Pemahaman tertib administrasi dalam rangka meningkatkan dan mewujudkan tertib administrasi kependudukan di keluarga.
              </p>
            </div>
          </div>
        </div>

        <!-- Sehat 11 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Posyandu -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <polyline points="16 11 18 13 22 9"></polyline>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Optimalisasi Posyandu Terpadu</h3>
                <span class="pokja-badge">POSYANDU</span>
              </div>
              <p class="pokja-card-desc">
                Optimalisasi Posyandu.
              </p>
            </div>
          </div>
        </div>

        <!-- Sehat 12 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Kemampuan Keluarga -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Peningkatan Kapasitas &amp; Kemampuan Keluarga</h3>
                <span class="pokja-badge">KAPASITAS</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan pengetahuan dan kemampuan keluarga.
              </p>
            </div>
          </div>
        </div>

      </div>

      <!-- Kotak Catatan Singkatan Kesehatan -->
      <div class="pokja-prioritas-note">
        <strong>Arti singkatan:</strong> PHBS = Perilaku Hidup Bersih dan Sehat. KADARZI = Keluarga Sadar Gizi. LIL = Lima Imunisasi Dasar Lengkap. PUS = Pasangan Usia Subur. AKI = Angka Kematian Ibu. AKB = Angka Kematian Bayi. AKBAL = Angka Kematian Balita. UKS = Usaha Kesehatan Sekolah.
      </div>
    </section>

    <!-- 7. PRIORITAS PROGRAM: KELESTARIAN LINGKUNGAN HIDUP -->
    <section class="pokja-box" aria-label="Kelestarian Lingkungan Hidup">
      <h2 class="pokja-box-title">Kelestarian Lingkungan Hidup</h2>
      <p class="pokja-gotong-intro">
        Mewujudkan permukiman yang bersih, sehat, dan asri melalui pemeliharaan jamban sehat, pemilahan sampah dan limbah, biopori, serta penghijauan kota.
      </p>

      <div class="pokja-grid-2">
        <!-- Lingkungan 1 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Kebersihan Jamban & SPAL -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Kamar Mandi, Jamban &amp; SPAL Sehat</h3>
                <span class="pokja-badge">SANITASI SPAL</span>
              </div>
              <p class="pokja-card-desc">
                Lingkungan Bersih dan Sehat - Menanamkan kesadaran tentang kebersihan pengelolaan kamar mandi dan jamban keluarga, Saluran Pembuangan Air Limbah (SPAL).
              </p>
            </div>
          </div>
        </div>

        <!-- Lingkungan 2 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Pemilahan Sampah -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Pemilahan Sampah Organik &amp; Limbah B3</h3>
                <span class="pokja-badge">PILAH SAMPAH</span>
              </div>
              <p class="pokja-card-desc">
                Menanamkan kebiasaan memilah sampah organik dan non organik serta Bahan Berbahaya dan Beracun (B3) di tempat yang benar.
              </p>
            </div>
          </div>
        </div>

        <!-- Lingkungan 3 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Daur Ulang -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <polyline points="23 4 23 10 17 10"></polyline>
                <polyline points="1 20 1 14 7 14"></polyline>
                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Daur Ulang Limbah Rumah Tangga</h3>
                <span class="pokja-badge">DAUR ULANG</span>
              </div>
              <p class="pokja-card-desc">
                Mendaur ulang limbah.
              </p>
            </div>
          </div>
        </div>

        <!-- Lingkungan 4 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Lomba LBS -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                <path d="M4 22h16"></path>
                <path d="M6 4h12a2 2 0 0 1 2 2v3a6 6 0 0 1-6 6h0a6 6 0 0 1-6-6V6a2 2 0 0 1 2-2z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Lomba Lingkungan Bersih dan Sehat</h3>
                <span class="pokja-badge">LOMBA LBS</span>
              </div>
              <p class="pokja-card-desc">
                Mengadakan lomba/ Pelaksana Terbaik Lingkungan Bersih dan Sehat.
              </p>
            </div>
          </div>
        </div>

        <!-- Lingkungan 5 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Air Bersih -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Pengadaan &amp; Penghematan Air Bersih</h3>
                <span class="pokja-badge">AIR BERSIH</span>
              </div>
              <p class="pokja-card-desc">
                Peningkatan pengetahuan tentang pengadaan, pemakaian dan penghematan air bersih dan sehat dalam keluarga.
              </p>
            </div>
          </div>
        </div>

        <!-- Lingkungan 6 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Konservasi Lingkungan -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="2" y1="12" x2="22" y2="12"></line>
                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Kelestarian Lingkungan Hidup Menyeluruh</h3>
                <span class="pokja-badge">KONSERVASI</span>
              </div>
              <p class="pokja-card-desc">
                Kelestarian Lingkungan Hidup.
              </p>
            </div>
          </div>
        </div>

        <!-- Lingkungan 7 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Health Cities -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Kualitas Permukiman &amp; Health Cities</h3>
                <span class="pokja-badge">HEALTH CITIES</span>
              </div>
              <p class="pokja-card-desc">
                Pengembangan kualitas lingkungan dan pemukiman, kebersihan dan kesehatan, pada pemukiman yang padat, dalam rangka terwujudnya kota bersih dan sehat (Health Cities).
              </p>
            </div>
          </div>
        </div>

        <!-- Lingkungan 8 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Pencegahan Banjir / Pohon -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 22v-8"></path>
                <path d="M4 14l8-8 8 8"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Pencegahan Banjir &amp; Program Sejuta Pohon</h3>
                <span class="pokja-badge">SEJUTA POHON</span>
              </div>
              <p class="pokja-card-desc">
                Pencegahan banjir dengan tidak menebang pohon sembarangan. Program sejuta pohon sebagai paru-paru kota dan pencegahan polusi udara.
              </p>
            </div>
          </div>
        </div>

        <!-- Lingkungan 9 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Indonesia Sehat -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Pemanfaatan Jamban Sehat Mandiri</h3>
                <span class="pokja-badge">INDONESIA SEHAT</span>
              </div>
              <p class="pokja-card-desc">
                Pemanfaatan jamban dan air bersih dalam rangka mewujudkan Indonesia Sehat.
              </p>
            </div>
          </div>
        </div>

        <!-- Lingkungan 10 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Biopori -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="10"></circle>
                <circle cx="12" cy="12" r="4"></circle>
                <line x1="4.93" y1="4.93" x2="9.17" y2="9.17"></line>
                <line x1="14.83" y1="14.83" x2="19.07" y2="19.07"></line>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Pemasyarakatan Lubang Resapan Biopori</h3>
                <span class="pokja-badge">BIOPORI</span>
              </div>
              <p class="pokja-card-desc">
                Memasyarakatkan biopori (lubang resapan) untuk mencegah genangan dan resapan air.
              </p>
            </div>
          </div>
        </div>

      </div>

      <!-- Kotak Catatan Singkatan Lingkungan -->
      <div class="pokja-prioritas-note">
        <strong>Arti singkatan:</strong> SPAL = Saluran Pembuangan Air Limbah. B3 = Bahan Berbahaya dan Beracun. LBS = Lingkungan Bersih dan Sehat. Health Cities = Kota Sehat. Biopori = Lubang Resapan Air.
      </div>
    </section>

    <!-- 8. PRIORITAS PROGRAM: PERENCANAAN SEHAT -->
    <section class="pokja-box" aria-label="Perencanaan Sehat">
      <h2 class="pokja-box-title">Perencanaan Sehat</h2>
      <p class="pokja-gotong-intro">
        Mendorong terwujudnya masa depan keluarga sejahtera dan berketahanan melalui perencanaan keluarga berencana, budaya menabung, serta kesehatan reproduksi.
      </p>

      <div class="pokja-grid-2">
        <!-- Rencana 1 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon KB Berkualitas -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Partisipasi Program KB Berkualitas</h3>
                <span class="pokja-badge">PROGRAM KB</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan penyuluhan tentang pentingnya pemahaman dan kesertaan dalam program keluarga berencana menuju keluarga berkualitas.
              </p>
            </div>
          </div>
        </div>

        <!-- Rencana 2 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Menabung -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Perencanaan Masa Depan &amp; Menabung</h3>
                <span class="pokja-badge">GEMAR MENABUNG</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan kemampuan perencanaan kehidupan keluarga sehari-hari dengan berorientasi pada masa depan dengan cara membiasakan menabung.
              </p>
            </div>
          </div>
        </div>

        <!-- Rencana 3 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Kesatuan Gerak KB-KES -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <line x1="19" y1="8" x2="19" y2="14"></line>
                <line x1="22" y1="11" x2="16" y2="11"></line>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Kesatuan Gerak PKK KB-KES</h3>
                <span class="pokja-badge">KB-KES</span>
              </div>
              <p class="pokja-card-desc">
                Kegiatan Kesatuan Gerak PKK KB-KES dalam upaya meningkatkan cakupan hasil pelayanan KB-KES.
              </p>
            </div>
          </div>
        </div>

        <!-- Rencana 4 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon HARGANAS -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Hari Keluarga Nasional (HARGANAS)</h3>
                <span class="pokja-badge">HARGANAS</span>
              </div>
              <p class="pokja-card-desc">
                Peringatan Hari Keluarga Nasional (HARGANAS) dalam upaya peningkatan ketahanan keluarga untuk mewujudkan keluarga berkualitas.
              </p>
            </div>
          </div>
        </div>

        <!-- Rencana 5 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Kesehatan Reproduksi -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Kesehatan Reproduksi Catin &amp; Remaja</h3>
                <span class="pokja-badge">KESPRO</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan penyuluhan kesehatan reproduksi bagi remaja dan calon pengantin.
              </p>
            </div>
          </div>
        </div>

        <!-- Rencana 6 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Keseimbangan Keuangan -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <line x1="12" y1="1" x2="12" y2="23"></line>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Keseimbangan Anggaran Finansial Keluarga</h3>
                <span class="pokja-badge">KEUANGAN KELUARGA</span>
              </div>
              <p class="pokja-card-desc">
                Mengatur keseimbangan antara pemasukan dan pengeluaran keuangan keluarga.
              </p>
            </div>
          </div>
        </div>

      </div>

      <!-- Kotak Catatan Singkatan Perencanaan -->
      <div class="pokja-prioritas-note">
        <strong>Arti singkatan:</strong> KB = Keluarga Berencana. KB-KES = Keluarga Berencana - Kesehatan. HARGANAS = Hari Keluarga Nasional. KESPRO = Kesehatan Reproduksi. Catin = Calon Pengantin.
      </div>
    </section>

  </div>
</div>

@endsection
