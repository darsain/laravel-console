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
        $configPath = __DIR__.'/../../config/config.php';
        $publicPath = __DIR__.'/../../../public';

        // Publish config.
        $this->publishes([
            $configPath => config_path('console.php'),
            $publicPath => base_path('public/packages/darsain/console'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app['request']->is('console') and $this->app['request']->getMethod() == 'POST')
        {
            $this->app->singleton(
                'Illuminate\Contracts\Debug\ExceptionHandler',
                'Darsain\Console\Handler'
            );
        }

        $configPath = __DIR__.'/../../config/config.php';
        $routePath = __DIR__ . '/../../routes.php';
        $viewPath = __DIR__.'/../../views';


        $this->mergeConfigFrom($configPath, 'console');

        $this->loadViewsFrom($viewPath, 'console');

        // Routes
        require $routePath;

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