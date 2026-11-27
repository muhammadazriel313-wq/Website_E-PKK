<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users_mobile';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'phone_number',
        'full_name',
        'password',
        'kode_otp',
        'status',
        'id_subdistrict',
        'id_village',
        'id_role',
        'id_organization'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'kode_otp'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Tambahkan di model Pengguna
    protected $appends = ['name', 'nomer_telepon'];

    public function getNameAttribute()
    {
        return $this->full_name;
    }

    public function getNomerTeleponAttribute()
    {
        return $this->phone_number;
    }

    /**
     * Relasi ke tabel subdistrict (Kecamatan)
     */
    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class, 'id_subdistrict');
    }

    /**
     * Relasi ke tabel village (Desa / Kelurahan)
     */
    public function village()
    {
        return $this->belongsTo(Village::class, 'id_village');
    }
}
