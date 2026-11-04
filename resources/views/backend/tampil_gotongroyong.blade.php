{{-- @extends('backend/layouts.template') --}}

{{-- @section('content1') --}}

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Laporan Gotong Royong</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('backend/assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('backend/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('backend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('backend/assets/css/style.css') }}" rel="stylesheet">

  {{-- fontawesome --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('fontawesome/css/all.min.css') }}">

  <style>
    * { font-family: "Poppins", sans-serif !important; }
    body { background: #f6f9ff !important; }
    .header { background: #fff !important; box-shadow: 0 2px 4px rgba(0,0,0,0.08) !important; height: 70px !important; padding: 0 20px !important; z-index: 998 !important; }
    .header .logo { min-width: auto; padding: 0; margin-left: 15px; }
    .header .logo img { max-height: 50px; width: 50px; border-radius: 50%; margin-right: 15px; flex-shrink: 0; }
    .header .logo span { font-size: 15px; font-weight: 700; font-family: "Poppins", sans-serif !important; line-height: 1.3; color: #1a1a1a; white-space: nowrap; display: inline-block; }
    .toggle-sidebar-btn { color: #1a1a1a !important; font-size: 24px !important; cursor: pointer !important; padding: 10px 15px !important; }
    .sidebar { width: 300px !important; top: 70px !important; background: #fff !important; border-right: 1px solid #e5e7eb !important; z-index: 997 !important; }
    .toggle-sidebar .sidebar { width: 80px !important; }
    .toggle-sidebar .sidebar .nav-link span { display: none !important; }
    .toggle-sidebar .sidebar .nav-link { justify-content: center !important; padding: 12px 0 !important; }
    #main { margin-left: 300px !important; margin-top: 70px !important; padding: 25px 35px !important; background: #f6f9ff !important; min-height: calc(100vh - 70px) !important; }
    .toggle-sidebar #main { margin-left: 80px !important; }
    .sidebar-nav .nav-link:not(.collapsed) { background: #e8ecff; color: #4154f1; border-radius: 6px; }
    .sidebar-nav .nav-link:not(.collapsed) i { color: #4154f1; }
    .sidebar-nav .nav-item { margin-bottom: 4px; }
    .sidebar-nav .nav-link { display: flex; align-items: center; padding: 12px 20px; font-size: 15px; font-weight: 400; font-family: "Poppins", sans-serif !important; color: #4b5563; transition: all 0.3s; }
    .sidebar-nav .nav-link i { font-size: 18px; margin-right: 12px; color: #6b7280; }
    .sidebar-nav .nav-link:hover { background: #f3f4f6; color: #4154f1; }
    i, .bi, [class^="bi-"], [class*=" bi-"], [class^="fa"], [class*=" fa-"] { font-family: unset !important; }
  </style>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center w-100">
      <i class="bi bi-list toggle-sidebar-btn"></i>
      <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center" style="text-decoration:none;">
        <img src="{{ asset('backend/assets/img/pkk.png') }}" alt="PKK">
        <span class="d-none d-lg-block">
          Pemberdayaan Kesejahteraan Keluarga<br>Kabupaten Nganjuk
        </span>
      </a>
    </div>
    <nav class="header-nav ms-auto"></nav>
  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @include('backend.includes.sidebar')
  <!-- End Sidebar-->

  <main id="main" class="main">

    <section class="section">
      <div class="row">
        <div class="col-md-12 mx-auto mt-2">
          <div class="pagetitle">
            <h1>Review Laporan Gotong Royong</h1>
          </div><!-- End Page Title -->
          <div class="card">
            <div class="card-body mt-4">
              <form action="{{ route('gotongroyong.update', $data->id_pokja1_bidang2) }}" method="POST"
                enctype="multipart/form-data" onsubmit="event.preventDefault(); confirmSubmission(event)">

                @csrf
                @method('PUT')

                <div class="form-outline mb-4">

                  <div class="form-outline mb-4 mt-3">
                    <label for="id_pokja1_bidang2" class="form-label">ID Laporan Gotong Royong</label>
                    <input type="text" name="id_pokja1_bidang2" id="id_pokja1_bidang2" class="form-control" required
                      readonly value="{{ $data->id_pokja1_bidang2 }}" />
                  </div>

                  <div class="row">
                    {{-- 1. KERJA BAKTI --}}
                    <div class="col-12 mt-3 mb-2"><h5>KERJA BAKTI</h5><hr></div>
                    <div class="col-md-3 mb-3">
                      <label class="form-label">Kegiatan</label>
                      <input type="text" class="form-control" value="{{ $data->kerja_bakti_kegiatan ?? ($data->jenis_kegiatan == 'Kerja Bakti' ? 'Kerja Bakti' : '-') }}" readonly />
                    </div>
                    <div class="col-md-3 mb-3">
                      <label class="form-label">Vol. Keg</label>
                      <input type="text" class="form-control" value="{{ $data->kerja_bakti_vol ?? ($data->kerja_bakti > 0 ? $data->kerja_bakti : '-') }}" readonly />
                    </div>
                    <div class="col-md-3 mb-3">
                      <label class="form-label">Metode</label>
                      <input type="text" class="form-control" value="{{ $data->kerja_bakti_metode ?? '-' }}" readonly />
                    </div>
                    <div class="col-md-3 mb-3">
                      <label class="form-label">Jml Sasaran</label>
                      <input type="text" class="form-control" value="{{ $data->kerja_bakti_sasaran ?? '-' }}" readonly />
                    </div>

                    {{-- 2. BANTUAN ANAK YATIM --}}
                    <div class="col-12 mt-3 mb-2"><h5>BANTUAN ANAK YATIM</h5><hr></div>
                    <div class="col-md-3 mb-3">
                      <label class="form-label">Kegiatan</label>
                      <input type="text" class="form-control" value="{{ $data->bantuan_yatim_kegiatan ?? ($data->jenis_kegiatan == 'Bantuan Anak Yatim' ? 'Santunan Yatim' : '-') }}" readonly />
                    </div>
                    <div class="col-md-3 mb-3">
                      <label class="form-label">Vol. Keg</label>
                      <input type="text" class="form-control" value="{{ $data->bantuan_yatim_vol ?? ($data->rukun_kematian > 0 ? $data->rukun_kematian : '-') }}" readonly />
                    </div>
                    <div class="col-md-3 mb-3">
                      <label class="form-label">Metode</label>
                      <input type="text" class="form-control" value="{{ $data->bantuan_yatim_metode ?? '-' }}" readonly />
                    </div>
                    <div class="col-md-3 mb-3">
                      <label class="form-label">Jml Sasaran</label>
                      <input type="text" class="form-control" value="{{ $data->bantuan_yatim_sasaran ?? '-' }}" readonly />
                    </div>

                    {{-- 3. KEGIATAN SOSIAL --}}
                    <div class="col-12 mt-3 mb-2"><h5>KEGIATAN SOSIAL</h5><hr></div>
                    <div class="col-md-3 mb-3">
                      <label class="form-label">Kegiatan</label>
                      <input type="text" class="form-control" value="{{ $data->kegiatan_sosial_kegiatan ?? ($data->jenis_kegiatan == 'Kegiatan Sosial' ? 'Kegiatan Sosial' : '-') }}" readonly />
                    </div>
                    <div class="col-md-3 mb-3">
                      <label class="form-label">Vol. Keg</label>
                      <input type="text" class="form-control" value="{{ $data->kegiatan_sosial_vol ?? (($data->keagamaan ?? 0) > 0 ? $data->keagamaan : (($data->jimpitan ?? 0) > 0 ? $data->jimpitan : (($data->arisan ?? 0) > 0 ? $data->arisan : '-'))) }}" readonly />
                    </div>
                    <div class="col-md-3 mb-3">
                      <label class="form-label">Metode</label>
                      <input type="text" class="form-control" value="{{ $data->kegiatan_sosial_metode ?? '-' }}" readonly />
                    </div>
                    <div class="col-md-3 mb-3">
                      <label class="form-label">Jml Sasaran</label>
                      <input type="text" class="form-control" value="{{ $data->kegiatan_sosial_sasaran ?? '-' }}" readonly />
                    </div>

                    {{-- INFORMASI TAMBAHAN --}}
                    <div class="col-12 mt-3 mb-2"><h5>Informasi Tambahan</h5><hr></div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Sumber Dana</label>
                      <input type="text" class="form-control" value="{{ $data->sumber_dana ?? '-' }}" readonly />
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Hasil Kegiatan</label>
                      <textarea class="form-control" rows="3" readonly>{{ $data->hasil_kegiatan ?? '-' }}</textarea>
                    </div>
                  </div>

                  <div class="form-outline mb-4 mt-3">
                    <label for="id_user" class="form-label">Id Pengguna</label>
                    <input type="text" name="id_user" id="id_user" class="form-control" required readonly
                      value="{{ $data->id_user }}" />
                  </div>

                  <div id="statusAlert" class="alert alert-danger d-none" role="alert">
                    Harap pilih status laporan.
                  </div>

                  <div class="form-outline mb-4">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="datepicker-trigger form-control hasDatepicker"
                      onchange="exibeMsg(this.value);">
                      <option value="">--Pilih--</option>
                      <option value="Revisi">Revisi</option>
                      @if(Auth::guard('pengguna')->check())
                      <option value="Disetujui1">Disetujui (Kecamatan)</option>
                      @else
                      <option value="Disetujui2">Disetujui (Admin)</option>
                      @endif
                    </select>
                  </div>

                  <div class="form-outline mb-1 mt-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <input type="text" name="catatan" id="catatan" class="form-control" placeholder="Masukkan Catatan"
                      value="{{ $data->catatan }}" />
                  </div>
                  <p class="mb-4">*Jika laporan perlu di revisi maka bisa menambahkan catatan dan catatan hanya di isi
                    jika status laporan menjadi <b>Revisi</b></p>

                  <div class="form-outline mb-4 mt-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="text" name="tanggal" id="tanggal" class="form-control" required readonly
                      value="{{ $data->created_at }}" />
                  </div>

                  <div class="text-end pt-1 pb-1 mt-4">
                    <button class="btn btn-success ps-xxl-5 pe-xxl-5 mr-auto background-blue-1 mb-2 fw-semibold fs-5"
                      type="submit">Upload</button>
                  </div>

                </div>
              </form>

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('backend/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/quill/quill.min.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('backend/assets/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('backend/assets/js/main.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function confirmSubmission(e) {
      var status = document.querySelector('select[name="status"]').value;
      var alertBox = document.getElementById('statusAlert');
      alertBox.classList.add('d-none');

      if (status === "Revisi") {
        return Swal.fire({
          title: 'Konfirmasi Revisi',
          text: 'Apakah Anda yakin ingin mengubah status menjadi Revisi? Catatan perlu diisi.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#f0ad4e',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Revisi',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            e.target.submit();
          }
        });
      } else if (status === "Disetujui1" || status === "Disetujui2") {
        return Swal.fire({
          title: 'Konfirmasi Persetujuan',
          text: 'Apakah Anda yakin ingin menyetujui laporan ini?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#5cb85c',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Setujui',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            e.target.submit();
          }
        });
      } else {
        alertBox.classList.remove('d-none');
      }
    }
  </script>

</body>

</html>