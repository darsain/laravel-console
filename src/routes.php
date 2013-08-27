<?php

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
*/

Route::group(array('before' => Config::get('console.filter', Config::get('console::filter'))), function () {

	Route::get('/console',          'Darsain\Console\ConsoleController@getIndex');
	Route::post('/console/execute', array('as' => 'execute', 'uses' =>  'Darsain\Console\ConsoleController@postExecute'));

});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
*/

Route::filter('console_whitelist', function() {

	if (!in_array($_SERVER['REMOTE_ADDR'], Config::get('console.whitelist', Config::get('console::whitelist')), true))
	{
		\App::abort(401, 'You are not authorized.');
	}

});
