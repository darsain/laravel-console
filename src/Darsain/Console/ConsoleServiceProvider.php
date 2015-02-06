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
        if ($this->app['request']->is('console') and $this->app['request']->getMethod() == 'POST')
        {
            $this->app->singleton(
                'Illuminate\Contracts\Debug\ExceptionHandler',
                'Darsain\Console\Handler'
            );
        }

        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('laravel-console.php'),
            __DIR__.'/../../../public/' => base_path('public/packages/darsain/laravel-console'),
        ]);

        $this->mergeConfigFrom(
            __DIR__.'/../../config/config.php', 'laravel-console'
        );

        $this->loadViewsFrom(__DIR__.'/../../views', 'laravel-console');

        $src_path = __DIR__ . '/../../';

        // Routes
        require $src_path . 'routes.php';

        // Attach Console events
        Console::attach();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
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