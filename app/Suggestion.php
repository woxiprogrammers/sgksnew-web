<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $table = 'suggestions';

    protected $fillable = ['description','suggestion_type_id','suggestion_category_id','city_id'];
}
