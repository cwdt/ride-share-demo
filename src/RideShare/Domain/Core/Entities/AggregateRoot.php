<?php

namespace RideShare\Domain\Core\Entities;

use RideShare\Domain\Core\Events\DomainEvent;
use RideShare\Domain\Core\Events\DomainEventPublisher;

abstract class AggregateRoot
{
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
        $modifier = 'apply' . substr(get_class($event), strrpos(get_class($event), '\\') + 1);

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