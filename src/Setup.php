<?php

declare(strict_types=1);

namespace PHPGithook\HelloWorld;

use PHPGithook\HelloWorld\Hooks\Comitter;
use PHPGithook\HelloWorld\Hooks\PostCommit;
use PHPGithook\HelloWorld\Hooks\PrepareCommitMessage;
use PHPGithook\HelloWorld\Hooks\Prepush;
use PHPGithook\ModuleInterface\ConfigurationBag;
use PHPGithook\ModuleInterface\PHPGithookSetupInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Setup implements PHPGithookSetupInterface
{
    private const NAME = 'helloworld';
    public const COMMIT_ADD = 'addingToCommit';
    public const CONFIG = 'ourownConfiguration';

    /**
     * The name that will be displayed to the user, when using modify/enable/disable module.
     */
    public function getVisualName(): string
    {
        return 'Hello World';
    }

    /**
     * Description of what your module does.
     */
    public function getDescription(): string
    {
        return 'This is an example module';
    }

    /**
     * The name to the configuration.
     */
    public function getModuleName(): string
    {
        // And our name to the configuration file
        // This will be validated, and all characters not between a-z will be removed
        return self::NAME;
    }

    /**
     * The version of the module.
     */
    public function getVersion(): string
    {
        return '1.0';
    }

    /**
     * The configuration to the module
     * This configuration will be parsed to each of the hooks.
     * You can ask the user for configuration options or just set the configuration.
     */
    public function createConfiguration(InputInterface $input, OutputInterface $output, ConfigurationBag $configuration): void
    {
        $io = new SymfonyStyle($input, $output);
        // If the configuration "pre-commit-message" is not set - we default it to I'm precommit message
        $precommitMessage = $configuration->get(self::COMMIT_ADD, 'I\'m precommit message');

        // Lets ask the user about what he would like to be added to each commit
        $precommitMessage = $io->ask('What should we add to the commit message', $precommitMessage);
        $configuration->set(self::COMMIT_ADD, $precommitMessage);

        // Lets set our own configuration
        $configuration->set(self::CONFIG, 'strrev');
    }

    /**
     * Array of classes which should be loaded that contains your git hooks.
     */
    public function classes(): array
    {
        return [
            // We will add our committer class here, this implements two interfaces, so this is doing 2 things in 1 file
            Comitter::class,
            // And the rest of the classes
            PostCommit::class,
            PrepareCommitMessage::class,
            Prepush::class,
        ];
    }
}
