<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akad extends Model
{
    protected $table = 'bmt_akad';

    protected $fillable = ['id_plafon','id_anggota','kode_akad','tanggal_akad','keterangan',
                          'jenis_pembayaran','id_aktor','flag_status','approved_by','approved_date','flag_lunas','tanggal_lunas'];


    public function anggota()
    {
        return $this->belongsTo('App\Models\Anggota', 'id_anggota');
    }

    public function plafon()
    {
        return $this->belongsTo('App\Models\Plafon', 'id_plafon');
    }

    public function approveBy()
    {
        return $this->belongsTo('App\Models\Anggota', 'approved_by');
    }
}
