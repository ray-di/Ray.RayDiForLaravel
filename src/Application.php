<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel;

use Illuminate\Contracts\Container\BindingResolutionException;
use Ray\Compiler\AbstractInjectorContext;
use Ray\Compiler\ContextInjector;
use Ray\Di\Exception\Unbound;
use Ray\Di\InjectorInterface;
use Ray\RayDiForLaravel\Attribute\Injectable;
use Ray\ServiceLocator\ServiceLocator;
use ReflectionClass;
use ReflectionException;

class Application extends \Illuminate\Foundation\Application
{
    /** @var InjectorInterface */
    private InjectorInterface $injector;

    /** @var string[] */
    private array $abstractsResolvedByRay = [];

    public function __construct(string $basePath, AbstractInjectorContext $injectorContext)
    {
        parent::__construct($basePath);
        $this->injector = ContextInjector::getInstance($injectorContext);
    }

    protected function resolve($abstract, $parameters = [], $raiseEvents = true)
    {
        if (!$this->shouldBeResolvedByRay($abstract)) {
            return parent::resolve($abstract, $parameters, $raiseEvents);
        }

        try {
            return $this->injector->getInstance($abstract);
        } catch (Unbound $e) {
            throw new BindingResolutionException("Failed to resolve {$abstract} by Ray's injector.", 0, $e);
        }
    }

    private function shouldBeResolvedByRay(string $abstract): bool
    {
        if (in_array($abstract, $this->abstractsResolvedByRay, true)) {
            return true;
        }

        try {
            $reflectionClass = new ReflectionClass($abstract);
        } catch (ReflectionException) {
            return false;
        }

        $annotation = ServiceLocator::getReader()->getClassAnnotation($reflectionClass, Injectable::class);
        if ($annotation === null) {
            return false;
        }

        $this->abstractsResolvedByRay[] = $abstract;
        return true;
    }
}
