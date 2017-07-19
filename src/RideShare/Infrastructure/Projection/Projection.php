<?php

namespace RideShare\Infrastructure\Projection;

use RideShare\Domain\Core\Events\DomainEvent;

interface Projection
{
    /**
     * @return string
     */
    public function listensTo(): string;

    /**
     * @param DomainEvent $event
     * @return void
     */
    public function project($event);
}