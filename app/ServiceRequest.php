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

    public function getServiceName(int $serviceNumber)
    {

        $serviceFullName = [
            self::MISC => 'Miscellaneous',
            self::OTHER_EMERGENCY => 'Other Emergency',
            self::GARBAGE_COLLECTION => 'Garbage Collection',
            self::FOOD => 'Relief Food Assistance',
            self::HEALTH => 'Health Assistance',
            self::COVID_INCIDENT => 'COVID-19 Case',
            self::COVID_TESTING => 'COVID-19 Test'
        ];

        return $serviceFullName[ServiceRequest::servicesMap($serviceNumber)];
    }

    public static function servicesMap(int $serviceNumber)
    {
        return [
            1 => self::COVID_TESTING,
            2 => self::COVID_INCIDENT,
            3 => self::HEALTH,
            4 => self::FOOD,
            5 => self::GARBAGE_COLLECTION,
            6 => self::OTHER_EMERGENCY,
            7 => self::MISC,
        ][$serviceNumber];
    }
}
