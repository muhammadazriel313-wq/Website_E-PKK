<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanganSandang extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pangan_sandang';
    protected $table = 'laporan_pangan_sandang';
    protected $guarded = [
        'id_pangan_sandang'
    ];

    public function user()
    {
        return $this->belongsTo(Pengguna::class, 'id_user');
    }
}
