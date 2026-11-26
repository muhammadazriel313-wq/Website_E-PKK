<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerahTerimaJabatan extends Model
{
    use HasFactory;

    protected $table = 'serah_terima_jabatan';

    protected $fillable = [
        'nama_lengkap',    // nama pejabat baru
        'email',           // email pejabat baru
        'nomor_sk_baru',   // nomor SK baru
        'tanggal_efektif', // tanggal mulai berlaku
        'pejabat_lama',    // nama pejabat yang menyerahkan (otomatis)
        'dokumen_sk',      // file scan SK jika ada (opsional)
        'keterangan',      // catatan serah terima (opsional)
        'status',          // status proses ('Berhasil' / 'Aktif')
        'id_user',         // ID user akun yang diserahterimakan
    ];

    protected $casts = [
        'tanggal_efektif' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
