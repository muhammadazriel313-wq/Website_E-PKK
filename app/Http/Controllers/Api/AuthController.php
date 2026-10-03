<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // LOGIN
    public function login(Request $request)
    {
        try {
            $request->validate([
                'phone_number' => 'required',
                'password' => 'required',
                'role' => 'required'
            ]);

            // 🔥 ambil user sesuai role
            $user = DB::table('users_mobile')
                ->where('phone_number', $request->phone_number)
                ->where('id_role', $request->role)
                ->first();

            if (!$user) {
                return response()->json([
                    'statusCode' => 404,
                    'error' => ['message' => 'User dengan role ini tidak ditemukan']
                ], 404);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'statusCode' => 401,
                    'error' => ['message' => 'Password salah']
                ], 401);
            }

            // 🔥 ambil detail lengkap + relasi
            $data = DB::table('users_mobile')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->leftJoin('role_users_mobile', 'users_mobile.id_role', '=', 'role_users_mobile.id')
                ->leftJoin('role_organization', 'users_mobile.id_organization', '=', 'role_organization.id')
                ->where('users_mobile.id', $user->id)
                ->select(
                    'users_mobile.*',

                    'subdistrict.id as subdistrict_id',
                    'subdistrict.uuid as subdistrict_uuid',
                    'subdistrict.name as subdistrict_name',

                    'village.id as village_id',
                    'village.uuid as village_uuid',
                    'village.name as village_name',

                    'role_users_mobile.id as role_id',
                    'role_users_mobile.uuid as role_uuid',
                    'role_users_mobile.name as role_name',

                    'role_organization.id as organization_id',
                    'role_organization.uuid as organization_uuid',
                    'role_organization.name as organization_name'
                )
                ->first();

            //  format response sesuai model Flutter
            return response()->json([
                'statusCode' => 200,
                'message' => 'Success Login',
                'data' => [
                    'id' => $data->id,
                    'uuid' => $data->uuid,
                    'phoneNumber' => $data->phone_number ?? '',
                    'fullName' => $data->full_name ?? '',
                    'status' => $data->status ?? '',
                    'createdAt' => $data->created_at,
                    'updatedAt' => $data->updated_at,

                    'subdistrict' => $data->subdistrict_id ? [
                        'id' => $data->subdistrict_id,
                        'uuid' => $data->subdistrict_uuid,
                        'name' => $data->subdistrict_name
                    ] : null,

                    'village' => $data->village_id ? [
                        'id' => $data->village_id,
                        'uuid' => $data->village_uuid,
                        'name' => $data->village_name
                    ] : null,

                    'role' => $data->role_id ? [
                        'id' => $data->role_id,
                        'uuid' => $data->role_uuid,
                        'name' => $data->role_name
                    ] : null,

                    'organization' => $data->organization_id ? [
                        'id' => $data->organization_id,
                        'uuid' => $data->organization_uuid,
                        'name' => $data->organization_name
                    ] : null,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'error' => ['message' => $e->getMessage()]
            ]);
        }
    }

    // REGISTER
    public function register(Request $request)
    {
        try {
            $request->validate([
                'full_name' => 'required',
                'phone_number' => 'required',
                'password' => 'required',
                'kode_otp' => 'required',
                'id_subdistrict' => 'required',
                'id_village' => 'required',
                'id_role' => 'required',
                'id_organization' => 'required',
            ]);

            //  cek nomor sudah dipakai
            $exists = DB::table('users_mobile')
                ->where('phone_number', $request->phone_number)
                ->where('id_role', $request->id_role)
                ->where('id_organization', $request->id_organization)
                ->exists();

            if ($exists) {
                return response()->json([
                    'statusCode' => 409,
                    'data' => null,
                    'error' => ['message' => 'Phone number already used']
                ], 409);
            }

            //  ambil subdistrict by name
            $subdistrict = DB::table('subdistrict')
                ->where('name', $request->id_subdistrict)
                ->first();

            if (!$subdistrict) {
                return response()->json([
                    'statusCode' => 404,
                    'data' => null,
                    'error' => ['message' => 'Subdistrict tidak ditemukan']
                ], 404);
            }

            //  ambil village by name
            $village = DB::table('village')
                ->where('name', $request->id_village)
                ->first();

            if (!$village) {
                return response()->json([
                    'statusCode' => 404,
                    'data' => null,
                    'error' => ['message' => 'Village tidak ditemukan']
                ], 404);
            }

            //  hash password
            $password = bcrypt($request->password);

            //  UUID Laravel
            $uuid = Str::uuid();

            DB::beginTransaction();

            //  insert user
            $id = DB::table('users_mobile')->insertGetId([
                'uuid' => $uuid,
                'phone_number' => $request->phone_number,
                'full_name' => $request->full_name,
                'password' => $password,
                'kode_otp' => $request->kode_otp,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
                'id_subdistrict' => $subdistrict->id,
                'id_village' => $village->id,
                'id_role' => $request->id_role,
                'id_organization' => $request->id_organization
            ]);

            //  ambil data lengkap (JOIN)
            $data = DB::table('users_mobile')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->leftJoin('role_users_mobile', 'users_mobile.id_role', '=', 'role_users_mobile.id')
                ->leftJoin('role_organization', 'users_mobile.id_organization', '=', 'role_organization.id')
                ->where('users_mobile.id', $id)
                ->select(
                    'users_mobile.*',
                    'subdistrict.id as subdistrict_id',
                    'subdistrict.uuid as subdistrict_uuid',
                    'subdistrict.name as subdistrict_name',
                    'village.id as village_id',
                    'village.uuid as village_uuid',
                    'village.name as village_name',
                    'role_users_mobile.id as role_id',
                    'role_users_mobile.uuid as role_uuid',
                    'role_users_mobile.name as role_name',
                    'role_organization.id as organization_id',
                    'role_organization.uuid as organization_uuid',
                    'role_organization.name as organization_name'
                )
                ->first();

            DB::commit();

            return response()->json([
                'statusCode' => 200,
                'message' => 'Success Create Account',
                'data' => [
                    'id' => $data->id,
                    'uuid' => $data->uuid,
                    'phoneNumber' => $data->phone_number,
                    'fullName' => $data->full_name,
                    'status' => $data->status,
                    'createdAt' => $data->created_at,
                    'updatedAt' => $data->updated_at,
                    'subdistrict' => [
                        'id' => $data->subdistrict_id,
                        'uuid' => $data->subdistrict_uuid,
                        'name' => $data->subdistrict_name
                    ],
                    'village' => [
                        'id' => $data->village_id,
                        'uuid' => $data->village_uuid,
                        'name' => $data->village_name
                    ],
                    'role' => [
                        'id' => $data->role_id,
                        'uuid' => $data->role_uuid,
                        'name' => $data->role_name
                    ],
                    'organization' => [
                        'id' => $data->organization_id,
                        'uuid' => $data->organization_uuid,
                        'name' => $data->organization_name
                    ]
                ],
                'error' => null
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'statusCode' => 500,
                'data' => null,
                'error' => ['message' => 'Server error ' . $e->getMessage()]
            ], 500);
        }
    }


    //GET ROLE
    public function getRole(Request $request)
    {
        //  cek parameter id
        if (!$request->id) {
            return response()->json([
                'statusCode' => 400,
                'message' => "Parameter 'id' is required",
                'data' => [],
                'error' => [
                    'code' => 400,
                    'message' => "Parameter 'id' is required for this request"
                ]
            ], 400);
        }

        //  ambil data
        $roles = DB::table('role_users_mobile')
            ->where('id', $request->id)
            ->get();

        //  tidak ditemukan
        if ($roles->isEmpty()) {
            return response()->json([
                'statusCode' => 404,
                'message' => 'Role users not found!',
                'data' => [],
                'error' => null
            ], 404);
        }

        //  format response
        $data = $roles->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name
            ];
        });

        return response()->json([
            'statusCode' => 200,
            'message' => 'Successfully fetched role users!',
            'data' => $data,
            'error' => null
        ], 200);
    }

    // SELECTED ROLE
    public function selectRole(Request $request)
    {
        try {
            $request->validate([
                'id_user' => 'required'
            ]);

            $data = DB::table('users_mobile')
                ->leftJoin('subdistrict', 'users_mobile.id_subdistrict', '=', 'subdistrict.id')
                ->leftJoin('village', 'users_mobile.id_village', '=', 'village.id')
                ->leftJoin('role_users_mobile', 'users_mobile.id_role', '=', 'role_users_mobile.id')
                ->leftJoin('role_organization', 'users_mobile.id_organization', '=', 'role_organization.id')
                ->where('users_mobile.id', $request->id_user)
                ->select(
                    'users_mobile.*',
                    'subdistrict.name as subdistrict_name',
                    'village.name as village_name',
                    'role_users_mobile.name as role_name',
                    'role_organization.name as organization_name'
                )
                ->first();

            return response()->json([
                'statusCode' => 200,
                'message' => 'Role selected',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'error' => $e->getMessage()
            ]);
        }
    }

    // GET ORGANISASI
    public function getOrganization(Request $request)
    {
        //  cek parameter id (uuid)
        if (!$request->id) {
            return response()->json([
                'statusCode' => 400,
                'message' => "Parameter 'id' is required",
                'data' => [],
                'error' => [
                    'code' => 400,
                    'message' => "Parameter 'id' is required for this request"
                ]
            ], 400);
        }

        //  ambil data berdasarkan UUID
        $org = DB::table('role_organization')
            ->where('uuid', $request->id)
            ->get();

        //  tidak ditemukan
        if ($org->isEmpty()) {
            return response()->json([
                'statusCode' => 404,
                'message' => 'Role organization not found!',
                'data' => [],
                'error' => null
            ], 404);
        }

        //  format data
        $data = $org->map(function ($item) {
            return [
                'id' => $item->uuid,
                'name' => $item->name
            ];
        });

        return response()->json([
            'statusCode' => 200,
            'message' => 'Successfully fetched role organization!',
            'data' => $data,
            'error' => null
        ], 200);
    }


    // SEND OTP
    public function sendOtp(Request $request)
    {
        try {
            //  validasi
            $request->validate([
                'phone' => 'required',
                'otp' => 'required'
            ]);

            // BYPASS OTP - HAPUS SETELAH PRESENTASI
            if (env('OTP_BYPASS', false)) {
                return response()->json([
                    'success' => true,
                    'bypass' => true,
                    'message' => 'OTP bypassed for presentation',
                    'response' => ['status' => true, 'target' => $request->phone]
                ]);
            }

            $phone = $request->phone;
            $otp = $request->otp;

            //  ubah 08 → 628
            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }

            //  token (sementara hardcode dulu)
            $token = "otuLSYYpavqCBPE6LpXA";

            //  kirim request ke Fonnte
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => $token
            ])->post('https://api.fonnte.com/send', [
                'target' => $phone,
                'message' => "Kode verifikasi E-PKK Anda adalah: *$otp*"
            ]);

            return response()->json([
                'success' => true,
                'response' => $response->json()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // CHECK USER
    public function checkUser(Request $request)
    {
        try {
            //  validasi
            if (!$request->phone_number) {
                return response()->json([
                    'statusCode' => 400,
                    'message' => 'Phone number is required.',
                    'data' => null,
                    'error' => ['message' => 'Please provide a phone number.']
                ], 400);
            }

            //  ambil user
            $user = DB::table('users_mobile')
                ->select('uuid', 'phone_number', 'full_name')
                ->where('phone_number', $request->phone_number)
                ->first();

            //  tidak ditemukan
            if (!$user) {
                return response()->json([
                    'statusCode' => 404,
                    'message' => 'Phone number not found.',
                    'data' => null,
                    'error' => ['message' => 'No user found with this phone number.']
                ], 404);
            }

            //  sukses
            return response()->json([
                'statusCode' => 200,
                'message' => 'Phone number found.',
                'data' => [
                    'id' => $user->uuid,
                    'phone_number' => $user->phone_number,
                    'full_name' => $user->full_name,
                ],
                'error' => null
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Internal server error.',
                'data' => null,
                'error' => ['message' => 'Error while fetching data.']
            ], 500);
        }
    }

    // GANTI PASSWORD
    public function updatePassword(Request $request)
    {
        try {
            //  validasi
            if (!$request->phone || !$request->new_password) {
                return response()->json([
                    'statusCode' => 400,
                    'message' => 'Phone number or new password cannot be empty.',
                    'data' => null,
                    'error' => ['message' => 'Invalid input.']
                ], 400);
            }

            //  ambil user
            $user = DB::table('users_mobile')
                ->where('phone_number', $request->phone)
                ->first();

            //  user tidak ditemukan
            if (!$user) {
                return response()->json([
                    'statusCode' => 404,
                    'message' => 'Phone number not found.',
                    'data' => null,
                    'error' => ['message' => 'User with this phone number was not found.']
                ], 404);
            }

            //  password sama
            if (Hash::check($request->new_password, $user->password)) {
                return response()->json([
                    'statusCode' => 400,
                    'message' => 'New password cannot be the same as the old password.',
                    'data' => null,
                    'error' => ['message' => 'No changes made.']
                ], 400);
            }

            //  hash password baru
            $hashedPassword = bcrypt($request->new_password);

            //  update password
            $updated = DB::table('users_mobile')
                ->where('phone_number', $request->phone)
                ->update([
                    'password' => $hashedPassword,
                    'updated_at' => now()
                ]);

            if ($updated) {
                return response()->json([
                    'statusCode' => 200,
                    'message' => 'Password updated successfully.',
                    'data' => [],
                    'error' => null
                ], 200);
            }

            return response()->json([
                'statusCode' => 404,
                'message' => 'No changes made or phone number not found.',
                'data' => null,
                'error' => ['message' => 'Password tidak berubah.']
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message' => 'Server error.',
                'data' => null,
                'error' => ['message' => $e->getMessage()]
            ], 500);
        }
    }
}
