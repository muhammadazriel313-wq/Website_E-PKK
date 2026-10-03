<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Models\Galeri;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class GaleriKelestarianController extends Controller
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
                    'Kelestarian Lingkungan Hidup'
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

                ->where('galerys.bidang', 'Kelestarian Lingkungan Hidup')

                // DATA DARI DESA
                ->where('galerys.id_role', 1)

                // SESUAI KECAMATAN LOGIN
                ->where(
                    'users_mobile.id_subdistrict',
                    $user->id_subdistrict
                )

                // PROSES + SUDAH DIREVIEW
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
            'backend.galerikelestarian',
            compact('data')
        );
    }

    public function edit(string $id)
    {
        $data = Galeri::find($id);
        return view('backend.tampil_galerikelestarian', compact('data'));
    }

    public function update(Request $request, string $id)
    {
        $data = Galeri::find($id);

        // =====================================
        // WEB KECAMATAN
        // DESA -> KAB
        // =====================================
        if (auth()->guard('pengguna')->check()) {

            $data->update([

                'deskripsi' => $request->deskripsi,

                'tanggal'   => $request->tanggal,

                // FIX LOKASI
                'lokasi'    => $request->tempat_kegiatan,
                'nama_peserta' => $request->has('nama_peserta') ? (function() use ($request, $data) {
                    $val = $request->nama_peserta;
                    if (is_array($val)) return json_encode(array_values(array_filter(array_map('trim', $val))));
                    if (is_string($val) && trim($val) !== '') {
                        $dec = json_decode($val, true);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($dec)) return json_encode(array_values(array_filter(array_map('trim', $dec))));
                        return json_encode(array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $val))))));
                    }
                    return null;
                })() : $data->nama_peserta,

                // MASUK KE WEB KAB
                'status'    => 'upload1',
            ]);

            return redirect()
                ->route('galerikelestarian.index')
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
                'nama_peserta' => $request->has('nama_peserta') ? (function() use ($request, $data) {
                    $val = $request->nama_peserta;
                    if (is_array($val)) return json_encode(array_values(array_filter(array_map('trim', $val))));
                    if (is_string($val) && trim($val) !== '') {
                        $dec = json_decode($val, true);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($dec)) return json_encode(array_values(array_filter(array_map('trim', $dec))));
                        return json_encode(array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $val))))));
                    }
                    return null;
                })() : $data->nama_peserta,

                // TAMPIL LANDING PAGE
                'status'    => 'upload2',
            ]);

            return redirect()
                ->route('galerikelestarian.index')
                ->with([
                    'success' => 'Berhasil Publish Ke Landing Page'
                ]);
        }
    }
    
    public function destroy($id)
    {
        $data = Galeri::findOrFail($id);

        // Ganti dengan path sesuai lokasi file kamu
        $filePath = public_path('frontend2/gallery2/' . $data->gambar);

        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        $data->delete();
        return redirect()->route('galerikelestarian.index')->with(['success' => 'Berhasil Menghapus Gambar dalam Galeri']);
    }

}