<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventsTranslations extends Model
{
    protected $table = 'events_translations';
    protected $fillable = ['event_name','description','venue','event_id','language_id'];
}
