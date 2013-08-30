<?php namespace Darsain\Console;

use \Event, \DB;

class Console
{
	public static $error_map = array(
		E_ERROR => 'E_ERROR',
		E_WARNING => 'E_WARNING',
		E_PARSE => 'E_PARSE',
		E_NOTICE => 'E_NOTICE',
		E_CORE_ERROR => 'E_CORE_ERROR',
		E_CORE_WARNING => 'E_CORE_WARNING',
		E_COMPILE_ERROR => 'E_COMPILE_ERROR',
		E_COMPILE_WARNING => 'E_COMPILE_WARNING',
		E_USER_ERROR => 'E_USER_ERROR',
		E_USER_WARNING => 'E_USER_WARNING',
		E_USER_NOTICE => 'E_USER_NOTICE',
		E_STRICT => 'E_STRICT',
		E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
		E_DEPRECATED => 'E_DEPRECATED',
		E_USER_DEPRECATED => 'E_USER_DEPRECATED',
		E_ALL => 'E_ALL',
	);
	public static $profile = array(
		'queries' => array(),
		'memory'       => 0,
		'memory_peak'  => 0,
		'time'         => 0,
		'time_queries' => 0,
		'time_total'   => 0,
		'output'       => '',
		'output_size'  => 0,
		'error'        => false
	);

	public static function getProfile($profile)
	{
		// Total execution time by queries
		$time_queries = 0;
		foreach (static::$profile['queries'] as $query)
		{
			$time_queries += $query['time'];
		}

		// Extend the profile with new data
		static::$profile = array_merge(static::$profile, array(
			'memory'       => memory_get_usage(true),
			'memory_peak'  => memory_get_peak_usage(true),
			'time_queries' => number_format($time_queries, 2),
			'time_total'   => number_format((microtime(true) - LARAVEL_START) * 1000, 2),
		), $profile);

		// Set human readable error type
		if (isset($profile['error']['type']) and isset(static::$error_map[$profile['error']['type']])) {
			$profile['error']['type'] = static::$error_map[$profile['error']['type']];
		}

		return static::$profile;
	}

	public static function execute($code)
	{
		$profile = array();

		// Execute the code
		ob_start();
		$console_execute_start = microtime(true);
		$estatus = @eval($code);
		$console_execute_end = microtime(true);
		$output = ob_get_contents();
		ob_end_clean();

		// Retrieve an error
		if ($estatus === false) {
			$profile['error'] = error_get_last();
		}

		// Extend the profile
		$profile += array(
			'time'        => number_format(($console_execute_end - $console_execute_start) * 1000, 2),
			'output'      => $output,
			'output_size' => strlen($output)
		);

		return static::getProfile($profile);
	}

	public static function query($sql, $bindings, $time)
	{
		foreach ($bindings as $binding)
		{
			$binding = DB::connection()->getPdo()->quote($binding);

			$sql = preg_replace('/\?/', $binding, $sql, 1);
			$sql = htmlspecialchars($sql);
		}

		static::$profile['queries'][] = array(
			'query' => $sql,
			'time'  => $time
		);
	}

	public static function attach()
	{
		Event::listen('illuminate.query', function($sql, $bindings, $time)
		{
			Console::query($sql, $bindings, $time);
		});
	}
}