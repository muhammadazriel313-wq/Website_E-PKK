# Panduan Singkat Deploy Google Apps Script & Integrasi Google Sheets

Dokumen ini berisi panduan langkah demi langkah untuk menghubungkan fitur ekspor laporan Website E-PKK ke Google Spreadsheet milik Anda sendiri.

---

### Langkah 1: Buat Google Spreadsheet Baru
1. Buka [Google Drive](https://drive.google.com/) dan pastikan Anda login dengan akun Google yang diinginkan.
2. Klik tombol **+ Baru (+ New)** > pilih **Google Spreadsheet (Google Sheets)**.
3. Beri nama file Spreadsheet, misalnya: `Laporan E-PKK Nganjuk`.
4. Salin tautan spreadsheet dari address bar browser atau melalui tombol **Bagikan (Share)** (pastikan akses disesuaikan sesuai kebutuhan).

---

### Langkah 2: Buka Google Apps Script
1. Di dalam Google Spreadsheet yang baru dibuat, klik menu bar atas:
   **Ekstensi (Extensions)** > **Apps Script**.
2. Anda akan diarahkan ke editor Google Apps Script.
3. Beri nama project di pojok kiri atas (misalnya: `Export-EPKK`).

---
   
### Langkah 3: Tempelkan Kode `Code.gs`
1. Di editor file `Code.gs`, hapus seluruh kode bawaan (`function myFunction() { ... }`).
2. Buka file [`apps_script/Code.gs`](file:///c:/xampp/htdocs/Website_E-PKK/apps_script/Code.gs) pada project ini, lalu salin (*copy*) seluruh isinya.
3. Tempelkan (*paste*) ke dalam editor `Code.gs` di Apps Script.
4. Klik ikon **Simpan (Save project / Ctrl + S)**.

---

### Langkah 4: Terapkan Sebagai Web App (Deployment)
1. Di pojok kanan atas editor Apps Script, klik tombol biru **Deploy** > pilih **New deployment (Penerapan baru)**.
2. Klik ikon roda gigi ⚙️ (**Select type**) di sebelah kiri > pilih jenis **Web app**.
3. Atur konfigurasi berikut:
   - **Description**: `Export Web E-PKK v1`
   - **Execute as (Jalankan sebagai)**: **Me (email Anda)**
   - **Who has access (Siapa yang memiliki akses)**: **Anyone (Siapa saja)**  
     *(Pengaturan "Anyone" mutlak diperlukan agar backend Laravel dan browser dapat mengirim data tanpa terhalang autentikasi Google).*
4. Klik tombol **Deploy**.
5. Jika muncul jendela permintaan otorisasi akun:
   - Klik **Authorize access (Beri izin akses)**.
   - Pilih akun Google Anda.
   - Jika muncul peringatan *"Google hasn't verified this app"*, klik **Advanced (Lanjutan)** di kiri bawah > klik **Go to [Nama Project] (unsafe)**.
   - Klik **Allow (Izinkan)**.
6. Setelah deployment selesai, Google akan menampilkan **Web app URL** yang berakhiran `/exec`.
7. Salin URL tersebut.

---

### Langkah 5: Masukkan URL ke `.env` Project Laravel
1. Buka file `.env` pada root project Laravel Anda (`c:\xampp\htdocs\Website_E-PKK\.env`).
2. Tambahkan kedua variabel berikut di baris paling bawah:
   ```env
   SHEETS_APPS_SCRIPT_URL=<URL_WEB_APP_YANG_BERAKHIRAN_/exec>
   SHEETS_SPREADSHEET_URL=<LINK_GOOGLE_SPREADSHEET_ANDA>
   ```
   *(Ganti `<...>` dengan URL Web App Apps Script dan tautan Google Spreadsheet Anda).*
3. Simpan file `.env`.

---

### Langkah 6: Bersihkan Cache Konfigurasi Laravel
Buka terminal / Command Prompt di folder project Laravel (`c:\xampp\htdocs\Website_E-PKK`), lalu jalankan:

```bash
php artisan config:clear
```

---

### Selesai!
Sekarang seluruh fitur ekspor laporan Google Sheets (Pokja 1, Pokja 2, Pokja 3, Pokja 4, dan Bidang Umum) akan otomatis mengirim data ke spreadsheet Anda secara terstruktur, rapi, dan menimpa data pada periode yang sama tanpa duplikasi.
