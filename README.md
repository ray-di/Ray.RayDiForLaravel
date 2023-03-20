# Ray.Di for Laravel
## DI+AOP, done the right way

English | [Japanese](README.ja.md)

## Installation

````
composer require ray/ray-di-for-laravel
````

## Use

Copy the module that describes the binding, the context, and the directory where the generated files will be stored.

```
cp -r vendor/ray/ray-di-for-laravel/RayDi app
cp -r vendor/ray/ray-di-for-laravel/storage/ storage
```

Change the following lines in `bootstrap/app.php`.

```diff
+ $basePath = $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__);
+ $context = getenv('APP_ENV') ?: 'local';
- $app = new Illuminate\Foundation\Application(
-     $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
- );
+ $app = new Ray\RayDiForLaravel\Application(
+     $basePath,
+     App\RayDi\Context\ContextProvider::get($basePath, $context)
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

## Context

The `RayDi/Context/ContextProvider` generates a context class for the application runtime context.

Specify the module and cache in the context class and the context-specific injector will be selected.

Ray.Di for Laravel provides the following built-in contexts.

* `RayDi/Context/ProductionContext`
* `RayDi/Context/LocalContext`
* `RayDi/Context/TestingContext.php`

### Cache

In the `RayDi/Context/ProductionContext`, the injector is cached if the apcu extension is enabled.

### Custom context

You may need your own context.
Implement a custom context with reference to the built-in context and use it in `RayDi/Context/ContextProvider`.

### Overriding Modules

When running tests, you may want to change the binding depending on the test case.

Use `Ray\RayDiForLaravel\Testing\OverrideModule` in your test class and call `$this->overrideModule` as shown below.

```php
use Tests\TestCase;

final class HelloTest extends TestCase
{
    use Ray\RayDiForLaravel\Testing\OverrideModule;

    public function testStatusOk(): void
    {
        $this->overrideModule(new OverrideModule());
    
        $res = $this->get('/hello');

        $res->assertOk();
        $res->assertSeeText('Hello 1 * 2 = 2.');
    }
}
```

## Performance

By installin the [DiCompileModule](https://github.com/ray-di/Ray.Compiler/blob/1.x/src/DiCompileModule.php), An optimized injector is used and dependency errors are reported at compile time, not at runtime.

For `RayDi/ProductionModule` corresponding to `RayDi/Context/ProductionContext`, `DiCompileModule` is already installed.

## Demo

See [hello-ray-di-for-laravel](https://github.com/koriym/hello-ray-di-for-laravel) demo code.
