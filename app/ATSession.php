<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ATSession extends Model
{
    protected $table = 'sessions';
    protected $fillable = ['at_id', 'meta'];
}
