<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reviews extends Model
{
        //table name
    protected $table = 'review';

    //primary key
    protected $primaryKey = 'rew_id';

    //TimeStemps
    public $timestamps = false;
}
