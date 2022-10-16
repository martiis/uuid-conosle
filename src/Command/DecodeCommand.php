<?php

declare(strict_types=1);

namespace Martiis\UuidConsole\Command;

use Symfony\Component\Console\Command\Command;

class DecodeCommand extends Command
{
    protected static $defaultName = 'decode';
    protected static $defaultDescription = 'Decode a UUID';
}
