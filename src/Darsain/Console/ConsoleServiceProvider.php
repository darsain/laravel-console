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
		$this->package('darsain/console');

		//Include the routes
		include __DIR__ . '/../../routes.php';
		//Include helper file
		include __DIR__ . '/../../helpers.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		/*
		|--------------------------------------------------------------------------
		| Set console config
		|--------------------------------------------------------------------------
		*/

		/*$this->app['config']->set('application.profiler', false);
		$this->app['config']->set('error.detail', false);
		$this->app['config']->set('error.log', false);*/

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