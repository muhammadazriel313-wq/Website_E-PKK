@extends('backend.layouts.template')

@section('content1')

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-heading">Serah Terima Jabatan</h1>

                {{-- Notifikasi --}}
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

                {{-- FORM SERAH TERIMA JABATAN --}}
                <div class="form-card mb-4">
                    <h5 class="fw-bold mb-3" style="color: #1e293b;">
                        <i class="bi bi-person-badge me-2 text-primary"></i>Formulir Serah Terima Jabatan Baru
                    </h5>
                    
                    <div class="alert alert-info py-2 px-3 small mb-3" style="border-radius: 8px;">
                        <i class="bi bi-info-circle me-1"></i> Pejabat saat ini yang menyerahkan jabatan: 
                        <strong>{{ $currentUser->name ?? $currentUser->full_name ?? 'Admin' }}</strong> ({{ $currentUser->email ?? $currentUser->phone_number ?? '-' }})
                    </div>

                    <form action="{{ route('serah_terima_jabatan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap Pejabat Baru : <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap beserta gelar" required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label fw-semibold">Email Resmi Pejabat Baru : <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="contoh: pejabat.baru@pkk.go.id" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="nomor_sk_baru" class="form-label fw-semibold">Nomor SK Baru : <span class="text-danger">*</span></label>
                                    <input type="text" name="nomor_sk_baru" id="nomor_sk_baru" class="form-control @error('nomor_sk_baru') is-invalid @enderror" value="{{ old('nomor_sk_baru') }}" placeholder="Contoh: SK/001/PKK/XI/2026" required>
                                    @error('nomor_sk_baru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="tanggal_efektif" class="form-label fw-semibold">Tanggal Efektif : <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_efektif" id="tanggal_efektif" class="form-control @error('tanggal_efektif') is-invalid @enderror" value="{{ old('tanggal_efektif', date('Y-m-d')) }}" required>
                                    @error('tanggal_efektif')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="kata_sandi" class="form-label fw-semibold">Kata Sandi Baru Akun : <span class="text-danger">*</span></label>
                                    <input type="password" name="kata_sandi" id="kata_sandi" class="form-control @error('kata_sandi') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
                                    @error('kata_sandi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="dokumen_sk" class="form-label fw-semibold">Upload Berkas / Salinan SK (Opsional) :</label>
                                    <input type="file" name="dokumen_sk" id="dokumen_sk" class="form-control @error('dokumen_sk') is-invalid @enderror" accept="image/*,.pdf">
                                    <small class="text-muted d-block mt-1">Format: PDF atau Gambar (Maks. 4MB)</small>
                                    @error('dokumen_sk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="keterangan" class="form-label fw-semibold">Catatan / Keterangan Serah Terima (Opsional) :</label>
                                    <textarea name="keterangan" id="keterangan" rows="2" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Catatan peralihan inventaris, berkas, atau pesan...">{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-2">
                            <button class="btn-kirim" type="submit">
                                <i class="bi bi-check2-circle me-1"></i> Proses Serah Terima Jabatan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- TABEL RIWAYAT SERAH TERIMA JABATAN --}}
                <h1 class="page-heading" style="margin-top: 30px;">Riwayat Serah Terima Jabatan</h1>

                <div class="table-card">
                    <table class="table-ttd">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 14%;">Tanggal Efektif</th>
                                <th>Pejabat Lama</th>
                                <th>Pejabat Baru</th>
                                <th>Nomor SK</th>
                                <th style="width: 12%; text-align: center;">Berkas SK</th>
                                <th style="width: 10%; text-align: center;">Status</th>
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
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_efektif)->format('d-m-Y') }}</td>
                                    <td>{{ $item->pejabat_lama ?? '-' }}</td>
                                    <td>
                                        <strong>{{ $item->nama_lengkap }}</strong><br>
                                        <small class="text-muted">{{ $item->email }}</small>
                                    </td>
                                    <td>{{ $item->nomor_sk_baru }}</td>
                                    <td style="text-align: center;">
                                        @if ($item->dokumen_sk)
                                            <a href="{{ asset('storage/serah_terima/' . $item->dokumen_sk) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1">
                                                <i class="bi bi-file-earmark-pdf"></i> Lihat SK
                                            </a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="badge" style="background: #dcfce7; color: #15803d; font-weight: 600; padding: 6px 12px; border-radius: 6px;">
                                            {{ $item->status ?? 'Berhasil' }}
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <form action="{{ route('serah_terima_jabatan.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-act btn-act-delete" onclick="confirmDelete(this)" title="Hapus Riwayat">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-3 d-block mb-1"></i>
                                        Belum ada riwayat serah terima jabatan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-3 d-flex justify-content-end">
                    {{ $data->links() }}
                </div>

            </div>
        </div>
    </section>

</main>

<script>
    function confirmDelete(button) {
        Swal.fire({
            title: 'Hapus Riwayat Serah Terima?',
            text: "Catatan riwayat serah terima jabatan ini akan dihapus dari arsip!",
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
