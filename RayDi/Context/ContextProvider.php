<?php

declare(strict_types=1);

namespace App\RayDi\Context;

use Ray\Compiler\AbstractInjectorContext;
use Ray\RayDiForLaravel\Exception\InvalidContextException;

class ContextProvider
{
    public static function get(string $basePath, string $context): AbstractInjectorContext
    {
        return match ($context) {
            'production' => new ProductionContext($basePath),
            'testing' => new TestingContext(''),
            'local' => new LocalContext(''),
            default => throw new InvalidContextException(),
        };
    }
}
