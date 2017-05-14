<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bmt extends Model
{
    protected $table = 'fra_bmt';

    protected $fillable = ['no_induk','nama','alamat','mpd','mpw','telp','nama_kontak','nomor_kontak','email','aktor','flag_status'];


    public function anggota()
    {
      return $this->hasMany('App\Models\BmtAnggota');
    }

    public function peserta()
    {
      return $this->hasMany('App\Models\BmtPeserta');
    }
}
