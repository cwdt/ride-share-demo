<?php

namespace RideShare\Infrastructure\Ui\Cli;

use Psr\Log\LoggerInterface;
use RideShare\Application\RegisterRide\RegisterRideCommand;
use SimpleBus\Message\Bus\MessageBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
        $this->setName('ride-share:ride:register')
            ->setDescription('Register a ride')
            ->addArgument('departure-lat', InputOption::VALUE_REQUIRED)
            ->addArgument('departure-long', InputOption::VALUE_REQUIRED)
            ->addArgument('destination-lat', InputOption::VALUE_REQUIRED)
            ->addArgument('destination-long', InputOption::VALUE_REQUIRED)
            ->addArgument('departure-time', InputOption::VALUE_REQUIRED);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    public  function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Start registering ride</info>');

        $rideId = uniqid();
        $this->commandBus->handle(
            new RegisterRideCommand(
                $rideId,
                $input->getArgument('departure-lat'),
                $input->getArgument('departure-long'),
                $input->getArgument('destination-lat'),
                $input->getArgument('destination-long'),
                $input->getArgument('departure-time')
            )
        );

        $output->writeln('<info>Finished registering ride (' . $rideId . ')</info>');
    }
}