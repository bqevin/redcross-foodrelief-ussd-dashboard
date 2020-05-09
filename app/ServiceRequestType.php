<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceRequestType extends Model
{
    protected $fillable = ['details', 'request_id',];

    public function geoLocation()
    {
        return $this->belongsTo(ServiceRequest::class);
    }
}
