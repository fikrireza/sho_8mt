<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{
    protected $table = 'fra_iuran';

    protected $fillable = ['id_akad','kode_iuran','tanggal_iuran','keterangan','jenis_pembayaran','img_struk','nilai_iuran','id_aktor'];

    public function akad()
    {
      return $this->belongsTo(Akad::class, 'id_akad');
    }

    public function aktor()
    {
      return $this->belongsTo(User::class, 'id_aktor');
    }
}
