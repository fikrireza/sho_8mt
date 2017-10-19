<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->registerBidangPolicies();
        $this->registerPosisiPolicies();
        $this->registerPlafonPolicies();
        $this->registerDaftarPolicies();
        $this->registerAnggotaPolicies();
        $this->registerAkadPolicies();
        $this->registerPembayaranPolicies();
        $this->registerKlaimPolicies();
        $this->registerJurnalPolicies();
        $this->registerLogAksesPolicies();
        $this->registerUsersPolicies();
    }

    public function registerBidangPolicies()
    {
        Gate::define('read-bidang', function($user){
          return $user->hasAccess(['read-bidang']);
        });

        Gate::define('create-bidang', function($user){
          return $user->hasAccess(['create-bidang']);
        });

        Gate::define('update-bidang', function($user){
          return $user->hasAccess(['update-bidang']);
        });

        Gate::define('publish-bidang', function($user){
          return $user->hasAccess(['publish-bidang']);
        });
    }

    public function registerPosisiPolicies()
    {
        Gate::define('read-posisi', function($user){
          return $user->hasAccess(['read-posisi']);
        });

        Gate::define('create-posisi', function($user){
          return $user->hasAccess(['create-posisi']);
        });

        Gate::define('update-posisi', function($user){
          return $user->hasAccess(['update-posisi']);
        });

        Gate::define('publish-posisi', function($user){
          return $user->hasAccess(['publish-posisi']);
        });
    }

    public function registerPlafonPolicies()
    {
        Gate::define('read-plafon', function($user){
          return $user->hasAccess(['read-plafon']);
        });

        Gate::define('create-plafon', function($user){
          return $user->hasAccess(['create-plafon']);
        });

        Gate::define('update-plafon', function($user){
          return $user->hasAccess(['update-plafon']);
        });

        Gate::define('publish-plafon', function($user){
          return $user->hasAccess(['publish-plafon']);
        });
    }

    public function registerDaftarPolicies()
    {
        Gate::define('read-daftar', function($user){
          return $user->hasAccess(['read-daftar']);
        });

        Gate::define('create-daftar', function($user){
          return $user->hasAccess(['create-daftar']);
        });

        Gate::define('update-daftar', function($user){
          return $user->hasAccess(['update-daftar']);
        });
    }

    public function registerAnggotaPolicies()
    {
        Gate::define('read-anggota', function($user){
          return $user->hasAccess(['read-anggota']);
        });

        Gate::define('create-anggota', function($user){
          return $user->hasAccess(['create-anggota']);
        });

        Gate::define('update-anggota', function($user){
          return $user->hasAccess(['update-anggota']);
        });

        Gate::define('publish-anggota', function($user){
          return $user->hasAccess(['publish-anggota']);
        });
    }

    public function registerAkadPolicies()
    {
        Gate::define('read-akad', function($user){
          return $user->hasAccess(['read-akad']);
        });

        Gate::define('create-akad', function($user){
          return $user->hasAccess(['create-akad']);
        });

        Gate::define('approve-akad', function($user){
          return $user->hasAccess(['approve-akad']);
        });
    }

    public function registerPembayaranPolicies()
    {
        Gate::define('read-pembayaran', function($user){
          return $user->hasAccess(['read-pembayaran']);
        });

        Gate::define('create-pembayaran', function($user){
          return $user->hasAccess(['create-pembayaran']);
        });

        Gate::define('delete-pembayaran', function($user){
          return $user->hasAccess(['delete-pembayaran']);
        });

    }

    public function registerKlaimPolicies()
    {
        Gate::define('read-klaim', function($user){
          return $user->hasAccess(['read-klaim']);
        });

        Gate::define('create-klaim', function($user){
          return $user->hasAccess(['create-klaim']);
        });
    }

    public function registerJurnalPolicies()
    {
        Gate::define('read-jurnal', function($user){
          return $user->hasAccess(['read-jurnal']);
        });
    }

    public function registerLogAksesPolicies()
    {
        Gate::define('read-logakses', function($user){
          return $user->hasAccess(['read-logakses']);
        });
    }

    public function registerUsersPolicies()
    {
        Gate::define('read-user', function($user){
          return $user->hasAccess(['read-user']);
        });
        Gate::define('create-user', function($user){
          return $user->hasAccess(['create-user']);
        });
        Gate::define('update-user', function($user){
          return $user->hasAccess(['update-user']);
        });
        Gate::define('reset-user', function($user){
          return $user->hasAccess(['reset-user']);
        });
        Gate::define('activate-user', function($user){
          return $user->hasAccess(['activate-user']);
        });
        Gate::define('read-role', function($user){
          return $user->hasAccess(['read-role']);
        });
        Gate::define('create-role', function($user){
          return $user->hasAccess(['create-role']);
        });
        Gate::define('update-role', function($user){
          return $user->hasAccess(['update-role']);
        });
        Gate::define('management-user', function($user){
          return $user->inRole('administrator');
        });
        Gate::define('management-role', function($user){
          return $user->inRole('administrator');
        });
    }
}
