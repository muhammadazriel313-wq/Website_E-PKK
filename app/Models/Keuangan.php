<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangan';

    protected $fillable = [
        'jenis',        // 'pemasukan' atau 'pengeluaran'
        'tanggal',
        'nominal',
        'keterangan',
        'bukti',        // nama/path file bukti atau nota (opsional)
        'id_user',      // pencatat transaksi
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'double',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
