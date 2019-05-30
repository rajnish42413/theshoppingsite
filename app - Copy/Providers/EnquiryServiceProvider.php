<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\EnquiryService;

class EnquiryServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Contracts\EnquiryServiceContract', function ($app) {
          return new EnquiryService();
        });
    }
}
