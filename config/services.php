<?php

return [

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // [PERUBAHAN 2026-10-09] Konfigurasi integrasi Google Sheets & Google Apps Script
    // Wadah Pokja 1. Nama kunci 'sheets' sengaja dipertahankan karena sudah dipakai halaman dan controller Pokja 1. Isinya dari .env:
    // SHEETS_APPS_SCRIPT_URL, SHEETS_SPREADSHEET_URL, SHEETS_TRIGGER_TOKEN.
    'sheets' => [
        'script_url' => env('SHEETS_APPS_SCRIPT_URL'),
        'spreadsheet_url' => env('SHEETS_SPREADSHEET_URL'),
        'trigger_token' => env('SHEETS_TRIGGER_TOKEN'),
    ],

    // Wadah kosong ekspor per area. Pokja 1 memakai blok 'sheets' di atas,
    // jadi blok per area dimulai dari Pokja 2. Nilai diisi lewat .env oleh
    // pemegang masing-masing.
    'pokja2' => [
        'script_url' => env('SHEETS_POKJA2_SCRIPT_URL'),
        'spreadsheet_url' => env('SHEETS_POKJA2_SPREADSHEET_URL'),
    ],

    'pokja3' => [
        'script_url' => env('SHEETS_POKJA3_SCRIPT_URL'),
        'spreadsheet_url' => env('SHEETS_POKJA3_SPREADSHEET_URL'),
    ],

    'pokja4' => [
        'script_url' => env('SHEETS_POKJA4_SCRIPT_URL'),
        'spreadsheet_url' => env('SHEETS_POKJA4_SPREADSHEET_URL'),
    ],

    'bidang_umum' => [
        'script_url' => env('SHEETS_BIDANG_UMUM_SCRIPT_URL'),
        'spreadsheet_url' => env('SHEETS_BIDANG_UMUM_SPREADSHEET_URL'),
    ],

    'export_api' => [
        'token' => env('EXPORT_API_TOKEN'),
    ],

];
