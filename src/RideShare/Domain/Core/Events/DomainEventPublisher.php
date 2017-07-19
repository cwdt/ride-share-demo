<?php

namespace RideShare\Domain\Core\Events;

class DomainEventPublisher
{
    /** @var DomainEventPublisher */
    protected static $instance;

    /**
     * @return DomainEventPublisher
     */
    public static function getInstance()
    {
        if (! self::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @param DomainEvent $event
     */
    public function publish(DomainEvent $event)
    {
        // TODO implement publish
    }
}