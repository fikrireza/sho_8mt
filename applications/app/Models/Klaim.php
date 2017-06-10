<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Klaim extends Model
{
    protected $table = 'bmt_klaim';

    protected $fillable = ['id_anggota','no_permohonan','tanggal_permohonan','alasan_permohonan','keterangan','id_aktor','flag_status'];



}
