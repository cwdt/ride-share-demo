<?php

namespace RideShare\Domain\Core\EventStore;

use RideShare\Domain\Core\Events\DomainEvent;

interface EventStore
{
    /**
     * @param DomainEvent $event
     * @return void
     */
    public function append(DomainEvent $event);
}