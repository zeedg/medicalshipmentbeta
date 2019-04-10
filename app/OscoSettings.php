<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OscoSettings extends Model
{
      protected $table = 'osco_settings';
        protected $guarded = ['id'];
        protected $primaryKey = '';
        public $timestamps = FALSE;
        
}
