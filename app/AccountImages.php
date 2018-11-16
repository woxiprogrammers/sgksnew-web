<?php
/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 14/11/18
 * Time: 12:15 PM
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class AccountImages extends Model
{
    protected $table = 'account_images';
    protected $fillable = ['account_id','url'];
}