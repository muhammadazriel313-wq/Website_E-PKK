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

---

### 09-10-2026 | Migrasi Tautan Google Sheets & Apps Script ke Environment Variables (.env)
- **Masalah:** URL Google Apps Script dan Google Spreadsheet sebelumnya di-hardcode di dalam controller dan view Blade Pokja 1, 2, 3, 4, dan Bidang Umum sehingga pengguna tidak dapat menggunakan Spreadsheet dan Apps Script milik sendiri secara fleksibel.
- **File & Baris yang Diubah:**
  1. [`config/services.php`](file:///c:/xampp/htdocs/Website_E-PKK/config/services.php) (Baris 34-39):
     - Menambahkan konfigurasi `'sheets' => ['script_url' => env('SHEETS_APPS_SCRIPT_URL'), 'spreadsheet_url' => env('SHEETS_SPREADSHEET_URL')]`.
     - Label: `// [PERUBAHAN 2026-10-09] Konfigurasi integrasi Google Sheets & Google Apps Script`.
  2. [`.env.example`](file:///c:/xampp/htdocs/Website_E-PKK/.env.example) (Baris 63-65):
     - Menambahkan variabel kosong `SHEETS_APPS_SCRIPT_URL=` dan `SHEETS_SPREADSHEET_URL=`.
  3. [`app/Http/Controllers/backend/Pokja1ExportController.php`](file:///c:/xampp/htdocs/Website_E-PKK/app/Http/Controllers/backend/Pokja1ExportController.php) (Baris 15-24):
     - Mengganti URL hardcode dengan `config('services.sheets.script_url')` serta menambahkan validasi jika kosong.
     - Label: `// [PERUBAHAN 2026-10-09] Mengambil URL Apps Script dari config services; URL hardcode dinonaktifkan`.
  4. [`app/Http/Controllers/backend/Pokja4ExportController.php`](file:///c:/xampp/htdocs/Website_E-PKK/app/Http/Controllers/backend/Pokja4ExportController.php) (Baris 75-84):
     - Mengganti URL hardcode dengan `config('services.sheets.script_url')` serta menambahkan validasi jika kosong.
     - Label: `// [PERUBAHAN 2026-10-09] Mengambil URL Apps Script dari config services; URL hardcode dinonaktifkan`.
  5. [`resources/views/backend/pokja1.blade.php`](file:///c:/xampp/htdocs/Website_E-PKK/resources/views/backend/pokja1.blade.php) (Baris 128-154 & 198-245):
     - Mengganti link spreadsheet dan script URL dengan `{{ config('services.sheets.spreadsheet_url') }}` dan `{{ config('services.sheets.script_url') }}`.
     - Menambahkan validasi SweetAlert jika URL belum diatur di `.env`, serta menyertakan metadata `pokja: 'POKJA 1'`.
     - Label: `[PERUBAHAN 2026-10-09]`.
  6. [`resources/views/backend/pokja2.blade.php`](file:///c:/xampp/htdocs/Website_E-PKK/resources/views/backend/pokja2.blade.php) (Baris 129-148 & 200-248):
     - Mengganti link spreadsheet dan script URL dengan `config('services.sheets.*')`.
     - Menambahkan validasi SweetAlert jika URL belum diatur di `.env`, serta menyertakan metadata `pokja: 'POKJA 2'`.
     - Label: `[PERUBAHAN 2026-10-09]`.
  7. [`resources/views/backend/pokja3.blade.php`](file:///c:/xampp/htdocs/Website_E-PKK/resources/views/backend/pokja3.blade.php) (Baris 149-168 & 216-256):
     - Mengganti link spreadsheet dan script URL dengan `config('services.sheets.*')`.
     - Menambahkan validasi SweetAlert jika URL belum diatur di `.env`, serta menyertakan metadata `pokja: 'POKJA 3'`.
     - Label: `[PERUBAHAN 2026-10-09]`.
  8. [`resources/views/backend/pokja4.blade.php`](file:///c:/xampp/htdocs/Website_E-PKK/resources/views/backend/pokja4.blade.php) (Baris 199-218 & 273-301):
     - Mengganti link spreadsheet dan script URL dengan `config('services.sheets.*')`.
     - Menambahkan validasi SweetAlert jika URL belum diatur di `.env`, serta menyertakan metadata `pokja: 'POKJA 4'`.
     - Label: `[PERUBAHAN 2026-10-09]`.
  9. [`resources/views/backend/accbidangumum.blade.php`](file:///c:/xampp/htdocs/Website_E-PKK/resources/views/backend/accbidangumum.blade.php) (Baris 134-158 & 198-232):
     - Mengganti link spreadsheet dan script URL dengan `config('services.sheets.*')`.
     - Menambahkan validasi SweetAlert jika URL belum diatur di `.env`, serta menyertakan metadata `pokja: 'BIDANG UMUM'`.
     - Label: `[PERUBAHAN 2026-10-09]`.
  10. [`apps_script/Code.gs`](file:///c:/xampp/htdocs/Website_E-PKK/apps_script/Code.gs) & [`apps_script/PANDUAN.md`](file:///c:/xampp/htdocs/Website_E-PKK/apps_script/PANDUAN.md):
     - Membuat file fungsi Apps Script `doPost(e)` lengkap dengan deduplikasi periode, penamaan tab dinamis, formatting header, pengembalian direct-tab URL (`#gid=sheetId`), serta panduan penerapan.
   11. Fitur Navigasi Langsung ke Tab Sheet (`#gid`):
      - Diterapkan pada seluruh tampilan ekspor (`pokja1.blade.php`, `pokja2.blade.php`, `pokja3.blade.php`, `pokja4.blade.php`, `accbidangumum.blade.php`).
      - Setelah ekspor sukses, tombol SweetAlert otomatis mengarah ke tab sheet yang tepat (`#gid=...`) sehingga pengguna langsung diarahkan ke tab yang relevan tanpa harus menggeser atau mencari tab di Google Sheets.
- **Alasan:** Memungkinkan penggunaan spreadsheet dan Google Apps Script milik sendiri tanpa mengubah struktur database/API mobile dan mencegah error/crash jika URL belum diatur di `.env`.
- **Cara Mengembalikan (Rollback):** Kembalikan file-file yang diubah via `git checkout` dan hapus folder `apps_script/`.

---

### 09-10-2026 | TAHAP 1 - AUDIT KESESUAIAN HEADER VIEW CETAK PDF VS HALAMAN WEB

- **Tujuan Audit:** Membandingkan seluruh header tabel di view cetak PDF (`cetak_bulan_*` dan `cetak_tahun_*`) dengan header tabel pada halaman web acuan (`dec*` dan `tampil_*`) untuk Bidang Umum dan Pokja 1 s/d 4.
- **Tabel Hasil Audit:**

| Bidang | Sub-Laporan | File Cetak | File Web (Acuan) | Selisih Header & Data | Cocok/Tidak |
| :--- | :--- | :--- | :--- | :--- | :---: |
| **Bidang Umum** | Laporan Bidang Umum | `cetak_bulan_bidangumum.blade.php`<br>`cetak_tahun_bidangumum.blade.php` | `decbidangumum.blade.php`<br>`tampil_bidangumum.blade.php` | 1. Kolom `Desa` hilang di cetak.<br>2. Kolom `PKK RT` (`PKK_RT`) hilang di cetak.<br>3. Header cetak flat 1 baris, sedangkan web hierarki grup 3 baris (`JUMLAH KELOMPOK`, `JUMLAH`, `JUMLAH JIWA`, `JUMLAH KADER`, `JUMLAH TENAGA SEKRETARIAT`).<br>4. Controller `BidangUmumController@filter` belum join ke tabel `village`. | **Tidak** |
| **Pokja 1** | Penghayatan dan Pengamalan Pancasila | `cetak_bulan_pokja1.blade.php`<br>`cetak_tahun_pokja1.blade.php` | `decpenghayatan.blade.php`<br>`tampil_penghayatan.blade.php` | 1. Kolom `Desa` hilang di cetak.<br>2. Label sub-kolom disingkat (`Keg`, `Vol`, `Metode`, `Sasaran` vs web: `Kegiatan`, `Vol. Keg`, `Metode`, `Jml Sasaran`).<br>3. Controller `Pokja1Controller@cetak` belum join ke tabel `village`. | **Tidak** |
| **Pokja 1** | Gotong Royong | `cetak_bulan_pokja1.blade.php`<br>`cetak_tahun_pokja1.blade.php` | `decgotongroyong.blade.php`<br>`tampil_gotongroyong.blade.php` | 1. **FATAL**: Tabel Gotong Royong **hilang total** di view cetak (tidak dirender sama sekali).<br>2. Kolom `Desa` belum ter-join di controller. | **Tidak** |
| **Pokja 1** | Kader Pokja 1 | `cetak_bulan_pokja1.blade.php`<br>`cetak_tahun_pokja1.blade.php` | `declaporanpokja1.blade.php`<br>`tampil_laporanpokja1.blade.php` | 1. Kolom `Desa` hilang di cetak.<br>2. Controller `Pokja1Controller@cetak` belum join ke tabel `village`. | **Tidak** |
| **Pokja 2** | Pendidikan dan Keterampilan | `cetak_bulan_pokja2.blade.php`<br>`cetak_tahun_pokja2.blade.php` | `decpendidikan.blade.php`<br>`tampil_pendidikan.blade.php` | 1. Kolom `Desa` hilang di cetak.<br>2. Kolom `Keterangan` hilang di cetak.<br>3. Header hierarki grup (`BKB`, `KADER KHUSUS`, `JUMLAH KADER YANG SUDAH DILATIH`) flat di cetak.<br>4. Controller `Pokja2Controller@cetak` belum join ke tabel `village`. | **Tidak** |
| **Pokja 2** | Pengembangan Kehidupan Berkoperasi | `cetak_bulan_pokja2.blade.php`<br>`cetak_tahun_pokja2.blade.php` | `decpengembangan.blade.php`<br>`tampil_pengembangan.blade.php` | 1. Kolom `Desa` hilang di cetak.<br>2. Kolom `Keterangan` (`catatan`) hilang di cetak.<br>3. Header grup (`PRAKOPERASI / USAHA BERSAMA / UP2K` & `KOPERASI BERBADAN HUKUM`) flat di cetak.<br>4. Controller `Pokja2Controller@cetak` belum join ke tabel `village`. | **Tidak** |
| **Pokja 3** | Pangan | `cetak_bulan_pokja3.blade.php`<br>`cetak_tahun_pokja3.blade.php` | `decpangan.blade.php`<br>`tampil_pangan.blade.php` | 1. Kolom `Desa` hilang di cetak.<br>2. Header grup (`MAKANAN POKOK`, `PEMANFAATAN PEKARANGAN / HATINYA PKK`, `TANAMAN LAINNYA`) flat di cetak.<br>3. Controller `Pokja3Controller@cetak` belum join ke tabel `village`. | **Tidak** |
| **Pokja 3** | Sandang | `cetak_bulan_pokja3.blade.php`<br>`cetak_tahun_pokja3.blade.php` | `decsandang.blade.php`<br>`tampil_sandang.blade.php` | 1. Kolom `Desa` hilang di cetak.<br>2. Header grup `JUMLAH INDUSTRI RUMAH TANGGA` flat di cetak.<br>3. Controller `Pokja3Controller@cetak` belum join ke tabel `village`. | **Tidak** |
| **Pokja 3** | Perumahan dan Tata Laksana Rumah Tangga | `cetak_bulan_pokja3.blade.php`<br>`cetak_tahun_pokja3.blade.php` | `decperumahan.blade.php`<br>`tampil_perumahan.blade.php` | 1. Kolom `Desa` hilang di cetak.<br>2. Header induk `JUMLAH RUMAH` dan teks label `SEHAT & LAYAK HUNI` / `TIDAK SEHAT & TIDAK LAYAK HUNI` berbeda.<br>3. Controller `Pokja3Controller@cetak` belum join ke tabel `village`. | **Tidak** |
| **Pokja 3** | Kader Pokja 3 | `cetak_bulan_pokja3.blade.php`<br>`cetak_tahun_pokja3.blade.php` | `declaporanpokja3.blade.php`<br>`tampil_laporanpokja3.blade.php` | 1. Kolom `Desa` hilang di cetak.<br>2. Header induk `JUMLAH KADER` flat di cetak.<br>3. Sub-kolom ke-3 di web tertulis `Jasa` (database `tata_laksana_rumah`), di cetak tertulis `Tata Laksana Rumah`.<br>4. Controller `Pokja3Controller@cetak` belum join ke tabel `village`. | **Tidak** |
| **Pokja 4** | Kesehatan | `cetak_bulan_pokja4.blade.php`<br>`cetak_tahun_pokja4.blade.php` | `deckesehatan.blade.php`<br>`tampil_kesehatan.blade.php` | 1. Kolom `Desa` hilang di cetak.<br>2. Kolom `Keterangan` (`catatan`) hilang di cetak.<br>3. Header grup `Posyandu (Jumlah, Terintegrasi, Lansia: Jml Klp, Jml Anggota, Jml yg Memiliki Kartu Berobat Gratis)` flat di cetak.<br>4. Controller `Pokja4Controller@cetak` belum join ke tabel `village`. | **Tidak** |
| **Pokja 4** | Kelestarian Lingkungan Hidup | `cetak_bulan_pokja4.blade.php`<br>`cetak_tahun_pokja4.blade.php` | `deckelestarian.blade.php`<br>`tampil_kelestarian_lingkungan_hidup.blade.php` | 1. Kolom `Desa` hilang di cetak.<br>2. Kolom `Keterangan` (`catatan`) hilang di cetak.<br>3. Header grup 3 tingkat (`Jumlah Rumah yang Memiliki`, `Jumlah MCK`, `Jumlah KK yang Menggunakan Air`) flat di cetak.<br>4. Controller `Pokja4Controller@cetak` belum join ke tabel `village`. | **Tidak** |
| **Pokja 4** | Perencanaan Sehat | `cetak_bulan_pokja4.blade.php`<br>`cetak_tahun_pokja4.blade.php` | `decperencanaan.blade.php`<br>`tampil_perencanaan_sehat.blade.php` | 1. Kolom `Desa` hilang di cetak.<br>2. Kolom `Keterangan` (`catatan`) hilang di cetak.<br>3. Teks label berbeda (`Jumlah PUS`, `Jumlah WUS`, `Jumlah Aseptor KB L/P`, `Jumlah KK yang Memiliki Tabungan` vs `Perempuan Subur`, `Wanita Subur`, `KB Pria`, `KB Wanita`, `KK TBG`).<br>4. Controller `Pokja4Controller@cetak` belum join ke tabel `village`. | **Tidak** |
| **Pokja 4** | Kader Pokja 4 | `cetak_bulan_pokja4.blade.php`<br>`cetak_tahun_pokja4.blade.php` | `declaporanpokja4.blade.php`<br>`tampil_laporanpokja4.blade.php` | 1. Kolom `Desa` hilang di cetak.<br>2. Kolom `Keterangan` (`catatan`) hilang di cetak.<br>3. Header induk `Jumlah Kader` flat di cetak, teks disingkat `Peny. Narkoba`.<br>4. Controller `Pokja4Controller@cetak` belum join ke tabel `village`. | **Tidak** |
| **Pokja 4** | Inovasi: Rekap Desa Bulanan | `cetak_bulan_pokja4.blade.php`<br>`cetak_tahun_pokja4.blade.php` | `prioritas_bulanan.blade.php`<br>`unggulan_bulanan.blade.php` | 1. Kolom `Desa` hilang di cetak.<br>2. Kolom `Kategori` ditambahkan di cetak.<br>3. Header grup hierarki flat di cetak.<br>4. Controller `Pokja4Controller@cetak` belum join ke tabel `village`. | **Tidak** |
| **Pokja 4** | Inovasi: Rekap Desa Tahunan | `cetak_bulan_pokja4.blade.php`<br>`cetak_tahun_pokja4.blade.php` | `prioritas_tahunan.blade.php`<br>`unggulan_tahunan.blade.php` | 1. Kolom `Desa` hilang di cetak.<br>2. Kolom `Kategori` ditambahkan di cetak.<br>3. Header grup hierarki flat di cetak.<br>4. Controller `Pokja4Controller@cetak` belum join ke tabel `village`. | **Tidak** |
| **Pokja 4** | Inovasi: Posyandu | `cetak_bulan_pokja4.blade.php`<br>`cetak_tahun_pokja4.blade.php` | `prioritas_posyandu.blade.php`<br>`unggulan_posyandu.blade.php` | 1. Kolom `Desa` hilang di cetak.<br>2. Kolom `Kategori` ditambahkan di cetak.<br>3. Header grup hierarki flat di cetak.<br>4. Controller `Pokja4Controller@cetak` belum join ke tabel `village`. | **Tidak** |
| **Pokja 4** | Inovasi: Kegiatan Pokja 4 | `cetak_bulan_pokja4.blade.php`<br>`cetak_tahun_pokja4.blade.php` | `prioritas_pokja4.blade.php`<br>`unggulan_pokja4.blade.php` | 1. Kolom `Desa` hilang di cetak.<br>2. Kolom `Kategori` ditambahkan di cetak.<br>3. Header grup hierarki flat di cetak.<br>4. Controller `Pokja4Controller@cetak` belum join ke tabel `village`. | **Tidak** |

- **Kesimpulan Audit:** Terdapat **18 sub-laporan** dengan lebih dari **30 titik selisih** signifikan (kolom `Desa` hilang di semua view cetak, kolom `PKK RT` hilang di Bidang Umum, tabel `Gotong Royong` hilang total di Pokja 1, kolom `Keterangan` hilang di berbagai Pokja, serta hilangnya hierarki `colspan`/`rowspan` header grup).

---

### 09-10-2026 | TAHAP 2 - PERBAIKAN DAN PENYELARASAN SELURUH HEADER & VIEW CETAK PDF (BIDANG UMUM, POKJA 1, 2, 3, 4)

- **Masalah:** Ketidaksesuaian header, hilangnya kolom wilayah (Desa), kolom data (PKK RT, Catatan/Keterangan), dan hilangnya tabel Gotong Royong pada hasil cetak PDF laporan bulanan dan tahunan jika dibandingkan dengan halaman web acuan (`dec*` dan `tampil_*`).
- **Aturan Implementasi:**
  1. Halaman web acuan (`dec*` dan `tampil_*`) TIDAK diubah sama sekali.
  2. Kolom wilayah: Menampilkan Kecamatan + Desa jika login admin Kabupaten (`Auth::guard('web')->check()`), atau Desa saja jika login Kecamatan (`Auth::guard('pengguna')->check()`).
  3. Join village: `leftJoin('village', 'users_mobile.id_village', '=', 'village.id')` dan `select 'village.name as nama_desa'`.
  4. Header (colspan, rowspan, hierarki, label) dan baris data identik persis dengan web acuan.
  5. Format kertas A4 landscape responsif dengan `@media print` CSS tanpa memotong kolom.
  6. Kode lama di-comment dengan label `[PERUBAHAN 2026-10-09]`.

#### 1. Bidang Umum
- **File Diubah:**
  - `app/Http/Controllers/backend/BidangUmumController.php` (method `filter`): Menambahkan `leftJoin('village', ...)` dan `'village.name as nama_desa'`.
  - `resources/views/backend/cetak_bulan_bidangumum.blade.php` & `resources/views/backend/cetak_tahun_bidangumum.blade.php`: Header berjenjang 3 tingkat (`JUMLAH KELOMPOK`, `JUMLAH`, `JUMLAH JIWA`, `JUMLAH KADER`, `JUMLAH TENAGA SEKRETARIAT`), kolom Desa, kolom PKK RT (`PKK_RT`), baris data, dan total footer diselaraskan persis dengan `decbidangumum.blade.php`.
- **Hasil Uji:** LULUS.

#### 2. Pokja 1
- **File Diubah:**
  - `app/Http/Controllers/backend/Pokja1Controller.php` (method `cetak`): Menambahkan `leftJoin('village', ...)` dan `'village.name as nama_desa'` pada query Penghayatan, Gotong Royong, dan Kader Pokja 1.
  - `resources/views/backend/cetak_bulan_pokja1.blade.php` & `resources/views/backend/cetak_tahun_pokja1.blade.php`:
    - Tabel Penghayatan: Header berjenjang 3 tingkat (`Kegiatan`, `Vol. Keg`, `Metode`, `Jml Sasaran`) + kolom Desa + Keterangan (`catatan`).
    - Tabel Gotong Royong: **Ditambahkan kembali** (sebelumnya hilang total) persis sesuai acuan `decgotongroyong.blade.php` (6 kegiatan: Kerja Bakti, Rukun Kematian, Keagamaan, Jaga Malam, Swadaya/Gotong Royong, Lansia) + kolom Desa + Keterangan (`catatan`).
    - Tabel Kader Pokja 1: Ditambahkan kolom Desa persis sesuai acuan `declaporanpokja1.blade.php`.
- **Hasil Uji:** LULUS.

#### 3. Pokja 2
- **File Diubah:**
  - `app/Http/Controllers/backend/Pokja2Controller.php` (method `cetak`): Menambahkan `leftJoin('village', ...)` dan `'village.name as nama_desa'` pada query Pendidikan dan Pengembangan.
  - `resources/views/backend/cetak_bulan_pokja2.blade.php` & `resources/views/backend/cetak_tahun_pokja2.blade.php`:
    - Tabel Pendidikan dan Keterampilan: Header 4 baris hierarkis (`BKB`, `TUTOR`, `KADER KHUSUS`, `JUMLAH KADER YANG SUDAH DILATIH`) + kolom Desa + Keterangan (`catatan`).
    - Tabel Pengembangan Kehidupan Berkoperasi: Header 4 baris hierarkis (`PRAKOPERASI / USAHA BERSAMA / UP2K`, `KOPERASI BERBADAN HUKUM`) + kolom Desa + Keterangan (`catatan`).
- **Hasil Uji:** LULUS.

#### 4. Pokja 3
- **File Diubah:**
  - `app/Http/Controllers/backend/Pokja3Controller.php` (method `cetak`): Menambahkan `leftJoin('village', ...)` dan `'village.name as nama_desa'` pada query Pangan, Sandang, Perumahan, dan Kader Pokja 3.
  - `resources/views/backend/cetak_bulan_pokja3.blade.php` & `resources/views/backend/cetak_tahun_pokja3.blade.php`:
    - Tabel Pangan: Header 3 baris hierarkis (`MAKANAN POKOK`, `PEMANFAATAN PEKARANGAN / HATINYA PKK`, `TANAMAN LAINNYA`) + kolom Desa + Keterangan (`catatan`).
    - Tabel Sandang: Header 2 baris hierarkis (`JUMLAH INDUSTRI RUMAH TANGGA`: Pangan, Sandang, Jasa) + kolom Desa + Keterangan (`catatan`).
    - Tabel Perumahan: Header 2 baris hierarkis (`JUMLAH RUMAH`: Sehat & Layak Huni, Tidak Sehat & Tidak Layak Huni) + kolom Desa + Keterangan (`catatan`).
    - Tabel Kader Pokja 3: Header 2 baris hierarkis (`JUMLAH KADER`: Pangan, Sandang, Jasa) + kolom Desa + Keterangan (`catatan`).
- **Temuan Keputusan 2:** Field database adalah `tata_laksana_rumah`, tetapi web `declaporanpokja3` melabelinya dengan `Jasa`. Sesuai instruksi, label cetak mengikuti web acuan (`Jasa`).
- **Hasil Uji:** LULUS.

#### 5. Pokja 4 Reguler
- **File Diubah:**
  - `app/Http/Controllers/backend/Pokja4Controller.php` (method `cetak`): Menambahkan `leftJoin('village', ...)` dan `'village.name as nama_desa'` pada query Kesehatan, Kelestarian, Perencanaan Sehat, dan Kader Pokja 4.
  - `resources/views/backend/cetak_bulan_pokja4.blade.php` & `resources/views/backend/cetak_tahun_pokja4.blade.php`:
    - Tabel Kesehatan: Header 4 baris hierarkis (`Kesehatan` -> `Posyandu` -> `Jumlah`, `Terintegrasi`, `Lansia: Jml Klp, Jml Anggota, Jml yg Memiliki Kartu Berobat Gratis`) + kolom Desa + Keterangan (`catatan`).
    - Tabel Kelestarian Lingkungan Hidup: Header 3 baris hierarkis (`Kelestarian Lingkungan Hidup` -> `Jumlah Rumah yang Memiliki: Jamban, SPAL, TPS`, `Jumlah MCK`, `Jumlah KK yang Menggunakan Air: PDAM, Sumur, Lain Lain`) + kolom Desa + Keterangan (`catatan`).
    - Tabel Perencanaan Sehat: Header 3 baris hierarkis (`Perencanaan Sehat` -> `Jumlah PUS`, `Jumlah WUS`, `Jumlah Aseptor KB: L, P`, `Jumlah KK yang Memiliki Tabungan`) + kolom Desa + Keterangan (`catatan`).
    - Tabel Kader Pokja 4: Header 2 baris hierarkis (`Jumlah Kader`: Posyandu, Gizi, Kesling, Penyuluhan Narkoba, PHBS, KB) + kolom Desa + Keterangan (`catatan`).
- **Hasil Uji:** LULUS.

#### 6. Pokja 4 Inovasi
- **File Diubah:**
  - `app/Http/Controllers/backend/Pokja4Controller.php` (method `cetak`): Menambahkan `leftJoin('village', ...)` dan `'village.name as nama_desa'` pada query Rekap Bulanan (`queryInovasiRDB`), Rekap Tahunan (`queryInovasiRDT`), Posyandu (`queryInovasiPos`), dan Kegiatan Pokja 4 (`queryInovasiKP4`).
  - `resources/views/backend/cetak_bulan_pokja4.blade.php` & `resources/views/backend/cetak_tahun_pokja4.blade.php`:
    - Tabel Rekap Desa Bulanan: Header 3 baris hierarkis (`JUMLAH: RW, RT, Dasa Wisma`, `JUMLAH IBU: Hamil, Melahirkan, Nifas, Meninggal`, `JUMLAH BAYI: Lahir L/P, Akte Ada/Tidak, Meninggal L/P`, `BALITA MENINGGAL: L/P`) + kolom Kecamatan & Desa terpisah sesuai guard + kolom Kategori.
    - Tabel Rekap Desa Tahunan: Kolom Kecamatan & Desa terpisah sesuai guard + kolom Kategori + subheader Kesehatan, Lingkungan, Program Lingkungan, KB, Program PKK.
    - Tabel Posyandu: Kolom Kecamatan & Desa terpisah sesuai guard + kolom Kategori + subheader Ibu, KB, Balita, Buku KIA, Datang, Naik, Vit A, PMT, Imunisasi TT.
    - Tabel Kegiatan Pokja 4: Header 2 baris hierarkis (`Kesehatan`, `Kelestarian Lingkungan Hidup`, `Perencanaan Sehat`, `Program Unggulan GKSTTB`) + kolom Kecamatan & Desa terpisah sesuai guard + kolom Kategori.
- **Temuan Keputusan 1:** Kolom "Kategori" pada Inovasi Pokja 4 dipertahankan agar pengguna dapat membedakan data Prioritas dan Unggulan saat mencetak semua kategori.
- **Hasil Uji:** LULUS.

---

### TABEL AUDIT SESUDAH PERBAIKAN TAHAP 2

| Bidang | Sub-Laporan | File Cetak | File Web (Acuan) | Status Header & Kolom | Hasil Uji |
| :--- | :--- | :--- | :--- | :--- | :---: |
| **Bidang Umum** | Laporan Bidang Umum | `cetak_bulan_bidangumum`<br>`cetak_tahun_bidangumum` | `decbidangumum`<br>`tampil_bidangumum` | Identik (Header 3 baris, Kolom Desa, PKK RT, Total) | **Lulus** |
| **Pokja 1** | Penghayatan Pancasila | `cetak_bulan_pokja1`<br>`cetak_tahun_pokja1` | `decpenghayatan`<br>`tampil_penghayatan` | Identik (Header 3 baris, Kolom Desa, Catatan, Total) | **Lulus** |
| **Pokja 1** | Gotong Royong | `cetak_bulan_pokja1`<br>`cetak_tahun_pokja1` | `decgotongroyong`<br>`tampil_gotongroyong` | Identik (Tabel dipulihkan, Kolom Desa, Catatan, Total) | **Lulus** |
| **Pokja 1** | Kader Pokja 1 | `cetak_bulan_pokja1`<br>`cetak_tahun_pokja1` | `declaporanpokja1`<br>`tampil_laporanpokja1` | Identik (Kolom Desa, Total) | **Lulus** |
| **Pokja 2** | Pendidikan & Keterampilan | `cetak_bulan_pokja2`<br>`cetak_tahun_pokja2` | `decpendidikan`<br>`tampil_pendidikan` | Identik (Header 4 baris, Kolom Desa, Catatan, Total) | **Lulus** |
| **Pokja 2** | Pengembangan Berkoperasi | `cetak_bulan_pokja2`<br>`cetak_tahun_pokja2` | `decpengembangan`<br>`tampil_pengembangan` | Identik (Header 4 baris, Kolom Desa, Catatan, Total) | **Lulus** |
| **Pokja 3** | Pangan | `cetak_bulan_pokja3`<br>`cetak_tahun_pokja3` | `decpangan`<br>`tampil_pangan` | Identik (Header 3 baris, Kolom Desa, Catatan, Total) | **Lulus** |
| **Pokja 3** | Sandang | `cetak_bulan_pokja3`<br>`cetak_tahun_pokja3` | `decsandang`<br>`tampil_sandang` | Identik (Header 2 baris, Kolom Desa, Catatan, Total) | **Lulus** |
| **Pokja 3** | Perumahan & Tata Laksana | `cetak_bulan_pokja3`<br>`cetak_tahun_pokja3` | `decperumahan`<br>`tampil_perumahan` | Identik (Header 2 baris, Kolom Desa, Catatan, Total) | **Lulus** |
| **Pokja 3** | Kader Pokja 3 | `cetak_bulan_pokja3`<br>`cetak_tahun_pokja3` | `declaporanpokja3`<br>`tampil_laporanpokja3` | Identik (Header 2 baris, Kolom Desa, Label Jasa, Total) | **Lulus** |
| **Pokja 4** | Kesehatan | `cetak_bulan_pokja4`<br>`cetak_tahun_pokja4` | `deckesehatan`<br>`tampil_kesehatan` | Identik (Header 4 baris, Kolom Desa, Catatan, Total) | **Lulus** |
| **Pokja 4** | Kelestarian Lingkungan Hidup | `cetak_bulan_pokja4`<br>`cetak_tahun_pokja4` | `deckelestarian`<br>`tampil_kelestarian` | Identik (Header 3 baris, Kolom Desa, Catatan, Total) | **Lulus** |
| **Pokja 4** | Perencanaan Sehat | `cetak_bulan_pokja4`<br>`cetak_tahun_pokja4` | `decperencanaan`<br>`tampil_perencanaan` | Identik (Header 3 baris, Kolom Desa, Catatan, Total) | **Lulus** |
| **Pokja 4** | Kader Pokja 4 | `cetak_bulan_pokja4`<br>`cetak_tahun_pokja4` | `declaporanpokja4`<br>`tampil_laporanpokja4` | Identik (Header 2 baris, Kolom Desa, Catatan, Total) | **Lulus** |
| **Pokja 4** | Inovasi: Rekap Desa Bulanan | `cetak_bulan_pokja4`<br>`cetak_tahun_pokja4` | `prioritas_bulanan`<br>`unggulan_bulanan` | Identik (Header 3 baris, Kolom Wilayah, Kategori, Total) | **Lulus** |
| **Pokja 4** | Inovasi: Rekap Desa Tahunan | `cetak_bulan_pokja4`<br>`cetak_tahun_pokja4` | `prioritas_tahunan`<br>`unggulan_tahunan` | Identik (Header 2 baris, Kolom Wilayah, Kategori, Total) | **Lulus** |
| **Pokja 4** | Inovasi: Posyandu | `cetak_bulan_pokja4`<br>`cetak_tahun_pokja4` | `prioritas_posyandu`<br>`unggulan_posyandu` | Identik (Header 2 baris, Kolom Wilayah, Kategori, Total) | **Lulus** |
| **Pokja 4** | Inovasi: Kegiatan Pokja 4 | `cetak_bulan_pokja4`<br>`cetak_tahun_pokja4` | `prioritas_pokja4`<br>`unggulan_pokja4` | Identik (Header 2 baris, Kolom Wilayah, Kategori, Total) | **Lulus** |

---

### CARA MENGEMBALIKAN (ROLLBACK) PERUBAHAN TAHAP 2
Jika ingin membatalkan perubahan Tahap 2:
1. Jalankan perintah git checkout untuk file controller:
   ```bash
   git checkout app/Http/Controllers/backend/BidangUmumController.php
   git checkout app/Http/Controllers/backend/Pokja1Controller.php
   git checkout app/Http/Controllers/backend/Pokja2Controller.php
   git checkout app/Http/Controllers/backend/Pokja3Controller.php
   git checkout app/Http/Controllers/backend/Pokja4Controller.php
   ```
2. Jalankan perintah git checkout untuk file view cetak:
   ```bash
   git checkout resources/views/backend/cetak_bulan_bidangumum.blade.php
   git checkout resources/views/backend/cetak_tahun_bidangumum.blade.php
   git checkout resources/views/backend/cetak_bulan_pokja1.blade.php
   git checkout resources/views/backend/cetak_tahun_pokja1.blade.php
   git checkout resources/views/backend/cetak_bulan_pokja2.blade.php
   git checkout resources/views/backend/cetak_tahun_pokja2.blade.php
   git checkout resources/views/backend/cetak_bulan_pokja3.blade.php
   git checkout resources/views/backend/cetak_tahun_pokja3.blade.php
   git checkout resources/views/backend/cetak_bulan_pokja4.blade.php
   git checkout resources/views/backend/cetak_tahun_pokja4.blade.php
   ```
3. Bersihkan cache view:
   ```bash
   php artisan view:clear
   ```

---

### 12-10-2026 | Redesain Halaman Program Kerja Pokja 2 Sesuai Layout Pokja 1
- **Masalah:** Halaman frontend Program Kerja 2 (`pokjathu.blade.php`) masih menggunakan desain dan layout lama (`.pokja-hero` abu-abu, teks datar tanpa kartu/ikon terstruktur) sehingga berbeda dan tertinggal dibandingkan halaman Pokja 1 (`pokja.blade.php`) yang telah diperbarui dengan stylesheet modern (`pokja.css`).
- **File & Baris yang Diubah:**
  1. [`public/css/pokja.css`](file:///c:/xampp/htdocs/Website_E-PKK/public/css/pokja.css):
     - Menambahkan class utilitas `.pokja-grid-full { grid-column: 1 / -1; }` agar kartu penutup bernomor ganjil dapat mengisi penuh lebar kolom secara seimbang pada mode desktop.
  2. [`resources/views/frontend/pokjathu.blade.php`](file:///c:/xampp/htdocs/Website_E-PKK/resources/views/frontend/pokjathu.blade.php):
     - Menerapkan layout Pokja 1 menggunakan stylesheet `css/pokja.css` dan container `.pokja`.
     - Menyusun ulang struktur menjadi 7 bagian utama:
       1. **Banner Utama** (Judul Pokja 2, deskripsi, dan logo resmi PKK).
       2. **Misi Pokja 2** (Kartu Visi/Misi dengan penekanan kata kunci dan ikon).
       3. **Program Pokok Pokja 2** (Grid 2 kartu: Pendidikan & Keterampilan dan Pengembangan Kehidupan Berkoperasi).
       4. **Pita Statistik** (4 metrik ringkas: 2 Program Pokok, 11 Tugas, 13 Prioritas Pendidikan, 8 Kehidupan Berkoperasi).
       5. **Daftar 11 Tugas** (Struktur baris nomor `01` s/d `11` dengan judul dan teks lengkap).
       6. **Prioritas Program: Pendidikan dan Ketrampilan** (13 kartu kegiatan dengan ikon SVG, badge singkatan resmi, dan kotak catatan singkatan).
       7. **Pengembangan Kehidupan Berkoperasi** (8 kartu kegiatan berkoperasi dengan ikon SVG, badge kategori UP2K/Koperasi/Sinergi, dan kotak catatan singkatan).
     - **Catatan Penting:** 100% teks asli (misi, 11 tugas, 13 poin pendidikan, 8 poin koperasi), fungsi, dan skema warna biru PKK (`#016AA3`) tetap dipertahankan tanpa perubahan data apapun.
- **Alasan:** Menyelaraskan tampilan antarmuka Program Kerja Pokja 2 agar konsisten, modern, responsif, dan mudah dibaca oleh kader PKK serta masyarakat umum layaknya Pokja 1.
- **Cara Mengembalikan (Rollback):** Jalankan `git checkout resources/views/frontend/pokjathu.blade.php`.

---

### 12-10-2026 | Redesain Halaman Program Kerja Pokja 3 dan Pokja 4 Sesuai Layout Pokja 1 & 2
- **Masalah:** Halaman frontend Program Kerja 3 (`pokjatre.blade.php`) dan Pokja 4 (`pokjafou.blade.php`) masih menggunakan format lama (`#heroo` abu-abu, teks datar tidak berstruktur), sehingga tampilan belum selaras dengan Pokja 1 dan 2.
- **File & Baris yang Diubah:**
  1. [`resources/views/frontend/pokjatre.blade.php`](file:///c:/xampp/htdocs/Website_E-PKK/resources/views/frontend/pokjatre.blade.php):
     - Menerapkan layout berbasis `pokja.css` dengan 8 bagian:
       1. **Banner Utama** (Judul Pokja 3, deskripsi, logo PKK).
       2. **Misi Pokja 3** (Kartu Visi/Misi dengan penekanan kata kunci dan ikon).
       3. **Program Pokok Pokja 3** (Grid 3 kartu: Pangan, Sandang, Perumahan & Tatalaksana Rumah Tangga dengan ikon SVG).
       4. **Pita Statistik** (3 Program Pokok, 19 Tugas, 9 Prioritas Pangan, 9 Sandang & Perumahan).
       5. **Daftar 19 Tugas** (Format nomor `01` s/d `19` dengan judul dan teks lengkap).
       6. **Prioritas Program: Pangan** (9 kartu kegiatan lengkap dengan badge HATINYA PKK, pola 3B, TTG, dll.).
       7. **Prioritas Program: Sandang** (4 kartu kegiatan lengkap dengan badge Hak Paten, Pameran, dll.).
       8. **Perumahan dan Tata Laksana Rumahtangga** (5 kartu kegiatan lengkap dengan badge P2LDT, Rumah Sehat, dll.).
       9. Kotak penjelasan singkatan resmi di setiap seksi.
  2. [`resources/views/frontend/pokjafou.blade.php`](file:///c:/xampp/htdocs/Website_E-PKK/resources/views/frontend/pokjafou.blade.php):
     - Menerapkan layout berbasis `pokja.css` dengan 8 bagian:
       1. **Banner Utama** (Judul Pokja 4, deskripsi, logo PKK).
       2. **Misi Pokja 4** (Kartu Visi/Misi dengan penekanan kata kunci dan ikon).
       3. **Program Pokok Pokja 4** (Grid 3 kartu: Kesehatan, Kelestarian Lingkungan Hidup, Perencanaan Sehat dengan ikon SVG).
       4. **Pita Statistik** (3 Program Pokok, 8 Tugas, 12 Prioritas Kesehatan, 16 Lingkungan & Perencanaan).
       5. **Daftar 8 Tugas** (Format nomor `01` s/d `08` dengan judul dan teks lengkap).
       6. **Prioritas Program: Kesehatan** (12 kartu kegiatan lengkap dengan badge KADARZI, PMT-AS, PHBS, UKS, LIL, dll.).
       7. **Kelestarian Lingkungan Hidup** (10 kartu kegiatan lengkap dengan badge Sanitasi SPAL, Pilah Sampah, Biopori, dll.).
       8. **Perencanaan Sehat** (6 kartu kegiatan lengkap dengan badge Program KB, Gemar Menabung, Harganas, dll.).
       9. Kotak penjelasan singkatan resmi di setiap seksi.
  - **Catatan Penting:** Seluruh 19 tugas di Pokja 3, 8 tugas di Pokja 4, dan semua poin program prioritas 100% utuh tanpa perubahan isi/redaksi kalimat teks aslinya, serta warna tetap konsisten dengan tema resmi PKK (`#016AA3`).
- **Alasan:** Menyeragamkan seluruh tampilan halaman Program Kerja PKK (Pokja 1, 2, 3, dan 4) menjadi satu sistem desain yang rapi, modern, responsif, dan mudah dibaca.
- **Cara Mengembalikan (Rollback):**
  ```bash
  git checkout resources/views/frontend/pokjatre.blade.php resources/views/frontend/pokjafou.blade.php
  php artisan view:clear
  ```

---

### 12-10-2026 | Peningkatan Visual & Interaktivitas Pokja 1: Gradasi Biru-Putih & Komponen Dinamis
- **Masalah:** Tampilan Pokja 1 sebelumnya dinilai masih agak monoton dan datar karena berbasis kartu putih polos dan latar solid tanpa gradasi, serta minim elemen interaktif.
- **File & Baris yang Diubah:**
  1. [`public/css/pokja.css`](file:///c:/xampp/htdocs/Website_E-PKK/public/css/pokja.css):
     - Menambahkan palet gradasi biru - putih (`--grad-hero`, `--grad-ribbon`, `--grad-card`, `--grad-card-hover`, `--grad-icon`, `--grad-badge`, `--grad-line`).
     - Banner utama ditingkatkan dengan latar gradasi biru mewah, aksen cahaya radial glow, floating tag dengan pulsing live dot (`.pokja-hero-tag`), dan box logo glassmorphism.
     - Kotak bagian (`.pokja-box`) dan kartu (`.pokja-card`) diberikan gradasi putih-ke-biru es halus, aksen garis atas (`.pokja-card-accent-top`), hover 3D-lift (`translateY(-5px)`), serta border bercahaya biru halus.
     - Visi Pokja diperbarui menjadi feature showcase card dengan border kiri tebal dan kutipan dekoratif.
     - Pita statistik menggunakan gradasi biru-cyan dengan pod kapsul kaca semi-transparan (*glassmorphism*) yang interaktif saat di-hover.
     - Menambahkan komponen navigasi cepat pill (`.pokja-nav-bar`, `.pokja-nav-pill`).
     - Menambahkan komponen Live Search (`.pokja-search-wrap`, `.pokja-search-input`) dan Filter Chips (`.pokja-filter-chips`, `.pokja-chip-btn`).
     - Nomor tugas (`.pokja-tugas-num`) diubah menjadi lingkaran gradasi yang membesar saat baris tugas di-hover, serta mendukung status aktif terpilih (`.pokja-tugas-row.active`).
  2. [`resources/views/frontend/pokja.blade.php`](file:///c:/xampp/htdocs/Website_E-PKK/resources/views/frontend/pokja.blade.php):
     - Menerapkan seluruh kelas dan struktur gradasi baru pada seluruh seksi Pokja 1.
     - Menambahkan navigasi pintas 6 kapsul (Visi, Program Pokok, Statistik, 7 Tugas, Prioritas, Gotong Royong) dengan smooth scroll & active scroll spy.
     - Menambahkan kolom pencarian instan (Live Search) dan tombol filter kategori pada daftar 7 Tugas Pokja 1.
     - Menambahkan script vanilla JavaScript untuk animasi penghitung angka statistik (*count-up animation*), filter instan tugas, toggle highlight tugas, dan navigasi smooth-scroll.
     - **Catatan Penting:** 100% teks isi (visi, program, 7 tugas, prioritas, gotong royong) tetap utuh tanpa perubahan.
- **Alasan:** Memberikan pengalaman visual yang jauh lebih modern, elegan, tidak monoton, dan interaktif sesuai permintaan pengguna.
- **Cara Mengembalikan (Rollback):**
  ```bash
  git checkout resources/views/frontend/pokja.blade.php public/css/pokja.css
  php artisan view:clear
  ```

---

### [2026-10-12] Penghapusan Bar Navigasi Pintas (Pill Navigation) pada Detail Pokja 1
- **File Diubah:**
  1. [`resources/views/frontend/pokja.blade.php`](file:///c:/xampp/htdocs/Website_E-PKK/resources/views/frontend/pokja.blade.php):
     - Menghapus komponen baris navigasi pintas kapsul/pill (`<nav class="pokja-nav-bar">` yang berisi kapsul Visi, Program Pokok, Pita Statistik, 7 Tugas Pokja, Prioritas Program, Gotong Royong).
     - Menghapus event listener JavaScript scroll-spy dan smooth-scroll yang terkait dengan `.pokja-nav-pill`.
  2. [`public/css/pokja.css`](file:///c:/xampp/htdocs/Website_E-PKK/public/css/pokja.css):
     - Menghapus deklarasi CSS `.pokja-nav-bar` dan `.pokja-nav-pill` agar stylesheet tetap bersih tanpa kode mati (*dead code*).
- **Hasil:** Tampilan langsung mengalir dari banner utama ke kartu Visi Pokja tanpa adanya bilah tombol pill loncat bagian, sesuai permintaan pengguna. Seluruh fitur lainnya (Live Search 7 tugas, counter statistik, kartu program gradasi biru-putih) tetap berjalan normal.
