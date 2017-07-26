<?php

namespace RideShare\Domain\Ride\Entities;

class RideId
{
    /** @var string */
    protected $id;

    /**
     * @param string $id
     */
    private function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $id
     * @return RideId
     */
    public static function create(string $id): RideId
    {
        return new self($id);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->id;
    }
}