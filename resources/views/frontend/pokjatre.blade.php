@extends('frontend/layouts.template')

@section('content')

{{-- CSS Khusus Pokja 3 (Scoped di bawah .pokja) --}}
<link rel="stylesheet" href="{{ asset('css/pokja.css') }}?v={{ filemtime(public_path('css/pokja.css')) }}">

<div class="pokja">
  <div class="pokja-container">

    <!-- 1. BANNER UTAMA -->
    <section class="pokja-banner" aria-label="Banner Kelompok Kerja 3">
      <div class="pokja-banner-text">
        <h1 class="pokja-banner-title">Kelompok Kerja 3 (Pokja 3)</h1>
        <p class="pokja-banner-desc">
          Membidangi penguatan ketahanan keluarga, yang diantaranya mengelola program Pangan, Sandang, serta Perumahan dan Tata Laksana Rumah Tangga.
        </p>
      </div>
      <div class="pokja-banner-logo-box">
        <img src="{{ asset('frontend/assets/img/favicon.png') }}" alt="Logo PKK Kabupaten Nganjuk" width="80" height="80">
      </div>
    </section>

    <!-- 2. MISI POKJA 3 -->
    <section class="pokja-box" aria-label="Misi Pokja 3">
      <div class="pokja-visi-wrap">
        <div class="pokja-icon-circle" aria-hidden="true">
          <!-- Ikon Target / Misi -->
          <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
          </svg>
        </div>
        <div class="pokja-visi-content">
          <div class="pokja-visi-label">Misi Pokja 3</div>
          <p class="pokja-visi-text">
            Menciptakan ketahanan keluarga melalui peningkatan keterampilan dalam pengelolaan <strong class="pokja-highlight">sandang</strong>, <strong class="pokja-highlight">pangan</strong>, dan <strong class="pokja-highlight">rumah tangga</strong> yang sehat dan layak.
          </p>
        </div>
      </div>
    </section>

    <!-- 3. PROGRAM POKOK POKJA 3 -->
    <section class="pokja-box" aria-label="Program Pokok Pokja 3">
      <h2 class="pokja-box-title">Program pokok Pokja 3</h2>
      <div class="pokja-grid-3">
        
        <!-- Kartu Program 1 -->
        <div class="pokja-card pokja-program-card">
          <div class="pokja-icon-circle" aria-hidden="true">
            <!-- Ikon Pangan / Daun / Gandum -->
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"></path>
              <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"></path>
            </svg>
          </div>
          <div class="pokja-card-body">
            <h3 class="pokja-card-title">Pangan</h3>
            <p class="pokja-card-desc">
              Mewujudkan ketahanan pangan keluarga, pola konsumsi 3B (Beragam, Bergizi, Berimbang), serta optimalisasi gerakan pekarangan HATINYA PKK.
            </p>
          </div>
        </div>

        <!-- Kartu Program 2 -->
        <div class="pokja-card pokja-program-card">
          <div class="pokja-icon-circle" aria-hidden="true">
            <!-- Ikon Sandang / Pakaian -->
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"></path>
            </svg>
          </div>
          <div class="pokja-card-body">
            <h3 class="pokja-card-title">Sandang</h3>
            <p class="pokja-card-desc">
              Mendorong pemanfaatan bahan sandang dalam negeri, pelestarian etika berbusana, serta pemberdayaan kreasi industri rumah tangga daerah.
            </p>
          </div>
        </div>

        <!-- Kartu Program 3 -->
        <div class="pokja-card pokja-program-card">
          <div class="pokja-icon-circle" aria-hidden="true">
            <!-- Ikon Perumahan & Tata Laksana -->
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
              <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
          </div>
          <div class="pokja-card-body">
            <h3 class="pokja-card-title">Perumahan dan Tatalaksana Rumah Tangga</h3>
            <p class="pokja-card-desc">
              Membina perumahan sehat layak huni dengan azas Tri Bina, pemanfaatan teknologi hemat energi, dan mewujudkan keharmonisan keluarga.
            </p>
          </div>
        </div>

      </div>
    </section>

    <!-- 4. PITA STATISTIK -->
    <section class="pokja-stats-ribbon" aria-label="Statistik Pokja 3">
      <div class="pokja-stat-item">
        <div class="pokja-stat-number">3</div>
        <div class="pokja-stat-label">Program pokok</div>
      </div>
      <div class="pokja-stat-item">
        <div class="pokja-stat-number">19</div>
        <div class="pokja-stat-label">Tugas</div>
      </div>
      <div class="pokja-stat-item">
        <div class="pokja-stat-number">9</div>
        <div class="pokja-stat-label">Prioritas pangan</div>
      </div>
      <div class="pokja-stat-item">
        <div class="pokja-stat-number">9</div>
        <div class="pokja-stat-label">Sandang &amp; perumahan</div>
      </div>
    </section>

    <!-- 5. TUGAS POKJA 3 -->
    <section class="pokja-box" aria-label="Daftar Tugas Pokja 3">
      <div class="pokja-tugas-header">
        <h2 class="pokja-tugas-title">Tugas Pokja 3</h2>
        <p class="pokja-tugas-subtitle">Pokja 3 memiliki 19 tugas.</p>
      </div>

      <div class="pokja-tugas-container">
        <!-- Tugas 01 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">01</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Ketahanan pangan keluarga</h3>
            <p class="pokja-tugas-item-desc">
              Mengupayakan ketahanan keluarga dibidang pangan sesuai dengan UU No. 7 Tahun 1996 tentang Pangan.
            </p>
          </div>
        </div>

        <!-- Tugas 02 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">02</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Penganekaragaman tanaman pangan</h3>
            <p class="pokja-tugas-item-desc">
              Meningkatkan penganekaragaman tanaman pangan dalam upaya peningkatan gizi keluarga menuju keluarga yang berkualitas.
            </p>
          </div>
        </div>

        <!-- Tugas 03 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">03</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Pola pangan 3B berbasis lokal</h3>
            <p class="pokja-tugas-item-desc">
              Menumbuhkan kesadaran masyarakat untuk mengkonsumsi makanan yang Beragam, Bergizi, Berimbang (3B), yang aman dan berbasis sumber daya lokal.
            </p>
          </div>
        </div>

        <!-- Tugas 04 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">04</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Pemanfaatan lahan darat &amp; air</h3>
            <p class="pokja-tugas-item-desc">
              Mengusahakan pemanfaatan lahan baik darat maupun air, minimal untuk pemenuhan kebutuhan pangan keluarga.
            </p>
          </div>
        </div>

        <!-- Tugas 05 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">05</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Cadangan pangan masyarakat</h3>
            <p class="pokja-tugas-item-desc">
              Berperan dan membantu dalam program Cadangan Pangan Masyarakat.
            </p>
          </div>
        </div>

        <!-- Tugas 06 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">06</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Gerakan HATINYA PKK</h3>
            <p class="pokja-tugas-item-desc">
              Memantapkan Gerakan Halaman, Asri, Teratur, Indah dan Nyaman (HATINYA PKK).
            </p>
          </div>
        </div>

        <!-- Tugas 07 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">07</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Pemanfaatan Teknologi Tepat Guna</h3>
            <p class="pokja-tugas-item-desc">
              Memanfaatan Teknologi Tepat Guna (TTG) dalam upaya meringankan beban kerja sehingga hasilnya lebih efektif dan efisien.
            </p>
          </div>
        </div>

        <!-- Tugas 08 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">08</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Aku Cinta Makanan &amp; Produksi Indonesia</h3>
            <p class="pokja-tugas-item-desc">
              Membudayakan "Aku Cinta Makanan Indonesia" dan "Aku Cinta Produksi Indonesia" sehingga menumbuhkan rasa bangga.
            </p>
          </div>
        </div>

        <!-- Tugas 09 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">09</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Pola pangan keluarga balita &amp; lansia</h3>
            <p class="pokja-tugas-item-desc">
              Mensosialisasikan pola pangan 3B untuk keluarga khususnya bagi balita dan lansia.
            </p>
          </div>
        </div>

        <!-- Tugas 10 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">10</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Bahan sandang dalam negeri</h3>
            <p class="pokja-tugas-item-desc">
              Meningkatkan penggunaan bahan sandang dalam negeri serta mendorong peningkatan kualitas dan kuantitas produksi dan pemasarannya.
            </p>
          </div>
        </div>

        <!-- Tugas 11 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">11</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Kreativitas UKM busana &amp; pariwisata</h3>
            <p class="pokja-tugas-item-desc">
              Mengembangkan kreatifitas Usaha Kecil Mikro (UKM) dengan berbagai produk busana, cinderamata khas daerah untuk menunjang pariwisata.
            </p>
          </div>
        </div>

        <!-- Tugas 12 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">12</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Penciptaan kesempatan kerja</h3>
            <p class="pokja-tugas-item-desc">
              Mendorong terciptanya lapangan/kesempatan kerja di bidang jasa, sandang, pangan dan perumahan.
            </p>
          </div>
        </div>

        <!-- Tugas 13 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">13</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Pemasyarakatan rumah sehat layak huni</h3>
            <p class="pokja-tugas-item-desc">
              Memasyarakatkan rumah sehat dan layak huni sebagai upaya terwujudnya kualitas hidup keluarga.
            </p>
          </div>
        </div>

        <!-- Tugas 14 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">14</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Fungsi rumah harmonis</h3>
            <p class="pokja-tugas-item-desc">
              Memantapkan pemahaman tentang fungsi rumah sebagai tempat tumbuh kembang keluarga harmonis.
            </p>
          </div>
        </div>

        <!-- Tugas 15 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">15</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Jalinan kerjasama institusi</h3>
            <p class="pokja-tugas-item-desc">
              Meningkatkan jalinan kerjasama dengan institusi terkait.
            </p>
          </div>
        </div>

        <!-- Tugas 16 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">16</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Pelaksanaan PMT-AS terpadu</h3>
            <p class="pokja-tugas-item-desc">
              Melaksanakan PMT- AS terkoordinasi dan terpadu.
            </p>
          </div>
        </div>

        <!-- Tugas 17 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">17</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Gerakan Memasyarakatkan Makan Ikan (GEMARIKAN)</h3>
            <p class="pokja-tugas-item-desc">
              Sosialisasi program nasional Gerakan Memasyarakatkan Makan Ikan (GEMARIKAN) dalam rangka mencerdaskan bangsa.
            </p>
          </div>
        </div>

        <!-- Tugas 18 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">18</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Gerakan tanam, tebar &amp; pelihara pohon</h3>
            <p class="pokja-tugas-item-desc">
              Melaksanakan Program Nasional Gerakan Perempuan, Tanam, Tebar dan Pelihara Pohon untuk mengantisipasi akibat perubahan iklim yang berdampak pada ketahanan pangan keluarga.
            </p>
          </div>
        </div>

        <!-- Tugas 19 -->
        <div class="pokja-tugas-row">
          <div class="pokja-tugas-num">19</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">Kelestarian hutan</h3>
            <p class="pokja-tugas-item-desc">
              Menjaga kelestarian hutan.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- 6. PRIORITAS PROGRAM: PANGAN -->
    <section class="pokja-box" aria-label="Prioritas Program Pangan">
      <h2 class="pokja-box-title">Prioritas program: Pangan</h2>
      <p class="pokja-gotong-intro">
        Fokus utama pada swasembada pangan keluarga, pola konsumsi 3B yang aman dari bahan berbahaya, optimalisasi pekarangan HATINYA PKK, dan pemanfaatan teknologi tepat guna.
      </p>

      <div class="pokja-grid-2">
        <!-- Pangan 1 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Potensi Pangan -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 2a10 10 0 0 0-7.07 17.07L12 22l7.07-2.93A10 10 0 0 0 12 2z"></path>
                <circle cx="12" cy="11" r="3"></circle>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Ketahanan Pangan Potensi Daerah</h3>
                <span class="pokja-badge">KETAHANAN PANGAN</span>
              </div>
              <p class="pokja-card-desc">
                Mewujudkan Ketahanan Pangan Keluarga melalui penganekaragaman pangan yang bergizi sesuai potensi daerah.
              </p>
            </div>
          </div>
        </div>

        <!-- Pangan 2 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Pola 3B -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M12 6v6l4 2"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Penerapan Pola Pangan 3B Sehari-hari</h3>
                <span class="pokja-badge">POLA 3B</span>
              </div>
              <p class="pokja-card-desc">
                Peningkatan pangan keluarga sehari-hari dengan mendorong terciptanya sikap dan perilaku masyarakat melalui penganekaragaman makanan dengan menerapkan pola pangan 3B (beragam, bergizi, berimbang), sesuai potensi daerah.
              </p>
            </div>
          </div>
        </div>

        <!-- Pangan 3 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Higiene & Keamanan Pangan -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Kewaspadaan Bahaya &amp; Racun Pangan</h3>
                <span class="pokja-badge">KEAMANAN PANGAN</span>
              </div>
              <p class="pokja-card-desc">
                Mewaspadai terjadinya keracunan pangan, mulai dari menanam, memilih, mengolah sampai terhidangnya makanan, menghindari bahan tambahan makanan yang berbahaya, antara lain : zat pewarna, bahan pengawet, produk kedaluwarsa, dan penggunaan pestisida.
              </p>
            </div>
          </div>
        </div>

        <!-- Pangan 4 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Edukasi Budaya Makanan -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Edukasi Pantangan Merugikan</h3>
                <span class="pokja-badge">EDUKASI GIZI</span>
              </div>
              <p class="pokja-card-desc">
                Meminimalkan budaya / tradisi pangan yang merugikan kesehatan misalnya orang hamil / balita banyak pantangan makan.
              </p>
            </div>
          </div>
        </div>

        <!-- Pangan 5 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon HATINYA PKK & TOGA -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Optimalisasi HATINYA PKK &amp; TOGA</h3>
                <span class="pokja-badge">HATINYA PKK</span>
              </div>
              <p class="pokja-card-desc">
                Mengoptimalkan HATINYA PKK dengan tananam pangan dan tanaman produktif/keras (bernilai ekonomis tinggi), minimal untuk memenuhi keperluan dan tabungan keluarga serta meningkatkan Tanaman Obat Keluarga (TOGA).
              </p>
            </div>
          </div>
        </div>

        <!-- Pangan 6 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Industri Rumah Tangga -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-2z"></path>
                <line x1="3" y1="6" x2="21" y2="6"></line>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Industri Pangan Rumah Tangga</h3>
                <span class="pokja-badge">INDUSTRI PANGAN</span>
              </div>
              <p class="pokja-card-desc">
                Mengembangkan industri pangan rumah tangga dan mengadakan penyuluhan, orientasi dan pelatihan untuk menunjang pemasaran.
              </p>
            </div>
          </div>
        </div>

        <!-- Pangan 7 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Lomba Masak -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                <path d="M4 22h16"></path>
                <path d="M6 4h12a2 2 0 0 1 2 2v3a6 6 0 0 1-6 6h0a6 6 0 0 1-6-6V6a2 2 0 0 1 2-2z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Kreativitas Cipta Menu Lomba Masak</h3>
                <span class="pokja-badge">LOMBA MASAK</span>
              </div>
              <p class="pokja-card-desc">
                Mengadakan lomba masak secara berjenjang guna meningikatkan kreativitas cipta makanan.
              </p>
            </div>
          </div>
        </div>

        <!-- Pangan 8 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon TTG Agrobisnis -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Pemanfaatan TTG Agrobisnis &amp; Pertanian</h3>
                <span class="pokja-badge">TTG AGROBISNIS</span>
              </div>
              <p class="pokja-card-desc">
                Pemanfaatan Teknologi Tepat Guna (TTG) untuk menunjang usaha agrobisnis, hortikultura, tanaman buah, perikanan, peternakan dan lain-lain untuk meningkatkan kualitas dan kuantitas produksi dalam mencapai taraf hidup dan kesejahteraan keluarga.
              </p>
            </div>
          </div>
        </div>

        <!-- Pangan 9 -->
        <div class="pokja-card pokja-grid-full">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Buku Panduan -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Buku Pedoman Keanekaragaman Konsumsi Pangan</h3>
                <span class="pokja-badge">BUKU PEDOMAN</span>
              </div>
              <p class="pokja-card-desc">
                Menyempurnakan dan sosialisasi buku Peran PKK Dalam Mendukung Gerakan Percepatan Keanekaragaman Konsumsi Pangan.
              </p>
            </div>
          </div>
        </div>

      </div>

      <!-- Kotak Catatan Singkatan Pangan -->
      <div class="pokja-prioritas-note">
        <strong>Arti singkatan:</strong> 3B = Beragam, Bergizi, Berimbang. HATINYA PKK = Halaman, Asri, Teratur, Indah dan Nyaman. TOGA = Tanaman Obat Keluarga. TTG = Teknologi Tepat Guna. PMT-AS = Pemberian Makanan Tambahan Anak Sekolah. GEMARIKAN = Gerakan Memasyarakatkan Makan Ikan.
      </div>
    </section>

    <!-- 7. PRIORITAS PROGRAM: SANDANG -->
    <section class="pokja-box" aria-label="Prioritas Program Sandang">
      <h2 class="pokja-box-title">Prioritas program: Sandang</h2>
      <p class="pokja-gotong-intro">
        Penguatan identitas moral dan budaya berbusana, perlindungan karya cipta desain, promosi produk sandang khas daerah, serta sinergi pelaku usaha pariwisata.
      </p>

      <div class="pokja-grid-2">
        <!-- Sandang 1 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Hak Paten -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M15 9.354a4 4 0 1 0 0 5.292"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Perlindungan Hak Paten Desain</h3>
                <span class="pokja-badge">HAK PATEN</span>
              </div>
              <p class="pokja-card-desc">
                Mengupayakan adanya hak paten untuk melindungi hak cipta desain.
              </p>
            </div>
          </div>
        </div>

        <!-- Sandang 2 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Pameran -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                <line x1="8" y1="21" x2="16" y2="21"></line>
                <line x1="12" y1="17" x2="12" y2="21"></line>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Partisipasi Pameran &amp; Lomba</h3>
                <span class="pokja-badge">PAMERAN</span>
              </div>
              <p class="pokja-card-desc">
                Mengupayakan keikutsertaan dalam pameran dan lomba baik tingkat lokal, nasional dan internasional.
              </p>
            </div>
          </div>
        </div>

        <!-- Sandang 3 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Kemitraan Desainer -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Kemitraan Desainer &amp; Pariwisata</h3>
                <span class="pokja-badge">SINERGI INDUSTRI</span>
              </div>
              <p class="pokja-card-desc">
                Mengadakan kerja sama dengan para disainer, pengusaha, industri sandang dan pariwisata.
              </p>
            </div>
          </div>
        </div>

        <!-- Sandang 4 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Cinta Produksi Indonesia -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Moral Budaya Berbusana &amp; Cinta Produk Lokal</h3>
                <span class="pokja-badge">AKU CINTA INDONESIA</span>
              </div>
              <p class="pokja-card-desc">
                Membudayakan perilaku berbusana sesuai dengan moral budaya Indonesia dan meningkatkan kesadaran masyarakat mencintai produksi dalam negeri (Aku Cinta Produksi Indonesia).
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 8. PERUMAHAN DAN TATA LAKSANA RUMAHTANGGA -->
    <section class="pokja-box" aria-label="Perumahan dan Tata Laksana Rumah Tangga">
      <h2 class="pokja-box-title">Perumahan dan Tata Laksana Rumahtangga</h2>
      <p class="pokja-gotong-intro">
        Mewujudkan hunian yang sehat, aman, dan tertata rapi melalui program pemugaran rumah, pemasyarakatan teknologi hemat energi, serta pembinaan pola hidup rukun dan harmonis.
      </p>

      <div class="pokja-grid-2">
        <!-- Rumah 1 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon P2LDT -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Pemugaran Perumahan &amp; Tri Bina (P2LDT)</h3>
                <span class="pokja-badge">P2LDT</span>
              </div>
              <p class="pokja-card-desc">
                Menumbuh kembangkan kembali program Pemugaran Perumahan dan Lingkungan Desa Terpadu (P2LDT) melalui pemugaran rumah layak huni terutama keluarga miskin dan pengungsi dengan azas Tri Bina (bina usaha, bina manusia dan bina lingkungan), gotong royong serta mengupayakan bantuan dari instansi/dinas terkait, bank, swasta dan masyarakat.
              </p>
            </div>
          </div>
        </div>

        <!-- Rumah 2 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Rumah Sehat & Hukum -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <line x1="12" y1="1" x2="12" y2="23"></line>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Edukasi Rumah Sehat &amp; Kepemilikan Lahan</h3>
                <span class="pokja-badge">RUMAH SEHAT</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan pemasyarakatan tentang perumahan sehat dan layak huni serta menumbuhkan kesadaran akan bahaya bertempat tinggal di daerah tegangan listrik tinggi, bantaran sungai, timbunan sampah, tepian jalan rel kereta api dan menumbuhkan kesadaran hukum tentang kepemilikan rumah dan tanah.
              </p>
            </div>
          </div>
        </div>

        <!-- Rumah 3 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon TTG Hemat Energi -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">TTG Rumah Tangga &amp; Hemat Energi</h3>
                <span class="pokja-badge">HEMAT ENERGI</span>
              </div>
              <p class="pokja-card-desc">
                Pemasyarakatan dan pemanfaatan TTG dalam rumahtangga, sarana dan prasarana perumahan serta hemat energi dan mencegah pemborosan.
              </p>
            </div>
          </div>
        </div>

        <!-- Rumah 4 -->
        <div class="pokja-card">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Keluarga Harmonis -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                <line x1="9" y1="9" x2="9.01" y2="9"></line>
                <line x1="15" y1="9" x2="15.01" y2="9"></line>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Harmonisasi Tata Laksana Keluarga</h3>
                <span class="pokja-badge">KEHARMONISAN</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan pengetahuan dan keterampilan tentang tata laksana rumah tangga dalam mengharmoniskan dan membahagiakan kehidupan keluarga.
              </p>
            </div>
          </div>
        </div>

        <!-- Rumah 5 -->
        <div class="pokja-card pokja-grid-full">
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Rumah Susun -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect>
                <line x1="9" y1="22" x2="9" y2="2"></line>
                <line x1="8" y1="6" x2="8.01" y2="6"></line>
                <line x1="16" y1="6" x2="16.01" y2="6"></line>
                <line x1="16" y1="10" x2="16.01" y2="10"></line>
                <line x1="16" y1="14" x2="16.01" y2="14"></line>
                <line x1="16" y1="18" x2="16.01" y2="18"></line>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Pola Hidup Tertib Penghuni Rumah Susun</h3>
                <span class="pokja-badge">RUMAH SUSUN</span>
              </div>
              <p class="pokja-card-desc">
                Meningkatkan penerapan pola hidup /perilaku bagi penghuni rumah susun.
              </p>
            </div>
          </div>
        </div>

      </div>

      <!-- Kotak Catatan Singkatan Rumah -->
      <div class="pokja-prioritas-note">
        <strong>Arti singkatan:</strong> P2LDT = Pemugaran Perumahan dan Lingkungan Desa Terpadu. Tri Bina = Bina Usaha, Bina Manusia, Bina Lingkungan. TTG = Teknologi Tepat Guna. UKM = Usaha Kecil Mikro.
      </div>
    </section>

  </div>
</div>

@endsection
