# CATATAN PERUBAHAN SISTEM E-PKK

Format Log:
`Tanggal | Masalah | File dan baris | Kode lama (ringkas) | Kode baru (ringkas) | Alasan | Cara mengembalikan`

---

## Log Perubahan

### 03-10-2026 | Penyesuaian Skema Tabel Penghayatan (Pokja 1) Tanpa Hapus Data Lama
- **Masalah:** API `POST /api/report/penghayatan` dan web `/decpenghayatan` error (*Unknown column 'kisah_kegiatan' / Undefined property*) karena skema tabel `laporan_penghayatan_n_pengamalan` di database lokal `pkklur` masih memakai 8 kolom lama (`jumlah_kel_simulasi1..4`, `jumlah_anggota1..4`), sedangkan kode Flutter/API/Blade memakai 24 kolom kegiatan (`kisah_`, `krisan_`, `kilas_`, `kiat_`, `kisak_`, `pkbn_` dengan `_kegiatan`, `_vol`, `_metode`, `_sasaran`).
- **File & Baris yang Diubah:**
  1. [`alter_tables.sql`](file:///c:/xampp/htdocs/Website_E-PKK/alter_tables.sql) (Baris 1 - 50):
     - *Lama:* `DROP COLUMN jumlah_kel_simulasi1..4, jumlah_anggota1..4;` dan ALTER `laporan_kader_pokja1` (DROP PKBN, PKDRT, pola_asuh).
     - *Baru:* Baris `DROP COLUMN` di-comment (`--`), 8 kolom lama di-`MODIFY COLUMN ... DEFAULT 0`, dan blok `laporan_kader_pokja1` dinonaktifkan (`--`).
  2. [`app/Http/Controllers/Api/ReportController.php`](file:///c:/xampp/htdocs/Website_E-PKK/app/Http/Controllers/Api/ReportController.php) (Baris 526):
     - *Lama:* `'status' => 'Menunggu',`
     - *Baru:* `// [PERUBAHAN 03-10-2026] disamakan dengan endpoint lain ('Proses'); kode lama di bawah dinonaktifkan`  
       `// 'status' => 'Menunggu',`  
       `'status' => 'Proses',`
- **Perintah SQL yang Dijalankan:**
  ```sql
  -- Dijalankan pada database pkklur via mysql CLI:
  source c:/xampp/htdocs/Website_E-PKK/alter_tables.sql;
  ```
- **Alasan:** Menyelaraskan struktur tabel `laporan_penghayatan_n_pengamalan` dengan form Flutter dan Web Blade tanpa menghapus kolom atau data lama, serta menyelaraskan status awal laporan baru menjadi `'Proses'` agar langsung dapat diproses berjenjang oleh Web Kecamatan dan Kabupaten.
- **Cara Mengembalikan (Rollback):**
  1. Kembalikan file `ReportController.php` dan `alter_tables.sql` via git checkout atau kembalikan baris status ke `'Menunggu'`.
  2. Kembalikan database dari file backup yang telah dibuat:
     ```powershell
     & 'C:\xampp\mysql\bin\mysql.exe' -u root pkklur -e "source C:/Users/ASUS/Documents/pkklur_backup_sebelum_perubahan.sql"
     ```

---

## Daftar ID Data Uji Baru yang Dibuat (`TEST-ANTIGRAVITY`)

- **Penghayatan (Pokja 1):**
  - UUID `KP1B1-6GU13Y` (ID: `7`, status: `Proses`)
  - UUID `KP1B1-G7LYGQ` (ID: `8`, status: `Disetujui2`)
- **Kader Pokja 1:**
  - UUID `KP1-6SQKIG`, UUID `KP1-SOG7YZ` (status: `Proses`)
- **Gotong Royong (Pokja 1):**
  - UUID `KP1B2-U0DQVC`, UUID `KP1B2-NEKOVL` (status: `Proses`)
- **Kader Pokja 3:**
  - UUID `KP3-PLRROS`, UUID `KP3-GGV8BY` (status: `Proses`)
- **Pangan (Pokja 3):**
  - UUID `KP3B1-FIANGJ`, UUID `KP3B1-RRPIPR` (status: `Proses`)
- **Sandang (Pokja 3):**
  - UUID `KP3B2-YY8EXW`, UUID `KP3B2-IBI4RI` (status: `Proses`)
- **Perumahan (Pokja 3):**
  - UUID `KP3B3-HNSCIN`, UUID `KP3B3-Q8ZWW9` (status: `Proses`)

### 03-10-2026 | Perbaikan Upload Galeri (Image Preview Flutter Web & Format WebP API)
- **Masalah:**
  1. Pada Flutter Web/Chrome, aplikasi crash menampilkan layar merah dengan pesan `Assertion failed: !kIsWeb "Image.file is not supported on Flutter Web..."` saat memilih gambar galeri.
  2. Pada API `POST /api/report/galeri`, upload gambar format WebP ditolak validasi karena aturan `mimes` belum menyertakan `webp`.
- **File & Baris yang Diubah:**
  1. [`lib/features/laporan/upload_galeri/upload_galeri_screen.dart`](file:///d:/42.%20SEMESTER%203/project/Mobile_E-PKK/lib/features/laporan/upload_galeri/upload_galeri_screen.dart) (Baris 11 & 396):
     - *Lama:* `child: Image.file(_image!, fit: BoxFit.cover),`
     - *Baru:*
       ```dart
       // [PERUBAHAN 03-10-2026] Mendukung preview gambar di Flutter Web (Chrome); kode lama di bawah dinonaktifkan
       // child: Image.file(_image!, fit: BoxFit.cover),
       child: kIsWeb
           ? Image.network(_image!.path, fit: BoxFit.cover)
           : Image.file(_image!, fit: BoxFit.cover),
       ```
  2. [`app/Http/Controllers/Api/ReportController.php`](file:///c:/xampp/htdocs/Website_E-PKK/app/Http/Controllers/Api/ReportController.php) (Baris 20):
     - *Lama:* `'gambar' => 'required|image|mimes:heic,jpeg,jpg,png,gif',`
     - *Baru:*
       ```php
       // [PERUBAHAN 03-10-2026] Menambahkan format webp pada validasi mimes; kode lama di bawah dinonaktifkan
       // 'gambar' => 'required|image|mimes:heic,jpeg,jpg,png,gif',
       'gambar' => 'required|image|mimes:heic,jpeg,jpg,png,gif,webp',
       ```
- **Alasan:** Memungkinkan Flutter Web menampilkan preview gambar yang dipilih tanpa crash, serta mengizinkan pengguna mengunggah gambar format `.webp` ke server secara aman.
- **Cara Mengembalikan (Rollback):**
  - Di Mobile_E-PKK: kembalikan baris 396 di `upload_galeri_screen.dart` menjadi `child: Image.file(_image!, fit: BoxFit.cover),`.
  - Di Website_E-PKK: kembalikan baris 20 di `ReportController.php` menjadi `'gambar' => 'required|image|mimes:heic,jpeg,jpg,png,gif',`.

### 03-10-2026 | Perubahan Tampilan Galeri -> Kegiatan & Penambahan Fitur Nama Peserta
- **Masalah:**
  1. Istilah "Galeri" perlu disesuaikan menjadi "Kegiatan" pada seluruh tampilan antarmuka (Mobile & Website).
  2. Dibutuhkan kemampuan mencatat dan menampilkan banyak nama peserta untuk setiap kegiatan.
- **Perubahan Skema Database:**
  - Cadangan database dibuat ke: `C:\Users\ASUS\Documents\pkklur_backup_sebelum_kegiatan.sql`
  - Perintah SQL yang dijalankan:
    ```sql
    ALTER TABLE `galerys` ADD COLUMN `nama_peserta` TEXT NULL AFTER `deskripsi`;
    ```
- **File & Baris yang Diubah:**
  1. **Mobile (Flutter):**
     - [`lib/features/home/home_screen.dart`](file:///d:/42.%20SEMESTER%203/project/Mobile_E-PKK/lib/features/home/home_screen.dart): Mengubah teks subtitle button menjadi "upload kegiatan PKK disini".
     - [`lib/features/laporan/upload_galeri/upload_galeri_model.dart`](file:///d:/42.%20SEMESTER%203/project/Mobile_E-PKK/lib/features/laporan/upload_galeri/upload_galeri_model.dart): Menambahkan field `namaPeserta` pada `GaleriEntry`.
     - [`lib/features/laporan/upload_galeri/upload_galerii_controller.dart`](file:///d:/42.%20SEMESTER%203/project/Mobile_E-PKK/lib/features/laporan/upload_galeri/upload_galerii_controller.dart): Menambahkan parameter `namaPeserta` pada `submitDataGaleri`.
     - [`lib/features/laporan/upload_galeri/upload_galeri_screen.dart`](file:///d:/42.%20SEMESTER%203/project/Mobile_E-PKK/lib/features/laporan/upload_galeri/upload_galeri_screen.dart): Menambahkan input Nama Peserta, tombol Tambah, daftar chip peserta dengan tombol hapus, validasi nama kosong/duplikat, dan judul "Upload Kegiatan".
  2. **API (Laravel):**
     - [`app/Http/Controllers/Api/ReportController.php`](file:///c:/xampp/htdocs/Website_E-PKK/app/Http/Controllers/Api/ReportController.php): Menerima dan menyimpan `nama_peserta` (JSON array) pada `insertGaleri` serta mengembalikannya pada respons.
  3. **Website Backend (Laravel):**
     - [`resources/views/backend/layouts/sidebar.blade.php`](file:///c:/xampp/htdocs/Website_E-PKK/resources/views/backend/layouts/sidebar.blade.php) & `includes/sidebar.blade.php`: Mengganti teks label menu sidebar menjadi "Kegiatan".
     - Semua view tabel (`resources/views/backend/galeri*.blade.php`): Mengubah judul heading dan menambahkan kolom tabel "Nama Peserta" (data JSON di-render menjadi daftar bernomor, data lama bernilai NULL tampil "-").
     - Semua view review (`resources/views/backend/tampil_galeri*.blade.php`): Menambahkan textarea daftar nama peserta.
     - Semua controller backend (`app/Http/Controllers/backend/Galeri*.php`): Memperbarui method `update()` agar menyimpan pembaruan `nama_peserta`.
     - Semua view cetak (`resources/views/backend/cetak_galeri*.blade.php`): Menambahkan kolom Nama Peserta pada tabel cetak.
- **Alasan:** Memenuhi permintaan revisi untuk mengganti nama fitur menjadi Kegiatan dan mencatat banyak nama peserta per kegiatan secara dinamis dan aman tanpa merusak struktur kode lama.
- **Cara Mengembalikan (Rollback):**
  1. Kembalikan kode via `git checkout` pada kedua repository.
  2. Kembalikan struktur database dari file backup:
     ```powershell
     & 'C:
mpp\mysql\bin\mysql.exe' -u root pkklur -e "source C:/Users/ASUS/Documents/pkklur_backup_sebelum_kegiatan.sql"
     ```

### 03-10-2026 | Penyesuaian baseUrl Flutter untuk Android Emulator Lokal
- **Masalah:** Saat tombol "Kirim" ditekan di aplikasi mobile via Android Emulator, muncul error `"Gagal upload galeri"` karena `baseUrl` masih mengarah ke `http://127.0.0.1:8000/api` (loopback internal Android VM), sehingga request gagal menjangkau server Laravel di laptop host.
- **File & Baris yang Diubah:**
  - [`lib/core/api_helper.dart`](file:///d:/42.%20SEMESTER%203/project/Mobile_E-PKK/lib/core/api_helper.dart) (Baris 6):
    - *Lama:* `baseUrl: 'http://127.0.0.1:8000/api',`
    - *Baru:*
      ```dart
      // [PERUBAHAN 03-10-2026] Menggunakan 10.0.2.2 untuk Android Emulator lokal; kode lama dinonaktifkan
      // baseUrl: 'http://127.0.0.1:8000/api',
      baseUrl: 'http://10.0.2.2:8000/api',
      ```
- **Catatan Penting:** Pengaturan `10.0.2.2` ini HANYA berlaku khusus saat menguji di Android Emulator resmi Google pada laptop yang sama. Sebelum build rilis (APK/AAB) atau jika dijalankan di HP fisik/Chrome, `baseUrl` wajib dikembalikan ke `https://epkknganjuk.pbltifnganjuk.com/api` (server hosting) atau IP LAN WiFi laptop.
- **Alasan:** Memungkinkan aplikasi di Android Emulator dapat berkomunikasi langsung dengan backend Laravel lokal di laptop tanpa `Connection refused`.
- **Cara Mengembalikan (Rollback):** Kembalikan baris `baseUrl` di `lib/core/api_helper.dart` ke URL hosting atau `127.0.0.1`.

### 03-10-2026 | Kompatibilitas Upload File Multipart di Flutter Web (Browser Chrome)
- **Masalah:** Saat tombol "Kirim" ditekan di Flutter Web (Chrome), muncul error `"Gagal upload galeri"` karena penggunaan `dio.MultipartFile.fromFile(path)` yang tidak didukung pada platform browser.
- **File & Baris yang Diubah:**
  1. [`lib/features/laporan/upload_galeri/upload_galeri_screen.dart`](file:///d:/42.%20SEMESTER%203/project/Mobile_E-PKK/lib/features/laporan/upload_galeri/upload_galeri_screen.dart):
     - Membaca byte gambar (`await pickedFile.readAsBytes()`) dan nama file (`pickedFile.name`) saat foto dipilih.
     - Meneruskan `gambarBytes` dan `namaFile` ke method `submitDataGaleri`.
  2. [`lib/features/laporan/upload_galeri/upload_galerii_controller.dart`](file:///d:/42.%20SEMESTER%203/project/Mobile_E-PKK/lib/features/laporan/upload_galeri/upload_galerii_controller.dart):
     - Menerima parameter `Uint8List? gambarBytes` dan `String? namaFile`.
     - Menggunakan `dio.MultipartFile.fromBytes(gambarBytes, filename: ...)` saat `kIsWeb`, sedangkan pada platform mobile/desktop tetap menggunakan `dio.MultipartFile.fromFile(gambar)`:
       ```dart
       // [PERUBAHAN 03-10-2026] Mendukung upload di Flutter Web menggunakan fromBytes; kode lama di bawah dinonaktifkan
       // final file = await dio.MultipartFile.fromFile(gambar);
       final dio.MultipartFile file = (kIsWeb && gambarBytes != null)
           ? dio.MultipartFile.fromBytes(gambarBytes, filename: namaFile ?? 'upload.jpg')
           : await dio.MultipartFile.fromFile(gambar);
       ```
- **Alasan:** Memungkinkan upload kegiatan dan foto bekerja 100% lancar baik saat dijalankan di browser (Chrome/Web) maupun di mobile/desktop tanpa `UnsupportedError`.
- **Cara Mengembalikan (Rollback):** Kembalikan `upload_galeri_screen.dart` dan `upload_galerii_controller.dart` ke versi sebelumnya via git.

### 03-10-2026 | Perapian Format Kolom Ekspor Google Sheets Pokja 1
- **Masalah:** Hasil ekspor spreadsheet untuk Pokja 1 semrawut karena data yang dikirim adalah dump mentah database (`SELECT *`) yang memuat kolom teknis (`uuid`, `id_*`, `created_at`, `updated_at`), nama kolom bahasa teknis database, tidak memiliki urutan logis, dan tanggal tidak diformat `d-m-Y`.
- **File & Baris yang Diubah:**
  1. [`app/Http/Controllers/backend/Pokja1Controller.php`](file:///c:/xampp/htdocs/Website_E-PKK/app/Http/Controllers/backend/Pokja1Controller.php) (Baris 406-488):
     - Memetakan data ekspor secara terstruktur dengan urutan logis: `No`, `Tanggal Laporan` (format `d-m-Y`), `Kecamatan`, `Desa / Kelurahan`, kolom-kolom kegiatan/kader dengan label bahasa Indonesia formal, `Catatan`, dan `Status`.
     - Membuang kolom teknis database (`uuid`, `id_*`, `created_at`, `updated_at`, dan 8 kolom lama simulasi).
     - Menuliskan komentar `// [PERUBAHAN 03-10-2026] Merapikan pemetaan kolom ekspor Pokja 1; kode lama di bawah dinonaktifkan`.
  2. [`resources/views/backend/pokja1.blade.php`](file:///c:/xampp/htdocs/Website_E-PKK/resources/views/backend/pokja1.blade.php) (Baris 128 & 147):
     - Memperbarui tautan spreadsheet tujuan (`SHEET_HREF`) ke spreadsheet target Pokja 1 yang baru (`https://docs.google.com/spreadsheets/d/15eG1L1kuDMbnSsbm3T-Z_e5A4FKINH0ExettHIuZBys/edit`).
- **Alasan:** Menyajikan data ekspor Pokja 1 yang bersih, rapi, mudah dibaca, dan siap cetak di Google Sheets tanpa kolom teknis internal.
- **Cara Mengembalikan (Rollback):** Kembalikan perubahan pada `Pokja1Controller.php` dan `pokja1.blade.php` via git checkout.

### 03-10-2026 | Perapian Format Kolom Ekspor Google Sheets Pokja 2, 3, 4, dan Bidang Umum
- **Masalah:** Ekspor spreadsheet Pokja 2, Pokja 3, Pokja 4, dan Bidang Umum masih mengirim dump kolom teknis database mentah (`uuid`, `id_*`, `created_at`, `updated_at`) atau format yang belum seragam dengan UI/cetak. Spreadsheet Pokja 1 juga sempat tidak terisi karena izin deployment Web App Google Apps Script belum diset ke *Anyone*.
- **File & Baris yang Diubah:**
  1. [`app/Http/Controllers/backend/Pokja2Controller.php`](file:///c:/xampp/htdocs/Website_E-PKK/app/Http/Controllers/backend/Pokja2Controller.php):
     - Memetakan data ekspor `pendidikan` dan `pengembangan` dengan header bahasa Indonesia resmi, urutan logis, `No`, `Tanggal Laporan` (format `d-m-Y`), `Kecamatan`, `Desa / Kelurahan`, `Catatan`, dan `Status`.
     - Menuliskan komentar `// [PERUBAHAN 03-10-2026] Merapikan pemetaan kolom ekspor Pokja 2; kode lama di bawah dinonaktifkan`.
  2. [`app/Http/Controllers/backend/Pokja3Controller.php`](file:///c:/xampp/htdocs/Website_E-PKK/app/Http/Controllers/backend/Pokja3Controller.php):
     - Memetakan data ekspor `pangan`, `sandang`, `perumahan`, dan `kader` dengan format terstruktur.
     - Menuliskan komentar `// [PERUBAHAN 03-10-2026] Merapikan pemetaan kolom ekspor Pokja 3; kode lama di bawah dinonaktifkan`.
  3. [`app/Http/Controllers/backend/Pokja4Controller.php`](file:///c:/xampp/htdocs/Website_E-PKK/app/Http/Controllers/backend/Pokja4Controller.php):
     - Memetakan data ekspor `kesehatan`, `kelestarian`, `perencanaan`, `kader`, dan sub-bidang inovasi prioritas/unggulan (`rekap_bulanan`, `rekap_tahunan`, `posyandu`, `kegiatan_pokja4`).
     - Menuliskan komentar `// [PERUBAHAN 03-10-2026] Merapikan pemetaan kolom ekspor Pokja 4; kode lama di bawah dinonaktifkan`.
  4. [`app/Http/Controllers/backend/BidangUmumController.php`](file:///c:/xampp/htdocs/Website_E-PKK/app/Http/Controllers/backend/BidangUmumController.php):
     - Mengubah sumber query ke tabel `galerys` khusus bidang Laporan Umum/Bidang Umum dengan kolom: `No`, `Tanggal` (`d-m-Y`), `Kecamatan`, `Desa`, `Nama Kegiatan`, `Nama Peserta` (digabung koma), `Lokasi`, `Status`.
     - Menuliskan komentar `// [PERUBAHAN 03-10-2026] Menggunakan tabel galerys untuk ekspor Bidang Umum sesuai format kegiatan (No, Tanggal, Kecamatan, Desa, Nama Kegiatan, Nama Peserta, Lokasi, Status); kode lama query laporan_umum dinonaktifkan`.
- **Alasan:** Menyeragamkan seluruh struktur data ekspor agar rapi, mudah dibaca, dan bebas dari kolom teknis database di semua Pokja dan Bidang Umum.
- **Cara Mengembalikan (Rollback):** Kembalikan file controller via `git checkout`.