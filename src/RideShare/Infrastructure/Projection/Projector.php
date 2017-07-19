<?php

namespace RideShare\Infrastructure\Projection;

use RideShare\Domain\Core\Events\DomainEvent;

class Projector
{
    /** @var array */
    protected $projections = [];

    /**
     * @param Projection[] $projections
     */
    public function register(array $projections)
    {
        foreach ($projections as $projection) {
            $listensTo = $projection->listensTo();
            $this->projections[$listensTo][] = $projection;
        }
    }

    /**
     * @param DomainEvent[] $events
     */
    public function project(array $events)
    {
        foreach ($events as $event) {
            $projectionImplementations = isset($this->projections[get_class($event)]) ? $this->projections[get_class($event)] : [];
            foreach ($projectionImplementations as $projection) {
                $projection->project($event);
            }
        }
    }
}