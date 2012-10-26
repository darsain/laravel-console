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
		Asset::container('header')->add('normalize', 'css/normalize.css');
		Asset::container('header')->add('main', 'css/main.css', 'normalize');
		Asset::container('header')->add('codemirror', 'css/codemirror/codemirror.css');
		Asset::container('header')->add('codemirror-theme', 'css/codemirror/theme/'.Config::get('console.theme', Config::get('console::console.theme')).'.css', 'codemirror');

		/* Scripts */
		Asset::container('footer')->add('modernizr', 'js/vendor/modernizr.js');

		Asset::container('footer')->add('jquery', 'js/vendor/jquery.min.js');
		Asset::container('footer')->add('plugins', 'js/vendor/plugins.js', 'jquery');

		Asset::container('footer')->add('codemirror', 'js/vendor/codemirror.js');
		// Asset::container('footer')->add('codemirror-xml', 'js/vendor/mode/xml.js', 'codemirror');
		// Asset::container('footer')->add('codemirror-javascript', 'js/vendor/mode/javascript.js', 'codemirror');
		// Asset::container('footer')->add('codemirror-css', 'js/vendor/mode/css.js', 'codemirror');
		Asset::container('footer')->add('codemirror-clike', 'js/vendor/mode/clike.js', 'codemirror');
		Asset::container('footer')->add('codemirror-php', 'js/vendor/mode/php.js', 'codemirror');

		Asset::container('footer')->add('main', 'js/main.js', array('jquery', 'plugins', 'codemirror'));

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

		// Execute and profile the time
		ob_start();
		$start = microtime(true);
		eval($code);
		$end = microtime(true);
		$output = ob_get_clean();

		// Response
		return Response::json(array(
			'time'        => number_format(($end - $start) * 1000, 2),
			'time_total'  => number_format((microtime(true) - LARAVEL_START) * 1000, 2),
			'memory'      => get_file_size(memory_get_usage(true)),
			'memory_peak' => get_file_size(memory_get_peak_usage(true)),
			'output'      => $output
		));
	}

}