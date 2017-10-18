<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persetujuan extends Model
{
    protected $table = 'fra_persetujuan';

    protected $fillable = ['id_akad','no_persetujuan','tangal_persetujuan','status_persetujuan','keterangan','flag_status','id_aktor'];

    public function akad()
    {
      return $this->belongsTo(Akad::class, 'id_akad');
    }

    public function aktor()
    {
      return $this->belongsTo(User::class, 'id_aktor');
    }
}
