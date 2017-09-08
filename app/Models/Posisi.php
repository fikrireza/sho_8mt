<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posisi extends Model
{
    protected $table = 'bmt_posisi';

    protected $fillable = ['kode_posisi','nama_posisi','id_bidang', 'id_aktor','flag_status'];

    public function bidang()
    {
        return $this->belongsTo('App\Models\Bidang', 'id_bidang');
    }
}
