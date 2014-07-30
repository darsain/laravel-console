# Laravel 4 Console

In-browser console for Laravel 4 PHP framework.

This bundle executes your code within `ConsoleController@postExecute` context, and displays the produced output.

The purpose is to easily test your stuff without creating garbage routes and controllers just to run something, ...
I'm sure you know what I'm talking about :)

This bundle is intended for a local testing, and **shouldn't get nowhere near your production servers!**

## Screenshots

![Index](http://i.imgur.com/SaDPurm.png)
![Output](http://i.imgur.com/YezliAi.png)
![SQL](http://i.imgur.com/BLs7wnW.png)

## Installation

### Laravel 4

Add this into `require-dev` in your `composer.json` file:

```
"require-dev" : {
	...
	"darsain/laravel-console": "dev-master"
}
```

Run an update:

```
php composer.phar update
```

Register the console service provider in `app/config/app.php`:

```php
'providers' => array(
	...
	'Darsain\Console\ConsoleServiceProvider',
);
```

Then publish the bundle assets:

```
php artisan asset:publish
```

And you are done! Open the console in:

```
yourdomain.com/console
```

### Laravel 3

Laravel 3 version along with installation process can be found in the [L3 branch](https://github.com/Darsain/laravel-console/tree/L3).
