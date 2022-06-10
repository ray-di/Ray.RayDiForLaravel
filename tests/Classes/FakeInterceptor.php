<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel\Classes;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

class FakeInterceptor implements MethodInterceptor
{
    public function invoke(MethodInvocation $invocation)
    {
        $result = $invocation->proceed();

        return $result . ' Intercepted.';
    }
}
