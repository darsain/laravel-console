<?php namespace Darsain\Console;

use \Controller, \View, \Input, \App, \Response;

class ConsoleController extends Controller {

	public $restful = true;

	public function getIndex()
	{
		return View::make('console::console');
	}

	public function postExecute()
	{
		$code = Input::get('code');

		// replace newlines in the entire code block by the new specified one
		// i.e. put #\r\n on the first line to emulate a file with windows line
		// endings if you're on a unix box
		if (preg_match('{#((?:\\\\[rn]){1,2})}', $code, $m)) {
			$newLineBreak = str_replace(array('\\n', '\\r'), array("\n", "\r"), $m[1]);
			$code = preg_replace('#(\r?\n|\r\n?)#', $newLineBreak, $code);
		}

		// Execute and profile the code
		$profile = Console::execute($code);

		// Response
		return Response::json($profile);
	}

}