<?php

namespace RideShare\Application\RegisterRide;

use DateTimeImmutable;
use RideShare\Domain\Core\ValueObjects\Coordinate;
use RideShare\Domain\Ride\Entities\Ride;
use RideShare\Domain\Ride\Entities\RideId;
use RideShare\Domain\Ride\Repositories\RideRepository;

class RegisterRideHandler
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
     * @param RegisterRideCommand $command
     * @return void
     */
    public function handle(RegisterRideCommand $command)
    {
        $ride = Ride::from(
            RideId::create($command->getGuid()),
            Coordinate::from($command->getDepartureLat(), $command->getDepartureLong()),
            Coordinate::from($command->getDestinationLat(), $command->getDestinationLong()),
            new DateTimeImmutable($command->getDepartureTime())
        );

        $this->rideRepository->save($ride);
    }
}