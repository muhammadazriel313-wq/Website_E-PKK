@extends('backend.layouts.template')

@section('content1')

<style>
  * { font-family: 'Poppins', sans-serif !important; }
  .page-heading { font-size: 24px; font-weight: 600; color: #1e293b; margin-bottom: 20px; }
  .pokja-card:hover { transform: translateY(-4px); box-shadow: 0 8px 16px rgba(0,0,0,0.12) !important; }
</style>

<main id="main" class="main">
  <section class="section">
    <h1 class="page-heading">Laporan Pokja 1</h1>

    @if (session('error'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Perhatian!</strong> {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- CARDS LAPORAN --}}
    <div class="row mb-3">
      {{-- PENGHAYATAN DAN PENGAMALAN PANCASILA --}}
      <div class="col-md-4 mb-3">
        <a href="{{ route('accpenghayatan.index') }}" style="text-decoration:none;">
          <div class="form-card pokja-card" style="background:white; border-radius:16px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,0.08); transition:all 0.3s; cursor:pointer;">
            <div class="d-flex align-items-center mb-3">
              <div style="background:#e0f2fe; width:56px; height:56px; border-radius:14px; display:flex; align-items:center; justify-content:center; margin-right:16px; flex-shrink:0;">
                <i class="bi bi-shield-fill-check" style="font-size:26px; color:#0284c7;"></i>
              </div>
              <h5 style="font-weight:600; font-size:14px; color:#1e293b; margin:0; line-height:1.4;">Penghayatan Dan Pengamalan Pancasila</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
              <span style="font-size:28px; font-weight:600; color:#0369a1;">{{ $modelPertama ?? 0 }}</span>
              <span style="font-size:13px; color:#94a3b8;">Jumlah total laporan</span>
            </div>
          </div>
        </a>
      </div>

      {{-- GOTONG ROYONG --}}
      <div class="col-md-4 mb-3">
        <a href="{{ route('accgotongroyong.index') }}" style="text-decoration:none;">
          <div class="form-card pokja-card" style="background:white; border-radius:16px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,0.08); transition:all 0.3s; cursor:pointer;">
            <div class="d-flex align-items-center mb-3">
              <div style="background:#dcfce7; width:56px; height:56px; border-radius:14px; display:flex; align-items:center; justify-content:center; margin-right:16px; flex-shrink:0;">
                <i class="bi bi-people-fill" style="font-size:26px; color:#16a34a;"></i>
              </div>
              <h5 style="font-weight:600; font-size:14px; color:#1e293b; margin:0; line-height:1.4;">Gotong Royong</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
              <span style="font-size:28px; font-weight:600; color:#15803d;">{{ $modelKedua ?? 0 }}</span>
              <span style="font-size:13px; color:#94a3b8;">Jumlah total laporan</span>
            </div>
          </div>
        </a>
      </div>

      {{-- KADER POKJA 1 --}}
      <div class="col-md-4 mb-3">
        <a href="{{ route('acclaporanpokja1.index') }}" style="text-decoration:none;">
          <div class="form-card pokja-card" style="background:white; border-radius:16px; padding:24px; box-shadow:0 1px 4px rgba(0,0,0,0.08); transition:all 0.3s; cursor:pointer;">
            <div class="d-flex align-items-center mb-3">
              <div style="background:#ede9fe; width:56px; height:56px; border-radius:14px; display:flex; align-items:center; justify-content:center; margin-right:16px; flex-shrink:0;">
                <i class="bi bi-person-badge-fill" style="font-size:26px; color:#7c3aed;"></i>
              </div>
              <h5 style="font-weight:600; font-size:14px; color:#1e293b; margin:0; line-height:1.4;">Kader Pokja 1</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
              <span style="font-size:28px; font-weight:600; color:#7c3aed;">{{ $modelKetiga ?? 0 }}</span>
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
          <h5 style="font-weight:600; font-size:16px; color:#2d3748; margin-bottom:6px;">Laporan Pokja 1</h5>
          <p style="font-size:13px; color:#6b7280; margin-bottom:16px;">Cetak laporan berdasarkan bulan, tahun, bidang dan format file</p>
          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalLaporanPokja1">
            <i class="bi bi-file-earmark-arrow-down me-1"></i> Cetak Laporan
          </button>
        </div>
      </div>
    </div>
  </section>
</main>

{{-- MODAL CETAK LAPORAN POKJA 1 --}}
<div class="modal fade" id="modalLaporanPokja1" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 12px;">
      <div class="modal-header">
        <h5 class="modal-title" style="font-weight: 600;">Cetak Laporan Pokja 1</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="formExportPokja1">
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
              <option value="penghayatan">Penghayatan & Pengamalan Pancasila</option>
              <option value="gotongroyong">Gotong Royong</option>
              <option value="kader">Kader Pokja 1</option>
            </select>
          </div>
          <div class="mb-3">
            <label style="font-size: 13px; font-weight: 500;">Format <span class="text-danger">*</span></label>
            <select name="format" id="formatExportPokja1" class="form-select" required>
              <option value="">-- Pilih Format --</option>
              <option value="pdf">📄 PDF (Download / Print)</option>
              @if ((Auth::guard('web')->check() && !empty($spreadsheetUrl)) || (Auth::guard('pengguna')->check() && (int) Auth::guard('pengguna')->user()->id_role === 2))
                <option value="excel">📊 Google Sheets (Online)</option>
              @endif
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success" id="btnExportPokja1"><i class="bi bi-download"></i> <span id="btnTextPokja1">Export</span></button>
        </div>
      </form>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  const isDistrictUser = @json(Auth::guard('pengguna')->check() && (int) (Auth::guard('pengguna')->user()->id_role ?? 0) === 2);

  document.getElementById("formExportPokja1").addEventListener("submit", async function(e) {
    e.preventDefault();
    const format = document.getElementById("formatExportPokja1").value;
    const btn = document.getElementById("btnExportPokja1");
    const btnText = document.getElementById("btnTextPokja1");
    const form = e.target;
    const formData = new FormData(form);
    const bulan = formData.get('bulan');
    const tahun = formData.get('tahun');
    const bidang = formData.get('bidang');

    if (!format) {
      Swal.fire({ icon: 'warning', title: 'Pilih Format!', text: 'Silakan pilih format export terlebih dahulu' });
      return;
    }

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
      bootstrap.Modal.getInstance(document.getElementById('modalLaporanPokja1'))?.hide();
      window.open("{{ route('pokja1.cetak') }}?" + params.toString(), "_blank");
      return;
    }

    if (format !== "excel") return;

    const confirmExport = await Swal.fire({
      title: 'Perbarui Spreadsheet?',
      text: isDistrictUser
        ? 'Isi tab untuk bidang dan periode ini akan ditimpa dengan data terbaru laporan desa (Disetujui1 dan Disetujui2) dan laporan kecamatan Anda (Proses dan Disetujui2).'
        : 'Isi tab untuk bidang dan periode ini akan ditimpa dengan data terbaru yang Disetujui2.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#198754',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, Perbarui',
      cancelButtonText: 'Batal'
    });
    if (!confirmExport.isConfirmed) return;

    btn.disabled = true;
    btnText.textContent = 'Sedang memperbarui spreadsheet... mohon tunggu';
    Swal.fire({
      title: 'Sedang memperbarui spreadsheet... mohon tunggu',
      allowOutsideClick: false,
      didOpen: () => Swal.showLoading()
    });

    try {
      const exportUrl = isDistrictUser
        ? "{{ route('pokja1.sheets.district.export') }}"
        : "{{ route('pokja1.sheets.export') }}";
      const response = await fetch(exportUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': formData.get('_token')
        },
        body: JSON.stringify({ bulan: bulan || null, tahun: tahun, bidang: bidang })
      });
      const result = await response.json().catch(() => null);
      if (!result) {
        throw new Error('Server tidak mengembalikan hasil ekspor yang dapat dibaca. Coba lagi.');
      }
      if (!response.ok || result.status !== 'success') {
        throw new Error(result.message || 'Ekspor gagal. Coba lagi atau hubungi pengelola aplikasi.');
      }

      const results = result.results || [];
      const resultLines = results.map(function (item) {
        return `${item.tab}: ${item.count} laporan`;
      });
      const labelNotes = results.filter(function (item) { return item.label !== 'written'; })
        .map(function (item) { return `Label A1 dilewati (${item.tab}: ${item.label})`; });
      const resultContent = document.createElement('div');
      if (result.diekspor_sebagai) {
        const roleLine = document.createElement('div');
        roleLine.className = 'text-muted mb-2';
        roleLine.style.fontSize = '12px';
        roleLine.textContent = 'Diekspor sebagai: ' + result.diekspor_sebagai;
        resultContent.appendChild(roleLine);
      }
      const summary = document.createElement('p');
      summary.textContent = resultLines.concat(labelNotes).join(' | ');
      resultContent.appendChild(summary);

      const linkBox = document.createElement('div');
      linkBox.className = 'alert alert-primary mt-3';
      linkBox.style.cssText = 'text-align:left; border-left:4px solid #0d6efd; background-color:#f0f7ff;';

      const linkHeading = document.createElement('h6');
      linkHeading.className = 'alert-heading fw-bold mb-1';
      linkHeading.style.fontSize = '13px';
      const linkIcon = document.createElement('i');
      linkIcon.className = 'bi bi-link-45deg';
      linkHeading.appendChild(linkIcon);
      linkHeading.appendChild(document.createTextNode(' Link Spreadsheet Tujuan'));
      linkBox.appendChild(linkHeading);

      const linkDescription = document.createElement('p');
      linkDescription.className = 'mb-2';
      linkDescription.style.cssText = 'font-size:12px; color:#475569;';
      linkDescription.textContent = 'Data sudah diperbarui pada Google Sheets berikut:';
      linkBox.appendChild(linkDescription);

      (result.links || []).forEach(function (link) {
        const anchor = document.createElement('a');
        anchor.href = link.url;
        anchor.target = '_blank';
        anchor.rel = 'noopener noreferrer';
        anchor.className = 'btn btn-sm btn-light text-primary';
        anchor.style.cssText = 'font-size:12px; font-weight:600; border:1px solid #cce3fd;';
        if (bidang === 'semua') {
          anchor.classList.add('m-1');
          anchor.textContent = 'Buka tab ' + link.tab;
        } else {
          const buttonIcon = document.createElement('i');
          buttonIcon.className = 'bi bi-box-arrow-up-right';
          anchor.appendChild(buttonIcon);
          anchor.appendChild(document.createTextNode(' Buka Spreadsheet Pokja 1'));
        }
        linkBox.appendChild(anchor);
      });
      resultContent.appendChild(linkBox);

      Swal.fire({
        icon: 'success',
        title: result.message || 'Spreadsheet berhasil diperbarui.',
        html: resultContent,
        showCancelButton: false,
        confirmButtonText: 'Tutup'
      });
    } catch (error) {
      Swal.fire({
        icon: 'error',
        title: 'Ekspor tidak berhasil',
        text: error.message || 'Spreadsheet tidak dapat diperbarui. Coba lagi atau hubungi pengelola aplikasi.'
      });
    } finally {
      btn.disabled = false;
      btnText.textContent = 'Export';
    }
  });
</script>

@endsection