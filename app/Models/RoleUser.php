<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class RoleUser extends Authenticatable
{
    protected $table = 'fra_role_users';

    protected $fillable = ['user_id', 'role_id'];
}
