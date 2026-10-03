@extends('backend.layouts.template')

@section('content1')

<style>
  * { font-family: 'Poppins', sans-serif !important; }

  .page-heading {
    font-family: 'Poppins', sans-serif;
    font-size: 24px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 20px;
  }

  .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    border-radius: 10px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
    background: white;
  }

  .table-responsive table {
    min-width: 900px;
    white-space: nowrap;
    margin-bottom: 0;
    font-family: 'Poppins', sans-serif;
  }

  .table-responsive thead th {
    position: sticky;
    top: 0;
    background: #f8fafc;
    color: #334155;
    z-index: 2;
    font-size: 11px;
    font-weight: 600;
    padding: 12px 8px;
    vertical-align: middle;
    border: 1px solid #e2e8f0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-family: 'Poppins', sans-serif;
  }

  .table-responsive tbody td,
  .table-responsive tbody th {
    font-size: 12px;
    padding: 10px 8px;
    vertical-align: middle;
    background-color: white;
    color: #475569;
    font-family: 'Poppins', sans-serif;
  }

  .table-responsive tbody tr:hover td,
  .table-responsive tbody tr:hover th {
    background-color: #f1f5f9;
  }

  .table-bordered th,
  .table-bordered td {
    border: 1px solid #e2e8f0;
  }

  .table-responsive::-webkit-scrollbar { height: 8px; }
  .table-responsive::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
  .table-responsive::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
  .table-responsive::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

  .badge {
    font-family: 'Poppins', sans-serif;
    font-size: 11px;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 6px;
  }

  .btn {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    border-radius: 6px;
    transition: all 0.3s ease;
  }

  .btn-info { background-color: #0369a1; border-color: #0369a1; }
  .btn-info:hover { background-color: #075985; border-color: #075985; }
  .btn-danger { background-color: #ef4444; border-color: #ef4444; }
  .btn-danger:hover { background-color: #dc2626; border-color: #dc2626; }

  .alert { font-family: 'Poppins', sans-serif; border-radius: 8px; border: none; }
  .alert-success { background-color: #d1fae5; color: #065f46; }

  .card { border-radius: 12px; border: none; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); }
  .card-body { padding: 24px; }

  /* Filter Card */
  .form-card {
    margin-bottom: 20px;
    padding: 20px 32px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  }

  /* SweetAlert Custom */
  .swal2-popup { font-family: 'Poppins', sans-serif !important; border-radius: 24px !important; padding: 40px 32px 32px !important; box-shadow: 0 24px 64px rgba(0,0,0,0.12) !important; max-width: 400px !important; }
  .swal2-title { font-family: 'Poppins', sans-serif !important; font-size: 20px !important; font-weight: 700 !important; color: #1a1a2e !important; }
  .swal2-html-container { font-family: 'Poppins', sans-serif !important; font-size: 14px !important; color: #6b7280 !important; }
  .swal2-icon.swal2-warning { border: none !important; background: #ffe4e6 !important; border-radius: 50% !important; width: 72px !important; height: 72px !important; }
  .swal2-icon.swal2-warning .swal2-icon-content { font-size: 36px !important; color: #ef4444 !important; font-weight: 700 !important; }
  .swal2-actions { gap: 12px !important; margin-top: 28px !important; width: 100% !important; padding: 0 !important; }
  .swal2-confirm { font-family: 'Poppins', sans-serif !important; font-size: 15px !important; font-weight: 600 !important; border-radius: 14px !important; padding: 12px 0 !important; flex: 1 !important; background-color: #ef4444 !important; border: none !important; color: #fff !important; }
  .swal2-confirm:hover { background-color: #dc2626 !important; }
  .swal2-cancel { font-family: 'Poppins', sans-serif !important; font-size: 15px !important; font-weight: 600 !important; border-radius: 14px !important; padding: 12px 0 !important; flex: 1 !important; background-color: #fff !important; border: 2px solid #e5e7eb !important; color: #374151 !important; }
  .swal2-cancel:hover { background-color: #f9fafb !important; border-color: #d1d5db !important; }
</style>

<main id="main" class="main">
  <section class="section">
    <h1 class="page-heading">Daftar Laporan Kelompok Kerja 1</h1>

    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-2"></i>
      {{ $message }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card mt-3">
      <div class="card-body">
        <div class="alert alert-info d-flex align-items-center" role="alert" style="background-color:#dbeafe; color:#1e40af; border:none; border-radius:8px;">
          <i class="bi bi-info-circle-fill me-2"></i>
          <div>Scroll horizontal untuk melihat semua kolom</div>
        </div>

        <div class="table-responsive mt-3">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th scope="col" rowspan="2" class="text-center align-middle" style="width:60px;">No</th>
                @if (Auth::guard('web')->check())
                <th scope="col" rowspan="2" class="text-center align-middle" style="width:120px;">Kecamatan</th>
                <th scope="col" rowspan="2" class="text-center align-middle" style="width:120px;">Desa</th>
                @elseif (Auth::guard('pengguna')->check())
                <th scope="col" rowspan="2" class="text-center align-middle" style="width:120px;">Desa</th>
                @endif
                <th scope="col" colspan="2" class="text-center align-middle">JML KADER</th>
                <th scope="col" rowspan="2" class="text-center align-middle" style="width:100px;">Status</th>
                <th scope="col" rowspan="2" class="text-center align-middle" style="width:140px;">Tanggal</th>
                <th scope="col" rowspan="2" class="text-center align-middle" style="width:120px;">Aksi</th>
              </tr>
              <tr>
                <th scope="col" class="text-center align-middle">Umum</th>
                <th scope="col" class="text-center align-middle">Khusus</th>
              </tr>
            </thead>
            <tbody>
              @php $no = 1; @endphp
              @forelse ($data as $got1)
              <tr>
                <th scope="row" class="text-center">{{ $no++ }}</th>
                @if (Auth::guard('web')->check())
                <td class="text-center">{{ $got1->nama_kec }}</td>
                <td class="text-center">{{ $got1->nama_desa }}</td>
                @elseif (Auth::guard('pengguna')->check())
                <td class="text-center">{{ $got1->nama_desa }}</td>
                @endif
                <td class="text-center">{{ $got1->kader_umum ?? '0' }}</td>
                <td class="text-center">{{ $got1->kader_khusus ?? '0' }}</td>
                <td class="text-center">
                  @if(in_array(strtolower($got1->status), ['proses', 'revisi']))
                  <span class="badge bg-warning text-dark">{{ $got1->status }}</span>
                  @elseif(in_array(strtolower($got1->status), ['disetujui1', 'disetujui2']))
                  <span class="badge bg-success">{{ $got1->status }}</span>
                  @else
                  <span class="badge bg-secondary">{{ $got1->status }}</span>
                  @endif
                </td>
                <td class="text-center" style="font-size:11px;">{{ \Carbon\Carbon::parse($got1->created_at)->format('d/m/Y H:i') }}</td>
                <td class="text-center">
                  <div style="display:inline-flex; gap:6px; align-items:center;">
                    <a href="{{ route('laporanpokja1.edit', $got1->id_kader_pokja1) }}" class="btn btn-sm btn-info text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Review Data">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="{{ route('laporanpokja1.destroy', $got1->id_kader_pokja1) }}" method="POST" class="d-inline delete-form" style="margin:0;">
                      @csrf
                      @method('DELETE')
                      <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this)" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="9" class="text-center" style="padding:40px;">
                  <i class="bi bi-inbox" style="font-size:48px; display:block; margin-bottom:10px; color:#9ca3af;"></i>
                  <span style="color:#9ca3af; font-size:14px;">Tidak ada data laporan kelompok kerja 1</span>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })

  function submitFilter() {
    const bulan = document.getElementById('bulan').value;
    const tahun = document.getElementById('tahun').value;
    if (!bulan && !tahun) {
      Swal.fire({
        icon: 'info', title: 'Pilih Filter',
        text: 'Silakan pilih bulan atau tahun terlebih dahulu',
        confirmButtonColor: '#0369a1', confirmButtonText: 'OK',
        customClass: { popup: 'swal-popup', title: 'swal-title', confirmButton: 'swal-info-btn' },
        buttonsStyling: false
      });
      return;
    }
    const tableRows = document.querySelectorAll('.table-responsive tbody tr');
    let visibleCount = 0;
    tableRows.forEach(row => {
      const cells = row.querySelectorAll('td');
      if (cells.length === 0) return;
      const tanggalCell = cells[cells.length - 2];
      if (!tanggalCell) return;
      const tanggalText = tanggalCell.textContent.trim();
      let isVisible = true;
      const tanggalParts = tanggalText.split(' ')[0].split('/');
      if (tanggalParts.length === 3) {
        const rowBulan = tanggalParts[1];
        const rowTahun = tanggalParts[2];
        if (bulan && tahun) { isVisible = (rowBulan === bulan && rowTahun === tahun); }
        else if (bulan) { isVisible = (rowBulan === bulan); }
        else if (tahun) { isVisible = (rowTahun === tahun); }
      }
      if (isVisible) { row.style.display = ''; visibleCount++; }
      else { row.style.display = 'none'; }
    });
    if (visibleCount === 0) {
      const existingMessage = document.querySelector('.no-data-message');
      if (!existingMessage) {
        const tbody = document.querySelector('.table-responsive tbody');
        const messageRow = document.createElement('tr');
        messageRow.className = 'no-data-message';
        messageRow.innerHTML = '<td colspan="9" class="text-center" style="padding:40px;"><i class="bi bi-inbox" style="font-size:48px; display:block; margin-bottom:10px; color:#9ca3af;"></i><span style="color:#9ca3af; font-size:14px;">Tidak ada data yang sesuai dengan filter</span></td>';
        tbody.appendChild(messageRow);
      }
    } else {
      const existingMessage = document.querySelector('.no-data-message');
      if (existingMessage) existingMessage.remove();
    }
  }

  function resetFilter() {
    const tableRows = document.querySelectorAll('.table-responsive tbody tr');
    tableRows.forEach(row => { row.style.display = ''; });
    const existingMessage = document.querySelector('.no-data-message');
    if (existingMessage) existingMessage.remove();
    document.getElementById('bulan').value = '';
    document.getElementById('tahun').value = '';
  }

  function confirmDelete(button) {
    Swal.fire({
      title: 'Yakin hapus data?',
      text: "Data yang dihapus tidak bisa dikembalikan.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal',
      customClass: { popup: 'swal-popup', title: 'swal-title', confirmButton: 'swal-confirm-btn', cancelButton: 'swal-cancel-btn' },
      buttonsStyling: false,
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) { button.closest('form').submit(); }
    });
  }
</script>

@endsection
