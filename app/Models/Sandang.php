<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sandang extends Model
{
    use HasFactory;

    protected $table = 'laporan_sandang';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected $casts = [
        'kader_sandang'    => 'integer',
        'industri_pangan'  => 'integer',
        'industri_sandang' => 'integer',
        'jasa'             => 'integer',
        'approved_at'      => 'datetime',
        'created_at'       => 'datetime',
        'updated_at'       => 'datetime',
    ];

    /**
     * Kompatibilitas legacy: alias id_pokja3_bidang2 ke id
     */
    public function getIdPokja3Bidang2Attribute()
    {
        return $this->attributes['id'] ?? null;
    }

    public function setIdPokja3Bidang2Attribute($value)
    {
        $this->attributes['id'] = $value;
    }

    /**
     * Kompatibilitas legacy: alias 'pangan' ke 'industri_pangan'
     */
    public function getPanganAttribute()
    {
        return $this->attributes['industri_pangan'] ?? $this->attributes['pangan'] ?? 0;
    }

    public function setPanganAttribute($value)
    {
        $this->attributes['industri_pangan'] = $value;
    }

    /**
     * Kompatibilitas legacy: alias 'sandang' ke 'industri_sandang'
     */
    public function getSandangAttribute()
    {
        return $this->attributes['industri_sandang'] ?? 0;
    }

    public function setSandangAttribute($value)
    {
        $this->attributes['industri_sandang'] = $value;
    }

    public function user()
    {
        return $this->belongsTo(Pengguna::class, 'id_user');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Subdistrict::class, 'kecamatan_id');
    }

    public function desa()
    {
        return $this->belongsTo(Village::class, 'desa_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
