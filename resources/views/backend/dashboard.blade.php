@extends('backend/layouts.template')

@section('content')

<main id="main" class="main">
  @if ($message = Session::get('success'))
  <div class="alert alert-success" role="alert">
    {{ $message }}
  </div>
  @endif

  <section class="section dashboard">
    <div class="row">
      <div class="row">

        {{-- CARD PENGGUNA --}}
        <div class="col-xxl-6 col-md-6">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">Pengguna</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background: #e0f2fe;">
                  <i class="bi bi-people-fill" style="color: #0284c7;"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $jmlh_user }}</h6>
                  <span class="text-muted small pt-2 ps-1">Jumlah total pengguna</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- CARD BIDANG UMUM --}}
        <div class="col-xxl-6 col-md-6">
          <div class="card info-card sales-card">
            <a href="{{ route('accbidangumum.index') }}">
              <div class="card-body">
                <h5 class="card-title">Laporan Bidang Umum</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background: #fef9c3;">
                    <i class="bi bi-clipboard2-data-fill" style="color: #ca8a04;"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $bidangumum }}</h6>
                    <span class="text-muted small pt-2 ps-1">Jumlah total Laporan Bidang Umum</span>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>

        {{-- CARD POKJA 1 --}}
        <div class="col-xxl-6 col-md-6">
          <div class="card info-card sales-card">
            <a href="{{ route('pokja1.index') }}">
              <div class="card-body">
                <h5 class="card-title">Laporan Kelompok Kerja 1</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background: #dcfce7;">
                    <i class="bi bi-shield-fill-check" style="color: #16a34a;"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $totalbidang1 }}</h6>
                    <span class="text-muted small pt-2 ps-1">Jumlah total Laporan Kelompok Kerja 1</span>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>

        {{-- CARD POKJA 2 --}}
        <div class="col-xxl-6 col-md-6">
          <div class="card info-card sales-card">
            <a href="{{ route('pokja2.index') }}">
              <div class="card-body">
                <h5 class="card-title">Laporan Kelompok Kerja 2</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background: #ede9fe;">
                    <i class="bi bi-mortarboard-fill" style="color: #7c3aed;"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $totalbidang2 }}</h6>
                    <span class="text-muted small pt-2 ps-1">Jumlah total Laporan Kelompok Kerja 2</span>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>

        {{-- CARD POKJA 3 --}}
        <div class="col-xxl-6 col-md-6">
          <div class="card info-card sales-card">
            <a href="{{ route('pokja3.index') }}">
              <div class="card-body">
                <h5 class="card-title">Laporan Kelompok Kerja 3</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background: #ffedd5;">
                    <i class="bi bi-house-fill" style="color: #ea580c;"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $totalbidang3 }}</h6>
                    <span class="text-muted small pt-2 ps-1">Jumlah total Laporan Kelompok Kerja 3</span>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>

        {{-- CARD POKJA 4 --}}
        <div class="col-xxl-6 col-md-6">
          <div class="card info-card sales-card">
            <a href="{{ route('pokja4.index') }}">
              <div class="card-body">
                <h5 class="card-title">Laporan Kelompok Kerja 4</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background: #fce7f3;">
                    <i class="bi bi-heart-pulse-fill" style="color: #db2777;"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $totalbidang4 }}</h6>
                    <span class="text-muted small pt-2 ps-1">Jumlah total Laporan Kelompok Kerja 4</span>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>

        <!-- ========================================= -->
        <!-- GRAFIK JUMLAH LAPORAN MASUK -->
        <!-- ========================================= -->
        <div class="col-12 mt-4 mb-2">
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pb-2 border-bottom">
            <div>
              <h5 class="mb-1" style="font-weight: 700; color: #012970; font-size: 1.25rem;">
                <i class="bi bi-graph-up-arrow me-2" style="color: #016AA3;"></i>Grafik Jumlah Laporan Masuk
              </h5>
              <span class="text-muted small">Visualisasi komparasi dan persentase laporan yang masuk ke sistem</span>
            </div>
            <div>
              <span class="badge px-3 py-2" style="background: linear-gradient(135deg, #016AA3 0%, #0284c7 100%); color: #fff; font-size: 0.85rem; font-weight: 600; border-radius: 20px; box-shadow: 0 4px 10px rgba(1, 106, 163, 0.25);">
                <i class="bi bi-file-earmark-check-fill me-1"></i> Total: {{ $totalSemuaLaporan }} Laporan
              </span>
            </div>
          </div>
        </div>

        <!-- ROW GRAFIK -->
        <div class="col-12">
          <div class="row g-3">
            
            <!-- GRAFIK BATANG / AREA -->
            <div class="col-xxl-8 col-lg-7">
              <div class="card shadow-sm border-0 h-100" style="border-radius: 16px;">
                <div class="card-body p-4">
                  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <div>
                      <h5 class="card-title p-0 m-0" style="font-size: 1.05rem; font-weight: 700; color: #012970;">
                        Tren Jumlah Laporan Masuk
                      </h5>
                      <span class="text-muted small">Visualisasi tren laporan masuk bulanan (Tahun {{ $selectedYear }})</span>
                    </div>

                    <!-- TOGGLE VIEW TABS -->
                    <div class="btn-group btn-group-sm" role="group" aria-label="Tampilan Grafik">
                      <button type="button" class="btn btn-outline-primary active" id="btnViewArea" onclick="switchChartMode('area')">
                        <i class="bi bi-graph-up me-1"></i>Tren Bulanan
                      </button>
                      <button type="button" class="btn btn-outline-primary" id="btnViewPokja" onclick="switchChartMode('pokja')">
                        <i class="bi bi-bar-chart-fill me-1"></i>Per Pokja
                      </button>
                      <button type="button" class="btn btn-outline-primary" id="btnViewDetail" onclick="switchChartMode('detail')">
                        <i class="bi bi-list-task me-1"></i>Detail 15 Program
                      </button>
                    </div>
                  </div>

                  <!-- Container Chart 1: Area Chart (Default seperti gambar acuan) -->
                  <div id="chartContainerArea">
                    <div id="chartLaporanArea" style="min-height: 350px;"></div>
                  </div>

                  <!-- Container Chart 2: Per Pokja (Bar) -->
                  <div id="chartContainerPokja" style="display: none;">
                    <div id="chartLaporanBar" style="min-height: 350px;"></div>
                  </div>

                  <!-- Container Chart 3: Detail Sub-Program (Hidden by default) -->
                  <div id="chartContainerDetail" style="display: none;">
                    <div id="chartLaporanDetail" style="min-height: 480px;"></div>
                  </div>

                  <!-- Mini Badges Summary -->
                  <div class="row g-2 pt-3 mt-2 border-top">
                    <div class="col">
                      <div class="p-2 rounded text-center" style="background: #fefce8; border: 1px solid #fef08a;">
                        <small class="text-muted d-block text-truncate" style="font-size: 11px;">Umum</small>
                        <b style="color: #ca8a04; font-size: 14px;">{{ $bidangumum }}</b>
                      </div>
                    </div>
                    <div class="col">
                      <div class="p-2 rounded text-center" style="background: #f0fdf4; border: 1px solid #bbf7d0;">
                        <small class="text-muted d-block text-truncate" style="font-size: 11px;">Pokja 1</small>
                        <b style="color: #16a34a; font-size: 14px;">{{ $totalbidang1 }}</b>
                      </div>
                    </div>
                    <div class="col">
                      <div class="p-2 rounded text-center" style="background: #faf5ff; border: 1px solid #e9d5ff;">
                        <small class="text-muted d-block text-truncate" style="font-size: 11px;">Pokja 2</small>
                        <b style="color: #7c3aed; font-size: 14px;">{{ $totalbidang2 }}</b>
                      </div>
                    </div>
                    <div class="col">
                      <div class="p-2 rounded text-center" style="background: #fff7ed; border: 1px solid #fed7aa;">
                        <small class="text-muted d-block text-truncate" style="font-size: 11px;">Pokja 3</small>
                        <b style="color: #ea580c; font-size: 14px;">{{ $totalbidang3 }}</b>
                      </div>
                    </div>
                    <div class="col">
                      <div class="p-2 rounded text-center" style="background: #fdf2f8; border: 1px solid #fbcfe8;">
                        <small class="text-muted d-block text-truncate" style="font-size: 11px;">Pokja 4</small>
                        <b style="color: #db2777; font-size: 14px;">{{ $totalbidang4 }}</b>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <!-- GRAFIK DONAT / DISTRIBUSI -->
            <div class="col-xxl-4 col-lg-5">
              <div class="card shadow-sm border-0 h-100" style="border-radius: 16px;">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                  <div>
                    <h5 class="card-title p-0 m-0 mb-1" style="font-size: 1.05rem; font-weight: 700; color: #012970;">
                      Proporsi Laporan
                    </h5>
                    <span class="text-muted small">Distribusi persentase laporan masuk</span>

                    <!-- Container Donut -->
                    <div class="mt-3">
                      <div id="chartLaporanDonut" style="min-height: 270px;"></div>
                    </div>
                  </div>

                  <!-- Breakdown List -->
                  <div class="list-group list-group-flush border-top pt-3 mt-2">
                    <div class="d-flex justify-content-between align-items-center py-2">
                      <div class="d-flex align-items-center">
                        <span class="rounded-circle me-2" style="width: 10px; height: 10px; background-color: #ca8a04; display: inline-block;"></span>
                        <span style="font-size: 13px; font-weight: 500;">Bidang Umum</span>
                      </div>
                      <div class="d-flex align-items-center gap-2">
                        <span class="badge" style="background: #fef9c3; color: #ca8a04; font-weight: 600;">{{ $bidangumum }} lap.</span>
                        <small class="text-muted" style="width: 45px; text-align: right;">{{ $totalSemuaLaporan > 0 ? round(($bidangumum / $totalSemuaLaporan) * 100, 1) : 0 }}%</small>
                      </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-2">
                      <div class="d-flex align-items-center">
                        <span class="rounded-circle me-2" style="width: 10px; height: 10px; background-color: #16a34a; display: inline-block;"></span>
                        <span style="font-size: 13px; font-weight: 500;">Pokja 1</span>
                      </div>
                      <div class="d-flex align-items-center gap-2">
                        <span class="badge" style="background: #dcfce7; color: #16a34a; font-weight: 600;">{{ $totalbidang1 }} lap.</span>
                        <small class="text-muted" style="width: 45px; text-align: right;">{{ $totalSemuaLaporan > 0 ? round(($totalbidang1 / $totalSemuaLaporan) * 100, 1) : 0 }}%</small>
                      </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-2">
                      <div class="d-flex align-items-center">
                        <span class="rounded-circle me-2" style="width: 10px; height: 10px; background-color: #7c3aed; display: inline-block;"></span>
                        <span style="font-size: 13px; font-weight: 500;">Pokja 2</span>
                      </div>
                      <div class="d-flex align-items-center gap-2">
                        <span class="badge" style="background: #ede9fe; color: #7c3aed; font-weight: 600;">{{ $totalbidang2 }} lap.</span>
                        <small class="text-muted" style="width: 45px; text-align: right;">{{ $totalSemuaLaporan > 0 ? round(($totalbidang2 / $totalSemuaLaporan) * 100, 1) : 0 }}%</small>
                      </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-2">
                      <div class="d-flex align-items-center">
                        <span class="rounded-circle me-2" style="width: 10px; height: 10px; background-color: #ea580c; display: inline-block;"></span>
                        <span style="font-size: 13px; font-weight: 500;">Pokja 3</span>
                      </div>
                      <div class="d-flex align-items-center gap-2">
                        <span class="badge" style="background: #ffedd5; color: #ea580c; font-weight: 600;">{{ $totalbidang3 }} lap.</span>
                        <small class="text-muted" style="width: 45px; text-align: right;">{{ $totalSemuaLaporan > 0 ? round(($totalbidang3 / $totalSemuaLaporan) * 100, 1) : 0 }}%</small>
                      </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-2">
                      <div class="d-flex align-items-center">
                        <span class="rounded-circle me-2" style="width: 10px; height: 10px; background-color: #db2777; display: inline-block;"></span>
                        <span style="font-size: 13px; font-weight: 500;">Pokja 4</span>
                      </div>
                      <div class="d-flex align-items-center gap-2">
                        <span class="badge" style="background: #fce7f3; color: #db2777; font-weight: 600;">{{ $totalbidang4 }} lap.</span>
                        <small class="text-muted" style="width: 45px; text-align: right;">{{ $totalSemuaLaporan > 0 ? round(($totalbidang4 / $totalSemuaLaporan) * 100, 1) : 0 }}%</small>
                      </div>
                    </div>

                  </div>

                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

</main>

@endsection

@section('scripts')
<script>
  let chartAreaInstance = null;
  let chartBarInstance = null;
  let chartDetailInstance = null;
  let chartDonutInstance = null;

  function switchChartMode(mode) {
    const btnArea = document.getElementById('btnViewArea');
    const btnPokja = document.getElementById('btnViewPokja');
    const btnDetail = document.getElementById('btnViewDetail');
    
    const containerArea = document.getElementById('chartContainerArea');
    const containerPokja = document.getElementById('chartContainerPokja');
    const containerDetail = document.getElementById('chartContainerDetail');

    btnArea.classList.remove('active');
    btnPokja.classList.remove('active');
    btnDetail.classList.remove('active');

    containerArea.style.display = 'none';
    containerPokja.style.display = 'none';
    containerDetail.style.display = 'none';

    if (mode === 'area') {
      btnArea.classList.add('active');
      containerArea.style.display = 'block';
      if (chartAreaInstance) chartAreaInstance.render();
    } else if (mode === 'pokja') {
      btnPokja.classList.add('active');
      containerPokja.style.display = 'block';
      if (!chartBarInstance) {
        initBarChart();
      } else {
        chartBarInstance.render();
      }
    } else {
      btnDetail.classList.add('active');
      containerDetail.style.display = 'block';
      if (!chartDetailInstance) {
        initDetailChart();
      } else {
        chartDetailInstance.render();
      }
    }
  }

  function initBarChart() {
    const barEl = document.querySelector("#chartLaporanBar");
    if (!barEl) return;

    const totalSemua = {{ (int)$totalSemuaLaporan }};

    const optionsBar = {
      series: [{
        name: 'Jumlah Laporan',
        data: [
          {{ (int)$bidangumum }},
          {{ (int)$totalbidang1 }},
          {{ (int)$totalbidang2 }},
          {{ (int)$totalbidang3 }},
          {{ (int)$totalbidang4 }}
        ]
      }],
      chart: {
        type: 'bar',
        height: 350,
        fontFamily: 'Poppins, sans-serif',
        toolbar: {
          show: true,
          tools: {
            download: true
          }
        },
        animations: {
          enabled: true,
          easing: 'easeinout',
          speed: 700
        }
      },
      plotOptions: {
        bar: {
          borderRadius: 8,
          borderRadiusApplication: 'end',
          columnWidth: '45%',
          distributed: true,
          dataLabels: {
            position: 'top'
          }
        }
      },
      colors: ['#ca8a04', '#16a34a', '#7c3aed', '#ea580c', '#db2777'],
      dataLabels: {
        enabled: true,
        formatter: function(val) {
          return val + " Lap.";
        },
        offsetY: -22,
        style: {
          fontSize: '12px',
          fontWeight: '600',
          colors: ['#334155']
        }
      },
      legend: {
        show: false
      },
      xaxis: {
        categories: [
          'Bidang Umum',
          'Kelompok Kerja 1',
          'Kelompok Kerja 2',
          'Kelompok Kerja 3',
          'Kelompok Kerja 4'
        ],
        labels: {
          style: {
            fontSize: '12px',
            fontWeight: '500',
            colors: ['#ca8a04', '#16a34a', '#7c3aed', '#ea580c', '#db2777']
          }
        },
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        }
      },
      yaxis: {
        title: {
          text: 'Jumlah Laporan',
          style: {
            fontSize: '12px',
            fontWeight: '500',
            color: '#94a3b8'
          }
        },
        labels: {
          style: {
            colors: '#64748b'
          },
          formatter: function(val) {
            return Math.floor(val);
          }
        },
        min: 0,
        forceNiceScale: true
      },
      grid: {
        borderColor: '#f1f5f9',
        strokeDashArray: 4,
        yaxis: {
          lines: {
            show: true
          }
        }
      },
      tooltip: {
        theme: 'light',
        y: {
          formatter: function(val) {
            const pct = totalSemua > 0 ? ((val / totalSemua) * 100).toFixed(1) : 0;
            return val + " Laporan (" + pct + "%)";
          }
        }
      }
    };

    chartBarInstance = new ApexCharts(barEl, optionsBar);
    chartBarInstance.render();
  }

  function initDetailChart() {
    const detailEl = document.querySelector("#chartLaporanDetail");
    if (!detailEl) return;
    
    const detailLabels = {!! json_encode(array_column($detailProgramKerja, 'program')) !!};
    const detailValues = {!! json_encode(array_column($detailProgramKerja, 'jumlah')) !!};
    const detailColors = {!! json_encode(array_column($detailProgramKerja, 'warna')) !!};
    const detailKategori = {!! json_encode(array_column($detailProgramKerja, 'kategori')) !!};

    const optionsDetail = {
      series: [{
        name: 'Jumlah Laporan',
        data: detailValues
      }],
      chart: {
        type: 'bar',
        height: 480,
        fontFamily: 'Poppins, sans-serif',
        toolbar: {
          show: true,
          tools: {
            download: true
          }
        }
      },
      plotOptions: {
        bar: {
          borderRadius: 6,
          borderRadiusApplication: 'end',
          horizontal: true,
          distributed: true,
          barHeight: '72%',
          dataLabels: {
            position: 'right'
          }
        }
      },
      colors: detailColors,
      dataLabels: {
        enabled: true,
        formatter: function(val) {
          return val + " Lap.";
        },
        offsetX: 6,
        style: {
          fontSize: '11px',
          fontWeight: '600',
          colors: ['#334155']
        }
      },
      legend: {
        show: false
      },
      xaxis: {
        categories: detailLabels,
        labels: {
          style: {
            fontSize: '11px',
            colors: '#64748b'
          },
          formatter: function(val) {
            return Math.floor(val);
          }
        }
      },
      yaxis: {
        labels: {
          style: {
            fontSize: '11px',
            fontWeight: '500',
            colors: '#334155'
          }
        }
      },
      grid: {
        borderColor: '#f1f5f9',
        strokeDashArray: 4
      },
      tooltip: {
        theme: 'light',
        custom: function({series, seriesIndex, dataPointIndex, w}) {
          const prog = detailLabels[dataPointIndex];
          const kat = detailKategori[dataPointIndex];
          const val = series[seriesIndex][dataPointIndex];
          const col = detailColors[dataPointIndex];
          return '<div style="padding: 8px 12px; font-family: Poppins, sans-serif;">' +
            '<div style="font-size: 11px; font-weight: 600; color: ' + col + ';">' + kat + '</div>' +
            '<div style="font-size: 13px; font-weight: 600; color: #1e293b;">' + prog + ': <span style="color:' + col + '">' + val + ' Laporan</span></div>' +
            '</div>';
        }
      }
    };

    chartDetailInstance = new ApexCharts(detailEl, optionsDetail);
    chartDetailInstance.render();
  }

  function initCharts() {
    if (typeof ApexCharts === 'undefined') {
      setTimeout(initCharts, 100);
      return;
    }

    const totalSemua = {{ (int)$totalSemuaLaporan }};
    const chartMonthlyData = {!! json_encode($chartMonthlyData) !!};
    const selectedYear = {{ (int)$selectedYear }};

    // =========================================
    // 1. TREN BULANAN - AREA SPLINE CHART (SESUAI GAMBAR ACUAN)
    // =========================================
    const areaEl = document.querySelector("#chartLaporanArea");
    if (areaEl) {
      const optionsArea = {
        series: [{
          name: 'Jumlah Laporan',
          data: chartMonthlyData
        }],
        chart: {
          type: 'area',
          height: 350,
          fontFamily: 'Poppins, sans-serif',
          toolbar: {
            show: true,
            tools: {
              download: true,
              selection: false,
              zoom: false,
              zoomin: false,
              zoomout: false,
              pan: false,
              reset: false
            }
          },
          animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800
          },
          dropShadow: {
            enabled: true,
            color: '#1d4ed8',
            top: 6,
            left: 0,
            blur: 8,
            opacity: 0.15
          }
        },
        colors: ['#1d4ed8'],
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth',
          width: 3.5,
          colors: ['#1d4ed8']
        },
        fill: {
          type: 'gradient',
          gradient: {
            type: 'vertical',
            shadeIntensity: 1,
            opacityFrom: 0.90,
            opacityTo: 0.08,
            stops: [0, 65, 100],
            colorStops: [
              {
                offset: 0,
                color: '#1d4ed8',
                opacity: 0.92
              },
              {
                offset: 40,
                color: '#2563eb',
                opacity: 0.65
              },
              {
                offset: 75,
                color: '#60a5fa',
                opacity: 0.25
              },
              {
                offset: 100,
                color: '#93c5fd',
                opacity: 0.04
              }
            ]
          }
        },
        markers: {
          size: 4,
          colors: ['#ffffff'],
          strokeColors: '#1d4ed8',
          strokeWidth: 3,
          hover: {
            size: 7,
            sizeOffset: 3
          }
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          axisBorder: {
            show: true,
            color: '#cbd5e1'
          },
          axisTicks: {
            show: true,
            color: '#cbd5e1'
          },
          labels: {
            style: {
              colors: '#64748b',
              fontSize: '12px',
              fontFamily: 'Poppins, sans-serif',
              fontWeight: 500
            }
          }
        },
        yaxis: {
          min: 0,
          forceNiceScale: true,
          labels: {
            style: {
              colors: '#64748b',
              fontSize: '12px',
              fontFamily: 'Poppins, sans-serif'
            },
            formatter: function (val) {
              return Math.floor(val);
            }
          }
        },
        grid: {
          borderColor: '#e2e8f0',
          strokeDashArray: 0,
          yaxis: {
            lines: {
              show: true
            }
          },
          xaxis: {
            lines: {
              show: false
            }
          }
        },
        tooltip: {
          theme: 'light',
          custom: function({series, seriesIndex, dataPointIndex, w}) {
            const val = series[seriesIndex][dataPointIndex];
            const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            const month = monthNames[dataPointIndex] || 'Bulan';
            const pct = totalSemua > 0 ? ((val / totalSemua) * 100).toFixed(1) : 0;
            
            return '<div style="padding: 10px 14px; font-family: Poppins, sans-serif; background: #ffffff; border-radius: 10px; box-shadow: 0 6px 20px rgba(0,0,0,0.12); border: 1px solid #e2e8f0;">' +
              '<div style="font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase;">' + month + ' ' + selectedYear + '</div>' +
              '<div style="font-size: 16px; font-weight: 700; color: #1d4ed8; margin: 3px 0;">' + val + ' Laporan</div>' +
              '<div style="display: inline-block; background: #eff6ff; color: #1d4ed8; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 12px; border: 1px solid #bfdbfe;">' +
              '+' + pct + '% dari total' +
              '</div>' +
              '</div>';
          }
        }
      };

      chartAreaInstance = new ApexCharts(areaEl, optionsArea);
      chartAreaInstance.render();
    }

    // =========================================
    // 2. DONUT CHART (DISTRIBUSI LAPORAN)
    // =========================================
    const donutEl = document.querySelector("#chartLaporanDonut");
    if (donutEl) {
      const optionsDonut = {
        series: [
          {{ (int)$bidangumum }},
          {{ (int)$totalbidang1 }},
          {{ (int)$totalbidang2 }},
          {{ (int)$totalbidang3 }},
          {{ (int)$totalbidang4 }}
        ],
        labels: [
          'Bidang Umum',
          'Pokja 1',
          'Pokja 2',
          'Pokja 3',
          'Pokja 4'
        ],
        chart: {
          type: 'donut',
          height: 290,
          fontFamily: 'Poppins, sans-serif'
        },
        colors: ['#ca8a04', '#16a34a', '#7c3aed', '#ea580c', '#db2777'],
        stroke: {
          width: 2,
          colors: ['#ffffff']
        },
        plotOptions: {
          pie: {
            donut: {
              size: '72%',
              labels: {
                show: true,
                total: {
                  show: true,
                  showAlways: true,
                  label: 'Total Laporan',
                  fontSize: '12px',
                  fontWeight: 500,
                  color: '#64748b',
                  formatter: function (w) {
                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                  }
                },
                value: {
                  fontSize: '24px',
                  fontWeight: 700,
                  color: '#012970',
                  offsetY: 2,
                  formatter: function (val) {
                    return val;
                  }
                }
              }
            }
          }
        },
        dataLabels: {
          enabled: false
        },
        legend: {
          show: false
        },
        tooltip: {
          theme: 'light',
          y: {
            formatter: function(val) {
              const pct = totalSemua > 0 ? ((val / totalSemua) * 100).toFixed(1) : 0;
              return val + " Laporan (" + pct + "%)";
            }
          }
        }
      };

      chartDonutInstance = new ApexCharts(donutEl, optionsDonut);
      chartDonutInstance.render();
    }
  }

  // Load when DOM ready or window loaded
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCharts);
  } else {
    initCharts();
  }
</script>
@endsection