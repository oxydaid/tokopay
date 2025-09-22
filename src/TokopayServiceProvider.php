<?php

namespace Oxydaid\Tokopay;

use Illuminate\Support\ServiceProvider;

class TokopayServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('tokopay', function () {
            return new Tokopay();
        });

        $this->mergeConfigFrom(__DIR__ . '/../config/tokopay.php', 'tokopay');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/tokopay.php' => config_path('tokopay.php'),
        ], 'config');
    }
}
