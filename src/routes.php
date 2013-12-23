<?php

use Darsain\Console\Console;

/*
|--------------------------------------------------------------------------
| Error handler
|--------------------------------------------------------------------------
*/

App::error(function (Exception $e, $code) {
	if (App::runningInConsole() or !(Request::url() === 'console' and $_SERVER['REQUEST_METHOD'] === 'POST')) {
		return;
	}
	@ob_end_clean();
	Console::addProfile('error', array(
		'type'    => $code,
		'message' => $e->getMessage(),
		'file'    => $e->getFile(),
		'line'    => $e->getLine(),
	));
	return Response::json(Console::getProfile(), 200);
});

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
*/

Route::group(array('before' => Config::get('laravel-console::filter')), function () {

	Route::get('console',  'Darsain\Console\ConsoleController@getIndex');
	Route::post('console', array(
		'as' => 'console_execute',
		'uses' => 'Darsain\Console\ConsoleController@postExecute'
	));

});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
*/

Route::filter('console_whitelist', function () {

	if (!in_array($_SERVER['REMOTE_ADDR'], Config::get('laravel-console::whitelist'), true))
	{
		App::abort(404);
	}

});
