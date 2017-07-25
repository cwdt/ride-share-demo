<?php

namespace RideShare\Domain\Core\Entities;

use BadMethodCallException;
use RideShare\Domain\Core\Events\DomainEvent;
use RideShare\Domain\Core\Events\DomainEventPublisher;

abstract class AggregateRoot
{
    /** @var array */
    protected $apply;

    /** @var array */
    protected $recordedEvents = [];

    /**
     * @param DomainEvent $event
     */
    protected function recordApplyAndPublishThat(DomainEvent $event)
    {
        $this->recordThat($event);
        $this->applyThat($event);
        $this->publishThat($event);
    }

    /**
     * @param DomainEvent $event
     */
    protected function recordThat(DomainEvent $event)
    {
        $this->recordedEvents[] = $event;
    }

    /**
     * @param DomainEvent $event
     */
    protected function applyThat(DomainEvent $event)
    {
        if (! isset($this->apply[get_class($event)])) {
            throw new BadMethodCallException('Can\'t apply ' . get_class($event));
        }

        $modifier = $this->apply[get_class($event)];
        $this->$modifier($event);
    }

    /**
     * @param DomainEvent $event
     */
    protected function publishThat(DomainEvent $event)
    {
        DomainEventPublisher::getInstance()->publish($event);
    }

    /**
     * @return array
     */
    public function getRecordedEvents(): array
    {
        return $this->recordedEvents;
    }

    /**
     * @return void
     */
    public function clearEvents()
    {
        $this->recordedEvents = [];
    }
}