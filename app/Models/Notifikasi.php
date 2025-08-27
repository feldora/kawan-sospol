<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';
    protected $guarded = [];

    /**
     * Kalau nanti notifikasi dikaitkan dengan konflik
     */
    public function konflik()
    {
        return $this->belongsTo(Konflik::class, 'konflik_id', 'id');
    }
}
