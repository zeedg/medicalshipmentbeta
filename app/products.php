<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
        //table name
    protected $table = 'product';

    //primary key
   protected $primaryKey = 'product_id';

    //TimeStemps
     public $timestamps = false;
}
