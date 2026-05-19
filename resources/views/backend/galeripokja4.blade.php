@extends('backend.layouts.template')

@section('content1')

<main id="main" class="main">
    <section class="section">
        <h1 class="page-heading">Galeri Kelompok Kerja 4</h1>

        <!-- Gallery Cards -->
        <div class="row" style="margin-bottom: 30px;">
            <!-- Kesehatan -->
            <div class="col-md-6 mb-3">
                <a href="{{ route('galerikesehatan.index') }}" style="text-decoration: none;">
                    <div class="form-card gallery-card" style="padding: 16px; transition: all 0.3s; cursor: pointer; min-height: 140px; display: flex; flex-direction: column;">
                        <div style="background-color: #fce7f3; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; flex-shrink: 0;">
                            <i class="bi bi-heart-pulse-fill" style="font-size: 22px; color: #db2777;"></i>
                        </div>
                        <h5 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 13px; color: #2d3748; margin-bottom: 6px; line-height: 1.3; flex-grow: 1;">Kesehatan</h5>
                        <p style="font-family: 'Poppins', sans-serif; font-size: 11px; color: #6b7280; margin: 0;">{{ $pertama }} Data Galeri</p>
                    </div>
                </a>
            </div>

            <!-- Kelestarian Lingkungan Hidup -->
            <div class="col-md-6 mb-3">
                <a href="{{ route('galerikelestarian.index') }}" style="text-decoration: none;">
                    <div class="form-card gallery-card" style="padding: 16px; transition: all 0.3s; cursor: pointer; min-height: 140px; display: flex; flex-direction: column;">
                        <div style="background-color: #dcfce7; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; flex-shrink: 0;">
                            <i class="bi bi-tree-fill" style="font-size: 22px; color: #16a34a;"></i>
                        </div>
                        <h5 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 13px; color: #2d3748; margin-bottom: 6px; flex-grow: 1;">Kelestarian Lingkungan Hidup</h5>
                        <p style="font-family: 'Poppins', sans-serif; font-size: 11px; color: #6b7280; margin: 0;">{{ $kedua }} Data Galeri</p>
                    </div>
                </a>
            </div>

            <!-- Perencanaan Sehat -->
            <div class="col-md-6 mb-3">
                <a href="{{ route('galeriperencanaan.index') }}" style="text-decoration: none;">
                    <div class="form-card gallery-card" style="padding: 16px; transition: all 0.3s; cursor: pointer; min-height: 140px; display: flex; flex-direction: column;">
                        <div style="background-color: #e0f2fe; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; flex-shrink: 0;">
                            <i class="bi bi-calendar2-check-fill" style="font-size: 22px; color: #0284c7;"></i>
                        </div>
                        <h5 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 13px; color: #2d3748; margin-bottom: 6px; flex-grow: 1;">Perencanaan Sehat</h5>
                        <p style="font-family: 'Poppins', sans-serif; font-size: 11px; color: #6b7280; margin: 0;">{{ $ketiga }} Data Galeri</p>
                    </div>
                </a>
            </div>

            <!-- Kader Pokja 4 -->
            <div class="col-md-6 mb-3">
                <a href="{{ route('galerilaporanpokja4.index') }}" style="text-decoration: none;">
                    <div class="form-card gallery-card" style="padding: 16px; transition: all 0.3s; cursor: pointer; min-height: 140px; display: flex; flex-direction: column;">
                        <div style="background-color: #ede9fe; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; flex-shrink: 0;">
                            <i class="bi bi-person-badge-fill" style="font-size: 22px; color: #7c3aed;"></i>
                        </div>
                        <h5 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 13px; color: #2d3748; margin-bottom: 6px; flex-grow: 1;">Kader Pokja 4</h5>
                        <p style="font-family: 'Poppins', sans-serif; font-size: 11px; color: #6b7280; margin: 0;">{{ $keempat }} Data Galeri</p>
                    </div>
                </a>
            </div>

            <!-- Inovasi -->
            <div class="col-md-6 mb-3">
                <a href="{{ route('galeriinovasi.index') }}" style="text-decoration: none;">
                    <div class="form-card gallery-card" style="padding: 16px; transition: all 0.3s; cursor: pointer; min-height: 140px; display: flex; flex-direction: column;">
                        <div style="background-color: #ede9fe; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; flex-shrink: 0;">
                            <i class="bi bi-lightbulb-fill" style="font-size: 22px; color:#ea580c;"></i>
                        </div>
                        <h5 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 13px; color: #2d3748; margin-bottom: 6px; flex-grow: 1;">Inovasi</h5>
                        <p style="font-family: 'Poppins', sans-serif; font-size: 11px; color: #6b7280; margin: 0;">{{ $kelima }} Data Galeri</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row">
            <!-- Cetak Perbulan -->
            <div class="col-md-6 mb-3">
                <div class="form-card">
                    <h5 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 14px; margin-bottom: 12px; color: #2d3748;">Cetak Perbulan</h5>
                    <form action="{{ route('galeripokja4.filter') }}" method="GET">
                        <div class="d-flex align-items-end gap-2">
                            <div style="flex: 1;">
                                <label style="font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 500; color: #6b7280; margin-bottom: 6px; display: block;">Bulan :</label>
                                <select name="search" class="form-control" style="height: 38px; font-size: 13px;">
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
                            <button type="submit" class="btn-kirim" style="margin-bottom: 0; font-size: 13px; padding: 8px 20px;">Cetak</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Cetak Pertahun -->
            <div class="col-md-6 mb-3">
                <div class="form-card">
                    <h5 style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 14px; margin-bottom: 12px; color: #2d3748;">Cetak Pertahun</h5>
                    <form action="{{ route('galeripokja4.filter') }}" method="GET">
                        <div class="d-flex align-items-end gap-2">
                            <div style="flex: 1;">
                                <label style="font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 500; color: #6b7280; margin-bottom: 6px; display: block;">Tahun :</label>
                                <select name="search2" class="form-control" style="height: 38px; font-size: 13px;">
                                    <option value="">-- Pilih Tahun --</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                </select>
                            </div>
                            <button type="submit" class="btn-kirim" style="margin-bottom: 0; font-size: 13px; padding: 8px 20px;">Cetak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

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
    
    .form-card h5,
    .form-card p,
    .form-card label,
    .form-card select,
    .form-card button {
        font-family: 'Poppins', sans-serif !important;
    }
</style>

@endsection
