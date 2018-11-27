<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassifiedImages extends Model
{
    protected $table = 'classified_images';

    protected $fillable = ['classified_id','image_url'];
}
