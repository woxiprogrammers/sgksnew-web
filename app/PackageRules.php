<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageRules extends Model
{
    protected $table = 'package_rules';

    protected $fillable = ['package_id','package_desc'];
}
