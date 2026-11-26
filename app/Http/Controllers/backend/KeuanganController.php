<?php

namespace App\Http\Controllers\backend;

use App\Models\Keuangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class KeuanganController extends Controller
{
    /**
     * Menampilkan daftar transaksi keuangan beserta ringkasan saldo.
     */
    public function index(Request $request)
    {
        $query = Keuangan::query();

        // Filter berdasarkan jenis (pemasukan / pengeluaran)
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter rentang tanggal
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        } elseif ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        } elseif ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }

        // Hitung total pemasukan, pengeluaran, dan saldo kas
        $totalPemasukan = (clone $query)->where('jenis', 'pemasukan')->sum('nominal');
        $totalPengeluaran = (clone $query)->where('jenis', 'pengeluaran')->sum('nominal');
        $saldo = $totalPemasukan - $totalPengeluaran;

        $data = $query->latest('tanggal')->latest('id')->paginate(10);

        return view('backend.keuangan', compact('data', 'totalPemasukan', 'totalPengeluaran', 'saldo'));
    }

    /**
     * Menampilkan form tambah transaksi keuangan.
     */
    public function create()
    {
        return view('backend.tambah_keuangan');
    }

    /**
     * Menyimpan transaksi keuangan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'tanggal' => 'required|date',
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'required|string|max:1000',
            'bukti' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ], [
            'jenis.required' => 'Jenis transaksi (pemasukan / pengeluaran) wajib dipilih.',
            'jenis.in' => 'Jenis transaksi hanya boleh pemasukan atau pengeluaran.',
            'tanggal.required' => 'Tanggal transaksi wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'nominal.required' => 'Nominal transaksi wajib diisi.',
            'nominal.numeric' => 'Nominal transaksi harus berupa angka.',
            'keterangan.required' => 'Keterangan transaksi wajib diisi.',
            'bukti.mimes' => 'Bukti/nota harus berupa gambar (JPG, PNG) atau file PDF.',
            'bukti.max' => 'Ukuran file bukti/nota maksimal 2MB.',
        ]);

        try {
            $fileName = null;
            if ($request->hasFile('bukti')) {
                $uploadPath = public_path('storage/keuangan');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0777, true, true);
                }
                $fileName = time() . '_' . uniqid() . '.' . $request->file('bukti')->getClientOriginalExtension();
                $request->file('bukti')->move($uploadPath, $fileName);
            }

            $userId = Auth::guard('web')->id() ?? Auth::guard('pengguna')->id();

            Keuangan::create([
                'jenis' => $request->jenis,
                'tanggal' => $request->tanggal,
                'nominal' => $request->nominal,
                'keterangan' => $request->keterangan,
                'bukti' => $fileName,
                'id_user' => $userId,
            ]);

            return redirect()->route('keuangan.index')
                ->with('success', 'Transaksi keuangan berhasil dicatat.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal mencatat transaksi keuangan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail transaksi keuangan.
     */
    public function show(string $id)
    {
        $data = Keuangan::findOrFail($id);
        return view('backend.detail_keuangan', compact('data'));
    }

    /**
     * Menampilkan form edit transaksi keuangan.
     */
    public function edit(string $id)
    {
        $data = Keuangan::findOrFail($id);
        return view('backend.edit_keuangan', compact('data'));
    }

    /**
     * Memperbarui transaksi keuangan.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'tanggal' => 'required|date',
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'required|string|max:1000',
            'bukti' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ], [
            'jenis.required' => 'Jenis transaksi wajib dipilih.',
            'tanggal.required' => 'Tanggal transaksi wajib diisi.',
            'nominal.required' => 'Nominal wajib diisi.',
            'keterangan.required' => 'Keterangan transaksi wajib diisi.',
            'bukti.mimes' => 'Bukti/nota harus berupa gambar (JPG, PNG) atau PDF.',
            'bukti.max' => 'Ukuran file bukti/nota maksimal 2MB.',
        ]);

        try {
            $data = Keuangan::findOrFail($id);
            $fileName = $data->bukti;

            if ($request->hasFile('bukti')) {
                $uploadPath = public_path('storage/keuangan');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0777, true, true);
                }

                // Hapus bukti lama jika ada
                if ($data->bukti && File::exists($uploadPath . '/' . $data->bukti)) {
                    File::delete($uploadPath . '/' . $data->bukti);
                }

                $fileName = time() . '_' . uniqid() . '.' . $request->file('bukti')->getClientOriginalExtension();
                $request->file('bukti')->move($uploadPath, $fileName);
            }

            $data->update([
                'jenis' => $request->jenis,
                'tanggal' => $request->tanggal,
                'nominal' => $request->nominal,
                'keterangan' => $request->keterangan,
                'bukti' => $fileName,
            ]);

            return redirect()->route('keuangan.index')
                ->with('success', 'Transaksi keuangan berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal memperbarui data keuangan: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus transaksi keuangan.
     */
    public function destroy(string $id)
    {
        try {
            $data = Keuangan::findOrFail($id);

            if ($data->bukti) {
                $filePath = public_path('storage/keuangan/' . $data->bukti);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }

            $data->delete();

            return redirect()->route('keuangan.index')
                ->with('success', 'Transaksi keuangan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Cetak laporan pembukuan kas keuangan.
     */
    public function cetak(Request $request)
    {
        $query = Keuangan::query();

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $totalPemasukan = (clone $query)->where('jenis', 'pemasukan')->sum('nominal');
        $totalPengeluaran = (clone $query)->where('jenis', 'pengeluaran')->sum('nominal');
        $saldo = $totalPemasukan - $totalPengeluaran;

        $data = $query->orderBy('tanggal', 'asc')->get();

        return view('backend.cetak_keuangan', compact('data', 'totalPemasukan', 'totalPengeluaran', 'saldo'));
    }
}
