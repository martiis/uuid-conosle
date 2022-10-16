<?php

declare(strict_types=1);

namespace Martiis\UuidConsole\Command;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{
    protected static $defaultName = 'generate';
    protected static $defaultDescription = 'Generate a UUID';

    protected function configure(): void
    {
        $this
            ->addArgument(
                'version',
                InputArgument::OPTIONAL,
                'The UUID version to generate.',
                1
            )
            ->addOption(
                'count',
                'c',
                InputOption::VALUE_REQUIRED,
                'Generate count UUIDs instead of just a single one.',
                1
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $uuids = [];
        $count = filter_var(
            $input->getOption('count'),
            FILTER_VALIDATE_INT,
            [
                'default' => 1,
                'min_range' => 1,
            ]
        );

        foreach (range(1, $count) as $i) {
            $uuids[] = $this->createUuid($input->getArgument('version'));
        }

        foreach ($uuids as $uuid) {
            $output->writeln((string) $uuid);
        }

        return 0;
    }

    protected function createUuid($version): UuidInterface
    {
        return match ((int) $version) {
            1 => Uuid::uuid1(),
            4 => Uuid::uuid4(),
            default => throw new \InvalidArgumentException('Invalid UUID version. Supported are version "1", "4".'),
        };
    }
}
