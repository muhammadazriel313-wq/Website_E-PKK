@extends('backend.layouts.template')

@section('content1')

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-heading">Edit Transaksi Keuangan</h1>

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-card mb-4">
                    <form action="{{ route('keuangan.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="jenis" class="form-label fw-semibold">Jenis Transaksi : <span class="text-danger">*</span></label>
                                    <select name="jenis" id="jenis" class="form-select @error('jenis') is-invalid @enderror" required>
                                        <option value="pemasukan" {{ old('jenis', $data->jenis) == 'pemasukan' ? 'selected' : '' }}>Pemasukan (Uang Masuk)</option>
                                        <option value="pengeluaran" {{ old('jenis', $data->jenis) == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran (Uang Keluar)</option>
                                    </select>
                                    @error('jenis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="tanggal" class="form-label fw-semibold">Tanggal : <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', \Carbon\Carbon::parse($data->tanggal)->format('Y-m-d')) }}" required>
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="nominal" class="form-label fw-semibold">Nominal (Rp) : <span class="text-danger">*</span></label>
                                    <input type="number" step="any" min="0" name="nominal" id="nominal" class="form-control @error('nominal') is-invalid @enderror" value="{{ old('nominal', $data->nominal) }}" required>
                                    @error('nominal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="keterangan" class="form-label fw-semibold">Keterangan : <span class="text-danger">*</span></label>
                                    <textarea name="keterangan" id="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror" required>{{ old('keterangan', $data->keterangan) }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="bukti" class="form-label fw-semibold">Ganti Bukti / Nota (Opsional) :</label>
                                    <input type="file" name="bukti" id="bukti" class="form-control @error('bukti') is-invalid @enderror" accept="image/*,.pdf">
                                    <small class="text-muted d-block mt-1">Format: JPG, PNG, PDF (Maks. 2MB)</small>
                                    @if ($data->bukti)
                                        <div class="mt-2">
                                            <span class="small text-muted">File saat ini:</span>
                                            <a href="{{ asset('storage/keuangan/' . $data->bukti) }}" target="_blank" class="badge bg-secondary text-decoration-none">
                                                <i class="bi bi-file-earmark"></i> {{ $data->bukti }}
                                            </a>
                                        </div>
                                    @endif
                                    @error('bukti')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="{{ route('keuangan.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button class="btn-kirim" type="submit">
                                <i class="bi bi-save me-1"></i> Perbarui Transaksi
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>

</main>

@endsection
