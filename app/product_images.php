<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_images extends Model
{
        //table name
    protected $table = 'product_image';

    //primary key
   protected $primaryKey = 'pi_id';

    //TimeStemps
     public $timestamps = false;
}
