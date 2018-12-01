<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CitiesTranslation extends Model
{
    protected $table = 'cities_translations';

    protected $fillable = ['name','city_id','language_id'];
}
