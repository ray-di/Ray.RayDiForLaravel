<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel;

use Illuminate\Contracts\Container\BindingResolutionException;
use Ray\Compiler\AbstractInjectorContext;
use Ray\Compiler\ContextInjector;
use Ray\Di\AbstractModule;
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

    private AbstractInjectorContext $context;

    private AbstractModule|null $overrideModule = null;

    /** @var array<string, InjectorInterface> */
    private array $overrideInjectorInstance = [];

    public function __construct(string $basePath, AbstractInjectorContext $injectorContext)
    {
        parent::__construct($basePath);
        $this->injector = ContextInjector::getInstance($injectorContext);
        $this->context = $injectorContext;
    }

    protected function resolve($abstract, $parameters = [], $raiseEvents = true)
    {
        if (!$this->shouldBeResolvedByRay($abstract)) {
            return parent::resolve($abstract, $parameters, $raiseEvents);
        }

        $injector = $this->getInjector();

        try {
            return $injector->getInstance($abstract);
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

    public function flush()
    {
        parent::flush();

        $this->overrideModule = null;
        $this->abstractsResolvedByRay = [];
        $this->overrideInjectorInstance = [];
    }

    public function overrideModule(AbstractModule $module): void
    {
        $this->overrideModule = $module;
    }

    private function getInjector(): InjectorInterface
    {
        if ($this->overrideModule === null) {
            return $this->injector;
        }

        $currentModuleString = spl_object_hash($this->overrideModule);

        if (isset($this->overrideInjectorInstance[$currentModuleString])) {
            return $this->overrideInjectorInstance[$currentModuleString];
        }

        $injector = ContextInjector::getOverrideInstance($this->context, $this->overrideModule);
        $newModuleString = spl_object_hash($this->overrideModule);
        $this->overrideInjectorInstance[$newModuleString] = $injector;

        return $injector;
    }
}
