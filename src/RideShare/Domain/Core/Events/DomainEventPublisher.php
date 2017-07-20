<?php

namespace RideShare\Domain\Core\Events;

class DomainEventPublisher
{
    /** @var DomainEventPublisher */
    protected static $instance;

    /** @var DomainEventSubscriber[] */
    protected $subscribers = [];

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
     * @param DomainEventSubscriber $subscriber
     */
    public function subscribe(DomainEventSubscriber $subscriber)
    {
        $this->subscribers[] = $subscriber;
    }

    /**
     * @param DomainEvent $event
     */
    public function publish(DomainEvent $event)
    {
        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->isSubscribedTo($event)) {
                $subscriber->handle($event);
            }
        }
    }
}