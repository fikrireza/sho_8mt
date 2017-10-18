<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'fra_anggota';

    protected $fillable = ['kode_anggota','id_posisi','id_bmt','nama_anggota','jenis_kelamin','alamat','kode_pos','no_telp',
                            'tempat_lahir','tanggal_lahir','jenis_usaha','lokasi_usaha','no_ktp','status_pernikahan',
                            'foto','email','flag_aktif','id_aktor'];

    public function bmt()
    {
      return $this->belongsTo(Bmt::class, 'id_bmt');
    }

    public function posisi()
    {
      return $this->belongsTo(Posisi::class, 'id_posisi');
    }

    public function aktor()
    {
      return $this->belongsTo(User::class, 'id_aktor');
    }
}
