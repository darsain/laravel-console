<?php namespace Darsain\Console;

use \Controller, \View, \Input, \Response;

class ConsoleController extends Controller {

	public function getIndex()
	{
		return View::make('laravel-console::console');
	}

	public function postExecute()
	{
		$code = Input::get('code');

		// Execute and profile the code
		$profile = Console::execute($code);

		// Terminate on error, as Error Handler already responded.
		if (isset($profile['error']) and $profile['error']) {
			exit;
		}

		// Response
		return Response::json($profile);
	}

}