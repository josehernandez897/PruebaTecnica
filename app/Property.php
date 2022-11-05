<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Base;


class Property extends Base
{
    protected $fillable = [
        'id','article','description','user_id',
    ];
}

