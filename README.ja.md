# Ray.Di for Laravel

[English](README.md) | Japanese

Laravelのコントローラーの依存解決をRay.Diが行います。インジェクトされるオブジェクトに対してAOPを可能にします。

Ray.Diのよる生成ができない場合には、既存のLaravelのコントローラーファクトリーがインスタンス生成するので互換性の問題はありません。

## インストール

```
composer require ray/ray-di-for-laravel
```

## 利用

束縛を記述するモジュールをコピーします。

```
cp -r vendor/ray/ray-di-for-larabel/Module .
```

`bootstrap/app.php`に以下の行を加えます。

```
$app['router'] = new RayRouter($app['events'], $app, new Injector(new Module()));
```
