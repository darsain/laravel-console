<?php namespace Darsain\Console;

use \Controller, \View, \Input, \App, \Response, \Route;

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

		// Response
		return Response::json($profile);
	}

}