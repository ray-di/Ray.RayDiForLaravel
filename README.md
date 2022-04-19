# Ray.Di for Laravel

English | [Japanese](README.ja.md)

In addition to the existing Laravel service container, [Ray.Di](https://ray-di.github.io/manuals/1.0/en/index.html) provides dependency resolution. AOP can be applied to all injected objects.

## Installation

````
composer require ray/ray-di-for-laravel
````

## Use

Copy the module that describes the binding.

```
cp -r vendor/ray/ray-di-for-laravel/Ray app
```

Change the following lines in `bootstrap/app.php`.

```diff
- $app = new Illuminate\Foundation\Application(
-     $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
- );
+ $app = new Ray\RayDiForLaravel\Application(
+     $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__),
+     new Ray\Di\Injector(new App\Ray\Module())
+ );
```

Add the `Ray\RayDiForLaravel\Attribute\Injectable` Attribute to classes or interfaces you want to resolve by Ray.Di.


This class will be resolved by Ray.Di.
```php
<?php

namespace App\Http\Controllers;

use Ray\RayDiForLaravel\Attribute\Injectable;

#[Injectable]
class HelloController extends Controller
{

}
```

This one will be resolved by the existing Laravel service container.

```php
<?php

namespace App\Http\Controllers;

// no attributes
class MyController extends Controller
{

}
```

## Demo

See [hello-ray-di-for-laravel](https://github.com/koriym/hello-ray-di-for-laravel) demo code.
