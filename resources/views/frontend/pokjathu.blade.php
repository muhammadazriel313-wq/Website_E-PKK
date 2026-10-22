@extends('frontend/layouts.template')

@section('content')

{{-- CSS Khusus Pokja 2 (Scoped di bawah .pokja) --}}
<link rel="stylesheet" href="{{ asset('css/pokja.css') }}?v={{ filemtime(public_path('css/pokja.css')) }}">

<div class="pokja">
  <div class="pokja-container">

    <!-- 1. BANNER UTAMA -->
    <section class="pokja-banner" aria-label="Banner Kelompok Kerja 2">
      <div class="pokja-banner-text">
        <h1 class="pokja-banner-title">Kelompok Kerja 2 (Pokja 2)</h1>
        <p class="pokja-banner-desc">
          Membidangi Pendidikan &amp; Peningkatan Ekonomi Keluarga, mengelola program pendidikan &amp; keterampilan, serta pengembangan kehidupan berkoperasi.
        </p>
      </div>
      <div class="pokja-banner-logo-box">
        <img src="{{ asset('frontend/assets/img/favicon.png') }}" alt="Logo PKK Kabupaten Nganjuk" width="80" height="80">
      </div>
    </section>

    <!-- 2. MISI POKJA 2 -->
    <section class="pokja-box" aria-label="Misi Pokja 2">
      <div class="pokja-visi-wrap">
        <div class="pokja-icon-circle" aria-hidden="true">
          <!-- Ikon Target / Misi -->
          <svg viewBox="0 0 24 24" aria-hidden="true">
            <circle cx="12" cy="12" r="10"></circle>
            <circle cx="12" cy="12" r="6"></circle>
            <circle cx="12" cy="12" r="2"></circle>
          </svg>
        </div>
        <div class="pokja-visi-content">
          <div class="pokja-visi-label">Misi Pokja 2</div>
          <p class="pokja-visi-text">
            Menumbuhkan lingkungan keluarga yang <strong class="pokja-highlight">cerdas</strong>, <strong class="pokja-highlight">kreatif</strong>, <strong class="pokja-highlight">terampil</strong>, <strong class="pokja-highlight">sejahtera</strong> dan <strong class="pokja-highlight">mandiri</strong> melalui upaya Pendidikan, peningkatan keterampilan dan pengembangan kehidupan berkoperasi.
          </p>
        </div>
      </div>
    </section>

    <!-- 3. PROGRAM POKOK POKJA 2 -->
    <section class="pokja-box" aria-label="Program Pokok Pokja 2">
      <h2 class="pokja-box-title">Program pokok Pokja 2</h2>
      <div class="pokja-grid-2">
        
        <!-- Kartu Program 1 -->
        <div class="pokja-card pokja-program-card">
          <div class="pokja-icon-circle" aria-hidden="true">
            <!-- Ikon Pendidikan / Topi Wisuda -->
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
              <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
            </svg>
          </div>
          <div class="pokja-card-body">
            <h3 class="pokja-card-title">Pendidikan dan Keterampilan</h3>
            <p class="pokja-card-desc">
              Meningkatkan pendidikan dan ketrampilan dalam keluarga, pembinaan kelompok belajar, serta peningkatan mutu kader dan ketahanan keluarga.
            </p>
          </div>
        </div>

        <!-- Kartu Program 2 -->
        <div class="pokja-card pokja-program-card">
          <div class="pokja-icon-circle" aria-hidden="true">
            <!-- Ikon Koperasi / Kerja Sama Ekonomi -->
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="12" y1="8" x2="12" y2="12"></line>
              <line x1="12" y1="16" x2="12.01" y2="16"></line>
              <path d="M16 16v1a2 2 0 0 1-2 2H10a2 2 0 0 1-2-2v-1"></path>
            </svg>
          </div>
          <div class="pokja-card-body">
            <h3 class="pokja-card-title">Pengembangan Kehidupan Berkoperasi</h3>
            <p class="pokja-card-desc">
              Mendorong penguatan ekonomi keluarga melalui kelompok Usaha Peningkatan Pendapatan Keluarga (UP2K) dan pembentukan koperasi berbadan hukum.
            </p>
          </div>
        </div>

      </div>
    </section>

    <!-- 4. PITA STATISTIK -->
    <section class="pokja-stats-ribbon" aria-label="Statistik Pokja 2">
      <div class="pokja-stat-item">
        <div class="pokja-stat-number">2</div>
        <div class="pokja-stat-label">Program pokok</div>
      </div>
      <div class="pokja-stat-item">
        <div class="pokja-stat-number">11</div>
        <div class="pokja-stat-label">Tugas</div>
      </div>
      <div class="pokja-stat-item">
        <div class="pokja-stat-number">13</div>
        <div class="pokja-stat-label">Prioritas pendidikan</div>
      </div>
      <div class="pokja-stat-item">
        <div class="pokja-stat-number">8</div>
        <div class="pokja-stat-label">Kehidupan berkoperasi</div>
      </div>
    </section>

    <!-- 5. TUGAS POKJA 2 -->
    <section class="pokja-box" aria-label="Daftar Tugas Pokja 2">
      <div class="pokja-tugas-header">
        <h2 class="pokja-tugas-title">Tugas Pokja 2</h2>
        <p class="pokja-tugas-subtitle">Pokja 2 memiliki 11 tugas.</p>
      </div>

      <div class="pokja-tugas-container">
        <!-- Tugas 01 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">01</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Pendidikan dan keterampilan keluarga</h3>
            <p class="pokja-tugas-item-desc">
              Meningkatkan pendidikan dan ketrampilan dalam keluarga, peningkatan jenis dan mutu kader, peningkatan pengetahuan TP PKK dan kelompok-kelompok PKK dan Dasawisma melalui penyuluhan, orientasi dan pelatihan.
            </p>
          </div>
        </div>

        <!-- Tugas 02 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">02</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Bina Keluarga Balita (BKB)</h3>
            <p class="pokja-tugas-item-desc">
              Melaksanakan dan mengembangkan kegiatan program Bina Keluarga Balita (BKB).
            </p>
          </div>
        </div>

        <!-- Tugas 03 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">03</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Kelompok Belajar Paket A, B, dan C</h3>
            <p class="pokja-tugas-item-desc">
              Memantapkan Kelompok Belajar (Kejar) Paket A dan B dan C.
            </p>
          </div>
        </div>

        <!-- Tugas 04 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">04</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Pendidikan Anak Usia Dini (PAUD)</h3>
            <p class="pokja-tugas-item-desc">
              Meningkatkan pengetahuan dan menumbuhkan kesadaran dalam keluarga tentang pentingnya pendidikan anak sejak usia dini (0-6) tahun agar anak tumbuh dan berkembang secara optimal sesuai dengan usianya.
            </p>
          </div>
        </div>

        <!-- Tugas 05 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">05</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Keaksaraan Fungsional (KF)</h3>
            <p class="pokja-tugas-item-desc">
              Membantu program Keaksaraan Fungsional (KF) dalam rangka meningkatkan pendidikan keluarga.
            </p>
          </div>
        </div>

        <!-- Tugas 06 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">06</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Usaha Peningkatan Pendapatan Keluarga (UP2K)</h3>
            <p class="pokja-tugas-item-desc">
              Meningkatkan kelompok dan kualitas Usaha Peningkatan Pendapatan Keluarga (UP2K) PKK.
            </p>
          </div>
        </div>

        <!-- Tugas 07 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">07</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Pemberdayaan koperasi keluarga</h3>
            <p class="pokja-tugas-item-desc">
              Memotivasi keluarga tentang manfaat koperasi sebagai salah satu upaya perbaikan ekonomi keluarga dan mendorong terbentuknya koperasi yang dikelola oleh PKK.
            </p>
          </div>
        </div>

        <!-- Tugas 08 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">08</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Identifikasi kebutuhan pelatihan</h3>
            <p class="pokja-tugas-item-desc">
              Identifikasi kebutuhan pelatihan.
            </p>
          </div>
        </div>

        <!-- Tugas 09 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">09</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Penyusunan modul pelatihan</h3>
            <p class="pokja-tugas-item-desc">
              Menyusun modul-modul pelatihan.
            </p>
          </div>
        </div>

        <!-- Tugas 10 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">10</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Partisipasi Forum PAUD</h3>
            <p class="pokja-tugas-item-desc">
              Berparitisipasi dalam Forum PAUD bekerjasama dengan Pokja IV yang difasilitasi oleh Kementerian Pendidikan Nasional.
            </p>
          </div>
        </div>

        <!-- Tugas 11 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">11</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Pendidikan dasar untuk semua (MDGs)</h3>
            <p class="pokja-tugas-item-desc">
              Meningkatkan pengetahuan masyarakt tentang pentingnya pendidikan dasar untuk semua sesuai dengan tujuan MGDs yaitu agar setiap anak laki-laki dan perempuan mendapatkan dan menyelesaikan pendidikan dasar.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- 6. PRIORITAS PROGRAM: PENDIDIKAN DAN KETRAMPILAN -->
    <section class="pokja-box" aria-label="Prioritas Program Pendidikan dan Keterampilan">
      <h2 class="pokja-box-title">Prioritas program: Pendidikan dan Ketrampilan</h2>
      <p class="pokja-gotong-intro">
        Fokus pembinaan pada peningkatan pengetahuan dan kecakapan hidup keluarga, stimulasi tumbuh kembang anak, hingga perluasan akses pendidikan dasar dan non-formal.
      </p>

      <div class="pokja-grid-2">
        <!-- Prioritas 1 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Kasih Sayang / Balita -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Tumbuh Kembang Balita</h3>
                <span class="pokja-badge">BALITA</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan kemampuan yang berkaitan dengan pengetahuan, kesadaran dan ketrampilan keluarga yang mempunyai anak balita mengenai tumbuh kembang anak balita secara optimal.
              </p>
            </div>
          </div>
        </div>

        <!-- Prioritas 2 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Modul / Buku -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Pelatihan &amp; Modul BKB</h3>
                <span class="pokja-badge">BKB</span>
              </div>
              <p class="pokja-card-desc">
                Menyusun modul pelatihan BKB bagi TP PKK dan mengadakan pelatihan BKB.
              </p>
            </div>
          </div>
        </div>

        <!-- Prioritas 3 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon TOT / Pelatih -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Pelatihan Pelatih (TOT)</h3>
                <span class="pokja-badge">TOT</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan mutu dan jumlah pelatih PKK dengan mengadakan pelatihan pelatih/ Training of Trainer (TOT).
              </p>
            </div>
          </div>
        </div>

        <!-- Prioritas 4 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Modul TPK3PKK -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Penyempurnaan Modul Pelatihan</h3>
                <span class="pokja-badge">DAMAS PKK</span>
              </div>
              <p class="pokja-card-desc">
                Menyempurnakan modul-modul pelatihan TPK3PKK, LP3PKK dan DAMAS PKK sesuai dengan perkembangan serta mensosialisasikannya antara lain melalui pelatihan-pelatihan : TPK3PKK, LP3PKK dan DAMAS PKK.
              </p>
            </div>
          </div>
        </div>

        <!-- Prioritas 5 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Integrasi Pos PAUD -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                <line x1="9" y1="9" x2="9.01" y2="9"></line>
                <line x1="15" y1="9" x2="15.01" y2="9"></line>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Integrasi Kegiatan Pos PAUD</h3>
                <span class="pokja-badge">POS PAUD</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan pengetahuan TP PKK dalam kegiatan Pos PAUD melalui kegiatan PAUD yang diintegrasikan dengan BKB dan Posyandu dengan pertemuan mitra PAUD bekerja sama dengan Pokja IV.
              </p>
            </div>
          </div>
        </div>

        <!-- Prioritas 6 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon HIMPAUDI / Kader -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <polyline points="16 11 18 13 22 9"></polyline>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Kader Pendidik Usia Dini</h3>
                <span class="pokja-badge">HIMPAUDI</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan jumlah, pengetahuan dan ketrampilan kader dalam mendidik anak usia dini melalui pelatihan bekerja sama dengan instansi terkait dan HIMPAUDI.
              </p>
            </div>
          </div>
        </div>

        <!-- Prioritas 7 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Kecakapan Hidup (Life Skill) -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Kecakapan Hidup Mandiri</h3>
                <span class="pokja-badge">LIFE SKILL</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan ketrampilan kecakapan hidup (LIFE SKILL) perempuan maupun laki laki sehingga mampu berusaha secara bersama atau mandiri untuk memperkuat kehidupan diri dan keluarganya.
              </p>
            </div>
          </div>
        </div>

        <!-- Prioritas 8 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Monev -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Monitoring &amp; Evaluasi PAUD</h3>
                <span class="pokja-badge">MONEV</span>
              </div>
              <p class="pokja-card-desc">
                Mengadakan monitoring dan evaluasi kegiatan Pos PAUD di TP PKK Provinsi untuk mengetahui sejauh mana pengintegrasian PAUD, BKB dan Posyandu.
              </p>
            </div>
          </div>
        </div>

        <!-- Prioritas 9 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Kejar Paket -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                <polyline points="2 17 12 22 22 17"></polyline>
                <polyline points="2 12 12 17 22 12"></polyline>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Tutor Kejar Paket A, B, dan C</h3>
                <span class="pokja-badge">KEJAR PAKET</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan kejar Paket A, B dan C melalui pelatihan Tutor Kejar Paket A, B dan C bekerja sama dengan instansi terkait.
              </p>
            </div>
          </div>
        </div>

        <!-- Prioritas 10 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Wajar Dikdas -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path>
                <line x1="4" y1="22" x2="4" y2="15"></line>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Wajib Belajar 9 Tahun</h3>
                <span class="pokja-badge">WAJAR DIKDAS</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan dan menyuluh keluarga tentang Wajib Belajar Pendidikan Dasar Sembilan Tahun (WAJAR DIKDAS 9 tahun).
              </p>
            </div>
          </div>
        </div>

        <!-- Prioritas 11 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Keaksaraan Fungsional -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Keaksaraan Fungsional (KF)</h3>
                <span class="pokja-badge">KF</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan pendidikan dan ketrampilan keluarga serta pengembangan Keaksaraan Fungsional (KF) dengan pendampingan melalui penyuluhan, orientasi dan pelatihan.
              </p>
            </div>
          </div>
        </div>

        <!-- Prioritas 12 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Taman Bacaan Masyarakat -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Taman Bacaan &amp; Sudut Baca</h3>
                <span class="pokja-badge">TBM</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan pengetahuan dan kemampuan baca tulis, serta membudayakan minat baca masyarakat melalui Taman Bacaan Masyarakat (TBM) dan Sudut Baca bekerja sama dengan instansi terkait.
              </p>
            </div>
          </div>
        </div>

        <!-- Prioritas 13 -->
        <div class="pokja-card pokja-grid-full">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Kemitraan Lembaga -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="2" y1="12" x2="22" y2="12"></line>
                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Kerjasama Kemitraan Pendamping</h3>
                <span class="pokja-badge">LINTAS SEKTOR</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan pelaksanaan kerjasama dengan mitra sebagai pendamping, yaitu lintas sektoral dan lintas kelembagaan.
              </p>
            </div>
          </div>
        </div>

      </div>

      <!-- Kotak Catatan Singkatan -->
      <div class="pokja-prioritas-note">
        <strong>Arti singkatan:</strong> BKB = Bina Keluarga Balita. TOT = Training of Trainer. TPK3PKK = Tim Pembina Kader Pos Pelayanan Terpadu PKK. DAMAS PKK = Dasawisma PKK. PAUD = Pendidikan Anak Usia Dini. HIMPAUDI = Himpunan Pendidik dan Tenaga Kependidikan Anak Usia Dini Indonesia. WAJAR DIKDAS = Wajib Belajar Pendidikan Dasar. KF = Keaksaraan Fungsional. TBM = Taman Bacaan Masyarakat.
      </div>
    </section>

    <!-- 7. PENGEMBANGAN KEHIDUPAN BERKOPERASI -->
    <section class="pokja-box" aria-label="Pengembangan Kehidupan Berkoperasi Pokja 2">
      <h2 class="pokja-box-title">Pengembangan Kehidupan Berkoperasi</h2>
      <p class="pokja-gotong-intro">
        Mendorong peningkatan pendapatan dan kemandirian ekonomi keluarga melalui pembinaan kelompok Usaha Peningkatan Pendapatan Keluarga (UP2K) serta pembentukan koperasi berbadan hukum yang terkelola dengan baik.
      </p>

      <div class="pokja-grid-2">
        <!-- Koperasi 1 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Evaluasi / Piala -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                <path d="M4 22h16"></path>
                <path d="M10 14.66V17c0 .55-.45 1-1 1H8c-.55 0-1 .45-1 1v1h10v-1c0-.55-.45-1-1-1h-1c-.55 0-1-.45-1-1v-2.34"></path>
                <path d="M6 4h12a2 2 0 0 1 2 2v3a6 6 0 0 1-6 6h0a6 6 0 0 1-6-6V6a2 2 0 0 1 2-2z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Evaluasi &amp; Lomba UP2K</h3>
                <span class="pokja-badge">EVALUASI UP2K</span>
              </div>
              <p class="pokja-card-desc">
                Melaksanakan evaluasi UP2K-PKK dan mengadakan lomba UP2K untuk mengetahui sejauh mana pelaksanaan kegiatan UP2K-PKK didaerah dan mengetahuai keberhasilannya.
              </p>
            </div>
          </div>
        </div>

        <!-- Koperasi 2 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Pelatihan Terampil -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Pelatihan Tenaga Terampil</h3>
                <span class="pokja-badge">PELATIHAN</span>
              </div>
              <p class="pokja-card-desc">
                Mengadakan pelatihan UP2K-PKK dalam rangka meningkatkan pengetahuan tentang program UP2K-PKK agar TP PKK Provinsi mempunyai tenaga terampil dalam pengembangan program UP2K-PKK.
              </p>
            </div>
          </div>
        </div>

        <!-- Koperasi 3 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Pendataan Kelompok -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <line x1="8" y1="6" x2="21" y2="6"></line>
                <line x1="8" y1="12" x2="21" y2="12"></line>
                <line x1="8" y1="18" x2="21" y2="18"></line>
                <line x1="3" y1="6" x2="3.01" y2="6"></line>
                <line x1="3" y1="12" x2="3.01" y2="12"></line>
                <line x1="3" y1="18" x2="3.01" y2="18"></line>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Pendataan Kelompok UP2K</h3>
                <span class="pokja-badge">DATA UP2K</span>
              </div>
              <p class="pokja-card-desc">
                Mendata ulang jumlah kelompok-kelompok UP2K-PKK.
              </p>
            </div>
          </div>
        </div>

        <!-- Koperasi 4 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Permodalan Mikro -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Akses Permodalan &amp; Lembaga Keuangan</h3>
                <span class="pokja-badge">PERMODALAN</span>
              </div>
              <p class="pokja-card-desc">
                Mengatatasi cara pemecahan masalah mengenai permodalan untuk kegiatan UP2K PKK melalui APBD, Lembaga Keuangan Mikro yang ada, baik yang bersifat bank seperti BRI Unit Desa, Bank Perkreditan Rakyat, Program Nasional Pemberdayaan Masyarakat (PNPM) Mandiri Pedesaan, Alokasi Dana Desa (ADD) dan lain lain.
              </p>
            </div>
          </div>
        </div>

        <!-- Koperasi 5 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Pemasaran & Bazar -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-2z"></path>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <path d="M16 10a4 4 0 0 1-8 0"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Pemasaran &amp; Kemitraan Dekranasda</h3>
                <span class="pokja-badge">PEMASARAN</span>
              </div>
              <p class="pokja-card-desc">
                Mengupayakan pemasaran UP2K PKK melalui pasar, warung, ikut pada pameran, bazar baik lokal maupun nasional dan menjalin kemitraan dengan Dekranas / Dekranasda.
              </p>
            </div>
          </div>
        </div>

        <!-- Koperasi 6 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Keanggotaan Koperasi -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <line x1="19" y1="8" x2="19" y2="14"></line>
                <line x1="22" y1="11" x2="16" y2="11"></line>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Motivasi Anggota Koperasi</h3>
                <span class="pokja-badge">ANGGOTA</span>
              </div>
              <p class="pokja-card-desc">
                Memotifasi keluarga agar mau menjadi anggota koperasi untuk meningkatkan pendapatan keluarga.
              </p>
            </div>
          </div>
        </div>

        <!-- Koperasi 7 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Koperasi Berbadan Hukum -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                <polyline points="9 12 11 14 15 10"></polyline>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Koperasi Berbadan Hukum</h3>
                <span class="pokja-badge">BADAN HUKUM</span>
              </div>
              <p class="pokja-card-desc">
                Mendorong terbentuknya koperasi yang berbadan hukum yang dikelola oleh TP PKK.
              </p>
            </div>
          </div>
        </div>

        <!-- Koperasi 8 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Sinergi Daerah & Instansi -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                <line x1="8" y1="21" x2="16" y2="21"></line>
                <line x1="12" y1="17" x2="12" y2="21"></line>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Kemitraan &amp; Kemampuan Daerah</h3>
                <span class="pokja-badge">SINERGI</span>
              </div>
              <p class="pokja-card-desc">
                Dalam pelaksanaa prioritas program disesuaikan dengan kemampuan daerah dan menjalin kemitraan dengan instansi terkait.
              </p>
            </div>
          </div>
        </div>

      </div>

      <!-- Kotak Catatan Singkatan -->
      <div class="pokja-prioritas-note">
        <strong>Arti singkatan:</strong> UP2K = Usaha Peningkatan Pendapatan Keluarga. APBD = Anggaran Pendapatan dan Belanja Daerah. PNPM = Program Nasional Pemberdayaan Masyarakat. ADD = Alokasi Dana Desa. Dekranas/Dekranasda = Dewan Kerajinan Nasional Daerah.
      </div>
    </section>

  </div>
</div>

@endsection