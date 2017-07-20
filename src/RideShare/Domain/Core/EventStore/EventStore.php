<?php

namespace RideShare\Domain\EventStore;

use RideShare\Domain\Core\Events\DomainEvent;

interface EventStore
{
    /**
     * @param DomainEvent $event
     * @return void
     */
    public function append(DomainEvent $event);
}