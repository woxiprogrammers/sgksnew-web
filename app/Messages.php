<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $table = 'messages';

    protected $fillable = ['title','description','message_type_id','city_id','is_active','image_url'];
}
