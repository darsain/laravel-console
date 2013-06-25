# Laravel Console

In-browser console for Laravel PHP framework.

This bundle executes your code within `ConsoleController@postExecute` controller context, and displays the produced output.

The purpose is to easily test your stuff without creating garbage routes and controllers just to run something, ...
I'm sure you know what I'm talking about :)

This package is intended for local testing, and **shouldn't get nowhere near your production servers!**

## Screenshots

![Index](http://i.imgur.com/5Cnl5.png)
![Output](http://i.imgur.com/wpx3W.png)
![SQL](http://i.imgur.com/uBmmj.png)

## Installation

### Laravel 4

Installation in Laravel 4 is a breeze, simply add the following into composer.json file :

	"darsain/console": "dev-master"

Run composer update :

	"php composer.phar update"

Add the following service provider into `app/config/app.php` :

	'Darsain\Console\ConsoleServiceProvider'

Publish the assets :

	php artisan asset:publish

And your done, browse to :

	http://yourdomain/console

### Laravel 3 (See tag L3)

[allmyitjason/laravel-console/tree/L3](https://github.com/allmyitjason/laravel-console/tree/L3)

## Config



---

#### Credits

* I've used some lines from the awesome [Seldaek/php-console](https://github.com/Seldaek/php-console).
* Editor powered by [marijnh/CodeMirror](https://github.com/marijnh/CodeMirror) with custom theme for Laravel.
