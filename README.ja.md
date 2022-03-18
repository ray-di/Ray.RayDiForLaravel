# Ray.Di for Laravel

[English](README.md) | Japanese

Laravelのコントローラーの依存解決を[Ray.Di](https://ray-di.github.io/manuals/1.0/en/index.html)が行います。コントローラーと依存オブジェクトのAOPも可能にします。

Ray.Diによる生成ができない場合には、既存のLaravelのコントローラーファクトリーがインスタンス生成して互換性を維持します。

## インストール

```
composer require ray/ray-di-for-laravel
```

## 利用

[束縛](https://ray-di.github.io/manuals/1.0/ja/bindings.html)を記述するモジュールをコピーします。

```
cp -r vendor/ray/ray-di-for-larabel/Module ./app
```

`bootstrap/app.php`に以下の行を加えます。

```php
use App\Ray\Module;
use App\RayRouter;
use Ray\Di\Injector;
```
```php
$app['router'] = new RayRouter($app['events'], $app, new Injector(new Module()));
```
