<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisKonflik extends Model
{
    protected $table = 'jenis_konflik';

    public function potensiKonflik()
    {
        return $this->hasMany(PotensiKonflik::class, 'jenis_konflik_id');
    }
}
