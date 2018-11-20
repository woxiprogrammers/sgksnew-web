<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageTranslations extends Model
{
    protected $table = 'messages_translations';

    protected $fillable = ['title','description','message_id','language_id'];
}
