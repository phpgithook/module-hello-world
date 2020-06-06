<?php

declare(strict_types=1);

namespace PHPGithook\HelloWorld\Hooks;

use PHPGithook\ModuleInterface\ConfigurationBag;
use PHPGithook\ModuleInterface\PHPGithookPostCommitInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PostCommit implements PHPGithookPostCommitInterface
{
    /**
     * Called after the actual commit is made. Because of this, it cannot disrupt the commit.
     * It is mainly used to allow notifications.
     */
    public function postCommit(InputInterface $input, OutputInterface $output, ConfigurationBag $configuration): void
    {
        // Yes we can send a notification to slack fx?
        // Then we would just add some configuration with slack channel, username etc etc
        // And then require the slack API via composer and do the code here

        // But very simple, we can say Hello World! to the console
        $output->writeln('Hello World!');
    }
}
