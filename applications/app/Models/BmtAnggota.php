<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BmtAnggota extends Model
{
    protected $table = 'fra_bmt_anggota';

    protected $fillable = ['bmt_id','no_ktp','nama','alamat','tempat_lahir','tanggal_lahir',
                          'lokasi_usaha','jenis_usaha','flag_status'];


    public function bmt()
    {
      return $this->belongsTo('App\Models\Bmt');
    }

}
