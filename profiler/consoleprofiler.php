<?php

use Laravel\Event;
use Laravel\Database;

class ConsoleProfiler
{
	protected static $data = array('queries' => array());

	public static function render($code)
	{
		ob_start();
		$console_profiler_timer_start = microtime(true);
		eval($code);
		$console_profiler_timer_end = microtime(true);
		$output = ob_get_clean();

		static::$data['memory'] = get_file_size(memory_get_usage(true));
		static::$data['memory_peak'] = get_file_size(memory_get_peak_usage(true));
		static::$data['time'] = number_format(($console_profiler_timer_end - $console_profiler_timer_start) * 1000, 2);
		static::$data['time_total'] = number_format((microtime(true) - LARAVEL_START) * 1000, 2);
		static::$data['output'] = $output;
		static::$data['query_output'] = render('path: '.__DIR__.'/template'.BLADE_EXT, static::$data);

		return static::$data;
	}

	public static function query($sql, $bindings, $time)
	{
		foreach ($bindings as $binding)
		{
			$binding = Database::connection()->pdo->quote($binding);

			$sql = preg_replace('/\?/', $binding, $sql, 1);
			$sql = htmlspecialchars($sql);
		}

		static::$data['queries'][] = array($sql, $time);
	}

	public static function attach()
	{
		Event::listen('laravel.query', function($sql, $bindings, $time)
		{
			ConsoleProfiler::query($sql, $bindings, $time);
		});
	}
}
