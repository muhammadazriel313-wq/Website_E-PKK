@extends('backend.layouts.template')

@section('content1')

<main id="main" class="main">
    <section class="section">
        <h1 class="page-heading">Galeri Kelompok Kerja 2</h1>

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
                    <h4 style="font-family: 'Poppins', sans-serif; font-weight: 700; color: #0f172a; margin-bottom: 6px; font-size: 18px;">Cetak Laporan Bidang Umum</h4>
                    <p style="font-family: 'Poppins', sans-serif; color: #64748b; margin-bottom: 0; font-size: 13px;">Cetak seluruh laporan galeri bidang umum berdasarkan bulan dan tahun.</p>
                </div>
                <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalCetak" style="font-family: 'Poppins', sans-serif; padding: 10px 20px; font-weight: 500; border-radius: 8px; background-color: #2563eb; border: none;">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </button>
            </div>
        </div>



        <!-- Gallery Cards -->
        <div class="row" style="margin-bottom: 30px;">
            <!-- Pendidikan Dan Ketrampilan -->
            <div class="col-md-6 mb-3">
                <a href="{{ route('galeripendidikan.index') }}" style="text-decoration: none;">
                    <div class="form-card gallery-card" style="padding: 16px; transition: all 0.3s; cursor: pointer; min-height: 140px; display: flex; flex-direction: column;">
                        <div style="background-color: #ede9fe; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; flex-shrink: 0;">
                            <i class="bi bi-mortarboard-fill" style="font-size: 22px; color: #7c3aed;"></i>
                        </div>
                        <h5 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 13px; color: #2d3748; margin-bottom: 6px; line-height: 1.3; flex-grow: 1;">Pendidikan Dan Ketrampilan</h5>
                        <p style="font-family: 'Poppins', sans-serif; font-size: 11px; color: #6b7280; margin: 0;">{{ $pertama }} Data Galeri</p>
                    </div>
                </a>
            </div>

            <!-- Pengembangan Kehidupan Berkoperasi -->
            <div class="col-md-6 mb-3">
                <a href="{{ route('galeripengembangan.index') }}" style="text-decoration: none;">
                    <div class="form-card gallery-card" style="padding: 16px; transition: all 0.3s; cursor: pointer; min-height: 140px; display: flex; flex-direction: column;">
                        <div style="background-color: #fef9c3; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; flex-shrink: 0;">
                            <i class="bi bi-graph-up-arrow" style="font-size: 22px; color: #ca8a04;"></i>
                        </div>
                        <h5 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 13px; color: #2d3748; margin-bottom: 6px; flex-grow: 1;">Pengembangan Kehidupan Berkoperasi</h5>
                        <p style="font-family: 'Poppins', sans-serif; font-size: 11px; color: #6b7280; margin: 0;">{{ $kedua }} Data Galeri</p>
                    </div>
                </a>
            </div>
        </div>
    </section>
</main>

{{-- MODAL CETAK --}}
<div class="modal fade" id="modalCetak" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; font-family: 'Poppins', sans-serif;">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: 600;">Cetak Laporan Pokja 2</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('galeripokja2.filter') }}" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 14px; font-weight: 500;">Tipe Cetak</label>
                        <select id="tipeCetak" class="form-select" required>
                            <option value="tahunan">Tahunan</option>
                            <option value="perbulan">Per Bulan</option>
                        </select>
                    </div>
                    {{-- Input Bulan --}}
                    <div class="mb-3" id="wrapBulan" style="display: none;">
                        <label class="form-label" style="font-size: 14px; font-weight: 500;">Bulan</label>
                        <select name="search" id="bulanSelect" class="form-select">
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
                    {{-- Input Tahun --}}
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 14px; font-weight: 500;">Tahun</label>
                        <select name="search2" class="form-select" required>
                            <option value="">-- Pilih Tahun --</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
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

<style>
    .gallery-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15) !important;
    }
    
    .gallery-card {
        height: 100%;
    }
    
    /* Pastikan semua text menggunakan Poppins */
    .form-card * {
        font-family: 'Poppins', sans-serif !important;
    }
</style>

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