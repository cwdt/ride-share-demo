<?php

namespace RideShare\Domain\Core\ValueObjects;

class Coordinate
{
    /** @var float */
    protected $lat;

    /** @var float */
    protected $long;

    /**
     * @param float $lat
     * @param float $long
     */
    private function __construct(float $lat, float $long)
    {
        $this->lat = $lat;
        $this->long = $long;
    }

    public static function from(float $lat, float $long)
    {
        return new self($lat, $long);
    }

    /**
     * @return float
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @return float
     */
    public function getLong(): float
    {
        return $this->long;
    }
}