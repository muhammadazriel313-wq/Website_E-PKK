@extends('backend.layouts.template')

@section('content1')

<main id="main" class="main">

    <section class="section">
        <h1 class="page-heading">Review Kegiatan</h1>

        <div class="form-card">

            <form action="{{ route('galeriperumahan.update', $data->id) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="form-group">

                    <label for="gambar" class="form-label">
                        Gambar :
                    </label>

                    <div id="carouselExampleInterval"
                        class="carousel slide"
                        data-bs-ride="carousel"
                        style="max-width: 800px; margin-top: 10px;">

                        <div class="carousel-inner"
                            style="border-radius: 8px; overflow: hidden;">

                            <div class="carousel-item active"
                                data-bs-interval="10000">

                                <img src="{{ asset('storage/gallery/' . $data->gambar) }}"
                                    class="d-block w-100"
                                    alt="Gallery Image">

                            </div>

                        </div>

                    </div>

                </div>

                <div class="form-group">

                    <label for="deskripsi" class="form-label">
                        Deskripsi :
                    </label>

                    <input type="text"
                        name="deskripsi"
                        id="deskripsi"
                        class="form-control"
                        required
                        readonly
                        oninvalid="this.setCustomValidity('Harap lengkapi Deskripsi')"
                        oninput="this.setCustomValidity('')"
                        placeholder="Masukkan Deskripsi"
                        value="{{ $data->deskripsi }}" />

                </div>

                <div class="form-group">
                    <label for="nama_peserta" class="form-label">
                        Nama Peserta :
                    </label>
                    @php
                        $pesertaArr = json_decode($data->nama_peserta, true);
                        $pesertaText = (!empty($pesertaArr) && is_array($pesertaArr)) ? implode("
", $pesertaArr) : ($data->nama_peserta ?? '');
                    @endphp
                    <textarea name="nama_peserta" id="nama_peserta" class="form-control" rows="3" placeholder="Daftar nama peserta (satu per baris)">{{ $pesertaText }}</textarea>
                    <small class="text-muted">Daftar nama peserta (satu nama per baris)</small>
                </div>

                <div class="form-group">

                    <label for="tempat_kegiatan" class="form-label">
                        Tempat Kegiatan :
                    </label>

                    <input type="text"
                        name="tempat_kegiatan"
                        id="tempat_kegiatan"
                        class="form-control"
                        required
                        readonly
                        oninvalid="this.setCustomValidity('Harap lengkapi Tempat Kegiatan')"
                        oninput="this.setCustomValidity('')"
                        placeholder="Masukkan Tempat Kegiatan"
                        value="{{ $data->lokasi }}" />

                </div>

                <div class="form-group">

                    <label for="tanggal" class="form-label">
                        Tanggal :
                    </label>

                    <input type="text"
                        name="tanggal"
                        id="tanggal"
                        class="form-control"
                        required
                        readonly
                        oninvalid="this.setCustomValidity('Harap lengkapi tanggal')"
                        oninput="this.setCustomValidity('')"
                        placeholder="Masukkan tanggal"
                        value="{{ $data->created_at }}" />

                </div>

                <div class="text-end">

                    {{-- WEB KECAMATAN --}}
                    @if(auth()->guard('pengguna')->check())

                    @if(strtolower($data->status) == 'proses')

                    <button class="btn-kirim"
                        type="submit"
                        style="background-color: #22c55e !important;">

                        Upload

                    </button>

                    @else

                    <a href="{{ route('galeriperumahan.index') }}"
                        class="btn-kirim"
                        style="
                            background-color: #6c757d !important;
                            text-decoration: none;
                            display: inline-block;
                        ">

                        Kembali

                    </a>

                    @endif

                    @endif


                    {{-- WEB KABUPATEN --}}
                    @if(auth()->guard('web')->check())

                    @if(
                    strtolower($data->status) == 'upload1' ||
                    strtolower($data->status) == 'proses'
                    )

                    <button class="btn-kirim"
                        type="submit"
                        style="background-color: #2563eb !important;">

                        Upload

                    </button>

                    @else

                    <a href="{{ route('galeriperumahan.index') }}"
                        class="btn-kirim"
                        style="
                            background-color: #6c757d !important;
                            text-decoration: none;
                            display: inline-block;
                        ">

                        Kembali

                    </a>

                    @endif

                    @endif

                </div>

            </form>

        </div>

    </section>

</main>

@endsection