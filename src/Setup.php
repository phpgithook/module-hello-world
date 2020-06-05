<?php

declare(strict_types=1);

namespace PHPGithook\HelloWorld;

use PHPGithook\HelloWorld\Hooks\Prepush;
use PHPGithook\ModuleInterface\ConfigurationBag;
use PHPGithook\ModuleInterface\PHPGithookSetupInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Setup implements PHPGithookSetupInterface
{
    public function getVisualName(): string
    {
        return 'Hello World';
    }

    public function getDescription(): string
    {
        return 'This is an example module';
    }

    public function getModuleName(): string
    {
        return 'helloworld';
    }

    public function getVersion(): string
    {
        return '1.0';
    }

    public function createConfiguration(InputInterface $input, OutputInterface $output, ConfigurationBag $configuration): void
    {
        $io = new SymfonyStyle($input, $output);
        $precommitMessage = $configuration->get('pre-commit-message', 'I\'m precommit message');
        $precommitMessage = $io->ask('Set pre commit message', $precommitMessage);

        $configuration->set('pre-commit-message', $precommitMessage);
        $configuration->set('bool', true);
        $configuration->set('int', 2);
    }

    public function classes(): array
    {
        return [
            Prepush::class,
        ];
    }
}
