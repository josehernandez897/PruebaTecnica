<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    protected $fillable = [
        'id','created_at','updated_at'
    ];
}
