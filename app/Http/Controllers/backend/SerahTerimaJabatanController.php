<?php

namespace App\Http\Controllers\backend;

use App\Models\User;
use App\Models\SerahTerimaJabatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class SerahTerimaJabatanController extends Controller
{
    /**
     * Menampilkan riwayat serah terima jabatan.
     */
    public function index()
    {
        $data = SerahTerimaJabatan::latest()->paginate(10);
        $currentUser = Auth::guard('web')->user() ?? Auth::guard('pengguna')->user();

        return view('backend.serah_terima_jabatan', compact('data', 'currentUser'));
    }

    /**
     * Menampilkan form serah terima jabatan.
     */
    public function create()
    {
        $currentUser = Auth::guard('web')->user() ?? Auth::guard('pengguna')->user();
        return view('backend.tambah_serah_terima_jabatan', compact('currentUser'));
    }

    /**
     * Menyimpan proses serah terima jabatan dan memperbarui kredensial akun pejabat.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nomor_sk_baru' => 'required|string|max:100',
            'tanggal_efektif' => 'required|date',
            'kata_sandi' => 'required|string|min:8',
            'dokumen_sk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'keterangan' => 'nullable|string|max:1000',
            'update_akun_sekarang' => 'nullable|boolean',
        ], [
            'nama_lengkap.required' => 'Nama lengkap pejabat baru wajib diisi.',
            'email.required' => 'Email pejabat baru wajib diisi.',
            'email.email' => 'Format penulisan email tidak valid.',
            'nomor_sk_baru.required' => 'Nomor SK Baru wajib diisi.',
            'tanggal_efektif.required' => 'Tanggal efektif serah terima jabatan wajib diisi.',
            'kata_sandi.required' => 'Kata sandi baru untuk pejabat pengganti wajib diisi.',
            'kata_sandi.min' => 'Kata sandi minimal 8 karakter.',
            'dokumen_sk.mimes' => 'Dokumen SK pendukung harus berupa file PDF atau gambar (JPG, PNG).',
            'dokumen_sk.max' => 'Ukuran dokumen SK maksimal 4MB.',
        ]);

        try {
            $currentUser = Auth::guard('web')->user() ?? Auth::guard('pengguna')->user();
            $namaPejabatLama = $currentUser ? ($currentUser->name ?? $currentUser->full_name ?? 'Pejabat Sebelumnya') : 'Admin';

            // Upload dokumen SK jika dilampirkan
            $dokumenName = null;
            if ($request->hasFile('dokumen_sk')) {
                $uploadPath = public_path('storage/serah_terima');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0777, true, true);
                }
                $dokumenName = time() . '_' . uniqid() . '.' . $request->file('dokumen_sk')->getClientOriginalExtension();
                $request->file('dokumen_sk')->move($uploadPath, $dokumenName);
            }

            // Simpan riwayat serah terima jabatan
            $serahTerima = SerahTerimaJabatan::create([
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'nomor_sk_baru' => $request->nomor_sk_baru,
                'tanggal_efektif' => $request->tanggal_efektif,
                'pejabat_lama' => $namaPejabatLama,
                'dokumen_sk' => $dokumenName,
                'keterangan' => $request->keterangan,
                'status' => 'Berhasil',
                'id_user' => $currentUser ? $currentUser->id : null,
            ]);

            // Pembaruan akun pejabat baru secara langsung (jika login sebagai admin guard web)
            if (Auth::guard('web')->check()) {
                $user = Auth::guard('web')->user();
                $user->name = $request->nama_lengkap;
                $user->email = $request->email;
                $user->password = Hash::make($request->kata_sandi);
                $user->save();
            }

            return redirect()->route('serah_terima_jabatan.index')
                ->with('success', 'Proses serah terima jabatan berhasil disimpan dan data akun telah diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal memproses serah terima jabatan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail serah terima jabatan.
     */
    public function show(string $id)
    {
        $data = SerahTerimaJabatan::findOrFail($id);
        return view('backend.detail_serah_terima_jabatan', compact('data'));
    }

    /**
     * Menghapus catatan riwayat serah terima jabatan.
     */
    public function destroy(string $id)
    {
        try {
            $data = SerahTerimaJabatan::findOrFail($id);

            if ($data->dokumen_sk) {
                $filePath = public_path('storage/serah_terima/' . $data->dokumen_sk);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }

            $data->delete();

            return redirect()->route('serah_terima_jabatan.index')
                ->with('success', 'Riwayat serah terima jabatan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Cetak Berita Acara Serah Terima Jabatan (BAST).
     */
    public function cetak(string $id)
    {
        $data = SerahTerimaJabatan::findOrFail($id);
        return view('backend.cetak_serah_terima_jabatan', compact('data'));
    }
}
