<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model{
	protected $table = 'product_item';
	protected $guarded = ['pi_id'];
	protected $primaryKey = 'pi_id';
	public $timestamps = FALSE;
}
