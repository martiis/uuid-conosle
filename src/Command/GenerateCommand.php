<?php

declare(strict_types=1);

namespace Martiis\UuidConsole\Command;

use Symfony\Component\Console\Command\Command;

class GenerateCommand extends Command
{
    protected static $defaultName = 'generate';
    protected static $defaultDescription = 'Generate a UUID';
}
