<?php

declare(strict_types=1);

namespace PHPGithook\HelloWorld\Hooks;

use PHPGithook\ModuleInterface\ConfigurationBag;
use PHPGithook\ModuleInterface\PHPGithookPrepushInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Prepush implements PHPGithookPrepushInterface
{
    public function prePush(
        string $destinationName,
        string $destinationLocation,
        InputInterface $input,
        OutputInterface $output,
        ConfigurationBag $configuration
    ): bool {
        return true;
    }
}
