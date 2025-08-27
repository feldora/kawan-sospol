<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        DB::statement('ALTER DATABASE ' . env('DB_DATABASE') . ' REFRESH COLLATION VERSION');
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@localhost',
        ]);


        $this->call([
            ProvinsiSeeder::class,
            KabupatenSeeder::class,
            KecamatanSeeder::class,
            DesaSeeder::class,
            ShapefileImportSeeder::class,
        ]);
        $this->call(KonflikSeeder::class);
    }
}
