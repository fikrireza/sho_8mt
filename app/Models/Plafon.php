<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plafon extends Model
{
    protected $table = 'fra_plafon';

    protected $fillable = ['jenis_plafon','jumlah_pembiayaan','bulan','iuran','deskripsi','id_aktor'];

    public function aktor()
    {
      return $this->belongsTo(User::class, 'id_aktor');
    }
}
