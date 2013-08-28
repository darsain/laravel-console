# Laravel Console

In-browser console bundle for Laravel 3 PHP framework.

This bundle executes your code within `console::Console@post_execute` controller context, and displays the produced output.

The purpose is to easily test your stuff without creating garbage routes and controllers just to run something, ...
I'm sure you know what I'm talking about :)

This bundle is intended for a local testing, and **shouldn't get nowhere near your production servers!**

## Screenshots

![Index](http://i.imgur.com/5Cnl5.png)
![Output](http://i.imgur.com/wpx3W.png)
![SQL](http://i.imgur.com/uBmmj.png)

## Installation

Navigate to your `bundles` directory, and run this command:

```
git clone --depth=1 -b L3 https://github.com/Darsain/laravel-console.git console && rm -rf -- console/.git
```

Or download [manually from here](https://github.com/Darsain/laravel-console/archive/L3.zip), and unzip into the `console` folder.

Register the bundle in `application/bundles.php`:

```php
// application/bundles.php
return array(
	...
	'console' => array('handles' => 'console'),
	...
);
```

Than publish the bundle assets:

```
php artisan bundle:publish console
```

And you are done! Open the console in:

```
yourdomain.com/console
```

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