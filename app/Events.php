<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $table = 'events';
    protected $fillable = ['event_name','description','venue','start_date','end_date','is_active','city_id'];
}
