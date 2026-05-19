<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Models\Galeri;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class GaleriPenghayatanController extends Controller
{
    public function index()
    {
        // =====================================
        // WEB KABUPATEN
        // =====================================
        if (auth()->guard('web')->check()) {

            $data = Galeri::leftJoin(
                'users_mobile',
                'galerys.id_user',
                '=',
                'users_mobile.id'
            )
            ->where(
                'galerys.bidang',
                'Penghayatan & Pengamalan Pancasila'
            )
            // =====================================
            // FILTER ROLE + STATUS
            // =====================================
            ->where(function ($query) {
                // DATA DARI DESA
                $query->where(function ($q) {
                    $q->where('galerys.id_role', 1)
                    ->whereIn('galerys.status', [
                        'upload1',
                        'upload2'
                    ]);

                })

                // DATA DARI MOBILE KECAMATAN
                ->orWhere(function ($q) {
                    $q->where('galerys.id_role', 2)
                    ->whereIn('galerys.status', [
                        'Proses',
                        'upload2'
                    ]);
                });
            })

            ->select('galerys.*')

            ->latest('galerys.created_at')

            ->get();
        }

        // =====================================
        // WEB KECAMATAN
        // =====================================
        elseif (auth()->guard('pengguna')->check()) {

            $user = auth()->guard('pengguna')->user();

            $data = Galeri::leftJoin(
                'users_mobile',
                'galerys.id_user',
                '=',
                'users_mobile.id'
            )

            ->where(
                'galerys.bidang',
                'Penghayatan & Pengamalan Pancasila'
            )

            // HANYA DATA DESA
            ->where('galerys.id_role', 1)

            // SESUAI KECAMATAN LOGIN
            ->where(
                'users_mobile.id_subdistrict',
                $user->id_subdistrict
            )

            // PROSES + SUDAH REVIEW
            ->whereIn('galerys.status', [
                'Proses',
                'upload1',
                'upload2'
            ])

            ->select('galerys.*')

            ->latest('galerys.created_at')

            ->get();
        }

        return view(
            'backend.galeripenghayatan',
            compact('data')
        );
    }

    public function edit(string $id)
    {
        $data = Galeri::find($id);

        return view(
            'backend.tampil_galeripenghayatan',
            compact('data')
        );
    }

    public function update(Request $request, string $id)
    {
        $data = Galeri::find($id);

        // =====================================
        // WEB KECAMATAN
        // DESA -> WEB KAB
        // =====================================
        if (auth()->guard('pengguna')->check()) {

            $data->update([

                'deskripsi' => $request->deskripsi,

                'tanggal'   => $request->tanggal,

                'lokasi'    => $request->tempat_kegiatan,

                // MASUK KE WEB KAB
                'status'    => 'upload1',
            ]);

            return redirect()
                ->route('galeripenghayatan.index')
                ->with([
                    'success' => 'Berhasil Upload Ke Kabupaten'
                ]);
        }

        // =====================================
        // WEB KABUPATEN
        // KAB -> LANDING PAGE
        // =====================================
        if (auth()->guard('web')->check()) {

            $data->update([

                'deskripsi' => $request->deskripsi,

                'tanggal'   => $request->tanggal,

                'lokasi'    => $request->tempat_kegiatan,

                // TAMPIL LANDING PAGE
                'status'    => 'upload2',
            ]);

            return redirect()
                ->route('galeripenghayatan.index')
                ->with([
                    'success' => 'Berhasil Publish Ke Landing Page'
                ]);
        }
    }

    public function destroy($id)
    {
        $data = Galeri::findOrFail($id);

        $filePath = public_path(
            'storage/gallery/' . $data->gambar
        );

        if (File::exists($filePath)) {

            File::delete($filePath);
        }

        $data->delete();

        return redirect()
            ->route('galeripenghayatan.index')
            ->with([
                'success' =>
                'Berhasil Menghapus Gambar dalam Galeri'
            ]);
    }
}