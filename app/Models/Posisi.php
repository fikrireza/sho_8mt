<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posisi extends Model
{
    protected $table = 'fra_posisi';

    protected $fillable = ['id_bidang','kode_posisi','nama_posisi','flag_aktif','id_aktor'];

    public function bidang()
    {
      return $this->belongsTo(Bidang::class, 'id_bidang');
    }

    public function aktor()
    {
      return $this->belongsTo(User::class, 'id_aktor');
    }
}
