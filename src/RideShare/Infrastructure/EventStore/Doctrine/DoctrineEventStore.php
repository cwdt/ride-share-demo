<?php

namespace RideShare\Infrastructure\EventStore\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use RideShare\Domain\Core\Events\DomainEvent;
use RideShare\Domain\Core\EventStore\EventStore;
use RideShare\Infrastructure\EventStore\Doctrine\Entities\StoredEvent;

class DoctrineEventStore implements EventStore
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritdoc
     */
    public function append(DomainEvent $event)
    {
        $storedEvent = new StoredEvent(
            get_class($event),
            $event->getOccurredOn(),
            serialize($event)
        );

        $this->entityManager->persist($storedEvent);
    }
}
