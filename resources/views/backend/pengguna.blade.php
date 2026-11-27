@extends('backend.layouts.template')

@section('content1')

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-md-12">
                
                {{-- JUDUL HALAMAN --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="page-heading mb-0">Data Pengguna E-PKK</h1>
                </div>

                {{-- NOTIFIKASI SUKSES / GAGAL --}}
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- TAB KECAMATAN & DESA BERSERTA FORM PENCARIAN SEJAJAR --}}
                <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header bg-white border-bottom p-3">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                            {{-- TAB KECAMATAN & DESA BESERTA TOTAL PENGGUNA --}}
                            <ul class="nav nav-pills card-header-pills m-0" id="penggunaTabs" role="tablist">
                                {{-- TAB KECAMATAN + TOTAL --}}
                                <li class="nav-item me-2" role="presentation">
                                    <button class="nav-link custom-tab-btn {{ $tab == 'kecamatan' ? 'active' : '' }}" 
                                        id="tab-kecamatan-btn" 
                                        data-bs-toggle="pill" 
                                        data-bs-target="#tab-kecamatan" 
                                        type="button" 
                                        role="tab"
                                        onclick="setTab('kecamatan')">
                                        <i class="bi bi-building me-1"></i>
                                        <span class="tab-title">Kecamatan</span>
                                        <span class="badge badge-tab ms-2">{{ number_format($totalKecamatan, 0, ',', '.') }}</span>
                                    </button>
                                </li>

                                {{-- TAB DESA + TOTAL --}}
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link custom-tab-btn {{ $tab == 'desa' ? 'active' : '' }}" 
                                        id="tab-desa-btn" 
                                        data-bs-toggle="pill" 
                                        data-bs-target="#tab-desa" 
                                        type="button" 
                                        role="tab"
                                        onclick="setTab('desa')">
                                        <i class="bi bi-houses me-1"></i>
                                        <span class="tab-title">Desa</span>
                                        <span class="badge badge-tab ms-2">{{ number_format($totalDesa, 0, ',', '.') }}</span>
                                    </button>
                                </li>
                            </ul>

                            {{-- SEARCH FORM SEJAJAR DENGAN KECAMATAN & DESA --}}
                            <form method="GET" action="{{ route('pengguna.index') }}" class="d-flex align-items-center gap-2 m-0 flex-grow-1 flex-md-grow-0">
                                <input type="hidden" name="tab" id="active-tab-input" value="{{ $tab }}">

                                <div class="input-group" style="min-width: 260px; max-width: 320px;">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                                    <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama, telepon, wilayah..." value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit" style="background-color: #016AA3; border-color: #016AA3;">
                                        Cari
                                    </button>
                                </div>

                                @if(request()->filled('search'))
                                    <a href="{{ route('pengguna.index', ['tab' => $tab]) }}" class="btn btn-outline-secondary" title="Reset Pencarian">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                @endif
                            </form>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="tab-content" id="penggunaTabsContent">
                            
                            {{-- ======================================================== --}}
                            {{-- 1. KONTEN TAB: PENGGUNA TINGKAT KECAMATAN               --}}
                            {{-- ======================================================== --}}
                            <div class="tab-pane fade {{ $tab == 'kecamatan' ? 'show active' : '' }}" id="tab-kecamatan" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0" style="font-size: 14px;">
                                        <thead style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0; color: #475569;">
                                            <tr>
                                                <th class="ps-4" style="width: 5%;">No</th>
                                                <th>Nama Lengkap</th>
                                                <th>Nomor Telepon / WhatsApp</th>
                                                <th>Kecamatan</th>
                                                <th style="text-align: center;">Status</th>
                                                <th style="text-align: center; width: 110px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $noKec = ($penggunaKecamatan->currentPage() - 1) * $penggunaKecamatan->perPage() + 1;
                                            @endphp
                                            @forelse ($penggunaKecamatan as $item)
                                                <tr>
                                                    <td class="ps-4 fw-semibold text-muted">{{ $noKec++ }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-circle me-3">
                                                                {{ strtoupper(substr($item->full_name, 0, 1)) }}
                                                            </div>
                                                            <div>
                                                                <span class="fw-bold text-dark d-block">{{ $item->full_name }}</span>
                                                                <small class="text-muted"><i class="bi bi-shield-check text-primary me-1"></i>TP PKK Kecamatan</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $item->phone_number)) }}" target="_blank" class="text-decoration-none" style="color: #059669;">
                                                            <i class="bi bi-whatsapp me-1"></i>{{ $item->phone_number }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark border px-2 py-1">
                                                            {{ Str::startsWith(strtolower($item->subdistrict->name ?? ''), ['kecamatan', 'kec.']) ? $item->subdistrict->name : 'Kec. ' . ($item->subdistrict->name ?? '-') }}
                                                        </span>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        @if (strtolower($item->status) == 'active')
                                                             <span class="badge rounded-pill bg-success px-3 py-1">Aktif</span>
                                                        @else
                                                            <span class="badge rounded-pill bg-secondary px-3 py-1">{{ $item->status ?? 'Nonaktif' }}</span>
                                                        @endif
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <div class="d-inline-flex gap-1 justify-content-center">
                                                            <a href="{{ route('pengguna.edit', $item->id) }}" class="btn-act btn-act-edit" title="Edit Pengguna">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </a>
                                                            <form action="{{ route('pengguna.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn-act btn-act-delete" onclick="confirmDelete(this, '{{ addslashes($item->full_name) }}')" title="Hapus Pengguna">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-5 text-muted">
                                                        <i class="bi bi-person-x fs-1 d-block mb-2 text-secondary"></i>
                                                        Tidak ada data pengguna tingkat Kecamatan yang ditemukan.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                {{-- PAGINATION KECAMATAN --}}
                                <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap">
                                    <small class="text-muted mb-2 mb-md-0">
                                        Menampilkan {{ $penggunaKecamatan->firstItem() ?? 0 }} - {{ $penggunaKecamatan->lastItem() ?? 0 }} dari total {{ $penggunaKecamatan->total() }} pengguna Kecamatan
                                    </small>
                                    <div>
                                        {{ $penggunaKecamatan->links() }}
                                    </div>
                                </div>
                            </div>

                            {{-- ======================================================== --}}
                            {{-- 2. KONTEN TAB: PENGGUNA TINGKAT DESA                     --}}
                            {{-- ======================================================== --}}
                            <div class="tab-pane fade {{ $tab == 'desa' ? 'show active' : '' }}" id="tab-desa" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0" style="font-size: 14px;">
                                        <thead style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0; color: #475569;">
                                            <tr>
                                                <th class="ps-4" style="width: 5%;">No</th>
                                                <th>Nama Lengkap</th>
                                                <th>Nomor Telepon / WhatsApp</th>
                                                <th>Desa / Kelurahan</th>
                                                <th>Kecamatan</th>
                                                <th style="text-align: center;">Status</th>
                                                <th style="text-align: center; width: 110px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $noDes = ($penggunaDesa->currentPage() - 1) * $penggunaDesa->perPage() + 1;
                                            @endphp
                                            @forelse ($penggunaDesa as $item)
                                                <tr>
                                                    <td class="ps-4 fw-semibold text-muted">{{ $noDes++ }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-circle avatar-desa me-3">
                                                                {{ strtoupper(substr($item->full_name, 0, 1)) }}
                                                            </div>
                                                            <div>
                                                                <span class="fw-bold text-dark d-block">{{ $item->full_name }}</span>
                                                                <small class="text-muted"><i class="bi bi-person-badge text-success me-1"></i>Kader / Pengurus Desa</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $item->phone_number)) }}" target="_blank" class="text-decoration-none" style="color: #059669;">
                                                            <i class="bi bi-whatsapp me-1"></i>{{ $item->phone_number }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark border px-2 py-1">
                                                            {{ Str::startsWith(strtolower($item->village->name ?? ''), ['desa', 'kelurahan']) ? $item->village->name : 'Desa ' . ($item->village->name ?? '-') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="text-secondary small">
                                                            {{ Str::startsWith(strtolower($item->subdistrict->name ?? ''), ['kecamatan', 'kec.']) ? $item->subdistrict->name : 'Kec. ' . ($item->subdistrict->name ?? '-') }}
                                                        </span>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        @if (strtolower($item->status) == 'active')
                                                            <span class="badge rounded-pill bg-success px-3 py-1">Aktif</span>
                                                        @else
                                                            <span class="badge rounded-pill bg-secondary px-3 py-1">{{ $item->status ?? 'Nonaktif' }}</span>
                                                        @endif
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <div class="d-inline-flex gap-1 justify-content-center">
                                                            <a href="{{ route('pengguna.edit', $item->id) }}" class="btn-act btn-act-edit" title="Edit Pengguna">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </a>
                                                            <form action="{{ route('pengguna.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn-act btn-act-delete" onclick="confirmDelete(this, '{{ addslashes($item->full_name) }}')" title="Hapus Pengguna">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center py-5 text-muted">
                                                        <i class="bi bi-person-x fs-1 d-block mb-2 text-secondary"></i>
                                                        Tidak ada data pengguna tingkat Desa yang ditemukan.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                {{-- PAGINATION DESA --}}
                                <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap">
                                    <small class="text-muted mb-2 mb-md-0">
                                        Menampilkan {{ $penggunaDesa->firstItem() ?? 0 }} - {{ $penggunaDesa->lastItem() ?? 0 }} dari total {{ $penggunaDesa->total() }} pengguna Desa
                                    </small>
                                    <div>
                                        {{ $penggunaDesa->links() }}
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

<style>
    /* Styling Nav Tabs */
    .custom-tab-btn {
        color: #475569 !important;
        font-weight: 600 !important;
        font-size: 15px !important;
        padding: 10px 20px !important;
        border-radius: 8px !important;
        background: #f1f5f9 !important;
        transition: all 0.2s ease !important;
        border: 1px solid #e2e8f0 !important;
    }
    .custom-tab-btn .badge-tab {
        background-color: #cbd5e1;
        color: #1e293b;
        font-size: 13px;
        padding: 4px 10px;
        border-radius: 20px;
        transition: all 0.2s ease;
    }
    .custom-tab-btn.active {
        background: #016AA3 !important;
        color: #ffffff !important;
        border-color: #016AA3 !important;
        box-shadow: 0 4px 12px rgba(1, 106, 163, 0.25) !important;
    }
    .custom-tab-btn.active .badge-tab {
        background-color: #ffffff !important;
        color: #016AA3 !important;
    }
    
    /* Avatar Lingkaran */
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
        color: #ffffff;
        font-weight: 700;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(2, 132, 199, 0.3);
        flex-shrink: 0;
    }
    .avatar-desa {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3);
    }

    /* Tombol Aksi */
    .btn-act {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: 1px solid transparent;
        font-size: 14px;
        transition: all 0.2s ease-in-out;
        text-decoration: none;
    }
    .btn-act-edit {
        color: #0284c7;
        background-color: #e0f2fe;
        border-color: #bae6fd;
    }
    .btn-act-edit:hover {
        color: #ffffff;
        background-color: #0284c7;
        border-color: #0284c7;
    }
    .btn-act-delete {
        color: #dc2626;
        background-color: #fee2e2;
        border-color: #fecaca;
    }
    .btn-act-delete:hover {
        color: #ffffff;
        background-color: #dc2626;
        border-color: #dc2626;
    }
</style>

<script>
    function setTab(tabName) {
        document.getElementById('active-tab-input').value = tabName;
        // Simpan preferensi tab ke URL query tanpa reload penuh jika diperlukan
        const url = new URL(window.location);
        url.searchParams.set('tab', tabName);
        window.history.replaceState({}, '', url);
    }

    function confirmDelete(button, name) {
        Swal.fire({
            title: 'Hapus Pengguna?',
            text: 'Apakah Anda yakin ingin menghapus akun pengguna "' + name + '"? Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
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
