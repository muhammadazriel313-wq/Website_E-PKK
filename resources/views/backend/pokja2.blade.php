@extends('backend.layouts.template')

@section('content1')

<style>
  * { font-family: 'Poppins', sans-serif !important; }
  .page-heading { font-family: 'Poppins', sans-serif; font-size: 24px; font-weight: 600; color: #1e293b; margin-bottom: 20px; }
  .pokja-card:hover { transform: translateY(-4px); box-shadow: 0 8px 16px rgba(0,0,0,0.12) !important; }
</style>

<main id="main" class="main">
  <section class="section">
    <h1 class="page-heading">Laporan Pokja 2</h1>

    @if (session('error'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Perhatian!</strong> {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- CARDS LAPORAN --}}
    <div class="row mb-4">
      {{-- PENDIDIKAN --}}
      <div class="col-md-6 mb-3">
        <a href="{{ route('accpendidikan.index') }}" style="text-decoration:none;">
          <div class="form-card pokja-card" style="background:white; border-radius:16px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,0.08); transition:all 0.3s; cursor:pointer;">
            <div class="d-flex align-items-center mb-3">
              <div style="background:#ede9fe; width:56px; height:56px; border-radius:14px; display:flex; align-items:center; justify-content:center; margin-right:16px; flex-shrink:0;">
                <i class="bi bi-mortarboard-fill" style="font-size:26px; color:#7c3aed;"></i>
              </div>
              <h5 style="font-weight:600; font-size:14px; color:#1e293b; margin:0; line-height:1.4;">Pendidikan Dan Ketrampilan</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
              <span style="font-size:28px; font-weight:600; color:#0369a1;">{{ $modelPertama ?? 0 }}</span>
              <span style="font-size:13px; color:#94a3b8;">Jumlah total laporan</span>
            </div>
          </div>
        </a>
      </div>

      {{-- PENGEMBANGAN --}}
      <div class="col-md-6 mb-3">
        <a href="{{ route('accpengembangan.index') }}" style="text-decoration:none;">
          <div class="form-card pokja-card" style="background:white; border-radius:16px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,0.08); transition:all 0.3s; cursor:pointer;">
            <div class="d-flex align-items-center mb-3">
              <div style="background:#fef9c3; width:56px; height:56px; border-radius:14px; display:flex; align-items:center; justify-content:center; margin-right:16px; flex-shrink:0;">
                <i class="bi bi-graph-up-arrow" style="font-size:26px; color:#ca8a04;"></i>
              </div>
              <h5 style="font-weight:600; font-size:14px; color:#1e293b; margin:0; line-height:1.4;">Pengembangan Kehidupan Berkoperasi</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
              <span style="font-size:28px; font-weight:600; color:#0369a1;">{{ $modelKedua ?? 0 }}</span>
              <span style="font-size:13px; color:#94a3b8;">Jumlah total laporan</span>
            </div>
          </div>
        </a>
      </div>
    </div>

    {{-- CARD CETAK (UNIFIED) --}}
    <div class="row">
      <div class="col-12">
        <div class="form-card" style="background:white; border-radius:12px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
          <h5 style="font-weight:600; font-size:16px; color:#2d3748; margin-bottom:6px;">Laporan Pokja 2</h5>
          <p style="font-size:13px; color:#6b7280; margin-bottom:16px;">Cetak laporan berdasarkan bulan, tahun, bidang dan format file</p>
          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalLaporanPokja2" style="padding: 8px 20px; border-radius: 8px;">
            <i class="bi bi-file-earmark-arrow-down me-1"></i> Cetak Laporan
          </button>
        </div>
      </div>
    </div>

  </section>
</main>

{{-- MODAL CETAK LAPORAN POKJA 2 --}}
<div class="modal fade" id="modalLaporanPokja2" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 12px;">
      <div class="modal-header">
        <h5 class="modal-title" style="font-weight: 600;">Cetak Laporan Pokja 2</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="formExportPokja2">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label style="font-size: 13px; font-weight: 500;">Bulan <span class="text-muted" style="font-size: 11px;">(Opsional untuk tahunan)</span></label>
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
            <label style="font-size: 13px; font-weight: 500;">Tahun <span class="text-danger">*</span></label>
            <select name="tahun" class="form-select" required>
              <option value="">-- Pilih Tahun --</option>
              @for ($year = now()->year; $year >= 2021; $year--)
                <option value="{{ $year }}">{{ $year }}</option>
              @endfor
            </select>
          </div>
          <div class="mb-3">
            <label style="font-size: 13px; font-weight: 500;">Bidang <span class="text-danger">*</span></label>
            <select name="bidang" class="form-select" required>
              <option value="">-- Pilih Bidang --</option>
              <option value="semua">Semua Bidang (Rekap Total)</option>
              <option value="pendidikan">Pendidikan Dan Ketrampilan</option>
              <option value="pengembangan">Pengembangan Kehidupan Berkoperasi</option>
            </select>
          </div>
          <div class="mb-3">
            <label style="font-size: 13px; font-weight: 500;">Format <span class="text-danger">*</span></label>
            <select name="format" id="formatExportPokja2" class="form-select" required>
              <option value="">-- Pilih Format --</option>
              <option value="pdf">📄 PDF (Download / Print)</option>
              <option value="excel">📊 Google Sheets (Online)</option>
            </select>
          </div>
          <div class="alert alert-primary mt-3" id="infoLinkSheet" style="display:none; border-left:4px solid #0d6efd; background-color: #f0f7ff;">
            <h6 class="alert-heading fw-bold mb-1" style="font-size:13px;"><i class="bi bi-link-45deg"></i> Link Spreadsheet Tujuan</h6>
            <p class="mb-2" style="font-size:12px; color:#475569;">Data akan diekspor ke dalam tab di Google Sheets berikut:</p>
            <a href="https://docs.google.com/spreadsheets/d/1icxYCki722NJEAdQEKUCqFbrQaLQGahoYUazoHW4PAU/edit?usp=sharing" target="_blank" class="btn btn-sm btn-light text-primary" style="font-size:12px; font-weight:600; border: 1px solid #cce3fd;">
              <i class="bi bi-box-arrow-up-right"></i> Buka Spreadsheet Pokja 2
            </a>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success" id="btnExportPokja2"><i class="bi bi-download"></i> <span id="btnTextPokja2">Export</span></button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // 🔴 GANTI URL INI DENGAN URL DEPLOY SCRIPT POKJA 2 KAMU 🔴
  const APPS_SCRIPT_URL_POKJA2 = "https://script.google.com/macros/s/AKfycby79VqaZVq-vQVI5ItFvJK6nS_qj3mzzCLcVx4YyOD8wgFWgzGFBZaGZi0-sjhFIzuFrw/exec"; 
  const SHEET_HREF = "https://docs.google.com/spreadsheets/d/1icxYCki722NJEAdQEKUCqFbrQaLQGahoYUazoHW4PAU/edit?usp=sharing";

  document.getElementById("formatExportPokja2").addEventListener("change", function() {
    document.getElementById("infoLinkSheet").style.display = this.value === "excel" ? "block" : "none";
  });

  document.getElementById("formExportPokja2").addEventListener("submit", async function(e) {
    e.preventDefault();
    const format = document.getElementById("formatExportPokja2").value;
    const btn = document.getElementById("btnExportPokja2");
    const btnText = document.getElementById("btnTextPokja2");
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

      // Cek apakah cetak perbulan atau pertahun
      if (bulan) {
          params.append('tipe_cetak', 'perbulan');
          params.append('bulan', bulan);
      } else {
          params.append('tipe_cetak', 'tahunan');
      }

      // Tutup modal agar rapi
      bootstrap.Modal.getInstance(document.getElementById('modalLaporanPokja2'))?.hide();
      
      // FIX: Arahkan langsung ke fungsi cetak di Pokja2Controller
      window.open("{{ route('pokja2.cetak') }}?" + params.toString(), "_blank");
    } 
    // ==========================================
    // LOGIKA EXPORT EXCEL (GOOGLE SHEETS)
    // ==========================================
    else if (format === "excel") {
      // (Biar gak eror milih 'semua' pas ekspor ke Google Sheets)
      if (bidang === 'semua') {
         Swal.fire('Perhatian!', 'Untuk export ke Google Sheets, silakan pilih bidang spesifik satu per satu.', 'warning');
         return;
      }

      if(APPS_SCRIPT_URL_POKJA2 === "TARUH_LINK_APPS_SCRIPT_DISINI") {
          Swal.fire('URL Belum Diatur!', 'Komandan, kamu belum menaruh URL Google Script di file Blade.', 'error');
          return;
      }

      const confirmExport = await Swal.fire({
        title: 'Mulai Ekspor?',
        html: `Data akan ditimpa/diperbarui ke dalam <b>Google Sheets Pokja 2</b>.<br><br>
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
        const urlTarget = `{{ route('pokja2.exportJson') }}?bulan=${bulan}&tahun=${tahun}&bidang=${bidang}`;
        const dbResponse = await fetch(urlTarget);
        
        if (!dbResponse.ok) {
            const textError = await dbResponse.text();
            let realErrorMsg = `Status HTTP: ${dbResponse.status}`;
            try {
                const jsonError = JSON.parse(textError);
                if(jsonError.message) realErrorMsg = jsonError.message;
            } catch(e) {
                realErrorMsg = `Laravel Error 500. Pastikan nama tabel Pokja 2 di database sudah benar.`;
            }
            throw new Error(realErrorMsg);
        }
        
        const dbResult = await dbResponse.json();
        
        if (!dbResult.data || dbResult.data.length === 0) {
          Swal.fire('Data Kosong', 'Tidak ada laporan yang Disetujui pada periode tersebut.', 'info');
          btn.disabled = false; btnText.textContent = 'Export'; return;
        }

        Swal.update({ text: `Ditemukan ${dbResult.data.length} baris data. Mengirim ke Google Sheets...` });

        const googleResponse = await fetch(APPS_SCRIPT_URL_POKJA2, {
          method: 'POST', redirect: 'follow',
          headers: { 'Content-Type': 'text/plain;charset=utf-8' },
          body: JSON.stringify(dbResult)
        });
        
        const textResult = await googleResponse.text();
        
        try {
            const result = JSON.parse(textResult);
            if (result.status === "success") {
              Swal.fire({ icon: 'success', title: 'Berhasil!', html: `✅ ${result.message}<br><br><a href="${SHEET_HREF}" target="_blank" class="btn btn-sm btn-outline-primary">Buka Laporan Pokja 2</a>`, confirmButtonText: 'Tutup' })
                .then(() => { form.reset(); document.getElementById("infoLinkSheet").style.display = "none"; bootstrap.Modal.getInstance(document.getElementById('modalLaporanPokja2'))?.hide(); });
            } else { throw new Error(result.message); }
        } catch(e) {
            let debugHTML = textResult.substring(0, 150).replace(/</g, "&lt;").replace(/>/g, "&gt;");
            throw new Error(`Google Apps Script Error. Pastikan Deploy as Web App di-set ke 'Anyone'.<br><br><small style="color:red;">${debugHTML}...</small>`);
        }

      } catch (error) {
        Swal.fire({ icon: 'error', title: 'Gagal Mengirim!', html: `<div style="text-align:left;">Detail:<br><br><code style="color:#d63384;">${error.message}</code></div>` });
      } finally {
        btn.disabled = false; btnText.textContent = 'Export';
      }
    }
  });
</script>
@endsection