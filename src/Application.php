<?php

namespace Ray\RayDiForLaravel;

use Ray\Di\Exception\Unbound;
use Ray\Di\InjectorInterface;

class Application extends \Illuminate\Foundation\Application
{
    /** @var InjectorInterface */
    private $injector;

    public function __construct(string $basePath, InjectorInterface $injector) {
        parent::__construct($basePath);
        $this->injector = $injector;
    }

    protected function resolve($abstract, $parameters = [], $raiseEvents = true)
    {
        try {
            return $this->injector->getInstance($abstract);
        } catch (Unbound $e) {
            return parent::resolve($abstract, $parameters, $raiseEvents);
        }
    }
}
