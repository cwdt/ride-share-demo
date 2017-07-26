<?php

namespace RideShare\Domain\Ride\Entities;

use DateTimeImmutable;
use RideShare\Domain\Core\Entities\AggregateRoot;
use RideShare\Domain\Core\ValueObjects\Coordinate;
use RideShare\Domain\Ride\Events\DepartureTimeHasChanged;
use RideShare\Domain\Ride\Events\RideWasCreated;

class Ride extends AggregateRoot
{
    /** @var array */
    protected $apply = [
        RideWasCreated::class => 'applyRideWasCreated',
    ];

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
     */
    private function __construct(RideId $id)
    {
        $this->id = $id;
    }

    /**
     * @param RideId $id
     * @param Coordinate $departure
     * @param Coordinate $destination
     * @param DateTimeImmutable $departureTime
     * @return Ride
     */
    public static function from(RideId $id, Coordinate $departure, Coordinate $destination, DateTimeImmutable $departureTime): Ride
    {
        $ride = new self($id);
        $ride->recordApplyAndPublishThat(
            new RideWasCreated($id, $departure, $destination, $departureTime)
        );

        return $ride;
    }

    /**
     * @param RideWasCreated $event
     */
    protected function applyRideWasCreated(RideWasCreated $event)
    {
        $this->id = $event->getId();
        $this->departure = $event->getDeparture();
        $this->destination = $event->getDestination();
        $this->departureTime = $event->getDepartureTime();
    }

    /**
     * @return RideId
     */
    public function getId(): RideId
    {
        return $this->id;
    }

    /**
     * @return Coordinate
     */
    public function getDeparture(): Coordinate
    {
        return $this->departure;
    }

    /**
     * @return Coordinate
     */
    public function getDestination(): Coordinate
    {
        return $this->destination;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDepartureTime(): DateTimeImmutable
    {
        return $this->departureTime;
    }
}