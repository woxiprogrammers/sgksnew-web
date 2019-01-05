<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCities extends Model
{
    protected $table = 'user_cities';

    protected $fillable = ['user_id','city_id'];
}
