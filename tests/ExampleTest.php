<?php

namespace GetriPay\ServiceRegistry\Tests;

use Orchestra\Testbench\TestCase;
use GetriPay\ServiceRegistry\ServiceRegistryServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [ServiceRegistryServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
