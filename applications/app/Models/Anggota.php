<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'bmt_anggota';

    protected $fillable = ['kode_anggota','status','id_posisi','nama_anggota','jenis_kelamin','alamat',
                          'kode_pos','no_telp','tempat_lahir','tanggal_lahir','jenis_identitas','no_identitas',
                          'status_pernihakan','pekerjaan','foto','email','id_aktor','flag_status'];

    public function posisi()
    {
        return $this->belongsTo('App\Models\Posisi', 'id_posisi');
    }
}
