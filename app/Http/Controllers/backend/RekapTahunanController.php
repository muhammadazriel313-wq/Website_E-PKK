<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RekapTahunanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | UNGGULAN TAHUNAN
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

            $data = DB::table('rekap_desa_tahunan')

                ->leftJoin(
                    'users_mobile',
                    'rekap_desa_tahunan.id_user',
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
                    'rekap_desa_tahunan.*',
                    'subdistrict.name as nama_kec',
                    'village.name as nama_desa'
                )

                ->where(
                    'rekap_desa_tahunan.kategori',
                    'Unggulan'
                )

                ->where(function ($query) use ($status) {

                    /*
                    |--------------------------------------------------------------------------
                    | SUDAH DISETUJUI
                    |--------------------------------------------------------------------------
                    */

                    if ($status == 'Disetujui2') {

                        $query->whereIn(
                            'rekap_desa_tahunan.status',
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
                                    'rekap_desa_tahunan.status',
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
                                        'rekap_desa_tahunan.status',
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
                    'rekap_desa_tahunan.id_rekap_desa_tahunan',
                    'desc'
                )

                ->get();

            return view(
                'backend.unggulan_tahunan',
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

                $data = DB::table('rekap_desa_tahunan')

                    ->leftJoin(
                        'users_mobile',
                        'rekap_desa_tahunan.id_user',
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
                        'rekap_desa_tahunan.*',
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
                        'rekap_desa_tahunan.kategori',
                        'Unggulan'
                    )

                    ->whereIn(
                        'rekap_desa_tahunan.status',

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
                        'rekap_desa_tahunan.id_rekap_desa_tahunan',
                        'desc'
                    )

                    ->get();
            }

            return view(
                'backend.unggulan_tahunan',
                compact('data', 'status')
            );
        }

        return view(
            'backend.unggulan_tahunan',
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
        $data = DB::table('rekap_desa_tahunan')
            ->where('id_rekap_desa_tahunan', $id)
            ->first();

        if (!$data) {

            return redirect()
                ->route('unggulan.tahunan')
                ->with([
                    'error' => 'Data tidak ditemukan'
                ]);
        }

        return view(
            'backend.unggulan_tahunan_edit',
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

            DB::table('rekap_desa_tahunan')

                ->where(
                    'id_rekap_desa_tahunan',
                    $id
                )

                ->update([

                    'kader_kesehatan' => $request->kader_kesehatan ?? 0,
                    'gizi' => $request->gizi ?? 0,
                    'kesling' => $request->kesling ?? 0,
                    'phbs' => $request->phbs ?? 0,
                    'kb' => $request->kb ?? 0,
                    'posyandu' => $request->posyandu ?? 0,
                    'imunisasi_vaksinasi_bayi_balita' => $request->imunisasi_vaksinasi_bayi_balita ?? 0,
                    'pkg' => $request->pkg ?? 0,
                    'tbc' => $request->tbc ?? 0,

                    'jamban_wc' => $request->jamban_wc ?? 0,
                    'spal' => $request->spal ?? 0,
                    'tps' => $request->tps ?? 0,
                    'jumlah_mck' => $request->jumlah_mck ?? 0,
                    'pdam' => $request->pdam ?? 0,
                    'sumur' => $request->sumur ?? 0,
                    'lain_lain' => $request->lain_lain ?? 0,

                    'jml_pus' => $request->jml_pus ?? 0,
                    'jml_wus' => $request->jml_wus ?? 0,
                    'akseptor_kb_l' => $request->akseptor_kb_l ?? 0,
                    'akseptor_kb_p' => $request->akseptor_kb_p ?? 0,
                    'jml_kk_tabungan' => $request->jml_kk_tabungan ?? 0,
                    'jml_kk_asuransi' => $request->jml_kk_asuransi ?? 0,

                    'kesehatan_program' => $request->kesehatan_program ?? 0,
                    'kelestarian_lingkungan_hidup' => $request->kelestarian_lingkungan_hidup ?? 0,
                    'perencanaan_sehat_program' => $request->perencanaan_sehat_program ?? 0,

                    'status' => $status,
                    'catatan' => $request->catatan,

                    'updated_at' => Carbon::now(),
                ]);

            return redirect()
                ->route('unggulan.tahunan')
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

            DB::table('rekap_desa_tahunan')

                ->where(
                    'id_rekap_desa_tahunan',
                    $id
                )

                ->delete();

            return redirect()
                ->route('unggulan.tahunan')
                ->with([
                    'success' => 'Berhasil Menghapus Laporan'
                ]);
        } catch (\Exception $e) {

            return redirect()
                ->route('unggulan.tahunan')
                ->with([
                    'error' => 'Gagal menghapus data : ' . $e->getMessage()
                ]);
        }
    }

    /*
|--------------------------------------------------------------------------
| PRIORITAS TAHUNAN
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

            $data = DB::table('rekap_desa_tahunan')

                ->leftJoin(
                    'users_mobile',
                    'rekap_desa_tahunan.id_user',
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
                    'rekap_desa_tahunan.*',
                    'subdistrict.name as nama_kec',
                    'village.name as nama_desa'
                )

                ->where(
                    'rekap_desa_tahunan.kategori',
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
                            'rekap_desa_tahunan.status',
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
                                    'rekap_desa_tahunan.status',
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
                                        'rekap_desa_tahunan.status',
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
                    'rekap_desa_tahunan.id_rekap_desa_tahunan',
                    'desc'
                )

                ->get();

            return view(
                'backend.prioritas_tahunan',
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

                $data = DB::table('rekap_desa_tahunan')

                    ->leftJoin(
                        'users_mobile',
                        'rekap_desa_tahunan.id_user',
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
                        'rekap_desa_tahunan.*',
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
                        'rekap_desa_tahunan.kategori',
                        'Prioritas'
                    )

                    ->whereIn(
                        'rekap_desa_tahunan.status',

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
                        'rekap_desa_tahunan.id_rekap_desa_tahunan',
                        'desc'
                    )

                    ->get();
            }

            return view(
                'backend.prioritas_tahunan',
                compact('data', 'status')
            );
        }

        return view(
            'backend.prioritas_tahunan',
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
        $data = DB::table('rekap_desa_tahunan')
            ->where('id_rekap_desa_tahunan', $id)
            ->first();

        if (!$data) {

            return redirect()
                ->route('prioritas.tahunan')
                ->with([
                    'error' => 'Data tidak ditemukan'
                ]);
        }

        return view(
            'backend.prioritas_tahunan_edit',
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

            DB::table('rekap_desa_tahunan')

                ->where(
                    'id_rekap_desa_tahunan',
                    $id
                )

                ->update([

                    'kader_kesehatan' => $request->kader_kesehatan ?? 0,
                    'gizi' => $request->gizi ?? 0,
                    'kesling' => $request->kesling ?? 0,
                    'phbs' => $request->phbs ?? 0,
                    'kb' => $request->kb ?? 0,
                    'posyandu' => $request->posyandu ?? 0,
                    'imunisasi_vaksinasi_bayi_balita' => $request->imunisasi_vaksinasi_bayi_balita ?? 0,
                    'pkg' => $request->pkg ?? 0,
                    'tbc' => $request->tbc ?? 0,

                    'jamban_wc' => $request->jamban_wc ?? 0,
                    'spal' => $request->spal ?? 0,
                    'tps' => $request->tps ?? 0,
                    'jumlah_mck' => $request->jumlah_mck ?? 0,
                    'pdam' => $request->pdam ?? 0,
                    'sumur' => $request->sumur ?? 0,
                    'lain_lain' => $request->lain_lain ?? 0,

                    'jml_pus' => $request->jml_pus ?? 0,
                    'jml_wus' => $request->jml_wus ?? 0,
                    'akseptor_kb_l' => $request->akseptor_kb_l ?? 0,
                    'akseptor_kb_p' => $request->akseptor_kb_p ?? 0,
                    'jml_kk_tabungan' => $request->jml_kk_tabungan ?? 0,
                    'jml_kk_asuransi' => $request->jml_kk_asuransi ?? 0,

                    'kesehatan_program' => $request->kesehatan_program ?? 0,
                    'kelestarian_lingkungan_hidup' => $request->kelestarian_lingkungan_hidup ?? 0,
                    'perencanaan_sehat_program' => $request->perencanaan_sehat_program ?? 0,

                    'status' => $status,
                    'catatan' => $request->catatan,

                    'updated_at' => Carbon::now(),
                ]);

            return redirect()
                ->route('prioritas.tahunan')
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

            DB::table('rekap_desa_tahunan')

                ->where(
                    'id_rekap_desa_tahunan',
                    $id
                )

                ->delete();

            return redirect()
                ->route('prioritas.tahunan')
                ->with([
                    'success' => 'Berhasil Menghapus Laporan'
                ]);
        } catch (\Exception $e) {

            return redirect()
                ->route('prioritas.tahunan')
                ->with([
                    'error' => 'Gagal menghapus data : ' . $e->getMessage()
                ]);
        }
    }
}
