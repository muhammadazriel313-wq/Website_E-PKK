<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
// [PERUBAHAN 08-10-2026] Menambahkan File, Str, Validator
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        try {
            //  ambil dari query parameter (?id=46)
            $userId = $request->query('id');

            // ✅ validasi
            if (!$userId) {
                return response()->json([
                    'statusCode' => 400,
                    'message' => 'User ID is required',
                    'data' => null,
                    'error' => [
                        'message' => 'User ID is required',
                        'code' => 400
                    ]
                ], 400);
            }

            //  query database
            $data = DB::table('users_mobile')
                ->select(
                    'id',
                    'uuid',
                    'phone_number',
                    'full_name',
                    'foto',
                    'status',
                    DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') as created_at"),
                    DB::raw("DATE_FORMAT(updated_at, '%Y-%m-%d %H:%i:%s') as updated_at"),
                    'id_subdistrict',
                    'id_village',
                    'id_role',
                    'id_organization'
                )
                ->where('id', (int)$userId) // casting biar aman
                ->first();

            // ❗ FIX: kalau TIDAK ADA data → 404
            if (!$data) {
                return response()->json([
                    'statusCode' => 404,
                    'message' => 'Profile not found',
                    'data' => null,
                    'error' => [
                        'message' => 'Profile not found',
                        'code' => 404
                    ]
                ], 404);
            }

            // [PERUBAHAN 08-10-2026] Format URL foto jika ada
            if ($data && !empty($data->foto)) {
                // [PERUBAHAN 08-10-2026] Menggunakan endpoint /api/profile/photo agar memiliki header CORS untuk Chrome CanvasKit dan Emulator
                // $data->foto = $request->getSchemeAndHttpHost() . '/storage/profile/' . $data->foto;
                $data->foto = $request->getSchemeAndHttpHost() . '/api/profile/photo/' . $data->foto;
            } else if ($data) {
                $data->foto = null;
            }

            //  kalau ADA data → sukses
            return response()->json([
                'statusCode' => 200,
                'message' => 'Profile data retrieved successfully',
                'data' => $data,
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Failed to get profile',
                'data' => null,
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => 500
                ]
            ], 500);
        }
    }

    // [PERUBAHAN 08-10-2026] UNGGAH / PERBARUI FOTO PROFIL
    
    // [PERUBAHAN 08-10-2026] Mengambil file foto profil dengan header CORS agar dapat dimuat di browser Chrome maupun emulator
    public function getPhoto($filename)
    {
        $filename = basename($filename);
        $path = public_path('storage/profile/' . $filename);

        if (!File::exists($path)) {
            return response()->json([
                'statusCode' => 404,
                'message' => 'Foto tidak ditemukan',
                'data' => null,
                'error' => [
                    'message' => 'Foto tidak ditemukan',
                    'code' => 404
                ]
            ], 404);
        }

        $mimeType = File::mimeType($path) ?: 'image/jpeg';
        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, OPTIONS',
            'Cache-Control' => 'no-cache, private',
        ]);
    }

    
    // [PERUBAHAN 08-10-2026] Menghapus foto profil pengguna
    public function deletePhoto(Request $request)
    {
        try {
            $userId = (int)($request->input('id_user') ?? $request->input('id') ?? $request->query('id_user') ?? $request->query('id'));

            if (!$userId) {
                return response()->json([
                    'statusCode' => 400,
                    'message' => 'ID pengguna wajib diisi',
                    'data' => null,
                    'error' => [
                        'message' => 'ID pengguna wajib diisi',
                        'code' => 400
                    ]
                ], 400);
            }

            $user = DB::table('users_mobile')->where('id', $userId)->first();
            if (!$user) {
                return response()->json([
                    'statusCode' => 404,
                    'message' => 'Akun pengguna tidak ditemukan',
                    'data' => null,
                    'error' => [
                        'message' => 'Akun pengguna tidak ditemukan',
                        'code' => 404
                    ]
                ], 404);
            }

            // Hapus berkas foto fisik jika ada
            if (!empty($user->foto)) {
                $destinationPath = public_path('storage/profile');
                $filePath = $destinationPath . DIRECTORY_SEPARATOR . $user->foto;
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }

            // Set kolom foto di basis data menjadi NULL
            DB::table('users_mobile')
                ->where('id', $userId)
                ->update([
                    'foto' => null,
                    'updated_at' => now(),
                ]);

            return response()->json([
                'statusCode' => 200,
                'message' => 'Foto profil berhasil dihapus',
                'data' => [
                    'id' => $user->id,
                    'uuid' => $user->uuid,
                    'full_name' => $user->full_name,
                    'foto' => null,
                ],
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Gagal menghapus foto profil: ' . $e->getMessage(),
                'data' => null,
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => 500
                ]
            ], 500);
        }
    }

    public function updatePhoto(Request $request)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'id_user' => 'required',
                'foto' => 'required|file|image|mimes:jpeg,jpg,png,webp|max:2048',
            ], [
                'id_user.required' => 'ID pengguna wajib diisi',
                'foto.required' => 'Berkas foto wajib diunggah',
                'foto.image' => 'Berkas harus berupa gambar',
                'foto.mimes' => 'Format foto harus berupa jpeg, jpg, png, atau webp',
                'foto.max' => 'Ukuran foto maksimal adalah 2 MB',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'statusCode' => 422,
                    'message' => $validator->errors()->first(),
                    'data' => null,
                    'error' => [
                        'message' => $validator->errors()->first(),
                        'code' => 422
                    ]
                ], 422);
            }

            $userId = (int)$request->input('id_user');

            // Periksa keberadaan user di users_mobile
            $user = DB::table('users_mobile')->where('id', $userId)->first();
            if (!$user) {
                return response()->json([
                    'statusCode' => 404,
                    'message' => 'Akun pengguna tidak ditemukan',
                    'data' => null,
                    'error' => [
                        'message' => 'Akun pengguna tidak ditemukan',
                        'code' => 404
                    ]
                ], 404);
            }

            // Folder penyimpanan
            $destinationPath = public_path('storage/profile');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            // Hapus berkas foto lama pengguna jika ada
            if (!empty($user->foto)) {
                $oldFilePath = $destinationPath . DIRECTORY_SEPARATOR . $user->foto;
                if (File::exists($oldFilePath)) {
                    File::delete($oldFilePath);
                }
            }

            // Simpan foto baru dengan nama acak aman
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $fileName = 'profile_' . $user->uuid . '_' . time() . '_' . Str::random(6) . '.' . $extension;

            $file->move($destinationPath, $fileName);

            // Perbarui kolom foto di basis data
            DB::table('users_mobile')
                ->where('id', $userId)
                ->update([
                    'foto' => $fileName,
                    'updated_at' => now(),
                ]);

            // Bangun URL foto penuh memakai host request yang sedang aktif
            // [PERUBAHAN 08-10-2026] Menggunakan endpoint /api/profile/photo agar memiliki header CORS untuk Chrome CanvasKit dan Emulator
            // $photoUrl = $request->getSchemeAndHttpHost() . '/storage/profile/' . $fileName;
            $photoUrl = $request->getSchemeAndHttpHost() . '/api/profile/photo/' . $fileName;

            return response()->json([
                'statusCode' => 200,
                'message' => 'Foto profil berhasil diperbarui',
                'data' => [
                    'id' => $user->id,
                    'uuid' => $user->uuid,
                    'full_name' => $user->full_name,
                    'foto' => $photoUrl,
                ],
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Gagal memperbarui foto profil: ' . $e->getMessage(),
                'data' => null,
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => 500
                ]
            ], 500);
        }
    }

    // UPDATE PROFILE
    public function updateProfile(Request $request)
    {
        try {
            $userId = $request->id;

            if (!$userId) {
                return response()->json([
                    'statusCode' => 400,
                    'message' => 'User ID is required',
                    'data' => null,
                    'error' => [
                        'message' => 'User ID is required',
                        'code' => 400
                    ]
                ], 400);
            }

            $updateData = [];
            $updateType = '';

            // =========================
            // UPDATE PROFILE
            // =========================
            if ($request->filled('full_name') || $request->filled('phone_number')) {

                $updateType = 'profile';

                if ($request->filled('full_name')) {
                    $updateData['full_name'] = $request->full_name;
                }

                if ($request->filled('phone_number')) {
                    $updateData['phone_number'] = $request->phone_number;
                }
            }

            // =========================
            // UPDATE PASSWORD
            // =========================
            elseif ($request->filled('current_password') && $request->filled('new_password')) {

                $updateType = 'password';

                $user = DB::table('users_mobile')->where('id', $userId)->first();

                if (!$user || !Hash::check($request->current_password, $user->password)) {
                    return response()->json([
                        'statusCode' => 401,
                        'message' => 'Password saat ini salah',
                        'data' => null,
                        'error' => [
                            'message' => 'Password saat ini salah',
                            'code' => 401
                        ]
                    ], 401);
                }

                $updateData['password'] = Hash::make($request->new_password);
            } else {
                return response()->json([
                    'statusCode' => 400,
                    'message' => 'No valid update data provided',
                    'data' => null,
                    'error' => [
                        'message' => 'No valid update data provided',
                        'code' => 400
                    ]
                ], 400);
            }

            // Tambah updated_at
            $updateData['updated_at'] = now();

            // Update
            DB::table('users_mobile')
                ->where('id', $userId)
                ->update($updateData);

            // Ambil data terbaru
            $updatedUser = DB::table('users_mobile')
                ->select(
                    'id',
                    'uuid',
                    'phone_number',
                    'full_name',
                    'foto',
                    'status',
                    DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') as created_at"),
                    DB::raw("DATE_FORMAT(updated_at, '%Y-%m-%d %H:%i:%s') as updated_at")
                )
                ->where('id', $userId)
                ->first();

            return response()->json([
                'statusCode' => 200,
                'message' => ucfirst($updateType) . ' updated successfully',
                'data' => [$updatedUser],
                'error' => null
            ]);
        } catch (\Exception $e) {
            $code = $e->getCode() ?: 400;

            return response()->json([
                'statusCode' => $code,
                'message' => 'Update failed',
                'data' => null,
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => $code
                ]
            ], $code);
        }
    }

    // HAPUS AKUN (ROLE DESA & KECAMATAN)
    public function deleteAccount(Request $request)
    {
        try {
            $userId = $request->input('id') ?? $request->query('id');

            if (!$userId) {
                return response()->json([
                    'statusCode' => 400,
                    'message' => 'User ID is required',
                    'data' => null,
                    'error' => [
                        'message' => 'User ID is required',
                        'code' => 400
                    ]
                ], 400);
            }

            // Cari user di users_mobile
            $user = DB::table('users_mobile')->where('id', $userId)->first();

            if (!$user) {
                return response()->json([
                    'statusCode' => 404,
                    'message' => 'Akun pengguna tidak ditemukan',
                    'data' => null,
                    'error' => [
                        'message' => 'Akun pengguna tidak ditemukan',
                        'code' => 404
                    ]
                ], 404);
            }

            // Validasi role: hanya Desa (1) dan Kecamatan (2)
            if (!in_array((string)$user->id_role, ['1', '2'])) {
                return response()->json([
                    'statusCode' => 403,
                    'message' => 'Hanya akun role Desa dan Kecamatan yang dapat dihapus',
                    'data' => null,
                    'error' => [
                        'message' => 'Akses ditolak: role tidak diizinkan untuk menghapus akun',
                        'code' => 403
                    ]
                ], 403);
            }

            // Hapus data pengguna dalam transaksi DB
            DB::transaction(function () use ($userId) {
                // Hapus galeri
                DB::table('galerys')->where('id_user', $userId)->delete();

                // Hapus laporan pangan sandang jika ada
                DB::table('laporan_pangan_sandang')->where('id_user', $userId)->delete();

                // Hapus rekap desa jika ada
                DB::table('rekap_desa_bulanan')->where('id_user', $userId)->delete();
                DB::table('rekap_desa_tahunan')->where('id_user', $userId)->delete();

                // Hapus laporan-laporan pokok
                $reportTables = [
                    'kegiatan_pokja4',
                    'laporan_bidang_kesehatan',
                    'laporan_gotong_royong',
                    'laporan_kader_pokja1',
                    'laporan_kader_pokja3',
                    'laporan_kader_pokja4',
                    'laporan_kelestarian_lingkungan_hidup',
                    'laporan_pangan',
                    'laporan_pendidikan_n_keterampilan',
                    'laporan_pengembangan_kehidupan',
                    'laporan_penghayatan_n_pengamalan',
                    'laporan_perencanaan_sehat',
                    'laporan_perumahan',
                    'laporan_sandang',
                    'laporan_umum',
                    'posyandu',
                ];

                foreach ($reportTables as $table) {
                    DB::table($table)->where('id_user', $userId)->delete();
                }

                // Terakhir hapus user dari users_mobile
                DB::table('users_mobile')->where('id', $userId)->delete();
            });

            return response()->json([
                'statusCode' => 200,
                'message' => 'Akun berhasil dihapus dari sistem dan basis data',
                'data' => null,
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Gagal menghapus akun: ' . $e->getMessage(),
                'data' => null,
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => 500
                ]
            ], 500);
        }
    }
}