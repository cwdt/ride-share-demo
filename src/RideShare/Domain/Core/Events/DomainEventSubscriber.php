<?php

namespace RideShare\Domain\Core\Events;

interface DomainEventSubscriber
{
    /**
     * @param DomainEvent $event
     * @return bool
     */
    public function isSubscribedTo(DomainEvent $event): bool;

    /**
     * @param DomainEvent $event
     * @return void
     */
    public function handle(DomainEvent $event);
}