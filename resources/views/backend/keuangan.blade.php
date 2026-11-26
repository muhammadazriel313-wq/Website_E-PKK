@extends('backend.layouts.template')

@section('content1')

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-heading">Kelola Keuangan</h1>

                {{-- Notifikasi Sukses / Gagal --}}
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- KARTU RINGKASAN SALDO --}}
                <div class="row mb-4">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card border-0 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff;">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1 text-white-50 small font-weight-bold">Total Pemasukan</p>
                                        <h4 class="mb-0 fw-bold">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h4>
                                    </div>
                                    <div class="rounded-circle p-3 d-flex align-items-center justify-content-center" style="background: rgba(255,255,255,0.2); width: 48px; height: 48px;">
                                        <i class="bi bi-arrow-down-left text-white fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card border-0 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: #fff;">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1 text-white-50 small font-weight-bold">Total Pengeluaran</p>
                                        <h4 class="mb-0 fw-bold">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h4>
                                    </div>
                                    <div class="rounded-circle p-3 d-flex align-items-center justify-content-center" style="background: rgba(255,255,255,0.2); width: 48px; height: 48px;">
                                        <i class="bi bi-arrow-up-right text-white fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #fff;">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1 text-white-50 small font-weight-bold">Sisa Saldo Kas</p>
                                        <h4 class="mb-0 fw-bold">Rp {{ number_format($saldo, 0, ',', '.') }}</h4>
                                    </div>
                                    <div class="rounded-circle p-3 d-flex align-items-center justify-content-center" style="background: rgba(255,255,255,0.2); width: 48px; height: 48px;">
                                        <i class="bi bi-wallet2 text-white fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FORM INPUT TRANSAKSI --}}
                <div class="form-card mb-4">
                    <h5 class="fw-bold mb-3" style="color: #1e293b;"><i class="bi bi-plus-circle me-2 text-primary"></i>Catat Transaksi Keuangan Baru</h5>
                    <form action="{{ route('keuangan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="jenis" class="form-label fw-semibold">Jenis Transaksi : <span class="text-danger">*</span></label>
                                    <select name="jenis" id="jenis" class="form-select @error('jenis') is-invalid @enderror" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="pemasukan" {{ old('jenis') == 'pemasukan' ? 'selected' : '' }}>Pemasukan (Uang Masuk)</option>
                                        <option value="pengeluaran" {{ old('jenis') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran (Uang Keluar)</option>
                                    </select>
                                    @error('jenis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="tanggal" class="form-label fw-semibold">Tanggal : <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="nominal" class="form-label fw-semibold">Nominal (Rp) : <span class="text-danger">*</span></label>
                                    <input type="number" step="any" min="0" name="nominal" id="nominal" class="form-control @error('nominal') is-invalid @enderror" placeholder="Contoh: 150000" value="{{ old('nominal') }}" required>
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
                                    <textarea name="keterangan" id="keterangan" rows="2" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Rincian sumber dana atau peruntukan pengeluaran..." required>{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="bukti" class="form-label fw-semibold">Upload Bukti / Nota (Opsional) :</label>
                                    <input type="file" name="bukti" id="bukti" class="form-control @error('bukti') is-invalid @enderror" accept="image/*,.pdf">
                                    <small class="text-muted d-block mt-1">Format: JPG, PNG, atau PDF (Maks. 2MB)</small>
                                    @error('bukti')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-2">
                            <button class="btn-kirim" type="submit">
                                <i class="bi bi-save me-1"></i> Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>

                {{-- FILTER & TABEL DAFTAR KEUANGAN --}}
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                    <h1 class="page-heading mb-0" style="margin-top: 0 !important;">Riwayat Transaksi Keuangan</h1>
                    
                    {{-- Form Filter --}}
                    <form method="GET" action="{{ route('keuangan.index') }}" class="d-flex flex-wrap gap-2 align-items-center mt-2 mt-md-0">
                        <select name="jenis" class="form-select form-select-sm" style="width: auto;">
                            <option value="">Semua Jenis</option>
                            <option value="pemasukan" {{ request('jenis') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="pengeluaran" {{ request('jenis') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                        <input type="date" name="tanggal_mulai" class="form-control form-control-sm" style="width: auto;" value="{{ request('tanggal_mulai') }}" title="Tanggal Mulai">
                        <span class="text-muted small">s/d</span>
                        <input type="date" name="tanggal_selesai" class="form-control form-control-sm" style="width: auto;" value="{{ request('tanggal_selesai') }}" title="Tanggal Selesai">
                        
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        @if (request()->hasAny(['jenis', 'tanggal_mulai', 'tanggal_selesai']))
                            <a href="{{ route('keuangan.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                        @endif
                    </form>
                </div>

                <div class="table-card">
                    <table class="table-ttd">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 12%;">Tanggal</th>
                                <th style="width: 12%;">Jenis</th>
                                <th>Keterangan</th>
                                <th style="width: 16%;">Nominal (Rp)</th>
                                <th style="width: 12%; text-align: center;">Bukti / Nota</th>
                                <th style="width: 10%; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = ($data->currentPage() - 1) * $data->perPage() + 1;
                            @endphp
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($item->jenis == 'pemasukan')
                                            <span class="badge" style="background: #dcfce7; color: #15803d; font-weight: 600; padding: 6px 12px; border-radius: 6px;">
                                                <i class="bi bi-arrow-down-left me-1"></i> Pemasukan
                                            </span>
                                        @else
                                            <span class="badge" style="background: #fee2e2; color: #b91c1c; font-weight: 600; padding: 6px 12px; border-radius: 6px;">
                                                <i class="bi bi-arrow-up-right me-1"></i> Pengeluaran
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td class="fw-bold {{ $item->jenis == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                                        {{ $item->jenis == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($item->nominal, 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($item->bukti)
                                            @php
                                                $ext = pathinfo($item->bukti, PATHINFO_EXTENSION);
                                            @endphp
                                            @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']))
                                                <a href="{{ asset('storage/keuangan/' . $item->bukti) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-3 py-1">
                                                    <i class="bi bi-image"></i> Lihat
                                                </a>
                                            @else
                                                <a href="{{ asset('storage/keuangan/' . $item->bukti) }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1">
                                                    <i class="bi bi-file-earmark-pdf"></i> Dokumen
                                                </a>
                                            @endif
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('keuangan.edit', $item->id) }}" class="btn-act btn-act-edit" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('keuangan.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-act btn-act-delete" onclick="confirmDelete(this)" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-3 d-block mb-1"></i>
                                        Belum ada catatan transaksi keuangan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-3 d-flex justify-content-end">
                    {{ $data->withQueryString()->links() }}
                </div>

            </div>
        </div>
    </section>

</main>

<script>
    function confirmDelete(button) {
        Swal.fire({
            title: 'Hapus Data Keuangan?',
            text: "Data transaksi dan berkas bukti yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }
</script>

@endsection
