<?php

use Darsain\Console\Console;

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
*/

$group = [];

$middleware = Config::get('console.middleware');

if (! is_null($middleware)) {
	$group['middleware'] = $middleware;
}

Route::group($group, function () {
	Route::get('console',  'Darsain\Console\ConsoleController@getIndex');
	Route::post('console', [
		'middleware' => [],
		'as'         => 'console_execute',
		'uses'       => 'Darsain\Console\ConsoleController@postExecute'
	]);
});
