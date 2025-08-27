<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konflik extends Model
{
    use HasFactory;

    protected $table = 'konflik';
    protected $guarded = [];

    /**
     * Relasi: Konflik dimiliki oleh sebuah desa
     */
    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa_id', 'id');
    }

    /**
     * Relasi: Konflik bisa punya banyak penanganan
     */
    public function penangananList()
    {
        return $this->hasMany(PenangananKonflik::class, 'konflik_id', 'id');
    }

    /**
     * Relasi: Konflik bisa punya banyak laporan
     */
    public function laporan()
    {
        return $this->hasMany(LaporanKonflik::class, 'konflik_id', 'id');
    }
}
