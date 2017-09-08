<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'bmt_anggota';

    protected $fillable = ['kode_anggota','id_posisi','id_bmt','nama_anggota','jenis_kelamin','alamat',
                          'kode_pos','no_telp','tempat_lahir','tanggal_lahir','jenis_usaha','lokasi_usaha','no_ktp',
                          'status_pernikahan','foto','email','id_aktor','flag_status'];

    public function posisi()
    {
        return $this->belongsTo('App\Models\Posisi', 'id_posisi');
    }

    public function bmt()
    {
        return $this->belongsTo('App\Models\Bmt', 'id_bmt');
    }
}
