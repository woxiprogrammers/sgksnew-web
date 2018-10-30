<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    protected $table = 'members';

    protected $fillable = ['first_name','address','middle_name','last_name','gender','date_of_birth','blood_group_id','mobile','email','city_id','longitude','latitude','profile_image','is_active'];
}
