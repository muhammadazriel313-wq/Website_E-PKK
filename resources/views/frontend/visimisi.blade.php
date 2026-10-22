@extends('frontend/layouts.template')

@section('content')

<style>
  /* =========================================================
     CSS VARIABLES & SCOPED STYLES: VISI MISI PKK (Prefix: vmp-)
     ========================================================= */
  :root {
    --vmp-blue: #0067a3;
    --vmp-blue-hover: #005688;
    --vmp-blue-light: #e5f0f7;
    --vmp-bg: #f5f5f5;
    --vmp-card-bg: #ffffff;
    --vmp-border: #e0e0e0;
    --vmp-text: #161616;
    --vmp-text-muted: #5f6368;
  }

  .vmp-section {
    background-color: var(--vmp-bg);
    padding-top: 110px;
    padding-bottom: 80px;
    min-height: calc(100vh - 120px);
    font-family: 'Poppins', sans-serif;
    color: var(--vmp-text);
  }

  .vmp-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
  }

  /* Header Section */
  .vmp-header {
    margin-bottom: 36px;
    text-align: left;
  }

  .vmp-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 36px;
    line-height: 1.25;
    color: var(--vmp-text);
    margin: 0 0 6px 0;
    letter-spacing: -0.5px;
  }

  .vmp-subtitle {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 18px;
    color: var(--vmp-blue);
    margin: 0 0 12px 0;
    letter-spacing: 0.2px;
  }

  .vmp-blue-line {
    width: 60px;
    height: 4px;
    background-color: var(--vmp-blue);
    border-radius: 2px;
  }

  /* 2-Column Grid (5:7 ratio) */
  .vmp-grid {
    display: grid;
    grid-template-columns: 5fr 7fr;
    gap: 32px;
    align-items: start;
  }

  /* =========================================================
     KIRI: PANEL VISI (Sticky)
     ========================================================= */
  .vmp-visi-wrapper {
    position: sticky;
    top: 105px;
    z-index: 5;
  }

  .vmp-visi-card {
    position: relative;
    background-color: var(--vmp-blue);
    border-radius: 20px;
    padding: 38px 30px;
    color: #ffffff;
    overflow: hidden;
    box-shadow: 0 12px 30px -10px rgba(0, 103, 163, 0.35);
  }

  /* Pola Batik Putih Tipis SVG Overlay */
  .vmp-visi-pattern {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1;
  }

  .vmp-visi-content {
    position: relative;
    z-index: 2;
  }

  /* Visi Header Badge */
  .vmp-visi-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #ffffff;
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 22px;
  }

  .vmp-visi-badge-dot {
    width: 8px;
    height: 8px;
    background: #ffffff;
    border-radius: 50%;
  }

  /* Quote Symbol */
  .vmp-visi-quote-icon {
    display: block;
    margin-bottom: 12px;
    color: rgba(255, 255, 255, 0.9);
  }

  /* Teks Visi Besar */
  .vmp-visi-text {
    font-family: 'Poppins', sans-serif;
    font-size: 1.25rem;
    line-height: 1.75;
    font-weight: 500;
    color: #ffffff;
    margin: 0 0 26px 0;
    letter-spacing: -0.2px;
  }

  /* Chip Container & Items */
  .vmp-chips-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }

  .vmp-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #ffffff;
    padding: 7px 15px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 500;
    transition: background-color 0.2s ease;
  }

  .vmp-chip:hover {
    background: rgba(255, 255, 255, 0.22);
    color: #ffffff;
  }

  .vmp-chip-icon {
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* =========================================================
     KANAN: PANEL MISI
     ========================================================= */
  .vmp-misi-wrapper {
    background: var(--vmp-card-bg);
    border: 1px solid var(--vmp-border);
    border-radius: 20px;
    padding: 34px 32px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
  }

  .vmp-misi-head-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--vmp-border);
  }

  .vmp-misi-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 22px;
    color: var(--vmp-text);
    margin: 0;
    letter-spacing: -0.3px;
  }

  .vmp-misi-badge-counter {
    font-size: 12px;
    font-weight: 600;
    color: var(--vmp-blue);
    background: var(--vmp-blue-light);
    border: 1px solid rgba(0, 103, 163, 0.15);
    padding: 4px 12px;
    border-radius: 20px;
  }

  .vmp-misi-list {
    display: flex;
    flex-direction: column;
  }

  /* Misi Item - Dipisah garis tipis, BUKAN kartu */
  .vmp-misi-item {
    display: flex;
    align-items: flex-start;
    gap: 18px;
    padding: 20px 4px;
    border-bottom: 1px solid var(--vmp-border);
    transition: background-color 0.2s ease;
  }

  .vmp-misi-item:first-child {
    padding-top: 14px;
  }

  .vmp-misi-item:last-child {
    border-bottom: none;
    padding-bottom: 8px;
  }

  /* 56px Rounded Icon Box (latar #e5f0f7) */
  .vmp-icon-box {
    width: 56px;
    height: 56px;
    min-width: 56px;
    min-height: 56px;
    border-radius: 14px;
    background-color: var(--vmp-blue-light);
    color: var(--vmp-blue);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .vmp-misi-content {
    flex: 1;
    min-width: 0;
  }

  .vmp-misi-item-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 16.5px;
    color: var(--vmp-text);
    margin: 0 0 5px 0;
    display: flex;
    align-items: baseline;
    gap: 6px;
    line-height: 1.4;
  }

  .vmp-misi-item-desc {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 14.5px;
    color: var(--vmp-text-muted);
    line-height: 1.68;
    margin: 0;
  }

  /* =========================================================
     RESPONSIVE BREAKPOINTS (360px, 768px, 860px, 1280px)
     ========================================================= */
  @media (max-width: 991px) {
    .vmp-grid {
      gap: 24px;
    }
    .vmp-visi-card {
      padding: 30px 24px;
    }
    .vmp-misi-wrapper {
      padding: 28px 24px;
    }
  }

  /* Di bawah 860px: Jadi 1 kolom, panel visi di atas, sticky off */
  @media (max-width: 860px) {
    .vmp-grid {
      grid-template-columns: 1fr;
      gap: 28px;
    }
    .vmp-visi-wrapper {
      position: static;
      top: auto;
    }
  }

  @media (max-width: 576px) {
    .vmp-section {
      padding-top: 95px;
      padding-bottom: 60px;
    }
    .vmp-header {
      margin-bottom: 24px;
    }
    .vmp-title {
      font-size: 28px;
    }
    .vmp-subtitle {
      font-size: 16px;
    }
    .vmp-visi-card {
      padding: 24px 18px;
      border-radius: 16px;
    }
    .vmp-visi-text {
      font-size: 1.12rem;
      line-height: 1.65;
      margin-bottom: 20px;
    }
    .vmp-chip {
      font-size: 12.5px;
      padding: 6px 12px;
    }
    .vmp-misi-wrapper {
      padding: 22px 18px;
      border-radius: 16px;
    }
    .vmp-misi-title {
      font-size: 19px;
    }
    .vmp-misi-item {
      gap: 14px;
      padding: 16px 2px;
    }
    .vmp-icon-box {
      width: 48px;
      height: 48px;
      min-width: 48px;
      min-height: 48px;
      border-radius: 12px;
    }
    .vmp-icon-box svg {
      width: 24px;
      height: 24px;
    }
    .vmp-misi-item-title {
      font-size: 15.5px;
    }
    .vmp-misi-item-desc {
      font-size: 13.5px;
      line-height: 1.6;
    }
  }
</style>

<section class="vmp-section">
    <div class="vmp-container">
        <!-- Header: Rata Kiri, Judul, Subjudul, Garis Biru Pendek -->
        <div class="vmp-header">
            <h1 class="vmp-title">Visi Misi PKK</h1>
            <p class="vmp-subtitle">Kabupaten Nganjuk</p>
            <div class="vmp-blue-line"></div>
        </div>

        <!-- 2 Kolom Layout (Desktop 5:7, Mobile 1 Kolom) -->
        <div class="vmp-grid">
            
            <!-- KIRI: PANEL VISI (Sticky) -->
            <div class="vmp-visi-wrapper">
                <div class="vmp-visi-card">
                    <!-- Pola Lingkaran Putih Tipis Bergaya Batik (SVG, opacity ~0.15) -->
                    <svg class="vmp-visi-pattern" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="vmpBatikPatternWhite" width="60" height="60" patternUnits="userSpaceOnUse">
                                <circle cx="30" cy="30" r="22" fill="none" stroke="#FFFFFF" stroke-width="1.2" />
                                <circle cx="0" cy="0" r="22" fill="none" stroke="#FFFFFF" stroke-width="1.2" />
                                <circle cx="60" cy="0" r="22" fill="none" stroke="#FFFFFF" stroke-width="1.2" />
                                <circle cx="0" cy="60" r="22" fill="none" stroke="#FFFFFF" stroke-width="1.2" />
                                <circle cx="60" cy="60" r="22" fill="none" stroke="#FFFFFF" stroke-width="1.2" />
                                <ellipse cx="30" cy="15" rx="5" ry="9" fill="none" stroke="#FFFFFF" stroke-width="1" />
                                <ellipse cx="30" cy="45" rx="5" ry="9" fill="none" stroke="#FFFFFF" stroke-width="1" />
                                <ellipse cx="15" cy="30" rx="9" ry="5" fill="none" stroke="#FFFFFF" stroke-width="1" />
                                <ellipse cx="45" cy="30" rx="9" ry="5" fill="none" stroke="#FFFFFF" stroke-width="1" />
                                <circle cx="30" cy="30" r="3.5" fill="#FFFFFF" />
                                <circle cx="0" cy="0" r="3.5" fill="#FFFFFF" />
                                <circle cx="60" cy="0" r="3.5" fill="#FFFFFF" />
                                <circle cx="0" cy="60" r="3.5" fill="#FFFFFF" />
                                <circle cx="60" cy="60" r="3.5" fill="#FFFFFF" />
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#vmpBatikPatternWhite)" opacity="0.15" />
                    </svg>

                    <!-- Konten Visi -->
                    <div class="vmp-visi-content">
                        <!-- Badge Visi -->
                        <div class="vmp-visi-badge">
                            <span class="vmp-visi-badge-dot"></span>
                            <span>Visi Tim Penggerak PKK</span>
                        </div>

                        <!-- Quote Icon -->
                        <svg class="vmp-visi-quote-icon" width="32" height="26" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                        </svg>

                        <!-- Teks Visi Besar -->
                        <p class="vmp-visi-text">
                            &ldquo;Terwujudnya keluarga yang beriman dan bertaqwa kepada Tuhan Yang Maha Esa, berakhlak mulia dan berbudi luhur, sehat sejahtera lahir dan batin.&rdquo;
                        </p>

                        <!-- 3 Chips -->
                        <div class="vmp-chips-wrapper">
                            <div class="vmp-chip">
                                <span class="vmp-chip-icon">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                </span>
                                <span>Beriman &amp; bertaqwa</span>
                            </div>
                            <div class="vmp-chip">
                                <span class="vmp-chip-icon">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </span>
                                <span>Berakhlak mulia</span>
                            </div>
                            <div class="vmp-chip">
                                <span class="vmp-chip-icon">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                                    </svg>
                                </span>
                                <span>Sehat sejahtera lahir batin</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KANAN: PANEL MISI -->
            <div class="vmp-misi-wrapper">
                <div class="vmp-misi-head-row">
                    <h2 class="vmp-misi-title">Misi Tim Penggerak PKK</h2>
                    <span class="vmp-misi-badge-counter">5 Misi Utama</span>
                </div>

                <div class="vmp-misi-list">
                    <!-- Item 1: Karakter keluarga -->
                    <div class="vmp-misi-item">
                        <div class="vmp-icon-box">
                            <!-- SVG: Karakter Keluarga & Pancasila Shield -->
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                <path d="M12 8c-1.5-1.5-3.5-1-4 .5-.8 2.3 4 5.5 4 5.5s4.8-3.2 4-5.5c-.5-1.5-2.5-2-4-.5z" fill="currentColor" fill-opacity="0.2"/>
                            </svg>
                        </div>
                        <div class="vmp-misi-content">
                            <h3 class="vmp-misi-item-title">
                                <span>1.</span> Karakter keluarga
                            </h3>
                            <p class="vmp-misi-item-desc">
                                Meningkatkan pembentukan karakter keluarga melalui penghayatan, pengamalan Pancasila, gotong royong serta kesetaraan dan keadilan gender.
                            </p>
                        </div>
                    </div>

                    <!-- Item 2: Pendidikan & ekonomi -->
                    <div class="vmp-misi-item">
                        <div class="vmp-icon-box">
                            <!-- SVG: Pendidikan & Koperasi / Pertumbuhan Ekonomi -->
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                                <circle cx="18" cy="18" r="3" fill="currentColor" fill-opacity="0.2"/>
                                <path d="M18 16.5v3M17 18h2"/>
                            </svg>
                        </div>
                        <div class="vmp-misi-content">
                            <h3 class="vmp-misi-item-title">
                                <span>2.</span> Pendidikan &amp; ekonomi
                            </h3>
                            <p class="vmp-misi-item-desc">
                                Meningkatkan pendidikan dan ekonomi keluarga melalui berbagai upaya keterampilan dan pengembangan koperasi.
                            </p>
                        </div>
                    </div>

                    <!-- Item 3: Pangan sandang & papan -->
                    <div class="vmp-misi-item">
                        <div class="vmp-icon-box">
                            <!-- SVG: Pangan, Sandang & Papan / Rumah Layak Huni -->
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <path d="M9 22V12h6v10"/>
                                <path d="M12 7.5v2.5M10.5 8.5l3 1M13.5 8.5l-3 1"/>
                            </svg>
                        </div>
                        <div class="vmp-misi-content">
                            <h3 class="vmp-misi-item-title">
                                <span>3.</span> Pangan sandang &amp; papan
                            </h3>
                            <p class="vmp-misi-item-desc">
                                Meningkatkan ketahanan keluarga melalui pemenuhan pangan, sandang dan perumahan sehat dan layak huni.
                            </p>
                        </div>
                    </div>

                    <!-- Item 4: Kesehatan & lingkungan -->
                    <div class="vmp-misi-item">
                        <div class="vmp-icon-box">
                            <!-- SVG: Kesehatan & Lingkungan Hidup / Daun & Pulse -->
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 20A7 7 0 0 1 4 13a7 7 0 0 1 7-7c5 0 8 3 8 8 0 3.3-2.7 6-6 6z"/>
                                <path d="M8 13.5h2l1.5-3 2 6 1.5-3h2"/>
                                <path d="M20 4c-3 0-6 2-7 5"/>
                            </svg>
                        </div>
                        <div class="vmp-misi-content">
                            <h3 class="vmp-misi-item-title">
                                <span>4.</span> Kesehatan &amp; lingkungan
                            </h3>
                            <p class="vmp-misi-item-desc">
                                Meningkatkan derajat kesehatan keluarga, kelestarian lingkungan hidup serta perencanaan sehat.
                            </p>
                        </div>
                    </div>

                    <!-- Item 5: Organisasi & SDM -->
                    <div class="vmp-misi-item">
                        <div class="vmp-icon-box">
                            <!-- SVG: Organisasi & SDM / Jaringan Tim -->
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                        <div class="vmp-misi-content">
                            <h3 class="vmp-misi-item-title">
                                <span>5.</span> Organisasi &amp; SDM
                            </h3>
                            <p class="vmp-misi-item-desc">
                                Meningkatkan pengelolaan Gerakan PKK meliputi kegiatan pengorganisasian dan peningkatan Sumberdaya Manusia.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection