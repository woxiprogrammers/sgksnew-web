<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';

    protected $fillable = ['first_name','last_name','email','mobile','password','dob','gender','role_id'];
}
