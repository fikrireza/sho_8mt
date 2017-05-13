<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BmtPeserta extends Model
{
    protected $table = 'fra_bmt_peserta';

    protected $fillable = ['bmt_id','tanggal_join','no_ktp','nama','alamat','tempat_lahir','tanggal_lahir',
                            'lokasi_usaha','jenis_usaha','rekening','jumlah_pembiayaan','tanggal_akad','jatuh_tempo',
                            'jangka_waktu','iuran_jiwa','iuran_kebakaran','jumlah_iuran'];


    public function bmt()
    {
      return $this->belongsTo('\App\Models\Bmt');
    }
}
