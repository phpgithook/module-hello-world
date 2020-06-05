<?php

declare(strict_types=1);

namespace PHPGithook\HelloWorld\Tests;

use PHPGithook\ModuleTester\ModuleTester;

class ModuleTest extends ModuleTester
{
    protected function directoryToModule(): string
    {
        return __DIR__.'/../src';
    }
}
