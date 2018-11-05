<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommitteeMembers extends Model
{
    protected $table = 'committee_members';
    protected $fillable = ['committee_id','full_name','designation','mobile_number','email_id','profile_image'];
}
