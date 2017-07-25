<?php

namespace RideShare\Infrastructure\Persistence\Doctrine\ EventStore;

use Doctrine\ORM\EntityManagerInterface;
use RideShare\Domain\Core\Events\DomainEvent;
use RideShare\Domain\Core\Events\EventStore;
use RideShare\Domain\Core\Entities\StoredEvent;

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

    /**
     * @param null|int $storedEventId
     * @return StoredEvent[]
     */
    public function allStoredEventsSince(?int $storedEventId)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb
            ->select('e')
            ->from(StoredEvent::class, 'e')
            ->orderBy('e.id', 'asc');

        if ($storedEventId) {
            $qb
                ->where('e.id > :id')
                ->setParameter('id', $storedEventId);
        }

        return $qb->getQuery()->getResult();
    }
}
