<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAkses extends Model
{
    protected $table = 'fra_log_akses';

    protected $fillable = ['aksi','id_aktor'];

    public function aktor()
    {
      return $this->belongsTo(User::class, 'id_aktor');
    }
}
