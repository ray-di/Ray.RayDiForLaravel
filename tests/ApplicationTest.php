<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel;

use Illuminate\Contracts\Container\BindingResolutionException;
use PHPUnit\Framework\TestCase;
use Ray\Compiler\AbstractInjectorContext;
use Ray\RayDiForLaravel\Classes\FakeCacheableContext;
use Ray\RayDiForLaravel\Classes\FakeContext;
use Ray\RayDiForLaravel\Classes\FakeInvalidContext;
use Ray\RayDiForLaravel\Classes\GreetingServiceProvider;
use Ray\RayDiForLaravel\Classes\IlluminateGreeting;
use Ray\RayDiForLaravel\Classes\InjectableService;
use Ray\RayDiForLaravel\Classes\NonInjectableService;

class ApplicationTest extends TestCase
{
    public function testResolvedByRayWhenMarkedClassGiven(): Application
    {
        $app = $this->createApplication(FakeContext::class);

        $service = $app->make(InjectableService::class);
        $result = $service->run();

        $this->assertEquals('Hello, Ray! Intercepted.', $result);

        return $app;
    }

    /**
     * @depends testResolvedByRayWhenMarkedClassGiven
     */
    public function testResolvedByRayDiWhenAlreadyResolved(Application $app): void
    {
        $service = $app->make(InjectableService::class);

        $this->assertInstanceOf(InjectableService::class, $service);
    }

    public function testResolvedByIlluminateWhenNonMarkedClassGiven(): void
    {
        $app = $this->createApplication(FakeContext::class);

        $service = $app->make(NonInjectableService::class);
        $result = $service->run();

        $this->assertEquals('Hello, Illuminate!', $result);
    }

    public function testResolvedByIlluminateWhenNonClassStringGiven(): void
    {
        $app = $this->createApplication(FakeContext::class);

        $greeting = $app->make('greeting');

        $this->assertInstanceOf(IlluminateGreeting::class, $greeting);
    }
    public function testCacheableContext(): void
    {
        $app = $this->createApplication(FakeCacheableContext::class);

        $service = $app->make(InjectableService::class);
        $result = $service->run();

        $this->assertEquals('Hello, Ray! Intercepted.', $result);
    }

    /**
     * @depends testCacheableContext
     */
    public function testCache(): void
    {
        $baseDir = __DIR__ . '/tmp/Ray_RayDiForLaravel_Classes_FakeCacheableContext';
        $this->assertDirectoryExists($baseDir);
        $this->assertFileExists($baseDir . '/Ray_RayDiForLaravel_Classes_FakeInterceptor-.php');
        $this->assertFileExists($baseDir . '/Ray_RayDiForLaravel_Classes_FakeInterface-.php');
        $this->assertFileExists($baseDir . '/Ray_RayDiForLaravel_Classes_FakeInterfaceNull.php');
        $this->assertFileExists($baseDir . '/Ray_RayDiForLaravel_Classes_GreetingInterface-.php');
        $this->assertFileExists($baseDir . '/Ray_RayDiForLaravel_Classes_InjectableService-.php');
    }

    public function testFailedToResolveByRayDi(): void
    {
        $this->expectException(BindingResolutionException::class);
        $this->expectExceptionMessage('Failed to resolve ' . InjectableService::class .  ' by Ray\'s injector.');

        $app = $this->createApplication(FakeInvalidContext::class);

        $app->make(InjectableService::class);
    }

    /**
     * @param class-string<AbstractInjectorContext> $contextClass
     */
    private function createApplication(string $contextClass): Application
    {
        $app = new Application(
            dirname(__DIR__),
            new $contextClass(dirname(__DIR__) . '/tests')
        );
        $app->register(GreetingServiceProvider::class);

        return $app;
    }
}
