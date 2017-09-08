<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{
    protected $table = 'bmt_iuran';

    protected $fillable = ['kode_iuran','tanggal_iuran','keterangan','jenis_pembayaran',
                          'nilai_iuran','id_akad','id_aktor','flag_status'];


    public function akad()
    {
        return $this->belongsTo('App\Models\Akad', 'id_akad');
    }
}
