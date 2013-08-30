<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Console routes filter
	|--------------------------------------------------------------------------
	|
	| Set filter used for managing access to the console. By default, filter
	| 'console_whitelist' allows only people from 'whitelist' array below.
	|
	*/

	'filter' => 'console_whitelist',

	/*
	|--------------------------------------------------------------------------
	| Enable console only for this locations
	|--------------------------------------------------------------------------
	|
	| Addresses allowed to access the console. This array is used in
	| 'console_whitelist' route filter. Nevertheless, this bundle should never
	| get nowhere near your production servers, but who am I to tell you how
	| to live your life :)
	|
	*/

	'whitelist' => array('127.0.0.1', '::1'),

);
