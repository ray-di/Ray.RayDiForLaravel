<?php

namespace Ray\RayDiForLaravel\Classes;

use Illuminate\Support\ServiceProvider;

class GreetingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('greeting', IlluminateGreeting::class);
        $this->app->alias('greeting', GreetingInterface::class);
    }
}