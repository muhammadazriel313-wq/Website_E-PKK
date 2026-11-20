<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * [PERUBAHAN] Fitur baru: Peringkat Anggota PKK (desa & kecamatan).
 *
 * Aturan poin:
 * - 1 laporan = 1 poin, hanya laporan berstatus Disetujui2 (ACC akhir admin kabupaten).
 * - Galeri kegiatan (tabel galerys) ikut dihitung, 1 galeri = 1 poin, hanya yang berstatus upload2.
 * - Peringkat desa  : laporan dari akun mobile id_role = 1, dikelompokkan per desa.
 * - Peringkat kecamatan: laporan dari akun mobile id_role = 2, dikelompokkan per kecamatan.
 *   (poin desa dan kecamatan terpisah, tidak digabung)
 * - Poin sama: yang waktu upload laporan terakhir (di periode itu) lebih awal ada di atas.
 */
class PeringkatController extends Controller
{
    private const STATUS_FINAL = 'disetujui2';

    // Tabel yang status persetujuan akhirnya bukan 'disetujui2'.
    private const STATUS_KHUSUS = [
        'galerys' => 'upload2',
    ];

    // Semua tabel yang jadi sumber poin (laporan mobile + galeri kegiatan).
    private const TABEL_LAPORAN = [
        'laporan_kader_pokja1',
        'laporan_gotong_royong',
        'laporan_penghayatan_n_pengamalan',
        'laporan_pendidikan_n_keterampilan',
        'laporan_pengembangan_kehidupan',
        'laporan_kader_pokja3',
        'laporan_pangan',
        'laporan_sandang',
        'laporan_perumahan',
        'laporan_kader_pokja4',
        'laporan_bidang_kesehatan',
        'laporan_kelestarian_lingkungan_hidup',
        'laporan_perencanaan_sehat',
        'laporan_umum',
        'rekap_desa_bulanan',
        'rekap_desa_tahunan',
        'posyandu',
        'kegiatan_pokja4',
        'galerys',
    ];

    // GET /api/ranking/desa?periode=bulan_ini&limit=3&id=<id user mobile>
    public function desa(Request $request)
    {
        return $this->buat($request, 'desa');
    }

    // GET /api/ranking/kecamatan?periode=tahun_ini
    public function kecamatan(Request $request)
    {
        return $this->buat($request, 'kecamatan');
    }

    private function buat(Request $request, string $jenis)
    {
        try {
            $periode = $this->tentukanPeriode($request);
            if (isset($periode['error'])) {
                return $this->gagal(400, $periode['error']);
            }

            $role   = $jenis === 'desa' ? 1 : 2;
            $kolom  = $jenis === 'desa' ? 'id_village' : 'id_subdistrict';
            $mulai  = $periode['mulai']->format('Y-m-d H:i:s');
            $akhir  = $periode['akhir']->format('Y-m-d H:i:s');

            // Poin per desa / kecamatan
            $agg = DB::query()
                ->fromSub($this->laporanDisetujui($mulai, $akhir), 'r')
                ->join('users_mobile as u', 'u.id', '=', 'r.id_user')
                ->where('u.id_role', $role)
                ->groupBy("u.$kolom")
                ->selectRaw("u.$kolom as kunci, COUNT(*) as poin, MAX(r.created_at) as terakhir");

            if ($jenis === 'desa') {
                $baris = DB::table('village as v')
                    ->join('subdistrict as s', 's.id', '=', 'v.id_subdistrict')
                    ->leftJoinSub($agg, 'a', 'a.kunci', '=', 'v.id')
                    ->selectRaw('v.id as id, v.name as nama, s.name as kecamatan, COALESCE(a.poin, 0) as poin, a.terakhir as terakhir');
                $namaUrut = 'v.name';
            } else {
                $baris = DB::table('subdistrict as s')
                    ->leftJoinSub($agg, 'a', 'a.kunci', '=', 's.id')
                    ->selectRaw('s.id as id, s.name as nama, (SELECT COUNT(*) FROM village WHERE village.id_subdistrict = s.id) as jumlah_desa, COALESCE(a.poin, 0) as poin, a.terakhir as terakhir');
                $namaUrut = 's.name';
            }

            $baris = $baris
                ->orderByDesc('poin')
                ->orderByRaw('a.terakhir IS NULL')
                ->orderBy('a.terakhir')
                ->orderBy($namaUrut)
                ->get();

            $foto = $this->ambilFoto($request, $role, $kolom, $mulai, $akhir);
            $meKunci = $this->kunciAkunSaya($request, $role, $kolom);

            $items = [];
            foreach ($baris as $i => $b) {
                $item = [
                    'rank' => $i + 1,
                    'id'   => (int) $b->id,
                    'nama' => $b->nama,
                ];
                if ($jenis === 'desa') {
                    $item['kecamatan'] = $b->kecamatan;
                } else {
                    $item['jumlah_desa'] = (int) $b->jumlah_desa;
                }
                $item['poin']  = (int) $b->poin;
                $item['foto']  = $foto[$b->id] ?? null;
                $item['is_me'] = $meKunci !== null && (int) $b->id === $meKunci;
                $items[] = $item;
            }

            $total = count($items);
            $limit = (int) $request->query('limit', 0);
            if ($limit > 0) {
                $items = array_slice($items, 0, min($limit, 500));
            }

            return response()->json([
                'statusCode' => 200,
                'message'    => 'Berhasil mengambil peringkat ' . $jenis,
                'data'       => [
                    'jenis'   => $jenis,
                    'periode' => [
                        'kode'  => $periode['kode'],
                        'label' => $periode['label'],
                        'mulai' => $periode['mulai']->toDateString(),
                        'akhir' => $periode['akhir']->toDateString(),
                    ],
                    'total' => $total,
                    'items' => $items,
                ],
                'error' => null,
            ], 200);
        } catch (\Throwable $e) {
            return $this->gagal(500, 'Terjadi kesalahan server', $e->getMessage());
        }
    }

    // Gabungan (UNION ALL) semua laporan dan galeri yang sudah ACC akhir pada rentang tanggal.
    private function laporanDisetujui(string $mulai, string $akhir)
    {
        $union = null;
        foreach (self::TABEL_LAPORAN as $tabel) {
            // Lewati tabel yang belum punya kolom yang dibutuhkan
            if (!Schema::hasColumns($tabel, ['id_user', 'status', 'created_at'])) {
                continue;
            }
            $statusAkhir = self::STATUS_KHUSUS[$tabel] ?? self::STATUS_FINAL;
            $q = DB::table($tabel)
                ->select('id_user', 'created_at')
                ->whereRaw('LOWER(status) = ?', [$statusAkhir])
                ->whereBetween('created_at', [$mulai, $akhir]);
            $union = $union ? $union->unionAll($q) : $q;
        }
        return $union;
    }

    // Foto profil per desa/kecamatan: akun dengan laporan terbanyak di periode itu,
    // kalau belum ada laporan, pakai akun pertama yang punya foto.
    private function ambilFoto(Request $request, int $role, string $kolom, string $mulai, string $akhir): array
    {
        $host = $request->getSchemeAndHttpHost() . $request->getBasePath();
        $hasil = [];

        $perAkun = DB::query()
            ->fromSub($this->laporanDisetujui($mulai, $akhir), 'r')
            ->join('users_mobile as u', 'u.id', '=', 'r.id_user')
            ->where('u.id_role', $role)
            ->whereNotNull('u.foto')->where('u.foto', '!=', '')
            ->groupBy("u.$kolom", 'u.id', 'u.foto')
            ->selectRaw("u.$kolom as kunci, u.foto as foto, COUNT(*) as n")
            ->orderByDesc('n')
            ->get();
        foreach ($perAkun as $r) {
            if (!isset($hasil[$r->kunci])) {
                $hasil[$r->kunci] = $host . '/api/profile/photo/' . $r->foto;
            }
        }

        $cadangan = DB::table('users_mobile')
            ->where('id_role', $role)
            ->whereNotNull('foto')->where('foto', '!=', '')
            ->orderBy('id')
            ->get([$kolom . ' as kunci', 'foto']);
        foreach ($cadangan as $r) {
            if (!isset($hasil[$r->kunci])) {
                $hasil[$r->kunci] = $host . '/api/profile/photo/' . $r->foto;
            }
        }

        return $hasil;
    }

    // Untuk penanda "Anda": desa/kecamatan milik akun yang login (kalau jenis akunnya cocok).
    private function kunciAkunSaya(Request $request, int $role, string $kolom): ?int
    {
        $idUser = $request->query('id');
        if (!$idUser) {
            return null;
        }
        $u = DB::table('users_mobile')->where('id', (int) $idUser)->first();
        if (!$u || (int) $u->id_role !== $role) {
            return null;
        }
        return (int) $u->{$kolom};
    }

    private function tentukanPeriode(Request $request): array
    {
        $kode = $request->query('periode', 'bulan_ini');
        $now  = Carbon::now('Asia/Jakarta');

        switch ($kode) {
            case 'bulan_ini':
                return $this->rentang($kode, 'Bulan Ini', $now->copy()->startOfMonth(), $now->copy()->endOfMonth());
            case 'bulan_lalu':
                $b = $now->copy()->subMonthNoOverflow();
                return $this->rentang($kode, 'Bulan Lalu', $b->copy()->startOfMonth(), $b->copy()->endOfMonth());
            case 'tahun_ini':
                return $this->rentang($kode, 'Tahun Ini', $now->copy()->startOfYear(), $now->copy()->endOfYear());
            case 'tahun_lalu':
                $t = $now->copy()->subYear();
                return $this->rentang($kode, 'Tahun Lalu', $t->copy()->startOfYear(), $t->copy()->endOfYear());
            case 'custom':
                try {
                    $mulai = Carbon::createFromFormat('Y-m-d', (string) $request->query('mulai'), 'Asia/Jakarta')->startOfDay();
                    $akhir = Carbon::createFromFormat('Y-m-d', (string) $request->query('akhir'), 'Asia/Jakarta')->endOfDay();
                } catch (\Throwable $e) {
                    return ['error' => 'Parameter mulai dan akhir wajib berformat YYYY-MM-DD'];
                }
                if ($akhir->lt($mulai)) {
                    return ['error' => 'Tanggal akhir tidak boleh sebelum tanggal mulai'];
                }
                return $this->rentang($kode, 'Periode Pilihan', $mulai, $akhir);
            default:
                return ['error' => 'periode harus salah satu dari: bulan_ini, bulan_lalu, tahun_ini, tahun_lalu, custom'];
        }
    }

    private function rentang(string $kode, string $label, Carbon $mulai, Carbon $akhir): array
    {
        return ['kode' => $kode, 'label' => $label, 'mulai' => $mulai, 'akhir' => $akhir];
    }

    private function gagal(int $kode, string $pesan, ?string $detail = null)
    {
        return response()->json([
            'statusCode' => $kode,
            'message'    => $pesan,
            'data'       => null,
            'error'      => ['message' => $detail ?? $pesan, 'code' => $kode],
        ], $kode);
    }
}
