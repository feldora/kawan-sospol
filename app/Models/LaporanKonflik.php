<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKonflik extends Model
{
    use HasFactory;

    protected $table = 'laporan_konflik';
    protected $guarded = [];

    /**
     * Relasi: laporan milik sebuah konflik
     */
    public function konflik()
    {
        return $this->belongsTo(Konflik::class, 'konflik_id', 'id');
    }
}
