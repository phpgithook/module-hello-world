<?php

declare(strict_types=1);

namespace PHPGithook\HelloWorld\Tests;

use PHPGithook\HelloWorld\Setup;
use PHPGithook\ModuleInterface\ConfigurationBag;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\NullOutput;

class SetupTest extends TestCase
{
    private Setup $class;

    protected function setUp(): void
    {
        $this->class = new Setup();
    }

    /**
     * @test
     */
    public function can_get_visual_name(): void
    {
        self::assertSame('Hello World', $this->class->getVisualName());
    }

    /**
     * @test
     */
    public function can_get_description(): void
    {
        self::assertSame('This is an example module', $this->class->getDescription());
    }

    /**
     * @test
     */
    public function can_get_module_name(): void
    {
        self::assertSame('helloworld', $this->class->getModuleName());
    }

    /**
     * @test
     */
    public function can_get_version(): void
    {
        self::assertSame('1.0', $this->class->getVersion());
    }

    /**
     * @test
     */
    public function can_create_configuration(): void
    {
        $config = new ConfigurationBag();
        $input = new class() extends ArgvInput {
            public function isInteractive(): bool
            {
                return false;
            }
        };

        $output = new NullOutput();

        $this->class->createConfiguration($input, $output, $config);
        self::assertSame('I\'m precommit message', $config->get('pre-commit-message'));
    }
}
