<?php

namespace RideShare\Domain\Ride\Events;

use DateTimeImmutable;
use RideShare\Domain\Core\Events\DomainEvent;
use RideShare\Domain\Ride\Entities\RideId;

class DepartureTimeHasChanged extends DomainEvent
{
    /** @var RideId */
    protected $rideId;

    /** @var DateTimeImmutable */
    protected $departureTime;

    /**
     * @param RideId $rideId
     * @param DateTimeImmutable $departureTime
     */
    public function __construct(RideId $rideId, DateTimeImmutable $departureTime)
    {
        $this->rideId = $rideId;
        $this->departureTime = $departureTime;
        $this->occurredOn = new DateTimeImmutable();
    }

    /**
     * @return RideId
     */
    public function getRideId(): RideId
    {
        return $this->rideId;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDepartureTime(): DateTimeImmutable
    {
        return $this->departureTime;
    }
}