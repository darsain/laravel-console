<?php

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
*/

Route::group(array('before' => 'whitelist'), function () {

	Route::get('(:bundle)',          'console::console@index');
	Route::post('(:bundle)/execute', 'console::console@execute');

});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
*/

Route::filter('whitelist', function() {

	if (!in_array($_SERVER['REMOTE_ADDR'], Config::get('console.whitelist', Config::get('console::console.whitelist')), true))
	{
		return Response::error('500');
	}

});
