<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Klaim extends Model
{
    protected $table = 'fra_klaim';

    protected $fillable = ['id_akad','no_permohonan','tanggal_musibah','keterangan_musibah','sisa_bayar','total_bayar',
                          'flag_status','id_aktor'];


    public function akad()
    {
      return $this->belongsTo(Akad::class, 'id_akad');
    }

    public function aktor()
    {
      return $this->belongsTo(User::class, 'id_aktor');
    }
}
