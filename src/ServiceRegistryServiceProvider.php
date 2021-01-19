<?php

namespace GetriPay\ServiceRegistry;

use Illuminate\Support\ServiceProvider;
use GetriPay\ServiceRegistry\Commands\ServiceRegistryPurgeCommand;

class ServiceRegistryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'service-registry');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'service-registry');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('service-registry.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/service-registry'),
            ], 'views');*/

            // Publishing assets.
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/service-registry'),
            ], 'assets');

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/service-registry'),
            ], 'lang');*/

            // Registering package commands.
             $this->commands([
                 ServiceRegistryPurgeCommand::class
             ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'service-registry');

        // Register the main class to use with the facade
        $this->app->singleton('service-registry', function () {
            return new ServiceRegistry;
        });
    }
}
