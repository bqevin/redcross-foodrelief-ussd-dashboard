<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetaData extends Model
{
    protected $table = 'metadata';
    protected $fillable = ['extra'];
}
