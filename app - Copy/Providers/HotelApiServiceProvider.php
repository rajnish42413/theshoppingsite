<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\HotelApiService;

class HotelApiServiceProvider extends ServiceProvider
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
      $this->app->bind('App\Contracts\HotelApiServiceContract', function ($app) {
          return new HotelApiService();
      });
    }
}
