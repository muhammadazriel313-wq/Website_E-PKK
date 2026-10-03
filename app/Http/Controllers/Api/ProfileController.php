<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
}
