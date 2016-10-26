# Laravel 5 Console

In-browser console for Laravel 5 PHP framework.

This bundle executes your code within `ConsoleController@postExecute` context, and displays the produced output.

The purpose is to easily test your stuff without creating garbage routes and controllers just to run something, ...
I'm sure you know what I'm talking about :)

This bundle is intended for a local testing, and **shouldn't get nowhere near your production servers!**

## Screenshots

![Index](http://i.imgur.com/SaDPurm.png)
![Output](http://i.imgur.com/YezliAi.png)
![SQL](http://i.imgur.com/BLs7wnW.png)

## Installation

### Laravel 5

Add this into `repositories` and `require-dev` in your `composer.json` file:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/teepluss/laravel-console"
    }
],
"require-dev" : {
	"darsain/laravel-console": "dev-L5"
}
```

Run an update:

```
php composer.phar update
```

Register the console service provider in `config/app.php`:

```php
'providers' => [
	...
	Darsain\Console\ConsoleServiceProvider::class,
];
```

Then publish the bundle assets:

```
php artisan vendor:publish --provider="Darsain\Console\ConsoleServiceProvider"
```

And you are done! Open the console in:

```
yourdomain.com/console
```
