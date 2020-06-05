<?php

declare(strict_types=1);

namespace PHPGithook\HelloWorld\Tests\Hooks;

use PHPGithook\HelloWorld\Hooks\Prepush;
use PHPGithook\ModuleInterface\ConfigurationBag;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\NullOutput;

class PrepushTest extends TestCase
{
    /**
     * @test
     */
    public function can_do_prepush(): void
    {
        $class = new Prepush();
        self::assertTrue(
            $class->prePush('name', 'loc', new ArgvInput(), new NullOutput(), new ConfigurationBag())
        );
    }
}
