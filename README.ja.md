# Ray.Di for Laravel
## DI+AOP, done the right way

[English](README.md) | Japanese

Laravelの依存解決を[Ray.Di](https://ray-di.github.io/manuals/1.0/en/index.html)が行います。依存オブジェクトのAOPも可能にします。

Ray.Diによる生成を行わない場合には、既存のLaravelのサービスコンテナがインスタンス生成して互換性を維持します。

## インストール

```
composer require ray/ray-di-for-laravel
```

## 利用

[束縛](https://ray-di.github.io/manuals/1.0/ja/bindings.html)を記述するモジュール、コンテキスト、生成されるファイルを保存するディレクトリをコピーします。

```
cp -r vendor/ray/ray-di-for-laravel/RayDi app
cp -r vendor/ray/ray-di-for-laravel/storage/ storage
```

`bootstrap/app.php`の以下の行を変更します。

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

## コンテキスト

`RayDi/Context/ContextProvider` によって、アプリケーション実行時のコンテキストに応じたコンテキストクラスが生成されます。

コンテキストクラスでモジュールとキャッシュを指定し、コンテキストに応じたインジェクターが選択されます。

Ray.Di for Laravel では、組み込みコンテキストとして以下を提供しています。

* `RayDi/Context/ProductionContext`
* `RayDi/Context/LocalContext`
* `RayDi/Context/TestingContext`

### キャッシュ

`RayDi/Context/ProductionContext`では、
apcu拡張が有効な場合インジェクターをキャッシュします。

### カスタムコンテキスト

独自のコンテキストが必要になる場合もあります。
組み込みコンテキストを参考にカスタムコンテキストを実装し、`RayDi/Context/ContextProvider`で利用するようにします。

### モジュールのオーバーライド

テスト実行時にはテストケースによって束縛を変更したい場合があります。

以下のように、テストクラスで `Ray\RayDiForLaravel\Testing\OverrideModule` を利用し、`$this->overrideModule` を呼び出してください。

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

## パフォーマンス

[DiCompileModule](https://github.com/ray-di/Ray.Compiler/blob/1.x/src/DiCompileModule.php)をインストールすることで、
最適化されたインジェクターが利用され、依存関係エラーは実行時ではなくコンパイル時に報告されます。

`RayDi/Context/ProductionContext`に対応する`RayDi/ProductionModule`では、`DiCompileModule`は既にインストールされています。

## デモ

[hello-ray-di-for-laravel](https://github.com/koriym/hello-ray-di-for-laravel) を確認してください。
