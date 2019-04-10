<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bestseller extends Model
{
        //table name
    protected $table = 'best_seller';

    //primary key
    public $primayKey = 'bs_id';

    //TimeStemps
    //public $TimeStemps = '';
}
