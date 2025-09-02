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
        'penanggung_jawab',
        'latar_belakang',
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
}
