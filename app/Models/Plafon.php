<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plafon extends Model
{
    protected $table = 'bmt_plafon';

    protected $fillable = ['jenis_plafon','jumlah_pembiayaan','bulan','iuran','deskripsi','id_aktor','flag_status'];
}
