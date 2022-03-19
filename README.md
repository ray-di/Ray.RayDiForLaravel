# Ray.Di for Laravel

English | [Japanese](README.ja.md)

In addition to the existing Laravel service container, [Ray.Di](https://ray-di.github.io/manuals/1.0/en/index.html) provides dependency resolution for contoroller. AOP can be applied to all injected objects.

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

## Demo

See [hello-ray-di-for-laravel](https://github.com/koriym/hello-ray-di-for-laravel) demo code.
