@extends('backend.layouts.template')

@section('content1')

<style>
    * { font-family: 'Poppins', sans-serif !important; }
    .page-heading { font-size: 24px; font-weight: 600; color: #1e293b; margin-bottom: 20px; }
    .form-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important; }
</style>

<main id="main" class="main">
    <section class="section">
        <h1 class="page-heading">Laporan Bidang Umum</h1>

        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Perhatian!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Cards Section (Status Laporan) - DIPINDAH KE ATAS -->
        <div class="row mb-4">
            <!-- Menunggu Persetujuan -->
            <div class="col-md-6 mb-3">
                <a href="{{ route('bidangumum.index') }}" style="text-decoration: none;">
                    <div class="form-card" style="cursor:pointer; transition:all 0.3s; border-radius:16px; box-shadow:0 1px 4px rgba(0,0,0,0.08); background:white; padding:24px;">
                        <div class="d-flex align-items-center mb-3">
                            <div style="background:#fef2f2; width:56px; height:56px; border-radius:14px; display:flex; align-items:center; justify-content:center; margin-right:16px;">
                                <i class="bi bi-hourglass-split" style="font-size:26px; color:#ef4444;"></i>
                            </div>
                            <h5 style="font-weight:600; font-size:14px; color:#1e293b; margin:0;">Menunggu Persetujuan</h5>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span style="font-size:28px; font-weight:600; color:#0369a1;">{{ $got1 }}</span>
                            <span style="font-size:13px; color:#94a3b8;">Jumlah total laporan</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Sudah Disetujui -->
            <div class="col-md-6 mb-3">
                <a href="{{ route('decbidangumum.index') }}" style="text-decoration: none;">
                    <div class="form-card" style="cursor:pointer; transition:all 0.3s; border-radius:16px; box-shadow:0 1px 4px rgba(0,0,0,0.08); background:white; padding:24px;">
                        <div class="d-flex align-items-center mb-3">
                            <div style="background:#f0fdf4; width:56px; height:56px; border-radius:14px; display:flex; align-items:center; justify-content:center; margin-right:16px;">
                                <i class="bi bi-patch-check-fill" style="font-size:26px; color:#10b981;"></i>
                            </div>
                            <h5 style="font-weight:600; font-size:14px; color:#1e293b; margin:0;">Sudah Disetujui</h5>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span style="font-size:28px; font-weight:600; color:#0369a1;">{{ $got2 }}</span>
                            <span style="font-size:13px; color:#94a3b8;">Jumlah total laporan</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Card Cetak Utama - DIPINDAH KE BAWAH -->
        <div class="row">
            <div class="col-12">
                <div class="form-card" style="background:white; border-radius:12px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                    <h5 style="font-weight:600; font-size:16px; color:#2d3748; margin-bottom:6px;">Laporan Bidang Umum</h5>
                    <p style="font-size:13px; color:#6b7280; margin-bottom:16px;">Cetak laporan berdasarkan bulan, tahun, dan format file.</p>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalLaporan" style="padding: 8px 20px; border-radius: 8px;">
                        <i class="bi bi-file-earmark-arrow-down me-1"></i> Cetak Laporan
                    </button>
                </div>
            </div>
        </div>

    </section>
</main>

<!-- MODAL CETAK / EXPORT -->
<div class="modal fade" id="modalLaporan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: 600;">Cetak Bidang Umum</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formExport">
                @csrf
                <div class="modal-body">
                    <!-- BULAN -->
                    <div class="mb-3">
                        <label style="font-size: 13px; font-weight: 500;">Bulan <span class="text-muted">(Opsional untuk tahunan)</span></label>
                        <select name="bulan" class="form-select">
                            <option value="">-- Pilih Bulan --</option>
                            <option value="1">Januari</option><option value="2">Februari</option>
                            <option value="3">Maret</option><option value="4">April</option>
                            <option value="5">Mei</option><option value="6">Juni</option>
                            <option value="7">Juli</option><option value="8">Agustus</option>
                            <option value="9">September</option><option value="10">Oktober</option>
                            <option value="11">November</option><option value="12">Desember</option>
                        </select>
                    </div>

                    <!-- TAHUN -->
                    <div class="mb-3">
                        <label style="font-size: 13px; font-weight: 500;">Tahun <span class="text-danger">*</span></label>
                        <select name="tahun" class="form-select" required>
                            <option value="">-- Pilih Tahun --</option>
                            @for ($year = now()->year; $year >= 2021; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>

                    <!-- FORMAT -->
                    <div class="mb-3">
                        <label style="font-size: 13px; font-weight: 500;">Format <span class="text-danger">*</span></label>
                        <select name="format" id="formatExport" class="form-select" required>
                            <option value="">-- Pilih Format --</option>
                            <option value="pdf">📄 PDF (Download)</option>
                            <option value="excel">📊 Google Sheets (Online)</option>
                        </select>
                    </div>

                    <!-- INFO LINK GOOGLE SHEETS -->
                    <div class="alert alert-primary mt-3" id="infoLinkSheet" style="display: none; border-left: 4px solid #0d6efd; background-color: #f0f7ff;">
                        <h6 class="alert-heading fw-bold mb-1" style="font-size: 13px;"><i class="bi bi-link-45deg"></i> Link Spreadsheet Tujuan</h6>
                        <p class="mb-2" style="font-size: 12px; color: #475569;">Data akan diekspor dan disusun otomatis ke tab di Google Sheets berikut:</p>
                        {{-- [PERUBAHAN 2026-10-09] Mengambil URL Spreadsheet dari config services; URL hardcode dinonaktifkan --}}
                        {{-- <a href="https://docs.google.com/spreadsheets/d/1jQo74NIJiUAcrWdVE8O-Afup-ijjCY733F151trNlp4/edit?usp=sharing" target="_blank" class="btn btn-sm btn-light text-primary" style="font-size: 12px; font-weight: 600; border: 1px solid #cce3fd;"> --}}
                        <a id="linkSheetBidangUmum" href="{{ config('services.sheets.spreadsheet_url') ?: '#' }}" target="_blank" class="btn btn-sm btn-light text-primary" style="font-size: 12px; font-weight: 600; border: 1px solid #cce3fd;">
                            <i class="bi bi-box-arrow-up-right"></i> Buka Spreadsheet Laporan
                        </a>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" id="btnExport">
                        <i class="bi bi-download"></i> <span id="btnText">Export</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // URL GOOGLE APPS SCRIPT BIDANG UMUM
    // [PERUBAHAN 2026-10-09] Mengambil URL Apps Script dan Spreadsheet dari config services; URL hardcode dinonaktifkan
    // const APPS_SCRIPT_URL = "https://script.google.com/macros/s/AKfycbwRFcqpMF2IP81GirLgjnNzaD5_k3DBF5yAwbP5nS82_DiFtKn7nbZCW-z3np4NvuMV/exec";
    const APPS_SCRIPT_URL = "{{ config('services.sheets.script_url') }}";
    // const SHEET_HREF = "https://docs.google.com/spreadsheets/d/1jQo74NIJiUAcrWdVE8O-Afup-ijjCY733F151trNlp4/edit?usp=sharing";
    const SHEET_HREF = "{{ config('services.sheets.spreadsheet_url') }}";

    // [PERUBAHAN 2026-10-09] Fungsi navigasi langsung ke tab Google Sheets Bidang Umum
    function updateLinkBidangUmum() {
        const saved = localStorage.getItem('sheet_tab_bidang_umum') || SHEET_HREF;
        const el = document.getElementById("linkSheetBidangUmum");
        if (el && saved) el.href = saved;
    }

    document.getElementById("formatExport").addEventListener("change", function() {
        const isExcel = this.value === "excel";
        document.getElementById("infoLinkSheet").style.display = isExcel ? "block" : "none";
        if (isExcel) updateLinkBidangUmum();
    });
    updateLinkBidangUmum();

    document.getElementById("formExport").addEventListener("submit", async function(e){
        e.preventDefault();
        
        const format = document.getElementById("formatExport").value;
        const btn = document.getElementById("btnExport");
        const btnText = document.getElementById("btnText");
        const form = e.target;
        
        const formData = new FormData(form);
        const bulan = formData.get('bulan');
        const tahun = formData.get('tahun');
        
        if(!format) {
            Swal.fire({ icon: 'warning', title: 'Pilih Format!', text: 'Silakan pilih format export terlebih dahulu' });
            return;
        }
        
        // --- EXPORT PDF ---
        if(format === "pdf"){
            let params = new URLSearchParams();
            if (bulan && tahun) {
                params.append('search', `${tahun}-${bulan.toString().padStart(2, '0')}`);
            } else if (tahun) {
                params.append('search2', tahun);
            }
            window.location.href = "{{ route('bidangumum.filter') }}?" + params.toString(); 
            return;
        } 
        
        // --- EXPORT GOOGLE SHEETS ---
        if(format === "excel"){
            // [PERUBAHAN 2026-10-09] Validasi URL Apps Script dari .env
            if (!APPS_SCRIPT_URL || APPS_SCRIPT_URL.trim() === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'URL Belum Diatur!',
                    text: 'URL Google Sheets belum diatur di .env'
                });
                return;
            }

            const confirmExport = await Swal.fire({
              title: 'Mulai Ekspor?',
              html: `Data akan ditimpa/diperbarui ke dalam <b>Google Sheets Bidang Umum</b>.<br><br>
                     <a href="${SHEET_HREF}" target="_blank" style="text-decoration: none; color: #0d6efd; font-weight: 600; background: #f8f9fa; padding: 5px 10px; border-radius: 5px;">
                       <i class="bi bi-box-arrow-up-right"></i> Pratinjau Spreadsheet
                     </a>`,
              icon: 'question',
              showCancelButton: true,
              confirmButtonColor: '#198754', cancelButtonColor: '#6c757d',
              confirmButtonText: '<i class="bi bi-send"></i> Ya, Ekspor!', cancelButtonText: 'Batal', reverseButtons: true
            });

            if (!confirmExport.isConfirmed) return; 

            btn.disabled = true;
            btnText.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';
            Swal.fire({ title: 'Mengekspor data...', text: 'Sedang mengambil data dari Database...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });

            try {
                // 1. Fetch JSON dari Laravel
                const urlTarget = `{{ route('bidangumum.exportJson') }}?bulan=${bulan}&tahun=${tahun}`;
                const dbResponse = await fetch(urlTarget);
                
                if (!dbResponse.ok) throw new Error(`Status HTTP Laravel: ${dbResponse.status}`);
                
                const dbResult = await dbResponse.json();

                if(dbResult.status === 'empty' || !dbResult.data || dbResult.data.length === 0) {
                    Swal.fire('Data Kosong', dbResult.message || 'Tidak ada laporan yang sesuai pada periode tersebut.', 'info');
                    btn.disabled = false; btnText.textContent = 'Export'; return;
                }

                // [PERUBAHAN 2026-10-09] Lengkapi metadata identitas pokja dan periode
                dbResult.pokja = 'BIDANG UMUM';
                dbResult.bulan = bulan;
                dbResult.tahun = tahun;

                Swal.update({ text: `Ditemukan ${dbResult.data.length} baris. Mengirim ke Google Sheets...` });

                // 2. Tembak ke Apps Script
                const googleResponse = await fetch(APPS_SCRIPT_URL, {
                    method: 'POST', redirect: 'follow', 
                    headers: { 'Content-Type': 'text/plain;charset=utf-8' },
                    body: JSON.stringify(dbResult)
                });

                const textResult = await googleResponse.text();

                try {
                    const result = JSON.parse(textResult);
                    if(result.status === "success") {
                        const directTabUrl = result.tab_url || SHEET_HREF;
                        if (result.tab_url) {
                            try {
                                localStorage.setItem('sheet_tab_bidang_umum', result.tab_url);
                                const el = document.getElementById("linkSheetBidangUmum");
                                if (el) el.href = result.tab_url;
                            } catch(e) {}
                        }
                        Swal.fire({
                            icon: 'success', title: 'Berhasil!',
                            html: `✅ ${result.message}<br><br><a href="${directTabUrl}" target="_blank" class="btn btn-sm btn-primary text-white" style="font-weight:600;"><i class="bi bi-box-arrow-up-right"></i> Buka Langsung Tab Laporan</a>`,
                            confirmButtonText: 'Tutup',
                        }).then(() => {
                            form.reset(); document.getElementById("infoLinkSheet").style.display = "none";
                            bootstrap.Modal.getInstance(document.getElementById('modalLaporan'))?.hide();
                        });
                    } else { throw new Error(result.message); }
                } catch(e) {
                    let debugHTML = textResult.substring(0, 150).replace(/</g, "&lt;").replace(/>/g, "&gt;");
                    throw new Error(`Google Apps Script Error. Pastikan Deploy as Web App di-set ke 'Anyone'.<br><br><small style="color:red;">${debugHTML}...</small>`);
                }
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'Gagal Mengirim!', html: `Terjadi kesalahan:<br><br><code>${error.message}</code>` });
            } finally {
                btn.disabled = false; btnText.textContent = 'Export';
            }
        }
    });
</script>

@endsection 