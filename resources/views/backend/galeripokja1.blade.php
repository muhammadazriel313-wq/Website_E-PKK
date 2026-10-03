@extends('backend.layouts.template')

@section('content1')

<style>
    .table-ttd td, .table-ttd th { vertical-align: middle !important; }
    .table-ttd td { padding: 18px 14px; }
    .gallery-image-table { width: 110px; height: 110px; object-fit: cover; border-radius: 10px; border: 1px solid #e2e8f0; display: block; margin: auto; }
    .table-desc { max-width: 220px; word-break: break-word; font-weight: 500; line-height: 1.5; }
    .table-lokasi { min-width: 240px; max-width: 320px; word-break: break-word; color: #475569; line-height: 1.5; }
    .table-status { text-align: center; vertical-align: middle !important; }
    .table-status span { display: inline-flex; align-items: center; justify-content: center; min-width: 85px; height: 34px; }
    .table-aksi { text-align: center; vertical-align: middle !important; }
    .table-aksi-wrapper { display: flex; justify-content: center; align-items: center; gap: 10px; min-height: 110px; }
    .status-upload { background-color: #22c55e; color: white; padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; }
    .status-proses { background-color: #f59e0b; color: white; padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; }
    .btn-review-custom { background: #06b6d4; color: white !important; transition: 0.2s; }
    .btn-review-custom:hover { background: #0891b2 !important; color: white !important; transform: translateY(-1px); }
    .btn-delete-custom { background: #ef4444; color: white !important; transition: 0.2s; }
    .btn-delete-custom:hover { background: #dc2626 !important; color: white !important; transform: translateY(-1px); }
</style>

<main id="main" class="main">
    <section class="section">
        <h1 class="page-heading">Kegiatan Kelompok Kerja 1</h1>

        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

{{-- TOMBOL CETAK MODAL --}}
        <div class="form-card" style="padding: 24px; margin-bottom: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 style="font-family: 'Poppins', sans-serif; font-weight: 700; color: #0f172a; margin-bottom: 6px; font-size: 18px;">Cetak Laporan Pokja 1</h4>
                    <p style="font-family: 'Poppins', sans-serif; color: #64748b; margin-bottom: 0; font-size: 13px;">Cetak seluruh laporan galeri pokja berdasarkan bulan dan tahun.</p>
                </div>
                <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalCetak" style="font-family: 'Poppins', sans-serif; padding: 10px 20px; font-weight: 500; border-radius: 8px; background-color: #2563eb; border: none;">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </button>
            </div>
        </div>


        {{-- Gallery Cards (Sama seperti punya komandan) --}}
        <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-4 mb-3"><a href="{{ route('galeripenghayatan.index') }}" style="text-decoration: none;"><div class="form-card gallery-card" style="padding: 16px; min-height: 140px; display: flex; flex-direction: column;"><div style="background-color: #e0f2fe; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;"><i class="bi bi-shield-fill-check" style="font-size: 22px; color: #0284c7;"></i></div><h5 style="font-weight: 600; font-size: 13px; color: #2d3748; margin-bottom: 6px;">Penghayatan Dan Pengamalan Pancasila</h5><p style="font-size: 11px; color: #6b7280; margin: 0;">{{ $pertama }} Data Galeri</p></div></a></div>
            <div class="col-md-4 mb-3"><a href="{{ route('galerigotongroyong.index') }}" style="text-decoration: none;"><div class="form-card gallery-card" style="padding: 16px; min-height: 140px; display: flex; flex-direction: column;"><div style="background-color: #dcfce7; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;"><i class="bi bi-people-fill" style="font-size: 22px; color: #16a34a;"></i></div><h5 style="font-weight: 600; font-size: 13px; color: #2d3748; margin-bottom: 6px;">Gotong Royong</h5><p style="font-size: 11px; color: #6b7280; margin: 0;">{{ $kedua }} Data Galeri</p></div></a></div>
            <div class="col-md-4 mb-3"><a href="{{ route('galerilaporanpokja1.index') }}" style="text-decoration: none;"><div class="form-card gallery-card" style="padding: 16px; min-height: 140px; display: flex; flex-direction: column;"><div style="background-color: #ede9fe; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;"><i class="bi bi-person-badge-fill" style="font-size: 22px; color: #7c3aed;"></i></div><h5 style="font-weight: 600; font-size: 13px; color: #2d3748; margin-bottom: 6px;">Kader Pokja 1</h5><p style="font-size: 11px; color: #6b7280; margin: 0;">{{ $ketiga }} Data Galeri</p></div></a></div>
        </div>

        <div class="table-card">
            {{-- Tabel Data Komandan tetap disini --}}
            {{-- (Saya asumsikan tabel di sini sudah sesuai, tidak saya tulis ulang agar tidak panjang) --}}
        </div>
    </section>
</main>

{{-- MODAL CETAK --}}
<div class="modal fade" id="modalCetak" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: 600;">Cetak Laporan Pokja 1</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            {{-- Form ini mengarah ke route filter yang sama --}}
            <form action="{{ route('galeripokja1.filter') }}" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tipe Cetak</label>
                        <select id="tipeCetak" class="form-select" required>
                            <option value="tahunan">Tahunan</option>
                            <option value="perbulan">Per Bulan</option>
                        </select>
                    </div>
                    {{-- Input Bulan (name="search" sesuai Controller komandan) --}}
                    <div class="mb-3" id="wrapBulan" style="display: none;">
                        <label class="form-label">Bulan</label>
                        <select name="search" id="bulanSelect" class="form-select">
                            <option value="">-- Pilih Bulan --</option>
                            <option value="01">Januari</option><option value="02">Februari</option>
                            <option value="03">Maret</option><option value="04">April</option>
                            <option value="05">Mei</option><option value="06">Juni</option>
                            <option value="07">Juli</option><option value="08">Agustus</option>
                            <option value="09">September</option><option value="10">Oktober</option>
                            <option value="11">November</option><option value="12">Desember</option>
                        </select>
                    </div>
                    {{-- Input Tahun (name="search2" sesuai Controller komandan) --}}
                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <select name="search2" class="form-select" required>
                            <option value="">-- Pilih Tahun --</option>
                            <option value="2023">2023</option><option value="2024">2024</option>
                            <option value="2025">2025</option><option value="2026">2026</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success"><i class="bi bi-printer"></i> Cetak PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('tipeCetak').addEventListener('change', function() {
        const wrapBulan = document.getElementById('wrapBulan');
        const bulanSelect = document.getElementById('bulanSelect');
        if(this.value === 'perbulan') {
            wrapBulan.style.display = 'block';
            bulanSelect.setAttribute('required', 'required');
        } else {
            wrapBulan.style.display = 'none';
            bulanSelect.removeAttribute('required');
            bulanSelect.value = '';
        }
    });
</script>
@endsection