<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    protected $table = 'bmt_jurnal';

    protected $fillable = ['id_iuran','tanggal_iuran','keterangan','jumlah','id_aktor'];

    public function akad()
    {
        return $this->belongsTo('App\Models\Akad', 'id_akad');
    }
}
