<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = "token";
    public $timestamps = false;
    
    public function college() 
    {
        return $this->hasOne('App\Models\College', 'id', 'college_id');
    }

    public function counter() 
    {
        return $this->hasOne('App\Models\Counter', 'id', 'counter_id');
    }

    public function officer() 
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function generated_by() 
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function client()
    {
        return $this->hasOne('App\Models\User', 'mobile', 'client_mobile');
    }
}
