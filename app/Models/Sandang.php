<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sandang extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pokja3_bidang2';
    protected $table = 'laporan_sandang';
    protected $guarded = [
        'id_pokja3_bidang2'
    ];

    public function user()
    {
        return $this->belongsTo(Pengguna::class, 'id_user');
    }
}
