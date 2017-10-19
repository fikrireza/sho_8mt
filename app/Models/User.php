<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'fra_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'id_bmt', 'id_anggota', 'avatar', 'login_count', 'api_token', 'confirmed'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function bmt()
    {
        return $this->belongsTo(Bmt::class, 'id_bmt');
    }


    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'fra_role_users');
    }

    /**
     *  Cek jika user punya akses ke $permission
     */
    public function hasAccess(array $permissions) : bool
    {
        foreach ($this->roles as $role) {
          if($role->hasAccess($permissions)){
            return true;
          }
        }

        return false;
    }

    /**
     *  Cek jika user punya role
     */
    public function inRole(string $roleSlug)
    {
        return $this->roles()->where('slug', $roleSlug)->count() == 1;
    }
}
