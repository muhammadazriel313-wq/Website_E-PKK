@extends('backend.layouts.template')

@section('content1')

<style>
    .table-ttd td,
    .table-ttd th {
        vertical-align: middle !important;
    }

    .table-ttd td {
        padding: 18px 14px;
    }

    .gallery-image-table {
        width: 110px;
        height: 110px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        display: block;
        margin: auto;
    }

    /* DESKRIPSI */
    .table-desc {
        max-width: 220px;
        word-break: break-word;
        font-weight: 500;
        line-height: 1.5;
    }

    /* LOKASI */
    .table-lokasi {
        min-width: 240px;
        max-width: 320px;
        word-break: break-word;
        color: #475569;
        line-height: 1.5;
    }

    /* STATUS */
    .table-status {
        text-align: center;
        vertical-align: middle !important;
    }

    .table-status span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 85px;
        height: 34px;
    }

    /* AKSI */
    .table-aksi {
        text-align: center;
        vertical-align: middle !important;
    }

    .table-aksi-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        min-height: 110px;
    }

    /* BADGE */
    .status-upload {
        background-color: #22c55e;
        color: white;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-proses {
        background-color: #f59e0b;
        color: white;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-upload2 {
        background-color: #2563eb;
        color: white;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    .btn-review-custom {
        background: #06b6d4;
        color: white !important;
        transition: 0.2s;
    }

    .btn-review-custom:hover {
        background: #0891b2 !important;
        color: white !important;
        transform: translateY(-1px);
    }

    .btn-delete-custom {
        background: #ef4444;
        color: white !important;
        transition: 0.2s;
    }

    .btn-delete-custom:hover {
        background: #dc2626 !important;
        color: white !important;
        transform: translateY(-1px);
    }
</style>

<main id="main" class="main">

    <section class="section">

        <h1 class="page-heading">
            Galeri Laporan Kader Pokja 3
        </h1>

        @if ($message = Session::get('success'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">

            {{ $message }}

            <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
            </button>

        </div>

        @endif

        @if ($message = Session::get('error'))

        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            {{ $message }}

            <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
            </button>

        </div>

        @endif

        <div class="table-card">

            <table class="table-ttd">

                <thead>

                    <tr>

                        <th style="width: 60px;">
                            No
                        </th>

                        <th style="width: 150px;">
                            Gambar
                        </th>

                        <th>
                            Deskripsi
                        </th>

                        <th>
                            Lokasi Kegiatan
                        </th>

                        <th style="width: 180px;">
                            Tanggal
                        </th>

                        <th style="width: 120px;">
                            Status
                        </th>

                        <th style="width: 180px; text-align:center;">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @php
                    $no = 1;
                    @endphp

                    @forelse ($data as $tampil)

                    <tr>

                        <td>
                            {{ $no++ }}
                        </td>

                        <td>

                            <img
                                src="{{ asset('storage/gallery/' . $tampil->gambar) }}"
                                alt="{{ $tampil->deskripsi }}"
                                class="gallery-image-table">

                        </td>

                        <td class="table-desc">

                            {{ $tampil->deskripsi }}

                        </td>

                        <td class="table-lokasi">

                            {{ $tampil->lokasi ?? '-' }}

                        </td>

                        <td>

                            {{ \Carbon\Carbon::parse($tampil->created_at)->format('d-m-Y H:i') }}

                        </td>

                        <td class="table-status">

                            @if(strtolower($tampil->status) == 'upload1')

                            <span class="status-upload">
                                Upload1
                            </span>

                            @elseif(strtolower($tampil->status) == 'upload2')

                            <span class="status-upload2">
                                Upload2
                            </span>

                            @else

                            <span class="status-proses">
                                Proses
                            </span>

                            @endif

                        </td>

                        <td class="table-aksi">

                            <div class="table-aksi-wrapper">

                                {{-- WEB KECAMATAN --}}
                                @if(auth()->guard('pengguna')->check())

                                @if(strtolower($tampil->status) == 'proses')

                                <a href="{{ route('galerilaporanpokja3.edit', $tampil->id) }}"
                                    class="btn btn-sm btn-review-custom d-flex align-items-center gap-1 px-3 py-2 border-0 rounded"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title=" Review Data">

                                    <i class="bi bi-search"></i>

                                </a>

                                @endif

                                @endif


                                {{-- WEB KABUPATEN --}}
                                @if(auth()->guard('web')->check())

                                @if(
                                strtolower($tampil->status) == 'upload1' ||
                                strtolower($tampil->status) == 'proses'
                                )

                                <a href="{{ route('galerilaporanpokja3.edit', $tampil->id) }}"
                                    class="btn btn-sm btn-review-custom d-flex align-items-center gap-1 px-3 py-2 border-0 rounded"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Publish Data">

                                    <i class="bi bi-search"></i>

                                </a>

                                @endif

                                @endif


                                {{-- HAPUS --}}
                                <form action="{{ route('galerilaporanpokja3.destroy', $tampil->id)}}"
                                    method="POST"
                                    class="d-inline delete-form">

                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                        class="btn btn-sm btn-delete-custom d-flex align-items-center justify-content-center px-3 py-2 border-0 rounded"
                                        onclick="confirmDelete(this)"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Hapus Data">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7"
                            style="text-align:center; padding:40px; color:#9ca3af;">

                            <i class="bi bi-inbox"
                                style="font-size:48px; display:block; margin-bottom:10px;">
                            </i>

                            Tidak ada data galeri

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </section>

</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    function confirmDelete(button) {
        Swal.fire({
            title: 'Yakin hapus data?',
            text: "Data yang dihapus tidak bisa dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
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