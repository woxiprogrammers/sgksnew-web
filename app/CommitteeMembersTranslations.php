<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommitteeMembersTranslations extends Model
{
    protected $table='committee_members_translations';
    protected $fillable=['full_name','language_id','member_id'];
}
