<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class unit_product extends Model
{
        //table name
    protected $table = 'unit_product';

    //primary key
    protected $primaryKey = 'product_id';

    //TimeStemps
    public $timestamps = false;
}
