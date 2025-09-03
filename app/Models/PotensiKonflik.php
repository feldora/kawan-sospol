<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PotensiKonflik extends Model
{
    use HasFactory;
    protected $table = 'potensi_konflik';

    protected $fillable = [
        'nama_potensi',
        'tanggal_potensi',
        'kabupaten_id',
        'kecamatan_id',
        'desa_id',
        'jenis_konflik_id', // Tambahkan field ini
        'jenis',
        'penanggung_jawab',
        'latar_belakang',
        'potensi_konflik',
        'eskalasi',
        'status_konflik',

    ];

    protected $casts = [
        'tanggal_potensi' => 'date',
    ];

    public function kabupaten(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class);
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    /**
     * Relasi ke JenisKonflik
     */
    public function jenisKonflik(): BelongsTo
    {
        return $this->belongsTo(JenisKonflik::class, 'jenis_konflik_id');
    }
    public function laporanKonflik()
    {
        return $this->hasMany(LaporanKonflik::class, 'potensi_konflik_id');
    }

}
