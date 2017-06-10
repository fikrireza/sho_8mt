<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akad extends Model
{
    protected $table = 'bmt_akad';

    protected $fillable = ['id_plafon','id_anggota','no_akad','nama_akad','tanggal_akad','keterangan',
                          'jenis_pembayaran','lama_pembayaran','id_aktor','flag_status'];


    public function anggota()
    {
        return $this->belongsTo('App\Models\Anggota', 'id_anggota');
    }

    public function plafon()
    {
        return $this->belongsTo('App\Models\Plafon', 'id_plafon');
    }
}
