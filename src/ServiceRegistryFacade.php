<?php

namespace GetriPay\ServiceRegistry;

use Illuminate\Support\Facades\Facade;

/**
 * @see \GetriPay\ServiceRegistry\Skeleton\SkeletonClass
 */
class ServiceRegistryFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'service-registry';
    }
}
