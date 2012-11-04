<?php

/**
 * Calculate the human-readable file size (with proper units).
 *
 * @param  int     $size
 * @return string
 */
if (!function_exists('get_file_size'))
{
	function get_file_size($size)
	{
		$units = array('Bytes', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB');
		return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2).' '.$units[$i];
	}
}
