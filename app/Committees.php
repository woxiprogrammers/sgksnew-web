<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Committees extends Model
{
    protected $table= 'committees';
    protected $fillable = ['committee_name','description','city_id','is_active'];
}
