<?php

namespace RideShare\Infrastructure\EventStore\Doctrine;

use Doctrine\ORM\EntityRepository;
use RideShare\Domain\Core\Events\DomainEvent;
use RideShare\Domain\EventStore\EventStore;

class DoctrineEventStore extends EntityRepository implements EventStore
{
    /**
     * @inheritdoc
     */
    public function append(DomainEvent $event)
    {
        $storedEvent = new StoredEvent(
            get_class($event),
            new \DateTimeImmutable(),
            serialize($event)
        );

        $this->getEntityManager()->persist($storedEvent);
    }
}
