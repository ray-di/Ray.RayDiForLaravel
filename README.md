# Ray.Di for Laravel

English | [Japanese](README.ja.md)

Ray.Di performs dependency resolution for Laravel controllers. It enables AOP for injected objects.

If Ray.Di cannot be created by Ray.Di, the existing Laravel controller factory will create an instance, so there are no compatibility issues.

## Installation

````
composer require ray/ray-di-for-laravel
````

## Use

Copy the module that describes the binding.

```
cp -r vendor/ray/ray-di-for-larabel/Module .
```

Add the following line to `bootstrap/app.php`.

````
$app['router'] = new RayRouter($app['events'], $app, new Injector(new Module()));
```
