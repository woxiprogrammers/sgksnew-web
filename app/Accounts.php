<?php
/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 14/11/18
 * Time: 12:05 PM
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    protected $table = 'accounts';
    protected $fillable = ['name','description','city_id'];
}