<?php

namespace Ray\RayDiForLaravel;

use Illuminate\Routing\Route;
use Ray\Di\Exception\Unbound;
use Ray\Di\InjectorInterface;

class RayRoute extends Route
{
    /** @var InjectorInterface  */
    private $injector;

    public function __construct($methods, $uri, $action, InjectorInterface $injector)
    {
        parent::__construct($methods, $uri, $action);
        $this->injector = $injector;
    }

    /**
     * {@inheritDoc}
     */
    public function getController()
    {
        if (! $this->controller) {
            $class = method_exists($this, 'getControllerClass') ? $this->getControllerClass() : $this->parseControllerCallback()[0];
            try {
                $this->controller = $this->injector->getInstance($class);
            } catch (Unbound $e) {
                $this->controller = $this->container->make(ltrim($class, '\\'));
            }
        }

        return $this->controller;
    }
}
