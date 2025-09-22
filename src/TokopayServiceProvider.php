<?php

namespace Oxydaid\Tokopay;

use Illuminate\Support\ServiceProvider;
use Oxydaid\Tokopay\Tokopay as TokopayService;

class TokopayServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('tokopay', function () {
            return new TokopayService();
        });

        $this->mergeConfigFrom(__DIR__ . '/config/tokopay.php', 'tokopay');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/tokopay.php' => config_path('tokopay.php'),
        ], 'config');
    }
}
