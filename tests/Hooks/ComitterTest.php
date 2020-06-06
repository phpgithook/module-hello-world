<?php

declare(strict_types=1);

namespace PHPGithook\HelloWorld\Tests\Hooks;

use PHPGithook\HelloWorld\Hooks\Comitter;
use PHPGithook\HelloWorld\Setup;
use PHPGithook\ModuleInterface\ConfigurationBag;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class ComitterTest extends TestCase
{
    /**
     * @test
     */
    public function can_commit_message(): void
    {
        $commiter = new Comitter();
        $commitMessage = 'This is a commit message containing HelloWorld';
        $input = new ArgvInput([]);
        $output = new BufferedOutput();
        $configuration = new ConfigurationBag([
            Setup::COMMIT_ADD => 'HelloWorld',
            Setup::CONFIG => 'strrev',
        ]);
        $result = $commiter->commitMsg($commitMessage, $input, $output, $configuration);
        self::assertTrue($result);
        self::assertStringContainsString('dlroWolleH', $commitMessage);
    }

    /**
     * @test
     */
    public function can_not_commit_message_because_commitmessage_is_not_correct(): void
    {
        $commiter = new Comitter();
        $commitMessage = 'This is a commit message';
        $input = new ArgvInput([]);
        $output = new BufferedOutput();
        $configuration = new ConfigurationBag([
            Setup::COMMIT_ADD => 'HelloWorld',
            Setup::CONFIG => 'strrev',
        ]);
        $result = $commiter->commitMsg($commitMessage, $input, $output, $configuration);
        self::assertFalse($result);
        self::assertSame("The commit message does not contains HelloWorld\n", $output->fetch());
    }

    /**
     * @test
     */
    public function can_pre_commit(): void
    {
        $commiter = new Comitter();
        $input = new ArgvInput([]);
        $output = new BufferedOutput();
        $configuration = new ConfigurationBag([
            Setup::COMMIT_ADD => 'HelloWorld',
            Setup::CONFIG => 'strrev',
        ]);
        $result = $commiter->preCommit($input, $output, $configuration);
        self::assertSame("HelloWorld\n", $output->fetch());
        self::assertTrue($result);
    }

    /**
     * @test
     */
    public function will_not_commit_if_request_fails(): void
    {
        $responses = [
            new MockResponse('', [
                'error' => true,
            ]),
        ];

        $commiter = new Comitter(new MockHttpClient($responses));
        $input = new ArgvInput([]);
        $output = new BufferedOutput();
        $configuration = new ConfigurationBag([
            Setup::COMMIT_ADD => 'HelloWorld',
            Setup::CONFIG => 'strrev',
        ]);
        $result = $commiter->preCommit($input, $output, $configuration);
        self::assertFalse($result);
    }
}
