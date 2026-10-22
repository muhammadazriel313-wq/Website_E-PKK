@extends('frontend/layouts.template')

@section('content')

{{-- CSS Khusus Pokja 1 (Scoped di bawah .pokja) --}}
<link rel="stylesheet" href="{{ asset('css/pokja.css') }}?v={{ filemtime(public_path('css/pokja.css')) }}">

<div class="pokja">
  <div class="pokja-container">

    <!-- 1. BANNER UTAMA (GRADASI BIRU-PUTIH MEWAH) -->
    <section class="pokja-banner" aria-label="Banner Kelompok Kerja 1">
      <div class="pokja-banner-text">
        <div class="pokja-hero-tag">
          <span class="pokja-pulse-dot"></span>
          <span>POKJA 1 TP-PKK KABUPATEN NGANJUK</span>
        </div>
        <h1 class="pokja-banner-title">Kelompok Kerja 1 (Pokja 1)</h1>
        <p class="pokja-banner-desc">
          Pokja 1 membina karakter dalam keluarga. Tugasnya mengelola program Penghayatan dan Pengamalan Pancasila serta Gotong Royong.
        </p>
      </div>
      <div class="pokja-banner-logo-box">
        <img src="{{ asset('frontend/assets/img/favicon.png') }}" alt="Logo PKK Kabupaten Nganjuk" width="82" height="82">
      </div>
    </section>

    <!-- 2. VISI POKJA 1 (FEATURE CARD BERGRADASI) -->
    <section id="visi" class="pokja-box pokja-visi-box" aria-label="Visi Pokja 1">
      <div class="pokja-visi-wrap">
        <div class="pokja-icon-circle" aria-hidden="true">
          <!-- Ikon Mata Visi -->
          <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
          </svg>
        </div>
        <div class="pokja-visi-content">
          <div class="pokja-visi-label">Visi Pokja 1</div>
          <p class="pokja-visi-text">
            Menumbuhkan karakter keluarga yang <strong class="pokja-highlight">bahagia</strong>, <strong class="pokja-highlight">aman</strong> dan <strong class="pokja-highlight">damai</strong> melalui penghayatan dan pengamalan Pancasila serta semangat gotong royong.
          </p>
        </div>
      </div>
    </section>

    <!-- 3. PROGRAM POKOK POKJA 1 -->
    <section id="program-pokok" class="pokja-box" aria-label="Program Pokok Pokja 1">
      <h2 class="pokja-box-title">Program pokok Pokja 1</h2>
      <div class="pokja-grid-2">
        
        <!-- Kartu Program 1 -->
        <div class="pokja-card pokja-program-card">
          <div class="pokja-card-accent-top"></div>
          <div class="pokja-icon-circle" aria-hidden="true">
            <!-- Ikon Pancasila / Tameng Kebangsaan -->
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
              <polygon points="12 8 13.5 11 17 11.5 14.5 14 15 17.5 12 15.5 9 17.5 9.5 14 7 11.5 10.5 11 12 8"></polygon>
            </svg>
          </div>
          <div class="pokja-card-body">
            <h3 class="pokja-card-title">Penghayatan dan Pengamalan Pancasila</h3>
            <p class="pokja-card-desc">
              Menumbuhkan ketahanan keluarga melalui kesadaran bermasyarakat, berbangsa dan bernegara.
            </p>
          </div>
        </div>

        <!-- Kartu Program 2 -->
        <div class="pokja-card pokja-program-card">
          <div class="pokja-card-accent-top"></div>
          <div class="pokja-icon-circle" aria-hidden="true">
            <!-- Ikon Gotong Royong / Kerja Sama -->
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
          </div>
          <div class="pokja-card-body">
            <h3 class="pokja-card-title">Gotong Royong</h3>
            <p class="pokja-card-desc">
              Membangun kerja sama yang baik antara keluarga, warga dan kelompok.
            </p>
          </div>
        </div>

      </div>
    </section>

    <!-- 4. PITA STATISTIK (DENGAN POD KACA & ANIMASI COUNTER) -->
    <section id="statistik" class="pokja-stats-ribbon" aria-label="Statistik Pokja 1">
      <div class="pokja-stat-item">
        <div class="pokja-stat-number" data-target="2">2</div>
        <div class="pokja-stat-label">Program pokok</div>
      </div>
      <div class="pokja-stat-item">
        <div class="pokja-stat-number" data-target="7">7</div>
        <div class="pokja-stat-label">Tugas</div>
      </div>
      <div class="pokja-stat-item">
        <div class="pokja-stat-number" data-target="4">4</div>
        <div class="pokja-stat-label">Prioritas program</div>
      </div>
      <div class="pokja-stat-item">
        <div class="pokja-stat-number" data-target="3">3</div>
        <div class="pokja-stat-label">Kegiatan gotong royong</div>
      </div>
    </section>

    <!-- 5. TUGAS POKJA 1 (INTERAKTIF: PENCARIAN & FILTER KATEGORI) -->
    <section id="tugas" class="pokja-box" aria-label="Daftar Tugas Pokja 1">
      <div class="pokja-tugas-header">
        <h2 class="pokja-tugas-title">Tugas Pokja 1</h2>
        <p class="pokja-tugas-subtitle">Pokja 1 memiliki 7 tugas pokok pelaksanaan program.</p>
        
        <!-- Kolom Pencarian Cepat Interaktif -->
        <div class="pokja-search-wrap">
          <div class="pokja-search-box">
            <svg class="pokja-search-icon" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" id="tugasSearchInput" class="pokja-search-input" placeholder="Cari 7 tugas Pokja 1 (contoh: toleransi, bela negara, lansia...)" autocomplete="off">
          </div>

          <!-- Filter Kategori Chip -->
          <div class="pokja-filter-chips">
            <button type="button" class="pokja-chip-btn active" data-filter="all">Semua (7)</button>
            <button type="button" class="pokja-chip-btn" data-filter="kebangsaan">Pancasila &amp; Bela Negara</button>
            <button type="button" class="pokja-chip-btn" data-filter="keluarga">Keluarga &amp; Remaja</button>
            <button type="button" class="pokja-chip-btn" data-filter="sosial">Hukum &amp; Lansia</button>
          </div>
        </div>
      </div>

      <div class="pokja-tugas-container" id="tugasList">
        <!-- Tugas 01 -->
        <div class="pokja-tugas-row" data-category="kebangsaan">
          <div class="pokja-tugas-num">01</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">
              <span>Kerukunan umat beragama</span>
              <span class="pokja-badge">KEBANGSAAN</span>
            </h3>
            <p class="pokja-tugas-item-desc">
              Memantapkan kerukunan dan toleransi antar umat beragama, saling menghormati dan menghargai dalam wadah Negara Kesatuan Republik Indonesia.
            </p>
          </div>
        </div>

        <!-- Tugas 02 -->
        <div class="pokja-tugas-row" data-category="kebangsaan">
          <div class="pokja-tugas-num">02</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">
              <span>Ketahanan keluarga dan bela negara</span>
              <span class="pokja-badge">PKBN</span>
            </h3>
            <p class="pokja-tugas-item-desc">
              Meningkatkan ketahanan keluarga dalam rangka mewujudkan kesadaran setiap warga tentang Penghayatan dan Pengamalan Pancasila melalui Pembinaan Kesadaran Bela Negara (PKBN).
            </p>
          </div>
        </div>

        <!-- Tugas 03 -->
        <div class="pokja-tugas-row" data-category="keluarga">
          <div class="pokja-tugas-num">03</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">
              <span>Pola asuh anak dan remaja</span>
              <span class="pokja-badge">POLA ASUH</span>
            </h3>
            <p class="pokja-tugas-item-desc">
              Memantapkan pola asuh anak dan remaja dalam keluarga serta perlindungan anak melalui lokakarya dan ujicoba.
            </p>
          </div>
        </div>

        <!-- Tugas 04 -->
        <div class="pokja-tugas-row" data-category="keluarga">
          <div class="pokja-tugas-num">04</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">
              <span>Budi pekerti dan sopan santun</span>
              <span class="pokja-badge">KARAKTER</span>
            </h3>
            <p class="pokja-tugas-item-desc">
              Peningkatan pemahaman dan pengamalan perilaku budi pekerti dan sopan santun dalam keluarga dan lingkungan.
            </p>
          </div>
        </div>

        <!-- Tugas 05 -->
        <div class="pokja-tugas-row" data-category="sosial">
          <div class="pokja-tugas-num">05</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">
              <span>Kesadaran hukum</span>
              <span class="pokja-badge">KEDARKUM</span>
            </h3>
            <p class="pokja-tugas-item-desc">
              Meningkatkan pemahaman peraturan perundangan yang berkaitan dengan pencegahan Kekerasan Dalam Rumah Tangga (KDRT), pencegahan perdagangan orang (trafficking), dan penyalahgunaan narkoba melalui life skill dan parenting skill.
            </p>
          </div>
        </div>

        <!-- Tugas 06 -->
        <div class="pokja-tugas-row" data-category="sosial">
          <div class="pokja-tugas-num">06</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">
              <span>Gotong royong dan keamanan lingkungan</span>
              <span class="pokja-badge">TMMD</span>
            </h3>
            <p class="pokja-tugas-item-desc">
              Meningkatkan kesadaran hidup bergotong royong, kesetiakawanan sosial, keamanan lingkungan, Tentara Manunggal Membangun Desa (TMMD) dan lain-lainnya.
            </p>
          </div>
        </div>

        <!-- Tugas 07 -->
        <div class="pokja-tugas-row" data-category="sosial">
          <div class="pokja-tugas-num">07</div>
          <div class="pokja-tugas-detail">
            <h3 class="pokja-tugas-item-title">
              <span>Lansia produktif</span>
              <span class="pokja-badge">LANSIA</span>
            </h3>
            <p class="pokja-tugas-item-desc">
              Memberdayakan lansia dalam kegiatan yang produktif dan menjadi teladan dalam keluarga dan lingkungannya.
            </p>
          </div>
        </div>

        <!-- Pesan Kosong Jika Pencarian Tidak Ada -->
        <div id="tugasEmptyMessage" class="pokja-empty-state" style="display: none;">
          🔍 Tidak ditemukan tugas yang sesuai dengan pencarian. Silakan coba kata kunci lain.
        </div>
      </div>
    </section>

    <!-- 6. PRIORITAS PROGRAM (KARTU ELEGAN DENGAN AKSEN GRADASI) -->
    <section id="prioritas" class="pokja-box" aria-label="Prioritas Program Pokja 1">
      <h2 class="pokja-box-title">Prioritas program</h2>
      
      <div class="pokja-grid-2">
        <!-- Prioritas 1 -->
        <div class="pokja-card">
          <div class="pokja-card-accent-top"></div>
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Buku Pedoman -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Penghayatan dan Pengamalan Pancasila</h3>
                <span class="pokja-badge">PANCASILA</span>
              </div>
              <p class="pokja-card-desc">
                Menumbuhkan ketahanan keluarga melalui kesadaran bermasyarakat, berbangsa dan bernegara. Pemahaman perlu dilaksanakan secara terpadu.
              </p>
            </div>
          </div>
        </div>

        <!-- Prioritas 2 -->
        <div class="pokja-card">
          <div class="pokja-card-accent-top"></div>
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Bendera Bela Negara -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path>
                <line x1="4" y1="22" x2="4" y2="15"></line>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Pembinaan Kesadaran Bela Negara</h3>
                <span class="pokja-badge">PKBN</span>
              </div>
              <p class="pokja-card-desc">
                Mencakup lima unsur: cinta tanah air, kesadaran berbangsa dan bernegara, keyakinan atas kebenaran Pancasila, kerelaan berkorban untuk bangsa dan negara, serta memiliki kemampuan awal bela negara.
              </p>
            </div>
          </div>
        </div>

        <!-- Prioritas 3 -->
        <div class="pokja-card">
          <div class="pokja-card-accent-top"></div>
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Neraca Hukum -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <line x1="12" y1="3" x2="12" y2="21"></line>
                <polyline points="3 8 12 5 21 8"></polyline>
                <polygon points="1.5 13 4.5 13 3 8"></polygon>
                <polygon points="19.5 13 22.5 13 21 8"></polygon>
                <path d="M7 21h10"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Kesadaran Hukum</h3>
                <span class="pokja-badge">KEDARKUM</span>
              </div>
              <p class="pokja-card-desc">
                Upaya meningkatkan pemahaman peraturan perundang-undangan. Diprioritaskan di PKK untuk pencegahan KDRT, trafficking, perlindungan anak, narkoba dan lain-lain.
              </p>
            </div>
          </div>
        </div>

        <!-- Prioritas 4 -->
        <div class="pokja-card">
          <div class="pokja-card-accent-top"></div>
          <div class="pokja-program-card">
            <div class="pokja-icon-circle" aria-hidden="true">
              <!-- Ikon Kasih Sayang Keluarga -->
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
              </svg>
            </div>
            <div class="pokja-card-body">
              <div class="pokja-prioritas-card-header">
                <h3 class="pokja-card-title">Pola Asuh Anak dan Remaja</h3>
                <span class="pokja-badge">POLA ASUH</span>
              </div>
              <p class="pokja-card-desc">
                Upaya menumbuhkan dan membangun perilaku, budi pekerti dan sopan santun di dalam keluarga sesuai budaya bangsa.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Kotak Catatan Singkatan -->
      <div class="pokja-prioritas-note">
        <strong>Arti singkatan:</strong> PKBN = Pembinaan Kesadaran Bela Negara. KEDARKUM = Kesadaran Hukum. KDRT = Kekerasan Dalam Rumah Tangga. TMMD = Tentara Manunggal Membangun Desa.
      </div>
    </section>

    <!-- 7. GOTONG ROYONG -->
    <section id="gotong-royong" class="pokja-box" aria-label="Kegiatan Gotong Royong Pokja 1">
      <h2 class="pokja-box-title">Gotong royong</h2>
      <p class="pokja-gotong-intro">
        Kegiatan dilaksanakan dengan membangun kerja sama yang baik antara keluarga, warga dan kelompok untuk mewujudkan semangat persatuan dan kesatuan.
      </p>

      <div class="pokja-grid-3">
        <!-- Kartu 1 -->
        <div class="pokja-card pokja-gotong-card">
          <div class="pokja-card-accent-top"></div>
          <div class="pokja-icon-circle" aria-hidden="true">
            <!-- Ikon Kebersamaan / Handshake -->
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
              <line x1="19" y1="8" x2="19" y2="14"></line>
              <line x1="22" y1="11" x2="16" y2="11"></line>
            </svg>
          </div>
          <div>
            <h3 class="pokja-card-title">Kebersamaan</h3>
            <p class="pokja-card-desc">
              Menumbuhkan kesadaran, kesetiakawanan sosial, bertenggang rasa dan kebersamaan serta saling menghormati antar umat beragama.
            </p>
          </div>
        </div>

        <!-- Kartu 2 -->
        <div class="pokja-card pokja-gotong-card">
          <div class="pokja-card-accent-top"></div>
          <div class="pokja-icon-circle" aria-hidden="true">
            <!-- Ikon Lansia Produktif / Vitalitas -->
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <circle cx="12" cy="12" r="4"></circle>
              <path d="M12 2v2"></path>
              <path d="M12 20v2"></path>
              <path d="M4.93 4.93l1.41 1.41"></path>
              <path d="M17.66 17.66l1.41 1.41"></path>
              <path d="M2 12h2"></path>
              <path d="M20 12h2"></path>
              <path d="M4.93 19.07l1.41-1.41"></path>
              <path d="M17.66 6.34l1.41-1.41"></path>
            </svg>
          </div>
          <div>
            <h3 class="pokja-card-title">Lansia produktif</h3>
            <p class="pokja-card-desc">
              Memberdayakan lansia agar dapat menjaga kesehatan fisik dan mental, kebugaran, serta keterampilan, sehingga menjadi teladan bagi keluarga dan lingkungannya.
            </p>
          </div>
        </div>

        <!-- Kartu 3 -->
        <div class="pokja-card pokja-gotong-card">
          <div class="pokja-card-accent-top"></div>
          <div class="pokja-icon-circle" aria-hidden="true">
            <!-- Ikon Bakti Sosial / TMMD -->
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
            </svg>
          </div>
          <div>
            <h3 class="pokja-card-title">Bakti sosial dan TMMD</h3>
            <p class="pokja-card-desc">
              Berpartisipasi dalam pelaksanaan kegiatan bakti sosial dan kegiatan Tentara Manunggal Membangun Desa (TMMD).
            </p>
          </div>
        </div>
      </div>
    </section>

  </div>
</div>

{{-- SCRIPT INTERAKTIF KHUSUS POKJA 1 --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  // 1. ANIMASI PENGHITUNG ANGKA STATISTIK (COUNT-UP)
  const counters = document.querySelectorAll('.pokja-stat-number');
  if ('IntersectionObserver' in window) {
    const counterObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const el = entry.target;
          const target = parseInt(el.getAttribute('data-target') || el.innerText, 10);
          if (!isNaN(target)) {
            let current = 0;
            const step = Math.max(1, Math.floor(target / 20));
            const timer = setInterval(() => {
              current += step;
              if (current >= target) {
                el.innerText = target;
                clearInterval(timer);
              } else {
                el.innerText = current;
              }
            }, 40);
          }
          observer.unobserve(el);
        }
      });
    }, { threshold: 0.5 });

    counters.forEach(counter => counterObserver.observe(counter));
  }

  // 2. LIVE SEARCH & FILTER CHIP UNTUK 7 TUGAS POKJA 1
  const searchInput = document.getElementById('tugasSearchInput');
  const chipBtns = document.querySelectorAll('.pokja-chip-btn');
  const tugasRows = document.querySelectorAll('.pokja-tugas-row');
  const emptyMsg = document.getElementById('tugasEmptyMessage');

  let currentCategory = 'all';
  let searchQuery = '';

  function filterTugas() {
    let visibleCount = 0;
    const q = searchQuery.toLowerCase().trim();

    tugasRows.forEach(row => {
      const category = row.getAttribute('data-category') || '';
      const text = row.innerText.toLowerCase();

      const matchCategory = (currentCategory === 'all' || category === currentCategory);
      const matchSearch = (!q || text.includes(q));

      if (matchCategory && matchSearch) {
        row.style.display = 'flex';
        visibleCount++;
      } else {
        row.style.display = 'none';
      }
    });

    if (emptyMsg) {
      emptyMsg.style.display = (visibleCount === 0) ? 'block' : 'none';
    }
  }

  if (searchInput) {
    searchInput.addEventListener('input', function (e) {
      searchQuery = e.target.value;
      filterTugas();
    });
  }

  chipBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      chipBtns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      currentCategory = this.getAttribute('data-filter') || 'all';
      filterTugas();
    });
  });

  // 3. KLIK PADA BARIS TUGAS UNTUK TOGGLE HIGHLIGHT
  tugasRows.forEach(row => {
    row.addEventListener('click', function () {
      const isAlreadyActive = this.classList.contains('active');
      tugasRows.forEach(r => r.classList.remove('active'));
      if (!isAlreadyActive) {
        this.classList.add('active');
      }
    });
  });

});
</script>

@endsection
