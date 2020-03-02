<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CreateCsvServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'create_csv',
            'App\Library\CreateCsv'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
