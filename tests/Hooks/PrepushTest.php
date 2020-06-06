<?php

declare(strict_types=1);

namespace PHPGithook\HelloWorld\Tests\Hooks;

use PHPGithook\HelloWorld\Hooks\Prepush;
use PHPGithook\ModuleInterface\ConfigurationBag;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;

class PrepushTest extends TestCase
{
    /**
     * @test
     */
    public function can_do_prepush(): void
    {
        $class = new Prepush();
        $output = new BufferedOutput();
        $result = $class->prePush('name', 'loc', new ArgvInput(), $output, new ConfigurationBag());
        self::assertTrue($result);
        self::assertSame("Destination is: name\nLocation is: loc\n", $output->fetch());
    }

    /**
     * @test
     */
    public function can_not_prepush_if_destination_is_failed(): void
    {
        $class = new Prepush();
        $output = new BufferedOutput();
        $result = $class->prePush('Fail', 'loc', new ArgvInput(), $output, new ConfigurationBag());
        self::assertFalse($result);
    }
}
