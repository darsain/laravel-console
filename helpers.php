<?php

/**
 * Calculate the human-readable file size (with proper units).
 *
 * @param  int     $size
 * @return string
 */
function nice_bytesize($size)
{
	$units = array('Bytes', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB');
	return @round($size / pow(1024, ($i = max(floor(log($size, 1024)), 0))), 2).' '.$units[$i];
}
