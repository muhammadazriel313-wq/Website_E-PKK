@extends('backend.layouts.template')

@section('content1')

<main id="main" class="main">

  <section class="section">
    <div class="row">
      <div class="col-12 mb-3">
        <h1 class="page-heading mb-1">Pengaturan Profil & Akun</h1>

        {{-- NOTIFIKASI UMUM --}}
        @if ($message = Session::get('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if ($message = Session::get('successs'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if ($message = Session::get('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
      </div>

      {{-- ======================================================== --}}
      {{-- 1. KONTAINER FULL-WIDTH: INFORMASI PRIBADI               --}}
      {{-- ======================================================== --}}
      <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm profile-container-box">
          {{-- HEADER KONTAINER (KLIK UNTUK MEMUNCULKAN KONTEN) --}}
          <div class="card-header bg-white p-3 p-md-4 d-flex justify-content-between align-items-center profile-collapse-trigger" 
               role="button" 
               data-bs-toggle="collapse" 
               data-bs-target="#collapseInfoPribadi" 
               aria-expanded="{{ Session::has('success') ? 'true' : 'false' }}" 
               aria-controls="collapseInfoPribadi">
            <div class="d-flex align-items-center gap-3">
              <div class="profile-icon-box bg-primary-subtle text-primary">
                <i class="bi bi-person-circle fs-3"></i>
              </div>
              <div>
                <h4 class="mb-1 fw-bold text-dark fs-5">Informasi Pribadi</h4>
                <div class="text-muted small">Klik untuk menampilkan detail biodata diri Anda</div>
              </div>
            </div>
            <div class="d-flex align-items-center gap-2">
              <div class="toggle-icon-wrap ms-2">
                <i class="bi bi-chevron-down fs-5 text-secondary toggle-icon"></i>
              </div>
            </div>
          </div>

          {{-- KONTEN INFORMASI PRIBADI --}}
          <div id="collapseInfoPribadi" class="collapse {{ Session::has('success') ? 'show' : '' }}">
            <div class="card-body p-4 border-top">
              <div class="info-content">
                <div class="row py-3 border-bottom" style="border-color: #f1f5f9 !important;">
                  <div class="col-sm-3 col-md-2" style="font-weight: 500; color: #64748b;">Nama lengkap :</div>
                  <div class="col-sm-9 col-md-10" style="color: #1e293b; font-weight: 600;">
                    {{ $userType == 'pengguna' ? $user->full_name : $user->name }}
                  </div>
                </div>
                
                @if($userType == 'user')
                  <div class="row py-3 border-bottom" style="border-color: #f1f5f9 !important;">
                    <div class="col-sm-3 col-md-2" style="font-weight: 500; color: #64748b;">Email :</div>
                    <div class="col-sm-9 col-md-10" style="color: #1e293b; font-weight: 600;">{{ $user->email }}</div>
                  </div>
                @endif
                
                <div class="row py-3 border-bottom" style="border-color: #f1f5f9 !important;">
                  <div class="col-sm-3 col-md-2" style="font-weight: 500; color: #64748b;">Nomor telepon :</div>
                  <div class="col-sm-9 col-md-10" style="color: #1e293b; font-weight: 600;">
                    {{ $userType == 'pengguna' ? $user->phone_number : $user->nomer_telepon }}
                  </div>
                </div>
                
                @if($userType == 'user')
                  <div class="row py-3" style="border-color: #f1f5f9 !important;">
                    <div class="col-sm-3 col-md-2" style="font-weight: 500; color: #64748b;">Alamat :</div>
                    <div class="col-sm-9 col-md-10" style="color: #1e293b; font-weight: 600;">{{ $user->alamat }}</div>
                  </div>
                @endif
              </div>

              <div class="text-end pt-3 border-top mt-4">
                <button class="btn-kirim" type="button" onclick="openEditModal()">
                  <i class="bi bi-pencil-square me-1"></i> Edit Informasi
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- ======================================================== --}}
      {{-- 2. KONTAINER FULL-WIDTH: UBAH KATA SANDI                 --}}
      {{-- ======================================================== --}}
      <div class="col-12 mb-4">

    {{-- HEADER (tanpa trigger, tanpa chevron) --}}
     <div class="card border-0 shadow-sm profile-container-box">
    <div class="card-header bg-white p-3 p-md-4 d-flex justify-content-between align-items-center profile-collapse-trigger"
         role="button"
         data-bs-toggle="collapse"
         data-bs-target="#collapseKeamananAkun"
         aria-expanded="{{ (isset($errors) && $errors->any() || Session::has('error') || Session::has('successs')) ? 'true' : 'false' }}"
         aria-controls="collapseKeamananAkun">
      <div class="d-flex align-items-center gap-3">
        <div class="profile-icon-box bg-warning-subtle text-warning">
          <i class="bi bi-shield-lock fs-3"></i>
        </div>
        <div>
          <h4 class="mb-1 fw-bold text-dark fs-5">Keamanan Akun</h4>
          <div class="text-muted small">Klik untuk melihat pengaturan keamanan akun Anda</div>
        </div>
      </div>
      <div class="toggle-icon-wrap ms-2">
        <i class="bi bi-chevron-down fs-5 text-secondary toggle-icon"></i>
      </div>
    </div>

          {{-- ISI KONTAINER LUAR --}}
            <div id="collapseKeamananAkun"
             class="collapse {{ (isset($errors) && $errors->any() || Session::has('error') || Session::has('successs')) ? 'show' : '' }}">
            <div class="card-body p-3 p-md-4 border-top bg-light">

          {{-- KONTEN FORM UBAH KATA SANDI --}}
            <div class="card-body p-4 border-top">
              <form action="{{ route('change_password.update', $user->id) }}" method="POST">
                @method('PUT')
                @csrf

                <div class="row g-3">
                  <div class="col-md-4">
                    <div class="form-group mb-2">
                      <label for="currentPassword" class="form-label fw-semibold">Kata Sandi Saat Ini <span class="text-danger">*</span></label>
                      <input name="currentPassword" type="password" minlength="8"
                        class="form-control @error('currentPassword') is-invalid @enderror" id="currentPassword"
                        required placeholder="Masukkan kata sandi saat ini">
                      @error('currentPassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group mb-2">
                      <label for="newpassword" class="form-label fw-semibold">Kata Sandi Baru <span class="text-danger">*</span></label>
                      <input name="newpassword" type="password" minlength="8"
                        class="form-control @error('newpassword') is-invalid @enderror" id="newPassword"
                        placeholder="Minimal 8 karakter" required>
                      @error('newpassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group mb-2">
                      <label for="renewpassword" class="form-label fw-semibold">Konfirmasi Kata Sandi Baru <span class="text-danger">*</span></label>
                      <input name="renewpassword" type="password" minlength="8"
                        class="form-control @error('renewpassword') is-invalid @enderror" id="renewPassword"
                        placeholder="Ulangi kata sandi baru" required>
                      @error('renewpassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="text-end pt-3 border-top mt-4">
                  <button class="btn-kirim" type="submit">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan Kata Sandi
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function openEditModal() {
    Swal.fire({
      title: '<span style="font-family: \'Poppins\', sans-serif; font-weight: 600; font-size: 24px; color: #2d3748;">Edit Profil</span>',
      html: `
        <form id="editProfileForm" action="{{ route('profile.update', $user->id) }}" method="POST">
          @method('PUT')
          @csrf
          
          <div style="text-align: left; margin-bottom: 16px;">
            <label style="display: block; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 500; color: #6b7280; margin-bottom: 6px;">Nama Lengkap :</label>
            <input name="name" type="text" class="swal2-input" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e0; border-radius: 6px; font-family: 'Poppins', sans-serif; font-size: 14px; margin: 0;" value="{{ $userType == 'pengguna' ? $user->full_name : $user->name }}" required>
          </div>
          
          @if($userType == 'user')
          <div style="text-align: left; margin-bottom: 16px;">
            <label style="display: block; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 500; color: #6b7280; margin-bottom: 6px;">Email :</label>
            <input name="email" type="text" class="swal2-input" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e0; border-radius: 6px; font-family: 'Poppins', sans-serif; font-size: 14px; margin: 0; background-color: #f3f4f6;" value="{{ $user->email }}" readonly>
          </div>
          @endif
          
          <div style="text-align: left; margin-bottom: 16px;">
            <label style="display: block; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 500; color: #6b7280; margin-bottom: 6px;">Nomor Telepon :</label>
            <input name="nomer_telepon" type="tel" pattern="^08\\d{10,13}$" class="swal2-input" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e0; border-radius: 6px; font-family: 'Poppins', sans-serif; font-size: 14px; margin: 0;" value="{{ $userType == 'pengguna' ? $user->phone_number : $user->nomer_telepon }}" placeholder="08xxxxxxxxxx" required>
          </div>
          
          @if($userType == 'user')
          <div style="text-align: left; margin-bottom: 16px;">
            <label style="display: block; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 500; color: #6b7280; margin-bottom: 6px;">Alamat :</label>
            <textarea name="alamat" class="swal2-textarea" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e0; border-radius: 6px; font-family: 'Poppins', sans-serif; font-size: 14px; margin: 0; min-height: 80px;" required>{{ $user->alamat }}</textarea>
          </div>
          @endif
        </form>
      `,
      width: '600px',
      showCancelButton: false,
      showConfirmButton: true,
      showCloseButton: true,
      confirmButtonText: 'Simpan',
      customClass: {
        popup: 'edit-profile-popup',
        title: 'edit-profile-title',
        htmlContainer: 'edit-profile-content',
        confirmButton: 'edit-profile-confirm-btn',
        closeButton: 'edit-profile-close-btn'
      },
      buttonsStyling: false,
      didOpen: () => {
        document.querySelector('input[name="name"]').focus();
      },
      preConfirm: () => {
        const form = document.getElementById('editProfileForm');
        const formData = new FormData(form);
        
        const nomorTelepon = formData.get('nomer_telepon');
        if (!/^08\d{10,13}$/.test(nomorTelepon)) {
          Swal.showValidationMessage('Nomor telepon harus diawali dengan 08 dan diikuti 10-13 digit angka');
          return false;
        }
        
        return true;
      }
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('editProfileForm').submit();
      }
    });
  }

  // Sinkronkan rotasi chevron saat event collapse berlangsung
  document.querySelectorAll('.collapse').forEach(function(collapseEl) {
    collapseEl.addEventListener('show.bs.collapse', function () {
      const trigger = document.querySelector('[data-bs-target="#' + this.id + '"]');
      if (trigger) trigger.setAttribute('aria-expanded', 'true');
    });
    collapseEl.addEventListener('hide.bs.collapse', function () {
      const trigger = document.querySelector('[data-bs-target="#' + this.id + '"]');
      if (trigger) trigger.setAttribute('aria-expanded', 'false');
    });
  });
</script>

<style>
  /* Styling Kontainer Profil */
  .profile-container-box {
    border-radius: 12px !important;
    border: 1px solid #e2e8f0 !important;
    overflow: hidden;
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
  }
  .profile-container-box:hover {
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06) !important;
    border-color: #cbd5e1 !important;
  }
  .profile-collapse-trigger {
    cursor: pointer;
    user-select: none;
    transition: background-color 0.2s ease;
  }
  .profile-collapse-trigger:hover {
    background-color: #f8fafc !important;
  }
  .profile-icon-box {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .bg-primary-subtle {
    background-color: #e0f2fe !important;
  }
  .bg-warning-subtle {
    background-color: #fef3c7 !important;
  }
  .toggle-icon {
    transition: transform 0.3s ease;
    display: inline-block;
  }
  .profile-collapse-trigger[aria-expanded="true"] .toggle-icon {
    transform: rotate(180deg);
  }
  .btn-kirim {
    background: #016AA3;
    color: #fff;
    border: none;
    padding: 8px 24px;
    border-radius: 6px;
    font-weight: 500;
    transition: background 0.2s;
  }
  .btn-kirim:hover {
    background: #01507d;
  }

  /* Modal Edit Profile */
  .edit-profile-popup {
    border-radius: 16px !important;
    padding: 32px !important;
  }
  
  .edit-profile-title {
    padding: 0 !important;
    margin-bottom: 24px !important;
  }
  
  .edit-profile-content {
    margin: 0 !important;
    padding: 0 !important;
  }
  
  .edit-profile-confirm-btn {
    background-color: #0369a1 !important;
    color: white !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    padding: 10px 32px !important;
    border-radius: 6px !important;
    border: none !important;
    cursor: pointer !important;
    transition: all 0.2s !important;
    margin-top: 20px !important;
  }
  
  .edit-profile-confirm-btn:hover {
    background-color: #0284c7 !important;
  }
  
  .edit-profile-close-btn {
    background-color: #ef4444 !important;
    color: white !important;
    width: 32px !important;
    height: 32px !important;
    border-radius: 6px !important;
    font-size: 18px !important;
    font-weight: bold !important;
    transition: all 0.2s !important;
  }
  
  .edit-profile-close-btn:hover {
    background-color: #dc2626 !important;
  }
</style>

@endsection
