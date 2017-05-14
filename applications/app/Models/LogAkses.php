<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAkses extends Model
{
    protected $table = 'fra_log_akses';

    protected $fillable = ['aksi','aktor'];
}
