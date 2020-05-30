<?php

namespace App;

use App\Enum\RequestType;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $fillable = ['details', 'contact_info', 'official', 'geo_location_id', 'type', 'household_number'];

    public function geography()
    {
        return $this->belongsTo(GeoLocation::class);
    }

    public function getServiceName(int $serviceNumber)
    {
        return RequestType::serviceName($serviceNumber);
    }
}
