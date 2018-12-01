<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classifieds extends Model
{
    protected $table = 'classifieds';

    protected $fillable = ['title','description','package_id','city_id'];
}
