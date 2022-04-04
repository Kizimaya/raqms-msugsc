<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    protected $table = "college";

	public function user()
	{
	    return $this->belongsTo('App\Models\User');
	}
}
