<?php

namespace Realpvz\Services\Facades;

use Illuminate\Support\Facades\Facade;

class Services extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'services';
    }
}
