<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = 'provinsi';
    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
        'nama'  => 'string'
    ];

    public function kabupaten()
    {
        return $this->hasMany(Kabupaten::class);
    }
    public function geoFeature()
    {
        return $this->belongsTo(GeoFeature::class, 'geo_features_id');
    }
}
