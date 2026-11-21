@extends('backend.layouts.template')

@section('content1')

<main id="main" class="main">

    <section class="section">
      <div class="row">
        <div class="col-md-12">
          <h1 class="page-heading">Tambahkan Berita Baru</h1>

          <div class="form-card">
            <form id="berita-form" action="{{ route('input_berita.store') }}" method="POST" enctype="multipart/form-data">
              @csrf

              <div class="form-group">
                <label for="image" class="form-label">Gambar :</label>
                <input type="file" name="image" id="image" class="form-control" required
                  oninvalid="this.setCustomValidity('Harap unggah gambar')" oninput="this.setCustomValidity('')" />
                <small class="form-text text-muted">Maksimal ukuran gambar yang diunggah adalah 2 MB.</small>
                <div id="image-size-error" class="text-danger" role="alert" style="display: none;">Ukuran gambar melebihi batas maksimal 2 MB.</div>
              </div>

              <div class="form-group">
                <label for="judul" class="form-label">Judul :</label>
                <input type="text" name="judul" id="judul" class="form-control" required
                  oninvalid="this.setCustomValidity('Harap lengkapi judul')" oninput="this.setCustomValidity('')"
                  placeholder="Masukkan judul" />
              </div>

              <div class="form-group">
                <label for="deskripsi" class="form-label">Deskripsi :</label>
                <textarea class="form-control" name="deskripsi" rows="4" id="deskripsi"
                  placeholder="Masukkan deskripsi berita" required
                  oninvalid="this.setCustomValidity('Harap lengkapi deskripsi')"
                  oninput="this.setCustomValidity('')" style="height: auto !important;"></textarea>
              </div>

              <div class="form-group">
                <label for="file" class="form-label">Upload Dokumen Pendukung (Opsional) :</label>
                <input type="file" name="file" id="file" class="form-control"
                  oninput="this.setCustomValidity('')" />
              </div>

              <div class="text-end">
                <button class="btn-kirim" type="submit">Kirim</button>
              </div>
            </form>
          </div>

          <h1 class="page-heading" style="margin-top: 40px;">Daftar Berita</h1>

          @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
              {{ $message }}
            </div>
          @endif

          <div class="table-card">
            <table class="table-ttd">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Gambar</th>
                  <th scope="col">Judul</th>
                  <th scope="col">Deskripsi</th>
                  <th scope="col">File</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $no = 1;
                @endphp
                @forelse ($data as $berita)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td><img src="{{ asset('storage/berita/' . $berita->image) }}" class="rounded" width="100"
                      height="100" style="object-fit: cover;">
                    </td>
                    <td>{{ Str::limit($berita->judul, 25) }}</td>
                    <td>{{ Str::limit($berita->deskripsi, 25) }}</td>
                    <td>{{ Str::limit($berita->file, 20) }}</td>
                    <td>
                      <a href="{{ route('input_berita.edit', $berita->id) }}" class="btn-act btn-act-edit">
                        <i class="bi bi-pencil-square"></i>
                      </a>

                      <form action="{{ route('input_berita.destroy', $berita->id)}}" method="POST"
                        class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn-act btn-act-delete" onclick="confirmDelete(this)">
                          <i class="bi bi-trash"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center" style="padding: 24px;">
                      <div class="alert alert-danger mb-0">
                        Tidak ada data berita
                      </div>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    const beritaForm = document.getElementById('berita-form');
    const beritaImage = document.getElementById('image');
    const imageSizeError = document.getElementById('image-size-error');
    const maxImageSize = 2 * 1024 * 1024;

    beritaForm.addEventListener('submit', function (event) {
      const image = beritaImage.files[0];
      if (image && image.size > maxImageSize) {
        event.preventDefault();
        imageSizeError.style.display = 'block';
        beritaImage.focus();
      } else {
        imageSizeError.style.display = 'none';
      }
    });

    beritaImage.addEventListener('change', function () {
      const image = this.files[0];
      imageSizeError.style.display = image && image.size > maxImageSize ? 'block' : 'none';
    });

    function confirmDelete(button) {
      Swal.fire({
        title: 'Yakin hapus data?',
        text: "Data yang dihapus tidak bisa dikembalikan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          button.closest('form').submit();
        }
      });
    }
  </script>

@endsection
