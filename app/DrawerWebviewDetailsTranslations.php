<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrawerWebviewDetailsTranslations extends Model
{
    protected $table = 'drawer_webview_details_translations';

    protected $fillable = ['drawer_webview_details_id','description','language_id'];
}
