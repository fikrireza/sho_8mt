<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    protected $table = 'bmt_bidang';

    protected $fillable = ['kode_bidang','nama_bidang','deskripsi', 'id_aktor','flag_status'];
}
