<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KegiatanPokja4Controller extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $data = collect();

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
        | ADMIN KABUPATEN
        |--------------------------------------------------------------------------
        */

        if (Auth::guard('web')->check()) {

            $data = DB::table('kegiatan_pokja4')

                ->leftJoin(
                    'users_mobile',
                    'kegiatan_pokja4.id_user',
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
                    'kegiatan_pokja4.*',
                    'users_mobile.id_role',
                    'subdistrict.name as nama_kec',
                    'village.name as nama_desa'
                )

                ->where('kegiatan_pokja4.kategori', 'unggulan')

                ->where(function ($query) use ($status) {

                    if ($status == 'Disetujui2') {

                        $query->whereIn(
                            'kegiatan_pokja4.status',
                            [
                                'Disetujui2',
                                'disetujui2',
                                'DISETUJUI2'
                            ]
                        );
                    } else {

                        /*
                        |--------------------------------------------------------------------------
                        | DESA
                        |--------------------------------------------------------------------------
                        */

                        $query->where(function ($q) {

                            $q->where('users_mobile.id_role', 1)

                                ->whereIn(
                                    'kegiatan_pokja4.status',
                                    [
                                        'Disetujui1',
                                        'disetujui1',
                                        'DISETUJUI1'
                                    ]
                                );
                        })

                            /*
                        |--------------------------------------------------------------------------
                        | KECAMATAN
                        |--------------------------------------------------------------------------
                        */

                            ->orWhere(function ($q) {

                                $q->where('users_mobile.id_role', 2)

                                    ->whereIn(
                                        'kegiatan_pokja4.status',
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

                ->orderBy('id_kegiatan_pokja4', 'desc')

                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | KECAMATAN
        |--------------------------------------------------------------------------
        */

        if (Auth::guard('pengguna')->check()) {

            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {

                $data = DB::table('kegiatan_pokja4')

                    ->leftJoin(
                        'users_mobile',
                        'kegiatan_pokja4.id_user',
                        '=',
                        'users_mobile.id'
                    )

                    ->leftJoin(
                        'village',
                        'users_mobile.id_village',
                        '=',
                        'village.id'
                    )

                    ->select(
                        'kegiatan_pokja4.*',
                        'users_mobile.id_role',
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
                        'kegiatan_pokja4.kategori',
                        'unggulan'
                    )

                    ->whereIn(
                        'kegiatan_pokja4.status',

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

                    ->orderBy('id_kegiatan_pokja4', 'desc')

                    ->get();
            }
        }

        return view(
            'backend.unggulan_pokja4',
            compact('data', 'status')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $data = DB::table('kegiatan_pokja4')

            ->where('id_kegiatan_pokja4', $id)

            ->first();

        return view(
            'backend.unggulan_pokja4_edit',
            compact('data')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $status = $request->status;

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

        DB::table('kegiatan_pokja4')

            ->where('id_kegiatan_pokja4', $id)

            ->update([

                'status' => $status,
                'catatan' => $request->catatan,
                'updated_at' => Carbon::now()

            ]);

        return redirect()

            ->route('unggulan.pokja4')

            ->with([
                'success' => 'Berhasil memperbarui data'
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        DB::table('kegiatan_pokja4')

            ->where('id_kegiatan_pokja4', $id)

            ->delete();

        return redirect()

            ->route('unggulan.pokja4')

            ->with([
                'success' => 'Berhasil menghapus data'
            ]);
    }

    /*
|--------------------------------------------------------------------------
| PRIORITAS
|--------------------------------------------------------------------------
*/

    public function prioritas(Request $request)
    {
        $data = collect();

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
    | ADMIN KABUPATEN
    |--------------------------------------------------------------------------
    */

        if (Auth::guard('web')->check()) {

            $data = DB::table('kegiatan_pokja4')

                ->leftJoin(
                    'users_mobile',
                    'kegiatan_pokja4.id_user',
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
                    'kegiatan_pokja4.*',
                    'users_mobile.id_role',
                    'subdistrict.name as nama_kec',
                    'village.name as nama_desa'
                )

                ->where('kegiatan_pokja4.kategori', 'prioritas')

                ->where(function ($query) use ($status) {

                    if ($status == 'Disetujui2') {

                        $query->whereIn(
                            'kegiatan_pokja4.status',
                            [
                                'Disetujui2',
                                'disetujui2',
                                'DISETUJUI2'
                            ]
                        );
                    } else {

                        /*
                    |--------------------------------------------------------------------------
                    | DESA
                    |--------------------------------------------------------------------------
                    */

                        $query->where(function ($q) {

                            $q->where('users_mobile.id_role', 1)

                                ->whereIn(
                                    'kegiatan_pokja4.status',
                                    [
                                        'Disetujui1',
                                        'disetujui1',
                                        'DISETUJUI1'
                                    ]
                                );
                        })

                            /*
                    |--------------------------------------------------------------------------
                    | KECAMATAN
                    |--------------------------------------------------------------------------
                    */

                            ->orWhere(function ($q) {

                                $q->where('users_mobile.id_role', 2)

                                    ->whereIn(
                                        'kegiatan_pokja4.status',
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

                ->orderBy('id_kegiatan_pokja4', 'desc')

                ->get();
        }

        /*
    |--------------------------------------------------------------------------
    | KECAMATAN
    |--------------------------------------------------------------------------
    */

        if (Auth::guard('pengguna')->check()) {

            $user = Auth::guard('pengguna')->user();

            if ($user->id_role == 2) {

                $data = DB::table('kegiatan_pokja4')

                    ->leftJoin(
                        'users_mobile',
                        'kegiatan_pokja4.id_user',
                        '=',
                        'users_mobile.id'
                    )

                    ->leftJoin(
                        'village',
                        'users_mobile.id_village',
                        '=',
                        'village.id'
                    )

                    ->select(
                        'kegiatan_pokja4.*',
                        'users_mobile.id_role',
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
                        'kegiatan_pokja4.kategori',
                        'prioritas'
                    )

                    ->whereIn(
                        'kegiatan_pokja4.status',

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

                    ->orderBy('id_kegiatan_pokja4', 'desc')

                    ->get();
            }
        }

        return view(
            'backend.prioritas_pokja4',
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
        $data = DB::table('kegiatan_pokja4')

            ->where('id_kegiatan_pokja4', $id)

            ->first();

        return view(
            'backend.prioritas_pokja4_edit',
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
        $status = $request->status;

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

        DB::table('kegiatan_pokja4')

            ->where('id_kegiatan_pokja4', $id)

            ->update([

                'status' => $status,
                'catatan' => $request->catatan,
                'updated_at' => Carbon::now()

            ]);

        return redirect()

            ->route('prioritas.pokja4')

            ->with([
                'success' => 'Berhasil memperbarui data'
            ]);
    }

    /*
|--------------------------------------------------------------------------
| DELETE PRIORITAS
|--------------------------------------------------------------------------
*/

    public function destroyPrioritas($id)
    {
        DB::table('kegiatan_pokja4')

            ->where('id_kegiatan_pokja4', $id)

            ->delete();

        return redirect()

            ->route('prioritas.pokja4')

            ->with([
                'success' => 'Berhasil menghapus data'
            ]);
    }
}
