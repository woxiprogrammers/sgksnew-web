<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassifiedsTranslations extends Model
{
    protected $table = 'classifieds_translations';

    protected $fillable = ['title','classified_desc','classified_id','language_id'];
}
