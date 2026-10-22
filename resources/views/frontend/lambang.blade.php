@extends('frontend/layouts.template')

@section('content')

@php
$warnaList = [
    [
        'kode' => 'a',
        'nama' => 'Biru',
        'hex' => '#1e9bdb',
        'deskripsi' => 'Melambangkan suasana damai, aman, tenteram dan sejahtera.'
    ],
    [
        'kode' => 'b',
        'nama' => 'Putih',
        'hex' => '#ffffff',
        'border' => true,
        'deskripsi' => 'Melambangkan kesucian dan ketulusan untuk satu tujuan dan itikad.'
    ],
    [
        'kode' => 'c',
        'nama' => 'Kuning',
        'hex' => '#f2c91e',
        'deskripsi' => 'Melambangkan keagungan dan cita-cita luhur.'
    ],
    [
        'kode' => 'd',
        'nama' => 'Hitam',
        'hex' => '#1a1a1a',
        'deskripsi' => 'Melambangkan kekekalan dan keabadian.'
    ],
];

$komponenList = [
    [
        'huruf' => 'a',
        'judul' => 'Segilima',
        'deskripsi' => 'Segilima melambangkan Pancasila sebagai dasar Gerakan PKK.',
        'full_width' => false,
    ],
    [
        'huruf' => 'b',
        'judul' => 'Bintang',
        'deskripsi' => 'Bintang melambangkan Ketuhanan Yang Maha Esa.',
        'full_width' => false,
    ],
    [
        'huruf' => 'c',
        'judul' => '17 Butir Kapas, 8 Buah Simpul Pengikat, 45 Butir Padi',
        'deskripsi' => 'Melambangkan kemerdekaan Republik Indonesia (17 Agustus 1945) dan kemakmuran seluruh rakyat Indonesia.',
        'full_width' => true,
        'angka_highlight' => [
            [
                'angka' => '17',
                'label' => 'Butir Kapas',
                'makna' => 'Tanggal kemerdekaan RI'
            ],
            [
                'angka' => '8',
                'label' => 'Simpul Pengikat',
                'makna' => 'Bulan kemerdekaan RI'
            ],
            [
                'angka' => '45',
                'label' => 'Butir Padi',
                'makna' => 'Tahun kemerdekaan & kemakmuran'
            ],
        ],
        'sub_bagian' => [
            [
                'judul' => 'Akolade Melingkar',
                'deskripsi' => 'Melambangkan wahana partisipasi masyarakat dalam pembangunan yang memadukan pelaksanaan segala kegiatan dan prakarsa serta swadaya gotong royong masyarakat dalam segala aspek kehidupan dan penghidupan untuk mewujudkan Ketahanan Nasional.'
            ],
            [
                'judul' => 'Rangkaian Mata Rantai',
                'deskripsi' => 'Melambangkan masyarakat yang terdiri dari keluarga-keluarga sebagai unit terkecil yang merupakan sasaran Gerakan PKK.'
            ]
        ]
    ],
    [
        'huruf' => 'd',
        'judul' => 'Lingkaran Putih',
        'deskripsi' => 'Lingkaran Putih melambangkan Pemberdayaan dan Kesejahteraan Keluarga dilaksanakan secara terus menerus dan berkesinambungan.',
        'full_width' => false,
    ],
    [
        'huruf' => 'e',
        'judul' => '10 Ujung Tombak',
        'deskripsi' => '10 buah ujung tombak yang tersusun merupakan bunga melambangkan gerakan masyarakat dalam pembangunan dengan melaksanakan 10 Program Pokok PKK dan sasarannya keluarga sebagai unit terkecil dalam masyarakat.',
        'full_width' => false,
    ],
];
@endphp

<style>
  :root {
    --alp-blue: #0067a3;
    --alp-blue-hover: #005688;
    --alp-blue-light: #e5f0f7;
    --alp-bg: #f5f5f5;
    --alp-card-bg: #ffffff;
    --alp-border: #e0e0e0;
    --alp-text: #161616;
    --alp-text-muted: #5f6368;
  }

  .alp-section {
    background-color: var(--alp-bg);
    padding-top: 110px;
    padding-bottom: 80px;
    min-height: calc(100vh - 120px);
    font-family: 'Poppins', sans-serif;
    color: var(--alp-text);
  }

  .alp-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
  }

  /* =========================================================
     HERO PANEL: Biru dengan pola batik putih tipis
     ========================================================= */
  .alp-hero-card {
    position: relative;
    background-color: var(--alp-blue);
    border-radius: 20px;
    padding: 44px 40px;
    color: #ffffff;
    overflow: hidden;
    margin-bottom: 48px;
    box-shadow: 0 12px 30px -10px rgba(0, 103, 163, 0.35);
  }

  .alp-hero-pattern {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1;
  }

  .alp-hero-grid {
    position: relative;
    z-index: 2;
    display: grid;
    grid-template-columns: 1.3fr 0.7fr;
    gap: 36px;
    align-items: center;
  }

  .alp-hero-badge {
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
    margin-bottom: 18px;
  }

  .alp-hero-badge-dot {
    width: 8px;
    height: 8px;
    background: #ffffff;
    border-radius: 50%;
  }

  .alp-hero-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 34px;
    line-height: 1.25;
    color: #ffffff;
    margin: 0 0 8px 0;
    letter-spacing: -0.5px;
  }

  .alp-hero-subtitle {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 18px;
    color: #dbeafe;
    margin: 0 0 14px 0;
  }

  .alp-hero-line {
    width: 60px;
    height: 4px;
    background-color: #ffffff;
    border-radius: 2px;
    margin-bottom: 18px;
  }

  .alp-hero-intro {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 15px;
    line-height: 1.7;
    color: rgba(255, 255, 255, 0.92);
    margin: 0;
  }

  .alp-hero-logo-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .alp-hero-logo {
    max-width: 250px;
    width: 100%;
    height: auto;
    display: block;
    filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.2));
  }

  /* =========================================================
     SECTION HEADINGS
     ========================================================= */
  .alp-section-head {
    margin-bottom: 24px;
    text-align: left;
  }

  .alp-section-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 24px;
    color: var(--alp-text);
    margin: 0 0 6px 0;
    letter-spacing: -0.3px;
  }

  .alp-section-desc {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 14.5px;
    color: var(--alp-text-muted);
    margin: 0;
  }

  /* =========================================================
     BAGIAN 1: GRID WARNA (4 Kolom)
     ========================================================= */
  .alp-warna-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 48px;
  }

  .alp-warna-card {
    background: var(--alp-card-bg);
    border: 1px solid var(--alp-border);
    border-radius: 16px;
    padding: 22px 20px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    display: flex;
    flex-direction: column;
  }

  .alp-color-box {
    width: 100%;
    height: 48px;
    border-radius: 10px;
    margin-bottom: 16px;
  }

  .alp-warna-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 16.5px;
    color: var(--alp-text);
    margin: 0 0 8px 0;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .alp-warna-desc {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 13.5px;
    color: var(--alp-text-muted);
    line-height: 1.6;
    margin: 0;
  }

  /* =========================================================
     BAGIAN 2: GRID KOMPONEN (2 Kolom & Kartu C Full Width)
     ========================================================= */
  .alp-komponen-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
  }

  .alp-komponen-card {
    background: var(--alp-card-bg);
    border: 1px solid var(--alp-border);
    border-radius: 18px;
    padding: 28px 26px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    display: flex;
    flex-direction: column;
  }

  .alp-komponen-card.full-width {
    grid-column: 1 / -1;
  }

  .alp-komponen-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 14px;
  }

  .alp-badge-letter {
    width: 38px;
    height: 38px;
    min-width: 38px;
    min-height: 38px;
    border-radius: 50%;
    background-color: var(--alp-blue);
    color: #ffffff;
    font-weight: 700;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .alp-komponen-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 18px;
    color: var(--alp-text);
    margin: 0;
    line-height: 1.35;
  }

  .alp-komponen-desc {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 14.5px;
    color: var(--alp-text-muted);
    line-height: 1.68;
    margin: 0;
  }

  /* Highlight Angka Besar untuk Kartu C (17, 8, 45) */
  .alp-angka-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin: 22px 0 24px 0;
  }

  .alp-angka-item {
    background: var(--alp-blue-light);
    border: 1px solid rgba(0, 103, 163, 0.15);
    border-radius: 14px;
    padding: 20px 16px;
    text-align: center;
  }

  .alp-angka-value {
    font-family: 'Poppins', sans-serif;
    font-weight: 800;
    font-size: 36px;
    line-height: 1;
    color: var(--alp-blue);
    margin-bottom: 6px;
  }

  .alp-angka-label {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 14.5px;
    color: var(--alp-text);
    margin-bottom: 4px;
  }

  .alp-angka-makna {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 12.5px;
    color: var(--alp-text-muted);
    line-height: 1.4;
  }

  /* Sub-bagian Kartu C (Akolade Melingkar & Rangkaian Mata Rantai) */
  .alp-sub-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
    margin-top: 10px;
    padding-top: 20px;
    border-top: 1px solid var(--alp-border);
  }

  .alp-sub-item {
    background: #fafafa;
    border: 1px solid var(--alp-border);
    border-radius: 12px;
    padding: 18px 18px;
  }

  .alp-sub-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 15px;
    color: var(--alp-blue);
    margin: 0 0 6px 0;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .alp-sub-desc {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 13.5px;
    color: var(--alp-text-muted);
    line-height: 1.62;
    margin: 0;
  }

  /* =========================================================
     RESPONSIVE BREAKPOINTS (360px, 768px, 860px, 1280px)
     ========================================================= */
  @media (max-width: 991px) {
    .alp-hero-card {
      padding: 34px 28px;
    }
    .alp-warna-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 16px;
    }
  }

  /* Di bawah 860px: Layout hero & komponen jadi 1 kolom */
  @media (max-width: 860px) {
    .alp-hero-grid {
      grid-template-columns: 1fr;
      text-align: center;
      gap: 28px;
    }
    .alp-hero-line {
      margin-left: auto;
      margin-right: auto;
    }
    .alp-hero-logo {
      max-width: 200px;
    }
    .alp-komponen-grid {
      grid-template-columns: 1fr;
      gap: 20px;
    }
    .alp-sub-grid {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 576px) {
    .alp-section {
      padding-top: 95px;
      padding-bottom: 60px;
    }
    .alp-hero-card {
      padding: 26px 20px;
      border-radius: 16px;
      margin-bottom: 36px;
    }
    .alp-hero-title {
      font-size: 26px;
    }
    .alp-hero-subtitle {
      font-size: 16px;
    }
    .alp-hero-intro {
      font-size: 14px;
    }
    .alp-warna-grid {
      grid-template-columns: 1fr;
      gap: 14px;
      margin-bottom: 36px;
    }
    .alp-angka-grid {
      grid-template-columns: 1fr;
      gap: 12px;
    }
    .alp-komponen-card {
      padding: 22px 18px;
      border-radius: 16px;
    }
    .alp-komponen-title {
      font-size: 16.5px;
    }
    .alp-komponen-desc {
      font-size: 13.5px;
    }
  }
</style>

<section class="alp-section">
    <div class="alp-container">
        
        <!-- HERO PANEL: Biru dengan pola batik putih tipis -->
        <div class="alp-hero-card">
            <!-- Pola Lingkaran Putih Tipis Bergaya Batik (SVG, opacity ~0.15) -->
            <svg class="alp-hero-pattern" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="alpHeroBatikWhite" width="60" height="60" patternUnits="userSpaceOnUse">
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
                <rect width="100%" height="100%" fill="url(#alpHeroBatikWhite)" opacity="0.15" />
            </svg>

            <div class="alp-hero-grid">
                <!-- Kiri: Judul, Subjudul, Garis, Kalimat Pengantar -->
                <div>
                    <div class="alp-hero-badge">
                        <span class="alp-hero-badge-dot"></span>
                        <span>Profil &amp; Filosofi PKK</span>
                    </div>
                    <h1 class="alp-hero-title">Arti dan Lambang PKK</h1>
                    <p class="alp-hero-subtitle">Kabupaten Nganjuk</p>
                    <div class="alp-hero-line"></div>
                    <p class="alp-hero-intro">
                        Lambang Gerakan PKK melambangkan semangat pengabdian, persatuan, dan tujuan luhur dalam mewujudkan keluarga yang sehat, sejahtera, maju, dan mandiri berlandaskan Pancasila.
                    </p>
                </div>

                <!-- Kanan: Logo PKK (Maks 280px) -->
                <div class="alp-hero-logo-wrapper">
                    <img src="{{ asset('frontend/assets/img/logopkk.png') }}" alt="Logo PKK Kabupaten Nganjuk" class="alp-hero-logo">
                </div>
            </div>
        </div>

        <!-- BAGIAN 1: WARNA (Grid 4 Kolom, Perulangan Array) -->
        <div class="alp-section-head">
            <h2 class="alp-section-title">Makna Warna</h2>
            <p class="alp-section-desc">Filosofi dan arti dari setiap warna pada lambang Gerakan PKK</p>
        </div>

        <div class="alp-warna-grid">
            @foreach($warnaList as $warna)
            <div class="alp-warna-card">
                <div class="alp-color-box" style="background-color: {{ $warna['hex'] }}; {{ !empty($warna['border']) ? 'border: 1px solid #d0d0d0;' : '' }}"></div>
                <h3 class="alp-warna-title">
                    <span>{{ $warna['kode'] }}.</span> {{ $warna['nama'] }}
                </h3>
                <p class="alp-warna-desc">
                    {{ $warna['deskripsi'] }}
                </p>
            </div>
            @endforeach
        </div>

        <!-- BAGIAN 2: KOMPONEN (Grid 2 Kolom, Kartu C Selebar Penuh, Perulangan Array) -->
        <div class="alp-section-head">
            <h2 class="alp-section-title">Makna Komponen</h2>
            <p class="alp-section-desc">Simbol dan unsur pembentuk lambang Gerakan PKK beserta arti filosofisnya</p>
        </div>

        <div class="alp-komponen-grid">
            @foreach($komponenList as $item)
            <div class="alp-komponen-card {{ $item['full_width'] ? 'full-width' : '' }}">
                <div class="alp-komponen-header">
                    <div class="alp-badge-letter">{{ $item['huruf'] }}</div>
                    <h3 class="alp-komponen-title">{{ $item['judul'] }}</h3>
                </div>

                <p class="alp-komponen-desc">
                    {{ $item['deskripsi'] }}
                </p>

                {{-- Khusus Komponen C: Angka Besar (17, 8, 45) & Sub-bagian --}}
                @if(!empty($item['angka_highlight']))
                <div class="alp-angka-grid">
                    @foreach($item['angka_highlight'] as $stat)
                    <div class="alp-angka-item">
                        <div class="alp-angka-value">{{ $stat['angka'] }}</div>
                        <div class="alp-angka-label">{{ $stat['label'] }}</div>
                        <div class="alp-angka-makna">{{ $stat['makna'] }}</div>
                    </div>
                    @endforeach
                </div>
                @endif

                @if(!empty($item['sub_bagian']))
                <div class="alp-sub-grid">
                    @foreach($item['sub_bagian'] as $sub)
                    <div class="alp-sub-item">
                        <h4 class="alp-sub-title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            {{ $sub['judul'] }}
                        </h4>
                        <p class="alp-sub-desc">
                            {{ $sub['deskripsi'] }}
                        </p>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
        </div>

    </div>
</section>

@endsection