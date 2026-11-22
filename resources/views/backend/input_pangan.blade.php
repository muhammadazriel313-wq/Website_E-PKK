@extends('backend.layouts.template')

@section('content1')
<main id="main" class="main">
  <div class="pagetitle mb-3">
    <h1>Input Laporan Program Pangan</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('pokja3.index') }}">Pokja 3</a></li>
        <li class="breadcrumb-item"><a href="{{ route('accpangan.index') }}">Program Pangan</a></li>
        <li class="breadcrumb-item active">Input Laporan</li>
      </ol>
    </nav>
  </div>

  @if (isset($errors) && $errors->any())
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Terjadi Kesalahan:</strong>
    <ul class="mb-0 mt-1">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  @endif

  <div class="card shadow-sm border-0" style="border-radius: 14px;">
    <div class="card-header bg-white py-3" style="border-bottom: 1px solid #edf2f7; border-radius: 14px 14px 0 0;">
      <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-basket2-fill text-warning me-2"></i>Form Laporan Program Pangan</h5>
      <p class="text-muted small mb-0 mt-1">Isi data capaian Program Pangan tingkat desa/kelurahan sesuai format resmi PKK.</p>
    </div>
    <div class="card-body p-4">
      <form action="{{ route('pangan.store') }}" method="POST" id="formPangan">
        @csrf

        {{-- BAGIAN 1: WILAYAH --}}
        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-geo-alt-fill me-1"></i> 1. Informasi Wilayah</h6>
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label for="kecamatan_id" class="form-label fw-semibold">Kecamatan <span class="text-danger">*</span></label>
            <select name="kecamatan_id" id="kecamatan_id" class="form-select" required>
              <option value="">-- Pilih Kecamatan --</option>
              @foreach($kecamatanList as $kec)
                <option value="{{ $kec->id }}" {{ old('kecamatan_id') == $kec->id ? 'selected' : '' }}>
                  {{ $kec->name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <label for="desa_id" class="form-label fw-semibold">Desa / Kelurahan <span class="text-danger">*</span></label>
            <select name="desa_id" id="desa_id" class="form-select" required>
              <option value="">-- Pilih Desa / Kelurahan --</option>
              @foreach($desaList as $des)
                <option value="{{ $des->id }}" data-kec="{{ $des->id_subdistrict }}" {{ old('desa_id') == $des->id ? 'selected' : '' }}>
                  {{ $des->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <hr class="my-4">

        {{-- BAGIAN 2: KADER PANGAN --}}
        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-person-badge-fill me-1"></i> 2. Jumlah Kader Pangan</h6>
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label for="kader_pangan" class="form-label fw-semibold">Jumlah Kader Pangan</label>
            <div class="input-group">
              <span class="input-group-text bg-light"><i class="bi bi-people"></i></span>
              <input type="number" name="kader_pangan" id="kader_pangan" class="form-control" min="0" value="{{ old('kader_pangan', 0) }}" required>
            </div>
          </div>
        </div>

        <hr class="my-4">

        {{-- BAGIAN 3: MAKANAN POKOK --}}
        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-egg-fried me-1"></i> 3. Makanan Pokok</h6>
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label for="beras" class="form-label fw-semibold">Beras</label>
            <input type="number" name="beras" id="beras" class="form-control" min="0" value="{{ old('beras', 0) }}" required>
          </div>
          <div class="col-md-6">
            <label for="non_beras" class="form-label fw-semibold">Non Beras</label>
            <input type="number" name="non_beras" id="non_beras" class="form-control" min="0" value="{{ old('non_beras', 0) }}" required>
          </div>
        </div>

        <hr class="my-4">

        {{-- BAGIAN 4: PEMANFAATAN PEKARANGAN / HATINYA PKK --}}
        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-flower1 me-1"></i> 4. Pemanfaatan Pekarangan / Hatinya PKK</h6>
        <div class="row g-3 mb-4">
          <div class="col-md-4">
            <label for="peternakan" class="form-label fw-semibold">Peternakan</label>
            <input type="number" name="peternakan" id="peternakan" class="form-control" min="0" value="{{ old('peternakan', 0) }}" required>
          </div>
          <div class="col-md-4">
            <label for="perikanan" class="form-label fw-semibold">Perikanan</label>
            <input type="number" name="perikanan" id="perikanan" class="form-control" min="0" value="{{ old('perikanan', 0) }}" required>
          </div>
          <div class="col-md-4">
            <label for="warung_hidup" class="form-label fw-semibold">Warung Hidup</label>
            <input type="number" name="warung_hidup" id="warung_hidup" class="form-control" min="0" value="{{ old('warung_hidup', 0) }}" required>
          </div>
          <div class="col-md-4">
            <label for="lumbung_hidup" class="form-label fw-semibold">Lumbung Hidup</label>
            <input type="number" name="lumbung_hidup" id="lumbung_hidup" class="form-control" min="0" value="{{ old('lumbung_hidup', 0) }}" required>
          </div>
          <div class="col-md-4">
            <label for="toga" class="form-label fw-semibold">TOGA (Tanaman Obat Keluarga)</label>
            <input type="number" name="toga" id="toga" class="form-control" min="0" value="{{ old('toga', 0) }}" required>
          </div>
          <div class="col-md-4">
            <label for="tanaman_keras" class="form-label fw-semibold">Tanaman Keras</label>
            <input type="number" name="tanaman_keras" id="tanaman_keras" class="form-control" min="0" value="{{ old('tanaman_keras', 0) }}" required>
          </div>
          <div class="col-md-4">
            <label for="tanaman_lainnya" class="form-label fw-semibold">Tanaman Lainnya</label>
            <input type="number" name="tanaman_lainnya" id="tanaman_lainnya" class="form-control" min="0" value="{{ old('tanaman_lainnya', 0) }}" required>
          </div>
        </div>



        <hr class="my-4">

        {{-- CATATAN TAMBAHAN --}}
        <div class="mb-4">
          <label for="catatan" class="form-label fw-semibold">Catatan (Opsional)</label>
          <textarea name="catatan" id="catatan" class="form-control" rows="2" placeholder="Catatan tambahan bila ada">{{ old('catatan') }}</textarea>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-2">
          <a href="{{ route('pangan.index') }}" class="btn btn-secondary px-4">Batal</a>
          <button type="submit" class="btn btn-primary px-4 fw-semibold"><i class="bi bi-check-circle me-1"></i> Simpan Laporan</button>
        </div>
      </form>
    </div>
  </div>
</main>

<script>
  // Filter desa berdasarkan kecamatan
  document.getElementById('kecamatan_id')?.addEventListener('change', function() {
    const kecId = this.value;
    const desaSelect = document.getElementById('desa_id');
    const options = desaSelect.querySelectorAll('option');

    desaSelect.value = '';
    options.forEach(opt => {
      if (!opt.value) {
        opt.style.display = 'block';
        return;
      }
      const dataKec = opt.getAttribute('data-kec');
      opt.style.display = (!kecId || dataKec === kecId) ? 'block' : 'none';
    });
  });

  // Validasi tidak boleh negatif
  document.querySelectorAll('input[type="number"]').forEach(input => {
    input.addEventListener('input', function() {
      if (this.value < 0) this.value = 0;
    });
  });
</script>
@endsection
