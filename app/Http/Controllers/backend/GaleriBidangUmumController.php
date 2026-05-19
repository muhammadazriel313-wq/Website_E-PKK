<?php

namespace App\Http\Controllers\backend;

use App\Models\Ttd;
use App\Models\Ttds;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

use Locale;

class GaleriBidangUmumController extends Controller
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
                    'Laporan Umum'
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

                ->where('galerys.bidang', 'Laporan Umum')

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
            'backend.galeribidangumum',
            compact('data')
        );
    }


    public function edit(string $id)
    {
        $data = Galeri::find($id);
        return view('backend.tampil_galeribidangumum', compact('data'));
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

                // MASUK KE WEB KAB
                'status'    => 'upload1',
            ]);

            return redirect()
                ->route('galeribidangumum.index')
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
                ->route('galeribidangumum.index')
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

        return redirect()->route('galeribidangumum.index')->with(['success' => 'Berhasil Menghapus Gambar dalam Galeri']);
    }

    public function filter(Request $request)
    {
        if ($request->has('search')) {
            $bidangumum = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'Kader Pokja I')->where('bidang', 'Laporan Umum')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $bidangumum1 = Galeri::where('created_at', 'LIKE', '%' . $request->search . '%')->where('pokja', 'Kader Pokja I')->where('bidang', 'Laporan Umum')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $tanggal = $request->input('search');
            $carbonDate = Carbon::parse($tanggal);
            $tanggal = $carbonDate->isoFormat('MMMM');

            $tanggal2 = $request->input('search');

            $ketua = Ttd::where('jabatan', 'Sekretaris')->where('pokja', 'Bidang Umum')->get();
            $wakil = Ttd::where('jabatan', 'Ketua')->get();

            return view('backend.cetak_galeri_bulan_bidangumum', compact('bidangumum', 'bidangumum1', 'tanggal', 'tanggal2', 'ketua', 'wakil'));
        } elseif ($request->has('search2')) {
            $janu = 1;
            $jan = Galeri::whereMonth('created_at', $janu)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $febr = 2;
            $feb = Galeri::whereMonth('created_at', $febr)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $mare = 3;
            $mar = Galeri::whereMonth('created_at', $mare)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $apri = 4;
            $apr = Galeri::whereMonth('created_at', $apri)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $meii = 5;
            $mei = Galeri::whereMonth('created_at', $meii)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $juni = 6;
            $jun = Galeri::whereMonth('created_at', $juni)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $juli = 7;
            $jul = Galeri::whereMonth('created_at', $juli)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $agus = 8;
            $agu = Galeri::whereMonth('created_at', $agus)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $sept = 9;
            $sep = Galeri::whereMonth('created_at', $sept)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $okto = 10;
            $okt = Galeri::whereMonth('created_at', $okto)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $nove = 11;
            $nov = Galeri::whereMonth('created_at', $nove)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $dese = 12;
            $des = Galeri::whereMonth('created_at', $dese)->where('created_at', 'LIKE', '%' . $request->search2 . '%')->where('pokja', 'Kader Pokja I')->where('status', 'Upload')->orderBy('created_at', 'ASC')->get();

            $currentDate = Carbon::now();
            $formattedDate = $currentDate->isoFormat('dddd, D MMMM YYYY');
            $tanggal = $request->input('search2');

            $tanggal2 = $request->input('search2');

            $ketua = Ttd::where('jabatan', 'Sekretaris')->where('pokja', 'Bidang Umum')->get();
            $wakil = Ttds::where('jabatan', 'Wakil Ketua I')->get();

            return view('backend.cetak_galeri_tahun_bidangumum', compact(
                'jan',
                'feb',
                'mar',
                'apr',
                'mei',
                'jun',
                'jul',
                'agu',
                'sep',
                'okt',
                'nov',
                'des',
                'tanggal',
                'tanggal2',
                'ketua',
                'wakil'
            ));
        } else {
        }
    }
}
