<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    protected $table = 'fra_jurnal';

    protected $fillable = ['id_akad','id_iuran','tanggal_jurnal','keterangan_jurnal','jumlah','jenis_jurnal','id_aktor'];

    public function akad()
    {
      return $this->belongsTo(Akad::class, 'id_akad');
    }

    public function iuran()
    {
      return $this->belongsTo(Iuran::class, 'id_iuran');
    }

    public function aktor()
    {
      return $this->belongsTo(User::class, 'id_aktor');
    }
}
