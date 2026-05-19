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
            Galeri Bidang Umum
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

        {{-- FILTER --}}
        <div class="form-card" style="margin-bottom: 20px; padding: 20px 32px;">

            <form action="{{ route('galeribidangumum.filter') }}"
                method="GET"
                id="filterForm">

                <div class="d-flex align-items-center gap-3 mb-3">

                    <div class="d-flex align-items-center gap-2">

                        <label for="bulan"
                            class="form-label"
                            style="margin-bottom:0; font-size:14px; color:#6b7280; white-space:nowrap; font-weight:500;">

                            Pilih Bulan

                        </label>

                        <select name="bulan"
                            id="bulan"
                            class="form-control"
                            style="height:40px; width:180px; font-size:13px;">

                            <option value="">-- Pilih Bulan --</option>

                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>

                        </select>

                    </div>

                    <div class="d-flex align-items-center gap-2">

                        <label for="tahun"
                            class="form-label"
                            style="margin-bottom:0; font-size:14px; color:#6b7280; white-space:nowrap; font-weight:500;">

                            Pilih Tahun

                        </label>

                        <select name="tahun"
                            id="tahun"
                            class="form-control"
                            style="height:40px; width:180px; font-size:13px;">

                            <option value="">-- Pilih Tahun --</option>

                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>

                        </select>

                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2">

                    <button type="button"
                        class="btn"
                        onclick="resetFilter()"
                        style="background-color:#9ca3af; color:white; height:40px; padding:0 24px; border-radius:6px;">

                        Refresh

                    </button>

                    <button type="button"
                        class="btn d-flex align-items-center justify-content-center gap-2"
                        onclick="submitFilter()"
                        style="background-color:#0369a1; color:white; height:40px; padding:0 24px; border-radius:6px;">

                        <i class="bi bi-funnel-fill"></i>

                        <span>Filter</span>

                    </button>

                </div>

            </form>

        </div>

        {{-- CETAK --}}
        <div class="d-flex justify-content-end mb-3">

            <button type="button"
                class="btn d-flex align-items-center justify-content-center gap-2"
                onclick="cetakGaleri()"
                style="background-color:#0369a1; color:white; height:40px; padding:0 24px; border-radius:6px;">

                <i class="bi bi-download"></i>

                <span>Cetak Galeri</span>

            </button>

        </div>

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

                                <a href="{{ route('galeribidangumum.edit', $tampil->id) }}"
                                    class="btn btn-sm btn-review-custom d-flex align-items-center gap-1 px-3 py-2 border-0 rounded"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Review Data">

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

                                <a href="{{ route('galeribidangumum.edit', $tampil->id) }}"
                                    class="btn btn-sm btn-review-custom d-flex align-items-center gap-1 px-3 py-2 border-0 rounded"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Publish Data">

                                    <i class="bi bi-search"></i>

                                </a>

                                @endif

                                @endif


                                {{-- HAPUS --}}
                                <form action="{{ route('galeribidangumum.destroy', $tampil->id)}}"
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

    function submitFilter() {

        const bulan = document.getElementById('bulan').value;
        const tahun = document.getElementById('tahun').value;

        if (!bulan && !tahun) {
            alert('Silakan pilih bulan atau tahun terlebih dahulu');
            return;
        }

        const tableRows = document.querySelectorAll('.table-ttd tbody tr');

        let visibleCount = 0;

        tableRows.forEach(row => {

            const tanggalCell = row.querySelectorAll('td')[4];

            if (!tanggalCell) return;

            const tanggalText = tanggalCell.textContent.trim();

            let isVisible = true;

            const tanggalParts = tanggalText.split(' ')[0].split('-');

            const rowBulan = tanggalParts[1];
            const rowTahun = tanggalParts[2];

            if (bulan && tahun) {

                isVisible = (rowBulan === bulan && rowTahun === tahun);

            } else if (bulan) {

                isVisible = (rowBulan === bulan);

            } else if (tahun) {

                isVisible = (rowTahun === tahun);

            }

            if (isVisible) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }

        });

    }

    function resetFilter() {

        document.getElementById('bulan').value = '';
        document.getElementById('tahun').value = '';

        const tableRows = document.querySelectorAll('.table-ttd tbody tr');

        tableRows.forEach(row => {
            row.style.display = '';
        });

    }

    function cetakGaleri() {

        const bulan = document.getElementById('bulan').value;
        const tahun = document.getElementById('tahun').value;

        let url = '{{ route("galeribidangumum.filter") }}?';

        if (bulan && tahun) {

            url += 'search=' + tahun + '-' + bulan;

        } else if (tahun) {

            url += 'search2=' + tahun;

        } else {

            alert('Silakan pilih filter terlebih dahulu');
            return;

        }

        window.location.href = url;

    }
</script>

@endsection