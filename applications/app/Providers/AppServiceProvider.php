<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Models\Iuran;
use App\Models\Akad;
use App\Models\Plafon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Start set kode flag_lunas akad menjadi lunas = 1
        $getIuran = Iuran::selectRaw('sum(nilai_iuran) as jumlah_iuran, id_akad')->groupBy('id_akad')->get();

        foreach ($getIuran as $iuran) {
          $set = $iuran->akad->plafon->jumlah_pembiayaan;
          if($iuran->jumlah_iuran >= $set ){
            $status = Akad::find($iuran->id_akad);
            $status->flag_status = 2;
            $status->flag_lunas = 1;
            $status->tanggal_lunas = date('Y-m-d');
            $status->update();
          }
        }
        // End set kode flag_lunas akad menjadi lunas = 1



    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
