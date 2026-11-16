<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;

/**
 * Halaman peringkat desa dan kecamatan di website (admin kabupaten & akun kecamatan/desa).
 * Datanya diambil lewat API yang sama dengan aplikasi mobile: /api/ranking/desa dan /api/ranking/kecamatan.
 */
class PeringkatController extends Controller
{
    public function index()
    {
        return view('backend.peringkat');
    }
}