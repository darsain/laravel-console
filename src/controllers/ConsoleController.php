<?php namespace Darsain\Console;

use Illuminate\Routing\Controller as BaseController;

use View, Input, Response, Session;

class ConsoleController extends BaseController {

	public function getIndex()
	{
		return View::make('console::console');
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