<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    const HEALTH = 'health';
    const GARBAGE_COLLECTION = 'garbage_collection';
    const OTHER_EMERGENCY = 'other_emergency';
    const COVID_TESTING = 'covid_testing';
    const COVID_INCIDENT = 'covid_incident';
    const FOOD = 'food';
    const MISC = 'misc';


    protected $fillable = ['details', 'contact_info', 'official', 'geo_location_id', 'type'];

    public function geography()
    {
        return $this->belongsTo(GeoLocation::class);
    }
}
