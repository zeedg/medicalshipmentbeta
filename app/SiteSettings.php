<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model{
	protected $table = 'site_setting';
	protected $guarded = ['id'];
	protected $primaryKey = 'id';
	//public $timestamps = FALSE;
	
}
