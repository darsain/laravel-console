<?php namespace Darsain\Console;

use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config.
        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('console.php'),
            __DIR__.'/../../../public' => base_path('public/vendor/darsain/console'),
        ], 'public');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app['request']->is('console') and $this->app['request']->getMethod() == 'POST') {
            $this->app->bind(
                'Illuminate\Contracts\Debug\ExceptionHandler',
                'Darsain\Console\Handler'
            );
        }

        $this->mergeConfigFrom(
            __DIR__.'/../../config/config.php', 'console'
        );

        $this->loadViewsFrom(
            __DIR__.'/../../views', 'console'
        );

        $this->publishes([
            __DIR__.'/../../views' => resource_path('views/vendor/console'),
        ], 'view');

        if (! $this->app->routesAreCached()) {
            require __DIR__ . '/../../routes.php';
        }

        // Attach Console events
        Console::attach();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}
