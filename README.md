# Ray.Di for Laravel

English | [Japanese](README.ja.md)

[Ray.Di](https://ray-di.github.io/manuals/1.0/en/index.html) performs dependency resolution for Laravel controllers. It also allows AOP of controllers and dependent objects.

If the controller cannot be created by Ray.Di, an existing Laravel controller factory will create an instance to maintain compatibility.

## Installation

````
composer require ray/ray-di-for-laravel
````

## Use

Copy the module that describes the binding.

```
cp -r vendor/ray/ray-di-for-laravel/Ray app
```

Add the following line to `bootstrap/app.php`.

```php
use App\Ray\Module;
use App\RayRouter;
use Ray\Di\Injector;
```
```php
$app['router'] = new RayRouter($app['events'], $app, new Injector(new Module()));
```
