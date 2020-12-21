<?php

namespace App\Providers;

use App\Contracts\MailerContracts;
use App\Managers\MailManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Register contracts with service class
        $this->app->bind(MailerContracts::class, MailManager::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
