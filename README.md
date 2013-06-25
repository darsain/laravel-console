# Laravel Console

In-browser console for Laravel PHP framework.

This bundle executes your code within `ConsoleController@postExecute` controller context, and displays the produced output.

The purpose is to easily test your stuff without creating garbage routes and controllers just to run something, ...
I'm sure you know what I'm talking about :)

This bundle is intended for local testing, and **shouldn't get nowhere near your production servers!**

## Screenshots

![Index](http://i.imgur.com/5Cnl5.png)
![Output](http://i.imgur.com/wpx3W.png)
![SQL](http://i.imgur.com/uBmmj.png)

## Installation

### Laravel 4

Installation in Laravel 4 is a breeze, simply add the following into composer.json file :

	"allmyitjason/laravel-console": "dev-master"

Add the following service provider into `app/config/app.php` :

	'Darsain\Console\ConsoleServiceProvider'

Publish the assets :

	php artisan asset:publish

And your done, browse to :

	http://localhost/console

### Laravel 3 (See tag L3)

[allmyitjason/laravel-console/tree/L3](https://github.com/allmyitjason/laravel-console/tree/L3)

## Config

You can override the default config by copying `bundles/console/config/console.php` into `application/config/console.php`
(or to your dev/local environment subdirectory) and changing it to your liking.

You can mostly ignore the config, but what you should know about is that option `console.filter` sets the name of
a route filter used to controll access to the console. By default `console_whitelist` filter uses
the `console.whitelist` array (`array('127.0.0.1', '::1')`) to allow only localhost usage.
You can change the filter, or the whitelist array to whatever you want, but not having this bundle on production
servers should be a no-brainer :)

---

#### Credits

* I've used some lines from the awesome [Seldaek/php-console](https://github.com/Seldaek/php-console).
* Editor powered by [marijnh/CodeMirror](https://github.com/marijnh/CodeMirror) with custom theme for Laravel.
