<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    const HEALTH = 'health';
    const GARBAGE_COLLECTION = 'garbage_collection';
    const OTHER_EMERGENCY = 'other_emergency';
    const COVID_TESTING = 'covid_testing';
    const COVID_INCIDENT = 'covid_incident';
    const FOOD = 'food';
    const MISC = 'misc';


    protected $fillable = ['details', 'contact_info', 'official', 'geo_location_id', 'type', 'household_number'];

    public function geography()
    {
        return $this->belongsTo(GeoLocation::class);
    }
}
