<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanKonflik;

class LaporKawanController extends Controller
{
    /**
     * Tampilkan halaman form pelaporan
     */
    public function create()
    {
        // ambil kabupaten untuk dropdown awal
        // $kabupatens = \App\Models\Kabupaten::all();
        return view('pelaporan.create');
    }

    /**
     * Simpan laporan konflik ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'         => 'required|string|min:3|max:100',
            'kontak'       => 'required|string|max:100',
            'kabupaten_id' => 'nullable|exists:kabupatens,id',
            'kecamatan_id' => 'nullable|exists:kecamatans,id',
            'desa_id'      => 'nullable|exists:desas,id',
            'lokasi_text'  => 'nullable|string|max:255',
            'deskripsi'    => 'required|string|min:20',
        ]);

        $laporan = new LaporanKonflik();
        $laporan->nama          = $validated['nama'];
        $laporan->kontak        = $validated['kontak'];
        $laporan->kabupaten_id  = $validated['kabupaten_id'] ?? null;
        $laporan->kecamatan_id  = $validated['kecamatan_id'] ?? null;
        $laporan->desa_id       = $validated['desa_id'] ?? null;
        $laporan->lokasi_text   = $validated['lokasi_text'] ?? null;
        $laporan->deskripsi     = $validated['deskripsi'];
        $laporan->status        = 'baru'; // default status
        $laporan->save();

        return redirect()
            ->route('laporan.selesai')
            ->with('success', 'Laporan berhasil dikirim. Terima kasih.');
    }

    /**
     * Halaman selesai setelah laporan dikirim
     */
    public function selesai()
    {
        return view('pelaporan.selesai');
    }
}
