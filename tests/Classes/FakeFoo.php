<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel\Classes;

class FakeFoo implements FooInterface
{
    public function __invoke(): string
    {
        return 'Fake';
    }
}
