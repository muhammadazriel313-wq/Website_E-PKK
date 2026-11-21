@extends('backend.layouts.template')

@section('content1')
<main id="main" class="main">
  <div class="pagetitle mb-3">
    <h1>Input Laporan Program Sandang</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('pokja3.index') }}">Pokja 3</a></li>
        <li class="breadcrumb-item"><a href="{{ route('accsandang.index') }}">Program Sandang</a></li>
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
      <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-tag-fill text-danger me-2"></i>Form Laporan Program Sandang</h5>
      <p class="text-muted small mb-0 mt-1">Isi data capaian Program Sandang (Kader, Industri Sandang, dan Jasa) tingkat desa/kelurahan.</p>
    </div>
    <div class="card-body p-4">
      <form action="{{ route('sandang.store') }}" method="POST" id="formSandang">
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

        {{-- BAGIAN 2: KADER SANDANG --}}
        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-person-badge-fill me-1"></i> 2. Jumlah Kader Sandang</h6>
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label for="kader_sandang" class="form-label fw-semibold">Jumlah Kader Sandang</label>
            <div class="input-group">
              <span class="input-group-text bg-light"><i class="bi bi-people"></i></span>
              <input type="number" name="kader_sandang" id="kader_sandang" class="form-control" min="0" value="{{ old('kader_sandang', 0) }}" required>
            </div>
            <small class="text-muted">Jumlah kader aktif bidang sandang.</small>
          </div>
        </div>

        <hr class="my-4">

        {{-- BAGIAN 3: INDUSTRI RUMAH TANGGA --}}
        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-scissors me-1"></i> 3. Industri Rumah Tangga</h6>
        <div class="row g-3 mb-4">
          <div class="col-md-4">
            <label for="industri_pangan" class="form-label fw-semibold">Industri Rumah Tangga: Pangan</label>
            <input type="number" name="industri_pangan" id="industri_pangan" class="form-control" min="0" value="{{ old('industri_pangan', 0) }}" required>
            <small class="text-muted">Industri rumah tangga bidang pangan.</small>
          </div>
          <div class="col-md-4">
            <label for="industri_sandang" class="form-label fw-semibold">Industri Rumah Tangga: Sandang</label>
            <input type="number" name="industri_sandang" id="industri_sandang" class="form-control" min="0" value="{{ old('industri_sandang', 0) }}" required>
            <small class="text-muted">Industri rumah tangga bidang sandang.</small>
          </div>
          <div class="col-md-4">
            <label for="jasa" class="form-label fw-semibold">Industri Rumah Tangga: Jasa</label>
            <input type="number" name="jasa" id="jasa" class="form-control" min="0" value="{{ old('jasa', 0) }}" required>
            <small class="text-muted">Industri rumah tangga bidang jasa.</small>
          </div>
        </div>

        <hr class="my-4">

        {{-- CATATAN TAMBAHAN --}}
        <div class="mb-4">
          <label for="catatan" class="form-label fw-semibold">Catatan (Opsional)</label>
          <textarea name="catatan" id="catatan" class="form-control" rows="2" placeholder="Catatan tambahan bila ada">{{ old('catatan') }}</textarea>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-2">
          <a href="{{ route('sandang.index') }}" class="btn btn-secondary px-4">Batal</a>
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
