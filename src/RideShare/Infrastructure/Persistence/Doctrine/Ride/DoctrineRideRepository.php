<?php

namespace RideShare\Infrastructure\Persistence\Doctrine\Ride;

use Doctrine\ORM\EntityManagerInterface;
use RideShare\Domain\Core\EventStore\EventStore;
use RideShare\Domain\Ride\Entities\Ride;
use RideShare\Domain\Ride\Entities\RideId;
use RideShare\Domain\Ride\Repositories\RideRepository;
use RideShare\Infrastructure\Projection\Projector;

class DoctrineRideRepository implements RideRepository
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var EventStore */
    protected $eventStore;

    /** @var Projector */
    protected $projector;

    /**
     * @param EntityManagerInterface $entityManager
     * @param EventStore $eventStore
     * @param Projector $projector
     */
    public function __construct(EntityManagerInterface $entityManager, EventStore $eventStore, Projector $projector)
    {
        $this->entityManager = $entityManager;
        $this->eventStore = $eventStore;
        $this->projector = $projector;
    }

    /**
     * @inheritdoc
     */
    public function save(Ride $ride)
    {
        $this->entityManager->transactional(function () use ($ride) {
            $this->entityManager->persist($ride);
            foreach ($ride->getRecordedEvents() as $event) {
                $this->eventStore->append($event);
            }
        });
        $this->projector->project($ride->getRecordedEvents());
    }

    /**
     * @inheritdoc
     */
    public function find(RideId $id): ?Ride
    {
        return $this->entityManager->find(Ride::class, $id);
    }
}