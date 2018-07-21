# Extra context data logging for Laravel 5

This package allows you to add global context data for logging in easy way.

## Status

This package is currently under development. Some parts may change significantly.

## Installation

Add the `tekord/laravel-logman` package in your composer.json and update your dependencies or add it via command 
line:

```
$ composer require tekord/laravel-logman
```

If you are using Laravel < 5.5, you also need to add `Tekord\Logomania\ServiceProvider` to your `config/app.php` providers array:

```
\Tekord\Logomania\ServiceProvider::class,
```

...

TBD

## Usage examples

### Collect context data before request handling

Suppose we want to log incoming request information like request method, URI, user agent and referer. Add the following middleware to your App\Http\Middleware namespace:

```php
<?php
    
namespace App\Http\Middleware;

class WatchWebRequest {
	/**
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 * @param string|null $guard
	 *
	 * @return mixed
	 */
	public function handle($request, \Closure $next, $guard = null) {
		Logman::put('request', [
			'method' => $_SERVER['REQUEST_METHOD'],
			'uri' => $_SERVER['REQUEST_URI'],
			'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null,
			'referer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null
		]);

		return $next($request);
	}
}
```

Add it to Kernel's middleware list:

```php
protected $middleware = [
	...
	\App\Http\Middleware\WatchWebRequest::class,
];
```

Go to \App\Exceptions\Handler class and override the `context` method like this:

```php
protected function context() {
	try {
        $context = \Tekord\Logman\Facades\Logman::getContextWith([
            // put additional custom context records here if you want
        ]);
	} catch (\Throwable $e) {
		$context = [];
	}

	return array_merge($context, parent::context());
}
```

Now if something goes wrong you will see helpful request information in error log files.

### Collect context data before controller's action execution

Add the following code to your controller class:

```php
public function callAction($method, $parameters) {
	Logman::put('request', [
		'method' => $_SERVER['REQUEST_METHOD'],
		'uri' => $_SERVER['REQUEST_URI'],
		'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null,
		'referer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null
	]);

	return parent::callAction($method, $parameters);
}
```
