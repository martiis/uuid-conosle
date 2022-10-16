<?php

declare(strict_types=1);

namespace Martiis\UuidConsole\Command;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\Exception\UnsupportedOperationException;
use Ramsey\Uuid\Rfc4122\Fields;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DecodeCommand extends Command
{
    protected static $defaultName = 'decode';
    protected static $defaultDescription = 'Decode a UUID';

    private UuidFactoryInterface $uuidFactory;
    private OrderedTimeCodec $orderedTimeCodec;

    public function __construct()
    {
        parent::__construct();

        $this->uuidFactory = clone Uuid::getFactory();
        $this->orderedTimeCodec = new OrderedTimeCodec($this->uuidFactory->getUuidBuilder());
    }


    protected function configure(): void
    {
        $this
            ->addArgument(
                'uuid',
                InputArgument::REQUIRED,
                'The UUID to decode.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $uuidScalar = $input->getArgument('uuid');

        if (($ordered = str_starts_with($uuidScalar, '0x')) === true) {
            $uuidScalar = substr($uuidScalar, 2);
        } else {
            if (!Uuid::isValid($uuidScalar)) {
                throw new \InvalidArgumentException('Invalid UUID.');
            }
        }

        $uuid = Uuid::fromString($uuidScalar);

        if ($ordered === true) {
            try {
                $uuid = $this->orderedTimeCodec->decodeBytes($uuid->getBytes());
            } catch (UnsupportedOperationException) {
                throw new \InvalidArgumentException('Invalid UUID.');
            }
        }

        $uuidFields = $uuid->getFields();
        $table = new Table($output);
        $table->setStyle('symfony-style-guide');

        if ($uuidFields instanceof Fields) {
            $table->addRow(['Version', $uuid->getVersion()]);
            $table->addRow(['Str', $uuid->toString()]);
            $table->addRow(['Str-Hex', $uuid->getHex()->toString()]);
            $table->addRow(['Int', $uuid->getInteger()->toString()]);

            if ($uuidFields->getVersion() === 1) {
                $table->addRow([
                    'Ord-Time',
                    '0x'.Uuid::fromBytes($this->orderedTimeCodec->encodeBinary($uuid))->getHex()->toString()
                ]);
            }
        } else {
            $table->addRow(['', 'Not an RFC 4122 UUID',]);
        }

        $table->render();

        return 0;
    }
}
