<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKonflik extends Model
{
    use HasFactory;

    protected $table = 'jenis_konflik';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    /**
     * Relasi: Jenis konflik memiliki banyak potensi konflik
     */
    public function potensiKonflik()
    {
        return $this->hasMany(PotensiKonflik::class, 'jenis_konflik_id');
    }
}
