@extends('backend.layouts.template')

@section('content1')

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="page-heading mb-0">Edit Data Pengguna</h1>
                    <a href="{{ route('pengguna.index', ['tab' => $pengguna->id_role == 2 ? 'kecamatan' : 'desa']) }}" class="btn btn-outline-secondary btn-sm">
                       Kembali ke Daftar
                    </a>
                </div>

                {{-- Alert Error Validasi --}}
                @if (isset($errors) && $errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Terdapat kesalahan pengisian data:</div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-person-gear text-primary fs-5"></i>
                            <span class="fw-bold text-dark">Informasi Akun Pengguna</span>
                        </div>
                        <div>
                            @if ($pengguna->id_role == 2)
                                <span class="badge" style="background-color: #0284c7; font-size: 13px;">
                                    <i class="bi bi-building me-1"></i> Pengurus Kecamatan
                                </span>
                            @else
                                <span class="badge" style="background-color: #10b981; font-size: 13px;">
                                    <i class="bi bi-houses me-1"></i> Kader / Pengurus Desa
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('pengguna.update', $pengguna->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                {{-- Nama Lengkap --}}
                                <div class="col-md-6">
                                    <label for="full_name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="full_name" 
                                           id="full_name" 
                                           class="form-control @error('full_name') is-invalid @enderror" 
                                           value="{{ old('full_name', $pengguna->full_name) }}" 
                                           required>
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Nomor Telepon / WhatsApp --}}
                                <div class="col-md-6">
                                    <label for="phone_number" class="form-label fw-semibold">Nomor Telepon / WhatsApp <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-whatsapp text-success"></i></span>
                                        <input type="text" 
                                               name="phone_number" 
                                               id="phone_number" 
                                               class="form-control @error('phone_number') is-invalid @enderror" 
                                               value="{{ old('phone_number', $pengguna->phone_number) }}" 
                                               placeholder="081234567890" 
                                               required>
                                    </div>
                                    @error('phone_number')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Status Akun --}}
                                <div class="col-md-4">
                                    <label for="status" class="form-label fw-semibold">Status Akun <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="Active" {{ old('status', $pengguna->status) == 'Active' ? 'selected' : '' }}>Aktif (Active)</option>
                                        <option value="Inactive" {{ old('status', $pengguna->status) == 'Inactive' ? 'selected' : '' }}>Nonaktif (Inactive)</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Kecamatan --}}
                                <div class="col-md-{{ $pengguna->id_role == 1 ? '4' : '8' }}">
                                    <label for="id_subdistrict" class="form-label fw-semibold">Kecamatan <span class="text-danger">*</span></label>
                                    <select name="id_subdistrict" id="id_subdistrict" class="form-select @error('id_subdistrict') is-invalid @enderror" onchange="loadVillages(this.value)">
                                        <option value="">-- Pilih Kecamatan --</option>
                                        @foreach ($subdistricts as $sub)
                                            <option value="{{ $sub->id }}" {{ old('id_subdistrict', $pengguna->id_subdistrict) == $sub->id ? 'selected' : '' }}>
                                                {{ $sub->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_subdistrict')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Desa / Kelurahan (hanya jika pengguna tingkat Desa) --}}
                                @if ($pengguna->id_role == 1)
                                    <div class="col-md-4" id="village-wrapper">
                                        <label for="id_village" class="form-label fw-semibold">Desa / Kelurahan <span class="text-danger">*</span></label>
                                        <select name="id_village" id="id_village" class="form-select @error('id_village') is-invalid @enderror">
                                            <option value="">-- Pilih Desa --</option>
                                            @foreach ($villages as $vil)
                                                <option value="{{ $vil->id }}" {{ old('id_village', $pengguna->id_village) == $vil->id ? 'selected' : '' }}>
                                                    {{ $vil->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_village')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif

                                {{-- Password Baru (Opsional) --}}
                                <div class="col-md-12">
                                    <div class="p-3 bg-light rounded border mt-2">
                                        <label for="password" class="form-label fw-semibold mb-1">
                                            <i class="bi bi-key me-1 text-primary"></i> Ganti Kata Sandi (Opsional)
                                        </label>
                                        <div class="input-group">
                                            <input type="password" 
                                                   name="password" 
                                                   id="password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   placeholder="Masukkan kata sandi baru jika ingin mengubah">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility()">
                                                <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted d-block mt-1">
                                            Biarkan kolom ini kosong jika tidak ingin mengubah kata sandi akun pengguna ini (minimal 6 karakter).
                                        </small>
                                        @error('password')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <a href="{{ route('pengguna.index', ['tab' => $pengguna->id_role == 2 ? 'kecamatan' : 'desa']) }}" class="btn btn-secondary">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary" style="background-color: #016AA3; border-color: #016AA3;">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    function loadVillages(subdistrictId) {
        const villageSelect = document.getElementById('id_village');
        if (!villageSelect) return;

        villageSelect.innerHTML = '<option value="">-- Memuat Desa... --</option>';

        if (!subdistrictId) {
            villageSelect.innerHTML = '<option value="">-- Pilih Desa --</option>';
            return;
        }

        fetch(`{{ url('pengguna/villages') }}/${subdistrictId}`)
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">-- Pilih Desa --</option>';
                data.forEach(item => {
                    options += `<option value="${item.id}">${item.name}</option>`;
                });
                villageSelect.innerHTML = options;
            })
            .catch(err => {
                console.error(err);
                villageSelect.innerHTML = '<option value="">-- Gagal memuat desa --</option>';
            });
    }
</script>

@endsection
