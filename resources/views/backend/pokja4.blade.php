@extends('backend.layouts.template')

@section('content1')

<style>
  * { font-family: 'Poppins', sans-serif !important; }
  .page-heading { font-family: 'Poppins', sans-serif; font-size: 24px; font-weight: 600; color: #1e293b; margin-bottom: 20px; }
  .pokja-card:hover { transform: translateY(-4px); box-shadow: 0 8px 16px rgba(0,0,0,0.12) !important; }
</style>

<main id="main" class="main">
  <section class="section">
    <h1 class="page-heading">Laporan Pokja 4</h1>

    @if (session('error'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Perhatian!</strong> {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- CARDS LAPORAN --}}
    <div class="row mb-3">

      {{-- KESEHATAN --}}
      <div class="col-md-6 col-lg-3 mb-3">
        <a href="{{ route('acckesehatan.index') }}" style="text-decoration:none;">
          <div class="form-card pokja-card" style="background:white; border-radius:16px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,0.08); transition:all 0.3s; cursor:pointer;">
            <div class="d-flex align-items-center mb-3">
              <div style="background:#fce7f3; width:56px; height:56px; border-radius:14px; display:flex; align-items:center; justify-content:center; margin-right:16px; flex-shrink:0;">
                <i class="bi bi-heart-pulse-fill" style="font-size:26px; color:#db2777;"></i>
              </div>
              <h5 style="font-weight:600; font-size:14px; color:#1e293b; margin:0; line-height:1.4;">Kesehatan</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
              <span style="font-size:28px; font-weight:600; color:#0369a1;">{{ $modelPertama ?? 0 }}</span>
              <span style="font-size:13px; color:#94a3b8;">Jumlah total laporan</span>
            </div>
          </div>
        </a>
      </div>

      {{-- KELESTARIAN --}}
      <div class="col-md-6 col-lg-3 mb-3">
        <a href="{{ route('acckelestarian.index') }}" style="text-decoration:none;">
          <div class="form-card pokja-card" style="background:white; border-radius:16px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,0.08); transition:all 0.3s; cursor:pointer;">
            <div class="d-flex align-items-center mb-3">
              <div style="background:#dcfce7; width:56px; height:56px; border-radius:14px; display:flex; align-items:center; justify-content:center; margin-right:16px; flex-shrink:0;">
                <i class="bi bi-tree-fill" style="font-size:26px; color:#16a34a;"></i>
              </div>
              <h5 style="font-weight:600; font-size:14px; color:#1e293b; margin:0; line-height:1.4;">Kelestarian Lingkungan Hidup</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
              <span style="font-size:28px; font-weight:600; color:#0369a1;">{{ $modelKedua ?? 0 }}</span>
              <span style="font-size:13px; color:#94a3b8;">Jumlah total laporan</span>
            </div>
          </div>
        </a>
      </div>

      {{-- PERENCANAAN --}}
      <div class="col-md-6 col-lg-3 mb-3">
        <a href="{{ route('accperencanaan.index') }}" style="text-decoration:none;">
          <div class="form-card pokja-card" style="background:white; border-radius:16px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,0.08); transition:all 0.3s; cursor:pointer;">
            <div class="d-flex align-items-center mb-3">
              <div style="background:#e0f2fe; width:56px; height:56px; border-radius:14px; display:flex; align-items:center; justify-content:center; margin-right:16px; flex-shrink:0;">
                <i class="bi bi-calendar2-check-fill" style="font-size:26px; color:#0284c7;"></i>
              </div>
              <h5 style="font-weight:600; font-size:14px; color:#1e293b; margin:0; line-height:1.4;">Perencanaan Sehat</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
              <span style="font-size:28px; font-weight:600; color:#0369a1;">{{ $modelKetiga ?? 0 }}</span>
              <span style="font-size:13px; color:#94a3b8;">Jumlah total laporan</span>
            </div>
          </div>
        </a>
      </div>

      {{-- KADER POKJA 4 --}}
      <div class="col-md-6 col-lg-3 mb-3">
        <a href="{{ route('acclaporanpokja4.index') }}" style="text-decoration:none;">
          <div class="form-card pokja-card" style="background:white; border-radius:16px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,0.08); transition:all 0.3s; cursor:pointer;">
            <div class="d-flex align-items-center mb-3">
              <div style="background:#ede9fe; width:56px; height:56px; border-radius:14px; display:flex; align-items:center; justify-content:center; margin-right:16px; flex-shrink:0;">
                <i class="bi bi-person-badge-fill" style="font-size:26px; color:#7c3aed;"></i>
              </div>
              <h5 style="font-weight:600; font-size:14px; color:#1e293b; margin:0; line-height:1.4;">Jumlah Kader Pokja 4</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
              <span style="font-size:28px; font-weight:600; color:#0369a1;">{{ $modelKeempat ?? 0 }}</span>
              <span style="font-size:13px; color:#94a3b8;">Jumlah total laporan</span>
            </div>
          </div>
        </a>
      </div>

      {{-- INOVASI --}}
      <div class="col-md-6 col-lg-3 mb-3">
        <a href="{{ route('inovasi.index') }}" style="text-decoration:none;">
          <div class="form-card pokja-card" style="background:white; border-radius:16px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,0.08); transition:all 0.3s; cursor:pointer;">
            <div class="d-flex align-items-center mb-3">
              <div style="background:#ffedd5; width:56px; height:56px; border-radius:14px; display:flex; align-items:center; justify-content:center; margin-right:16px; flex-shrink:0;">
                <i class="bi bi-lightbulb-fill" style="font-size:26px; color:#ea580c;"></i>
              </div>
              <h5 style="font-weight:600; font-size:14px; color:#1e293b; margin:0; line-height:1.4;">Inovasi (Prioritas & Unggulan)</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
              <span style="font-size:28px; font-weight:600; color:#0369a1;"> {{($modelKelima ?? 0) + ($modelKeenam ?? 0) + ($modelKetujuh ?? 0) + ($modelKedelapan ?? 0)}}</span>
              <span style="font-size:13px; color:#94a3b8;">Jumlah total laporan</span>
            </div>
          </div>
        </a>
      </div>

    </div>

    {{-- CARD CETAK --}}
    <div class="row">
      <div class="col-12">
        <div class="form-card" style="background:white; border-radius:12px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
          <h5 style="font-weight:600; font-size:16px; color:#2d3748; margin-bottom:6px;">Laporan Pokja 4</h5>
          <p style="font-size:13px; color:#6b7280; margin-bottom:16px;">Cetak laporan berdasarkan bulan, tahun, bidang dan format file</p>
          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalLaporan">
            <i class="bi bi-file-earmark-arrow-down me-1"></i> Cetak Laporan
          </button>
        </div>
      </div>
    </div>
  </section>
</main>

{{-- MODAL CETAK LAPORAN POKJA 4 --}}
<div class="modal fade" id="modalLaporan" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 12px;">
      <div class="modal-header">
        <h5 class="modal-title" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Cetak Laporan Pokja 4</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="formExport">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label style="font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500;">Bulan <span class="text-muted" style="font-size: 11px;">(Opsional untuk tahunan)</span></label>
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
          <div class="mb-3">
            <label style="font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500;">Tahun <span class="text-danger">*</span></label>
            <select name="tahun" class="form-select" required>
              <option value="">-- Pilih Tahun --</option>
              @for ($year = now()->year; $year >= 2021; $year--)
                <option value="{{ $year }}">{{ $year }}</option>
              @endfor
            </select>
          </div>
          <div class="mb-3">
            <label style="font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500;">Bidang <span class="text-danger">*</span></label>
            <select name="bidang" class="form-select" required>
              <option value="">-- Pilih Bidang --</option>
              <option value="semua">Semua Bidang (Rekap Total)</option>
              <option value="kesehatan">Kesehatan</option>
              <option value="kelestarian">Kelestarian Lingkungan Hidup</option>
              <option value="perencanaan">Perencanaan Sehat</option>
              <option value="kader">Kader Pokja 4</option>
              {{-- TAMBAHAN MENU INOVASI --}}
              <option value="inovasi_prioritas">Inovasi Prioritas</option>
              <option value="inovasi_unggulan">Inovasi Unggulan</option>
            </select>
          </div>
          <div class="mb-3">
            <label style="font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500;">Format <span class="text-danger">*</span></label>
            <select name="format" id="formatExport" class="form-select" required>
              <option value="">-- Pilih Format --</option>
              <option value="pdf">📄 PDF (Download / Print)</option>
              <option value="excel">📊 Google Sheets (Online)</option>
            </select>
          </div>
          <div class="alert alert-primary mt-3" id="infoLinkSheet" style="display:none; border-left:4px solid #0d6efd; background-color: #f0f7ff;">
            <h6 class="alert-heading fw-bold mb-1" style="font-size:13px;"><i class="bi bi-link-45deg"></i> Link Spreadsheet Tujuan</h6>
            <p class="mb-2" style="font-size:12px; color:#475569;">Data akan diekspor ke dalam tab di Google Sheets berikut:</p>
            <a href="https://docs.google.com/spreadsheets/d/1sG9520UiJQIXg3u7YHXPPIpjU41w8fkyrw3fP37u-9c/edit?usp=sharing" target="_blank" class="btn btn-sm btn-light text-primary" style="font-size:12px; font-weight:600; border: 1px solid #cce3fd;">
              <i class="bi bi-box-arrow-up-right"></i> Buka Spreadsheet Laporan
            </a>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success" id="btnExport"><i class="bi bi-download"></i> <span id="btnText">Export</span></button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // URL GOOGLE APPS SCRIPT POKJA 4 YANG BARU
  const APPS_SCRIPT_URL = "https://script.google.com/macros/s/AKfycbzzZHCfXfsAKfF9rdeLGNRnEGmWe8u7Wxzfw4tePj-aXmjypjntzlRkp8-n4LgThYc/exec";
  const SHEET_HREF = "https://docs.google.com/spreadsheets/d/1sG9520UiJQIXg3u7YHXPPIpjU41w8fkyrw3fP37u-9c/edit?usp=sharing";

  document.getElementById("formatExport").addEventListener("change", function() {
    document.getElementById("infoLinkSheet").style.display = this.value === "excel" ? "block" : "none";
  });

  document.getElementById("formExport").addEventListener("submit", async function(e) {
    e.preventDefault();
    const format = document.getElementById("formatExport").value;
    const btn = document.getElementById("btnExport");
    const btnText = document.getElementById("btnText");
    const form = e.target;
    const formData = new FormData(form);
    
    const bulan = formData.get('bulan');
    const tahun = formData.get('tahun');
    const bidang = formData.get('bidang');

    if (!format) { Swal.fire({ icon: 'warning', title: 'Pilih Format!', text: 'Silakan pilih format export terlebih dahulu' }); return; }

    // ==========================================
    // PERBAIKAN LOGIKA CETAK PDF / PRINT (Buka di tab baru)
    // ==========================================
    if (format === "pdf") {
      let params = new URLSearchParams();
      params.append('bidang', bidang);
      params.append('tahun', tahun);

      if (bulan) {
          params.append('tipe_cetak', 'perbulan');
          params.append('bulan', bulan);
      } else {
          params.append('tipe_cetak', 'tahunan');
      }

      // Tutup modal agar rapi
      bootstrap.Modal.getInstance(document.getElementById('modalLaporan'))?.hide();
      
      // FIX: Arahkan langsung ke fungsi cetak di Pokja4Controller
      window.open("{{ route('pokja4.cetak') }}?" + params.toString(), "_blank");
      return;
    } 
    
    // --- GOOGLE SHEETS EXPORT ---
    else if (format === "excel") {
      if (bidang === 'semua') {
         Swal.fire('Perhatian!', 'Untuk export ke Google Sheets, silakan pilih bidang spesifik satu per satu.', 'warning');
         return;
      }

      const confirmExport = await Swal.fire({
        title: 'Mulai Ekspor?', html: `Data akan ditimpa/diperbarui ke dalam <b>Google Sheets Pokja 4</b>.<br><br>
                 <a href="${SHEET_HREF}" target="_blank" style="text-decoration: none; color: #0d6efd; font-weight: 600; background: #f8f9fa; padding: 5px 10px; border-radius: 5px;">
                   <i class="bi bi-box-arrow-up-right"></i> Pratinjau Spreadsheet
                 </a>`,
        icon: 'question', showCancelButton: true,
        confirmButtonColor: '#198754', cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-send"></i> Ya, Ekspor!', cancelButtonText: 'Batal', reverseButtons: true
      });
      if (!confirmExport.isConfirmed) return;

      btn.disabled = true;
      btnText.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';
      Swal.fire({ title: 'Mengekspor data...', text: 'Sedang mengambil data dari Database...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });

      try {
        // Fetch JSON dari Laravel Controller
        const urlTarget = `{{ route('pokja4.exportJson') }}?bulan=${bulan}&tahun=${tahun}&bidang=${bidang}`;
        const dbResponse = await fetch(urlTarget);
        
        if (!dbResponse.ok) {
            const textError = await dbResponse.text();
            let realErrorMsg = `Status HTTP: ${dbResponse.status}`;
            try {
                const jsonError = JSON.parse(textError);
                if(jsonError.message) realErrorMsg = jsonError.message;
            } catch(e) {
                realErrorMsg = `Gagal memproses data di server lokal (Pastikan route pokja4.exportJson sudah ada).`;
            }
            throw new Error(realErrorMsg);
        }
        
        const dbResult = await dbResponse.json();
        
        if (dbResult.status === 'empty' || !dbResult.data || dbResult.data.length === 0) {
          Swal.fire('Data Kosong', dbResult.message || 'Tidak ada laporan yang Disetujui pada periode tersebut.', 'info');
          btn.disabled = false; btnText.textContent = 'Export'; return;
        }

        Swal.update({ text: `Ditemukan ${dbResult.data.length} baris data. Mengirim ke Google Sheets...` });

        // Tembak data ke Google Apps Script
        const googleResponse = await fetch(APPS_SCRIPT_URL, {
          method: 'POST', redirect: 'follow',
          headers: { 'Content-Type': 'text/plain;charset=utf-8' },
          body: JSON.stringify(dbResult)
        });
        
        const textResult = await googleResponse.text();
        
        try {
            const result = JSON.parse(textResult);
            if (result.status === "success") {
              Swal.fire({ icon: 'success', title: 'Berhasil!', html: `✅ ${result.message}<br><br>
                                   <a href="${SHEET_HREF}" target="_blank" class="btn btn-sm btn-outline-primary">
                                      Buka Laporan Pokja 4
                                   </a>`, confirmButtonText: 'Tutup' })
                .then(() => { form.reset(); document.getElementById("infoLinkSheet").style.display = "none"; bootstrap.Modal.getInstance(document.getElementById('modalLaporan'))?.hide(); });
            } else { throw new Error(result.message); }
        } catch(e) {
            let debugHTML = textResult.substring(0, 150).replace(/</g, "&lt;").replace(/>/g, "&gt;");
            throw new Error(`Gagal memproses response Google Apps Script. Pastikan Deploy as Web App di-set ke 'Anyone'.<br><br><small style="color:red;">${debugHTML}...</small>`);
        }

      } catch (error) {
        Swal.fire({ icon: 'error', title: 'Gagal Mengirim!', html: `Terjadi kesalahan jaringan atau server:<br><br><code>${error.message}</code>` });
      } finally {
        btn.disabled = false; btnText.textContent = 'Export';
      }
    }
  });
</script>

@endsection