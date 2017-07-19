<?php

namespace RideShare\Application\RegisterRide;

class RegisterRideCommand
{
    /** @var string */
    protected $guid;

    /** @var float */
    protected $departureLat;

    /** @var float */
    protected $departureLong;

    /** @var float */
    protected $destinationLat;

    /** @var float */
    protected $destinationLong;

    /** @var string */
    protected $departureTime;

    /**
     * @param string $guid
     * @param float $departureLat
     * @param float $departureLong
     * @param float $destinationLat
     * @param float $destinationLong
     * @param string $departureTime
     */
    public function __construct(string $guid, float $departureLat, float $departureLong, float $destinationLat, float $destinationLong, string $departureTime)
    {
        $this->guid = $guid;
        $this->departureLat = $departureLat;
        $this->departureLong = $departureLong;
        $this->destinationLat = $destinationLat;
        $this->destinationLong = $destinationLong;
        $this->departureTime = $departureTime;
    }

    /**
     * @return string
     */
    public function getGuid(): string
    {
        return $this->guid;
    }

    /**
     * @return float
     */
    public function getDepartureLat(): float
    {
        return $this->departureLat;
    }

    /**
     * @return float
     */
    public function getDepartureLong(): float
    {
        return $this->departureLong;
    }

    /**
     * @return float
     */
    public function getDestinationLat(): float
    {
        return $this->destinationLat;
    }

    /**
     * @return float
     */
    public function getDestinationLong(): float
    {
        return $this->destinationLong;
    }

    /**
     * @return string
     */
    public function getDepartureTime(): string
    {
        return $this->departureTime;
    }
}