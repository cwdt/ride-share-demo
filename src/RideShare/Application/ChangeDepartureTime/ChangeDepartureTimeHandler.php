<?php

namespace RideShare\Application\ChangeDepartureTime;

use RideShare\Domain\Ride\Entities\RideId;
use RideShare\Domain\Ride\Repositories\RideRepository;

class ChangeDepartureTimeHandler
{
    /** @var RideRepository */
    protected $rideRepository;

    /**
     * @param RideRepository $rideRepository
     */
    public function __construct(RideRepository $rideRepository)
    {
        $this->rideRepository = $rideRepository;
    }

    /**
     * @param ChangeDepartureTimeCommand $command
     * @return void
     */
    public function handle(ChangeDepartureTimeCommand $command)
    {
        $ride = $this->rideRepository->find(RideId::create($command->getRideId()));
        $ride->changeDepartureTime($command->getDepartureTime());
        
        $this->rideRepository->save($ride);
    }
}