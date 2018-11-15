<?php
/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 14/11/18
 * Time: 12:16 PM
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class AccountsTranslations extends Model
{

    protected $table = 'accounts_translations';
    protected $fillable = ['name','description','account_id','language_id'];
}