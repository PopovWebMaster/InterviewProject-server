<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    protected $table = 'access';
    protected $primaryKey = 'id';
    /*protected $fillable = [
        'access_right',
    ]*/

    public $timestamps = true;
}
