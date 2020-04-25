<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Preference extends Model
{
		protected $table = 'preferences';
		protected $fillable = ['id', 'user_id', 'darkmode', 'created_at', 'updated_at'];
}
