<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'bmt_pembayaran';

    protected $fillable = ['no_pembayaran','tanggal_pembayaran','keterangan','jenis_pembayaran',
                          'nilai_pembayaran','id_persetujuan','id_aktor','flag_status'];


    public function persetujuan()
    {
        return $this->belongsTo('App\Models\Persetujuan', 'id_persetujuan');
    }
}
