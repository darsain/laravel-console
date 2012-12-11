<?php

class Console_Console_Controller extends Controller {

	public $restful = true;

	public function __construct()
	{
		// Assets
		// ---------------------------------------------------------
		Asset::container('header')->bundle('console');
		Asset::container('footer')->bundle('console');

		/* Styles */
		Asset::container('header')
			->add('normalize', 'css/normalize.css')
			->add('main', 'css/main.css', 'normalize')
			->add('codemirror', 'css/codemirror/codemirror.css')
			->add('codemirror-theme', 'css/codemirror/theme/'.Config::get('console.theme', Config::get('console::console.theme')).'.css', 'codemirror');

		/* Scripts */
		Asset::container('header')->add('modernizr', 'js/vendor/modernizr.js');

		Asset::container('footer')
			->add('jquery', 'js/vendor/jquery.min.js')
			->add('plugins', 'js/vendor/plugins.js', 'jquery')

			->add('codemirror', 'js/vendor/codemirror.js')
			->add('codemirror-clike', 'js/vendor/mode/clike.js', 'codemirror')
			->add('codemirror-php', 'js/vendor/mode/php.js', 'codemirror')

			->add('main', 'js/main.js', array('jquery', 'plugins', 'codemirror'));

		parent::__construct();
	}

	public function get_index()
	{
		return View::make('console::layouts.console');
	}

	public function post_execute()
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