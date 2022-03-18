<?php

namespace Ray\RayDiForLaravel;

use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use Ray\Di\InjectorInterface;

final class RayRouter extends Router
{
    /** @var InjectorInterface  */
    private $injector;

    public function __construct(Dispatcher $events, Container $container = null, InjectorInterface $injector)
    {
        parent::__construct($events, $container);
        $this->injector = $injector;
    }

    public function newRoute($methods, $uri, $action)
    {
        return (new RayRoute($methods, $uri, $action, $this->injector))
            ->setRouter($this)
            ->setContainer($this->container);
    }
}
