<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akad extends Model
{
    protected $table = 'fra_akad';

    protected $fillable = ['kode_akad','id_plafon','id_anggota','tanggal_akad','keterangan','jenis_pembayaran',
                      'approved_by','approved_date','tanggal_lunas','flag_status','id_aktor'];


    public function anggota()
    {
      return $this->belongsTo(Anggota::class, 'id_anggota');
    }

    public function aktor()
    {
      return $this->belongsTo(User::class, 'id_aktor');
    }

    public function plafon()
    {
      return $this->belongsTo(Plafon::class, 'id_plafon');
    }

    public function approveBy()
    {
      return $this->belongsTo(User::class, 'approved_by');
    }
}
