<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    protected $table = 'fra_bidang';

    protected $fillable = ['kode_bidang','nama_bidang','deskripsi','flag_aktif','id_aktor'];

    public function aktor()
    {
      return $this->belongsTo(User::class, 'id_aktor');
    }
}
