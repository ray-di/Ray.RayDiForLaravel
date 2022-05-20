<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel;

use PHPUnit\Framework\TestCase;
use Ray\Di\Injector;
use Ray\RayDiForLaravel\Classes\GreetingServiceProvider;
use Ray\RayDiForLaravel\Classes\IlluminateGreeting;
use Ray\RayDiForLaravel\Classes\InjectableService;
use Ray\RayDiForLaravel\Classes\Module;
use Ray\RayDiForLaravel\Classes\NonInjectableService;

class ApplicationTest extends TestCase
{
    public function testResolvedByRayWhenMarkedClassGiven(): void
    {
        $app = $this->createApplication();

        $service = $app->make(InjectableService::class);
        $result = $service->run();

        $this->assertEquals('Hello, Ray! Intercepted.', $result);
    }

    public function testResolvedByIlluminateWhenNonMarkedClassGiven(): void
    {
        $app = $this->createApplication();

        $service = $app->make(NonInjectableService::class);
        $result = $service->run();

        $this->assertEquals('Hello, Illuminate!', $result);
    }

    public function testResolvedByIlluminateWhenNonClassStringGiven(): void
    {
        $app = $this->createApplication();

        $greeting = $app->make('greeting');

        $this->assertInstanceOf(IlluminateGreeting::class, $greeting);
    }

    private function createApplication(): Application
    {
        $app = new Application(
            dirname(__DIR__),
            new Injector(new Module())
        );
        $app->register(GreetingServiceProvider::class);

        return $app;
    }
}
