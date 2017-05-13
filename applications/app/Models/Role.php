<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'fra_roles';

    protected $fillable = ['title','slug'];

    public function users()
  	{
  	  return $this->hasMany('App\Models\User');
  	}
}
