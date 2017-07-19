<?php

namespace RideShare\Domain\Ride\Events;

use DateTimeImmutable;
use RideShare\Domain\Core\Events\DomainEvent;
use RideShare\Domain\Core\ValueObjects\Coordinate;
use RideShare\Domain\Ride\Entities\RideId;

class RideWasCreated extends DomainEvent
{
    /** @var RideId */
    protected $id;

    /** @var Coordinate */
    protected $departure;

    /** @var Coordinate */
    protected $destination;

    /** @var DateTimeImmutable */
    protected $departureTime;

    /**
     * @param RideId $id
     * @param Coordinate $departure
     * @param Coordinate $destination
     * @param DateTimeImmutable $departureTime
     */
    public function __construct(RideId $id, Coordinate $departure, Coordinate $destination, DateTimeImmutable $departureTime)
    {
        $this->id = $id;
        $this->departure = $departure;
        $this->destination = $destination;
        $this->departureTime = $departureTime;
    }

    /**
     * @return RideId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Coordinate
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * @return Coordinate
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDepartureTime()
    {
        return $this->departureTime;
    }
}