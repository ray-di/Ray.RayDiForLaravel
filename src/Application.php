<?php

namespace Ray\RayDiForLaravel;

use Ray\Di\Exception\Unbound;
use Ray\Di\InjectorInterface;

class Application extends \Illuminate\Foundation\Application
{
    /** @var InjectorInterface */
    private $injector;

    public function __construct(string $basePath, InjectorInterface $injector)
    {
        parent::__construct($basePath);
        $this->injector = $injector;
    }

    protected function resolve($abstract, $parameters = [], $raiseEvents = true)
    {
        if ($this->shouldBeResolvedByIlluminate($abstract)) {
            return parent::resolve($abstract, $parameters, $raiseEvents);
        }

        try {
            $object = $this->injector->getInstance($abstract);
        } catch (Unbound $e) {
            return parent::resolve($abstract, $parameters, $raiseEvents);
        }

        if ($raiseEvents) {
            $this->fireResolvingCallbacks($abstract, $object);
        }

        return $object;
    }

    private function shouldBeResolvedByIlluminate(string $abstract): bool
    {
        return $abstract === strtolower($abstract);
    }
}
