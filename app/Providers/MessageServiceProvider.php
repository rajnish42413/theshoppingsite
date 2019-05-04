<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MessageService;

class MessageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Contracts\MessageServiceContract', function ($app) {
            return new MessageService();
        });
    }
}
