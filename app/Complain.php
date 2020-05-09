<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    protected $fillable = ['description', 'official', 'occurrence_date','geo_location_id'];

    public function geoLocation()
    {
        return $this->belongsTo(GeoLocation::class);
    }
}
