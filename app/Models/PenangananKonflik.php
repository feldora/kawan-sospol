<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenangananKonflik extends Model
{
    use HasFactory;

    protected $table = 'penanganan_konflik';
    protected $guarded = [];

    /**
     * Relasi: penanganan milik sebuah konflik
     */
    public function konflik()
    {
        return $this->belongsTo(Konflik::class, 'konflik_id', 'id');
    }
}
