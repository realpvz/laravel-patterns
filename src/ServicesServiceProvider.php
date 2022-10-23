<?php

namespace Realpvz\Services;

use Illuminate\Support\ServiceProvider;
use Realpvz\Services\Commands\MakeServiceCommand;

class ServicesServiceProvider extends ServiceProvider
{
    private array $commandName = [
        MakeServiceCommand::class
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/Stubs' => base_path('/stubs')
        ]);

        $this->commands($this->commandName);

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/services.php', 'services');

        // Register the service the package provides.
        $this->app->singleton('services', function ($app) {
            return new Services;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['services'];
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
            __DIR__.'/../config/services.php' => config_path('services.php'),
        ], 'services.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/realpvz'),
        ], 'services.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/realpvz'),
        ], 'services.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/realpvz'),
        ], 'services.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
