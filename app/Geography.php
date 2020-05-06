<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Geography extends Model
{
    protected $table = 'geography';
    protected $fillable = ['location', 'complain_id', 'ward', 'constituency'];

    public function complain()
    {
        return $this->belongsTo(Complain::class);
    }

}
