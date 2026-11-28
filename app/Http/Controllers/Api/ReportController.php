<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ReportController extends Controller
{
    /**
     * Validasi input. Bila gagal, langsung balas 422 dengan pesan aslinya
     * supaya aplikasi mobile tidak menerima error 500.
     * Mengembalikan null bila input valid.
     */
    private function validasiData(Request $request, array $aturan)
    {
        $validator = \Illuminate\Support\Facades\Validator::make(
            $request->all(),
            $aturan
        );

        if ($validator->fails()) {
            $errors = $validator->errors();
            $field = array_key_first($errors->messages()) ?? 'Data';
            $pesan = $errors->first($field);

            if (is_string($pesan) && str_contains($pesan, 'must be an integer')) {
                $pesan = 'Isian ' . str_replace('_', ' ', $field)
                    . ' harus berupa angka.';
            }

            return response()->json([
                'statusCode' => 422,
                'message' => $pesan,
                'data' => null,
                'error' => ['message' => $pesan],
            ], 422);
        }

        return null;
    }

    // UPLOAD FOTO
    public function insertGaleri(Request $request)
    {
        try {

            // Jabatan: untuk akun Bidang Umum (id_organization 5) wajib, untuk akun lainnya opsional
            if ((string) $request->id_organization === '5') {
                $jabatanRules = ['required', 'string'];
            } else {
                $jabatanRules = ['nullable', 'string'];
            }

            // VALIDASI
            $request->validate([
                // [PERUBAHAN 03-10-2026] Menambahkan format webp pada validasi mimes; kode lama di bawah dinonaktifkan
                // 'gambar' => 'required|image|mimes:heic,jpeg,jpg,png,gif',
                'gambar' => 'required|image|mimes:heic,jpeg,jpg,png,gif,webp',
                'id_user' => 'required',
                'deskripsi' => 'required',
                'pokja' => 'required',
                'bidang' => 'required',
                'id_role' => 'required',
                'id_organization' => 'required',

                // TAMBAHAN NAMA PESERTA & LOKASI
                'nama_peserta' => 'nullable',
                'lokasi' => 'nullable|string',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',

                // NAMA PESERTA KEGIATAN (array / JSON string / satu nama per baris)
                'nama_peserta' => 'nullable',

                // JABATAN (kolom JABATAN di Buku Kegiatan)
                'jabatan' => $jabatanRules,
            ]);

            // UUID
            $uuid = 'GAL-' . strtoupper(Str::random(6));

            // =========================
            // UPLOAD FILE
            // =========================

            $file = $request->file('gambar');

            $fileName =
                uniqid() .
                '_' .
                $file->getClientOriginalName();

            // folder tujuan
            $destinationPath =
                public_path('storage/gallery');

            // buat folder jika belum ada
            if (!File::exists($destinationPath)) {

                File::makeDirectory(
                    $destinationPath,
                    0777,
                    true,
                    true
                );
            }

            // pindah file langsung ke public/storage/gallery
            $file->move(
                $destinationPath,
                $fileName
            );

            // =========================
            // INSERT DATABASE
            // =========================

            DB::table('galerys')->insert([

                'uuid' => $uuid,
                'id_user' => $request->id_user,
                'deskripsi' => $request->deskripsi,
                // [PERUBAHAN 03-10-2026] Menyimpan nama_peserta (JSON)
                'nama_peserta' => (function() use ($request) {
                    $val = $request->nama_peserta;
                    if (is_array($val)) {
                        return json_encode(array_values(array_filter(array_map('trim', $val))));
                    } elseif (is_string($val) && trim($val) !== '') {
                        $decoded = json_decode($val, true);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                            return json_encode(array_values(array_filter(array_map('trim', $decoded))));
                        }
                        return json_encode([trim($val)]);
                    }
                    return null;
                })(),

                // JABATAN (kolom JABATAN di Buku Kegiatan)
                'jabatan' => trim((string) $request->jabatan) !== '' ? trim($request->jabatan) : null,

                // Tanggal kegiatan (kolom TANGGAL di Buku Kegiatan) = tanggal kirim
                'tanggal' => now(),

                'gambar' => $fileName,
                'pokja' => $request->pokja,
                'bidang' => $request->bidang,
                'status' => $request->status ?? 'Proses',

                'created_at' => now(),
                'updated_at' => now(),

                'id_role' => $request->id_role,
                'id_organization' => $request->id_organization,

                // LOKASI
                'lokasi' => $request->lokasi,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            // =========================
            // AMBIL DATA
            // =========================

            $data = DB::table('galerys')
                ->leftJoin(
                    'role_users_mobile',
                    'galerys.id_role',
                    '=',
                    'role_users_mobile.id'
                )
                ->leftJoin(
                    'role_organization',
                    'galerys.id_organization',
                    '=',
                    'role_organization.id'
                )
                ->where('galerys.uuid', $uuid)
                ->select(
                    'galerys.*',
                    'role_users_mobile.id as role_id',
                    'role_users_mobile.name as role_name',
                    'role_organization.id as organization_id',
                    'role_organization.name as organization_name'
                )
                ->first();

            // =========================
            // RESPONSE SUCCESS
            // =========================

            return response()->json([

                'statusCode' => 200,

                'message' => 'Data galeri berhasil disimpan',

                'data' => [

                    'id' => $data->id,
                    'uuid' => $data->uuid,
                    'id_user' => $data->id_user,
                    'deskripsi' => $data->deskripsi,
                    'nama_peserta' => $data->nama_peserta,
                    'gambar' => $data->gambar,
                    'pokja' => $data->pokja,
                    'bidang' => $data->bidang,
                    'status' => $data->status,

                    'created_at' => $data->created_at,
                    'updated_at' => $data->updated_at,

                    'lokasi' => $data->lokasi,
                    'latitude' => $data->latitude,
                    'longitude' => $data->longitude,

                    'role' => [
                        'id' => $data->role_id,
                        'name' => $data->role_name
                    ],

                    'organization' => [
                        'id' => $data->organization_id,
                        'name' => $data->organization_name
                    ]
                ],

                'error' => null
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            // Validasi gagal: tampilkan alasan sebenarnya (mis. "gambar harus berupa gambar")
            $pesan = collect($e->errors())->flatten()->first() ?? 'Data tidak valid';

            return response()->json([

                'statusCode' => 422,

                'message' => $pesan,

                'data' => null,

                'error' => [
                    'message' => $e->getMessage(),
                    'fields' => $e->errors()
                ]

            ], 422);
        } catch (\Exception $e) {

            // Catat penyebab asli di storage/logs/laravel.log
            \Illuminate\Support\Facades\Log::error('insertGaleri gagal: ' . $e->getMessage());

            // HAPUS FILE JIKA GAGAL
            if (isset($fileName)) {

                $filePath =
                    public_path(
                        'storage/gallery/' . $fileName
                    );

                if (File::exists($filePath)) {

                    File::delete($filePath);
                }
            }

            return response()->json([

                'statusCode' => 400,

                'message' => 'Gagal menyimpan data',

                'data' => null,

                'error' => [
                    'message' => $e->getMessage()
                ]

            ], 400);
        }
    }



    /**
     * Ubah input nama peserta (array, JSON string, atau teks satu nama per baris)
     * menjadi JSON array string, sama seperti format yang dipakai web.
     * Mengembalikan null jika tidak ada nama.
     */
    private function normalizeNamaPeserta($value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_string($value)) {
            $trim = trim($value);
            if ($trim === '') {
                return null;
            }
            $decoded = json_decode($trim, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $value = $decoded;
            } else {
                $value = explode("\n", str_replace("\r", '', $trim));
            }
        }

        if (!is_array($value)) {
            return null;
        }

        $names = [];
        foreach ($value as $name) {
            $name = trim((string) $name);
            if ($name !== '' && !in_array(mb_strtolower($name), array_map('mb_strtolower', $names), true)) {
                $names[] = $name;
            }
        }

        return count($names) ? json_encode($names, JSON_UNESCAPED_UNICODE) : null;
    }

    /// BIDANG UMUM 
    public function storeLaporanUmum(Request $request)
    {
        try {
            //  VALIDASI
            if ($gagal = $this->validasiData($request, [
                'id_user' => 'required',
                'id_role' => 'required',
                'id_organization' => 'required',
                'PKK_RW' => 'integer|min:0',
                'PKK_RT' => 'integer|min:0',
                'desa_wisma' => 'integer|min:0',
                'KRT' => 'integer|min:0',
                'KK' => 'integer|min:0',
                'jiwa_laki' => 'integer|min:0',
                'jiwa_perempuan' => 'integer|min:0',
                'anggota_laki' => 'integer|min:0',
                'anggota_perempuan' => 'integer|min:0',
                'umum_laki' => 'integer|min:0',
                'umum_perempuan' => 'integer|min:0',
                'khusus_laki' => 'integer|min:0',
                'khusus_perempuan' => 'integer|min:0',
                'honorer_laki' => 'integer|min:0',
                'honorer_perempuan' => 'integer|min:0',
                'bantuan_laki' => 'integer|min:0',
                'bantuan_perempuan' => 'integer|min:0',
            ])) {
                return $gagal;
            }

            //  UUID
            $uuid = 'PKKUM-' . strtoupper(\Illuminate\Support\Str::random(6));

            //  INSERT DATA
            DB::table('laporan_umum')->insert([
                'uuid' => $uuid,
                'id_user' => $request->id_user,
                'dusun_lingkungan' => $request->dusun_lingkungan ?? '',
                'PKK_RW' => $request->PKK_RW ?? 0,
                'PKK_RT' => $request->PKK_RT ?? 0,
                'desa_wisma' => $request->desa_wisma ?? 0,
                'KRT' => $request->KRT ?? 0,
                'KK' => $request->KK ?? 0,
                'jiwa_laki' => $request->jiwa_laki ?? 0,
                'jiwa_perempuan' => $request->jiwa_perempuan ?? 0,
                'anggota_laki' => $request->anggota_laki ?? 0,
                'anggota_perempuan' => $request->anggota_perempuan ?? 0,
                'umum_laki' => $request->umum_laki ?? 0,
                'umum_perempuan' => $request->umum_perempuan ?? 0,
                'khusus_laki' => $request->khusus_laki ?? 0,
                'khusus_perempuan' => $request->khusus_perempuan ?? 0,
                'honorer_laki' => $request->honorer_laki ?? 0,
                'honorer_perempuan' => $request->honorer_perempuan ?? 0,
                'bantuan_laki' => $request->bantuan_laki ?? 0,
                'bantuan_perempuan' => $request->bantuan_perempuan ?? 0,
                'catatan' => $request->catatan ?? '',
                'keterangan' => $request->keterangan ?? '',
                'status' => 'Proses',
                'created_at' => now(),
                'updated_at' => now(),
                'id_role' => $request->id_role,
                'id_organization' => $request->id_organization,
            ]);

            //  AMBIL DATA + JOIN
            $data = DB::table('laporan_umum')
                ->leftJoin('role_users_mobile', 'laporan_umum.id_role', '=', 'role_users_mobile.id')
                ->leftJoin('role_organization', 'laporan_umum.id_organization', '=', 'role_organization.id')
                ->where('laporan_umum.uuid', $uuid)
                ->select(
                    'laporan_umum.*',
                    'role_users_mobile.id as role_id',
                    'role_users_mobile.uuid as role_uuid',
                    'role_users_mobile.name as role_name',
                    'role_organization.id as organization_id',
                    'role_organization.uuid as organization_uuid',
                    'role_organization.name as organization_name'
                )
                ->first();

            //  RESPONSE
            return response()->json([
                'statusCode' => 200,
                'message' => 'Laporan Umum PKK berhasil disimpan',
                'data' => [
                    "id_laporan_umum" => $data->id_laporan_umum,
                    "uuid" => $data->uuid,
                    "id_user" => $data->id_user,
                    "dusun_lingkungan" => $data->dusun_lingkungan,
                    "PKK_RW" => $data->PKK_RW,
                    "PKK_RT" => $data->PKK_RT,
                    "desa_wisma" => $data->desa_wisma,
                    "KRT" => $data->KRT,
                    "KK" => $data->KK,
                    "jiwa_laki" => $data->jiwa_laki,
                    "jiwa_perempuan" => $data->jiwa_perempuan,
                    "anggota_laki" => $data->anggota_laki,
                    "anggota_perempuan" => $data->anggota_perempuan,
                    "umum_laki" => $data->umum_laki,
                    "umum_perempuan" => $data->umum_perempuan,
                    "khusus_laki" => $data->khusus_laki,
                    "khusus_perempuan" => $data->khusus_perempuan,
                    "honorer_laki" => $data->honorer_laki,
                    "honorer_perempuan" => $data->honorer_perempuan,
                    "bantuan_laki" => $data->bantuan_laki,
                    "bantuan_perempuan" => $data->bantuan_perempuan,
                    "catatan" => $data->catatan,
                    "keterangan" => $data->keterangan,
                    "status" => $data->status,
                    "created_at" => $data->created_at,
                    "updated_at" => $data->updated_at,
                    "role" => $data->role_id ? [
                        "id" => $data->role_id,
                        "uuid" => $data->role_uuid ?? '',
                        "name" => $data->role_name ?? ''
                    ] : null,
                    "organization" => $data->organization_id ? [
                        "id" => $data->organization_id,
                        "uuid" => $data->organization_uuid ?? '',
                        "name" => $data->organization_name ?? ''
                    ] : null,
                ],
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Gagal menyimpan laporan umum',
                'data' => null,
                'error' => [
                    'message' => $e->getMessage()
                ]
            ], 500);
        }
    }

    //   KADER POKJA 1 //
    // UPLOAD KADER POKJA 1
    public function insertKaderPokja1(Request $request)
    {
        try {
            //  validasi (mendukung format baru website dan format lama mobile)
            if ($gagal = $this->validasiData($request, [
                'PKBN' => 'required_without:kader_umum|integer|min:0',
                'PKDRT' => 'required_without:kader_khusus|integer|min:0',
                'pola_asuh' => 'nullable|integer|min:0',
                'kader_umum' => 'required_without:PKBN|integer|min:0',
                'kader_khusus' => 'required_without:PKDRT|integer|min:0',
                'id_user' => 'required',
                'id_role' => 'required',
                'id_organization' => 'required'
            ])) {
                return $gagal;
            }

            $pkbn = $request->input('PKBN', $request->input('kader_umum'));
            $pkdrt = $request->input('PKDRT', $request->input('kader_khusus'));
            $polaAsuh = $request->input('pola_asuh', 0);

            //  UUID custom
            $uuid = 'KP1-' . strtoupper(\Illuminate\Support\Str::random(6));

            //  insert data
            DB::table('laporan_kader_pokja1')->insert([
                'uuid' => $uuid,
                'id_user' => $request->id_user,
                'PKBN' => $pkbn,
                'PKDRT' => $pkdrt,
                'pola_asuh' => $polaAsuh,
                'kader_umum' => $request->input('kader_umum', $pkbn),
                'kader_khusus' => $request->input('kader_khusus', $pkdrt),
                'status' => 'Proses',
                'created_at' => now(),
                'updated_at' => now(),
                'id_role' => $request->id_role,
                'id_organization' => $request->id_organization
            ]);

            //  ambil data kembali (JOIN)
            $data = DB::table('laporan_kader_pokja1')
                ->leftJoin('role_users_mobile', 'laporan_kader_pokja1.id_role', '=', 'role_users_mobile.id')
                ->leftJoin('role_organization', 'laporan_kader_pokja1.id_organization', '=', 'role_organization.id')
                ->where('laporan_kader_pokja1.uuid', $uuid)
                ->select(
                    'laporan_kader_pokja1.*',
                    'role_users_mobile.id as role_id',
                    'role_users_mobile.uuid as role_uuid',
                    'role_users_mobile.name as role_name',
                    'role_organization.id as organization_id',
                    'role_organization.uuid as organization_uuid',
                    'role_organization.name as organization_name'
                )
                ->first();

            return response()->json([
                'statusCode' => 200,
                'message' => 'Successfully uploaded report kader pokja I',
                'data' => [
                    "id_kader_pokja1" => $data->id_kader_pokja1,
                    "uuid" => $data->uuid,
                    "id_user" => $data->id_user,
                    "PKBN" => $data->PKBN,
                    "PKDRT" => $data->PKDRT,
                    "pola_asuh" => $data->pola_asuh,
                    "catatan" => $data->catatan,
                    "status" => $data->status,
                    "created_at" => $data->created_at,
                    "updated_at" => $data->updated_at,
                    "role" => [
                        "id" => $data->role_id,
                        "uuid" => $data->role_uuid,
                        "name" => $data->role_name
                    ],
                    "organization" => [
                        "id" => $data->organization_id,
                        "uuid" => $data->organization_uuid,
                        "name" => $data->organization_name
                    ],
                ],
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Failed to upload report kader pokja I',
                'data' => null,
                'error' => ['message' => $e->getMessage()]
            ], 500);
        }
    }

    // LAPORAN GOTONG ROYONG
    public function insertGotongRoyong(Request $request)
    {
        try {
            //  validasi (format baru mobile + format lama website)
            $request->validate([
                'kerja_bakti' => 'nullable',
                'rukun_kematian' => 'nullable',
                'keagamaan' => 'nullable',
                'jimpitan' => 'nullable',
                'arisan' => 'nullable',
                'id_user' => 'required',
                'id_role' => 'required',
                'id_organization' => 'required'
            ]);

            $toInt = static function ($value) {
                if ($value === null || $value === '') {
                    return 0;
                }

                if (is_numeric($value)) {
                    return (int) $value;
                }

                preg_match('/-?\d+/', (string) $value, $match);

                return isset($match[0]) ? (int) $match[0] : 0;
            };

            $kerjaBakti = $toInt($request->input('kerja_bakti', $request->input('kerja_bakti_vol')));
            $rukunKematian = $toInt($request->input('rukun_kematian', $request->input('bantuan_yatim_vol')));
            $keagamaan = $toInt($request->input('keagamaan', $request->input('kegiatan_sosial_vol')));
            $jimpitan = $toInt($request->input('jimpitan'));
            $arisan = $toInt($request->input('arisan'));

            //  UUID custom (sama seperti kode lama)
            $uuid = 'KP1B2-' . strtoupper(\Illuminate\Support\Str::random(6));

            //  insert data
            DB::table('laporan_gotong_royong')->insert([
                'uuid' => $uuid,
                'id_user' => $request->id_user,
                'kerja_bakti' => $kerjaBakti,
                'rukun_kematian' => $rukunKematian,
                'keagamaan' => $keagamaan,
                'jimpitan' => $jimpitan,
                'arisan' => $arisan,
                'kerja_bakti_kegiatan' => $request->input('kerja_bakti_kegiatan'),
                'kerja_bakti_vol' => $request->input('kerja_bakti_vol'),
                'kerja_bakti_metode' => $request->input('kerja_bakti_metode'),
                'kerja_bakti_sasaran' => $request->input('kerja_bakti_sasaran'),
                'bantuan_yatim_kegiatan' => $request->input('bantuan_yatim_kegiatan'),
                'bantuan_yatim_vol' => $request->input('bantuan_yatim_vol'),
                'bantuan_yatim_metode' => $request->input('bantuan_yatim_metode'),
                'bantuan_yatim_sasaran' => $request->input('bantuan_yatim_sasaran'),
                'kegiatan_sosial_kegiatan' => $request->input('kegiatan_sosial_kegiatan'),
                'kegiatan_sosial_vol' => $request->input('kegiatan_sosial_vol'),
                'kegiatan_sosial_metode' => $request->input('kegiatan_sosial_metode'),
                'kegiatan_sosial_sasaran' => $request->input('kegiatan_sosial_sasaran'),
                'jenis_kegiatan' => $request->input('jenis_kegiatan'),
                'sumber_dana' => $request->input('sumber_dana'),
                'hasil_kegiatan' => $request->input('hasil_kegiatan'),
                'catatan' => $request->input('catatan', ''),
                'status' => 'Proses',
                'created_at' => now(),
                'updated_at' => now(),
                'id_role' => $request->id_role,
                'id_organization' => $request->id_organization
            ]);

            //  ambil data kembali (JOIN)
            $data = DB::table('laporan_gotong_royong')
                ->leftJoin('role_users_mobile', 'laporan_gotong_royong.id_role', '=', 'role_users_mobile.id')
                ->leftJoin('role_organization', 'laporan_gotong_royong.id_organization', '=', 'role_organization.id')
                ->where('laporan_gotong_royong.uuid', $uuid)
                ->select(
                    'laporan_gotong_royong.*',
                    'role_users_mobile.id as role_id',
                    'role_users_mobile.uuid as role_uuid',
                    'role_users_mobile.name as role_name',
                    'role_organization.id as organization_id',
                    'role_organization.uuid as organization_uuid',
                    'role_organization.name as organization_name'
                )
                ->first();

            return response()->json([
                'statusCode' => 200,
                'message' => 'Successfully uploaded report gotong royong',
                'data' => [
                    "id_pokja1_bidang2" => $data->id_pokja1_bidang2,
                    "uuid" => $data->uuid,
                    "id_user" => $data->id_user,
                    "kerja_bakti" => $data->kerja_bakti,
                    "rukun_kematian" => $data->rukun_kematian,
                    "keagamaan" => $data->keagamaan,
                    "jimpitan" => $data->jimpitan,
                    "arisan" => $data->arisan,
                    "catatan" => $data->catatan,
                    "status" => $data->status,
                    "created_at" => $data->created_at,
                    "updated_at" => $data->updated_at,
                    "role" => [
                        "id" => $data->role_id,
                        "uuid" => $data->role_uuid,
                        "name" => $data->role_name
                    ],
                    "organization" => [
                        "id" => $data->organization_id,
                        "uuid" => $data->organization_uuid,
                        "name" => $data->organization_name
                    ],
                ],
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Failed to upload report',
                'data' => null,
                'error' => ['message' => $e->getMessage()]
            ], 500);
        }
    }

    // PENGHAYATAN DAN PENGALAMAN PANCASILA
    public function insertPenghayatan(Request $request)
    {
        try {
            //  validasi (format baru mobile + format lama website)
            $request->validate([
                'jumlah_kel_simulasi1' => 'nullable',
                'jumlah_anggota1' => 'nullable',
                'jumlah_kel_simulasi2' => 'nullable',
                'jumlah_anggota2' => 'nullable',
                'jumlah_kel_simulasi3' => 'nullable',
                'jumlah_anggota3' => 'nullable',
                'jumlah_kel_simulasi4' => 'nullable',
                'jumlah_anggota4' => 'nullable',
                'id_user' => 'required',
                'id_role' => 'required',
                'id_organization' => 'required'
            ]);

            $toInt = static function ($value) {
                if ($value === null || $value === '') {
                    return 0;
                }

                if (is_numeric($value)) {
                    return (int) $value;
                }

                preg_match('/-?\d+/', (string) $value, $match);

                return isset($match[0]) ? (int) $match[0] : 0;
            };

            // UUID sama seperti native kamu
            $uuid = 'KP1B1-' . strtoupper(Str::random(6));

            DB::table('laporan_penghayatan_n_pengamalan')->insert([
                'uuid' => $uuid,
                'id_user' => $request->id_user,
                'jumlah_kel_simulasi1' => $toInt($request->input('jumlah_kel_simulasi1')),
                'jumlah_anggota1' => $toInt($request->input('jumlah_anggota1')),
                'jumlah_kel_simulasi2' => $toInt($request->input('jumlah_kel_simulasi2')),
                'jumlah_anggota2' => $toInt($request->input('jumlah_anggota2')),
                'jumlah_kel_simulasi3' => $toInt($request->input('jumlah_kel_simulasi3')),
                'jumlah_anggota3' => $toInt($request->input('jumlah_anggota3')),
                'jumlah_kel_simulasi4' => $toInt($request->input('jumlah_kel_simulasi4')),
                'jumlah_anggota4' => $toInt($request->input('jumlah_anggota4')),
                'kisah_kegiatan' => $request->input('kisah_kegiatan'),
                'kisah_vol' => $toInt($request->input('kisah_vol')),
                'kisah_metode' => $request->input('kisah_metode'),
                'kisah_sasaran' => $toInt($request->input('kisah_sasaran')),
                'krisan_kegiatan' => $request->input('krisan_kegiatan'),
                'krisan_vol' => $toInt($request->input('krisan_vol')),
                'krisan_metode' => $request->input('krisan_metode'),
                'krisan_sasaran' => $toInt($request->input('krisan_sasaran')),
                'kilas_kegiatan' => $request->input('kilas_kegiatan'),
                'kilas_vol' => $toInt($request->input('kilas_vol')),
                'kilas_metode' => $request->input('kilas_metode'),
                'kilas_sasaran' => $toInt($request->input('kilas_sasaran')),
                'kiat_kegiatan' => $request->input('kiat_kegiatan'),
                'kiat_vol' => $toInt($request->input('kiat_vol')),
                'kiat_metode' => $request->input('kiat_metode'),
                'kiat_sasaran' => $toInt($request->input('kiat_sasaran')),
                'kisak_kegiatan' => $request->input('kisak_kegiatan'),
                'kisak_vol' => $toInt($request->input('kisak_vol')),
                'kisak_metode' => $request->input('kisak_metode'),
                'kisak_sasaran' => $toInt($request->input('kisak_sasaran')),
                'pkbn_kegiatan' => $request->input('pkbn_kegiatan'),
                'pkbn_vol' => $toInt($request->input('pkbn_vol')),
                'pkbn_metode' => $request->input('pkbn_metode'),
                'pkbn_sasaran' => $toInt($request->input('pkbn_sasaran')),
                'sumber_dana' => $request->input('sumber_dana'),
                'hasil_kegiatan' => $request->input('hasil_kegiatan'),
                // [PERUBAHAN 03-10-2026] disamakan dengan endpoint lain ('Proses'); kode lama di bawah dinonaktifkan
                // 'status' => 'Menunggu',
                'status' => 'Proses',
                'created_at' => now(),
                'updated_at' => now(),
                'id_role' => $request->id_role,
                'id_organization' => $request->id_organization,
                'catatan' => $request->input('catatan', '')
            ]);

            $data = DB::table('laporan_penghayatan_n_pengamalan')
                ->leftJoin('role_users_mobile', 'laporan_penghayatan_n_pengamalan.id_role', '=', 'role_users_mobile.id')
                ->leftJoin('role_organization', 'laporan_penghayatan_n_pengamalan.id_organization', '=', 'role_organization.id')
                ->where('laporan_penghayatan_n_pengamalan.uuid', $uuid)
                ->select(
                    'laporan_penghayatan_n_pengamalan.*',
                    'role_users_mobile.id AS role_id',
                    'role_users_mobile.uuid AS role_uuid',
                    'role_users_mobile.name AS role_name',
                    'role_organization.id AS organization_id',
                    'role_organization.uuid AS organization_uuid',
                    'role_organization.name AS organization_name'
                )
                ->first();

            return response()->json([
                'statusCode' => 200,
                'message' => 'Successfully uploaded report penghayatan pengamalan',
                'data' => [
                    "id_pokja1_bidang1" => $data->id_pokja1_bidang1,
                    "uuid" => $data->uuid,
                    "id_user" => $data->id_user,
                    "kisah_kegiatan" => $data->kisah_kegiatan,
                    "kisah_vol" => $data->kisah_vol,
                    "kisah_metode" => $data->kisah_metode,
                    "kisah_sasaran" => $data->kisah_sasaran,
                    "krisan_kegiatan" => $data->krisan_kegiatan,
                    "krisan_vol" => $data->krisan_vol,
                    "krisan_metode" => $data->krisan_metode,
                    "krisan_sasaran" => $data->krisan_sasaran,
                    "kilas_kegiatan" => $data->kilas_kegiatan,
                    "kilas_vol" => $data->kilas_vol,
                    "kilas_metode" => $data->kilas_metode,
                    "kilas_sasaran" => $data->kilas_sasaran,
                    "kiat_kegiatan" => $data->kiat_kegiatan,
                    "kiat_vol" => $data->kiat_vol,
                    "kiat_metode" => $data->kiat_metode,
                    "kiat_sasaran" => $data->kiat_sasaran,
                    "kisak_kegiatan" => $data->kisak_kegiatan,
                    "kisak_vol" => $data->kisak_vol,
                    "kisak_metode" => $data->kisak_metode,
                    "kisak_sasaran" => $data->kisak_sasaran,
                    "pkbn_kegiatan" => $data->pkbn_kegiatan,
                    "pkbn_vol" => $data->pkbn_vol,
                    "pkbn_metode" => $data->pkbn_metode,
                    "pkbn_sasaran" => $data->pkbn_sasaran,
                    "catatan" => $data->catatan,
                    "status" => $data->status,
                    "created_at" => $data->created_at,
                    "updated_at" => $data->updated_at,
                    "role" => [
                        "id" => $data->role_id,
                        "uuid"=> $data->role_uuid,
                        "name" => $data->role_name
                    ],
                    "organization" => [
                        "id" => $data->organization_id,
                        "uuid" => $data->organization_uuid,
                        "name" => $data->organization_name
                    ]
                ],
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Failed to upload report kader pokja 1',
                'data' => null,
                'error' => ['message' => $e->getMessage()]
            ]);
        }
    }

    public function insertPendidikanKeterampilan(Request $request)
    {
        try {
            if ($gagal = $this->validasiData($request, [
                'id_user' => 'required',
                'id_role' => 'required',
                'id_organization' => 'required',
                'warga_buta' => 'integer|min:0',
                'kel_belajarA' => 'integer|min:0',
                'warga_belajarA' => 'integer|min:0',
                'kel_belajarB' => 'integer|min:0',
                'warga_belajarB' => 'integer|min:0',
                'kel_belajarC' => 'integer|min:0',
                'warga_belajarC' => 'integer|min:0',
                'kel_belajarKF' => 'integer|min:0',
                'warga_belajarKF' => 'integer|min:0',
                'paud' => 'integer|min:0',
                'taman_bacaan' => 'integer|min:0',
                'jumlah_klp' => 'integer|min:0',
                'jumlah_ibu_peserta' => 'integer|min:0',
                'jumlah_ape' => 'integer|min:0',
                'jumlah_kel_simulasi' => 'integer|min:0',
                'KF' => 'integer|min:0',
                'paud_tutor' => 'integer|min:0',
                'BKB' => 'integer|min:0',
                'koperasi' => 'integer|min:0',
                'ketrampilan' => 'integer|min:0',
                'LP3PKK' => 'integer|min:0',
                'TP3PKK' => 'integer|min:0',
                'damas_pkk' => 'integer|min:0',
            ])) {
                return $gagal;
            }

            // UUID (SAMA PERSIS)
            $uuid = 'KP2B1-' . strtoupper(Str::random(6));

            // INSERT (SEMUA FIELD)
            $id = DB::table('laporan_pendidikan_n_keterampilan')->insertGetId([
                'uuid' => $uuid,
                'id_user' => $request->id_user,
                'warga_buta' => $request->warga_buta ?? 0,
                'kel_belajarA' => $request->kel_belajarA ?? 0,
                'warga_belajarA' => $request->warga_belajarA ?? 0,
                'kel_belajarB' => $request->kel_belajarB ?? 0,
                'warga_belajarB' => $request->warga_belajarB ?? 0,
                'kel_belajarC' => $request->kel_belajarC ?? 0,
                'warga_belajarC' => $request->warga_belajarC ?? 0,
                'kel_belajarKF' => $request->kel_belajarKF ?? 0,
                'warga_belajarKF' => $request->warga_belajarKF ?? 0,
                'paud' => $request->paud ?? 0,
                'taman_bacaan' => $request->taman_bacaan ?? 0,
                'jumlah_klp' => $request->jumlah_klp ?? 0,
                'jumlah_ibu_peserta' => $request->jumlah_ibu_peserta ?? 0,
                'jumlah_ape' => $request->jumlah_ape ?? 0,
                'jumlah_kel_simulasi' => $request->jumlah_kel_simulasi ?? 0,
                'KF' => $request->KF ?? 0,
                'paud_tutor' => $request->paud_tutor ?? 0,
                'BKB' => $request->BKB ?? 0,
                'koperasi' => $request->koperasi ?? 0,
                'ketrampilan' => $request->ketrampilan ?? 0,
                'LP3PKK' => $request->LP3PKK ?? 0,
                'TP3PKK' => $request->TP3PKK ?? 0,
                'damas_pkk' => $request->damas_pkk ?? 0,
                'catatan' => $request->catatan ?? '',
                'status' => 'Proses',
                'created_at' => now(),
                'updated_at' => now(),
                'id_role' => $request->id_role,
                'id_organization' => $request->id_organization
            ]);

            // SELECT + JOIN (SAMA LOGIKA)
            $data = DB::table('laporan_pendidikan_n_keterampilan')
                ->leftJoin('role_users_mobile', 'laporan_pendidikan_n_keterampilan.id_role', '=', 'role_users_mobile.id')
                ->leftJoin('role_organization', 'laporan_pendidikan_n_keterampilan.id_organization', '=', 'role_organization.id')
                ->where('laporan_pendidikan_n_keterampilan.uuid', $uuid)
                ->select(
                    'laporan_pendidikan_n_keterampilan.id_pokja2_bidang1',
                    'laporan_pendidikan_n_keterampilan.uuid',
                    'laporan_pendidikan_n_keterampilan.id_user',
                    'laporan_pendidikan_n_keterampilan.warga_buta',
                    'laporan_pendidikan_n_keterampilan.kel_belajarA',
                    'laporan_pendidikan_n_keterampilan.warga_belajarA',
                    'laporan_pendidikan_n_keterampilan.kel_belajarB',
                    'laporan_pendidikan_n_keterampilan.warga_belajarB',
                    'laporan_pendidikan_n_keterampilan.kel_belajarC',
                    'laporan_pendidikan_n_keterampilan.warga_belajarC',
                    'laporan_pendidikan_n_keterampilan.kel_belajarKF',
                    'laporan_pendidikan_n_keterampilan.warga_belajarKF',
                    'laporan_pendidikan_n_keterampilan.paud',
                    'laporan_pendidikan_n_keterampilan.taman_bacaan',
                    'laporan_pendidikan_n_keterampilan.jumlah_klp',
                    'laporan_pendidikan_n_keterampilan.jumlah_ibu_peserta',
                    'laporan_pendidikan_n_keterampilan.jumlah_ape',
                    'laporan_pendidikan_n_keterampilan.jumlah_kel_simulasi',
                    'laporan_pendidikan_n_keterampilan.KF',
                    'laporan_pendidikan_n_keterampilan.paud_tutor',
                    'laporan_pendidikan_n_keterampilan.BKB',
                    'laporan_pendidikan_n_keterampilan.koperasi',
                    'laporan_pendidikan_n_keterampilan.ketrampilan',
                    'laporan_pendidikan_n_keterampilan.LP3PKK',
                    'laporan_pendidikan_n_keterampilan.TP3PKK',
                    'laporan_pendidikan_n_keterampilan.damas_pkk',
                    'laporan_pendidikan_n_keterampilan.catatan',
                    'laporan_pendidikan_n_keterampilan.status',
                    'laporan_pendidikan_n_keterampilan.created_at',
                    'laporan_pendidikan_n_keterampilan.updated_at',
                    'role_users_mobile.id AS role_id',
                    'role_users_mobile.uuid AS role_uuid',
                    'role_users_mobile.name AS role_name',
                    'role_organization.id AS organization_id',
                    'role_organization.uuid AS organization_uuid',
                    'role_organization.name AS organization_name'
                )
                ->first();

            return response()->json([
                'statusCode' => 200,
                'message' => 'Successfully uploaded pendidikan dan keterampilan report',
                'data' => [
                    "id_pokja2_bidang1" => $data->id_pokja2_bidang1,
                    "uuid" => $data->uuid,
                    "id_user" => $data->id_user,
                    "warga_buta" => $data->warga_buta,
                    "kel_belajarA" => $data->kel_belajarA,
                    "warga_belajarA" => $data->warga_belajarA,
                    "kel_belajarB" => $data->kel_belajarB,
                    "warga_belajarB" => $data->warga_belajarB,
                    "kel_belajarC" => $data->kel_belajarC,
                    "warga_belajarC" => $data->warga_belajarC,
                    "kel_belajarKF" => $data->kel_belajarKF,
                    "warga_belajarKF" => $data->warga_belajarKF,
                    "paud" => $data->paud,
                    "taman_bacaan" => $data->taman_bacaan,
                    "jumlah_klp" => $data->jumlah_klp,
                    "jumlah_ibu_peserta" => $data->jumlah_ibu_peserta,
                    "jumlah_ape" => $data->jumlah_ape,
                    "jumlah_kel_simulasi" => $data->jumlah_kel_simulasi,
                    "KF" => $data->KF,
                    "paud_tutor" => $data->paud_tutor,
                    "BKB" => $data->BKB,
                    "koperasi" => $data->koperasi,
                    "ketrampilan" => $data->ketrampilan,
                    "LP3PKK" => $data->LP3PKK,
                    "TP3PKK" => $data->TP3PKK,
                    "damas_pkk" => $data->damas_pkk,
                    "catatan" => $data->catatan,
                    "status" => $data->status,
                    "created_at" => $data->created_at,
                    "updated_at" => $data->updated_at,
                    "role" => [
                        "id" => $data->role_id,
                        "uuid" => $data->role_uuid,
                        "name" => $data->role_name
                    ],
                    "organization" => [
                        "id" => $data->organization_id,
                        "uuid" => $data->organization_uuid,
                        "name" => $data->organization_name
                    ],
                ],
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Failed to upload pendidikan dan keterampilan report',
                'data' => null,
                'error' => ['message' => $e->getMessage()]
            ], 500);
        }
    }

    // PENGEMBANGAN KEHIDUPAN (POKJA 2 BIDANG 2)
    public function insertPengembanganKehidupan(Request $request)
    {
        try {
            if ($gagal = $this->validasiData($request, [
                'id_user' => 'required',
                'id_role' => 'required',
                'id_organization' => 'required',
                'jumlah_kelompok_pemula' => 'integer|min:0',
                'jumlah_peserta_pemula' => 'integer|min:0',
                'jumlah_kelompok_madya' => 'integer|min:0',
                'jumlah_peserta_madya' => 'integer|min:0',
                'jumlah_kelompok_utama' => 'integer|min:0',
                'jumlah_peserta_utama' => 'integer|min:0',
                'jumlah_kelompok_mandiri' => 'integer|min:0',
                'jumlah_peserta_mandiri' => 'integer|min:0',
                'jumlah_kelompok_hukum' => 'integer|min:0',
                'jumlah_peserta_hukum' => 'integer|min:0',
            ])) {
                return $gagal;
            }

            // UUID (SAMA)
            $uuid = 'KP2B2-' . strtoupper(Str::random(6));

            // INSERT (SEMUA FIELD)
            DB::table('laporan_pengembangan_kehidupan')->insert([
                'uuid' => $uuid,
                'id_user' => $request->id_user,
                'jumlah_kelompok_pemula' => $request->jumlah_kelompok_pemula ?? 0,
                'jumlah_peserta_pemula' => $request->jumlah_peserta_pemula ?? 0,
                'jumlah_kelompok_madya' => $request->jumlah_kelompok_madya ?? 0,
                'jumlah_peserta_madya' => $request->jumlah_peserta_madya ?? 0,
                'jumlah_kelompok_utama' => $request->jumlah_kelompok_utama ?? 0,
                'jumlah_peserta_utama' => $request->jumlah_peserta_utama ?? 0,
                'jumlah_kelompok_mandiri' => $request->jumlah_kelompok_mandiri ?? 0,
                'jumlah_peserta_mandiri' => $request->jumlah_peserta_mandiri ?? 0,
                'jumlah_kelompok_hukum' => $request->jumlah_kelompok_hukum ?? 0,
                'jumlah_peserta_hukum' => $request->jumlah_peserta_hukum ?? 0,
                'catatan' => $request->catatan ?? '',
                'status' => 'Proses',
                'created_at' => now(),
                'updated_at' => now(),
                'id_role' => $request->id_role,
                'id_organization' => $request->id_organization
            ]);

            // SELECT + JOIN (SAMA)
            $data = DB::table('laporan_pengembangan_kehidupan')
                ->leftJoin('role_users_mobile', 'laporan_pengembangan_kehidupan.id_role', '=', 'role_users_mobile.id')
                ->leftJoin('role_organization', 'laporan_pengembangan_kehidupan.id_organization', '=', 'role_organization.id')
                ->where('laporan_pengembangan_kehidupan.uuid', $uuid)
                ->select(
                    'laporan_pengembangan_kehidupan.id_pokja2_bidang2',
                    'laporan_pengembangan_kehidupan.uuid',
                    'laporan_pengembangan_kehidupan.id_user',
                    'laporan_pengembangan_kehidupan.jumlah_kelompok_pemula',
                    'laporan_pengembangan_kehidupan.jumlah_peserta_pemula',
                    'laporan_pengembangan_kehidupan.jumlah_kelompok_madya',
                    'laporan_pengembangan_kehidupan.jumlah_peserta_madya',
                    'laporan_pengembangan_kehidupan.jumlah_kelompok_utama',
                    'laporan_pengembangan_kehidupan.jumlah_peserta_utama',
                    'laporan_pengembangan_kehidupan.jumlah_kelompok_mandiri',
                    'laporan_pengembangan_kehidupan.jumlah_peserta_mandiri',
                    'laporan_pengembangan_kehidupan.jumlah_kelompok_hukum',
                    'laporan_pengembangan_kehidupan.jumlah_peserta_hukum',
                    'laporan_pengembangan_kehidupan.catatan',
                    'laporan_pengembangan_kehidupan.status',
                    'laporan_pengembangan_kehidupan.created_at',
                    'laporan_pengembangan_kehidupan.updated_at',
                    'role_users_mobile.id AS role_id',
                    'role_users_mobile.uuid AS role_uuid',
                    'role_users_mobile.name AS role_name',
                    'role_organization.id AS organization_id',
                    'role_organization.uuid AS organization_uuid',
                    'role_organization.name AS organization_name'
                )
                ->first();

            return response()->json([
                'statusCode' => 200,
                'message' => 'Successfully uploaded pengembangan kehidupan report',
                'data' => [
                    "id_pokja2_bidang2" => $data->id_pokja2_bidang2,
                    "uuid" => $data->uuid,
                    "id_user" => $data->id_user,
                    "jumlah_kelompok_pemula" => $data->jumlah_kelompok_pemula,
                    "jumlah_peserta_pemula" => $data->jumlah_peserta_pemula,
                    "jumlah_kelompok_madya" => $data->jumlah_kelompok_madya,
                    "jumlah_peserta_madya" => $data->jumlah_peserta_madya,
                    "jumlah_kelompok_utama" => $data->jumlah_kelompok_utama,
                    "jumlah_peserta_utama" => $data->jumlah_peserta_utama,
                    "jumlah_kelompok_mandiri" => $data->jumlah_kelompok_mandiri,
                    "jumlah_peserta_mandiri" => $data->jumlah_peserta_mandiri,
                    "jumlah_kelompok_hukum" => $data->jumlah_kelompok_hukum,
                    "jumlah_peserta_hukum" => $data->jumlah_peserta_hukum,
                    "catatan" => $data->catatan,
                    "status" => $data->status,
                    "created_at" => $data->created_at,
                    "updated_at" => $data->updated_at,
                    "role" => [
                        "id" => $data->role_id,
                        "uuid" => $data->role_uuid,
                        "name" => $data->role_name
                    ],
                    "organization" => [
                        "id" => $data->organization_id,
                        "uuid" => $data->organization_uuid,
                        "name" => $data->organization_name
                    ],
                ],
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Failed to upload pengembangan kehidupan report',
                'data' => null,
                'error' => ['message' => $e->getMessage()]
            ], 500);
        }
    }

    // POKJA 3 //
    // PANGAN (POKJA 3 BIDANG 1)
    public function insertKaderPokja3(Request $request)
    {
        try {
            if ($gagal = $this->validasiData($request, [
                'id_user' => 'required',
                'id_role' => 'required',
                'id_organization' => 'required',
                'pangan' => 'integer|min:0',
                'sandang' => 'integer|min:0',
                'tata_laksana_rumah' => 'integer|min:0',
            ])) {
                return $gagal;
            }

            // DEFAULT VALUE (samain PHP lama)
            $pangan = $request->pangan ?? 0;
            $sandang = $request->sandang ?? 0;
            $tata_laksana_rumah = $request->tata_laksana_rumah ?? 0;
            $catatan = $request->catatan ?? '';

            // UUID
            $uuid = 'KP3-' . strtoupper(Str::random(6));

            // INSERT
            DB::table('laporan_kader_pokja3')->insert([
                'uuid' => $uuid,
                'id_user' => $request->id_user,
                'pangan' => $pangan,
                'sandang' => $sandang,
                'tata_laksana_rumah' => $tata_laksana_rumah,
                'catatan' => $catatan,
                'status' => 'Proses',
                'created_at' => now(),
                'updated_at' => now(),
                'id_role' => $request->id_role,
                'id_organization' => $request->id_organization
            ]);

            // SELECT + JOIN
            $data = DB::table('laporan_kader_pokja3')
                ->leftJoin('role_users_mobile', 'laporan_kader_pokja3.id_role', '=', 'role_users_mobile.id')
                ->leftJoin('role_organization', 'laporan_kader_pokja3.id_organization', '=', 'role_organization.id')
                ->where('laporan_kader_pokja3.uuid', $uuid)
                ->select(
                    'laporan_kader_pokja3.*',
                    'role_users_mobile.id as role_id',
                    'role_users_mobile.uuid as role_uuid',
                    'role_users_mobile.name as role_name',
                    'role_organization.id as organization_id',
                    'role_organization.uuid as organization_uuid',
                    'role_organization.name as organization_name'
                )
                ->first();

            return response()->json([
                'statusCode' => 200,
                'message' => 'Successfully uploaded kader pokja 3 report',
                'data' => [
                    "id_kader_pokja3" => $data->id_kader_pokja3,
                    "uuid" => $data->uuid,
                    "id_user" => $data->id_user,
                    "pangan" => $data->pangan,
                    "sandang" => $data->sandang,
                    "tata_laksana_rumah" => $data->tata_laksana_rumah,
                    "catatan" => $data->catatan,
                    "status" => $data->status,
                    "created_at" => $data->created_at,
                    "updated_at" => $data->updated_at,
                    "role" => [
                        "id" => $data->role_id,
                        "uuid" => $data->role_uuid,
                        "name" => $data->role_name
                    ],
                    "organization" => [
                        "id" => $data->organization_id,
                        "uuid" => $data->organization_uuid,
                        "name" => $data->organization_name
                    ],
                ],
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Failed to upload kader pokja 3 report',
                'data' => null,
                'error' => ['message' => $e->getMessage()]
            ], 500);
        }
    }


    // INSERT PANGAN
    public function insertPangan(Request $request)
    {
        try {
            if ($gagal = $this->validasiData($request, [
                'id_user' => 'required',
                'id_role' => 'required',
                'id_organization' => 'required',
                'kader_pangan' => 'integer|min:0',
                'beras' => 'integer|min:0',
                'non_beras' => 'integer|min:0',
                'peternakan' => 'integer|min:0',
                'perikanan' => 'integer|min:0',
                'warung_hidup' => 'integer|min:0',
                'lumbung_hidup' => 'integer|min:0',
                'toga' => 'integer|min:0',
                'tanaman_keras' => 'integer|min:0',
                'tanaman_lainnya' => 'integer|min:0',
                'industri_pangan' => 'integer|min:0',
            ])) {
                return $gagal;
            }

            // UUID (SAMA PERSIS)
            $uuid = 'KP3B1-' . strtoupper(Str::random(6));

            $user = DB::table('users_mobile')->where('id', $request->id_user)->first();

            // INSERT
            DB::table('laporan_pangan')->insert([
                'uuid' => $uuid,
                'id_user' => $request->id_user,
                'kecamatan_id' => $user->id_subdistrict ?? $request->kecamatan_id ?? $request->id_subdistrict ?? null,
                'desa_id' => $user->id_village ?? $request->desa_id ?? $request->id_village ?? null,
                'kader_pangan' => $request->kader_pangan ?? 0,
                'beras' => $request->beras ?? 0,
                'non_beras' => $request->non_beras ?? 0,
                'peternakan' => $request->peternakan ?? 0,
                'perikanan' => $request->perikanan ?? 0,
                'warung_hidup' => $request->warung_hidup ?? 0,
                'lumbung_hidup' => $request->lumbung_hidup ?? 0,
                'toga' => $request->toga ?? 0,
                'tanaman_keras' => $request->tanaman_keras ?? 0,
                'tanaman_lainnya' => $request->tanaman_lainnya ?? 0,
                'industri_pangan' => $request->industri_pangan ?? 0,
                'catatan' => $request->catatan ?? '',
                'status' => 'Menunggu',
                'created_at' => now(),
                'updated_at' => now(),
                'id_role' => $request->id_role,
                'id_organization' => $request->id_organization
            ]);

            // SELECT + JOIN
            $data = DB::table('laporan_pangan')
                ->leftJoin('role_users_mobile', 'laporan_pangan.id_role', '=', 'role_users_mobile.id')
                ->leftJoin('role_organization', 'laporan_pangan.id_organization', '=', 'role_organization.id')
                ->where('laporan_pangan.uuid', $uuid)
                ->select(
                    'laporan_pangan.id as id_pokja3_bidang1',
                    'laporan_pangan.id',
                    'laporan_pangan.uuid',
                    'laporan_pangan.id_user',
                    'laporan_pangan.beras',
                    'laporan_pangan.non_beras',
                    'laporan_pangan.peternakan',
                    'laporan_pangan.perikanan',
                    'laporan_pangan.warung_hidup',
                    'laporan_pangan.lumbung_hidup',
                    'laporan_pangan.toga',
                    'laporan_pangan.tanaman_keras',
                    'laporan_pangan.tanaman_lainnya',
                    'laporan_pangan.catatan',
                    'laporan_pangan.status',
                    'laporan_pangan.created_at',
                    'laporan_pangan.updated_at',
                    'role_users_mobile.id AS role_id',
                    'role_users_mobile.uuid AS role_uuid',
                    'role_users_mobile.name AS role_name',
                    'role_organization.id AS organization_id',
                    'role_organization.uuid AS organization_uuid',
                    'role_organization.name AS organization_name'
                )
                ->first();

            return response()->json([
                'statusCode' => 200,
                'message' => 'Successfully uploaded laporan pangan',
                'data' => [
                    "id_pokja3_bidang1" => $data->id_pokja3_bidang1,
                    "uuid" => $data->uuid,
                    "id_user" => $data->id_user,
                    "beras" => $data->beras,
                    "non_beras" => $data->non_beras,
                    "peternakan" => $data->peternakan,
                    "perikanan" => $data->perikanan,
                    "warung_hidup" => $data->warung_hidup,
                    "lumbung_hidup" => $data->lumbung_hidup,
                    "toga" => $data->toga,
                    "tanaman_keras" => $data->tanaman_keras,
                    "tanaman_lainnya" => $data->tanaman_lainnya,
                    "catatan" => $data->catatan,
                    "status" => $data->status,
                    "created_at" => $data->created_at,
                    "updated_at" => $data->updated_at,
                    "role" => [
                        "id" => $data->role_id,
                        "uuid" => $data->role_uuid,
                        "name" => $data->role_name
                    ],
                    "organization" => [
                        "id" => $data->organization_id,
                        "uuid" => $data->organization_uuid,
                        "name" => $data->organization_name
                    ],
                ],
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Failed to upload laporan pangan',
                'data' => null,
                'error' => ['message' => $e->getMessage()]
            ], 500);
        }
    }

    // SANDANG (POKJA 3 BIDANG 2)
    public function insertSandang(Request $request)
    {
        try {
            if ($gagal = $this->validasiData($request, [
                'id_user' => 'required',
                'id_role' => 'required',
                'id_organization' => 'required',
                'kader_sandang' => 'integer|min:0',
                'industri_pangan' => 'integer|min:0',
                'industri_sandang' => 'integer|min:0',
                'jasa' => 'integer|min:0',
            ])) {
                return $gagal;
            }

            // UUID (SAMA PERSIS)
            $uuid = 'KP3B2-' . strtoupper(Str::random(6));

            $user = DB::table('users_mobile')->where('id', $request->id_user)->first();

            // INSERT
            DB::table('laporan_sandang')->insert([
                'uuid' => $uuid,
                'id_user' => $request->id_user,
                'kecamatan_id' => $user->id_subdistrict ?? null,
                'desa_id' => $user->id_village ?? null,
                'kader_sandang' => $request->kader_sandang ?? 0,
                'industri_pangan' => $request->industri_pangan ?? $request->pangan ?? 0,
                'industri_sandang' => $request->industri_sandang ?? $request->sandang ?? 0,
                'jasa' => $request->jasa ?? 0,
                'catatan' => $request->catatan ?? '',
                'status' => 'Proses',
                'created_at' => now(),
                'updated_at' => now(),
                'id_role' => $request->id_role,
                'id_organization' => $request->id_organization
            ]);

            // SELECT + JOIN (SAMA LOGIKA ASLI)
            $data = DB::table('laporan_sandang')
                ->leftJoin('role_users_mobile', 'laporan_sandang.id_role', '=', 'role_users_mobile.id')
                ->leftJoin('role_organization', 'laporan_sandang.id_organization', '=', 'role_organization.id')
                ->where('laporan_sandang.uuid', $uuid)
                ->select(
                    'laporan_sandang.id as id_pokja3_bidang2',
                    'laporan_sandang.id',
                    'laporan_sandang.uuid',
                    'laporan_sandang.id_user',
                    'laporan_sandang.kader_sandang',
                    'laporan_sandang.industri_pangan as pangan',
                    'laporan_sandang.industri_pangan',
                    'laporan_sandang.industri_sandang as sandang',
                    'laporan_sandang.industri_sandang',
                    'laporan_sandang.jasa',
                    'laporan_sandang.catatan',
                    'laporan_sandang.status',
                    'laporan_sandang.created_at',
                    'laporan_sandang.updated_at',
                    'role_users_mobile.id AS role_id',
                    'role_users_mobile.uuid AS role_uuid',
                    'role_users_mobile.name AS role_name',
                    'role_organization.id AS organization_id',
                    'role_organization.uuid AS organization_uuid',
                    'role_organization.name AS organization_name'
                )
                ->first();

            return response()->json([
                'statusCode' => 200,
                'message' => 'Successfully uploaded laporan sandang',
                'data' => [
                    "id_pokja3_bidang2" => $data->id_pokja3_bidang2,
                    "uuid" => $data->uuid,
                    "id_user" => $data->id_user,
                    "pangan" => $data->pangan,
                    "sandang" => $data->sandang,
                    "jasa" => $data->jasa,
                    "catatan" => $data->catatan,
                    "status" => $data->status,
                    "created_at" => $data->created_at,
                    "updated_at" => $data->updated_at,
                    "role" => [
                        "id" => $data->role_id,
                        "uuid" => $data->role_uuid,
                        "name" => $data->role_name
                    ],
                    "organization" => [
                        "id" => $data->organization_id,
                        "uuid" => $data->organization_uuid,
                        "name" => $data->organization_name
                    ],
                ],
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Failed to upload laporan sandang',
                'data' => null,
                'error' => ['message' => $e->getMessage()]
            ], 500);
        }
    }

    // PERUMAHAN (POKJA 3 BIDANG 3)
    public function insertPerumahan(Request $request)
    {
        try {
            if ($gagal = $this->validasiData($request, [
                'id_user' => 'required',
                'id_role' => 'required',
                'id_organization' => 'required',
                'layak_huni' => 'integer|min:0',
                'tidak_layak' => 'integer|min:0',
            ])) {
                return $gagal;
            }

            // UUID (SAMA PERSIS)
            $uuid = 'KP3B3-' . strtoupper(Str::random(6));

            // INSERT
            DB::table('laporan_perumahan')->insert([
                'uuid' => $uuid,
                'id_user' => $request->id_user,
                'layak_huni' => $request->layak_huni ?? 0,
                'tidak_layak' => $request->tidak_layak ?? 0,
                'catatan' => $request->catatan ?? '',
                'status' => 'Proses',
                'created_at' => now(),
                'updated_at' => now(),
                'id_role' => $request->id_role,
                'id_organization' => $request->id_organization
            ]);

            // SELECT + JOIN (SAMA LOGIKA ASLI)
            $data = DB::table('laporan_perumahan')
                ->leftJoin('role_users_mobile', 'laporan_perumahan.id_role', '=', 'role_users_mobile.id')
                ->leftJoin('role_organization', 'laporan_perumahan.id_organization', '=', 'role_organization.id')
                ->where('laporan_perumahan.uuid', $uuid)
                ->select(
                    'laporan_perumahan.id_pokja3_bidang3',
                    'laporan_perumahan.uuid',
                    'laporan_perumahan.id_user',
                    'laporan_perumahan.layak_huni',
                    'laporan_perumahan.tidak_layak',
                    'laporan_perumahan.catatan',
                    'laporan_perumahan.status',
                    'laporan_perumahan.created_at',
                    'laporan_perumahan.updated_at',
                    'role_users_mobile.id AS role_id',
                    'role_users_mobile.uuid AS role_uuid',
                    'role_users_mobile.name AS role_name',
                    'role_organization.id AS organization_id',
                    'role_organization.uuid AS organization_uuid',
                    'role_organization.name AS organization_name'
                )
                ->first();

            return response()->json([
                'statusCode' => 200,
                'message' => 'Laporan perumahan berhasil disimpan',
                'data' => [
                    "id_pokja3_bidang3" => $data->id_pokja3_bidang3,
                    "uuid" => $data->uuid,
                    "id_user" => $data->id_user,
                    "layak_huni" => $data->layak_huni,
                    "tidak_layak" => $data->tidak_layak,
                    "catatan" => $data->catatan,
                    "status" => $data->status,
                    "created_at" => $data->created_at,
                    "updated_at" => $data->updated_at,
                    "role" => [
                        "id" => $data->role_id,
                        "uuid" => $data->role_uuid,
                        "name" => $data->role_name
                    ],
                    "organization" => [
                        "id" => $data->organization_id,
                        "uuid" => $data->organization_uuid,
                        "name" => $data->organization_name
                    ]
                ],
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Terjadi kesalahan saat memproses permintaan',
                'data' => null,
                'error' => ['message' => $e->getMessage()]
            ], 500);
        }
    }

    // KADER POKJA 4
    public function insertKaderPokja4(Request $request)
    {
        try {
            if ($gagal = $this->validasiData($request, [
                'id_user' => 'required',
                'id_role' => 'required',
                'id_organization' => 'required',
                'posyandu' => 'integer|min:0',
                'gizi' => 'integer|min:0',
                'kesling' => 'integer|min:0',
                'penyuluhan_narkoba' => 'integer|min:0',
                'PHBS' => 'integer|min:0',
                'KB' => 'integer|min:0',
            ])) {
                return $gagal;
            }

            // UUID (SAMA PERSIS)
            $uuid = 'KP4-' . strtoupper(Str::random(6));

            // INSERT
            DB::table('laporan_kader_pokja4')->insert([
                'uuid' => $uuid,
                'id_user' => $request->id_user,
                'posyandu' => $request->posyandu ?? 0,
                'gizi' => $request->gizi ?? 0,
                'kesling' => $request->kesling ?? 0,
                'penyuluhan_narkoba' => $request->penyuluhan_narkoba ?? 0,
                'PHBS' => $request->PHBS ?? 0,
                'KB' => $request->KB ?? 0,
                'catatan' => $request->catatan ?? '',
                'status' => 'Proses',
                'created_at' => now(),
                'updated_at' => now(),
                'id_role' => $request->id_role,
                'id_organization' => $request->id_organization
            ]);

            // SELECT + JOIN
            $data = DB::table('laporan_kader_pokja4')
                ->leftJoin('role_users_mobile', 'laporan_kader_pokja4.id_role', '=', 'role_users_mobile.id')
                ->leftJoin('role_organization', 'laporan_kader_pokja4.id_organization', '=', 'role_organization.id')
                ->where('laporan_kader_pokja4.uuid', $uuid)
                ->select(
                    'laporan_kader_pokja4.id_kader_pokja4',
                    'laporan_kader_pokja4.uuid',
                    'laporan_kader_pokja4.id_user',
                    'laporan_kader_pokja4.posyandu',
                    'laporan_kader_pokja4.gizi',
                    'laporan_kader_pokja4.kesling',
                    'laporan_kader_pokja4.penyuluhan_narkoba',
                    'laporan_kader_pokja4.PHBS',
                    'laporan_kader_pokja4.KB',
                    'laporan_kader_pokja4.catatan',
                    'laporan_kader_pokja4.status',
                    'laporan_kader_pokja4.created_at',
                    'laporan_kader_pokja4.updated_at',
                    'role_users_mobile.id AS role_id',
                    'role_users_mobile.uuid AS role_uuid',
                    'role_users_mobile.name AS role_name',
                    'role_organization.id AS organization_id',
                    'role_organization.uuid AS organization_uuid',
                    'role_organization.name AS organization_name'
                )
                ->first();

            return response()->json([
                'statusCode' => 200,
                'message' => 'Laporan Kader Pokja 4 berhasil disimpan',
                'data' => [
                    "id_kader_pokja4" => $data->id_kader_pokja4,
                    "uuid" => $data->uuid,
                    "id_user" => $data->id_user,
                    "posyandu" => $data->posyandu,
                    "gizi" => $data->gizi,
                    "kesling" => $data->kesling,
                    "penyuluhan_narkoba" => $data->penyuluhan_narkoba,
                    "PHBS" => $data->PHBS,
                    "KB" => $data->KB,
                    "catatan" => $data->catatan,
                    "status" => $data->status,
                    "created_at" => $data->created_at,
                    "updated_at" => $data->updated_at,
                    "role" => [
                        "id" => $data->role_id,
                        "uuid" => $data->role_uuid,
                        "name" => $data->role_name
                    ],
                    "organization" => [
                        "id" => $data->organization_id,
                        "uuid" => $data->organization_uuid,
                        "name" => $data->organization_name
                    ]
                ],
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Terjadi kesalahan saat memproses permintaan',
                'data' => null,
                'error' => ['message' => $e->getMessage()]
            ], 500);
        }
    }


    // KESEHATAN (POKJA 4 BIDANG 1)
    public function insertKesehatan(Request $request)
    {
        try {
            if ($gagal = $this->validasiData($request, [
                'id_user' => 'required',
                'id_role' => 'required',
                'id_organization' => 'required',
                'kader_kesehatan' => 'integer|min:0',
                'kader_gizi' => 'integer|min:0',
                'kader_kesling' => 'integer|min:0',
                'kader_phbs' => 'integer|min:0',
                'kader_kb' => 'integer|min:0',
                'posyandu' => 'integer|min:0',
                'jumlah_posyandu' => 'integer|min:0',
                'jumlah_posyandu_iterasi' => 'integer|min:0',
                'imunisasi_vaksinasi' => 'integer|min:0',
                'pkg' => 'integer|min:0',
                'tbc' => 'integer|min:0',
                'jumlah_klp' => 'integer|min:0',
                'jumlah_anggota' => 'integer|min:0',
                'jumlah_kartu_gratis' => 'integer|min:0',
            ])) {
                return $gagal;
            }

            // UUID (SAMA PERSIS)
            $uuid = 'KP4B1-' . strtoupper(Str::random(6));

            // INSERT
            DB::table('laporan_bidang_kesehatan')->insert([
                'uuid' => $uuid,
                'id_user' => $request->id_user,
                // Kolom Format Pokja IV (Lampiran 4.24)
                'kader_kesehatan' => $request->kader_kesehatan ?? 0,
                'kader_gizi' => $request->kader_gizi ?? 0,
                'kader_kesling' => $request->kader_kesling ?? 0,
                'kader_phbs' => $request->kader_phbs ?? 0,
                'kader_kb' => $request->kader_kb ?? 0,
                'posyandu' => $request->posyandu ?? ($request->jumlah_posyandu ?? 0),
                'imunisasi_vaksinasi' => $request->imunisasi_vaksinasi ?? 0,
                'pkg' => $request->pkg ?? 0,
                'tbc' => $request->tbc ?? 0,
                // Tetap simpan nilai default / legacy agar data lama kompatibel
                'jumlah_posyandu' => $request->jumlah_posyandu ?? ($request->posyandu ?? 0),
                'jumlah_posyandu_iterasi' => $request->jumlah_posyandu_iterasi ?? 0,
                'jumlah_klp' => $request->jumlah_klp ?? 0,
                'jumlah_anggota' => $request->jumlah_anggota ?? 0,
                'jumlah_kartu_gratis' => $request->jumlah_kartu_gratis ?? 0,
                'catatan' => $request->catatan ?? '',
                'status' => 'Proses',
                'created_at' => now(),
                'updated_at' => now(),
                'id_role' => $request->id_role,
                'id_organization' => $request->id_organization
            ]);

            // SELECT + JOIN
            $data = DB::table('laporan_bidang_kesehatan')
                ->leftJoin('role_users_mobile', 'laporan_bidang_kesehatan.id_role', '=', 'role_users_mobile.id')
                ->leftJoin('role_organization', 'laporan_bidang_kesehatan.id_organization', '=', 'role_organization.id')
                ->where('laporan_bidang_kesehatan.uuid', $uuid)
                ->select(
                    'laporan_bidang_kesehatan.id_pokja4_bidang1',
                    'laporan_bidang_kesehatan.uuid',
                    'laporan_bidang_kesehatan.id_user',
                    'laporan_bidang_kesehatan.kader_kesehatan',
                    'laporan_bidang_kesehatan.kader_gizi',
                    'laporan_bidang_kesehatan.kader_kesling',
                    'laporan_bidang_kesehatan.kader_phbs',
                    'laporan_bidang_kesehatan.kader_kb',
                    'laporan_bidang_kesehatan.posyandu',
                    'laporan_bidang_kesehatan.imunisasi_vaksinasi',
                    'laporan_bidang_kesehatan.pkg',
                    'laporan_bidang_kesehatan.tbc',
                    'laporan_bidang_kesehatan.jumlah_posyandu',
                    'laporan_bidang_kesehatan.jumlah_posyandu_iterasi',
                    'laporan_bidang_kesehatan.jumlah_klp',
                    'laporan_bidang_kesehatan.jumlah_anggota',
                    'laporan_bidang_kesehatan.jumlah_kartu_gratis',
                    'laporan_bidang_kesehatan.catatan',
                    'laporan_bidang_kesehatan.status',
                    'laporan_bidang_kesehatan.created_at',
                    'laporan_bidang_kesehatan.updated_at',
                    'role_users_mobile.id AS role_id',
                    'role_users_mobile.uuid AS role_uuid',
                    'role_users_mobile.name AS role_name',
                    'role_organization.id AS organization_id',
                    'role_organization.uuid AS organization_uuid',
                    'role_organization.name AS organization_name'
                )
                ->first();

            return response()->json([
                'statusCode' => 200,
                'message' => 'Laporan Bidang Kesehatan berhasil disimpan',
                'data' => [
                    "id_pokja4_bidang1" => $data->id_pokja4_bidang1,
                    "uuid" => $data->uuid,
                    "id_user" => $data->id_user,
                    "kader_kesehatan" => $data->kader_kesehatan ?? 0,
                    "kader_gizi" => $data->kader_gizi ?? 0,
                    "kader_kesling" => $data->kader_kesling ?? 0,
                    "kader_phbs" => $data->kader_phbs ?? 0,
                    "kader_kb" => $data->kader_kb ?? 0,
                    "posyandu" => $data->posyandu ?? 0,
                    "imunisasi_vaksinasi" => $data->imunisasi_vaksinasi ?? 0,
                    "pkg" => $data->pkg ?? 0,
                    "tbc" => $data->tbc ?? 0,
                    "jumlah_posyandu" => $data->jumlah_posyandu,
                    "jumlah_posyandu_iterasi" => $data->jumlah_posyandu_iterasi,
                    "jumlah_klp" => $data->jumlah_klp,
                    "jumlah_anggota" => $data->jumlah_anggota,
                    "jumlah_kartu_gratis" => $data->jumlah_kartu_gratis,
                    "catatan" => $data->catatan,
                    "status" => $data->status,
                    "created_at" => $data->created_at,
                    "updated_at" => $data->updated_at,
                    "role" => [
                        "id" => $data->role_id,
                        "uuid" => $data->role_uuid,
                        "name" => $data->role_name
                    ],
                    "organization" => [
                        "id" => $data->organization_id,
                        "uuid" => $data->organization_uuid,
                        "name" => $data->organization_name
                    ]
                ],
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Terjadi kesalahan saat memproses permintaan',
                'data' => null,
                'error' => ['message' => $e->getMessage()]
            ], 500);
        }
    }

    // LINGKUNGAN HIDUP (POKJA 4 BIDANG 2)
    public function insertLingkunganHidup(Request $request)
    {
        try {
            if ($gagal = $this->validasiData($request, [
                'id_user' => 'required',
                'id_role' => 'required',
                'id_organization' => 'required',
                'jamban' => 'integer|min:0',
                'spal' => 'integer|min:0',
                'tps' => 'integer|min:0',
                'mck' => 'integer|min:0',
                'pdam' => 'integer|min:0',
                'sumur' => 'integer|min:0',
                'dll' => 'integer|min:0',
            ])) {
                return $gagal;
            }

            // UUID (SAMA PERSIS)
            $uuid = 'KP4B2-' . strtoupper(Str::random(6));

            // INSERT
            DB::table('laporan_kelestarian_lingkungan_hidup')->insert([
                'uuid' => $uuid,
                'id_user' => $request->id_user,
                'jamban' => $request->jamban ?? 0,
                'spal' => $request->spal ?? 0,
                'tps' => $request->tps ?? 0,
                'mck' => $request->mck ?? 0,
                'pdam' => $request->pdam ?? 0,
                'sumur' => $request->sumur ?? 0,
                'dll' => $request->dll ?? 0,
                'catatan' => $request->catatan ?? '',
                'status' => 'Proses',
                'created_at' => now(),
                'updated_at' => now(),
                'id_role' => $request->id_role,
                'id_organization' => $request->id_organization
            ]);

            // SELECT + JOIN
            $data = DB::table('laporan_kelestarian_lingkungan_hidup')
                ->leftJoin('role_users_mobile', 'laporan_kelestarian_lingkungan_hidup.id_role', '=', 'role_users_mobile.id')
                ->leftJoin('role_organization', 'laporan_kelestarian_lingkungan_hidup.id_organization', '=', 'role_organization.id')
                ->where('laporan_kelestarian_lingkungan_hidup.uuid', $uuid)
                ->select(
                    'laporan_kelestarian_lingkungan_hidup.id_pokja4_bidang2',
                    'laporan_kelestarian_lingkungan_hidup.uuid',
                    'laporan_kelestarian_lingkungan_hidup.id_user',
                    'laporan_kelestarian_lingkungan_hidup.jamban',
                    'laporan_kelestarian_lingkungan_hidup.spal',
                    'laporan_kelestarian_lingkungan_hidup.tps',
                    'laporan_kelestarian_lingkungan_hidup.mck',
                    'laporan_kelestarian_lingkungan_hidup.pdam',
                    'laporan_kelestarian_lingkungan_hidup.sumur',
                    'laporan_kelestarian_lingkungan_hidup.dll',
                    'laporan_kelestarian_lingkungan_hidup.catatan',
                    'laporan_kelestarian_lingkungan_hidup.status',
                    'laporan_kelestarian_lingkungan_hidup.created_at',
                    'laporan_kelestarian_lingkungan_hidup.updated_at',
                    'role_users_mobile.id AS role_id',
                    'role_users_mobile.uuid AS role_uuid',
                    'role_users_mobile.name AS role_name',
                    'role_organization.id AS organization_id',
                    'role_organization.uuid AS organization_uuid',
                    'role_organization.name AS organization_name'
                )
                ->first();

            return response()->json([
                'statusCode' => 200,
                'message' => 'Laporan Kelestarian Lingkungan Hidup berhasil disimpan',
                'data' => [
                    "id_pokja4_bidang2" => $data->id_pokja4_bidang2,
                    "uuid" => $data->uuid,
                    "id_user" => $data->id_user,
                    "jamban" => $data->jamban,
                    "spal" => $data->spal,
                    "tps" => $data->tps,
                    "mck" => $data->mck,
                    "pdam" => $data->pdam,
                    "sumur" => $data->sumur,
                    "dll" => $data->dll,
                    "catatan" => $data->catatan,
                    "status" => $data->status,
                    "created_at" => $data->created_at,
                    "updated_at" => $data->updated_at,
                    "role" => [
                        "id" => $data->role_id,
                        "uuid" => $data->role_uuid,
                        "name" => $data->role_name
                    ],
                    "organization" => [
                        "id" => $data->organization_id,
                        "uuid" => $data->organization_uuid,
                        "name" => $data->organization_name
                    ]
                ],
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Terjadi kesalahan saat memproses permintaan',
                'data' => null,
                'error' => ['message' => $e->getMessage()]
            ], 500);
        }
    }

    // PERENCANAAN SEHAT (POKJA 4 BIDANG 3)
    public function insertPerencanaanSehat(Request $request)
    {
        try {
            if ($gagal = $this->validasiData($request, [
                'id_user' => 'required',
                'id_role' => 'required',
                'id_organization' => 'required',
                'J_Psubur' => 'integer|min:0',
                'J_Wsubur' => 'integer|min:0',
                'Kb_p' => 'integer|min:0',
                'Kb_w' => 'integer|min:0',
                'Kk_tbg' => 'integer|min:0',
                'Kk_asuransi' => 'integer|min:0',
            ])) {
                return $gagal;
            }

            // UUID (SAMA PERSIS)
            $uuid = 'KP4B3-' . strtoupper(Str::random(6));

            // INSERT
            DB::table('laporan_perencanaan_sehat')->insert([
                'uuid' => $uuid,
                'id_user' => $request->id_user,
                'J_Psubur' => $request->J_Psubur ?? 0,
                'J_Wsubur' => $request->J_Wsubur ?? 0,
                'Kb_p' => $request->Kb_p ?? 0,
                'Kb_w' => $request->Kb_w ?? 0,
                'Kk_tbg' => $request->Kk_tbg ?? 0,
                'Kk_asuransi' => $request->Kk_asuransi ?? 0,
                'catatan' => $request->catatan ?? '',
                'status' => 'Proses',
                'created_at' => now(),
                'updated_at' => now(),
                'id_role' => $request->id_role,
                'id_organization' => $request->id_organization
            ]);

            // SELECT + JOIN
            $data = DB::table('laporan_perencanaan_sehat')
                ->leftJoin('role_users_mobile', 'laporan_perencanaan_sehat.id_role', '=', 'role_users_mobile.id')
                ->leftJoin('role_organization', 'laporan_perencanaan_sehat.id_organization', '=', 'role_organization.id')
                ->where('laporan_perencanaan_sehat.uuid', $uuid)
                ->select(
                    'laporan_perencanaan_sehat.id_pokja4_bidang3',
                    'laporan_perencanaan_sehat.uuid',
                    'laporan_perencanaan_sehat.id_user',
                    'laporan_perencanaan_sehat.J_Psubur',
                    'laporan_perencanaan_sehat.J_Wsubur',
                    'laporan_perencanaan_sehat.Kb_p',
                    'laporan_perencanaan_sehat.Kb_w',
                    'laporan_perencanaan_sehat.Kk_tbg',
                    'laporan_perencanaan_sehat.Kk_asuransi',
                    'laporan_perencanaan_sehat.catatan',
                    'laporan_perencanaan_sehat.status',
                    'laporan_perencanaan_sehat.created_at',
                    'laporan_perencanaan_sehat.updated_at',
                    'role_users_mobile.id AS role_id',
                    'role_users_mobile.uuid AS role_uuid',
                    'role_users_mobile.name AS role_name',
                    'role_organization.id AS organization_id',
                    'role_organization.uuid AS organization_uuid',
                    'role_organization.name AS organization_name'
                )
                ->first();

            return response()->json([
                'statusCode' => 200,
                'message' => 'Laporan Perencanaan Sehat berhasil disimpan',
                'data' => [
                    "id_pokja4_bidang3" => $data->id_pokja4_bidang3,
                    "uuid" => $data->uuid,
                    "id_user" => $data->id_user,
                    "J_Psubur" => $data->J_Psubur,
                    "J_Wsubur" => $data->J_Wsubur,
                    "Kb_p" => $data->Kb_p,
                    "Kb_w" => $data->Kb_w,
                    "Kk_tbg" => $data->Kk_tbg,
                    "Kk_asuransi" => $data->Kk_asuransi,
                    "catatan" => $data->catatan,
                    "status" => $data->status,
                    "created_at" => $data->created_at,
                    "updated_at" => $data->updated_at,
                    "role" => [
                        "id" => $data->role_id,
                        "uuid" => $data->role_uuid,
                        "name" => $data->role_name
                    ],
                    "organization" => [
                        "id" => $data->organization_id,
                        "uuid" => $data->organization_uuid,
                        "name" => $data->organization_name
                    ]
                ],
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Terjadi kesalahan saat memproses permintaan',
                'data' => null,
                'error' => ['message' => $e->getMessage()]
            ], 500);
        }
    }
    /// ===============================
    /// INOVASI
    /// REKAP DESA BULANAN
    /// ===============================
    public function insertRekapDesaBulanan(Request $request)
    {
        try {

            /// ================= VALIDATION =================

            if ($gagal = $this->validasiData($request, [
                'id_user'         => 'required',
                'id_role'         => 'required',
                'id_organization' => 'required',
                'kategori'        => 'required',
                'rw'                       => 'integer|min:0',
                'rt'                       => 'integer|min:0',
                'dasa_wisma'               => 'integer|min:0',
                'hamil'                    => 'integer|min:0',
                'melahirkan'               => 'integer|min:0',
                'nifas'                    => 'integer|min:0',
                'meninggal'                => 'integer|min:0',
                'bayi_lahir_l'             => 'integer|min:0',
                'bayi_lahir_p'             => 'integer|min:0',
                'akte_kelahiran_ada'       => 'integer|min:0',
                'akte_kelahiran_tidak'     => 'integer|min:0',
                'bayi_meninggal_l'         => 'integer|min:0',
                'bayi_meninggal_p'         => 'integer|min:0',
                'balita_meninggal_l'       => 'integer|min:0',
                'balita_meninggal_p'       => 'integer|min:0',
            ])) {
                return $gagal;
            }

            /// ================= UUID =================

            $uuid =
                strtoupper($request->kategori) .
                '-RDB-' .
                strtoupper(Str::random(6));

            /// ================= INSERT =================

            DB::table('rekap_desa_bulanan')->insert([

                'uuid'                     => $uuid,
                'id_user'                  => $request->id_user,
                'id_role'                  => $request->id_role,
                'id_organization'          => $request->id_organization,

                'kategori'                 => strtolower($request->kategori),

                'rw'                       => $request->rw ?? 0,
                'rt'                       => $request->rt ?? 0,
                'dasa_wisma'               => $request->dasa_wisma ?? 0,

                'hamil'                    => $request->hamil ?? 0,
                'melahirkan'               => $request->melahirkan ?? 0,
                'nifas'                    => $request->nifas ?? 0,
                'meninggal'                => $request->meninggal ?? 0,

                'bayi_lahir_l'             => $request->bayi_lahir_l ?? 0,
                'bayi_lahir_p'             => $request->bayi_lahir_p ?? 0,

                'akte_kelahiran_ada'       => $request->akte_kelahiran_ada ?? 0,
                'akte_kelahiran_tidak'     => $request->akte_kelahiran_tidak ?? 0,

                'bayi_meninggal_l'         => $request->bayi_meninggal_l ?? 0,
                'bayi_meninggal_p'         => $request->bayi_meninggal_p ?? 0,

                'balita_meninggal_l'       => $request->balita_meninggal_l ?? 0,
                'balita_meninggal_p'       => $request->balita_meninggal_p ?? 0,

                'catatan'                  => $request->catatan ?? '',
                'status'                   => 'Proses',

                'created_at'               => now(),
                'updated_at'               => now(),
            ]);

            /// ================= GET DATA =================

            $data = DB::table('rekap_desa_bulanan')

                ->leftJoin(
                    'role_users_mobile',
                    'rekap_desa_bulanan.id_role',
                    '=',
                    'role_users_mobile.id'
                )

                ->leftJoin(
                    'role_organization',
                    'rekap_desa_bulanan.id_organization',
                    '=',
                    'role_organization.id'
                )

                ->where(
                    'rekap_desa_bulanan.uuid',
                    $uuid
                )

                ->select(

                    'rekap_desa_bulanan.*',

                    'role_users_mobile.id AS role_id',
                    'role_users_mobile.uuid AS role_uuid',
                    'role_users_mobile.name AS role_name',

                    'role_organization.id AS organization_id',
                    'role_organization.uuid AS organization_uuid',
                    'role_organization.name AS organization_name'
                )

                ->first();

            /// ================= RESPONSE =================

            return response()->json([

                'statusCode' => 200,

                'message' =>
                'Rekap Desa Bulanan berhasil disimpan',

                'data' => [

                    'id_rekap_desa_bulanan' => $data->id_rekap_desa_bulanan,

                    'uuid'                  => $data->uuid,
                    'id_user'               => $data->id_user,

                    'kategori'              => $data->kategori,

                    'rw'                    => $data->rw,
                    'rt'                    => $data->rt,
                    'dasa_wisma'            => $data->dasa_wisma,

                    'hamil'                 => $data->hamil,
                    'melahirkan'            => $data->melahirkan,
                    'nifas'                 => $data->nifas,
                    'meninggal'             => $data->meninggal,

                    'bayi_lahir_l'          => $data->bayi_lahir_l,
                    'bayi_lahir_p'          => $data->bayi_lahir_p,

                    'akte_kelahiran_ada'    => $data->akte_kelahiran_ada,
                    'akte_kelahiran_tidak'  => $data->akte_kelahiran_tidak,

                    'bayi_meninggal_l'      => $data->bayi_meninggal_l,
                    'bayi_meninggal_p'      => $data->bayi_meninggal_p,

                    'balita_meninggal_l'    => $data->balita_meninggal_l,
                    'balita_meninggal_p'    => $data->balita_meninggal_p,

                    'catatan'               => $data->catatan,
                    'status'                => $data->status,

                    'created_at'            => $data->created_at,
                    'updated_at'            => $data->updated_at,

                    'role' => [
                        'id'    => $data->role_id,
                        'uuid'  => $data->role_uuid,
                        'name'  => $data->role_name,
                    ],

                    'organization' => [
                        'id'    => $data->organization_id,
                        'uuid'  => $data->organization_uuid,
                        'name'  => $data->organization_name,
                    ],
                ],

                'error' => null

            ], 200);
        } catch (\Exception $e) {

            return response()->json([

                'statusCode' => 500,

                'message' =>
                'Terjadi kesalahan saat memproses permintaan',

                'data' => null,

                'error' => [
                    'message' => $e->getMessage(),
                ]

            ], 500);
        }
    }
    /// ===============================
    /// INOVASI
    /// REKAP DESA TAHUNAN
    /// ===============================
    public function insertRekapDesaTahunan(Request $request)
    {
        try {

            /// ================= VALIDATION =================

            if ($gagal = $this->validasiData($request, [

                'id_user'         => 'required',

                'id_role'         => 'required',

                'id_organization' => 'required',

                'kategori'        => 'required',

                'kader_kesehatan'          => 'integer|min:0',
                'gizi'                     => 'integer|min:0',
                'kesling'                  => 'integer|min:0',
                'phbs'                     => 'integer|min:0',
                'kb'                       => 'integer|min:0',
                'posyandu'                 => 'integer|min:0',
                'imunisasi_vaksinasi_bayi_balita' => 'integer|min:0',
                'pkg'                      => 'integer|min:0',
                'tbc'                      => 'integer|min:0',
                'jamban_wc'                => 'integer|min:0',
                'spal'                     => 'integer|min:0',
                'tps'                      => 'integer|min:0',
                'jumlah_mck'               => 'integer|min:0',
                'pdam'                     => 'integer|min:0',
                'sumur'                    => 'integer|min:0',
                'lain_lain'                => 'integer|min:0',
                'jml_pus'                  => 'integer|min:0',
                'jml_wus'                  => 'integer|min:0',
                'akseptor_kb_l'            => 'integer|min:0',
                'akseptor_kb_p'            => 'integer|min:0',
                'jml_kk_tabungan'          => 'integer|min:0',
                'jml_kk_asuransi'          => 'integer|min:0',
                'kesehatan_program'        => 'integer|min:0',
                'kelestarian_lingkungan_hidup' => 'integer|min:0',
                'perencanaan_sehat_program'    => 'integer|min:0',
            ])) {
                return $gagal;
            }

            /// ================= UUID =================

            $uuid =
                strtoupper($request->kategori) .
                '-RDT-' .
                strtoupper(Str::random(6));

            /// ================= INSERT =================

            DB::table('rekap_desa_tahunan')->insert([

                'uuid'                     => $uuid,

                'id_user'                  => $request->id_user,

                'id_role'                  => $request->id_role,

                'id_organization'          => $request->id_organization,

                'kategori'                 => strtolower($request->kategori),

                'kader_kesehatan'          => $request->kader_kesehatan ?? 0,

                'gizi'                     => $request->gizi ?? 0,

                'kesling'                  => $request->kesling ?? 0,

                'phbs'                     => $request->phbs ?? 0,

                'kb'                       => $request->kb ?? 0,

                'posyandu'                 => $request->posyandu ?? 0,

                'imunisasi_vaksinasi_bayi_balita'
                => $request->imunisasi_vaksinasi_bayi_balita ?? 0,

                'pkg'                      => $request->pkg ?? 0,

                'tbc'                      => $request->tbc ?? 0,

                'jamban_wc'                => $request->jamban_wc ?? 0,

                'spal'                     => $request->spal ?? 0,

                'tps'                      => $request->tps ?? 0,

                'jumlah_mck'               => $request->jumlah_mck ?? 0,

                'pdam'                     => $request->pdam ?? 0,

                'sumur'                    => $request->sumur ?? 0,

                'lain_lain'                => $request->lain_lain ?? 0,

                'jml_pus'                  => $request->jml_pus ?? 0,

                'jml_wus'                  => $request->jml_wus ?? 0,

                'akseptor_kb_l'            => $request->akseptor_kb_l ?? 0,

                'akseptor_kb_p'            => $request->akseptor_kb_p ?? 0,

                'jml_kk_tabungan'          => $request->jml_kk_tabungan ?? 0,

                'jml_kk_asuransi'          => $request->jml_kk_asuransi ?? 0,

                'kesehatan_program'        => $request->kesehatan_program ?? 0,

                'kelestarian_lingkungan_hidup'
                => $request->kelestarian_lingkungan_hidup ?? 0,

                'perencanaan_sehat_program'
                => $request->perencanaan_sehat_program ?? 0,

                'catatan'                  => $request->catatan ?? '',

                'status'                   => 'Proses',

                'created_at'               => now(),

                'updated_at'               => now(),
            ]);

            /// ================= GET DATA =================

            $data = DB::table('rekap_desa_tahunan')

                ->leftJoin(
                    'role_users_mobile',
                    'rekap_desa_tahunan.id_role',
                    '=',
                    'role_users_mobile.id'
                )

                ->leftJoin(
                    'role_organization',
                    'rekap_desa_tahunan.id_organization',
                    '=',
                    'role_organization.id'
                )

                ->where(
                    'rekap_desa_tahunan.uuid',
                    $uuid
                )

                ->select(

                    'rekap_desa_tahunan.*',

                    'role_users_mobile.id AS role_id',
                    'role_users_mobile.uuid AS role_uuid',
                    'role_users_mobile.name AS role_name',

                    'role_organization.id AS organization_id',
                    'role_organization.uuid AS organization_uuid',
                    'role_organization.name AS organization_name'
                )

                ->first();

            /// ================= RESPONSE =================

            return response()->json([

                'statusCode' => 200,

                'message' =>
                'Rekap Desa Tahunan berhasil disimpan',

                'data' => [

                    'id_rekap_desa_tahunan'
                    => $data->id_rekap_desa_tahunan,

                    'uuid'
                    => $data->uuid,

                    'id_user'
                    => $data->id_user,

                    'kategori'
                    => $data->kategori,

                    'kader_kesehatan'
                    => $data->kader_kesehatan,

                    'gizi'
                    => $data->gizi,

                    'kesling'
                    => $data->kesling,

                    'phbs'
                    => $data->phbs,

                    'kb'
                    => $data->kb,

                    'posyandu'
                    => $data->posyandu,

                    'imunisasi_vaksinasi_bayi_balita'
                    => $data->imunisasi_vaksinasi_bayi_balita,

                    'pkg'
                    => $data->pkg,

                    'tbc'
                    => $data->tbc,

                    'jamban_wc'
                    => $data->jamban_wc,

                    'spal'
                    => $data->spal,

                    'tps'
                    => $data->tps,

                    'jumlah_mck'
                    => $data->jumlah_mck,

                    'pdam'
                    => $data->pdam,

                    'sumur'
                    => $data->sumur,

                    'lain_lain'
                    => $data->lain_lain,

                    'jml_pus'
                    => $data->jml_pus,

                    'jml_wus'
                    => $data->jml_wus,

                    'akseptor_kb_l'
                    => $data->akseptor_kb_l,

                    'akseptor_kb_p'
                    => $data->akseptor_kb_p,

                    'jml_kk_tabungan'
                    => $data->jml_kk_tabungan,

                    'jml_kk_asuransi'
                    => $data->jml_kk_asuransi,

                    'kesehatan_program'
                    => $data->kesehatan_program,

                    'kelestarian_lingkungan_hidup'
                    => $data->kelestarian_lingkungan_hidup,

                    'perencanaan_sehat_program'
                    => $data->perencanaan_sehat_program,

                    'catatan'
                    => $data->catatan,

                    'status'
                    => $data->status,

                    'created_at'
                    => $data->created_at,

                    'updated_at'
                    => $data->updated_at,

                    'role' => [

                        'id'
                        => $data->role_id,

                        'uuid'
                        => $data->role_uuid,

                        'name'
                        => $data->role_name,
                    ],

                    'organization' => [

                        'id'
                        => $data->organization_id,

                        'uuid'
                        => $data->organization_uuid,

                        'name'
                        => $data->organization_name,
                    ],
                ],

                'error' => null

            ], 200);
        } catch (\Exception $e) {

            return response()->json([

                'statusCode' => 500,

                'message' =>
                'Terjadi kesalahan saat memproses permintaan',

                'data' => null,

                'error' => [

                    'message'
                    => $e->getMessage(),
                ]

            ], 500);
        }
    }
    /// =======================================================
    /// INSERT POSYANDU
    /// =======================================================

    public function insertPosyandu(Request $request)
    {
        try {

            /// ================= VALIDATION =================

            if ($gagal = $this->validasiData($request, [
                'id_user'         => 'required',
                'id_role'         => 'required',
                'id_organization' => 'required',
                'kategori'        => 'required',
                'bulan'           => 'required',
                'jml_ibu_hamil'    => 'integer|min:0',
                'diperiksa'        => 'integer|min:0',
                'fe_tablet_darah'  => 'integer|min:0',
                'jml_ibu_menyusui' => 'integer|min:0',
                'kondom'           => 'integer|min:0',
                'pil'              => 'integer|min:0',
                'implant'          => 'integer|min:0',
                'mop'              => 'integer|min:0',
                'mow'              => 'integer|min:0',
                'iud'              => 'integer|min:0',
                'suntikan'         => 'integer|min:0',
                'lain_lain_kb'     => 'integer|min:0',
                'jml_balita_l'     => 'integer|min:0',
                'jml_balita_p'     => 'integer|min:0',
                'buku_kia_l'       => 'integer|min:0',
                'buku_kia_p'       => 'integer|min:0',
                'datang_l'         => 'integer|min:0',
                'datang_p'         => 'integer|min:0',
                'naik_l'           => 'integer|min:0',
                'naik_p'           => 'integer|min:0',
                'vit_a_l'          => 'integer|min:0',
                'vit_a_p'          => 'integer|min:0',
                'pmt_l'            => 'integer|min:0',
                'pmt_p'            => 'integer|min:0',
                'imunisasi_tt_1'   => 'integer|min:0',
                'imunisasi_tt_2'   => 'integer|min:0',
            ])) {
                return $gagal;
            }

            /// ================= UUID =================

            $uuid =
                strtoupper($request->kategori) .
                '-POS-' .
                strtoupper(Str::random(6));

            /// ================= INSERT =================

            DB::table('posyandu')->insert([

                'uuid'                     => $uuid,

                'id_user'                  => $request->id_user,

                'id_role'                  => $request->id_role,

                'id_organization'          => $request->id_organization,

                'kategori'                 => strtolower($request->kategori),

                'bulan'                    => $request->bulan,

                'jml_ibu_hamil'            => $request->jml_ibu_hamil ?? 0,

                'diperiksa'                => $request->diperiksa ?? 0,

                'fe_tablet_darah'          => $request->fe_tablet_darah ?? 0,

                'jml_ibu_menyusui'         => $request->jml_ibu_menyusui ?? 0,

                'kondom'                   => $request->kondom ?? 0,

                'pil'                      => $request->pil ?? 0,

                'implant'                  => $request->implant ?? 0,

                'mop'                      => $request->mop ?? 0,

                'mow'                      => $request->mow ?? 0,

                'iud'                      => $request->iud ?? 0,

                'suntikan'                 => $request->suntikan ?? 0,

                'lain_lain_kb'              => $request->lain_lain_kb ?? 0,

                'jml_balita_l'             => $request->jml_balita_l ?? 0,

                'jml_balita_p'             => $request->jml_balita_p ?? 0,

                'buku_kia_l'               => $request->buku_kia_l ?? 0,

                'buku_kia_p'               => $request->buku_kia_p ?? 0,

                'datang_l'                 => $request->datang_l ?? 0,

                'datang_p'                 => $request->datang_p ?? 0,

                'naik_l'                   => $request->naik_l ?? 0,

                'naik_p'                   => $request->naik_p ?? 0,

                'vit_a_l'                  => $request->vit_a_l ?? 0,

                'vit_a_p'                  => $request->vit_a_p ?? 0,

                'pmt_l'                    => $request->pmt_l ?? 0,

                'pmt_p'                    => $request->pmt_p ?? 0,

                'imunisasi_tt_1'           => $request->imunisasi_tt_1 ?? 0,

                'imunisasi_tt_2'           => $request->imunisasi_tt_2 ?? 0,

                'catatan'                  => $request->catatan ?? '',

                'status'                   => 'Proses',

                'created_at'               => now(),

                'updated_at'               => now(),
            ]);

            /// ================= GET DATA =================

            $data = DB::table('posyandu')

                ->leftJoin(
                    'role_users_mobile',
                    'posyandu.id_role',
                    '=',
                    'role_users_mobile.id'
                )

                ->leftJoin(
                    'role_organization',
                    'posyandu.id_organization',
                    '=',
                    'role_organization.id'
                )

                ->where(
                    'posyandu.uuid',
                    $uuid
                )

                ->select(

                    'posyandu.*',

                    'role_users_mobile.id AS role_id',
                    'role_users_mobile.uuid AS role_uuid',
                    'role_users_mobile.name AS role_name',

                    'role_organization.id AS organization_id',
                    'role_organization.uuid AS organization_uuid',
                    'role_organization.name AS organization_name'
                )

                ->first();

            /// ================= RESPONSE =================

            return response()->json([

                'statusCode' => 200,

                'message' =>
                'Posyandu berhasil disimpan',

                'data' => [

                    'id_posyandu'            => $data->id_posyandu,

                    'uuid'                   => $data->uuid,

                    'id_user'                => $data->id_user,

                    'kategori'               => $data->kategori,

                    'bulan'                  => $data->bulan,

                    'jml_ibu_hamil'          => $data->jml_ibu_hamil,

                    'diperiksa'              => $data->diperiksa,

                    'fe_tablet_darah'        => $data->fe_tablet_darah,

                    'jml_ibu_menyusui'       => $data->jml_ibu_menyusui,

                    'kondom'                 => $data->kondom,

                    'pil'                    => $data->pil,

                    'implant'                => $data->implant,

                    'mop'                    => $data->mop,

                    'mow'                    => $data->mow,

                    'iud'                    => $data->iud,

                    'suntikan'               => $data->suntikan,

                    'lain_lain_kb'           => $data->lain_lain_kb,

                    'jml_balita_l'           => $data->jml_balita_l,

                    'jml_balita_p'           => $data->jml_balita_p,

                    'buku_kia_l'             => $data->buku_kia_l,

                    'buku_kia_p'             => $data->buku_kia_p,

                    'datang_l'               => $data->datang_l,

                    'datang_p'               => $data->datang_p,

                    'naik_l'                 => $data->naik_l,

                    'naik_p'                 => $data->naik_p,

                    'vit_a_l'                => $data->vit_a_l,

                    'vit_a_p'                => $data->vit_a_p,

                    'pmt_l'                  => $data->pmt_l,

                    'pmt_p'                  => $data->pmt_p,

                    'imunisasi_tt_1'         => $data->imunisasi_tt_1,

                    'imunisasi_tt_2'         => $data->imunisasi_tt_2,

                    'catatan'                => $data->catatan,

                    'status'                 => $data->status,

                    'created_at'             => $data->created_at,

                    'updated_at'             => $data->updated_at,

                    'role' => [
                        'id'    => $data->role_id,
                        'uuid'  => $data->role_uuid,
                        'name'  => $data->role_name,
                    ],

                    'organization' => [
                        'id'    => $data->organization_id,
                        'uuid'  => $data->organization_uuid,
                        'name'  => $data->organization_name,
                    ],
                ],

                'error' => null

            ], 200);
        } catch (\Exception $e) {

            return response()->json([

                'statusCode' => 500,

                'message' =>
                'Terjadi kesalahan saat memproses permintaan',

                'data' => null,

                'error' => [
                    'message' => $e->getMessage(),
                ]

            ], 500);
        }
    }
    /// =======================================================
    /// INSERT KEGIATAN POKJA 4
    /// =======================================================

    public function insertKegiatanPokja4(Request $request)
    {
        try {

            /// ================= VALIDATION =================

            if ($gagal = $this->validasiData($request, [
                'id_user'         => 'required',
                'id_role'         => 'required',
                'id_organization' => 'required',
                'kategori'        => 'required',
                'kader_kesehatan'          => 'integer|min:0',
                'gizi'                     => 'integer|min:0',
                'kesling'                  => 'integer|min:0',
                'phbs'                     => 'integer|min:0',
                'kb'                       => 'integer|min:0',
                'posyandu'                 => 'integer|min:0',
                'imunisasi_vaksinasi_bayi_balita' => 'integer|min:0',
                'pkg'                      => 'integer|min:0',
                'tbc'                      => 'integer|min:0',
                'jamban_wc'                => 'integer|min:0',
                'spal'                     => 'integer|min:0',
                'tps'                      => 'integer|min:0',
                'jumlah_mck'               => 'integer|min:0',
                'pdam'                     => 'integer|min:0',
                'sumur'                    => 'integer|min:0',
                'lain_lain'                => 'integer|min:0',
                'jml_pus'                  => 'integer|min:0',
                'jml_wus'                  => 'integer|min:0',
                'akseptor_kb_l'            => 'integer|min:0',
                'akseptor_kb_p'            => 'integer|min:0',
                'kk_memiliki_tabungan'     => 'integer|min:0',
                'kk_memiliki_asuransi'     => 'integer|min:0',
                'kesehatan'                => 'integer|min:0',
                'kelestarian_lingkungan_hidup' => 'integer|min:0',
                'perencanaan_sehat'            => 'integer|min:0',
            ])) {
                return $gagal;
            }

            /// ================= UUID =================

            $uuid =
                strtoupper($request->kategori) .
                '-KP4-' .
                strtoupper(Str::random(6));

            /// ================= INSERT =================

            DB::table('kegiatan_pokja4')->insert([

                'uuid'                     => $uuid,

                'id_user'                  => $request->id_user,

                'id_role'                  => $request->id_role,

                'id_organization'          => $request->id_organization,

                'kategori'                 => strtolower($request->kategori),

                'kader_kesehatan'          => $request->kader_kesehatan ?? 0,

                'gizi'                     => $request->gizi ?? 0,

                'kesling'                  => $request->kesling ?? 0,

                'phbs'                     => $request->phbs ?? 0,

                'kb'                       => $request->kb ?? 0,

                'posyandu'                 => $request->posyandu ?? 0,

                'imunisasi_vaksinasi_bayi_balita'
                => $request->imunisasi_vaksinasi_bayi_balita ?? 0,

                'pkg'                      => $request->pkg ?? 0,

                'tbc'                      => $request->tbc ?? 0,

                'jamban_wc'                => $request->jamban_wc ?? 0,

                'spal'                     => $request->spal ?? 0,

                'tps'                      => $request->tps ?? 0,

                'jumlah_mck'               => $request->jumlah_mck ?? 0,

                'pdam'                     => $request->pdam ?? 0,

                'sumur'                    => $request->sumur ?? 0,

                'lain_lain'                => $request->lain_lain ?? 0,

                'jml_pus'                  => $request->jml_pus ?? 0,

                'jml_wus'                  => $request->jml_wus ?? 0,

                'akseptor_kb_l'            => $request->akseptor_kb_l ?? 0,

                'akseptor_kb_p'            => $request->akseptor_kb_p ?? 0,

                'kk_memiliki_tabungan'
                => $request->kk_memiliki_tabungan ?? 0,

                'kk_memiliki_asuransi'
                => $request->kk_memiliki_asuransi ?? 0,

                'kesehatan'                => $request->kesehatan ?? 0,

                'kelestarian_lingkungan_hidup'
                => $request->kelestarian_lingkungan_hidup ?? 0,

                'perencanaan_sehat'
                => $request->perencanaan_sehat ?? 0,

                'catatan'                  => $request->catatan ?? '',

                'status'                   => 'Proses',

                'created_at'               => now(),

                'updated_at'               => now(),
            ]);

            /// ================= GET DATA =================

            $data = DB::table('kegiatan_pokja4')

                ->leftJoin(
                    'role_users_mobile',
                    'kegiatan_pokja4.id_role',
                    '=',
                    'role_users_mobile.id'
                )

                ->leftJoin(
                    'role_organization',
                    'kegiatan_pokja4.id_organization',
                    '=',
                    'role_organization.id'
                )

                ->where(
                    'kegiatan_pokja4.uuid',
                    $uuid
                )

                ->select(

                    'kegiatan_pokja4.*',

                    'role_users_mobile.id AS role_id',
                    'role_users_mobile.uuid AS role_uuid',
                    'role_users_mobile.name AS role_name',

                    'role_organization.id AS organization_id',
                    'role_organization.uuid AS organization_uuid',
                    'role_organization.name AS organization_name'
                )

                ->first();

            /// ================= RESPONSE =================

            return response()->json([

                'statusCode' => 200,

                'message' =>
                'Kegiatan Pokja 4 berhasil disimpan',

                'data' => [

                    'id_kegiatan_pokja4'
                    => $data->id_kegiatan_pokja4,

                    'uuid'             => $data->uuid,

                    'id_user'          => $data->id_user,

                    'kategori'         => $data->kategori,

                    'kader_kesehatan'
                    => $data->kader_kesehatan,

                    'gizi'             => $data->gizi,

                    'kesling'          => $data->kesling,

                    'phbs'             => $data->phbs,

                    'kb'               => $data->kb,

                    'posyandu'         => $data->posyandu,

                    'imunisasi_vaksinasi_bayi_balita'
                    => $data->imunisasi_vaksinasi_bayi_balita,

                    'pkg'              => $data->pkg,

                    'tbc'              => $data->tbc,

                    'jamban_wc'        => $data->jamban_wc,

                    'spal'             => $data->spal,

                    'tps'              => $data->tps,

                    'jumlah_mck'       => $data->jumlah_mck,

                    'pdam'             => $data->pdam,

                    'sumur'            => $data->sumur,

                    'lain_lain'        => $data->lain_lain,

                    'jml_pus'          => $data->jml_pus,

                    'jml_wus'          => $data->jml_wus,

                    'akseptor_kb_l'    => $data->akseptor_kb_l,

                    'akseptor_kb_p'    => $data->akseptor_kb_p,

                    'kk_memiliki_tabungan'
                    => $data->kk_memiliki_tabungan,

                    'kk_memiliki_asuransi'
                    => $data->kk_memiliki_asuransi,

                    'kesehatan'        => $data->kesehatan,

                    'kelestarian_lingkungan_hidup'
                    => $data->kelestarian_lingkungan_hidup,

                    'perencanaan_sehat'
                    => $data->perencanaan_sehat,

                    'catatan'          => $data->catatan,

                    'status'           => $data->status,

                    'created_at'       => $data->created_at,

                    'updated_at'       => $data->updated_at,

                    'role' => [
                        'id'    => $data->role_id,
                        'uuid'  => $data->role_uuid,
                        'name'  => $data->role_name,
                    ],

                    'organization' => [
                        'id'    => $data->organization_id,
                        'uuid'  => $data->organization_uuid,
                        'name'  => $data->organization_name,
                    ],
                ],

                'error' => null

            ], 200);
        } catch (\Exception $e) {

            return response()->json([

                'statusCode' => 500,

                'message' =>
                'Terjadi kesalahan saat memproses permintaan',

                'data' => null,

                'error' => [
                    'message' => $e->getMessage(),
                ]

            ], 500);
        }
    }
}