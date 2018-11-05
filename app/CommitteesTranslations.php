<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommitteesTranslations extends Model
{
    protected $table='committees_translations';
    protected $fillable=['committee_name','description','language_id','committee_id'];
}
