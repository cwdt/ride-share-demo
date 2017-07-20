<?php

namespace RideShare\Infrastructure\Ui\Cli;

use Psr\Log\LoggerInterface;
use RideShare\Application\RegisterRide\RegisterRideCommand;
use SimpleBus\Message\Bus\MessageBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterRide extends Command
{
    /** @var MessageBus */
    protected $commandBus;

    /** @var LoggerInterface */
    protected $logger;

    /**
     * @param MessageBus $commandBus
     * @param LoggerInterface $logger
     */
    public function __construct(MessageBus $commandBus, LoggerInterface $logger)
    {
        $this->commandBus = $commandBus;
        $this->logger = $logger;
        parent::__construct(null);
    }

    /**
     *
     */
    public function configure()
    {
        $this->setName('ride-share:ride:register');
        $this->setDescription('Register a ride');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->commandBus->handle(
            new RegisterRideCommand(
                uniqid(),
                10,
                10,
                10,
                10,
                '2017-10-11 10:00:00'
            )
        );
    }
}