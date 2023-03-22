<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel\Classes;

class Foo implements FooInterface
{
    public function __invoke(): string
    {
        return '';
    }
}
