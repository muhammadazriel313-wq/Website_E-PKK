@extends('backend.layouts.template')

@section('content1')

<style>
  * {
    font-family: 'Poppins', sans-serif !important;
  }

  .page-heading {
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
    min-width: 1800px;
    white-space: nowrap;
    margin-bottom: 0;
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
  }

  .table-responsive tbody td,
  .table-responsive tbody th {
    font-size: 12px;
    padding: 10px 8px;
    vertical-align: middle;
    background-color: white;
    color: #475569;
  }

  .table-responsive tbody tr:hover td,
  .table-responsive tbody tr:hover th {
    background-color: #f1f5f9;
  }

  .table-bordered th,
  .table-bordered td {
    border: 1px solid #e2e8f0;
  }

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

  .header-group-title {
    font-size: 12px;
    font-weight: 700;
    color: #1e293b;
  }

  .header-sub-title {
    font-size: 10px;
    font-weight: 600;
    color: #64748b;
  }

  .card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  }

  .card-body {
    padding: 24px;
  }
</style>

<main id="main" class="main">
  <section class="section">
    <div class="d-flex align-items-center gap-3 mb-3">
      <a href="{{ route('accbidangumum.index') }}" onclick="if (window.history.length > 1) { window.history.back(); return false; }"
        class="btn btn-outline-secondary d-inline-flex align-items-center justify-content-center"
        style="width: 40px; height: 40px; padding: 0; flex: 0 0 40px;" aria-label="Kembali" title="Kembali">
        <i class="bi bi-arrow-left"></i>
      </a>
      <h1 class="page-heading mb-0">Daftar Laporan Bidang Umum (Disetujui)</h1>
    </div>

    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-2"></i>
      {{ $message }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card mt-3">
      <div class="card-body">
        <div class="alert alert-info d-flex align-items-center" role="alert" style="background:#dbeafe; color:#1e40af; border:none; border-radius:8px;">
          <i class="bi bi-info-circle-fill me-2"></i>
          <div>Scroll horizontal untuk melihat semua kolom</div>
        </div>

        <div class="table-responsive mt-3">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th scope="col" rowspan="3" class="text-center align-middle">No</th>
                @if (Auth::guard('web')->check())
                <th scope="col" rowspan="3" class="text-center align-middle">Kecamatan</th>
                <th scope="col" rowspan="3" class="text-center align-middle">Desa</th>
                @elseif (Auth::guard('pengguna')->check())
                <th scope="col" rowspan="3" class="text-center align-middle">Desa</th>
                @endif
                <th scope="col" colspan="4" class="text-center header-group-title">JUMLAH KELOMPOK</th>
                <th scope="col" colspan="2" class="text-center header-group-title">JUMLAH</th>
                <th scope="col" colspan="2" class="text-center header-group-title">JUMLAH JIWA</th>
                <th scope="col" colspan="6" class="text-center header-group-title">JUMLAH KADER</th>
                <th scope="col" colspan="4" class="text-center header-group-title">JUMLAH TENAGA SEKRETARIAT</th>
                <th scope="col" rowspan="3" class="text-center align-middle" style="width: 200px;">Keterangan</th>
                <th scope="col" rowspan="3" class="text-center align-middle">Status</th>
                <th scope="col" rowspan="3" class="text-center align-middle">Tanggal</th>
                <th scope="col" rowspan="3" class="text-center align-middle">Aksi</th>
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
                <th scope="col" class="text-center" style="font-size:9px;">L</th>
                <th scope="col" class="text-center" style="font-size:9px;">P</th>
                <th scope="col" class="text-center" style="font-size:9px;">L</th>
                <th scope="col" class="text-center" style="font-size:9px;">P</th>
                <th scope="col" class="text-center" style="font-size:9px;">L</th>
                <th scope="col" class="text-center" style="font-size:9px;">P</th>
                <th scope="col" class="text-center" style="font-size:9px;">L</th>
                <th scope="col" class="text-center" style="font-size:9px;">P</th>
                <th scope="col" class="text-center" style="font-size:9px;">L</th>
                <th scope="col" class="text-center" style="font-size:9px;">P</th>
                <th scope="col" class="text-center" style="font-size:9px;">L</th>
                <th scope="col" class="text-center" style="font-size:9px;">P</th>
              </tr>
            </thead>
            <tbody>
              @php $no = 1; @endphp
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
                <td>{{ $umum->keterangan ?? '-' }}</td>
                <td class="text-center">
                  @if(in_array(strtolower($umum->status), ['proses', 'revisi']))
                  <span class="badge bg-warning text-dark">
                    {{ $umum->status }}
                  </span>
                  @elseif(in_array(strtolower($umum->status), ['disetujui1', 'disetujui2']))
                  <span class="badge bg-success">
                    {{ $umum->status }}
                  </span>
                  @else
                  <span class="badge bg-secondary">
                    {{ $umum->status }}
                  </span>
                  @endif
                </td>
                <td class="text-center" style="font-size:11px;">{{ \Carbon\Carbon::parse($umum->created_at)->format('d/m/Y H:i') }}</td>
                <td class="text-center">
                  <form action="{{ route('decbidangumum.destroy', $umum->id_laporan_umum) }}" method="POST" class="d-inline delete-form" style="margin:0;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this)" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="24" class="text-center" style="padding:40px;">
                  <i class="bi bi-inbox" style="font-size:48px; display:block; margin-bottom:10px; color:#9ca3af;"></i>
                  <span style="color:#9ca3af; font-size:14px;">Tidak ada data laporan bidang umum</span>
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
      buttonsStyling: false,
      reverseButtons: true,
      customClass: {
        confirmButton: 'btn btn-danger me-2',
        cancelButton: 'btn btn-secondary'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        button.closest('form').submit();
      }
    });
  }
</script>

@endsection
