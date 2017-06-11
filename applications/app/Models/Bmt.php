<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bmt extends Model
{
    protected $table = 'bmt_bmt';

    protected $fillable = ['no_induk_bmt','nama_bmt','alamat_bmt','mpd_bmt','mpw_bmt','telp_bmt',
                            'nama_kontak_bmt','nomor_kontak_bmt','email_bmt','flag_status'];

    public function anggota()
    {
        return $this->hasMany('App\Models\Anggota');
    }
}
