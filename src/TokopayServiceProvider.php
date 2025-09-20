<?php

namespace Oxydaid\Tokopay;

use Illuminate\Support\ServiceProvider;

class TokopayServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/tokopay.php', 'tokopay');
    }

    public function boot()
    {
        // publish config
        $this->publishes([
            __DIR__ . '/../config/tokopay.php' => config_path('tokopay.php'),
        ], 'config');
    }
}
