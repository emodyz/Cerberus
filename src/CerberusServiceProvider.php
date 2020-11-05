<?php

namespace Emodyz\Cerberus;

use Illuminate\Support\ServiceProvider;

class CerberusServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @param AuthorizationRegistrar $permissionLoader
     * @return void
     */
    public function boot(AuthorizationRegistrar $permissionLoader): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'emodyz');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'emodyz');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $permissionLoader->registerPermissions();

        $this->app->singleton(AuthorizationRegistrar::class, function ($app) use ($permissionLoader) {
            return $permissionLoader;
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/cerberus.php', 'cerberus');

        // Register the service the package provides.
        $this->app->singleton('cerberus', function ($app) {
            return new Cerberus();
        });

        // $this->app->alias(Cerberus::class, 'cerberus');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['cerberus'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/cerberus.php' => config_path('cerberus.php'),
        ], 'cerberus.config');

        // Publishing the migration files.
        $this->publishes([
            __DIR__.'/../database/migrations' => base_path('database/migrations/emodyz/cerberus'),
        ], 'cerberus.migrations');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/emodyz/cerberus'),
        ], 'cerberus.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/emodyz/cerberus'),
        ], 'cerberus.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/emodyz/cerberus'),
        ], 'cerberus.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
