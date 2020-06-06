<?php

declare(strict_types=1);

namespace PHPGithook\HelloWorld\Tests\Hooks;

use PHPGithook\HelloWorld\Hooks\PrepareCommitMessage;
use PHPGithook\ModuleInterface\ConfigurationBag;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\NullOutput;

class PrepareCommitMessageTest extends TestCase
{
    /**
     * @test
     */
    public function can_prepare_commit(): void
    {
        $prepare = new PrepareCommitMessage();
        $msg = 'Hello';
        $prepare->prepareCommitMsg($msg, new ArgvInput(), new NullOutput(), new ConfigurationBag());
        self::assertSame('sweet text Hello', $msg);
    }
}
