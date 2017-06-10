<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persetujuan extends Model
{
    protected $table = 'bmt_persetujuan';

    protected $fillable = ['no_persetujuan','tangal_persetujuan','keterangan','id_akad','status_akad','id_anggota','id_aktor','flag_status'];

    public function akad()
    {
        return $this->belongsTo('App\Models\Akad', 'id_akad');
    }

    public function anggota()
    {
        return $this->belongsTo('App\Models\Anggota', 'id_anggota');
    }
}
