<?php

namespace Emodyz\Cerberus;

use Emodyz\Cerberus\Http\Middleware\CheckRole;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class CerberusServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @param AuthorizationRegistrar $permissionLoader
     * @return void
     * @throws BindingResolutionException
     */
    public function boot(AuthorizationRegistrar $permissionLoader): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'emodyz');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'emodyz');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $permissionLoader->registerPermissions();

        $this->app->singleton(AuthorizationRegistrar::class, function ($app) use ($permissionLoader) {
            return $permissionLoader;
        });

        // Middlewares
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('cerberus-role', CheckRole::class);
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
    public function provides(): array
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
        ], 'cerberus-config');

        // Publishing the migration files.
        $this->publishes([
            __DIR__.'/../database/migrations' => base_path('database/migrations/emodyz/cerberus'),
        ], 'cerberus-migrations');

        // Publishing the migration files.
        /*$this->publishes([
            __DIR__ . '/../app/Http/Middleware' => base_path('app/Http/Middleware/emodyz/cerberus'),
        ], 'cerberus-middlewares');*/

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
