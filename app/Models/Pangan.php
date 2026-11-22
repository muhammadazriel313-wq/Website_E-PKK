<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pangan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pokja3_bidang1';
    protected $table = 'laporan_pangan';
    protected $guarded = [
        'id_pokja3_bidang1'
    ];
}
