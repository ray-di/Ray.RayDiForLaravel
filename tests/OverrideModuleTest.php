<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel;

use PHPUnit\Framework\TestCase;
use Ray\RayDiForLaravel\Classes\FakeContext;
use Ray\RayDiForLaravel\Classes\GreetingServiceProvider;
use Ray\RayDiForLaravel\Classes\InjectableService;
use Ray\RayDiForLaravel\Classes\OverrideGreetingModule;
use Ray\RayDiForLaravel\Testing\OverrideModule;

class OverrideModuleTest extends TestCase
{
    use OverrideModule;

    private \Illuminate\Foundation\Application $app;

    protected function setUp(): void
    {
        $this->app = new Application(
            dirname(__DIR__),
            new FakeContext(dirname(__DIR__) . '/tests')
        );

        $this->app->register(GreetingServiceProvider::class);
    }

    public function testAppIsRayDiApplication(): void
    {
        $this->overrideModule(new OverrideGreetingModule());

        $instance = $this->app->make(InjectableService::class);
        $actual = $instance->run();

        $this->assertSame('Hello, override!', $actual);
    }
}
