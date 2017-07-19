<?php

namespace RideShare\Domain\Ride\Repositories;

use RideShare\Domain\Ride\Entities\Ride;
use RideShare\Domain\Ride\Entities\RideId;

interface RideRepository
{
    /**
     * @param Ride $ride
     * @return void
     */
    public function save(Ride $ride);

    /**
     * @param RideId $id
     * @return null|Ride
     */
    public function find(RideId $id): ?Ride;
}