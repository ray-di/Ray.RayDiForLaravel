<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel\Testing;

use Ray\Di\AbstractModule;
use Ray\RayDiForLaravel\Application;

trait OverrideModule
{
    protected function overrideModule(AbstractModule $module): void
    {
        if (! property_exists($this, 'app')) {
            return;
        }

        if (! $this->app instanceof Application) {
            return;
        }

        $this->app->overrideModule($module);
    }
}
