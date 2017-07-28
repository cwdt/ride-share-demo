<?php

namespace RideShare\Application\ChangeDepartureTime;

use DateTimeImmutable;

class ChangeDepartureTimeCommand
{
    /** @var string */
    protected $rideId;

    /** @var DateTimeImmutable */
    protected $departureTime;

    /**
     * @param string $rideId
     * @param DateTimeImmutable $departureTime
     */
    public function __construct($rideId, DateTimeImmutable $departureTime)
    {
        $this->rideId = $rideId;
        $this->departureTime = $departureTime;
    }

    /**
     * @return string
     */
    public function getRideId(): string
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