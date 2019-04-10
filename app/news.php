<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class news extends Model
{
        //table name
    protected $table = 'news';

    //primary key
   protected $primaryKey = 'id';

    //TimeStemps
     public $timestamps = false;

}
