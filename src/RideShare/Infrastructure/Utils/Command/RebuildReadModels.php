<?php

namespace RideShare\Infrastructure\Utils\Command;

use RideShare\Domain\Core\Events\EventStore;
use RideShare\Infrastructure\Projection\Projector;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RebuildReadModels extends Command
{
    /** @var EventStore */
    protected $eventStore;

    /** @var Projector */
    protected $projector;

    /**
     * @param EventStore $eventStore
     * @param Projector $projector
     */
    public function __construct(EventStore $eventStore, Projector $projector)
    {
        $this->eventStore = $eventStore;
        $this->projector = $projector;
        parent::__construct(null);
    }

    /**
     * Configure command
     */
    public function configure()
    {
        $this->setName('utils:rebuild-read-models');
        $this->setDescription('Command will rebuild read models by re-applying all events');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Start rebuilding</info>');
        $output->writeln('<info>Retrieving stored events</info>');

        $storedEvents = $this->eventStore->allStoredEventsSince(null);
        $domainEvents = [];
        foreach ($storedEvents as $storedEvent) {
            $domainEvents[] = unserialize($storedEvent->getBody());
        }

        $output->writeln('<info>Projecting domain events</info>');

        $this->projector->project($domainEvents);

        $output->writeln('<info>Finished rebuilding</info>');
    }

}