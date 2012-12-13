<?php

use Laravel\Event;
use Laravel\Database;

class Console
{
	public static $profile = array('queries' => array());

	public static function execute($code)
	{
		// Execute the code
		ob_start();
		$console_render_start = microtime(true);
		eval($code);
		$console_render_end = microtime(true);
		$output = ob_get_clean();

		// Total execution time by queries
		$time_queries = 0;
		foreach (static::$profile['queries'] as $query)
		{
			$time_queries += $query['time'];
		}

		// Extend the profile
		static::$profile += array(
			'memory'       => nice_bytesize(memory_get_usage(true)),
			'memory_peak'  => nice_bytesize(memory_get_peak_usage(true)),
			'time'         => number_format(($console_render_end - $console_render_start) * 1000, 2),
			'time_queries' => number_format($time_queries, 2),
			'time_total'   => number_format((microtime(true) - LARAVEL_START) * 1000, 2),
			'output'       => $output,
			'output_size'  => nice_bytesize(strlen($output)),
		);

		return static::$profile;
	}

	public static function query($sql, $bindings, $time)
	{
		foreach ($bindings as $binding)
		{
			$binding = Database::connection()->pdo->quote($binding);

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
		Event::listen('laravel.query', function($sql, $bindings, $time)
		{
			Console::query($sql, $bindings, $time);
		});
	}
}