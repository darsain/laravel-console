# Laravel Console

In-browser console bundle for Laravel PHP framework.

This bundle executes your code within `console::console@post_execute` controller context, and displays the produced output.

The purpose is to easily test stuff without creating garbage routes and controllers just to run something, ...
I'm sure you know what I'm talking about :)

This bundle is meant for local testing, and **shouldn't get nowhere near your production servers!**

## Installation

Install bundle by running this in your Laravel installation root:

```
php artisan bundle:install console
```

Or alternatively in your `bundles` directory, run:

```
git clone git://github.com/Darsain/laravel-console.git console
```

Register the bundle in `application/bundles.php`:

```php
// application/bundles.php
return array(
	...
	'console' => array('handles' => 'console'),
	...
);
```

Than, publish the bundle assets:

```
php artisan bundle:publish console
```

And you are done! Open the console in:

```
yourdomain.com/console
```

## Config

You can override the default config by copying `bundles/console/config/console.php` into `application/config/console.php`
and changing stuff to your liking.

You can mostly ignore the config, but what you should know about is that option `console.whitelist` contains an array
of IP addresses available to access this bundle, and by default contains only `array('127.0.0.1', '::1')`.
That means that this bundle can be run only from local environment.

That said, you shouldn't have this installed on your production servers anyway. I take no responsibility for your laziness :)

## Screenshots

![Index](http://i.imgur.com/bVW31.png)
![Execution](http://i.imgur.com/y3edI.png)

---

#### Credits

* I've used some lines from the awesome [Seldaek/php-console](https://github.com/Seldaek/php-console).
* Editor powered by [marijnh/CodeMirror](https://github.com/marijnh/CodeMirror) with custom theme for Laravel.