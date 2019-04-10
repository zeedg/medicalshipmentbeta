<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ubs extends Model
{
    //table name
    protected $table = 'bill_ship_address';
	
	public $timestamps = false;
	
	protected $fillable = ['user_id', 'bsa_type', 'bsa_fname', 'bsa_lname', 'bsa_phone', 'bsa_zip', 'bsa_city', 'bsa_country', 'bsa_state', 'bsa_address', 'bsa_address_type', 'bsa_ship_dir', 'bsa_default', 'bsa_date'];
    
	//primary key
    //public $primayKey = 'id';

    //TimeStemps
    //public $TimeStemps = '';
}
