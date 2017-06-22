<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'bmt_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama','avatar','email','password','role_id','id_anggota','id_bmt','confirmed','confirmation_code','login_count'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
  	{
  		return $this->belongsTo('App\Models\Role');
  	}

    public function bmt()
    {
        return $this->belongsTo('App\Models\Bmt', 'id_bmt');
    }
}
