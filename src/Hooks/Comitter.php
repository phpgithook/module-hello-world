<?php

declare(strict_types=1);

namespace PHPGithook\HelloWorld\Hooks;

use JsonException;
use PHPGithook\HelloWorld\Setup;
use PHPGithook\ModuleInterface\ConfigurationBag;
use PHPGithook\ModuleInterface\PHPGithookCommitMsgInterface;
use PHPGithook\ModuleInterface\PHPGithookPreCommitInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Comitter implements PHPGithookCommitMsgInterface, PHPGithookPreCommitInterface
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client = null)
    {
        // We MUST allow NULL in the constructor
        // as phpgithook at the moment, does not supports adding variables in the constructor
        $this->client = $client ?? HttpClient::create();
    }

    /**
     * This hook is invoked by git commit and git merge, and can be bypassed with the --no-verify option.
     *
     * Exiting with a false causes the command to abort.
     *
     * The hook is allowed to edit the message file in place, and can be used to normalize the message into some
     * project standard format. It can also be used to refuse the commit after inspecting the message file.
     *
     * @param string $commitMessage The commit message
     */
    public function commitMsg(
        string &$commitMessage,
        InputInterface $input,
        OutputInterface $output,
        ConfigurationBag $configuration
    ): bool {
        // Lets get the `addingToCommit` configuration which we were added when this module got activated
        $addingToCommit = $configuration->getAlnum(Setup::COMMIT_ADD);

        // Lets test that our message contains $addingToCommit
        if (false === mb_strpos($commitMessage, $addingToCommit)) {
            // Nope `addingToCommit` not found in the commit message
            // Lets write a message to the console
            $output->writeln('The commit message does not contains '.$addingToCommit);

            // And return false, because the commit message is not accepted
            return false;
        }

        // The message contains HelloWorld
        // Lets rewrite HelloWorld in the commit message
        if (is_callable($configuration->get(Setup::CONFIG))) {
            $commitMessage = str_replace(
                $addingToCommit,
                call_user_func($configuration->get(Setup::CONFIG), $addingToCommit),
                $commitMessage
            );
        }

        // Lets add the git branch name to the front of the commit message
        $branch = (string) shell_exec("git branch | grep '*' | sed 's/* //'");
        $commitMessage = '['.trim($branch).'] '.$commitMessage;

        // And return true, because the commit message is accepted
        return true;
    }

    /**
     * This hook is called before obtaining the proposed commit message.
     *
     * Returning false will abort the commit.
     *
     * It is used to check the commit itself (rather than the message).
     */
    public function preCommit(InputInterface $input, OutputInterface $output, ConfigurationBag $configuration): bool
    {
        // Here we can fx run phpunit on in the code
        // Or we can just post something to httpbin
        // As this module requires a http client via composer, we can ofcourse utialize it
        try {
            $response = $this->client->request(
                'POST',
                'https://httpbin.org/post',
                [
                    'body' => [
                        'config' => $configuration->get(Setup::COMMIT_ADD),
                    ],
                ]
            );

            $json = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
            $output->writeln($json['form']['config']);

            // We will return true as the request is correct
            return true;
        } catch (ExceptionInterface | JsonException $e) {
            // As the request failed, we will return false - and the git pre commit will stop
            $output->writeln($e->getMessage());

            return false;
        }
    }
}
