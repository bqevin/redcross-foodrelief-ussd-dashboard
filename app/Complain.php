<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    protected $table = 'complain';
    protected $fillable = ['description', 'against', 'occurrence_date'];

    public function geography()
    {
        return $this->hasOne(Geography::class);
    }
}
