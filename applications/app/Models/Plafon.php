<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plafon extends Model
{
    protected $table = 'bmt_plafon';

    protected $fillable = ['no_plafon','besar','deskripsi','id_aktor','flag_status'];
}
