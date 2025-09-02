<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Konflik;
use App\Models\PotensiKonflik;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{

    public function potensiKonflik()
    {
        // Ambil potensi konflik dengan relasi desa → kecamatan → kabupaten → geoFeature
        $potensiList = PotensiKonflik::with([
            'desa.kecamatan.kabupaten',
            'desa.geoFeature'
        ])->get();
        // dd($potensiList->toArray());
        $result = [];

        foreach ($potensiList as $potensi) {
            $desa = $potensi->desa;
            if (!$desa || !$desa->geoFeature) {
                continue;
            }

            $kab = $desa->kecamatan->kabupaten;
            $desLabel = ($kab->nama == 'Kota Palu') ? 'Kelurahan' : 'Desa';

            $result[] = [
                'id'          => $potensi->id,
                'nama_potensi'=> $potensi->nama_potensi,
                'tanggal_potensi'     => $potensi->tanggal_potensi,
                'desa_id'     => $desa->id,
                'lokasi'      => "{$desLabel} {$desa->nama}, Kecamatan {$desa->kecamatan->nama}, Kabupaten {$kab->nama}",
                'geojson'     => json_decode(DB::selectOne(
                    "SELECT ST_AsGeoJSON(geom) as geo FROM geo_features WHERE id = ?",
                    [$desa->geoFeature->id]
                )->geo),
                'latar_belakang'   => $potensi->latar_belakang,
                'penanggung_jawab' => $potensi->penanggung_jawab,
            ];
        }

        return response()->json([
            'status' => 'success',
            'data'   => $result,
        ]);
    }

    public function konflik()
    {
        // Ambil konflik dengan relasi lengkap
        $konflikList = Konflik::with([
            'desa.kecamatan.kabupaten',
            'desa.geoFeature',
            'penangananList'
        ])->get();

        $result = [];

        foreach ($konflikList as $konflik) {
            $desa = $konflik->desa;
            if (!$desa || !$desa->geoFeature) {
                continue;
            }

            $kab = $desa->kecamatan->kabupaten;
            $desLabel = ($kab->nama == 'Kota Palu') ? 'Kelurahan' : 'Desa';

            $result[] = [
                'id'        => $konflik->id,
                'jenis'     => ucfirst($konflik->jenis), // sosial → Sosial
                'judul'     => $konflik->judul,
                'deskripsi' => $konflik->deskripsi,
                'desa_id'   => $desa->id,
                'lokasi'    => "{$desLabel} {$desa->nama}, Kecamatan {$desa->kecamatan->nama}, Kabupaten {$kab->nama}",
                'geojson'   => json_decode(DB::selectOne(
                    "SELECT ST_AsGeoJSON(geom) as geo FROM geo_features WHERE id = ?",
                    [$desa->geoFeature->id]
                )->geo),
                'jumlah'    => $konflik->jumlah,
                'status'    => $konflik->status,
                'tanggal'   => $konflik->tanggal,
                'sumber'    => $konflik->sumber,
                'penanganan'=> $konflik->penanganan, // field utama
                'penanganan_detail' => $konflik->penangananList->map(function ($p) {
                    return [
                        'instansi' => $p->instansi,
                        'tindakan' => $p->tindakan,
                        'tanggal'  => $p->tanggal,
                    ];
                }),
            ];
        }

        return response()->json([
            'status' => 'success',
            'data'   => $result,
        ]);
    }

    public function konflikPerKabupaten($kabupatenId = null)
    {
        $query = DB::table('konflik')
            ->join('desa', 'konflik.desa_id', '=', 'desa.id')
            ->join('kecamatan', 'desa.kecamatan_id', '=', 'kecamatan.id')
            ->join('kabupaten', 'kecamatan.kabupaten_id', '=', 'kabupaten.id')
            ->join('geo_features', DB::raw('desa.geo_features_id::bigint'), '=', 'geo_features.id') // ✅ casting
            ->select(
                'desa.id as desa_id',
                'desa.nama as desa',
                'kecamatan.id as kecamatan_id',
                'kecamatan.nama as kecamatan',
                'kabupaten.id as kabupaten_id',
                'kabupaten.nama as kabupaten',
                DB::raw('COUNT(konflik.id) as total_konflik'),
                DB::raw("SUM(CASE WHEN konflik.jenis = 'sosial' THEN 1 ELSE 0 END) as konflik_sosial"),
                DB::raw("SUM(CASE WHEN konflik.jenis = 'politik' THEN 1 ELSE 0 END) as konflik_politik"),
                DB::raw("ST_AsGeoJSON(geo_features.geom) as geojson")
            )
            ->groupBy(
                'kabupaten.id',
                'kabupaten.nama',
                'kecamatan.id',
                'kecamatan.nama',
                'desa.id',
                'desa.nama',
                'geo_features.geom'
            );

        if ($kabupatenId) {
            $query->where('kabupaten.id', $kabupatenId);
        }

        $data = $query->get()->map(function ($row) {
            return [
                'desa_id'        => $row->desa_id,
                'desa'           => $row->desa,
                'kecamatan_id'   => $row->kecamatan_id,
                'kecamatan'      => $row->kecamatan,
                'kabupaten_id'   => $row->kabupaten_id,
                'kabupaten'      => $row->kabupaten,
                'total_konflik'  => (int) $row->total_konflik,
                'konflik_sosial' => (int) $row->konflik_sosial,
                'konflik_politik'=> (int) $row->konflik_politik,
                'geojson'        => json_decode($row->geojson),
            ];
        });

        return response()->json([
            'status' => 'success',
            'data'   => $data,
        ]);
    }


    public function detailKonflikPerKabupaten($kabupatenId = null)
    {
        if (!$kabupatenId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kabupaten ID is required',
            ], 400);
        }

        $query = DB::table('konflik')
            ->join('desa', 'konflik.desa_id', '=', 'desa.id')
            ->join('kecamatan', 'desa.kecamatan_id', '=', 'kecamatan.id')
            ->join('kabupaten', 'kecamatan.kabupaten_id', '=', 'kabupaten.id')
            ->select(
                'konflik.id',
                'konflik.jenis',
                'konflik.judul',
                'konflik.deskripsi',
                'konflik.jumlah',
                'konflik.status',
                'konflik.tanggal',
                'konflik.sumber',
                DB::raw("CONCAT(
                    CASE WHEN kabupaten.nama = 'Kota Palu' THEN 'Kelurahan' ELSE 'Desa' END,
                    ' ', desa.nama, ', Kecamatan ', kecamatan.nama
                ) as lokasi")
            )
            ->where('kabupaten.id', $kabupatenId);

        $data = $query->get();

        return response()->json([
            'status' => 'success',
            'data'   => $data,
        ]);
    }

    public function detailKonflikPerDesa($desaId = null)
    {
        if (!$desaId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Desa ID is required',
            ], 400);
        }

        $query = DB::table('konflik')
            ->join('desa', 'konflik.desa_id', '=', 'desa.id')
            ->join('kecamatan', 'desa.kecamatan_id', '=', 'kecamatan.id')
            ->join('kabupaten', 'kecamatan.kabupaten_id', '=', 'kabupaten.id')
            ->select(
                'konflik.id',
                'konflik.jenis',
                'konflik.judul',
                'konflik.deskripsi',
                // 'konflik.jumlah',
                'konflik.status',
                'konflik.tanggal',
                'konflik.sumber',
                DB::raw("CONCAT(
                    CASE WHEN kabupaten.nama = 'Kota Palu' THEN 'Kelurahan' ELSE 'Desa' END,
                    ' ', desa.nama, ', Kecamatan ', kecamatan.nama, ', Kabupaten ', kabupaten.nama
                ) as lokasi")
            )
            ->where('desa.id', $desaId);

        $data = $query->get();

        return response()->json([
            'status' => 'success',
            'data'   => $data,
        ]);
    }
}
