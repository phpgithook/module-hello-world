<?php

declare(strict_types=1);

namespace PHPGithook\HelloWorld\Tests\Hooks;

use PHPGithook\HelloWorld\Hooks\PostCommit;
use PHPGithook\ModuleInterface\ConfigurationBag;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;

class PostCommitTest extends TestCase
{
    /**
     * @test
     */
    public function will_write_post_commit_to_console(): void
    {
        $postcommit = new PostCommit();
        $output = new BufferedOutput();
        $postcommit->postCommit(new ArgvInput(), $output, new ConfigurationBag());
        self::assertSame("Hello World!\n", $output->fetch());
    }
}
