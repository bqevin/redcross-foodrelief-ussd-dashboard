<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeoLocation extends Model
{
    protected $fillable = ['location_description', 'ward', 'constituency', 'lat', 'lng'];
}
