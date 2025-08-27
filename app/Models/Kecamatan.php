<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatan';
    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
        'nama'  => 'string',
        'kabupaten_id'  => 'string'
    ];

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }

    public function desa()
    {
        return $this->hasMany(Desa::class);
    }
    public function geoFeature()
    {
        return $this->belongsTo(GeoFeature::class, 'geo_features_id');
    }
}
