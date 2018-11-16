<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventImages extends Model
{
    protected $table = 'event_images';
    protected $fillable = ['event_id','url'];
}
