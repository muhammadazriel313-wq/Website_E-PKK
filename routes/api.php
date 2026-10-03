<?php

use App\Http\Controllers\Api\AnnouncementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\RiwayatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

//  AUTH GROUP
Route::prefix('auth')->group(function () {

    //  LOGIN
    Route::post('/login', [AuthController::class, 'login']);

    //  REGISTER
    Route::post('/register', [AuthController::class, 'register']);

    //  GET ROLE
    Route::get('/role', [AuthController::class, 'getRole']);
    // contoh: /api/auth/role?id=1

    //  GET ORGANIZATION
    Route::get('/organization', [AuthController::class, 'getOrganization']);
    // contoh: /api/auth/organization?id=UUID

    //  SEND OTP
    Route::post('/send-otp', [AuthController::class, 'sendOtp']);

    // CHECK USER
    Route::get('/check-user', [AuthController::class, 'checkUser']);

    // UPDATE PASSWOARD
    Route::post('/update-password', [AuthController::class, 'updatePassword']);
});

// PENGUMUMAN
Route::get('/announcement', [AnnouncementController::class, 'index']);
Route::get('/announcement/{id}', [AnnouncementController::class, 'show']);

// PROFIL
Route::get('/profile', [ProfileController::class, 'getProfile']);
Route::post('/profile/update', [ProfileController::class, 'updateProfile']);

// RIWAYAT
Route::get('/riwayat', [RiwayatController::class, 'getRiwayat']);
Route::get('/report', [RiwayatController::class, 'getReport']);
Route::get('/report/detail', [RiwayatController::class, 'getDetailReport']);
Route::post('/report/cancel', [RiwayatController::class, 'cancelReport']);
Route::post('/report/update', [RiwayatController::class, 'updateLaporan']);


// LAPORAN
Route::post('/report/galeri', [ReportController::class, 'insertGaleri']);

Route::post('/report/laporan-umum', [ReportController::class, 'storeLaporanUmum']);

// POKJA 1
Route::post('/report/kader-pokja1', [ReportController::class, 'insertKaderPokja1']);
Route::post('/report/gotong-royong', [ReportController::class, 'insertGotongRoyong']);
Route::post('/report/penghayatan', [ReportController::class, 'insertPenghayatan']);

// POKJA 2
Route::post('/report/pendidikan-keterampilan', [ReportController::class, 'insertPendidikanKeterampilan']);
Route::post('/report/pengembangan-kehidupan', [ReportController::class, 'insertPengembanganKehidupan']);

// POKJA 3
Route::post('/report/kader-pokja3', [ReportController::class, 'insertKaderPokja3']);
Route::post('/report/pangan', [ReportController::class, 'insertPangan']);
Route::post('/report/sandang', [ReportController::class, 'insertSandang']);
Route::post('/report/perumahan', [ReportController::class, 'insertPerumahan']);

// POKJA 4
Route::post('/report/kader-pokja4', [ReportController::class, 'insertKaderPokja4']);
Route::post('/report/kesehatan', [ReportController::class, 'insertKesehatan']);
Route::post('/report/lingkungan-hidup', [ReportController::class, 'insertLingkunganHidup']);
Route::post('/report/perencanaan-sehat', [ReportController::class, 'insertPerencanaanSehat']);
Route::post('/report/rekap-desa-bulanan', [ ReportController::class, 'insertRekapDesaBulanan']);
Route::post('/report/rekap-desa-tahunan', [ ReportController::class, 'insertRekapDesaTahunan']);
Route::post('/report/posyandu', [ ReportController::class, 'insertPosyandu']);
Route::post('/report/kegiatan-pokja4', [ ReportController::class, 'insertKegiatanPokja4']);