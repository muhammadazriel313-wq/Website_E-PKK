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
            <label style="font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500;">Bulan <span class="text-muted" style="font-size: 11px;">(Opsional)</span></label>
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
            <select name="bidang" id="bidangSelect" class="form-select" required>
              <option value="">-- Pilih Bidang --</option>
              <option value="semua">Semua Bidang (Rekap Total)</option>
              <option value="kesehatan">Kesehatan</option>
              <option value="kelestarian">Kelestarian Lingkungan Hidup</option>
              <option value="perencanaan">Perencanaan Sehat</option>
              <option value="kader">Kader Pokja 4</option>
              <option value="inovasi_prioritas">Inovasi Prioritas</option>
              <option value="inovasi_unggulan">Inovasi Unggulan</option>
            </select>
          </div>

          {{-- 🚨 INI DIA SAKLAR SUB-BIDANG INOVASI BARU 🚨 --}}
          <div class="mb-3" id="wrapSubBidang" style="display: none; background: #f8fafc; padding: 10px; border-radius: 8px; border-left: 4px solid #0ea5e9;">
            <label style="font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 500; color: #0284c7;">Pilih Sub Inovasi <span class="text-danger">*</span></label>
            <select name="sub_bidang" id="subBidangSelect" class="form-select border-primary">
              <option value="semua">-- Semua Sub Inovasi (Hanya PDF) --</option>
              <option value="rekap_bulanan">Rekap Desa Bulanan</option>
              <option value="rekap_tahunan">Rekap Desa Tahunan</option>
              <option value="posyandu">Rekap Posyandu</option>
              <option value="kegiatan_pokja4">Kegiatan Pokja 4</option>
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
            {{-- [PERUBAHAN 2026-10-09] Mengambil URL Spreadsheet dari config services; URL hardcode dinonaktifkan --}}
            {{-- <a href="https://docs.google.com/spreadsheets/d/1sG9520UiJQIXg3u7YHXPPIpjU41w8fkyrw3fP37u-9c/edit?usp=sharing" target="_blank" class="btn btn-sm btn-light text-primary" style="font-size:12px; font-weight:600; border: 1px solid #cce3fd;"> --}}
            <a id="linkSheetPokja4" href="{{ config('services.sheets.spreadsheet_url') ?: '#' }}" target="_blank" class="btn btn-sm btn-light text-primary" style="font-size:12px; font-weight:600; border: 1px solid #cce3fd;">
              <i class="bi bi-box-arrow-up-right"></i> Buka Spreadsheet
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
  // [PERUBAHAN 2026-10-09] Mengambil URL Apps Script dan Spreadsheet dari config services; URL hardcode dinonaktifkan
  // const APPS_SCRIPT_URL = "https://script.google.com/macros/s/AKfycbzzZHCfXfsAKfF9rdeLGNRnEGmWe8u7Wxzfw4tePj-aXmjypjntzlRkp8-n4LgThYc/exec";
  const APPS_SCRIPT_URL = "{{ config('services.sheets.script_url') }}";
  // const SHEET_HREF = "https://docs.google.com/spreadsheets/d/1sG9520UiJQIXg3u7YHXPPIpjU41w8fkyrw3fP37u-9c/edit?usp=sharing";
  const SHEET_HREF = "{{ config('services.sheets.spreadsheet_url') }}";

  // [PERUBAHAN 2026-10-09] Fungsi navigasi langsung ke tab Google Sheets Pokja 4
  function updateLinkPokja4() {
    const b = document.getElementById("bidangSelect")?.value || '';
    const sub = document.getElementById("subBidangSelect")?.value || '';
    const subKey = sub && sub !== 'semua' ? '_' + sub : '';
    const saved = localStorage.getItem('sheet_tab_pokja4_' + b + subKey) || localStorage.getItem('sheet_tab_pokja4_' + b) || localStorage.getItem('sheet_tab_pokja4') || SHEET_HREF;
    const el = document.getElementById("linkSheetPokja4");
    if (el && saved) el.href = saved;
  }

  // Saklar memunculkan Sub Bidang Inovasi
  document.getElementById("bidangSelect").addEventListener("change", function() {
    const wrapSub = document.getElementById("wrapSubBidang");
    if (this.value === "inovasi_prioritas" || this.value === "inovasi_unggulan") {
        wrapSub.style.display = "block";
    } else {
        wrapSub.style.display = "none";
        document.getElementById("subBidangSelect").value = "semua";
    }
    updateLinkPokja4();
  });

  document.getElementById("subBidangSelect")?.addEventListener("change", updateLinkPokja4);

  document.getElementById("formatExport").addEventListener("change", function() {
    const isExcel = this.value === "excel";
    document.getElementById("infoLinkSheet").style.display = isExcel ? "block" : "none";
    if (isExcel) updateLinkPokja4();
  });
  updateLinkPokja4();

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
    const sub_bidang = formData.get('sub_bidang') || 'semua';

    if (!format) { Swal.fire('Pilih Format!', 'Silakan pilih format export terlebih dahulu', 'warning'); return; }

    // EXPORT PDF
    if (format === "pdf") {
      let params = new URLSearchParams();
      params.append('bidang', bidang);
      params.append('sub_bidang', sub_bidang);
      params.append('tahun', tahun);

      if (bulan) {
          params.append('tipe_cetak', 'perbulan');
          params.append('bulan', bulan);
      } else {
          params.append('tipe_cetak', 'tahunan');
      }

      bootstrap.Modal.getInstance(document.getElementById('modalLaporan'))?.hide();
      window.open("{{ route('pokja4.cetak') }}?" + params.toString(), "_blank");
      return;
    } 
    
    // EXPORT GOOGLE SHEETS
    if (format === "excel") {
      // [PERUBAHAN 2026-10-09] Validasi URL Apps Script dari .env
      if (!APPS_SCRIPT_URL || APPS_SCRIPT_URL.trim() === '') {
        Swal.fire({
          icon: 'warning',
          title: 'URL Belum Diatur!',
          text: 'URL Google Sheets belum diatur di .env'
        });
        return;
      }

      if (bidang === 'semua') {
         Swal.fire('Perhatian!', 'Untuk export Excel, pilih bidang spesifik.', 'warning'); return;
      }
      if ((bidang === 'inovasi_prioritas' || bidang === 'inovasi_unggulan') && sub_bidang === 'semua') {
         Swal.fire('Perhatian!', 'Google Sheets membutuhkan format tabel yang rapi. Silakan pilih Sub Inovasi secara spesifik (Misal: Rekap Posyandu).', 'warning'); return;
      }

      const confirmExport = await Swal.fire({
        title: 'Mulai Ekspor?', html: `Data akan dikirim ke <b>Google Sheets</b>.<br><br><a href="${SHEET_HREF}" target="_blank" style="text-decoration:none; color:#0d6efd; font-weight:600;">Pratinjau Spreadsheet</a>`,
        icon: 'question', showCancelButton: true, confirmButtonText: 'Ya, Ekspor!', reverseButtons: true
      });
      if (!confirmExport.isConfirmed) return;

      btn.disabled = true; btnText.innerHTML = 'Memproses...';
      Swal.fire({ title: 'Mengekspor...', text: 'Mengambil data...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });

      try {
        const urlTarget = `{{ route('pokja4.exportJson') }}?bulan=${bulan}&tahun=${tahun}&bidang=${bidang}&sub_bidang=${sub_bidang}`;
        const dbResponse = await fetch(urlTarget);
        if (!dbResponse.ok) throw new Error(`Gagal memproses data server.`);
        
        const dbResult = await dbResponse.json();
        if (dbResult.status === 'empty' || !dbResult.data || dbResult.data.length === 0) {
          Swal.fire('Data Kosong', 'Tidak ada laporan valid pada periode tersebut.', 'info');
          btn.disabled = false; btnText.textContent = 'Export'; return;
        }

        // [PERUBAHAN 2026-10-09] Lengkapi metadata identitas pokja dan periode
        dbResult.pokja = 'POKJA 4';
        dbResult.bulan = bulan;
        dbResult.tahun = tahun;
        dbResult.sub_bidang = sub_bidang;

        Swal.update({ text: `Mengirim ${dbResult.data.length} data ke Google Sheets...` });
        const googleResponse = await fetch(APPS_SCRIPT_URL, {
          method: 'POST', redirect: 'follow', headers: { 'Content-Type': 'text/plain;charset=utf-8' },
          body: JSON.stringify(dbResult)
        });
        
        const textResult = await googleResponse.text();
        try {
          const result = JSON.parse(textResult);
          if (result.status === "success") {
            const directTabUrl = result.tab_url || SHEET_HREF;
            if (result.tab_url) {
              try {
                const subKey = sub_bidang && sub_bidang !== 'semua' ? '_' + sub_bidang : '';
                localStorage.setItem('sheet_tab_pokja4_' + bidang + subKey, result.tab_url);
                localStorage.setItem('sheet_tab_pokja4_' + bidang, result.tab_url);
                localStorage.setItem('sheet_tab_pokja4', result.tab_url);
                const el = document.getElementById("linkSheetPokja4");
                if (el) el.href = result.tab_url;
              } catch(e) {}
            }
            Swal.fire({
              icon: 'success',
              title: 'Berhasil!',
              html: `✅ ${result.message}<br><br><a href="${directTabUrl}" target="_blank" class="btn btn-sm btn-primary text-white" style="font-weight:600;"><i class="bi bi-box-arrow-up-right"></i> Buka Langsung Tab Laporan</a>`,
              confirmButtonText: 'Tutup'
            }).then(() => {
              form.reset();
              document.getElementById("infoLinkSheet").style.display = "none";
              bootstrap.Modal.getInstance(document.getElementById('modalLaporan'))?.hide();
            });
          } else { throw new Error(result.message); }
        } catch(e) {
          let debugHTML = textResult.substring(0, 150).replace(/</g, "&lt;").replace(/>/g, "&gt;");
          throw new Error(`Google Apps Script Error. Pastikan Deploy as Web App di-set ke 'Anyone'.<br><br><small style="color:red;">${debugHTML}...</small>`);
        }

      } catch (error) {
        Swal.fire({ icon: 'error', title: 'Gagal Mengirim!', html: `<div style="text-align:left;">Terjadi kesalahan:<br><br><code style="color:#d63384;">${error.message}</code></div>` });
      } finally {
        btn.disabled = false; btnText.textContent = 'Export';
      }
    }
  });
</script>

@endsection