<?php

namespace RideShare\Infrastructure\Persistence\Doctrine\Ride;

use Doctrine\ORM\EntityManagerInterface;
use RideShare\Domain\Ride\Entities\Ride;
use RideShare\Domain\Ride\Entities\RideId;
use RideShare\Domain\Ride\Repositories\RideRepository;
use RideShare\Infrastructure\Projection\Projector;

class DoctrineRideRepository implements RideRepository
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var Projector */
    protected $projector;

    /**
     * @param EntityManagerInterface $entityManager
     * @param Projector $projector
     */
    public function __construct(EntityManagerInterface $entityManager, Projector $projector)
    {
        $this->entityManager = $entityManager;
        $this->projector = $projector;
    }

    /**
     * @inheritdoc
     */
    public function save(Ride $ride)
    {
        $this->entityManager->transactional(function (EntityManagerInterface $entityManager) use ($ride) {
            $entityManager->persist($ride);

//            foreach ($ride->getRecordedEvents() as $event) {
//                $entityManager->persist($event);
//            }
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