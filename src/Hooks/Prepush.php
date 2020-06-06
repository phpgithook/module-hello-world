<?php

declare(strict_types=1);

namespace PHPGithook\HelloWorld\Hooks;

use PHPGithook\ModuleInterface\ConfigurationBag;
use PHPGithook\ModuleInterface\PHPGithookPrepushInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Prepush implements PHPGithookPrepushInterface
{
    /**
     * Called prior to a push to a remote.
     * Returning false aborts the push.
     */
    public function prePush(
        string $destinationName,
        string $destinationLocation,
        InputInterface $input,
        OutputInterface $output,
        ConfigurationBag $configuration
    ): bool {
        if ('Fail' === $destinationName) {
            return false;
        }

        // We can write to the console, with data we got
        $output->writeln([
            'Destination is: '.$destinationName,
            'Location is: '.$destinationLocation,
        ]);

        return true;
    }
}
