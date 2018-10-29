<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberTranslations extends Model
{
    protected $table = "member_translations";

    protected $fillable = ['first_name','middle_name','last_name','address','language_id','member_id'];
}
