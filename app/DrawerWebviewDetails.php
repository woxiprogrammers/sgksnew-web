<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrawerWebviewDetails extends Model
{
    protected $table = 'drawer_web_view_details';

    protected $fillable = ['drawer_web_id','description'];
}
