<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RekapBulananController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | UNGGULAN BULANAN
    |--------------------------------------------------------------------------
    */

    public function unggulan(Request $request)
    {
        $data = collect();

        /*
        |--------------------------------------------------------------------------
        | DEFAULT STATUS
        |--------------------------------------------------------------------------
        */

        $status = $request->status;

        if (empty($status)) {

            if (Auth::guard('web')->check()) {

                $status = 'Disetujui1';
            }

            if (Auth::guard('pengguna')->check()) {

                $status = 'Proses';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | WEB KABUPATEN
        |--------------------------------------------------------------------------
        */

        if (Auth::guard('web')->check()) {

            $data = DB::table('rekap_desa_bulanan')

                ->leftJoin(
                    'users_mobile',
                    'rekap_desa_bulanan.id_user',
                    '=',
                    'users_mobile.id'
                )

                ->leftJoin(
                    'subdistrict',
                    'users_mobile.id_subdistrict',
                    '=',
                    'subdistrict.id'
                )

                ->leftJoin(
                    'village',
                    'users_mobile.id_village',
                    '=',
                    'village.id'
                )

                ->select(
                    'rekap_desa_bulanan.*',
                    'subdistrict.name as nama_kec',
                    'village.name as nama_desa'
                )

                ->where(
                    'rekap_desa_bulanan.kategori',
                    'Unggulan'
                )

                ->where(function ($query) use ($status) {

                    /*
                    |--------------------------------------------------------------------------
                    | SUDAH DISETUJUI
                    | WEB KABUPATEN:
                    | - DESA -> Disetujui2
                    | - KECAMATAN -> Disetujui2
                    |--------------------------------------------------------------------------
                    */

                    if ($status == 'Disetujui2') {

                        $query->whereIn(
                            'rekap_desa_bulanan.status',
                            [
                                'Disetujui2',
                                'disetujui2',
                                'DISETUJUI2'
                            ]
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | MENUNGGU PERSETUJUAN
                    | WEB KABUPATEN:
                    | - DESA -> Disetujui1
                    | - KECAMATAN -> Proses
                    |--------------------------------------------------------------------------
                    */ else {

                        /*
                        |--------------------------------------------------------------------------
                        | DATA DESA
                        |--------------------------------------------------------------------------
                        */

                        $query->where(function ($q) {

                            $q->where('users_mobile.id_role', 1)

                                ->whereIn(
                                    'rekap_desa_bulanan.status',
                                    [
                                        'Disetujui1',
                                        'disetujui1',
                                        'DISETUJUI1'
                                    ]
                                );
                        })

                            /*
                        |--------------------------------------------------------------------------
                        | DATA MOBILE KECAMATAN
                        |--------------------------------------------------------------------------
                        */

                            ->orWhere(function ($q) {

                                $q->where('users_mobile.id_role', 2)

                                    ->whereIn(
                                        'rekap_desa_bulanan.status',
                                        [
                                            'Proses',
                                            'proses',
                                            'PROSES',
                                            'Menunggu',
                                            'menunggu',
                                            'MENUNGGU'
                                        ]
                                    );
                            });
                    }
                })

                ->orderBy(
                    'rekap_desa_bulanan.id_rekap_desa_bulanan',
                    'desc'
                )

                ->get();

            return view(
                'backend.unggulan_bulanan',
                compact('data', 'status')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | WEB KECAMATAN
        |--------------------------------------------------------------------------
        */

        if (Auth::guard('pengguna')->check()) {

            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {

                $data = DB::table('rekap_desa_bulanan')

                    ->leftJoin(
                        'users_mobile',
                        'rekap_desa_bulanan.id_user',
                        '=',
                        'users_mobile.id'
                    )

                    ->leftJoin(
                        'subdistrict',
                        'users_mobile.id_subdistrict',
                        '=',
                        'subdistrict.id'
                    )

                    ->leftJoin(
                        'village',
                        'users_mobile.id_village',
                        '=',
                        'village.id'
                    )

                    ->select(
                        'rekap_desa_bulanan.*',
                        'subdistrict.name as nama_kec',
                        'village.name as nama_desa'
                    )

                    ->where(
                        'users_mobile.id_subdistrict',
                        $user->id_subdistrict
                    )

                    ->where(
                        'users_mobile.id_role',
                        1
                    )

                    ->where(
                        'rekap_desa_bulanan.kategori',
                        'Unggulan'
                    )

                    /*
                    |--------------------------------------------------------------------------
                    | STATUS WEB KECAMATAN
                    |--------------------------------------------------------------------------
                    */

                    ->whereIn(
                        'rekap_desa_bulanan.status',

                        $status == 'Disetujui1'

                            ? [
                                'Disetujui1',
                                'disetujui1',
                                'DISETUJUI1'
                            ]

                            : [
                                'Proses',
                                'proses',
                                'PROSES',
                                'Menunggu',
                                'menunggu',
                                'MENUNGGU'
                            ]
                    )

                    ->orderBy(
                        'rekap_desa_bulanan.id_rekap_desa_bulanan',
                        'desc'
                    )

                    ->get();
            }

            return view(
                'backend.unggulan_bulanan',
                compact('data', 'status')
            );
        }

        return view(
            'backend.unggulan_bulanan',
            compact('data', 'status')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT UNGGULAN
    |--------------------------------------------------------------------------
    */

    public function editUnggulan($id)
    {
        $data = DB::table('rekap_desa_bulanan')
            ->where('id_rekap_desa_bulanan', $id)
            ->first();

        if (!$data) {

            return redirect()
                ->route('unggulan.bulanan')
                ->with([
                    'error' => 'Data tidak ditemukan'
                ]);
        }

        return view(
            'backend.unggulan_bulanan_edit',
            compact('data')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE UNGGULAN
    |--------------------------------------------------------------------------
    */

    public function updateUnggulan(Request $request, $id)
    {
        try {

            $status = $request->status;

            /*
            |--------------------------------------------------------------------------
            | AUTO APPROVAL
            |--------------------------------------------------------------------------
            */

            if (
                in_array(
                    strtolower($status),
                    [
                        'disetujui',
                        'disetujui1',
                        'disetujui2'
                    ]
                )
            ) {

                $status = Auth::guard('web')->check()
                    ? 'Disetujui2'
                    : 'Disetujui1';
            }

            DB::table('rekap_desa_bulanan')

                ->where(
                    'id_rekap_desa_bulanan',
                    $id
                )

                ->update([

                    'rw' => $request->rw ?? 0,
                    'rt' => $request->rt ?? 0,
                    'dasa_wisma' => $request->dasa_wisma ?? 0,

                    'hamil' => $request->hamil ?? 0,
                    'melahirkan' => $request->melahirkan ?? 0,
                    'nifas' => $request->nifas ?? 0,
                    'meninggal' => $request->meninggal ?? 0,

                    'bayi_lahir_l' => $request->bayi_lahir_l ?? 0,
                    'bayi_lahir_p' => $request->bayi_lahir_p ?? 0,

                    'akte_kelahiran_ada' => $request->akte_kelahiran_ada ?? 0,
                    'akte_kelahiran_tidak' => $request->akte_kelahiran_tidak ?? 0,

                    'bayi_meninggal_l' => $request->bayi_meninggal_l ?? 0,
                    'bayi_meninggal_p' => $request->bayi_meninggal_p ?? 0,

                    'balita_meninggal_l' => $request->balita_meninggal_l ?? 0,
                    'balita_meninggal_p' => $request->balita_meninggal_p ?? 0,

                    'status' => $status,
                    'catatan' => $request->catatan,

                    'updated_at' => Carbon::now(),
                ]);

            return redirect()
                ->route('unggulan.bulanan')
                ->with([
                    'success' => 'Berhasil Memperbarui Laporan'
                ]);
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with([
                    'error' => 'Gagal memperbarui data : ' . $e->getMessage()
                ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS UNGGULAN
    |--------------------------------------------------------------------------
    */

    public function destroyUnggulan($id)
    {
        try {

            DB::table('rekap_desa_bulanan')

                ->where(
                    'id_rekap_desa_bulanan',
                    $id
                )

                ->delete();

            return redirect()
                ->route('unggulan.bulanan')
                ->with([
                    'success' => 'Berhasil Menghapus Laporan'
                ]);
        } catch (\Exception $e) {

            return redirect()
                ->route('unggulan.bulanan')
                ->with([
                    'error' => 'Gagal menghapus data : ' . $e->getMessage()
                ]);
        }
    }

    /*
|--------------------------------------------------------------------------
| PRIORITAS BULANAN
|--------------------------------------------------------------------------
*/

    public function prioritas(Request $request)
    {
        $data = collect();

        /*
    |--------------------------------------------------------------------------
    | DEFAULT STATUS
    |--------------------------------------------------------------------------
    */

        $status = $request->status;

        if (empty($status)) {

            if (Auth::guard('web')->check()) {

                $status = 'Disetujui1';
            }

            if (Auth::guard('pengguna')->check()) {

                $status = 'Proses';
            }
        }

        /*
    |--------------------------------------------------------------------------
    | WEB KABUPATEN
    |--------------------------------------------------------------------------
    */

        if (Auth::guard('web')->check()) {

            $data = DB::table('rekap_desa_bulanan')

                ->leftJoin(
                    'users_mobile',
                    'rekap_desa_bulanan.id_user',
                    '=',
                    'users_mobile.id'
                )

                ->leftJoin(
                    'subdistrict',
                    'users_mobile.id_subdistrict',
                    '=',
                    'subdistrict.id'
                )

                ->leftJoin(
                    'village',
                    'users_mobile.id_village',
                    '=',
                    'village.id'
                )

                ->select(
                    'rekap_desa_bulanan.*',
                    'subdistrict.name as nama_kec',
                    'village.name as nama_desa'
                )

                ->where(
                    'rekap_desa_bulanan.kategori',
                    'Prioritas'
                )

                ->where(function ($query) use ($status) {

                    /*
                |--------------------------------------------------------------------------
                | SUDAH DISETUJUI
                |--------------------------------------------------------------------------
                */

                    if ($status == 'Disetujui2') {

                        $query->whereIn(
                            'rekap_desa_bulanan.status',
                            [
                                'Disetujui2',
                                'disetujui2',
                                'DISETUJUI2'
                            ]
                        );
                    }

                    /*
                |--------------------------------------------------------------------------
                | MENUNGGU PERSETUJUAN
                |--------------------------------------------------------------------------
                */ else {

                        /*
                    |--------------------------------------------------------------------------
                    | DATA DESA
                    |--------------------------------------------------------------------------
                    */

                        $query->where(function ($q) {

                            $q->where('users_mobile.id_role', 1)

                                ->whereIn(
                                    'rekap_desa_bulanan.status',
                                    [
                                        'Disetujui1',
                                        'disetujui1',
                                        'DISETUJUI1'
                                    ]
                                );
                        })

                            /*
                    |--------------------------------------------------------------------------
                    | DATA KECAMATAN
                    |--------------------------------------------------------------------------
                    */

                            ->orWhere(function ($q) {

                                $q->where('users_mobile.id_role', 2)

                                    ->whereIn(
                                        'rekap_desa_bulanan.status',
                                        [
                                            'Proses',
                                            'proses',
                                            'PROSES',
                                            'Menunggu',
                                            'menunggu',
                                            'MENUNGGU'
                                        ]
                                    );
                            });
                    }
                })

                ->orderBy(
                    'rekap_desa_bulanan.id_rekap_desa_bulanan',
                    'desc'
                )

                ->get();

            return view(
                'backend.prioritas_bulanan',
                compact('data', 'status')
            );
        }

        /*
    |--------------------------------------------------------------------------
    | WEB KECAMATAN
    |--------------------------------------------------------------------------
    */

        if (Auth::guard('pengguna')->check()) {

            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {

                $data = DB::table('rekap_desa_bulanan')

                    ->leftJoin(
                        'users_mobile',
                        'rekap_desa_bulanan.id_user',
                        '=',
                        'users_mobile.id'
                    )

                    ->leftJoin(
                        'subdistrict',
                        'users_mobile.id_subdistrict',
                        '=',
                        'subdistrict.id'
                    )

                    ->leftJoin(
                        'village',
                        'users_mobile.id_village',
                        '=',
                        'village.id'
                    )

                    ->select(
                        'rekap_desa_bulanan.*',
                        'subdistrict.name as nama_kec',
                        'village.name as nama_desa'
                    )

                    ->where(
                        'users_mobile.id_subdistrict',
                        $user->id_subdistrict
                    )

                    ->where(
                        'users_mobile.id_role',
                        1
                    )

                    ->where(
                        'rekap_desa_bulanan.kategori',
                        'Prioritas'
                    )

                    ->whereIn(
                        'rekap_desa_bulanan.status',

                        $status == 'Disetujui1'

                            ? [
                                'Disetujui1',
                                'disetujui1',
                                'DISETUJUI1'
                            ]

                            : [
                                'Proses',
                                'proses',
                                'PROSES',
                                'Menunggu',
                                'menunggu',
                                'MENUNGGU'
                            ]
                    )

                    ->orderBy(
                        'rekap_desa_bulanan.id_rekap_desa_bulanan',
                        'desc'
                    )

                    ->get();
            }

            return view(
                'backend.prioritas_bulanan',
                compact('data', 'status')
            );
        }

        return view(
            'backend.prioritas_bulanan',
            compact('data', 'status')
        );
    }

    /*
|--------------------------------------------------------------------------
| EDIT PRIORITAS
|--------------------------------------------------------------------------
*/

    public function editPrioritas($id)
    {
        $data = DB::table('rekap_desa_bulanan')
            ->where('id_rekap_desa_bulanan', $id)
            ->first();

        if (!$data) {

            return redirect()
                ->route('prioritas.bulanan')
                ->with([
                    'error' => 'Data tidak ditemukan'
                ]);
        }

        return view(
            'backend.prioritas_bulanan_edit',
            compact('data')
        );
    }

    /*
|--------------------------------------------------------------------------
| UPDATE PRIORITAS
|--------------------------------------------------------------------------
*/

    public function updatePrioritas(Request $request, $id)
    {
        try {

            $status = $request->status;

            /*
        |--------------------------------------------------------------------------
        | AUTO APPROVAL
        |--------------------------------------------------------------------------
        */

            if (
                in_array(
                    strtolower($status),
                    [
                        'disetujui',
                        'disetujui1',
                        'disetujui2'
                    ]
                )
            ) {

                $status = Auth::guard('web')->check()
                    ? 'Disetujui2'
                    : 'Disetujui1';
            }

            DB::table('rekap_desa_bulanan')

                ->where(
                    'id_rekap_desa_bulanan',
                    $id
                )

                ->update([

                    'rw' => $request->rw ?? 0,
                    'rt' => $request->rt ?? 0,
                    'dasa_wisma' => $request->dasa_wisma ?? 0,

                    'hamil' => $request->hamil ?? 0,
                    'melahirkan' => $request->melahirkan ?? 0,
                    'nifas' => $request->nifas ?? 0,
                    'meninggal' => $request->meninggal ?? 0,

                    'bayi_lahir_l' => $request->bayi_lahir_l ?? 0,
                    'bayi_lahir_p' => $request->bayi_lahir_p ?? 0,

                    'akte_kelahiran_ada' => $request->akte_kelahiran_ada ?? 0,
                    'akte_kelahiran_tidak' => $request->akte_kelahiran_tidak ?? 0,

                    'bayi_meninggal_l' => $request->bayi_meninggal_l ?? 0,
                    'bayi_meninggal_p' => $request->bayi_meninggal_p ?? 0,

                    'balita_meninggal_l' => $request->balita_meninggal_l ?? 0,
                    'balita_meninggal_p' => $request->balita_meninggal_p ?? 0,

                    'status' => $status,
                    'catatan' => $request->catatan,

                    'updated_at' => Carbon::now(),
                ]);

            return redirect()
                ->route('prioritas.bulanan')
                ->with([
                    'success' => 'Berhasil Memperbarui Laporan'
                ]);
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with([
                    'error' => 'Gagal memperbarui data : ' . $e->getMessage()
                ]);
        }
    }

    /*
|--------------------------------------------------------------------------
| HAPUS PRIORITAS
|--------------------------------------------------------------------------
*/

    public function destroyPrioritas($id)
    {
        try {

            DB::table('rekap_desa_bulanan')

                ->where(
                    'id_rekap_desa_bulanan',
                    $id
                )

                ->delete();

            return redirect()
                ->route('prioritas.bulanan')
                ->with([
                    'success' => 'Berhasil Menghapus Laporan'
                ]);
        } catch (\Exception $e) {

            return redirect()
                ->route('prioritas.bulanan')
                ->with([
                    'error' => 'Gagal menghapus data : ' . $e->getMessage()
                ]);
        }
    }
}
