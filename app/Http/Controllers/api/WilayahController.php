<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kecamatan;

class WilayahController extends Controller
{

    public function getProvinsi()
    {
        $provinsi = Provinsi::all(['id', 'nama']);
        return response()->json($provinsi);
    }

    public function getKabupaten(Request $request)
    {
        $provinsiId = $request->provinsi_id;

        $kabupaten = Kabupaten::when($provinsiId, function($q) use ($provinsiId) {
            $q->where('provinsi_id', $provinsiId);
        })->get(['id', 'nama']);

        return response()->json($kabupaten);
    }

    public function getKecamatan(Request $request)
    {
        $kabupatenId = $request->kabupaten_id;

        $kecamatan = Kecamatan::where('kabupaten_id', $kabupatenId)->get(['id', 'nama']);

        return response()->json($kecamatan);
    }

    public function getDesa(Request $request)
    {
        $kecamatanId = $request->kecamatan_id;

        $desa = \App\Models\Desa::where('kecamatan_id', $kecamatanId)->get(['id', 'nama']);

        return response()->json($desa);
    }

}
