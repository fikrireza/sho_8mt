<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bmt extends Model
{
    protected $table = 'fra_bmt';

    protected $fillable = ['no_induk_bmt','nama_bmt','alamat_bmt','mpd_bmt','mpw_bmt','telp_bmt','nama_kontak_bmt','nomor_kontak_bmt',
                        'email_bmt','flag_aktif','id_aktor'];

    public function aktor()
    {
      return $this->belongsTo(User::class, 'id_aktor');
    }
}
