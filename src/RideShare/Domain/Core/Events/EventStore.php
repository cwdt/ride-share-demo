<?php

namespace RideShare\Domain\Core\Events;

use RideShare\Domain\Core\Events\DomainEvent;
use RideShare\Domain\Core\Entities\StoredEvent;

interface EventStore
{
    /**
     * @param DomainEvent $event
     * @return void
     */
    public function append(DomainEvent $event);

    /**
     * Get all stored events since given $storedEventId
     *
     * @param int $storedEventId
     * @return StoredEvent[]
     */
    public function allStoredEventsSince(int $storedEventId);
}