<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class ShapefileImportSeeder extends Seeder
{
    public function run(): void
    {
        // Import kabupaten
        Artisan::call('shp:import', [
            'zip_path' => 'shapefiles/kab.zip',
            '--name-field' => 'WADMKK',
            '--tag' => 'kabupaten',
        ]);

        // Import kecamatan
        Artisan::call('shp:import', [
            'zip_path' => 'shapefiles/kec.zip',
            '--name-field' => 'WADMKC',
            '--tag' => 'kecamatan',
        ]);

        // Import Desa
        Artisan::call('shp:import', [
            'zip_path' => 'shapefiles/desa.zip',
            '--name-field' => 'WADMKD',
            '--tag' => 'desa',
        ]);

        $this->updateProperties();
        $this->updateWilayah();
    }

    private function updateProperties(){

        // Tambahkan field KDWKB jika belum ada
        DB::statement("
            UPDATE public.geo_features
            SET properties = jsonb_set(properties::jsonb, '{KDWKB}', to_jsonb(''::text))
            WHERE geo_features.tag = 'kabupaten'
              AND (properties->>'KDWKB') IS NULL
        ");

        // Tambahkan field KDWPR jika belum ada
        DB::statement("
            UPDATE public.geo_features
            SET properties = jsonb_set(properties::jsonb, '{KDWPR}', to_jsonb(''::text))
            WHERE geo_features.tag = 'kabupaten'
              AND (properties->>'KDWPR') IS NULL
        ");

        // Update berdasarkan kecocokan nama kabupaten
        DB::statement("
            UPDATE public.geo_features
            SET properties = jsonb_set(
                                jsonb_set(properties::jsonb, '{KDWKB}', to_jsonb(COALESCE(kabupaten.id::text, ''))),
                                '{KDWPR}', to_jsonb(COALESCE(kabupaten.provinsi_id::text, ''))
                            )
            FROM public.kabupaten
            WHERE geo_features.properties->>'WADMKK' = kabupaten.nama
              AND geo_features.tag = 'kabupaten'
        ");


        // Tambahkan field KDWKC jika belum ada
        DB::statement("
            UPDATE public.geo_features
            SET properties = jsonb_set(properties::jsonb, '{KDWKC}', to_jsonb(''::text))
            WHERE geo_features.tag = 'kecamatan'
              AND (properties->>'KDWKC') IS NULL
        ");

        // Tambahkan field KDWKB jika belum ada
        DB::statement("
            UPDATE public.geo_features
            SET properties = jsonb_set(properties::jsonb, '{KDWKB}', to_jsonb(''::text))
            WHERE geo_features.tag = 'kecamatan'
              AND (properties->>'KDWKB') IS NULL
        ");

        // Tambahkan field KDWPR jika belum ada
        DB::statement("
            UPDATE public.geo_features
            SET properties = jsonb_set(properties::jsonb, '{KDWPR}', to_jsonb(''::text))
            WHERE geo_features.tag = 'kecamatan'
              AND (properties->>'KDWPR') IS NULL
        ");

        // Update berdasarkan kecocokan WADMKC ke kecamatan.nama
        DB::statement("
            UPDATE public.geo_features
            SET properties = jsonb_set(
                                jsonb_set(
                                    jsonb_set(properties::jsonb, '{KDWKC}', to_jsonb(COALESCE(kecamatan.id::text, ''))),
                                    '{KDWKB}', to_jsonb(COALESCE(kecamatan.kabupaten_id::text, ''))
                                ),
                                '{KDWPR}', to_jsonb(COALESCE(kabupaten.provinsi_id::text, ''))
                            )
            FROM public.kecamatan
            LEFT JOIN public.kabupaten ON kabupaten.id = kecamatan.kabupaten_id
            WHERE geo_features.properties->>'WADMKC' = kecamatan.nama
              AND geo_features.tag = 'kecamatan'
        ");
    }

    private function updateWilayah() {
        // Update kabupaten
        DB::statement("
            UPDATE public.kabupaten
            SET geo_features_id = geo_features.id::text
            FROM public.geo_features
            WHERE geo_features.tag = 'kabupaten'
            AND geo_features.properties->>'KDWKB' = kabupaten.id::text
        ");

        // Update kecamatan
        DB::statement("
            UPDATE public.kecamatan
            SET geo_features_id = geo_features.id::text
            FROM public.geo_features
            WHERE geo_features.tag = 'kecamatan'
            AND geo_features.properties->>'KDWKC' = kecamatan.id::text
        ");

        // Update desa
        DB::statement("
            UPDATE public.desa
            SET geo_features_id = geo_features.id::text
            FROM public.geo_features
            WHERE geo_features.tag = 'desa'
            AND geo_features.properties->>'KDEPUM' = desa.id::text
        ");
    }


}
