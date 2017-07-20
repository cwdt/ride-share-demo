<?php

namespace RideShare\Domain\Ride\Events;

use DateTimeImmutable;
use RideShare\Domain\Core\Events\DomainEvent;
use RideShare\Domain\Ride\Entities\RideId;

class DepartureTimeHasChanged extends DomainEvent
{
    /** @var RideId */
    protected $id;

    /** @var DateTimeImmutable */
    protected $departureTime;

    /**
     * @param RideId $id
     * @param DateTimeImmutable $departureTime
     */
    public function __construct(RideId $id, DateTimeImmutable $departureTime)
    {
        $this->id = $id;
        $this->departureTime = $departureTime;
        $this->occurredOn = new DateTimeImmutable();
    }

    /**
     * @return RideId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDepartureTime()
    {
        return $this->departureTime;
    }
}