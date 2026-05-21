@extends('backend.layouts.template')

@section('content1')

<style>
  * {
    font-family: 'Poppins', sans-serif !important;
  }

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

  /* TABLE */
  .table-responsive table {
    min-width: 1800px;
    white-space: nowrap;
    margin-bottom: 0;
    font-family: 'Poppins', sans-serif;
  }

  /* HEADER */
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

  /* BODY */
  .table-responsive tbody td,
  .table-responsive tbody th {
    font-size: 12px;
    padding: 10px 8px;
    vertical-align: middle;
    background-color: white;
    color: #475569;
    font-family: 'Poppins', sans-serif;
  }

  /* HOVER */
  .table-responsive tbody tr:hover td,
  .table-responsive tbody tr:hover th {
    background-color: #f1f5f9;
  }

  /* BORDER */
  .table-bordered th,
  .table-bordered td {
    border: 1px solid #e2e8f0;
  }

  /* SCROLLBAR */
  .table-responsive::-webkit-scrollbar {
    height: 8px;
  }

  .table-responsive::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
  }

  .table-responsive::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
  }

  .table-responsive::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
  }

  /* TEXT */
  .header-group-title {
    font-size: 12px;
    font-weight: 700;
    color: #1e293b;
    font-family: 'Poppins', sans-serif;
  }

  .header-sub-title {
    font-size: 10px;
    font-weight: 600;
    color: #64748b;
    font-family: 'Poppins', sans-serif;
  }

  /* BADGE */
  .badge {
    font-family: 'Poppins', sans-serif;
    font-size: 11px;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 6px;
  }

  /* BUTTON */
  .btn {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    border-radius: 6px;
    transition: all 0.3s ease;
  }

  .btn-info {
    background-color: #0369a1;
    border-color: #0369a1;
  }

  .btn-info:hover {
    background-color: #075985;
    border-color: #075985;
  }

  .btn-danger {
    background-color: #ef4444;
    border-color: #ef4444;
  }

  .btn-danger:hover {
    background-color: #dc2626;
    border-color: #dc2626;
  }

  /* ALERT */
  .alert {
    font-family: 'Poppins', sans-serif;
    border-radius: 8px;
    border: none;
  }

  .alert-info {
    background-color: #dbeafe;
    color: #1e40af;
  }

  .alert-success {
    background-color: #d1fae5;
    color: #065f46;
  }

  .alert-danger {
    background-color: #fee2e2;
    color: #991b1b;
  }

  /* CARD */
  .card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  }

  .card-body {
    padding: 24px;
  }
  thead tr:nth-child(3) th:empty {
    padding: 0;
    height: 0;
    border: none;
    background: transparent;
}
</style>

<main id="main" class="main">
  <section class="section">
    <h1 class="page-heading">Daftar Laporan Bidang Umum</h1>

    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-2"></i>
      {{ $message }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif




    <div class="card mt-3">
      <div class="card-body">

        <div class="alert alert-info d-flex align-items-center" role="alert">
          <i class="bi bi-info-circle-fill me-2"></i>
          <div>Scroll horizontal untuk melihat semua kolom</div>
        </div>

        <div class="table-responsive mt-3">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th scope="col" rowspan="3" class="text-center align-middle" style="width: 60px;">No</th>
                @if (Auth::guard('web')->check())
                <th scope="col" rowspan="3" class="text-center align-middle" style="width: 120px;">Kecamatan</th>
                <th scope="col" rowspan="3" class="text-center align-middle" style="width: 120px;">Desa</th>
                @elseif (Auth::guard('pengguna')->check())
                <th scope="col" rowspan="3" class="text-center align-middle" style="width: 120px;">Desa</th>
                @endif
                <th scope="col" colspan="4" class="text-center header-group-title">JUMLAH KELOMPOK</th>
                <th scope="col" colspan="2" class="text-center header-group-title">JUMLAH</th>
                <th scope="col" colspan="2" class="text-center header-group-title">JUMLAH JIWA</th>
                <th scope="col" colspan="6" class="text-center header-group-title">JUMLAH KADER</th>
                <th scope="col" colspan="4" class="text-center header-group-title">JUMLAH TENAGA SEKRETARIAT</th>
                <th scope="col" rowspan="3" class="text-center align-middle" style="width: 100px;">Status</th>
                <th scope="col" rowspan="3" class="text-center align-middle" style="width: 140px;">Tanggal</th>
                <th scope="col" rowspan="3" class="text-center align-middle" style="width: 160px;">Aksi</th>
              </tr>
              <tr>
                <th scope="col" class="text-center header-sub-title">Dusun/<br>Lingkungan</th>
                <th scope="col" class="text-center header-sub-title">PKK/<br>RW</th>
                <th scope="col" class="text-center header-sub-title">PKK/<br>RT</th>
                <th scope="col" class="text-center header-sub-title">Desa/<br>Wisma</th>
                <th scope="col" class="text-center header-sub-title">KRT</th>
                <th scope="col" class="text-center header-sub-title">KK</th>
                <th scope="col" class="text-center header-sub-title">Laki-laki</th>
                <th scope="col" class="text-center header-sub-title">Perempuan</th>
                <th scope="col" colspan="2" class="text-center header-sub-title">ANGGOTA TP PKK</th>
                <th scope="col" colspan="2" class="text-center header-sub-title">UMUM</th>
                <th scope="col" colspan="2" class="text-center header-sub-title">KHUSUS</th>
                <th scope="col" colspan="2" class="text-center header-sub-title">HONORER</th>
                <th scope="col" colspan="2" class="text-center header-sub-title">BANTUAN</th>
              </tr>
              <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>

                <th class="text-center" style="font-size: 9px;">L</th>
                <th class="text-center" style="font-size: 9px;">P</th>

                <th class="text-center" style="font-size: 9px;">L</th>
                <th class="text-center" style="font-size: 9px;">P</th>

                <th class="text-center" style="font-size: 9px;">L</th>
                <th class="text-center" style="font-size: 9px;">P</th>

                <th class="text-center" style="font-size: 9px;">L</th>
                <th class="text-center" style="font-size: 9px;">P</th>

                <th class="text-center" style="font-size: 9px;">L</th>
                <th class="text-center" style="font-size: 9px;">P</th>

                <th class="text-center" style="font-size: 9px;">L</th>
                <th class="text-center" style="font-size: 9px;">P</th>
              </tr>
            </thead>
            <tbody>
              @php
              $no = 1;
              @endphp
              @forelse ($data as $umum)
              <tr>
                <th scope="row" class="text-center">{{ $no++ }}</th>
                @if (Auth::guard('web')->check())
                <td class="text-center">{{ $umum->nama_kec }}</td>
                <td class="text-center">{{ $umum->nama_desa }}</td>
                @elseif (Auth::guard('pengguna')->check())
                <td class="text-center">{{ $umum->nama_desa }}</td>
                @endif
                <td class="text-center">{{ $umum->dusun_lingkungan ?? '-' }}</td>
                <td class="text-center">{{ $umum->PKK_RW ?? '-' }}</td>
                <td class="text-center">{{ $umum->PKK_RT ?? '-' }}</td>
                <td class="text-center">{{ $umum->desa_wisma ?? '-' }}</td>
                <td class="text-center">{{ $umum->KRT ?? '-' }}</td>
                <td class="text-center">{{ $umum->KK ?? '-' }}</td>
                <td class="text-center">{{ $umum->jiwa_laki ?? '0' }}</td>
                <td class="text-center">{{ $umum->jiwa_perempuan ?? '0' }}</td>
                <td class="text-center">{{ $umum->anggota_laki ?? '0' }}</td>
                <td class="text-center">{{ $umum->anggota_perempuan ?? '0' }}</td>
                <td class="text-center">{{ $umum->umum_laki ?? '0' }}</td>
                <td class="text-center">{{ $umum->umum_perempuan ?? '0' }}</td>
                <td class="text-center">{{ $umum->khusus_laki ?? '0' }}</td>
                <td class="text-center">{{ $umum->khusus_perempuan ?? '0' }}</td>
                <td class="text-center">{{ $umum->honorer_laki ?? '0' }}</td>
                <td class="text-center">{{ $umum->honorer_perempuan ?? '0' }}</td>
                <td class="text-center">{{ $umum->bantuan_laki ?? '0' }}</td>
                <td class="text-center">{{ $umum->bantuan_perempuan ?? '0' }}</td>
                <td class="text-center">
                  @if(in_array(strtolower($umum->status), ['proses', 'revisi']))
                  <span class="badge bg-warning text-dark">{{ $umum->status }}</span>
                  @elseif(in_array(strtolower($umum->status), ['disetujui1', 'disetujui2']))
                  <span class="badge bg-success">{{ $umum->status }}</span>
                  @else
                  <span class="badge bg-secondary">{{ $umum->status }}</span>
                  @endif
                </td>
                <td class="text-center" style="font-size: 11px;">{{ \Carbon\Carbon::parse($umum->created_at)->format('d/m/Y H:i') }}</td>
                <td class="text-center">
                  <div style="display: inline-flex; gap: 6px; align-items: center;">
                    <a href="{{ route('bidangumum.edit', $umum->id_laporan_umum) }}" class="btn btn-sm btn-info text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Review Data">
                      <i class="bi bi-pencil-square"></i>
                    </a>

                    <form action="{{ route('bidangumum.destroy', $umum->id_laporan_umum)}}" method="POST" class="d-inline delete-form" style="margin: 0;">
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
                <td colspan="24" class="text-center" style="padding: 40px;">
                  <i class="bi bi-inbox" style="font-size: 48px; display: block; margin-bottom: 10px; color: #9ca3af;"></i>
                  <span style="color: #9ca3af; font-size: 14px;">Tidak ada data laporan bidang umum</span>
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
  // Initialize tooltips
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })

  function submitFilter() {
    const bulan = document.getElementById('bulan').value;
    const tahun = document.getElementById('tahun').value;

    if (!bulan && !tahun) {
      Swal.fire({
        icon: 'info',
        title: 'Pilih Filter',
        text: 'Silakan pilih bulan atau tahun terlebih dahulu',
        confirmButtonColor: '#0369a1',
        confirmButtonText: 'OK',
        customClass: {
          popup: 'swal-popup',
          title: 'swal-title',
          confirmButton: 'swal-info-btn'
        },
        buttonsStyling: false
      });
      return;
    }

    // Ambil semua baris tabel
    const tableRows = document.querySelectorAll('.table-responsive tbody tr');
    let visibleCount = 0;

    tableRows.forEach(row => {
      // Cari kolom tanggal (kolom kedua dari belakang)
      const cells = row.querySelectorAll('td');
      if (cells.length === 0) return;

      const tanggalCell = cells[cells.length - 2];

      if (!tanggalCell) return;

      const tanggalText = tanggalCell.textContent.trim();
      let isVisible = true;

      // Parse tanggal dari format "DD/MM/YYYY HH:MM"
      const tanggalParts = tanggalText.split(' ')[0].split('/');
      if (tanggalParts.length === 3) {
        const rowBulan = tanggalParts[1];
        const rowTahun = tanggalParts[2];

        // Filter berdasarkan bulan dan tahun
        if (bulan && tahun) {
          isVisible = (rowBulan === bulan && rowTahun === tahun);
        } else if (bulan) {
          isVisible = (rowBulan === bulan);
        } else if (tahun) {
          isVisible = (rowTahun === tahun);
        }
      }

      // Tampilkan atau sembunyikan baris
      if (isVisible) {
        row.style.display = '';
        visibleCount++;
      } else {
        row.style.display = 'none';
      }
    });

    // Jika tidak ada data yang cocok, tampilkan pesan
    if (visibleCount === 0) {
      const existingMessage = document.querySelector('.no-data-message');
      if (!existingMessage) {
        const tbody = document.querySelector('.table-responsive tbody');
        const messageRow = document.createElement('tr');
        messageRow.className = 'no-data-message';
        messageRow.innerHTML = '<td colspan="24" class="text-center" style="padding: 40px;"><i class="bi bi-inbox" style="font-size: 48px; display: block; margin-bottom: 10px; color: #9ca3af;"></i><span style="color: #9ca3af; font-size: 14px;">Tidak ada data yang sesuai dengan filter</span></td>';
        tbody.appendChild(messageRow);
      }
    } else {
      const existingMessage = document.querySelector('.no-data-message');
      if (existingMessage) {
        existingMessage.remove();
      }
    }
  }

  function resetFilter() {
    // Tampilkan semua baris tabel
    const tableRows = document.querySelectorAll('.table-responsive tbody tr');
    tableRows.forEach(row => {
      row.style.display = '';
    });

    // Hapus pesan "tidak ada data" jika ada
    const existingMessage = document.querySelector('.no-data-message');
    if (existingMessage) {
      existingMessage.remove();
    }

    // Reset form
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
      customClass: {
        popup: 'swal-popup',
        title: 'swal-title',
        confirmButton: 'swal-confirm-btn',
        cancelButton: 'swal-cancel-btn'
      },
      buttonsStyling: false,
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        button.closest('form').submit();
      }
    });
  }
</script>

<style>
  /* SweetAlert Custom Styles */
  .swal-popup {
    font-family: 'Poppins', sans-serif !important;
    border-radius: 12px;
  }

  .swal-title {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 600;
    font-size: 20px;
  }

  .swal-confirm-btn {
    background-color: #ef4444 !important;
    color: white !important;
    padding: 10px 24px !important;
    border-radius: 6px !important;
    font-family: 'Poppins', sans-serif !important;
    font-weight: 600 !important;
    font-size: 14px !important;
  }

  .swal-confirm-btn:hover {
    background-color: #dc2626 !important;
  }

  .swal-cancel-btn {
    background-color: #6c757d !important;
    color: white !important;
    padding: 10px 24px !important;
    border-radius: 6px !important;
    font-family: 'Poppins', sans-serif !important;
    font-weight: 600 !important;
    font-size: 14px !important;
  }

  .swal-cancel-btn:hover {
    background-color: #5a6268 !important;
  }

  .swal-info-btn {
    background-color: #0369a1 !important;
    color: white !important;
    padding: 10px 24px !important;
    border-radius: 6px !important;
    font-family: 'Poppins', sans-serif !important;
    font-weight: 600 !important;
    font-size: 14px !important;
  }

  .swal-info-btn:hover {
    background-color: #075985 !important;
  }
</style>
</script>

@endsection