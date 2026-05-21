<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\backend\ProfileController;
use App\Http\Controllers\frontend\BeritaController;
use App\Http\Controllers\frontend\LaporanController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\frontend\StrukturController;
use App\Http\Controllers\frontend\VisiMisiController;
use App\Http\Controllers\backend\InputBeritaController;
use App\Http\Controllers\frontend\PengumumanController;
use App\Http\Controllers\backend\ChangePasswordController;
use App\Http\Controllers\backend\InputPengumumanController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\backend\KesehatanController;
use App\Http\Controllers\backend\UnggulanController;
use App\Http\Controllers\backend\BidangUmumController;
use App\Http\Controllers\backend\GotongRoyongController;
use App\Http\Controllers\backend\RekapBulananController;
use App\Http\Controllers\backend\JumlahBeritaController;
use App\Http\Controllers\backend\GaleriController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\backend\InovasiController;
use App\Http\Controllers\backend\Pokja1ExportController;
use App\Http\Controllers\backend\Pokja4ExportController;
use App\Http\Controllers\backend\PosyanduController;
use App\Http\Controllers\backend\RekapTahunanController;
use App\Http\Controllers\backend\KegiatanPokja4Controller;
use App\Http\Controllers\backend\GaleriBidangUmumController;



/*
|--------------------------------------------------------------------------
| 1. ROUTE PUBLIC / FRONTEND (TIDAK PERLU LOGIN)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index']);

Route::resource('home', App\Http\Controllers\frontend\HomeController::class);
Route::resource('laporan', App\Http\Controllers\frontend\LaporanController::class);
Route::resource('berita', App\Http\Controllers\frontend\BeritaController::class);
Route::resource('pengumuman', App\Http\Controllers\frontend\PengumumanController::class);
Route::resource('pokja', App\Http\Controllers\frontend\PokjaController::class);
Route::resource('pokjathu', App\Http\Controllers\frontend\PokjathuController::class);
Route::resource('pokjatre', App\Http\Controllers\frontend\PokjatreController::class);
Route::resource('pokjafou', App\Http\Controllers\frontend\PokjafouController::class);
Route::resource('visimisi', App\Http\Controllers\frontend\VisiMisiController::class);
Route::resource('struktur', App\Http\Controllers\frontend\StrukturController::class);
Route::resource('mars', App\Http\Controllers\frontend\MarsController::class);
Route::resource('lambangpkk', App\Http\Controllers\frontend\LambangController::class);
Route::resource('sejarah', App\Http\Controllers\frontend\SejarahController::class);
Route::resource('showkes', App\Http\Controllers\frontend\TampilkesController::class);
Route::resource('showling', App\Http\Controllers\frontend\TampilkunganController::class);
Route::resource('showhat', App\Http\Controllers\frontend\TampilsehatController::class);
Route::resource('galery', App\Http\Controllers\frontend\GaleryController::class);
Route::get('frontend/show/{id}', [BeritaController::class, 'show'])->name('frontend.show');

// ROUTE LUPA SANDI (OTP)
Route::get('/otp', [OtpController::class, 'showForm'])->name('otp.form');
Route::post('/otp/send', [OtpController::class, 'sendOtp'])->name('otp.send');
Route::get('/otp/verify', function () {
    return view('auth.verify_otp');
})->name('otp.verify.form');
Route::post('/otp/verify', [OtpController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/otp/reset', [OtpController::class, 'resetPassword'])->name('otp.reset');


/*
|--------------------------------------------------------------------------
| 2. ROUTE BAWAAN LARAVEL (AUTH)
|--------------------------------------------------------------------------
| Ditaruh di sini agar route 'logout' bawaan pabrik bisa kita TIMPA di bawahnya.
*/
require __DIR__ . '/auth.php';


/*
|--------------------------------------------------------------------------
| 3. ROUTE BACKEND / PRIVATE (WAJIB LOGIN ADMIN ATAU KECAMATAN)
|--------------------------------------------------------------------------
| Semua route di dalam blok ini dilindungi dengan aman.
*/
Route::middleware(['auth:web,pengguna', 'prevent-back-history'])->group(function () {

    // =========================================================================
    // 🚨 PINDAHAN ROUTE CETAK DARI BAWAH KE SINI AGAR AMAN DARI TABRAKAN 🚨
    // =========================================================================
    Route::get('/cetak-pokja2', [App\Http\Controllers\backend\Pokja2Controller::class, 'cetak'])->name('pokja2.cetak');
    Route::get('/cetak-pokja3', [App\Http\Controllers\backend\Pokja3Controller::class, 'cetak'])->name('pokja3.cetak');
    Route::get('/cetak-pokja4', [App\Http\Controllers\backend\Pokja4Controller::class, 'cetak'])->name('pokja4.cetak');
    Route::get('/export-pokja4', [App\Http\Controllers\backend\Pokja4Controller::class, 'getExportData'])->name('pokja4.exportJson');
    Route::get('/galeribidangumum/cetak', [GaleriBidangUmumController::class, 'cetak'])->name('galeribidangumum.cetak');

    // === MENIMPA ROUTE LOGOUT AGAR BISA DIAKSES 2 AKUN ===
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // === DASHBOARD ===
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // === MENU UTAMA & PROFILE ===
    Route::resource('profile', App\Http\Controllers\backend\ProfileController::class);
    Route::resource('change_password', App\Http\Controllers\backend\ChangePasswordController::class);

    // === FITUR DATA & POKJA ===
    Route::resource('kesehatan', App\Http\Controllers\backend\KesehatanController::class);
    Route::get('/kesehatan/filter', [App\Http\Controllers\backend\KesehatanController::class, 'filter'])->name('kesehatan.filter');

    Route::get('/bidangumum/filter', [App\Http\Controllers\backend\BidangUmumController::class, 'filter'])->name('bidangumum.filter');
    Route::get('/bidangumum/export-json', [App\Http\Controllers\backend\BidangUmumController::class, 'getExportData'])->name('bidangumum.exportJson');

    Route::get('/gotongroyong/filter', [App\Http\Controllers\backend\GotongRoyongController::class, 'filter'])->name('gotongroyong.filter');
    Route::get('/pendidikan/filter', [App\Http\Controllers\backend\PendidikanController::class, 'filter'])->name('pendidikan.filter');
    Route::get('/pangan/filter', [App\Http\Controllers\backend\PanganController::class, 'filter'])->name('pangan.filter');

    Route::resource('kelestarian_lingkungan_hidup', App\Http\Controllers\backend\KelestarianLingkunganHidupController::class);
    Route::resource('perencanaan_sehat', App\Http\Controllers\backend\PerencanaanSehatController::class);

    // === GALERI ===
    Route::resource('galeripokja1', App\Http\Controllers\backend\Galeri1Controller::class);
    Route::get('/galeripokja1/filter', [App\Http\Controllers\backend\Galeri1Controller::class, 'filter'])->name('galeripokja1.filter');
    Route::get('/galeripokja2/filter', [App\Http\Controllers\backend\Galeri2Controller::class, 'filter'])->name('galeripokja2.filter');
    Route::get('/galeripokja3/filter', [App\Http\Controllers\backend\Galeri3Controller::class, 'filter'])->name('galeripokja3.filter');
    Route::get('/galeripokja4/filter', [App\Http\Controllers\backend\Galeri4Controller::class, 'filter'])->name('galeripokja4.filter');
    Route::get('/galeribidangumum/filter', [App\Http\Controllers\backend\GaleriBidangUmumController::class, 'filter'])->name('galeribidangumum.filter');
    Route::resource('galeripokja2', App\Http\Controllers\backend\Galeri2Controller::class);
    Route::resource('galeripokja3', App\Http\Controllers\backend\Galeri3Controller::class);
    Route::resource('galeripokja4', App\Http\Controllers\backend\Galeri4Controller::class);

    // === POKJA ===
    Route::resource('pokja1', App\Http\Controllers\backend\Pokja1Controller::class);
    Route::resource('pokja2', App\Http\Controllers\backend\Pokja2Controller::class);
    Route::resource('pokja3', App\Http\Controllers\backend\Pokja3Controller::class);
    Route::resource('pokja4', App\Http\Controllers\backend\Pokja4Controller::class);

    // === EXPORT JSON LAMA ===
    Route::get('/laporanpokja1/export-json', [App\Http\Controllers\backend\LaporanPokja1Controller::class, 'getExportData'])->name('laporanpokja1.exportJson');
    Route::get('/laporanpokja4/export-json', [App\Http\Controllers\backend\LaporanPokja4Controller::class, 'getExportData'])->name('laporanpokja4.exportJson');

    // === LAPORAN POKJA ===
    Route::resource('laporanpokja1', App\Http\Controllers\backend\LaporanPokja1Controller::class);
    Route::resource('laporanpokja3', App\Http\Controllers\backend\LaporanPokja3Controller::class);
    Route::resource('laporanpokja4', App\Http\Controllers\backend\LaporanPokja4Controller::class);

    // === DETAIL & ACC (DEC & ACC) ===
    Route::resource('deckesehatan', App\Http\Controllers\backend\DecKesehatanController::class);
    Route::resource('deckelestarian', App\Http\Controllers\backend\DecKelestarianController::class);
    Route::resource('decperencanaan', App\Http\Controllers\backend\DecPerencanaanController::class);
    Route::resource('decpangan', App\Http\Controllers\backend\DecPanganController::class);
    Route::resource('decpendidikan', App\Http\Controllers\backend\DecPendidikanController::class);
    Route::resource('decpengembangan', App\Http\Controllers\backend\DecPengembanganController::class);
    Route::resource('decpenghayatan', App\Http\Controllers\backend\DecPenghayatanController::class);
    Route::resource('decperumahan', App\Http\Controllers\backend\DecPerumahanController::class);
    Route::resource('decsandang', App\Http\Controllers\backend\DecSandangController::class);
    Route::resource('decgotongroyong', App\Http\Controllers\backend\DecGotongRoyongController::class);
    Route::resource('declaporanpokja1', App\Http\Controllers\backend\DecLaporanPokja1Controller::class);
    Route::resource('declaporanpokja3', App\Http\Controllers\backend\DecLaporanPokja3Controller::class);
    Route::resource('declaporanpokja4', App\Http\Controllers\backend\DecLaporanPokja4Controller::class);
    Route::resource('decbidangumum', App\Http\Controllers\backend\DecBidangUmumController::class);

    Route::resource('acckesehatan', App\Http\Controllers\backend\AccKesehatanController::class);
    Route::resource('acckelestarian', App\Http\Controllers\backend\AccKelestarianController::class);
    Route::resource('accperencanaan', App\Http\Controllers\backend\AccPerencanaanController::class);
    Route::resource('accpangan', App\Http\Controllers\backend\AccPanganController::class);
    Route::resource('accpendidikan', App\Http\Controllers\backend\AccPendidikanController::class);
    Route::resource('accpengembangan', App\Http\Controllers\backend\AccPengembanganController::class);
    Route::resource('accpenghayatan', App\Http\Controllers\backend\AccPenghayatanController::class);
    Route::resource('accperumahan', App\Http\Controllers\backend\AccPerumahanController::class);
    Route::resource('accsandang', App\Http\Controllers\backend\AccSandangController::class);
    Route::resource('accgotongroyong', App\Http\Controllers\backend\AccGotongRoyongController::class);
    Route::resource('acclaporanpokja1', App\Http\Controllers\backend\AccLaporanPokja1Controller::class);
    Route::resource('acclaporanpokja3', App\Http\Controllers\backend\AccLaporanPokja3Controller::class);
    Route::resource('acclaporanpokja4', App\Http\Controllers\backend\AccLaporanPokja4Controller::class);
    Route::resource('accbidangumum', App\Http\Controllers\backend\AccBidangUmumController::class);

    // === RESOURCES LAINNYA ===
    Route::resource('bidangumum', App\Http\Controllers\backend\BidangUmumController::class);
    Route::resource('gotongroyong', App\Http\Controllers\backend\GotongRoyongController::class);
    Route::resource('penghayatan', App\Http\Controllers\backend\PenghayatanController::class);
    Route::resource('pendidikan', App\Http\Controllers\backend\PendidikanController::class);
    Route::resource('pengembangan', App\Http\Controllers\backend\PengembanganController::class);
    Route::resource('sandang', App\Http\Controllers\backend\SandangController::class);
    Route::resource('pangan', App\Http\Controllers\backend\PanganController::class);
    Route::resource('perumahan', App\Http\Controllers\backend\PerumahanController::class);

    Route::resource('galeripenghayatan', App\Http\Controllers\backend\GaleriPenghayatanController::class);
    Route::resource('galerigotongroyong', App\Http\Controllers\backend\GaleriGotongRoyongController::class);
    Route::resource('galeripendidikan', App\Http\Controllers\backend\GaleriPendidikanController::class);
    Route::resource('galeripengembangan', App\Http\Controllers\backend\GaleriPengembanganController::class);
    Route::resource('galerisandang', App\Http\Controllers\backend\GaleriSandangController::class);
    Route::resource('galeripangan', App\Http\Controllers\backend\GaleriPanganController::class);
    Route::resource('galeriperumahan', App\Http\Controllers\backend\GaleriPerumahanController::class);
    Route::resource('galerikesehatan', App\Http\Controllers\backend\GaleriKesehatanController::class);
    Route::resource('galerikelestarian', App\Http\Controllers\backend\GaleriKelestarianController::class);
    Route::resource('galeriperencanaan', App\Http\Controllers\backend\GaleriPerencanaanController::class);
    
    // Resource galeribidangumum ditaruh sesudah rute cetak di atas
    Route::resource('galeribidangumum', App\Http\Controllers\backend\GaleriBidangUmumController::class)->except(['show']);
    
    Route::resource('galerilaporanpokja1', App\Http\Controllers\backend\GaleriLaporanPokja1Controller::class);
    Route::resource('galerilaporanpokja3', App\Http\Controllers\backend\GaleriLaporanPokja3Controller::class);
    Route::resource('galerilaporanpokja4', App\Http\Controllers\backend\GaleriLaporanPokja4Controller::class);
    Route::resource('galeriinovasi', App\Http\Controllers\backend\GaleriInovasiController::class);

    /*
|--------------------------------------------------------------------------
| INOVASI & REKAP BULANAN
|--------------------------------------------------------------------------
*/

    Route::get('/inovasi', function () {

        if (Auth::guard('web')->check()) {

            return app(
                \App\Http\Controllers\backend\InovasiController::class
            )->kabupaten();
        }

        return app(
            \App\Http\Controllers\backend\InovasiController::class
        )->index();
    })->name('inovasi.index');


    /*
|--------------------------------------------------------------------------
| PRIORITAS
|--------------------------------------------------------------------------
*/

    Route::get('/inovasi/prioritas', function () {

        if (Auth::guard('web')->check()) {

            return app(
                \App\Http\Controllers\backend\PrioritasController::class
            )->kabupaten();
        }

        return app(
            \App\Http\Controllers\backend\PrioritasController::class
        )->index();
    })->name('prioritas.index');


    /*
|--------------------------------------------------------------------------
| PRIORITAS BULANAN
|--------------------------------------------------------------------------
*/

    Route::get(
        '/inovasi/prioritas/bulanan',
        [RekapBulananController::class, 'prioritas']
    )->name('prioritas.bulanan');

    Route::get(
        '/inovasi/prioritas/bulanan/edit/{id}',
        [RekapBulananController::class, 'editPrioritas']
    )->name('prioritas.bulanan.edit');

    Route::put(
        '/inovasi/prioritas/bulanan/update/{id}',
        [RekapBulananController::class, 'updatePrioritas']
    )->name('prioritas.bulanan.update');

    Route::delete(
        '/inovasi/prioritas/bulanan/hapus/{id}',
        [RekapBulananController::class, 'destroyPrioritas']
    )->name('prioritas.bulanan.destroy');


    /*
|--------------------------------------------------------------------------
| PRIORITAS TAHUNAN
|--------------------------------------------------------------------------
*/

    Route::get(
        '/inovasi/prioritas/tahunan',
        [RekapTahunanController::class, 'prioritas']
    )->name('prioritas.tahunan');

    Route::get(
        '/inovasi/prioritas/tahunan/edit/{id}',
        [RekapTahunanController::class, 'editPrioritas']
    )->name('prioritas.tahunan.edit');

    Route::put(
        '/inovasi/prioritas/tahunan/update/{id}',
        [RekapTahunanController::class, 'updatePrioritas']
    )->name('prioritas.tahunan.update');

    Route::delete(
        '/inovasi/prioritas/tahunan/hapus/{id}',
        [RekapTahunanController::class, 'destroyPrioritas']
    )->name('prioritas.tahunan.destroy');


    /*
|--------------------------------------------------------------------------
| PRIORITAS POSYANDU
|--------------------------------------------------------------------------
*/

    Route::get(
        '/inovasi/prioritas/posyandu',
        [PosyanduController::class, 'prioritas']
    )->name('prioritas.posyandu');

    Route::get(
        '/inovasi/prioritas/posyandu/edit/{id}',
        [PosyanduController::class, 'editPrioritas']
    )->name('prioritas.posyandu.edit');

    Route::put(
        '/inovasi/prioritas/posyandu/update/{id}',
        [PosyanduController::class, 'updatePrioritas']
    )->name('prioritas.posyandu.update');

    Route::delete(
        '/inovasi/prioritas/posyandu/hapus/{id}',
        [PosyanduController::class, 'destroyPrioritas']
    )->name('prioritas.posyandu.destroy');


    /*
|--------------------------------------------------------------------------
| PRIORITAS KEGIATAN POKJA 4
|--------------------------------------------------------------------------
*/

    Route::get(
        '/inovasi/prioritas/pokja4',
        [KegiatanPokja4Controller::class, 'prioritas']
    )->name('prioritas.pokja4');

    Route::get(
        '/inovasi/prioritas/pokja4/edit/{id}',
        [KegiatanPokja4Controller::class, 'editPrioritas']
    )->name('prioritas.pokja4.edit');

    Route::put(
        '/inovasi/prioritas/pokja4/update/{id}',
        [KegiatanPokja4Controller::class, 'updatePrioritas']
    )->name('prioritas.pokja4.update');

    Route::delete(
        '/inovasi/prioritas/pokja4/hapus/{id}',
        [KegiatanPokja4Controller::class, 'destroyPrioritas']
    )->name('prioritas.pokja4.destroy');


    /*
|--------------------------------------------------------------------------
| UNGGULAN
|--------------------------------------------------------------------------
*/

    Route::get('/inovasi/unggulan', function () {

        if (Auth::guard('web')->check()) {

            return app(
                \App\Http\Controllers\backend\UnggulanController::class
            )->kabupaten();
        }

        return app(
            \App\Http\Controllers\backend\UnggulanController::class
        )->index();
    })->name('unggulan.index');


    /*
|--------------------------------------------------------------------------
| UNGGULAN BULANAN
|--------------------------------------------------------------------------
*/

    Route::get(
        '/inovasi/unggulan/bulanan',
        [RekapBulananController::class, 'unggulan']
    )->name('unggulan.bulanan');

    Route::get(
        '/inovasi/unggulan/bulanan/edit/{id}',
        [RekapBulananController::class, 'editUnggulan']
    )->name('unggulan.bulanan.edit');

    Route::put(
        '/inovasi/unggulan/bulanan/update/{id}',
        [RekapBulananController::class, 'updateUnggulan']
    )->name('unggulan.bulanan.update');

    Route::delete(
        '/inovasi/unggulan/bulanan/hapus/{id}',
        [RekapBulananController::class, 'destroyUnggulan']
    )->name('unggulan.bulanan.destroy');


    /*
|--------------------------------------------------------------------------
| UNGGULAN TAHUNAN
|--------------------------------------------------------------------------
*/

    Route::get(
        '/inovasi/unggulan/tahunan',
        [RekapTahunanController::class, 'unggulan']
    )->name('unggulan.tahunan');

    Route::get(
        '/inovasi/unggulan/tahunan/edit/{id}',
        [RekapTahunanController::class, 'editUnggulan']
    )->name('unggulan.tahunan.edit');

    Route::put(
        '/inovasi/unggulan/tahunan/update/{id}',
        [RekapTahunanController::class, 'updateUnggulan']
    )->name('unggulan.tahunan.update');

    Route::delete(
        '/inovasi/unggulan/tahunan/hapus/{id}',
        [RekapTahunanController::class, 'destroyUnggulan']
    )->name('unggulan.tahunan.destroy');


    /*
|--------------------------------------------------------------------------
| UNGGULAN POSYANDU
|--------------------------------------------------------------------------
*/

    Route::get(
        '/inovasi/unggulan/posyandu',
        [PosyanduController::class, 'index']
    )->name('unggulan.posyandu');

    Route::get(
        '/inovasi/unggulan/posyandu/edit/{id}',
        [PosyanduController::class, 'edit']
    )->name('unggulan.posyandu.edit');

    Route::put(
        '/inovasi/unggulan/posyandu/update/{id}',
        [PosyanduController::class, 'update']
    )->name('unggulan.posyandu.update');

    Route::delete(
        '/inovasi/unggulan/posyandu/hapus/{id}',
        [PosyanduController::class, 'destroy']
    )->name('unggulan.posyandu.destroy');


    /*
|--------------------------------------------------------------------------
| UNGGULAN KEGIATAN POKJA 4
|--------------------------------------------------------------------------
*/

    Route::get(
        '/inovasi/unggulan/pokja4',
        [KegiatanPokja4Controller::class, 'index']
    )->name('unggulan.pokja4');

    Route::get(
        '/inovasi/unggulan/pokja4/edit/{id}',
        [KegiatanPokja4Controller::class, 'edit']
    )->name('unggulan.pokja4.edit');

    Route::put(
        '/inovasi/unggulan/pokja4/update/{id}',
        [KegiatanPokja4Controller::class, 'update']
    )->name('unggulan.pokja4.update');

    Route::delete(
        '/inovasi/unggulan/pokja4/hapus/{id}',
        [KegiatanPokja4Controller::class, 'destroy']
    )->name('unggulan.pokja4.destroy');

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL & JSON LAINNYA
    |--------------------------------------------------------------------------
    */
    Route::post('/export-pokja1', [Pokja1ExportController::class, 'exportToSheet'])->name('export.pokja1');
    Route::get('/pokja1/filter', [App\Http\Controllers\backend\Pokja1Controller::class, 'filter'])->name('pokja1.filter');
    Route::get('/api-export/pokja1', [App\Http\Controllers\backend\Pokja1Controller::class, 'getExportData'])->name('pokja1.exportJson');

    Route::post('/export-pokja4', [Pokja4ExportController::class, 'exportToSheet'])->name('export.pokja4');
    Route::get('/api-export/pokja2', [App\Http\Controllers\backend\Pokja2Controller::class, 'getExportData'])->name('pokja2.exportJson');
    Route::get('/api-export/pokja3', [App\Http\Controllers\backend\Pokja3Controller::class, 'getExportData'])->name('pokja3.exportJson');

    /*
    |--------------------------------------------------------------------------
    | KHUSUS ADMIN (SUPER ADMIN)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin'])->group(function () {
        Route::resource('ttd', App\Http\Controllers\backend\TtdController::class);
        Route::resource('ttdketua', App\Http\Controllers\backend\TtdKetuaController::class);
        Route::resource('ttdwakilketua', App\Http\Controllers\backend\TtdWakilKetuaController::class);

        Route::resource('input_berita', App\Http\Controllers\backend\InputBeritaController::class);
        Route::resource('input_pengumuman', App\Http\Controllers\backend\InputPengumumanController::class);
    });
    



    // === TAMBAHKAN RUTE INI KE DALAM MIDDLEWARE ===
    Route::get('/cetak-pokja1', [App\Http\Controllers\backend\Pokja1Controller::class, 'cetak'])->name('pokja1.cetak');

    
    // ... rute lainnya ...
});