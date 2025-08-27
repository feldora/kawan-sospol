<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;

    protected $table = 'desa';
    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
        'nama'  => 'string',
        'kecamatan_id'  => 'string'
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
    public function geoFeature()
    {
        return $this->belongsTo(GeoFeature::class, 'geo_features_id');
    }
}
