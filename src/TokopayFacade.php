<?php

namespace Oxydaid\Tokopay;

use Illuminate\Support\Facades\Facade;

class Tokopay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tokopay';
    }
}
