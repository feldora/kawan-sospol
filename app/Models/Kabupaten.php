<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;

    protected $table = 'kabupaten';
    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
        'nama'  => 'string',
        'provinsi_id'  => 'string'
    ];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class);
    }
    public function geoFeature()
    {
        return $this->belongsTo(GeoFeature::class, 'geo_features_id');
    }
}
