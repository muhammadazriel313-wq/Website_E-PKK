<?php

namespace App\Http\Controllers\backend;

use App\Models\Pengguna;
use App\Models\Subdistrict;
use App\Models\Village;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    /**
     * Menampilkan daftar pengguna tingkat Desa dan Kecamatan untuk Web Kabupaten.
     */
    public function index(Request $request)
    {
        // Menentukan tab yang aktif (default: 'kecamatan')
        $tab = $request->get('tab', 'kecamatan');

        // Hitung total pengguna (semua, kecamatan, dan desa)
        $totalKecamatan = Pengguna::where('id_role', 2)->count();
        $totalDesa = Pengguna::where('id_role', 1)->count();
        $totalSemua = Pengguna::count();

        // Daftar Kecamatan untuk opsi dropdown filter
        $subdistricts = Subdistrict::orderBy('name', 'asc')->get();

        // 1. Query Pengguna Kecamatan (id_role = 2)
        $queryKecamatan = Pengguna::with(['subdistrict', 'village'])
            ->where('id_role', 2);

        // 2. Query Pengguna Desa (id_role = 1)
        $queryDesa = Pengguna::with(['subdistrict', 'village'])
            ->where('id_role', 1);

        // Filter Pencarian (Nama Lengkap / Nomor HP / Wilayah)
        if ($request->filled('search')) {
            $search = trim($request->search);
            // Bersihkan awalan kata seperti "desa", "kelurahan", "kecamatan", "kec." jika user mengetik misalnya "desa baron"
            $cleanSearch = trim(preg_replace('/^(desa|kelurahan|kecamatan|kec\.)\s+/i', '', $search));
            if (empty($cleanSearch)) {
                $cleanSearch = $search;
            }

            // 1. Pencarian untuk Pengguna Kecamatan:
            // Cocokkan nama pengguna, nomor telepon, atau nama kecamatan
            $queryKecamatan->where(function ($q) use ($search, $cleanSearch) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%")
                    ->orWhereHas('subdistrict', function ($sq) use ($search, $cleanSearch) {
                        $sq->where('name', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$cleanSearch}%");
                    });
            });

            // 2. Pencarian untuk Pengguna Desa:
            // HANYA cocokkan nama pengguna, nomor telepon, atau nama desa SAJA
            // (Nama kecamatan TIDAK diikutsertakan agar desa lain di kecamatan yang sama tidak ikut muncul)
            $queryDesa->where(function ($q) use ($search, $cleanSearch) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%")
                    ->orWhereHas('village', function ($vq) use ($search, $cleanSearch) {
                        $vq->where('name', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$cleanSearch}%");
                    });
            });
        }

        // Filter berdasarkan Kecamatan
        if ($request->filled('id_subdistrict')) {
            $queryKecamatan->where('id_subdistrict', $request->id_subdistrict);
            $queryDesa->where('id_subdistrict', $request->id_subdistrict);
        }

        // Filter berdasarkan Status (misal: 'Active', 'Inactive', 'Proses')
        if ($request->filled('status')) {
            $queryKecamatan->where('status', $request->status);
            $queryDesa->where('status', $request->status);
        }

        // Ambil data dengan pagination terpisah per tab
        $penggunaKecamatan = $queryKecamatan->latest('created_at')
            ->paginate(10, ['*'], 'page_kecamatan')
            ->appends(array_merge($request->query(), ['tab' => 'kecamatan']));

        $penggunaDesa = $queryDesa->latest('created_at')
            ->paginate(10, ['*'], 'page_desa')
            ->appends(array_merge($request->query(), ['tab' => 'desa']));

        return view('backend.pengguna', compact(
            'tab',
            'totalKecamatan',
            'totalDesa',
            'totalSemua',
            'subdistricts',
            'penggunaKecamatan',
            'penggunaDesa'
        ));
    }

    /**
     * Menampilkan detail informasi pengguna.
     */
    public function show(string $id)
    {
        $pengguna = Pengguna::with(['subdistrict', 'village'])->findOrFail($id);
        return view('backend.detail_pengguna', compact('pengguna'));
    }

    /**
     * Menampilkan form edit data pengguna.
     */
    public function edit(string $id)
    {
        $pengguna = Pengguna::with(['subdistrict', 'village'])->findOrFail($id);
        $subdistricts = Subdistrict::orderBy('name', 'asc')->get();
        $villages = $pengguna->id_subdistrict
            ? Village::where('id_subdistrict', $pengguna->id_subdistrict)->orderBy('name', 'asc')->get()
            : collect();

        return view('backend.edit_pengguna', compact('pengguna', 'subdistricts', 'villages'));
    }

    /**
     * Memperbarui data pengguna.
     */
    public function update(Request $request, string $id)
    {
        $pengguna = Pengguna::findOrFail($id);

        $request->validate([
            'full_name'      => 'required|string|max:255',
            'phone_number'   => 'required|string|max:20|unique:users_mobile,phone_number,' . $id,
            'status'         => 'required|in:Active,Inactive',
            'id_subdistrict' => 'nullable|exists:subdistrict,id',
            'id_village'     => 'nullable|exists:village,id',
            'password'       => 'nullable|string|min:6',
        ], [
            'full_name.required'    => 'Nama lengkap wajib diisi.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'phone_number.unique'   => 'Nomor telepon sudah digunakan oleh akun lain.',
            'status.required'       => 'Status akun wajib dipilih.',
            'password.min'          => 'Password minimal harus 6 karakter.',
        ]);

        $pengguna->full_name = $request->full_name;
        $pengguna->phone_number = $request->phone_number;
        $pengguna->status = $request->status;
        $pengguna->id_subdistrict = $request->id_subdistrict;

        // Jika peran tingkat kecamatan (id_role = 2), kosongkan id_village
        if ($pengguna->id_role == 2) {
            $pengguna->id_village = null;
        } else {
            $pengguna->id_village = $request->id_village;
        }

        if ($request->filled('password')) {
            $pengguna->password = Hash::make($request->password);
        }

        $pengguna->save();

        $tab = $pengguna->id_role == 2 ? 'kecamatan' : 'desa';
        return redirect()->route('pengguna.index', ['tab' => $tab])
            ->with('success', "Data pengguna {$pengguna->full_name} berhasil diperbarui.");
    }

    /**
     * Menghapus data pengguna.
     */
    public function destroy(string $id)
    {
        try {
            $pengguna = Pengguna::findOrFail($id);
            $tab = $pengguna->id_role == 2 ? 'kecamatan' : 'desa';
            $nama = $pengguna->full_name;

            $pengguna->delete();

            return redirect()->route('pengguna.index', ['tab' => $tab])
                ->with('success', "Akun pengguna \"{$nama}\" berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }

    /**
     * Mengambil daftar desa berdasarkan id kecamatan via AJAX.
     */
    public function getVillages($id_subdistrict)
    {
        $villages = Village::where('id_subdistrict', $id_subdistrict)->orderBy('name', 'asc')->get();
        return response()->json($villages);
    }
}
