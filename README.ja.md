# Ray.Di for Laravel

[English](README.md) | Japanese

Laravelの依存解決を[Ray.Di](https://ray-di.github.io/manuals/1.0/en/index.html)が行います。依存オブジェクトのAOPも可能にします。

Ray.Diによる生成を行わない場合には、既存のLaravelのサービスコンテナがインスタンス生成して互換性を維持します。

## インストール

```
composer require ray/ray-di-for-laravel
```

## 利用

[束縛](https://ray-di.github.io/manuals/1.0/ja/bindings.html)を記述するモジュールをコピーします。

```
cp -r vendor/ray/ray-di-for-laravel/Ray app
```

`bootstrap/app.php`の以下の行を変更します。

```php
- $app = new Illuminate\Foundation\Application(
-     $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
- );
+ $app = new Ray\RayDiForLaravel\Application(
+     $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__),
+     new Ray\Di\Injector(new App\Ray\Module())
+ );
```

`Ray\RayDiForLaravel\Attribute\Injectable`アトリビュートをRay.Diによって解決したいクラス・インターフェースに付加します。

下記クラスはRay.Diによって解決されます。
```php
<?php

namespace App\Http\Controllers;

use Ray\RayDiForLaravel\Attribute\Injectable;

#[Injectable]
class HelloController extends Controller
{

}
```

下記は既存のLaravelのサービスコンテナによって解決されます。
```php
<?php

namespace App\Http\Controllers;

// アトリビュートなし
class HelloController extends Controller
{

}
```
