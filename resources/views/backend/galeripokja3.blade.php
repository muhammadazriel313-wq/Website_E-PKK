@extends('backend.layouts.template')

@section('content1')

<main id="main" class="main">
    <section class="section">
        <h1 class="page-heading">Galeri Kelompok Kerja 3</h1>

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
                    <h4 style="font-family: 'Poppins', sans-serif; font-weight: 700; color: #0f172a; margin-bottom: 6px; font-size: 18px;">Cetak Laporan Pokja 3</h4>
                    <p style="font-family: 'Poppins', sans-serif; color: #64748b; margin-bottom: 0; font-size: 13px;">Cetak rekapitulasi galeri kegiatan Pokja 3 berdasarkan bulan atau tahun.</p>
                </div>
                <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalCetak" style="font-family: 'Poppins', sans-serif; padding: 10px 20px; font-weight: 500; border-radius: 8px;">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </button>
            </div>
        </div>

        <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-6 mb-3">
                <a href="{{ route('galeripangan.index') }}" style="text-decoration: none;">
                    <div class="form-card gallery-card" style="padding: 16px; transition: all 0.3s; cursor: pointer; min-height: 140px; display: flex; flex-direction: column;">
                        <div style="background-color: #fef9c3; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; flex-shrink: 0;">
                            <i class="bi bi-basket2-fill" style="font-size: 22px; color: #ca8a04;"></i>
                        </div>
                        <h5 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 13px; color: #2d3748; margin-bottom: 6px; line-height: 1.3; flex-grow: 1;">Program Pangan</h5>
                        <p style="font-family: 'Poppins', sans-serif; font-size: 11px; color: #6b7280; margin: 0;">{{ $pertama }} Data Galeri</p>
                    </div>
                </a>
            </div>

            <div class="col-md-6 mb-3">
                <a href="{{ route('galerisandang.index') }}" style="text-decoration: none;">
                    <div class="form-card gallery-card" style="padding: 16px; transition: all 0.3s; cursor: pointer; min-height: 140px; display: flex; flex-direction: column;">
                        <div style="background-color: #fce7f3; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; flex-shrink: 0;">
                            <i class="bi bi-bag-heart-fill" style="font-size: 22px; color: #db2777;"></i>
                        </div>
                        <h5 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 13px; color: #2d3748; margin-bottom: 6px; flex-grow: 1;">Program Industri Rumah Tangga</h5>
                        <p style="font-family: 'Poppins', sans-serif; font-size: 11px; color: #6b7280; margin: 0;">{{ $kedua }} Data Galeri</p>
                    </div>
                </a>
            </div>

            <div class="col-md-6 mb-3">
                <a href="{{ route('galeriperumahan.index') }}" style="text-decoration: none;">
                    <div class="form-card gallery-card" style="padding: 16px; transition: all 0.3s; cursor: pointer; min-height: 140px; display: flex; flex-direction: column;">
                        <div style="background-color: #ffedd5; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; flex-shrink: 0;">
                            <i class="bi bi-house-fill" style="font-size: 22px; color: #ea580c;"></i>
                        </div>
                        <h5 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 13px; color: #2d3748; margin-bottom: 6px; line-height: 1.3; flex-grow: 1;">Program Perumahan Dan Tata Laksana Rumah Tangga</h5>
                        <p style="font-family: 'Poppins', sans-serif; font-size: 11px; color: #6b7280; margin: 0;">{{ $ketiga }} Data Galeri</p>
                    </div>
                </a>
            </div>

            <div class="col-md-6 mb-3">
                <a href="{{ route('galerilaporanpokja3.index') }}" style="text-decoration: none;">
                    <div class="form-card gallery-card" style="padding: 16px; transition: all 0.3s; cursor: pointer; min-height: 140px; display: flex; flex-direction: column;">
                        <div style="background-color: #e0f2fe; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; flex-shrink: 0;">
                            <i class="bi bi-person-badge-fill" style="font-size: 22px; color: #0284c7;"></i>
                        </div>
                        <h5 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 13px; color: #2d3748; margin-bottom: 6px; flex-grow: 1;">Kader Pokja 3</h5>
                        <p style="font-family: 'Poppins', sans-serif; font-size: 11px; color: #6b7280; margin: 0;">{{ $keempat }} Data Galeri</p>
                    </div>
                </a>
            </div>
        </div>
    </section>
</main>

{{-- MODAL CETAK --}}
<div class="modal fade" id="modalCetak" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div class="modal-header" style="border-bottom: 1px solid #e2e8f0; padding: 20px 24px;">
                <h5 class="modal-title" style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #0f172a; font-size: 16px;">Cetak Laporan Pokja 3</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('galeripokja3.filter') }}" method="GET" target="_blank">
                <div class="modal-body" style="padding: 24px;">
                    <div class="mb-3">
                        <label class="form-label" style="font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500; color: #475569;">Tipe Cetak</label>
                        <select name="tipe_cetak" id="tipeCetak" class="form-select" style="font-family: 'Poppins', sans-serif; font-size: 14px; height: 42px;" required>
                            <option value="tahunan">Tahunan</option>
                            <option value="perbulan">Per Bulan</option>
                        </select>
                    </div>

                    <div class="mb-3" id="wrapBulan" style="display: none;">
                        <label class="form-label" style="font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500; color: #475569;">Bulan</label>
                        <select name="search" id="bulanSelect" class="form-select" style="font-family: 'Poppins', sans-serif; font-size: 14px; height: 42px;">
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

                    <div class="mb-3">
                        <label class="form-label" style="font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500; color: #475569;">Tahun</label>
                        <select name="search2" class="form-select" style="font-family: 'Poppins', sans-serif; font-size: 14px; height: 42px;" required>
                            <option value="">-- Pilih Tahun --</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e2e8f0; padding: 16px 24px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500; padding: 8px 16px;">Batal</button>
                    <button type="submit" class="btn btn-success" style="font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500; padding: 8px 16px; background-color: #10b981; border-color: #10b981;"><i class="bi bi-printer me-1"></i> Cetak PDF</button>
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
    
    .form-card * {
        font-family: 'Poppins', sans-serif !important;
    }
    
    .form-card h5,
    .form-card p,
    .form-card label,
    .form-card select,
    .form-card button {
        font-family: 'Poppins', sans-serif !important;
    }
</style>

<script>
    // JS untuk Toggle Form Bulan berdasarkan pilihan Tipe Cetak
    document.getElementById('tipeCetak').addEventListener('change', function() {
        const wrapBulan = document.getElementById('wrapBulan');
        const bulanSelect = document.getElementById('bulanSelect');
        
        if(this.value === 'perbulan') {
            wrapBulan.style.display = 'block';
            bulanSelect.setAttribute('required', 'required'); // Wajib diisi kalau cetak bulanan
        } else {
            wrapBulan.style.display = 'none';
            bulanSelect.removeAttribute('required');
            bulanSelect.value = ''; // Reset nilai bulan
        }
    });
</script>

@endsection