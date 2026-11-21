<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pangan extends Model
{
    use HasFactory;

    protected $table = 'laporan_pangan';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected $casts = [
        'kader_pangan'    => 'integer',
        'beras'           => 'integer',
        'non_beras'       => 'integer',
        'peternakan'      => 'integer',
        'perikanan'       => 'integer',
        'warung_hidup'    => 'integer',
        'lumbung_hidup'   => 'integer',
        'toga'            => 'integer',
        'tanaman_keras'   => 'integer',
        'tanaman_lainnya' => 'integer',
        'industri_pangan' => 'integer',
        'approved_at'     => 'datetime',
        'created_at'      => 'datetime',
        'updated_at'      => 'datetime',
    ];

    /**
     * Kompatibilitas legacy: alias id_pokja3_bidang1 ke id
     */
    public function getIdPokja3Bidang1Attribute()
    {
        return $this->attributes['id'] ?? null;
    }

    public function setIdPokja3Bidang1Attribute($value)
    {
        $this->attributes['id'] = $value;
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
