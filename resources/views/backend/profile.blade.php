@extends('backend.layouts.template')

@section('content1')

<main id="main" class="main">

  <section class="section">
    <div class="row align-items-stretch">
      {{-- KOLOM KIRI: INFORMASI PRIBADI --}}
      <div class="col-lg-6 mb-4 d-flex flex-column">
        <h1 class="page-heading">Informasi Pribadi</h1>

        @if ($message = Session::get('success'))
          <div class="alert alert-success" role="alert">
            {{ $message }}
          </div>
        @endif

        <div class="form-card flex-grow-1 d-flex flex-column justify-content-between">
          <div class="info-content">
            <div class="row py-3 border-bottom" style="border-color: #f1f5f9 !important;">
              <div class="col-sm-4 col-5" style="font-weight: 500; color: #64748b;">Nama lengkap :</div>
              <div class="col-sm-8 col-7" style="color: #1e293b; font-weight: 600;">
                {{ $userType == 'pengguna' ? $user->full_name : $user->name }}
              </div>
            </div>
            
            @if($userType == 'user')
              <div class="row py-3 border-bottom" style="border-color: #f1f5f9 !important;">
                <div class="col-sm-4 col-5" style="font-weight: 500; color: #64748b;">Email :</div>
                <div class="col-sm-8 col-7" style="color: #1e293b; font-weight: 600;">{{ $user->email }}</div>
              </div>
            @endif
            
            <div class="row py-3 border-bottom" style="border-color: #f1f5f9 !important;">
              <div class="col-sm-4 col-5" style="font-weight: 500; color: #64748b;">Nomor telepon :</div>
              <div class="col-sm-8 col-7" style="color: #1e293b; font-weight: 600;">
                {{ $userType == 'pengguna' ? $user->phone_number : $user->nomer_telepon }}
              </div>
            </div>
            
            @if($userType == 'user')
              <div class="row py-3" style="border-color: #f1f5f9 !important;">
                <div class="col-sm-4 col-5" style="font-weight: 500; color: #64748b;">Alamat :</div>
                <div class="col-sm-8 col-7" style="color: #1e293b; font-weight: 600;">{{ $user->alamat }}</div>
              </div>
            @endif
          </div>

          <div class="text-end mt-auto pt-4">
            <button class="btn-kirim" type="button" onclick="openEditModal()">Edit</button>
          </div>
        </div>
      </div>

      {{-- KOLOM KANAN: UBAH KATA SANDI --}}
      <div class="col-lg-6 mb-4 d-flex flex-column">
        <h1 class="page-heading">Ubah kata sandi</h1>

        @if ($message = Session::get('successs'))
          <div class="alert alert-success" role="alert">
            {{ $message }}
          </div>
        @endif

        @if ($message = Session::get('error'))
          <div class="alert alert-danger" role="alert">
            {{ $message }}
          </div>
        @endif

        <div class="form-card flex-grow-1 d-flex flex-column justify-content-between">
          <form action="{{ route('change_password.update', $user->id) }}" method="POST" class="h-100 d-flex flex-column justify-content-between">
            @method('PUT')
            @csrf

            <div class="password-inputs">
              <div class="form-group">
                <label for="currentPassword" class="form-label">Masukkan Kata Sandi</label>
                <input name="currentPassword" type="password" minlength="8"
                  class="form-control @error('currentPassword') is-invalid @enderror" id="currentPassword"
                  required placeholder="Masukkan kata sandi saat ini">
                @error('currentPassword')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="newpassword" class="form-label">Masukkan Kata Sandi Baru</label>
                <input name="newpassword" type="password" minlength="8"
                  class="form-control @error('newpassword') is-invalid @enderror" id="newPassword"
                  placeholder="Masukkan kata sandi baru" required>
                @error('newpassword')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="renewpassword" class="form-label">Konfirmasi Kata Sandi Baru</label>
                <input name="renewpassword" type="password" minlength="8"
                  class="form-control @error('renewpassword') is-invalid @enderror" id="renewPassword"
                  placeholder="Konfirmasi kata sandi anda" required>
                @error('renewpassword')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="text-end mt-auto pt-3">
              <button class="btn-kirim" type="submit">Simpan</button>
            </div>
          </form>
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
        // Focus pada input pertama
        document.querySelector('input[name="name"]').focus();
      },
      preConfirm: () => {
        const form = document.getElementById('editProfileForm');
        const formData = new FormData(form);
        
        // Validasi nomor telepon
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
</script>

<style>
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
